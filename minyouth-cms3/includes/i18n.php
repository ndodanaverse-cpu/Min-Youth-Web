<?php
require_once __DIR__ . '/site.php';
/**
 * Lightweight i18n system for the public-facing pages.
 * - Three supported languages: en (English), sn (ChiShona), nr (Ndebele)
 * - Language is stored in a cookie and can be switched via ?lang= URL param
 * - Use t('key') to get a translated string anywhere in a public page
 */

define('SUPPORTED_LANGS', ['en', 'sn', 'nr']);
define('DEFAULT_LANG', 'en');

// Allow switching via ?lang= query param, persist in cookie
if (isset($_GET['lang']) && in_array($_GET['lang'], SUPPORTED_LANGS, true)) {
    setcookie('site_lang', $_GET['lang'], time() + 60 * 60 * 24 * 365, '/', '', false, false);
    $_COOKIE['site_lang'] = $_GET['lang'];
}

$GLOBALS['_i18n_lang'] = (isset($_COOKIE['site_lang']) && in_array($_COOKIE['site_lang'], SUPPORTED_LANGS, true))
    ? $_COOKIE['site_lang']
    : DEFAULT_LANG;

// Load translations (lazy-loaded once)
$GLOBALS['_i18n_strings'] = require __DIR__ . '/../lang/' . $GLOBALS['_i18n_lang'] . '.php';

/**
 * Translate a key.  Falls back to the English string, then to the key itself.
 */
function t(string $key, array $replace = []): string
{
    $strings = $GLOBALS['_i18n_strings'];
    $value   = $strings[$key] ?? null;

    if ($value === null) {
        // Fall back to English
        static $en = null;
        if ($en === null) {
            $en = require __DIR__ . '/../lang/en.php';
        }
        $value = $en[$key] ?? $key;
    }

    foreach ($replace as $k => $v) {
        $value = str_replace(':' . $k, $v, $value);
    }

    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/** Current active language code (e.g. 'en'). */
function current_lang(): string
{
    return $GLOBALS['_i18n_lang'];
}

/**
 * Return a URL that switches to $lang while keeping current path + other params.
 * Works both on PHP and when called from static context.
 */
function lang_switch_url(string $lang): string
{
    $params = $_GET;
    $params['lang'] = $lang;
    $base = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    return $base . '?' . http_build_query($params);
}

/** HTML for the language switcher dropdown (injected in the nav). */
function lang_switcher_html(): string
{
    $current = current_lang();
    $langs   = [
        'en' => ['name' => 'English',    'flag' => '🇬🇧'],
        'sn' => ['name' => 'ChiShona',   'flag' => '🇿🇼'],
        'nr' => ['name' => 'Ndebele', 'flag' => '🇿🇼'],
    ];

    $opts = '';
    foreach ($langs as $code => $info) {
        $active = $code === $current ? 'font-bold text-primary' : 'text-on-surface-variant hover:text-primary';
        $opts  .= '<a href="' . htmlspecialchars(lang_switch_url($code)) . '" '
                . 'class="flex items-center gap-2 px-3 py-1.5 ' . $active . ' hover:bg-surface-container-low rounded-lg text-sm transition whitespace-nowrap">'
                . $info['flag'] . ' ' . htmlspecialchars($info['name'])
                . ($code === $current ? ' <span class="text-xs">✓</span>' : '')
                . '</a>';
    }

    $cur = $langs[$current];

    return <<<HTML
<div class="relative group/lang">
  <button class="flex items-center gap-1 text-sm text-on-surface-variant hover:text-primary transition font-medium py-1 px-2 rounded-lg hover:bg-surface-container-low">
    <span class="material-symbols-outlined text-[18px]">language</span>
    {$cur['flag']} {$cur['name']}
    <span class="material-symbols-outlined text-[16px]">expand_more</span>
  </button>
  <div class="hidden group-hover/lang:block absolute right-0 top-full mt-1 bg-white border border-outline-variant rounded-xl shadow-lg p-2 min-w-[150px] z-50">
    {$opts}
  </div>
</div>
HTML;
}
