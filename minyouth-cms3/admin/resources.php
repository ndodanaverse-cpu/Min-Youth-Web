<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$pdo = get_db();
$user = current_user();

$table='resources'; $nameCol='title'; $fileCols=['file_path']; $backUrl='resources.php';
require __DIR__ . '/includes/workflow_actions.php';

$status = $_GET['status'] ?? 'all';
$validStatuses = ['all','draft','pending','approved','published','rejected'];
if (!in_array($status, $validStatuses, true)) $status = 'all';

$sql = "SELECT r.*, u.full_name AS author_name FROM resources r JOIN users u ON u.id = r.author_id";
$params=[];
if ($status !== 'all') { $sql .= " WHERE r.status = ?"; $params[]=$status; }
$sql .= " ORDER BY r.updated_at DESC";
$stmt=$pdo->prepare($sql); $stmt->execute($params);
$items=$stmt->fetchAll();

$pageTitle='Resources'; $activeNav='resources';
require __DIR__ . '/includes/header.php';
?>
<div class="flex items-center justify-between mb-4 flex-wrap gap-3">
  <div class="flex gap-2 flex-wrap">
    <?php foreach ($validStatuses as $s): ?>
      <a href="?status=<?= $s ?>" class="px-3 py-1.5 rounded-full text-sm border capitalize
        <?= $status===$s ? 'bg-primary text-on-primary border-primary' : 'border-outline-variant text-on-surface-variant hover:bg-surface-container-low' ?>"><?= $s ?></a>
    <?php endforeach; ?>
  </div>
  <a href="resources_form.php" class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-1.5 hover:opacity-90">
    <span class="material-symbols-outlined text-[18px]">add</span> Upload document
  </a>
</div>
<div class="bg-white border border-outline-variant rounded-xl overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-surface-container-low text-on-surface-variant text-left">
      <tr><th class="px-4 py-3 font-medium">Title</th><th class="px-4 py-3 font-medium">Category</th><th class="px-4 py-3 font-medium">Author</th><th class="px-4 py-3 font-medium">Status / Next step</th><th class="px-4 py-3 font-medium">Updated</th><th class="px-4 py-3 font-medium text-right">Actions</th></tr>
    </thead>
    <tbody class="divide-y divide-outline-variant">
      <?php if (!$items): ?><tr><td colspan="6" class="px-4 py-10 text-center text-on-surface-variant">No documents uploaded yet.</td></tr><?php endif; ?>
      <?php foreach ($items as $item): ?>
        <tr class="hover:bg-surface-container-low/50">
          <td class="px-4 py-3">
            <a href="../<?= e($item['file_path']) ?>" target="_blank" class="font-medium hover:text-primary flex items-center gap-1.5">
              <span class="material-symbols-outlined text-[18px] text-on-surface-variant">description</span><?= e($item['title']) ?>
            </a>
            <?php if ($item['review_note']): ?><p class="text-xs text-error mt-1">Feedback: <?= e($item['review_note']) ?></p><?php endif; ?>
          </td>
          <td class="px-4 py-3 text-on-surface-variant"><?= e($item['category']) ?></td>
          <td class="px-4 py-3 text-on-surface-variant"><?= e($item['author_name']) ?></td>
          <td class="px-4 py-3"><?= status_badge($item['status']) ?><p class="text-xs text-on-surface-variant mt-1"><?= workflow_hint($item['status']) ?></p></td>
          <td class="px-4 py-3 text-on-surface-variant whitespace-nowrap"><?= format_date($item['updated_at']) ?></td>
          <td class="px-4 py-3"><?php $wItem=$item; $wType='resource'; $wEditUrl="resources_form.php?id={$item['id']}"; require __DIR__.'/includes/workflow_buttons.php'; ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
