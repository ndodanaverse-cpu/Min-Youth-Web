<?php
require_once __DIR__ . '/site.php';
/**
 * Language / i18n helpers.
 *
 * Detects the visitor's language from:
 *   1. ?lang= query parameter   (sets cookie, then redirects)
 *   2. minyouth_lang cookie
 *   3. Fallback: 'en'
 *
 * Public pages include this file; the __() helper is then available
 * for any server-side translated strings.
 */

define('SUPPORTED_LANGS', ['en', 'sn', 'nr']);

const LANGUAGE_NAMES = [
    'en'   => 'English',
    'sn'   => 'Shona',
    'nr'   => 'Ndebele',
];

require_once __DIR__ . '/translation.php';

/* ---- Language detection & switching ---- */
function detect_language(): string
{
    if (isset($_GET['lang']) && in_array($_GET['lang'], SUPPORTED_LANGS, true)) {
        $code = $_GET['lang'];
        setcookie('minyouth_lang', $code, time() + 60 * 60 * 24 * 365, '/');
        setcookie('site_lang', $code, time() + 60 * 60 * 24 * 365, '/');
        return $code;
    }
    $cookie = $_COOKIE['site_lang'] ?? $_COOKIE['minyouth_lang'] ?? 'en';
    return in_array($cookie, SUPPORTED_LANGS, true) ? $cookie : 'en';
}

$GLOBALS['current_lang'] = detect_language();

/* ---- Load translation strings ---- */
function load_lang(string $code): array
{
    $file = __DIR__ . '/../lang/' . $code . '.php';
    if (!file_exists($file)) {
        $file = __DIR__ . '/../lang/en.php';
    }
    return require $file;
}

$GLOBALS['lang_strings'] = load_lang($GLOBALS['current_lang']);

/**
 * Translate a UI key.  Falls back to English if key missing.
 */
function __(string $key, string $default = ''): string
{
    return htmlspecialchars(
        $GLOBALS['lang_strings'][$key]
            ?? load_lang('en')[$key]
            ?? $default,
        ENT_QUOTES, 'UTF-8'
    );
}

/**
 * Return the raw (un-escaped) translation string.
 */
function _r(string $key, string $default = ''): string
{
    return $GLOBALS['lang_strings'][$key]
        ?? load_lang('en')[$key]
        ?? $default;
}

function localized_content_value(?string $value): string
{
    if ($value === null || $value === '' || ($GLOBALS['current_lang'] ?? 'en') !== 'sn') {
        return (string)$value;
    }

    $translations = hardcoded_shona_translations();
    return $translations[$value] ?? $value;
}

/**
 * Fetch a translated field for a content item.
 * Returns null when language is 'en' or no translation exists (caller falls back to original).
 */
function get_translation(PDO $pdo, string $type, int $id, string $field): ?string
{
    $lang = $GLOBALS['current_lang'];
    if ($lang === 'en') return null;
    $stmt = $pdo->prepare(
        'SELECT field_value FROM content_translations
         WHERE content_type=? AND content_id=? AND language=? AND field_name=?'
    );
    $stmt->execute([$type, $id, $lang, $field]);
    $val = $stmt->fetchColumn();
    return ($val !== false && $val !== '') ? $val : null;
}

/**
 * Emit the HTML for the language switcher nav strip.
 * Rendered as a single dropdown containing all supported languages.
 */
function lang_switcher_html(string $class = ''): string
{
    $current = $GLOBALS['current_lang'];
    $base = strtok($_SERVER['REQUEST_URI'], '?');
    $options = '';
    foreach (LANGUAGE_NAMES as $code => $name) {
        $href = $base . '?lang=' . $code;
        $options .= '<a href="' . htmlspecialchars($href) . '" class="block px-3 py-2 text-sm text-on-surface-variant hover:bg-surface-container-high hover:text-black whitespace-nowrap">' . htmlspecialchars($name) . '</a>';
    }
    $current_name = LANGUAGE_NAMES[$current] ?? LANGUAGE_NAMES['en'];
    return '<details id="site-language" class="' . htmlspecialchars($class) . ' relative group">'
        . '<summary class="list-none cursor-pointer flex items-center gap-2 text-sm font-medium text-on-surface-variant hover:text-black" title="Language" aria-label="Language">'
        . '<span>Language:</span><span>' . htmlspecialchars(strtoupper($current)) . '</span>'
        . '<span aria-hidden="true">&#9662;</span></summary>'
        . '<div class="absolute right-0 top-full mt-2 z-50 min-w-40 bg-surface border border-outline-variant rounded-lg shadow-lg p-1">'
        . '<span class="sr-only">Current language: ' . htmlspecialchars($current_name) . '</span>' . $options . '</div></details>';
}
