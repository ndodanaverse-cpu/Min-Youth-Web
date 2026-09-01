<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('chief_editor');
$pdo  = get_db();
$user = current_user();

/* ---- Save settings ---- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $fields = ['enabled','api_key','model','max_tokens','welcome_en','welcome_sn','welcome_nd'];
    foreach ($fields as $key) {
        $val = $_POST[$key] ?? '';
        $pdo->prepare("INSERT INTO chatbot_config (cfg_key, cfg_value) VALUES (?,?) ON DUPLICATE KEY UPDATE cfg_value=?")->execute([$key, $val, $val]);
    }
    log_activity($user, 'updated chatbot settings');
    flash('success', 'Chatbot settings saved.');
    header('Location: chatbot.php'); exit;
}

/* ---- Load settings ---- */
$cfg = [];
foreach ($pdo->query("SELECT cfg_key, cfg_value FROM chatbot_config")->fetchAll() as $r) {
    $cfg[$r['cfg_key']] = $r['cfg_value'];
}

$pageTitle = 'Chatbot Settings'; $activeNav = 'chatbot';
require __DIR__ . '/includes/header.php';
?>

<div class="max-w-2xl">
  <p class="text-on-surface-variant mb-6 text-sm">
    The AI chatbot appears as a floating widget on all public pages. It uses the Anthropic API to answer visitors' questions about ministry programmes and services.
    You need an <a href="https://console.anthropic.com" target="_blank" class="text-primary underline">Anthropic API key</a> to enable it.
  </p>

  <form method="post" class="space-y-6">
    <?= csrf_field() ?>

    <!-- Enable / disable -->
    <div class="bg-white border border-outline-variant rounded-xl p-5">
      <h2 class="font-semibold mb-4 flex items-center gap-2"><span class="material-symbols-outlined">toggle_on</span> Status</h2>
      <label class="flex items-center gap-3 cursor-pointer">
        <input type="checkbox" name="enabled" value="1" class="w-4 h-4 accent-primary" <?= !empty($cfg['enabled']) && $cfg['enabled']==='1' ? 'checked' : '' ?>>
        <span class="text-sm font-medium">Chatbot is active on the public website</span>
      </label>
    </div>

    <!-- API key -->
    <div class="bg-white border border-outline-variant rounded-xl p-5">
      <h2 class="font-semibold mb-4 flex items-center gap-2"><span class="material-symbols-outlined">key</span> Anthropic API Key</h2>
      <input type="password" name="api_key" value="<?= e($cfg['api_key'] ?? '') ?>"
             placeholder="sk-ant-…"
             class="w-full rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none font-mono text-sm mb-2">
      <p class="text-xs text-on-surface-variant">Your key is stored in the database and never displayed after saving. Get one at <a href="https://console.anthropic.com" target="_blank" class="text-primary underline">console.anthropic.com</a>.</p>
    </div>

    <!-- Model settings -->
    <div class="bg-white border border-outline-variant rounded-xl p-5">
      <h2 class="font-semibold mb-4 flex items-center gap-2"><span class="material-symbols-outlined">settings</span> Model Settings</h2>
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Model</label>
          <select name="model" class="w-full rounded-lg border border-outline-variant px-4 py-2.5 text-sm">
            <?php foreach (['claude-sonnet-4-6','claude-haiku-4-5-20251001','claude-opus-4-6'] as $m): ?>
              <option value="<?= e($m) ?>" <?= ($cfg['model']??'')===$m?'selected':'' ?>><?= e($m) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Max tokens per reply</label>
          <input type="number" name="max_tokens" value="<?= e($cfg['max_tokens'] ?? '500') ?>" min="50" max="2000"
                 class="w-full rounded-lg border border-outline-variant px-4 py-2.5 text-sm">
        </div>
      </div>
    </div>

    <!-- Welcome messages -->
    <div class="bg-white border border-outline-variant rounded-xl p-5">
      <h2 class="font-semibold mb-4 flex items-center gap-2"><span class="material-symbols-outlined">waving_hand</span> Welcome Messages</h2>
      <?php foreach (['en'=>'English 🇬🇧','sn'=>'ChiShona 🇿🇼','nr'=>'Ndebele 🇿🇼'] as $code=>$label): ?>
        <label class="block text-sm font-medium mb-1"><?= e($label) ?></label>
        <textarea name="welcome_<?= $code ?>" rows="2"
                  class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary outline-none"><?= e($cfg["welcome_$code"] ?? '') ?></textarea>
      <?php endforeach; ?>
    </div>

    <button type="submit" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-semibold hover:opacity-90 flex items-center gap-2">
      <span class="material-symbols-outlined text-[18px]">save</span> Save settings
    </button>
  </form>

  <!-- Live test -->
  <div class="mt-8 bg-surface-container-low rounded-xl p-5">
    <h2 class="font-semibold mb-2 flex items-center gap-2"><span class="material-symbols-outlined">science</span> Test the chatbot</h2>
    <p class="text-sm text-on-surface-variant mb-3">Open the public site in a new tab to test the live chatbot widget.</p>
    <a href="../index.php" target="_blank" class="inline-flex items-center gap-2 bg-primary text-on-primary px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90">
      <span class="material-symbols-outlined text-[18px]">open_in_new</span> Open public site
    </a>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
