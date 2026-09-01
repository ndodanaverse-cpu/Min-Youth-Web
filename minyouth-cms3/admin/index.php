<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();

$pdo = get_db();
$user = current_user();

$tables = [
    'news'        => 'News',
    'gallery_items' => 'Gallery',
    'resources'   => 'Resources',
    'departments' => 'Departments',
];

// Counts per content type, per status
$counts = [];
foreach ($tables as $table => $label) {
    $stmt = $pdo->query("SELECT status, COUNT(*) c FROM `$table` GROUP BY status");
    $row = ['draft' => 0, 'pending' => 0, 'approved' => 0, 'published' => 0, 'rejected' => 0];
    foreach ($stmt->fetchAll() as $r) {
        $row[$r['status']] = (int)$r['c'];
    }
    $counts[$table] = $row;
}

// Recent activity
$activity = $pdo->query(
    "SELECT a.*, u.full_name FROM activity_log a JOIN users u ON u.id = a.user_id ORDER BY a.created_at DESC LIMIT 10"
)->fetchAll();

$pageTitle = 'Dashboard';
$activeNav = 'dashboard';
require __DIR__ . '/includes/header.php';
?>

<p class="text-on-surface-variant mb-6">Welcome back, <?= e($user['full_name']) ?> <span class="font-medium">(<?= role_label($user['role']) ?>)</span>. Here's what's happening across the site.</p>

<!-- Content stat cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
  <?php foreach ($tables as $table => $label):
        $c = $counts[$table];
        $total = array_sum($c);
        $href = $table === 'gallery_items' ? 'gallery.php' : "$table.php";
  ?>
    <a href="<?= e($href) ?>" class="block bg-white border border-outline-variant rounded-xl p-5 hover:shadow-md transition">
      <p class="text-on-surface-variant text-sm mb-1"><?= e($label) ?></p>
      <p class="text-2xl font-semibold mb-3"><?= $total ?> <span class="text-sm font-normal text-on-surface-variant">total</span></p>
      <div class="flex gap-2 text-xs flex-wrap">
        <span class="px-2 py-0.5 rounded-full bg-primary-container text-on-primary-container"><?= $c['published'] ?> published</span>
        <span class="px-2 py-0.5 rounded-full bg-tertiary-container text-on-tertiary-container"><?= $c['approved'] ?> approved</span>
        <span class="px-2 py-0.5 rounded-full bg-secondary-container text-on-secondary-container"><?= $c['pending'] ?> pending</span>
        <span class="px-2 py-0.5 rounded-full bg-surface-container-high text-on-surface-variant"><?= $c['draft'] ?> draft</span>
      </div>
    </a>
  <?php endforeach; ?>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

  <!-- Pending / Approved review queue -->
  <div class="bg-white border border-outline-variant rounded-xl p-5">
    <h2 class="font-semibold mb-1 flex items-center gap-2">
      <span class="material-symbols-outlined text-secondary">pending_actions</span>
      <?php if (is_chief_editor($user)): ?>Items approved — ready to publish<?php elseif (is_editor($user)): ?>Items pending your approval<?php else: ?>Your submissions<?php endif; ?>
    </h2>
    <p class="text-xs text-on-surface-variant mb-4">
      <?php if (is_chief_editor($user)): ?>Editors have approved these — you are the final step before they go live.
      <?php elseif (is_editor($user)): ?>Review these, then approve to forward to the Chief Editor for publication.
      <?php else: ?>Track the status of your submitted content below.<?php endif; ?>
    </p>
    <?php
    // Build queue: chief editor sees approved; editor sees pending; sub editor sees their own items
    $queueItems = [];
    foreach ($tables as $table => $label) {
        $titleCol = $table === 'departments' ? 'name' : 'title';
        if (is_chief_editor($user)) {
            $qStmt = $pdo->prepare("SELECT id, `$titleCol` AS title, updated_at FROM `$table` WHERE status='approved' ORDER BY updated_at DESC LIMIT 5");
            $qStmt->execute();
        } elseif (is_editor($user)) {
            $qStmt = $pdo->prepare("SELECT id, `$titleCol` AS title, updated_at FROM `$table` WHERE status='pending' ORDER BY updated_at DESC LIMIT 5");
            $qStmt->execute();
        } else {
            $qStmt = $pdo->prepare("SELECT id, `$titleCol` AS title, status, updated_at FROM `$table` WHERE author_id=? AND status != 'draft' ORDER BY updated_at DESC LIMIT 3");
            $qStmt->execute([$user['id']]);
        }
        foreach ($qStmt->fetchAll() as $r) {
            $r['type'] = $table; $r['type_label'] = $label; $queueItems[] = $r;
        }
    }
    usort($queueItems, fn($a,$b) => strtotime($b['updated_at']) - strtotime($a['updated_at']));
    ?>
    <?php if (!$queueItems): ?>
      <p class="text-sm text-on-surface-variant">Nothing in the queue right now.</p>
    <?php else: ?>
      <ul class="divide-y divide-outline-variant">
        <?php foreach (array_slice($queueItems, 0, 8) as $qi): ?>
          <li class="py-3 flex items-center justify-between gap-3">
            <div class="min-w-0">
              <p class="text-sm font-medium truncate"><?= e($qi['title']) ?></p>
              <p class="text-xs text-on-surface-variant"><?= e($qi['type_label']) ?>
                <?php if (!is_editor($user)): ?>&middot; <?= status_badge($qi['status']) ?><?php endif; ?>
                &middot; <?= format_date($qi['updated_at']) ?>
              </p>
            </div>
            <?php
            $listPage = $qi['type'] === 'gallery_items' ? 'gallery' : $qi['type'];
            $filterStatus = is_chief_editor($user) ? 'approved' : (is_editor($user) ? 'pending' : $qi['status']);
            ?>
            <a href="<?= e($listPage) ?>.php?status=<?= $filterStatus ?>"
               class="text-xs font-semibold text-primary hover:underline shrink-0">
              <?= is_chief_editor($user) ? 'Publish →' : (is_editor($user) ? 'Approve →' : 'View →') ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>

  <!-- Recent activity -->
  <div class="bg-white border border-outline-variant rounded-xl p-5">
    <h2 class="font-semibold mb-4 flex items-center gap-2">
      <span class="material-symbols-outlined text-primary">history</span>
      Recent activity
    </h2>
    <?php if (!$activity): ?>
      <p class="text-sm text-on-surface-variant">No activity recorded yet.</p>
    <?php else: ?>
      <ul class="divide-y divide-outline-variant">
        <?php foreach ($activity as $log): ?>
          <li class="py-3">
            <p class="text-sm"><span class="font-medium"><?= e($log['full_name']) ?></span> <?= e($log['action']) ?></p>
            <?php if ($log['details']): ?><p class="text-xs text-on-surface-variant"><?= e($log['details']) ?></p><?php endif; ?>
            <p class="text-xs text-on-surface-variant/70"><?= format_date($log['created_at']) ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
