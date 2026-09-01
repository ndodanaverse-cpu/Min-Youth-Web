<?php

use App\Services\SettingsService;
use App\Support\RemoteImage;

if (! function_exists('base64url_encode')) {
    function base64url_encode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}

if (! function_exists('base64url_decode')) {
    function base64url_decode(string $value): string|false
    {
        return base64_decode(strtr($value, '-_', '+/'), true);
    }
}

if (! function_exists('setting')) {
    /**
     * Read a CMS-managed setting.
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return app(SettingsService::class)->get($key, $default);
    }
}

if (! function_exists('remote_image')) {
    /**
     * Resolve a remote image URL through the local caching proxy.
     */
    function remote_image(?string $url): ?string
    {
        return RemoteImage::url($url);
    }
}
