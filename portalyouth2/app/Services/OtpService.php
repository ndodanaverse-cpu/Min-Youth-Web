<?php

namespace App\Services;

use App\Enums\OtpChannel;
use App\Enums\OtpPurpose;
use App\Jobs\SendSms;
use App\Models\OtpCode;
use App\Models\User;
use App\Notifications\SendOtp;
use Illuminate\Support\Str;

/**
 * Issues and validates one-time passwords over email and SMS.
 *
 * Providers are pluggable: email goes through the Laravel notification system,
 * SMS through the App\Services\Sms SmsSender contract, so a real gateway can
 * be switched in without touching this class.
 */
class OtpService
{
    public function issue(User $user, OtpPurpose $purpose, ?OtpChannel $channel = null): OtpCode
    {
        $channel ??= $this->defaultChannel($user);

        $this->consumeOutstanding($user, $purpose, $channel);

        $code = $this->randomCode();

        $otp = OtpCode::create([
            'user_id' => $user->getKey(),
            'channel' => $channel->value,
            'purpose' => $purpose->value,
            'code_hash' => OtpCode::hashCode($code),
            'expires_at' => now()->addSeconds(config('otp.ttl')),
        ]);

        $this->deliver($user, $channel, $code, $purpose);

        return $otp;
    }

    public function verify(User $user, string $code, OtpPurpose $purpose, OtpChannel $channel): bool
    {
        $otp = $this->latestFor($user, $purpose, $channel);

        if ($otp === null || $otp->hasExpired()) {
            return false;
        }

        if ($otp->attempts >= config('otp.max_attempts')) {
            return false;
        }

        if (! $otp->verify(Str::upper(trim($code)))) {
            $otp->increment('attempts');

            return false;
        }

        $otp->update(['used_at' => now()]);

        return true;
    }

    public function canResend(User $user, OtpPurpose $purpose, OtpChannel $channel): bool
    {
        $otp = $this->latestFor($user, $purpose, $channel);

        return $otp === null
            || $otp->created_at->diffInSeconds(now()) >= config('otp.resend_cooldown');
    }

    public function latestFor(User $user, OtpPurpose $purpose, OtpChannel $channel): ?OtpCode
    {
        return OtpCode::query()
            ->where('user_id', $user->getKey())
            ->where('purpose', $purpose->value)
            ->where('channel', $channel->value)
            ->latest()
            ->first();
    }

    public function availableChannels(User $user): array
    {
        $channels = [];

        if (config('otp.channels.email') && filled($user->email)) {
            $channels[OtpChannel::Email->value] = $user->email;
        }

        if (config('otp.channels.sms') && filled($user->phone)) {
            $channels[OtpChannel::Sms->value] = $user->phone;
        }

        return $channels;
    }

    public function channelLabel(OtpChannel $channel): string
    {
        return $channel->label();
    }

    private function defaultChannel(User $user): OtpChannel
    {
        $default = OtpChannel::tryFrom(config('otp.default_channel')) ?? OtpChannel::Email;

        if ($default === OtpChannel::Sms && blank($user->phone)) {
            return OtpChannel::Email;
        }

        if ($default === OtpChannel::Email && blank($user->email)) {
            return OtpChannel::Sms;
        }

        return $default;
    }

    private function consumeOutstanding(User $user, OtpPurpose $purpose, OtpChannel $channel): void
    {
        OtpCode::query()
            ->where('user_id', $user->getKey())
            ->where('purpose', $purpose->value)
            ->where('channel', $channel->value)
            ->whereNull('used_at')
            ->update(['used_at' => now()]);
    }

    private function randomCode(): string
    {
        $digits = max(4, config('otp.digits', 6));

        return Str::upper(str_pad((string) random_int(0, 10 ** $digits - 1), $digits, '0', STR_PAD_LEFT));
    }

    private function deliver(User $user, OtpChannel $channel, string $code, OtpPurpose $purpose): void
    {
        if ($channel === OtpChannel::Email) {
            $user->notify(new SendOtp($code, $purpose, config('otp.ttl')));

            return;
        }

        $message = sprintf(
            'Your %s verification code is %s. It expires in %d minutes. Do not share it.',
            config('portal.name'),
            $code,
            (int) ceil(config('otp.ttl') / 60)
        );

        SendSms::dispatch($user->phone, $message);
    }
}
