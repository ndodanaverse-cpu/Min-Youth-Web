<?php

namespace App\Services\Translation;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class NllbTranslator
{
    public function translate(string $value, string $locale): string
    {
        if ($value === '' || $locale === 'en' || !in_array($locale, config('portal.nllb_locales', []), true)) {
            return $value;
        }

        return Cache::remember(
            'nllb:' . $locale . ':' . sha1($value),
            now()->addDays(30),
            fn () => $this->request([$value], $locale)[0] ?? $value,
        );
    }

    public function translateModels(iterable $models, array $fields, string $locale): void
    {
        if ($locale === 'en' || !in_array($locale, config('portal.nllb_locales', []), true)) {
            return;
        }

        foreach ($models as $model) {
            foreach ($fields as $field) {
                if (!empty($model->{$field})) {
                    $model->{$field} = $this->translate($model->{$field}, $locale);
                }
            }
        }
    }

    private function request(array $values, string $locale): array
    {
        try {
            $response = Http::timeout((int) config('portal.nllb_timeout', 120))
                ->post(config('portal.nllb_url'), ['values' => $values, 'target' => $locale]);

            return $response->successful() ? (array) $response->json('translations', []) : $values;
        } catch (\Throwable) {
            return $values;
        }
    }
}