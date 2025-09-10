<?php
// app/Jobs/SendJanjiTemuReminder.php
namespace App\Jobs;

use App\Models\DeviceToken;
use App\Models\JanjiTemu;
use App\Models\Slot;
use App\Services\ApnsService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendJanjiTemuReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** optional tuning */
    public int $tries = 3;
    public int $timeout = 30;
    // public string $queue = 'reminders'; // ← aktifkan ini HANYA jika worker kamu memproses queue 'reminders' (cron tambahkan --queue=reminders,default)

    public function __construct(
        public int $janjiTemuId,
        public string $expectedStartAtIso // UTC ISO saat job dijadwalkan
    ) {}

    public function handle(ApnsService $apns): void
    {
        Log::info('SendJanjiTemuReminder: START', [
            'jt_id' => $this->janjiTemuId,
            'expectedStartAtIso' => $this->expectedStartAtIso,
        ]);

        $jt = JanjiTemu::with(['pasien', 'slot', 'dokter'])->find($this->janjiTemuId);
        if (!$jt || !$jt->pasien) {
            Log::warning('JT not found / pasien missing', ['jt_id' => $this->janjiTemuId]);
            return;
        }

        $tz = config('app.timezone', 'Asia/Jakarta');
        $slot = $jt->slot ?? Slot::find($jt->slot_id);

        // GANTI jika kolom kamu beda
        $slotStart = $slot?->jam_mulai ?? $slot?->mulai ?? $slot?->start_time; // 'HH:mm'
        if (!$slotStart) {
            Log::warning('slotStart missing', ['jt_id' => $jt->id, 'slot_id' => $jt->slot_id]);
            return;
        }

        $startAtUtc   = Carbon::parse("{$jt->tanggal} {$slotStart}", $tz)->utc();
        $expectedUtc  = Carbon::parse($this->expectedStartAtIso);

        // Jika jadwal berubah sejak dijadwalkan, skip
        if (!$startAtUtc->equalTo($expectedUtc)) {
            Log::info('Schedule changed, skip reminder', [
                'jt_id' => $jt->id,
                'now_calc' => $startAtUtc->toIso8601String(),
                'expected' => $this->expectedStartAtIso,
            ]);
            return;
        }

        // Jika (karena alasan apapun) worker telat dan sudah lewat jamnya, skip
        if (now()->greaterThan($startAtUtc)) {
            Log::info('Reminder past due, skip', [
                'jt_id' => $jt->id,
                'start_at_utc' => $startAtUtc->toIso8601String(),
                'now_utc' => now()->utc()->toIso8601String(),
            ]);
            return;
        }

        $userId = $jt->pasien->user_id ?? null;
        if (!$userId) {
            Log::warning('user_id missing on pasien', ['jt_id' => $jt->id]);
            return;
        }

        $tokens = DeviceToken::where('user_id', $userId)->where('platform', 'ios')->pluck('token');
        if ($tokens->isEmpty()) {
            Log::info('No iOS tokens for user', ['user_id' => $userId, 'jt_id' => $jt->id]);
            return;
        }

        // Format waktu lokal untuk pesan
        $startLocal = $startAtUtc->copy()->timezone($tz)->locale('id');
        $jamTgl     = $startLocal->translatedFormat('d MMM Y, HH:mm');

        $title = 'Reminder Janji Temu';
        $body  = "Janji temu kamu mulai pada {$jamTgl}. Datang tepat waktu ya.";

        $allResults = [];
        foreach ($tokens as $t) {
            $res = $apns->sendAlert(
                deviceToken: $t,
                title: $title,
                body: $body,
                badge: 1,
                custom: [
                    'type'        => 'appointment_reminder',
                    'janji_temu'  => $jt->id,
                    'dokter_id'   => $jt->dokter_id,
                    // 'deeplink'  => 'cihos://home' // kalau nanti mau
                ],
            );
            $allResults[] = $res;
        }

        Log::info('SendJanjiTemuReminder: DONE', [
            'jt_id'   => $jt->id,
            'tokens'  => $tokens->count(),
            'results' => $allResults,
        ]);
    }
}
