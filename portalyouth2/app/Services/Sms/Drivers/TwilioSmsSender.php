<?php

namespace App\Services\Sms\Drivers;

use App\Services\Sms\Contracts\SmsSender;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Twilio SMS provider.
 *
 * Implemented against the Twilio REST API without requiring the SDK so the
 * portal stays lightweight. Add additional providers (Africastalking, WhatsApp
 * Business API, etc.) by implementing SmsSender and registering the driver in
 * the service container — no other code needs to change.
 */
class TwilioSmsSender implements SmsSender
{
    public function send(string $to, string $message): void
    {
        $sid = config('sms.drivers.twilio.sid');
        $token = config('sms.drivers.twilio.token');

        if (blank($sid) || blank($token)) {
            Log::warning('[SMS] Twilio credentials are not configured; message not sent.', compact('to'));

            return;
        }

        $from = config('sms.drivers.twilio.from');

        try {
            Http::withBasicAuth($sid, $token)
                ->asForm()
                ->acceptJson()
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                    'To' => $to,
                    'From' => $from,
                    'Body' => $message,
                ])
                ->throw();
        } catch (ConnectionException $e) {
            Log::warning('[SMS] Twilio request failed.', [
                'to' => $to,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
