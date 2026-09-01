<?php
/**
 * Chatbot API proxy endpoint.
 * Accepts POST JSON: { messages: [...], lang: 'en'|'sn'|'nr' }
 * Returns JSON:      { reply: '...', error: '...' }
 */
header('Content-Type: application/json; charset=utf-8');

// CORS for same-origin (all public pages on the same domain)
header('X-Content-Type-Options: nosniff');

/* ---- Config ---- */
$configFile = __DIR__ . '/config/database.php';
if (!file_exists($configFile)) {
    echo json_encode(['error' => 'Server not configured.']); exit;
}
require_once $configFile;
require_once __DIR__ . '/includes/functions.php';

// Load chatbot config from DB
try {
    $pdo = get_db();
} catch (Throwable $e) {
    echo json_encode(['error' => 'Database unavailable.']); exit;
}

$cfg = [];
foreach ($pdo->query("SELECT cfg_key, cfg_value FROM chatbot_config")->fetchAll() as $r) {
    $cfg[$r['cfg_key']] = $r['cfg_value'];
}

if (empty($cfg['enabled']) || $cfg['enabled'] !== '1') {
    echo json_encode(['error' => 'Chatbot is currently disabled.']); exit;
}

$apiKey = trim($cfg['api_key'] ?? '');
if (!$apiKey) {
    echo json_encode(['error' => 'Chatbot API key not configured. Please ask an admin to add the key in Admin → Chatbot Settings.']); exit;
}

/* ---- Parse request ---- */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'POST required.']); exit;
}

$input    = json_decode(file_get_contents('php://input'), true);
$messages = $input['messages'] ?? [];
$lang     = in_array($input['lang'] ?? 'en', ['en', 'sn', 'nr'], true) ? $input['lang'] : 'en';

if (empty($messages) || !is_array($messages)) {
    echo json_encode(['error' => 'No messages.']); exit;
}

// Basic sanity: only allow user/assistant roles, cap history
$messages = array_filter($messages, fn($m) => in_array($m['role'] ?? '', ['user','assistant']));
$messages = array_slice(array_values($messages), -10); // keep last 10 turns

/* ---- Ministry context from DB ---- */
$departments = $pdo->query(
    "SELECT name, group_type, description FROM departments WHERE status='published' ORDER BY group_type, sort_order LIMIT 15"
)->fetchAll();

$recentNews = $pdo->query(
    "SELECT title, excerpt FROM news WHERE status='published' ORDER BY published_at DESC LIMIT 5"
)->fetchAll();

$deptLines = implode("\n", array_map(
    fn($d) => "  - {$d['name']} ({$d['group_type']}): {$d['description']}",
    $departments
));
$newsLines = implode("\n", array_map(
    fn($n) => "  - {$n['title']}" . ($n['excerpt'] ? ": {$n['excerpt']}" : ''),
    $recentNews
));

/* ---- System prompt ---- */
$system = <<<PROMPT
You are an official virtual assistant for the Zimbabwe Ministry of Youth Empowerment, Development and Vocational Training (MoYED).

MISSION: To empower the youth of Zimbabwe through skills development, entrepreneurship support, national service, and vocational training programs.

DEPARTMENTS ON THIS SITE:
{$deptLines}

RECENT NEWS & EVENTS:
{$newsLines}

KEY PROGRAMS:
  - National Youth Service (NYS): citizenship, leadership and national development training
  - Vocational Training Centres (VTCs): industry-standard technical skills and certification
  - Youth Empowerment Fund: grants, loans, and business support for young entrepreneurs
  - Business Development: mentorship, market access, and startup support

CONTACT: Citizens can visit the ministry website's Contact page or go in person to ministry offices.

LANGUAGE INSTRUCTIONS:
  - The user's selected language is: {$lang}
  - Always respond in the SAME language the user writes in
  - If the user writes in ChiShona, reply in ChiShona
  - If the user writes in isiNdebele, reply in isiNdebele
  - If the user writes in English, reply in English
  - For mixed-language messages, favour the dominant language

RESPONSE GUIDELINES:
  - Be helpful, respectful, professional, and concise (2–4 sentences unless more detail is requested)
  - Do not invent statistics, program details, or contact numbers you are not sure about
  - For specific applications or urgent queries, direct users to the Contact page or nearest ministry office
  - Encourage Zimbabwe's youth to take advantage of ministry programs
  - Never discuss politics, religion, or topics unrelated to the ministry's mandate
PROMPT;

/* ---- Call Anthropic API via cURL ---- */
$payload = json_encode([
    'model'      => $cfg['model'] ?? 'claude-sonnet-4-6',
    'max_tokens' => (int)($cfg['max_tokens'] ?? 500),
    'system'     => $system,
    'messages'   => array_values($messages),
]);

$ch = curl_init('https://api.anthropic.com/v1/messages');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => $payload,
    CURLOPT_HTTPHEADER     => [
        'x-api-key: ' . $apiKey,
        'anthropic-version: 2023-06-01',
        'content-type: application/json',
    ],
    CURLOPT_TIMEOUT        => 25,
    CURLOPT_SSL_VERIFYPEER => true,
]);

$raw      = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlErr  = curl_error($ch);
curl_close($ch);

if ($curlErr) {
    echo json_encode(['error' => 'Network error: ' . $curlErr]); exit;
}
if ($httpCode !== 200) {
    $data = json_decode($raw, true);
    $msg  = $data['error']['message'] ?? "API error (HTTP $httpCode)";
    echo json_encode(['error' => $msg]); exit;
}

$data  = json_decode($raw, true);
$reply = $data['content'][0]['text'] ?? '';
if (!$reply) {
    echo json_encode(['error' => 'Empty response from API.']); exit;
}

echo json_encode(['reply' => $reply]);
