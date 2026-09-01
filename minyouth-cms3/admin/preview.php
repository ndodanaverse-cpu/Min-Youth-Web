<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();

$pdo  = get_db();
$user = current_user();
$type = $_GET['type'] ?? '';
$id   = (int)($_GET['id'] ?? 0);

// Fetch the item based on type — no status filter, previewing any state
$item = null;
switch ($type) {
    case 'news':
        $stmt = $pdo->prepare('SELECT n.*, u.full_name AS author_name FROM news n JOIN users u ON u.id = n.author_id WHERE n.id = ?');
        $stmt->execute([$id]); $item = $stmt->fetch(); break;
    case 'gallery':
        $stmt = $pdo->prepare('SELECT g.*, u.full_name AS author_name FROM gallery_items g JOIN users u ON u.id = g.author_id WHERE g.id = ?');
        $stmt->execute([$id]); $item = $stmt->fetch(); break;
    case 'resource':
        $stmt = $pdo->prepare('SELECT r.*, u.full_name AS author_name FROM resources r JOIN users u ON u.id = r.author_id WHERE r.id = ?');
        $stmt->execute([$id]); $item = $stmt->fetch(); break;
    case 'department':
        $stmt = $pdo->prepare('SELECT d.*, u.full_name AS author_name FROM departments d JOIN users u ON u.id = d.author_id WHERE d.id = ?');
        $stmt->execute([$id]); $item = $stmt->fetch(); break;
}

$editLinks = [
    'news'       => "news_form.php?id=$id",
    'gallery'    => "gallery_form.php?id=$id",
    'resource'   => "resources_form.php?id=$id",
    'department' => "departments_form.php?id=$id",
];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Preview | <?= $item ? e($item['title'] ?? $item['name'] ?? '') : 'Not found' ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: { extend: {
      colors: {
        primary: "#008000", "on-primary": "#ffffff", "primary-container": "#d7f0d7",
        tertiary: "#006496", "tertiary-container": "#cce5ff", "on-tertiary-container": "#001e30",
        secondary: "#6e5c00", "secondary-container": "#fcd400", "on-secondary-container": "#6e5c00",
        error: "#ba1a1a", "error-container": "#ffdad6", "on-error-container": "#93000a",
        background: "#fcf9f8", "on-surface": "#1c1b1b", "on-surface-variant": "#3e4a41",
        "surface-container-low": "#f6f3f2", "outline-variant": "#bdcabe",
      },
      fontFamily: { sans: ["Poppins","sans-serif"] }
    }}
  };
</script>
<style>
  body { font-family: 'Poppins', sans-serif; }
  .material-symbols-outlined { font-variation-settings: 'FILL' 0,'wght' 400; font-size:20px; vertical-align:middle; }
</style>
</head>
<body class="bg-background text-on-surface min-h-screen">

<!-- Preview banner (sticky) -->
<div class="sticky top-0 z-50 bg-secondary-container text-on-secondary-container px-4 py-2 flex items-center justify-between text-sm font-medium shadow">
  <span class="flex items-center gap-2">
    <span class="material-symbols-outlined">preview</span>
    PREVIEW — <?= status_badge($item['status'] ?? 'draft') ?> — not live on the public site
  </span>
  <div class="flex items-center gap-3">
    <?php if (can_edit_item($user, $item ?? ['author_id'=>0,'status'=>'draft'])): ?>
      <a href="<?= e($editLinks[$type] ?? '#') ?>"
         class="bg-primary text-on-primary px-3 py-1 rounded text-xs font-semibold hover:opacity-90">
        ← Back to edit
      </a>
    <?php endif; ?>
    <button onclick="window.close()" class="border border-current px-3 py-1 rounded text-xs hover:bg-black/5">
      Close
    </button>
  </div>
</div>

<?php if (!$item): ?>
  <div class="max-w-2xl mx-auto mt-24 text-center px-6">
    <span class="material-symbols-outlined text-6xl text-outline-variant block mb-4">search_off</span>
    <h1 class="text-2xl font-semibold mb-2">Item not found</h1>
    <p class="text-on-surface-variant">This item may have been deleted or the link is incorrect.</p>
  </div>

