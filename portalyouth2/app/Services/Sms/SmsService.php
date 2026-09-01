<?php

namespace App\Services\Sms;

use App\Services\Sms\Contracts\SmsSender;

class SmsService
{
    public function __construct(private readonly SmsSender $sender)
    {
    }

    public function send(string $to, string $message): void
    {
        $this->sender->send($to, $message);
    }
}
