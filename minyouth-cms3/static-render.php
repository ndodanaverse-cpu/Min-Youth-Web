<?php
/** Render one public PHP page for static-export.php. */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('This renderer can only be run from the command line.');
}

$source = $argv[1] ?? '';
$get = json_decode(base64_decode($argv[2] ?? '', true) ?: '{}', true);
$allowed = ['index.php', 'about.php', 'contact.php', 'departments.php', 'gallery.php', 'news.php', 'resources.php', 'article.php'];

if (!in_array($source, $allowed, true) || !is_array($get)) {
    fwrite(STDERR, "Invalid static page request.\n");
    exit(1);
}

$_GET = $get + ['lang' => 'en'];
$_SERVER['REQUEST_URI'] = '/' . $source . (isset($_GET['lang']) ? '?lang=' . $_GET['lang'] : '');
$_SERVER['HTTP_HOST'] = 'localhost';
require __DIR__ . '/' . $source;
