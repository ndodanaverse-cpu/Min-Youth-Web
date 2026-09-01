<?php

namespace App\Http\Controllers;

use App\Support\RemoteImage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RemoteImageController extends Controller
{
    public function __invoke(Request $request, string $payload): Response
    {
        $url = $this->decryptPayload($payload);

        if ($url === null || ! RemoteImage::isRemote($url)) {
            abort(404);
        }

        $hash = RemoteImage::hash($url);
        $local = RemoteImage::publicPath($hash);

        if (! file_exists($local)) {
            $this->fetch($url, $local);
        }

        if (! file_exists($local)) {
            abort(404);
        }

        return response()
            ->file($local, [
                'Content-Type' => 'image/webp',
                'Cache-Control' => 'public, max-age='.config('portal.image_cache.ttl_seconds'),
                'X-Content-Type-Options' => 'nosniff',
            ]);
    }

    private function decryptPayload(string $payload): ?string
    {
        $decoded = str_replace(['-', '_'], ['+', '/'], $payload);

        try {
            $url = decrypt(base64_decode($decoded, true));
        } catch (\Throwable) {
            return null;
        }

        return is_string($url) ? $url : null;
    }

    private function fetch(string $url, string $localPath): void
    {
        try {
            $response = Http::timeout(config('portal.image_cache.timeout_seconds'))
                ->withOptions(['verify' => true])
                ->get($url);
        } catch (\Throwable $e) {
            Log::debug('[img] Upstream fetch failed.', ['url' => $url, 'error' => $e->getMessage()]);

            return;
        }

        if ($response->failed() || ! str_starts_with($response->header('Content-Type', ''), 'image/')) {
            return;
        }

        $body = $response->body();

        if (strlen($body) > config('portal.image_cache.max_bytes')) {
            return;
        }

        $image = @imagecreatefromstring($body);

        if ($image === false) {
            return;
        }

        if (! is_dir(dirname($localPath))) {
            mkdir(dirname($localPath), 0775, true);
        }

        $saved = @imagewebp($image, $localPath, 82);

        imagedestroy($image);

        if (! $saved) {
            @unlink($localPath);
        }
    }
}
