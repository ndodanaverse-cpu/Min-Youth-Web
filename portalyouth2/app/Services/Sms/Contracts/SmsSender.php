<?php

namespace App\Services\Sms\Contracts;

interface SmsSender
{
    /**
     * Send a text message to a recipient.
     */
    public function send(string $to, string $message): void;
}
