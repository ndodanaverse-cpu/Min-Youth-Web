<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Serves official ministry imagery (hotlinked remote URLs) through a local
 * caching proxy so the public site never depends on a slow or unreachable
 * upstream at render time.
 */
class RemoteImage
{
    public static function url(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        if (! config('portal.image_cache.enabled')) {
            return $url;
        }

        $hash = self::hash($url);

        if (file_exists(self::publicPath($hash))) {
            return self::publicUrl($hash);
        }

        $payload = base64url_encode(encrypt($url));

        return route('img.proxy', ['payload' => $payload]);
    }

    public static function hash(string $url): string
    {
        return substr(hash('sha256', $url), 0, 32);
    }

    public static function publicPath(string $hash): string
    {
        return storage_path("app/public/img/{$hash}.webp");
    }

    public static function publicUrl(string $hash): string
    {
        return asset("storage/img/{$hash}.webp");
    }

    public static function isRemote(string $url): bool
    {
        return Str::startsWith($url, ['https://', 'http://']);
    }

    /**
     * Inline SVG placeholder used as a graceful fallback for missing imagery.
     */
    public static function placeholderDataUri(string $label = 'Zimbabwe Youth'): string
    {
        $svg = <<<SVG
        <svg xmlns="http://www.w3.org/2000/svg" width="640" height="400" viewBox="0 0 640 400">
          <defs>
            <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
              <stop offset="0" stop-color="#144231"/>
              <stop offset="1" stop-color="#227e56"/>
            </linearGradient>
          </defs>
          <rect width="640" height="400" fill="url(#g)"/>
          <circle cx="320" cy="180" r="90" fill="none" stroke="#f6b711" stroke-width="6"/>
          <path d="M320 120 360 240 320 215 280 240 Z" fill="#f6b711"/>
          <text x="320" y="330" font-family="Arial, sans-serif" font-size="22" fill="#ffffff" text-anchor="middle" opacity="0.85">%s</text>
        </svg>
        SVG;

        return 'data:image/svg+xml;base64,'.base64_encode(sprintf($svg, htmlspecialchars($label)));
    }
}
