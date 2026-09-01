<?php

require_once __DIR__ . '/../config/google_translate.php';

/**
 * Translate a batch of plain-text values with Google Cloud Translation v2.
 *
 * @param array<int, string> $values
 * @return array<int, string>
 */
function google_translate(array $values, string $targetLanguage): array
{
    if (GOOGLE_TRANSLATE_API_KEY === '') {
        throw new RuntimeException('Google Translate is not configured. Set GOOGLE_TRANSLATE_API_KEY on the server.');
    }

    if (!$values) {
        return [];
    }

    $payload = json_encode([
        'q' => array_values($values),
        'target' => $targetLanguage,
        'format' => 'text',
    ], JSON_THROW_ON_ERROR);

    $ch = curl_init('https://translation.googleapis.com/language/translate/v2?key=' . rawurlencode(GOOGLE_TRANSLATE_API_KEY));
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => $payload,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 30,
    ]);

    $response = curl_exec($ch);
    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($response === false || $error !== '') {
        throw new RuntimeException('Google Translate request failed.');
    }

    $decoded = json_decode($response, true);
    $translations = $decoded['data']['translations'] ?? null;
    if ($status < 200 || $status >= 300 || !is_array($translations) || count($translations) !== count($values)) {
        throw new RuntimeException('Google Translate returned an invalid response.');
    }

    return array_map(static fn(array $translation): string => (string)($translation['translatedText'] ?? ''), $translations);
}