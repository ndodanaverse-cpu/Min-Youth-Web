<?php

namespace App\Enums;

enum OtpPurpose: string
{
    case Registration = 'registration';
    case Login = 'login';
    case PhoneVerification = 'phone_verification';
    case PasswordReset = 'password_reset';

    public function label(): string
    {
        return match ($this) {
            self::Registration => 'Account activation',
            self::Login => 'Sign in',
            self::PhoneVerification => 'Phone number verification',
            self::PasswordReset => 'Password reset',
        };
    }
}
