<?php

namespace App\Enums;

enum ProgrammeCategory: string
{
    case Entrepreneurship = 'entrepreneurship';
    case Agriculture = 'agriculture';
    case Ict = 'ict';
    case Innovation = 'innovation';
    case ClimateAction = 'climate_action';
    case Sports = 'sports';
    case Volunteerism = 'volunteerism';
    case VocationalTraining = 'vocational_training';
    case WomenEmpowerment = 'women_empowerment';
    case YouthFunding = 'youth_funding';

    public function label(): string
    {
        return match ($this) {
            self::Entrepreneurship => 'Entrepreneurship',
            self::Agriculture => 'Agriculture & Agro-processing',
            self::Ict => 'ICT & Digital Skills',
            self::Innovation => 'Innovation & Technology',
            self::ClimateAction => 'Climate Action',
            self::Sports => 'Sports Development',
            self::Volunteerism => 'Volunteerism & Civic Service',
            self::VocationalTraining => 'Vocational Training',
            self::WomenEmpowerment => 'Women Empowerment',
            self::YouthFunding => 'Youth Funding & Finance',
        };
    }
}
