<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Reads and writes CMS-managed settings through the database with a cache in
 * front so the public site never hits the table on every request.
 */
class SettingsService
{
    private const CACHE_KEY = 'portal.settings.all';

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->all()->get($key, $default);
    }

    public function set(string $key, mixed $value, string $group = 'general', bool $isPublic = true): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $this->encode($value),
                'group' => $group,
                'is_public' => $isPublic,
            ]
        );

        $this->forgetCache();
    }

    public function setMany(array $values, string $group = 'general'): void
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $group);
        }
    }

    /**
     * @return \Illuminate\Support\Collection<string, mixed>
     */
    public function all(): \Illuminate\Support\Collection
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return Setting::query()
                ->pluck('value', 'key')
                ->map(fn (?string $value) => $this->decode($value));
        });
    }

    public function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    private function encode(mixed $value): ?string
    {
        if (is_array($value) || is_object($value)) {
            return json_encode($value, JSON_UNESCAPED_SLASHES);
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        return is_null($value) ? null : (string) $value;
    }

    private function decode(?string $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if ($value === '1' || $value === '0') {
            return $value === '1';
        }

        $decoded = json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
    }
}
