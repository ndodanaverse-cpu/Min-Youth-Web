<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/translation.php';
require_login();
$pdo  = get_db();
$user = current_user();

/* ---- Save a translation ---- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $type   = $_POST['content_type'] ?? '';
    $id     = (int)($_POST['content_id'] ?? 0);
    $lang   = $_POST['language'] ?? '';
    $fields = $_POST['fields'] ?? [];
    $valid  = ['news','gallery_items','resources','departments'];
    $langs  = ['en','sn','nr'];
    $translatable = [
      'news'          => ['title','excerpt','body'],
      'gallery_items' => ['title'],
      'resources'     => ['title','description'],
      'departments'   => ['name','description'],
    ];

    if (in_array($type,$valid,true) && $id && in_array($lang,$langs,true)) {
      if (($_POST['action'] ?? 'save') === 'auto_translate') {
        $columns = $translatable[$type];
        $select = implode(',', array_map(static fn(string $field): string => "`$field`", $columns));
        $sourceStmt = $pdo->prepare("SELECT $select FROM `$type` WHERE id=? LIMIT 1");
        $sourceStmt->execute([$id]);
        $source = $sourceStmt->fetch();
        $sourceValues = [];
        $sourceFields = [];
        if (!$source) {
          flash('error', 'The selected content could not be found.');
          header('Location: translations.php?type=' . urlencode($type)); exit;
        }
        foreach ($columns as $field) {
          if (!empty($source[$field])) {
            $sourceFields[] = $field;
            $sourceValues[] = $source[$field];
          }
        }

        try {
                $translated = translate_values($sourceValues, $lang);
          $fields = array_combine($sourceFields, $translated) ?: [];
        } catch (Throwable $exception) {
          flash('error', $exception->getMessage());
          header('Location: translations.php?type=' . urlencode($type)); exit;
        }
      }

        foreach ($fields as $field => $value) {
          if (!in_array($field, $translatable[$type], true)) continue;
            $value = trim($value);
            if ($value !== '') {
                $pdo->prepare("INSERT INTO content_translations (content_type,content_id,language,field_name,field_value)
                               VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE field_value=?")
                    ->execute([$type,$id,$lang,$field,$value,$value]);
            } else {
                $pdo->prepare("DELETE FROM content_translations WHERE content_type=? AND content_id=? AND language=? AND field_name=?")
                    ->execute([$type,$id,$lang,$field]);
            }
        }
        log_activity($user, "saved $lang translation for $type #$id");
        flash('success', 'Translation saved.');
    }
    header('Location: translations.php?type=' . urlencode($type)); exit;
}

/* ---- List content for selected type ---- */
$type = $_GET['type'] ?? 'news';
$validTypes = ['news','gallery_items','resources','departments'];
if (!in_array($type, $validTypes, true)) $type = 'news';

$titleCol = $type === 'departments' ? 'name' : 'title';
$stmt = $pdo->query("SELECT id, `$titleCol` AS title, status FROM `$type` ORDER BY updated_at DESC");
$items = $stmt->fetchAll();

// Load all existing translations for this type
$transStmt = $pdo->prepare("SELECT content_id, language, field_name, field_value FROM content_translations WHERE content_type=?");
$transStmt->execute([$type]);
$translations = [];
foreach ($transStmt->fetchAll() as $r) {
    $translations[$r['content_id']][$r['language']][$r['field_name']] = $r['field_value'];
}

$translatable = [
    'news'         => ['title','excerpt','body'],
    'gallery_items'=> ['title'],
    'resources'    => ['title','description'],
    'departments'  => ['name','description'],
];
$fields = $translatable[$type];

$typeLabels = ['news'=>'News','gallery_items'=>'Gallery','resources'=>'Resources','departments'=>'Departments'];

$pageTitle = 'Translations'; $activeNav = 'translations';
require __DIR__ . '/includes/header.php';
?>