<?php elseif ($type === 'news'): ?>
  <!-- News article preview -->
  <div class="relative h-64 md:h-96 w-full overflow-hidden flex items-end">
    <?php if ($item['image']): ?>
      <img src="../<?= e($item['image']) ?>" class="absolute inset-0 w-full h-full object-cover brightness-50">
    <?php else: ?>
      <div class="absolute inset-0 bg-gradient-to-br from-primary to-primary/60"></div>
    <?php endif; ?>
    <div class="relative z-10 max-w-4xl mx-auto w-full px-6 pb-10">
      <span class="inline-block bg-secondary-container text-on-secondary-container text-xs font-bold px-3 py-1 rounded-full uppercase mb-3">News</span>
      <h1 class="text-3xl md:text-4xl font-bold text-white leading-tight"><?= e($item['title']) ?></h1>
      <p class="text-white/80 mt-3 text-sm">
        <?= e(date('F j, Y', strtotime($item['created_at']))) ?>
        &middot; By <?= e($item['author_name']) ?>
      </p>
    </div>
  </div>
  <div class="max-w-3xl mx-auto px-6 py-12">
    <?php if ($item['excerpt']): ?>
      <p class="text-lg text-on-surface-variant font-medium mb-8 leading-relaxed border-l-4 border-primary pl-4">
        <?= e($item['excerpt']) ?>
      </p>
    <?php endif; ?>
    <div class="text-on-surface leading-relaxed whitespace-pre-line text-base"><?= e($item['body']) ?></div>
  </div>

<?php elseif ($type === 'gallery'): ?>
  <!-- Gallery item preview -->
  <div class="max-w-3xl mx-auto px-6 py-12">
    <h1 class="text-2xl font-bold mb-2"><?= e($item['title']) ?></h1>
    <p class="text-on-surface-variant text-sm mb-6 capitalize"><?= e($item['category']) ?> &middot; <?= e($item['media_type']) ?></p>
    <div class="rounded-xl overflow-hidden bg-surface-container-low aspect-video flex items-center justify-center">
      <?php if ($item['media_type'] === 'video' && $item['video_url']): ?>
        <iframe src="<?= e($item['video_url']) ?>" class="w-full h-full" allowfullscreen></iframe>
      <?php elseif ($item['file_path']): ?>
        <img src="../<?= e($item['file_path']) ?>" class="w-full h-full object-contain">
      <?php else: ?>
        <span class="material-symbols-outlined text-6xl text-outline-variant">image</span>
      <?php endif; ?>
    </div>
    <p class="text-xs text-on-surface-variant mt-4">Uploaded by <?= e($item['author_name']) ?> on <?= format_date($item['created_at']) ?></p>
  </div>

<?php elseif ($type === 'resource'): ?>
  <!-- Resource / document preview -->
  <div class="max-w-2xl mx-auto px-6 py-12">
    <div class="bg-white border border-outline-variant rounded-2xl p-10 flex flex-col items-center text-center shadow-sm">
      <span class="material-symbols-outlined text-6xl text-error mb-4" style="font-variation-settings:'FILL' 1">picture_as_pdf</span>
      <h1 class="text-2xl font-bold mb-2"><?= e($item['title']) ?></h1>
      <?php if ($item['description']): ?>
        <p class="text-on-surface-variant mb-4 leading-relaxed"><?= e($item['description']) ?></p>
      <?php endif; ?>
      <span class="text-xs px-3 py-1 rounded-full bg-surface-container-low text-on-surface-variant mb-6"><?= e($item['category']) ?></span>
      <?php if ($item['file_path']): ?>
        <a href="../<?= e($item['file_path']) ?>" target="_blank"
           class="bg-primary text-on-primary font-bold py-3 px-8 rounded-xl flex items-center gap-2 hover:opacity-90">
          <span class="material-symbols-outlined text-[20px]">download</span> Download document
        </a>
      <?php endif; ?>
      <p class="text-xs text-on-surface-variant mt-6">Uploaded by <?= e($item['author_name']) ?> &middot; <?= format_date($item['created_at']) ?></p>
    </div>
  </div>

<?php elseif ($type === 'department'): ?>
  <!-- Department card preview -->
  <div class="max-w-2xl mx-auto px-6 py-12">
    <div class="bg-white border border-outline-variant rounded-2xl overflow-hidden shadow-sm">
      <?php if ($item['image']): ?>
        <div class="h-56 overflow-hidden">
          <img src="../<?= e($item['image']) ?>" class="w-full h-full object-cover">
        </div>
      <?php endif; ?>
      <div class="p-8 relative">
        <div class="absolute -top-6 right-8 w-12 h-12 bg-primary text-on-primary flex items-center justify-center rounded shadow-md">
          <span class="material-symbols-outlined"><?= e($item['icon'] ?? 'apartment') ?></span>
        </div>
        <span class="text-xs font-semibold uppercase tracking-wide text-on-surface-variant"><?= e($item['group_type']) ?> Department</span>
        <h1 class="text-2xl font-bold mt-1 mb-3"><?= e($item['name']) ?></h1>
        <?php if ($item['description']): ?>
          <p class="text-on-surface-variant leading-relaxed"><?= e($item['description']) ?></p>
        <?php endif; ?>
        <p class="text-xs text-on-surface-variant mt-6">Added by <?= e($item['author_name']) ?> &middot; <?= format_date($item['created_at']) ?></p>
      </div>
    </div>
  </div>
<?php endif; ?>

</body>
</html>
