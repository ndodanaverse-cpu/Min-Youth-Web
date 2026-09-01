<?php

namespace App\Enums;

enum OpportunityCategory: string
{
    case Funding = 'funding';
    case Employment = 'employment';
    case Training = 'training';
    case Incubation = 'incubation';
    case Competition = 'competition';
    case Internship = 'internship';
    case Mentorship = 'mentorship';
    case Volunteer = 'volunteer';

    public function label(): string
    {
        return match ($this) {
            self::Funding => 'Funding & Grants',
            self::Employment => 'Employment',
            self::Training => 'Training & Skills',
            self::Incubation => 'Business Incubation',
            self::Competition => 'Competitions & Awards',
            self::Internship => 'Internships & Traineeships',
            self::Mentorship => 'Mentorship',
            self::Volunteer => 'Volunteering',
        };
    }
}
