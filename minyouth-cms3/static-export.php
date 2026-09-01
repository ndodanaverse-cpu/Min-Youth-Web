<?php
/**
 * Render the PHP public site into static HTML files.
 * Run from the project directory: php static-export.php
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('This exporter can only be run from the command line.');
}

require_once __DIR__ . '/config/database.php';

$publicPages = [
    'index.php'       => 'index.html',
    'about.php'       => 'about.html',
    'contact.php'     => 'contact.html',
    'departments.php' => 'departments.html',
    'gallery.php'    => 'gallery.html',
    'news.php'        => 'news.html',
    'resources.php'   => 'resources.html',
];

function render_static_page(string $file, array $get = []): string
{
    $renderer = __DIR__ . '/static-render.php';
    $command = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($renderer) . ' '
        . escapeshellarg($file) . ' ' . escapeshellarg(base64_encode(json_encode($get + ['lang' => 'en']))) . ' 2>&1';
    $html = shell_exec($command);
    if (!is_string($html) || $html === '') {
        throw new RuntimeException('Unable to render ' . $file);
    }
    return $html;
}

function write_static_page(string $path, string $html): void
{
    $html = preg_replace_callback(
        '/((?:href|action)=["\'])article\.php\?slug=([^"\']+)(["\'])/i',
        static fn(array $match): string => $match[1] . 'article-' . preg_replace('/[^a-zA-Z0-9_-]/', '-', urldecode($match[2])) . '.html' . $match[3],
        $html
    );
    $html = preg_replace_callback(
        '/((?:href|action)=["\'])([^"\']+?)\.php((?:[?\#][^"\']*)?["\'])/i',
        static fn(array $match): string => $match[1] . preg_replace('/\.php$/i', '.html', $match[2]) . $match[3],
        $html
    );
    $html = preg_replace("/window\\.location\\.href='([^']+)\\.php'/i", "window.location.href='$1.html'", $html);
    if (file_put_contents(__DIR__ . '/' . $path, $html, LOCK_EX) === false) {
        throw new RuntimeException('Unable to write ' . $path);
    }
    echo "Wrote $path\n";
}

foreach ($publicPages as $source => $target) {
    write_static_page($target, render_static_page($source));
}

try {
    $pdo = get_db();
    $articles = $pdo->query("SELECT slug FROM news WHERE status = 'published' AND slug <> ''")->fetchAll(PDO::FETCH_COLUMN);
    $existingArticles = glob(__DIR__ . '/article-*.html') ?: [];
    foreach ($existingArticles as $existingArticle) {
        @unlink($existingArticle);
    }
    foreach ($articles as $slug) {
        write_static_page('article-' . preg_replace('/[^a-zA-Z0-9_-]/', '-', $slug) . '.html', render_static_page('article.php', ['slug' => $slug]));
    }
} catch (\Throwable $e) {
    echo "Database offline: skipping dynamic article pages export.\n";
}

echo 'Static export complete.' . PHP_EOL;
