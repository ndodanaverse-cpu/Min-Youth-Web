<?php

require_once __DIR__ . '/../config/translation.php';

function translate_values(array $values, string $targetLanguage): array
{
    if (!$values) return [];

    if ($targetLanguage === 'sn') {
        return array_map(static function ($value): string {
            $value = (string)$value;
            $translations = hardcoded_shona_translations();
            return $translations[$value] ?? $value;
        }, $values);
    }

    $translations = [];
    foreach ($values as $value) {
        $payload = json_encode([
            'text' => (string)$value,
            'to' => $targetLanguage,
        ], JSON_THROW_ON_ERROR);
        $ch = curl_init(FREE_TRANSLATE_API_URL);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 120,
        ]);
        $response = curl_exec($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        $decoded = is_string($response) ? json_decode($response, true) : null;
        if ($status < 200 || $status >= 300 || !is_array($decoded) || ($decoded['status'] ?? false) !== true) {
            $message = $curlError ?: (is_array($decoded) && isset($decoded['message'])
                ? (string)$decoded['message']
                : 'The free translation service is unavailable.');
            throw new RuntimeException($message);
        }

        $translations[] = (string)($decoded['translatedText'] ?? '');
    }

    return $translations;
}

function hardcoded_shona_translations(): array
{
    return [
        'Youth Empowerment & Development' => 'Kusimudzirwa neBudiriro yeVechidiki',
        'Empowering the youth through leadership programs and developmental initiatives across the nation.' => 'Kusimudzira vechidiki kuburikidza nezvirongwa zvehutungamiri uye zvirongwa zvebudiriro munyika yose.',
        'Youth Service in Zimbabwe' => 'Basa reVechidiki muZimbabwe',
        'Cultivating a sense of national service, discipline, and patriotic values among the younger generation.' => 'Kukudziridza pfungwa yebasa renyika, kuranga, uye tsika dzekuda nyika pakati pechizvarwa chevechidiki.',
        'Vocational Training Centers' => 'Nzvimbo dzeKudzidziswa Mabasa',
        'Providing industry-standard technical skills and certifications to bridge the youth employment gap.' => 'Kupa hunyanzvi hwehunyanzvi nezvitupa zvinoenderana nemwero wemaindasitiri kuti kuderedzwe kushaikwa kwemabasa pakati pevechidiki.',
        'Business Development' => 'Kusimudzirwa kweMabhizimusi',
        'Supporting youth-led startups and SMEs with strategic resources, financing, and business training.' => 'Kutsigira mabhizimusi matsva anotungamirirwa nevechidiki nemabhizimusi madiki nepakati kuburikidza nezviwanikwa, mari, uye kudzidziswa kwemabhizimusi.',
        'Procurement Management' => 'Kutarisira Kutengwa kwezvinhu',
        'Supply chain & acquisition services.' => 'Mabasa ekutengesa nekutenga zvinhu.',
        'Communication and Advocacy' => 'Kukurukurirana neKumiririra',
        'Public relations & media engagement.' => 'Hukama neveruzhinji nekudyidzana nenhau.',
        'Internal Audit' => 'Ongororo Yemukati',
        'Financial oversight & compliance.' => 'Kuongorora zvemari nekutevedza mitemo.',
        'Human Resources' => 'Vashandi',
        'Staff development & welfare.' => 'Budiriro nekuchengetedzwa kwevashandi.',
        'Legal Services' => 'Mabasa eMutemo',
        'Legal advisory & legislative compliance.' => 'Mazano emutemo nekutevedza mitemo.',
        'Finance and Administration' => 'Zvemari neKutonga',
        'Budgeting & financial planning.' => 'Kuronga bhajeti nezvemari.',
        'Gender Mainstreaming & Wellness' => 'Kuenzana kweVanhukadzi neUtano',
        'Inclusion & mental health support.' => 'Kubatanidzwa uye rutsigiro rweutano hwepfungwa.',
        'Strategic Policy & Evaluation' => 'Mitemo yeChirongwa neKuongorora',
        'Monitoring & future planning.' => 'Kutevera mafambiro nekuronga ramangwana.',
        'National Vocational Training Graduation Ceremony in Harare' => 'Mhemberero Yekupedza Kudzidziswa Mabasa muHarare',
        'Over 5,000 students graduated from various technical programs this week, marking a major milestone for the empowerment initiative.' => 'Vadzidzi vanopfuura 5 000 vakapedza zvirongwa zvakasiyana zvehunyanzvi svondo rino, zvichiratidza budiriro huru muchirongwa chekusimudzira vechidiki.',
        'Digital Innovation Hub Partnership Announced with Global Tech Firms' => 'Kudyidzana kweDigital Innovation Hub neMakambani eTekinoroji Kwaratidzwa',
        'The Ministry has signed a landmark MOU to establish three new innovation hubs focused on AI and sustainable software engineering.' => 'Bazi rakasaina chibvumirano chekuvamba nzvimbo nhatu itsva dzehutsva dzakanangana neAI nekuvaka software inochengetedza nharaunda.',
        'Strategic Land Allocation for Youth-led Agribusiness Projects' => 'Kugoverwa kweMinda kuMabhizimusi eVechidiki',
        'New land titles have been issued to 50 youth cooperatives specializing in organic export produce under the National Growth Plan.' => 'Mapepa matsva eminda akapihwa kumacooperative makumi mashanu evechidiki ari kuita zvirimwa zveorganic zvinotengeswa kunze kwenyika pasi peChirongwa cheKukura kweNyika.',
    ];
}