<!-- Type tabs -->
<div class="flex gap-2 flex-wrap mb-6">
  <?php foreach ($typeLabels as $key => $label): ?>
    <a href="?type=<?= $key ?>" class="px-4 py-2 rounded-full text-sm border
      <?= $type===$key ? 'bg-primary text-on-primary border-primary' : 'border-outline-variant text-on-surface-variant hover:bg-surface-container-low' ?>">
      <?= e($label) ?>
    </a>
  <?php endforeach; ?>
</div>

<p class="text-sm text-on-surface-variant mb-5">
  Add translations for published content in any supported language. Leave a field blank to fall back to the English original.
  Translations are shown to visitors who have selected the relevant language. Automatic translation uses the local Free Translate API.
</p>

<?php if (!$items): ?>
  <p class="text-center text-on-surface-variant py-10">No <?= e($typeLabels[$type]) ?> content yet.</p>
<?php endif; ?>

<?php foreach ($items as $item): ?>
  <details class="bg-white border border-outline-variant rounded-xl mb-3 overflow-hidden group">
    <summary class="px-5 py-3 cursor-pointer flex items-center gap-3 hover:bg-surface-container-low/50 select-none">
      <span class="material-symbols-outlined text-[18px] text-on-surface-variant group-open:rotate-90 transition-transform">chevron_right</span>
      <span class="font-medium flex-1 truncate"><?= e($item['title']) ?></span>
      <?= status_badge($item['status']) ?>
      <?php
        $languageLabels = ['en'=>'English','sn'=>'Shona','nr'=>'Ndebele'];
      ?>
      <?php foreach ($languageLabels as $languageCode => $languageName): ?>
        <?php if (!empty($translations[$item['id']][$languageCode])): ?>
          <span class="text-xs px-2 py-0.5 rounded-full bg-primary-container text-on-primary-container"><?= e(strtoupper($languageCode)) ?> ✓</span>
        <?php endif; ?>
      <?php endforeach; ?>
    </summary>

    <div class="px-5 py-4 border-t border-outline-variant">
      <?php foreach ($languageLabels as $lang=>$langLabel): ?>
        <div class="mb-6">
          <h3 class="text-sm font-semibold mb-3 text-on-surface-variant"><?= e($langLabel) ?></h3>
          <form method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="content_type" value="<?= e($type) ?>">
            <input type="hidden" name="content_id"   value="<?= (int)$item['id'] ?>">
            <input type="hidden" name="language"     value="<?= e($lang) ?>">

            <?php foreach ($fields as $field): ?>
              <label class="block text-sm font-medium mb-1 capitalize"><?= e($field) ?></label>
              <?php
                $existing = $translations[$item['id']][$lang][$field] ?? '';
                $isLong   = in_array($field, ['body','description','excerpt']);
              ?>
              <?php if ($isLong): ?>
                <textarea name="fields[<?= e($field) ?>]" rows="4"
                  class="w-full mb-3 rounded-lg border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none"><?= e($existing) ?></textarea>
              <?php else: ?>
                <input type="text" name="fields[<?= e($field) ?>]" value="<?= e($existing) ?>"
                  class="w-full mb-3 rounded-lg border border-outline-variant px-3 py-2 text-sm focus:ring-2 focus:ring-primary outline-none">
              <?php endif; ?>
            <?php endforeach; ?>

            <div class="flex flex-wrap gap-2">
              <button type="submit" name="action" value="save" class="px-4 py-1.5 rounded-lg bg-primary text-on-primary text-sm font-semibold hover:opacity-90">
                Save <?= e($langLabel) ?> translation
              </button>
              <?php if ($lang === 'sn'): ?>
              <button type="submit" name="action" value="auto_translate" class="px-4 py-1.5 rounded-lg border border-tertiary text-tertiary text-sm font-semibold hover:bg-tertiary-container">
                Use hard-coded Shona translation
              </button>
              <?php endif; ?>
            </div>
          </form>
        </div>
      <?php endforeach; ?>
    </div>
  </details>
<?php endforeach; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
