<?php

namespace App\Services\Sms\Drivers;

use App\Services\Sms\Contracts\SmsSender;
use Illuminate\Support\Facades\Log;

class LogSmsSender implements SmsSender
{
    public function send(string $to, string $message): void
    {
        Log::channel(config('sms.drivers.log.channel'))->info(
            sprintf('[SMS] To: %s | From: %s | %s', $to, config('sms.from'), $message)
        );
    }
}
