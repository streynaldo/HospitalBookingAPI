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

class SendJanjiTemuReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $janjiTemuId,
        public string $expectedStartAtIso // waktu mulai yang diharapkan (UTC/ISO) saat dijadwalkan
    ) {}

    public function handle(ApnsService $apns): void
    {
        $jt = JanjiTemu::with(['pasien', 'slot', 'dokter'])->find($this->janjiTemuId);
        if (!$jt || !$jt->pasien) return;

        // Hitung ulang startAt berdasar data TERKINI. Jika berubah, skip.
        $tz = config('app.timezone', 'Asia/Jakarta');
        $slot = $jt->slot ?? Slot::find($jt->slot_id);

        // GANTI nama kolom ini kalau beda:
        $slotStart = $slot?->jam_mulai ?? $slot?->mulai ?? $slot?->start_time; // 'HH:mm'
        if (!$slotStart) return; // tak bisa hitung → skip aman

        $startAt = Carbon::parse("{$jt->tanggal} {$slotStart}", $tz)->utc();
        if ($startAt->toIso8601String() !== $this->expectedStartAtIso) {
            // Jadwal sudah berubah sejak job dijadwalkan → jangan kirim.
            return;
        }

        $userId = $jt->pasien->user_id ?? null;
        if (!$userId) return;

        $tokens = DeviceToken::where('user_id', $userId)->where('platform', 'ios')->pluck('token');
        if ($tokens->isEmpty()) return;

        // Compose title/body
        $startLocal = $startAt->copy()->timezone($tz);
        $jamTgl = $startLocal->translatedFormat('d M Y, H:i');

        $title = 'Reminder Janji Temu';
        $body  = "Janji temu kamu mulai jam {$jamTgl}. Datang tepat waktu ya.";

        foreach ($tokens as $t) {
            $apns->sendAlert(
                deviceToken: $t,
                title: $title,
                body:  $body,
                badge: 1,
                custom: [
                    'type'        => 'appointment_reminder',
                    'janji_temu'  => $jt->id,
                    'dokter_id'   => $jt->dokter_id,
                ],
            );
        }
    }
}
