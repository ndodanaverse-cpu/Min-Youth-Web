<?php

namespace App\Enums;

enum Gender: string
{
    case Male = 'male';
    case Female = 'female';
    case NonBinary = 'non_binary';
    case PreferNotToSay = 'prefer_not_to_say';

    public function label(): string
    {
        return match ($this) {
            self::Male => 'Male',
            self::Female => 'Female',
            self::NonBinary => 'Non-binary',
            self::PreferNotToSay => 'Prefer not to say',
        };
    }
}
