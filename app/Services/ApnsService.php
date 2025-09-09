<?php
// app/Services/ApnsService.php
namespace App\Services;

use Pushok\AuthProvider\Token as ApnsTokenAuth;
use Pushok\Client as ApnsClient;
use Pushok\Notification as ApnsNotification;
use Pushok\Payload as ApnsPayload;
use Pushok\Payload\Alert as ApnsAlert;

class ApnsService
{
    protected function client(): ApnsClient
    {
        $auth = ApnsTokenAuth::create([
            'key_id'           => env('APNS_KEY_ID'),
            'team_id'          => env('APNS_TEAM_ID'),
            'app_bundle_id'    => env('APNS_BUNDLE_ID'),
            'private_key_path' => base_path(env('APNS_AUTH_KEY_PATH')),
            'private_key_secret' => null,
        ]);
        $isProduction = env('APNS_ENV') === 'production';
        return new ApnsClient($auth, $isProduction);
    }

    /** Notifikasi “biasa” → banner/lockscreen */
    public function sendAlert(string $deviceToken, string $title, ?string $body = null, int $badge = 1, array $custom = []): array
    {
        $alert = ApnsAlert::create()->setTitle($title);
        if ($body !== null) $alert->setBody($body);

        $payload = ApnsPayload::create()
            ->setAlert($alert)
            ->setSound('default')
            ->setBadge($badge);

        // data custom di luar aps
        foreach ($custom as $k => $v) { $payload->setCustomValue($k, $v); }

        $notification = new ApnsNotification($payload, $deviceToken);

        $client = $this->client();
        $client->addNotification($notification);

        $responses = $client->push(); // kirim (HTTP/2)
        return $this->formatResponses($responses, $deviceToken);
    }

    /** Silent push (background) → tidak tampil banner */
    public function sendSilent(string $deviceToken, array $custom = []): array
    {
        $payload = ApnsPayload::create()->setContentAvailability(true); // aps.content-available = 1
        foreach ($custom as $k => $v) { $payload->setCustomValue($k, $v); }

        $notification = new ApnsNotification($payload, $deviceToken);
        $client = $this->client();
        $client->addNotification($notification);

        $responses = $client->push();
        return $this->formatResponses($responses, $deviceToken);
    }

    /** Rich media (pakai Notification Service Extension di iOS) */
    public function sendRich(string $deviceToken, string $title, string $body, string $imageUrl, array $custom = []): array
    {
        $payload = ApnsPayload::create()
            ->setAlert(ApnsAlert::create()->setTitle($title)->setBody($body))
            ->setMutableContent(1) // trigger service extension
            ->setSound('default')
            ->setBadge(1);

        $payload->setCustomValue('image_url', $imageUrl);
        foreach ($custom as $k => $v) { $payload->setCustomValue($k, $v); }

        $notification = new ApnsNotification($payload, $deviceToken);
        $client = $this->client();
        $client->addNotification($notification);

        $responses = $client->push();
        return $this->formatResponses($responses, $deviceToken);
    }

    /** Helper respons */
    private function formatResponses(iterable $responses, string $token): array
    {
        $out = [];
        foreach ($responses as $r) {
            $out[] = [
                'success' => $r->isSuccess(),
                'status'  => $r->getStatusCode(),
                'reason'  => $r->getErrorReason(),
                'desc'    => $r->getErrorDescription(),
                'apns_id' => $r->getApnsId(),
                'token'   => $token,
            ];
        }
        return $out;
    }
}
