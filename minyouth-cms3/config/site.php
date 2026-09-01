<?php
/**
 * Public site settings (not secrets).
 *
 * Production: set the environment variable MINYOUTH_PORTAL_URL to the live
 * youth portal, then keep assets/js/site-config.js in sync for static HTML.
 */
$fromEnv = getenv('MINYOUTH_PORTAL_URL');

return [
    'portal_url' => ($fromEnv !== false && $fromEnv !== '')
        ? $fromEnv
        : 'http://127.0.0.1:8000',
];
