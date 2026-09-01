<?php

namespace App\Enums;

enum ActivityType: string
{
    case Event = 'event';
    case Provincial = 'provincial';
    case National = 'national';
    case InnovationChallenge = 'innovation_challenge';
    case CommunityOutreach = 'community_outreach';
    case YouthForum = 'youth_forum';
    case Sports = 'sports';
    case Training = 'training';
    case Webinar = 'webinar';

    public function label(): string
    {
        return match ($this) {
            self::Event => 'Upcoming Event',
            self::Provincial => 'Provincial Activity',
            self::National => 'National Event',
            self::InnovationChallenge => 'Innovation Challenge',
            self::CommunityOutreach => 'Community Outreach',
            self::YouthForum => 'Youth Forum',
            self::Sports => 'Sports Activity',
            self::Training => 'Training Workshop',
            self::Webinar => 'Online Webinar',
        };
    }
}
