<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$pdo = get_db();
$user = current_user();

$table='gallery_items'; $nameCol='title'; $fileCols=['file_path']; $backUrl='gallery.php';
require __DIR__ . '/includes/workflow_actions.php'; // exits on POST

$status = $_GET['status'] ?? 'all';
$validStatuses = ['all','draft','pending','approved','published','rejected'];
if (!in_array($status, $validStatuses, true)) $status = 'all';

$sql = "SELECT g.*, u.full_name AS author_name FROM gallery_items g JOIN users u ON u.id = g.author_id";
$params = [];
if ($status !== 'all') { $sql .= " WHERE g.status = ?"; $params[] = $status; }
$sql .= " ORDER BY g.updated_at DESC";
$stmt = $pdo->prepare($sql); $stmt->execute($params);
$items = $stmt->fetchAll();

$pageTitle='Gallery'; $activeNav='gallery';
require __DIR__ . '/includes/header.php';
?>

<div class="flex items-center justify-between mb-4 flex-wrap gap-3">
  <div class="flex gap-2 flex-wrap">
    <?php foreach ($validStatuses as $s): ?>
      <a href="?status=<?= $s ?>" class="px-3 py-1.5 rounded-full text-sm border capitalize
        <?= $status===$s ? 'bg-primary text-on-primary border-primary' : 'border-outline-variant text-on-surface-variant hover:bg-surface-container-low' ?>"><?= $s ?></a>
    <?php endforeach; ?>
  </div>
  <a href="gallery_form.php" class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-1.5 hover:opacity-90">
    <span class="material-symbols-outlined text-[18px]">add</span> Add item
  </a>
</div>

<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
  <?php if (!$items): ?><p class="col-span-full text-center text-on-surface-variant py-10">No gallery items here yet.</p><?php endif; ?>
  <?php foreach ($items as $item): ?>
    <div class="bg-white border border-outline-variant rounded-xl overflow-hidden flex flex-col">
      <div class="relative aspect-[4/3] bg-surface-container-high">
        <img src="../<?= e($item['file_path']) ?>" class="w-full h-full object-cover">
        <div class="absolute top-2 left-2"><?= status_badge($item['status']) ?></div>
      </div>
      <div class="p-3 flex-1 flex flex-col">
        <p class="font-medium text-sm truncate"><?= e($item['title']) ?></p>
        <p class="text-xs text-on-surface-variant mb-1 capitalize"><?= e($item['category']) ?></p>
        <p class="text-xs text-on-surface-variant/70 mb-2"><?= workflow_hint($item['status']) ?></p>
        <?php if ($item['review_note']): ?><p class="text-xs text-error mb-2">Feedback: <?= e($item['review_note']) ?></p><?php endif; ?>
        <div class="mt-auto pt-2 border-t border-outline-variant">
          <?php $wItem=$item; $wType='gallery'; $wEditUrl="gallery_form.php?id={$item['id']}"; require __DIR__.'/includes/workflow_buttons.php'; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
