<?php
/**
 * Shared public-site helpers. Safe to include from i18n.php or lang.php.
 */

if (!function_exists('portal_url')) {
    function portal_url(): string
    {
        static $url = null;
        if ($url === null) {
            $cfg = require __DIR__ . '/../config/site.php';
            $url = (string) ($cfg['portal_url'] ?? 'http://127.0.0.1:8000');
        }
        return $url;
    }
}

if (!function_exists('portal_url_attr')) {
    function portal_url_attr(): string
    {
        return htmlspecialchars(portal_url(), ENT_QUOTES, 'UTF-8');
    }
}
