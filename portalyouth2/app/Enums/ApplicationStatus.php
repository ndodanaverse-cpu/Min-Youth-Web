<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case Draft = 'draft';
    case Submitted = 'submitted';
    case UnderReview = 'under_review';
    case Shortlisted = 'shortlisted';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Withdrawn = 'withdrawn';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Submitted => 'Submitted',
            self::UnderReview => 'Under Review',
            self::Shortlisted => 'Shortlisted',
            self::Accepted => 'Accepted',
            self::Rejected => 'Not Successful',
            self::Withdrawn => 'Withdrawn',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Submitted, self::UnderReview => 'info',
            self::Shortlisted => 'warning',
            self::Accepted => 'success',
            self::Rejected, self::Withdrawn => 'danger',
        };
    }
}
