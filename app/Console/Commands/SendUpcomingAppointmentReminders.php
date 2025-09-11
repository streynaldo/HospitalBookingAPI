<?php

namespace App\Console\Commands;

use App\Models\JanjiTemu;
use App\Models\DeviceToken;
use App\Services\ApnsService;
use App\Models\Slot;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendUpcomingAppointmentReminders extends Command
{
    protected $signature = 'reminders:send-upcoming {--lead=60} {--window=2}';
    protected $description = 'Kirim push 60 menit (default) sebelum janji temu, setiap menit.';

    public function handle(): int
    {
        $tz      = config('app.timezone', 'Asia/Jakarta');
        $lead    = (int) $this->option('lead');     // menit sebelum mulai (default 60)
        $window  = (int) $this->option('window');   // lebar jendela (menit) untuk toleransi (default 2 menit)
        $from    = now($tz)->addMinutes($lead);
        $to      = now($tz)->addMinutes($lead + $window);

        $apns = app(ApnsService::class);

        Log::info('REM SCHED: scan', [
            'lead' => $lead, 'window' => $window,
            'from' => $from->toDateTimeString(), 'to' => $to->toDateTimeString()
        ]);

        // ambil janji yang belum dikirim
        JanjiTemu::with(['pasien','slot','dokter'])
            ->whereNull('reminder_sent_at')
            // batasi tanggal biar query ringan
            ->whereBetween('tanggal', [$from->toDateString(), $to->copy()->addDay()->toDateString()])
            ->chunkById(200, function ($rows) use ($tz, $from, $to, $apns) {
                foreach ($rows as $jt) {
                    $slot = $jt->slot ?? Slot::find($jt->slot_id);
                    $slotStart = $slot?->slot_mulai ?? $slot?->jam_mulai ?? $slot?->mulai ?? $slot?->start_time; // 'HH:mm'
                    if (!$slotStart || !$jt->pasien?->user_id) {
                        continue;
                    }

                    $startLocal = Carbon::parse("{$jt->tanggal} {$slotStart}", $tz);

                    // kirim hanya kalau startLocal berada dalam jendela [from, to]
                    if ($startLocal->lessThan($from) || $startLocal->greaterThan($to)) {
                        continue;
                    }

                    $tokens = DeviceToken::where('user_id', $jt->pasien->user_id)
                        ->where('platform', 'ios')
                        ->pluck('token');

                    if ($tokens->isEmpty()) {
                        // tetap tandai supaya tidak discan berulang
                        $jt->forceFill(['reminder_sent_at' => now()])->save();
                        continue;
                    }

                    $jamTgl = $startLocal->locale('id')->translatedFormat('d M Y, H:i');
                    $title  = "Janji Temu {$jamTgl}";
                    $body   = "Dengan {$jt->dokter->nama}. Harap hadir 15 menit sebelum waktu untuk registrasi ulang.";

                    $results = [];
                    foreach ($tokens as $t) {
                        $results[] = $apns->sendAlert(
                            deviceToken: $t,
                            title: $title,
                            body:  $body,
                            badge: 1,
                            custom: [
                                'type'        => 'appointment_reminder',
                                'janji_temu'  => $jt->id,
                                'dokter_id'   => $jt->dokter_id,
                                // 'deeplink' => 'cihos://home'
                            ],
                        );
                    }

                    Log::info('REM SCHED: pushed', [
                        'jt_id'  => $jt->id,
                        'tokens' => $tokens->count(),
                        'start'  => $startLocal->toDateTimeString(),
                        'results'=> $results,
                    ]);

                    // tandai sudah dikirim (idempotent)
                    $jt->forceFill(['reminder_sent_at' => now()])->save();
                }
            });

        return self::SUCCESS;
    }
}