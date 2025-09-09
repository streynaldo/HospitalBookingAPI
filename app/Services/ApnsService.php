<?php
// app/Services/ApnsService.php
namespace App\Services;

use Pushok\AuthProvider\Token as ApnsTokenAuth;
use Pushok\Client as ApnsClient;
use Pushok\Notification as ApnsNotification;
use Pushok\Payload as ApnsPayload;
use Pushok\Payload\Alert as ApnsAlert;
use App\Models\DeviceToken;


class ApnsService
{
    protected function client(): ApnsClient
    {
        $auth = ApnsTokenAuth::create([
            'key_id'             => env('APNS_KEY_ID'),
            'team_id'            => env('APNS_TEAM_ID'),
            'app_bundle_id'      => env('APNS_BUNDLE_ID'),
            'private_key_path'   => base_path(env('APNS_AUTH_KEY_PATH')),
            'private_key_secret' => null,
        ]);
        $isProduction = env('APNS_ENV') === 'production';
        return new ApnsClient($auth, $isProduction);
    }

    /** Notifikasi biasa (banner/lockscreen) */
    public function sendAlert(string $deviceToken, string $title, ?string $body = null, int $badge = 1, array $custom = []): array
    {
        $alert = ApnsAlert::create()->setTitle($title);
        if ($body !== null) $alert->setBody($body);

        $payload = ApnsPayload::create()
            ->setAlert($alert)
            ->setSound('default')
            ->setBadge($badge);

        foreach ($custom as $k => $v) {
            $payload->setCustomValue($k, $v);
        }

        $notification = new ApnsNotification($payload, $deviceToken);
        // push-type akan ditentukan otomatis oleh Pushok (berdasarkan payload)
        $notification->setHighPriority(); // default untuk alert

        $client = $this->client();
        $client->addNotification($notification);

        $responses = $client->push();
        $out = $this->formatResponses($responses, $deviceToken);

        $this->removeInvalidTokens($out);   // ⬅️ tambahkan baris ini
        return $out;
    }

    /** Silent push (background) — tidak tampil banner */
    public function sendSilent(string $deviceToken, array $custom = []): array
    {
        $payload = ApnsPayload::create()
            ->setContentAvailability(true); // aps.content-available = 1 (tanpa alert)

        foreach ($custom as $k => $v) {
            $payload->setCustomValue($k, $v);
        }

        $notification = new ApnsNotification($payload, $deviceToken);
        // Tanpa alert + content-available → Pushok set push-type=background
        $notification->setHighPriority(); // rekomendasi APNs untuk background

        $client = $this->client();
        $client->addNotification($notification);

        $responses = $client->push();
        $out = $this->formatResponses($responses, $deviceToken);

        $this->removeInvalidTokens($out);   // ⬅️
        return $out;
    }

    /** Rich media (perlu Notification Service Extension di iOS) */
    public function sendRich(string $deviceToken, string $title, string $body, string $imageUrl, array $custom = []): array
    {
        $payload = ApnsPayload::create()
            ->setAlert(ApnsAlert::create()->setTitle($title)->setBody($body))
            ->setMutableContent(1) // trigger service extension
            ->setSound('default')
            ->setBadge(1);

        $payload->setCustomValue('image_url', $imageUrl);
        foreach ($custom as $k => $v) {
            $payload->setCustomValue($k, $v);
        }

        $notification = new ApnsNotification($payload, $deviceToken);
        $notification->setHighPriority(); // alert

        $client = $this->client();
        $client->addNotification($notification);

        $responses = $client->push();
        $out = $this->formatResponses($responses, $deviceToken);

        $this->removeInvalidTokens($out);   // ⬅️
        return $out;
    }

    private function formatResponses(iterable $responses, string $token): array
    {
        $out = [];
        foreach ($responses as $r) {
            $status = $r->getStatusCode();                 // 200, 400, 410, ...
            $ok     = ($status >= 200 && $status < 300);   // sukses 2xx

            $out[] = [
                'success'   => $ok,
                'status'    => $status,
                'apns_id'   => $r->getApnsId(),
                'token'     => $token,
                'reason'    => $r->getErrorReason() ?? $r->getReasonPhrase(),
                'desc'      => $r->getErrorDescription(),
                'timestamp' => $r->get410Timestamp() ? date('c', $r->get410Timestamp()) : null,
            ];
        }
        return $out;
    }

    /**
     * Hapus token yang invalid berdasarkan respons APNs.
     * Kriteria: status 400/410 atau reason mengandung baddevicetoken/unregistered/devicetokennotfortopic.
     */
    private function removeInvalidTokens(array $results): void
    {
        foreach ($results as $r) {
            $status = (int)($r['status'] ?? 0);
            $reason = strtolower((string)($r['reason'] ?? ''));
            $token  = $r['token'] ?? null;

            $isInvalid =
                in_array($status, [400, 410], true) ||
                str_contains($reason, 'baddevicetoken') ||
                str_contains($reason, 'unregistered') ||
                str_contains($reason, 'devicetokennotfortopic');

            if ($isInvalid && $token) {
                DeviceToken::where('token', $token)->delete();
            }
        }
    }
}
