<?php

namespace App\Jobs;

use App\Models\DeviceToken;
use App\Services\ApnsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendApnsAlert implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $deviceToken,
        public string $title,
        public ?string $body = null,
        public array $custom = [],  // agenda_id / deeplink, dll.
        public int $badge = 1
    ) {}

    public function handle(ApnsService $apns): void
    {
        $resp = $apns->sendAlert($this->deviceToken, $this->title, $this->body, $this->badge, $this->custom);
        $status = $resp[0]['status'] ?? null;

        // Bersihkan token invalid
        if (in_array($status, [400, 410])) {
            DeviceToken::where('token', $this->deviceToken)->delete();
        }
    }
}
