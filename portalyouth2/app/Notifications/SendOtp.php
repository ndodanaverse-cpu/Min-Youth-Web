<?php

namespace App\Notifications;

use App\Enums\OtpPurpose;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendOtp extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $code,
        public OtpPurpose $purpose,
        public int $expiresInSeconds,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $minutes = (int) ceil($this->expiresInSeconds / 60);

        return (new MailMessage)
            ->subject('Your '.config('portal.name').' verification code')
            ->markdown('emails.otp', [
                'code' => $this->code,
                'purpose' => $this->purpose->label(),
                'minutes' => $minutes,
                'portalName' => config('portal.name'),
            ]);
    }
}
