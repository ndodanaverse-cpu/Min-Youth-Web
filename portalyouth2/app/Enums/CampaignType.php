<?php

namespace App\Enums;

enum CampaignType: string
{
    case DrugSubstanceAbuse = 'drug_substance_abuse';
    case MentalHealth = 'mental_health';
    case Environmental = 'environmental_conservation';
    case RoadSafety = 'road_safety';
    case DigitalLiteracy = 'digital_literacy';
    case GenderEquality = 'gender_equality';
    case HealthAwareness = 'health_awareness';
    case YouthLeadership = 'youth_leadership';

    public function label(): string
    {
        return match ($this) {
            self::DrugSubstanceAbuse => 'Drug & Substance Abuse Prevention',
            self::MentalHealth => 'Mental Health Awareness',
            self::Environmental => 'Environmental Conservation',
            self::RoadSafety => 'Road Safety',
            self::DigitalLiteracy => 'Digital Literacy & Online Safety',
            self::GenderEquality => 'Gender Equality',
            self::HealthAwareness => 'Health Awareness',
            self::YouthLeadership => 'Youth Leadership',
        };
    }
}
