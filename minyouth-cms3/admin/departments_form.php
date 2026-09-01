<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$pdo = get_db();
$user = current_user();

$id = (int)($_GET['id'] ?? 0);
$item = ['id' => 0, 'name' => '', 'group_type' => 'core', 'description' => '', 'icon' => 'apartment', 'image' => '', 'link_url' => '', 'sort_order' => 0, 'status' => 'draft', 'author_id' => $user['id'], 'review_note' => null];

$iconOptions = ['apartment', 'psychology', 'volunteer_activism', 'handyman', 'business_center', 'shopping_cart', 'campaign', 'fact_check', 'groups', 'gavel', 'payments', 'diversity_3', 'analytics', 'school', 'public', 'eco'];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM departments WHERE id = ?');
    $stmt->execute([$id]);
    $found = $stmt->fetch();
    if (!$found) { flash('error', 'Department not found.'); header('Location: departments.php'); exit; }
    if (!can_edit_item($user, $found)) { flash('error', "You don't have permission to edit that item."); header('Location: departments.php'); exit; }
    $item = $found;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $name = trim($_POST['name'] ?? '');
    $groupType = $_POST['group_type'] ?? 'core';
    $description = trim($_POST['description'] ?? '');
    $icon = $_POST['icon'] ?? 'apartment';
    $linkUrl = trim($_POST['link_url'] ?? '');
    $sortOrder = (int)($_POST['sort_order'] ?? 0);
    $action = $_POST['form_action'] ?? 'draft';

    if ($name === '') $errors[] = 'Department name is required.';
    if (!in_array($icon, $iconOptions, true)) $icon = 'apartment';

    $imagePath = $item['image'];
    try {
        $uploaded = handle_upload('image', 'departments', ['jpg', 'jpeg', 'png', 'webp'], 5);
        if ($uploaded) {
            if ($imagePath) { @unlink(__DIR__ . '/../' . $imagePath); }
            $imagePath = $uploaded;
        }
    } catch (RuntimeException $e) {
        $errors[] = $e->getMessage();
    }

    if (!$errors) {
        $status = resolve_save_status($action, $user);

        if ($id) {
            $sql = "UPDATE departments SET name=?, group_type=?, description=?, icon=?, image=?, link_url=?, sort_order=?, status=?, updated_at=NOW()";
            $params = [$name, $groupType, $description, $icon, $imagePath, $linkUrl, $sortOrder, $status];
            if ($status === 'published') { $sql .= ", reviewed_by=?, review_note=NULL"; $params[] = $user['id']; }
            $sql .= " WHERE id=?"; $params[] = $id;
            $pdo->prepare($sql)->execute($params);
            log_activity($user, 'updated department', $name);
        } else {
            $sql = "INSERT INTO departments (name, group_type, description, icon, image, link_url, sort_order, status, author_id" . ($status === 'published' ? ', reviewed_by' : '') . ") VALUES (?,?,?,?,?,?,?,?,?" . ($status === 'published' ? ',?' : '') . ")";
            $params = [$name, $groupType, $description, $icon, $imagePath, $linkUrl, $sortOrder, $status, $user['id']];
            if ($status === 'published') $params[] = $user['id'];
            $pdo->prepare($sql)->execute($params);
            log_activity($user, 'added department', $name);
        }
        flash('success', 'Department saved.');
        header('Location: departments.php');
        exit;
    }
}

$pageTitle = $id ? 'Edit Department' : 'Add Department';
$activeNav = 'departments';
require __DIR__ . '/includes/header.php';
?>

<a href="departments.php" class="text-sm text-on-surface-variant hover:text-primary flex items-center gap-1 mb-4">
  <span class="material-symbols-outlined text-[18px]">arrow_back</span> Back to Departments
</a>

<?php if ($errors): ?>
  <div class="mb-5 bg-error-container text-on-error-container text-sm rounded-lg px-4 py-3">
    <ul class="list-disc pl-5"><?php foreach ($errors as $err) echo '<li>' . e($err) . '</li>'; ?></ul>
  </div>
<?php endif; ?>
<?php if ($item['status'] === 'rejected' && $item['review_note']): ?>
  <div class="mb-5 bg-error-container text-on-error-container text-sm rounded-lg px-4 py-3 flex items-start gap-2">
    <span class="material-symbols-outlined text-[18px] shrink-0">feedback</span>
    <div><strong>Reviewer feedback:</strong> <?= e($item['review_note']) ?></div>
  </div>
<?php elseif ($item['status'] === 'pending'): ?>
  <div class="mb-5 bg-secondary-container text-on-secondary-container text-sm rounded-lg px-4 py-3 flex items-center gap-2">
    <span class="material-symbols-outlined text-[18px]">pending</span>
    This item is currently with the Editor for review.
  </div>
<?php elseif ($item['status'] === 'approved'): ?>
  <div class="mb-5 bg-tertiary-container text-on-tertiary-container text-sm rounded-lg px-4 py-3 flex items-center gap-2">
    <span class="material-symbols-outlined text-[18px]">thumb_up</span>
    Approved by an Editor — waiting for the Chief Editor to publish.
  </div>
<?php endif; ?>

<!-- Workflow guide -->
<div class="mb-6 bg-surface-container-low rounded-xl px-5 py-3 flex flex-wrap gap-4 text-xs text-on-surface-variant items-center">
  <span class="font-semibold text-on-surface text-sm">Workflow:</span>
  <span><span class="font-medium">1</span> Sub Editor saves draft &amp; submits</span>
  <span>→</span>
  <span><span class="font-medium">2</span> Editor approves</span>
  <span>→</span>
  <span><span class="font-medium">3</span> Chief Editor publishes</span>
</div>

<form method="post" enctype="multipart/form-data" class="bg-white border border-outline-variant rounded-xl p-6 max-w-2xl">
  <?= csrf_field() ?>

  <label class="block text-sm font-medium mb-1">Department name</label>
  <input name="name" required value="<?= e($item['name']) ?>" class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none">

  <div class="grid grid-cols-2 gap-4 mb-4">
    <div>
      <label class="block text-sm font-medium mb-1">Group</label>
      <select name="group_type" class="w-full rounded-lg border border-outline-variant px-4 py-2.5">
        <option value="core" <?= $item['group_type'] === 'core' ? 'selected' : '' ?>>Core department</option>
        <option value="support" <?= $item['group_type'] === 'support' ? 'selected' : '' ?>>Support department</option>
      </select>
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Display order</label>
      <input type="number" name="sort_order" value="<?= e((string)$item['sort_order']) ?>" class="w-full rounded-lg border border-outline-variant px-4 py-2.5">
    </div>
  </div>

  <label class="block text-sm font-medium mb-1">Icon badge</label>
  <select name="icon" class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5">
    <?php foreach ($iconOptions as $opt): ?>
      <option value="<?= e($opt) ?>" <?= $item['icon'] === $opt ? 'selected' : '' ?>><?= e(str_replace('_', ' ', $opt)) ?></option>
    <?php endforeach; ?>
  </select>

  <label class="block text-sm font-medium mb-1">Description</label>
  <textarea name="description" rows="3" class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none"><?= e($item['description']) ?></textarea>

  <label class="block text-sm font-medium mb-1">Link URL <span class="text-on-surface-variant font-normal">(optional - to a dedicated department page)</span></label>
  <input name="link_url" value="<?= e($item['link_url']) ?>" class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none">

  <label class="block text-sm font-medium mb-1">Image</label>
  <?php if ($item['image']): ?><img src="../<?= e($item['image']) ?>" class="h-24 rounded-lg mb-2 object-cover"><?php endif; ?>
  <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" class="w-full mb-6 text-sm">

  <!-- Role-aware save buttons + preview -->
  <div class="flex flex-wrap gap-3 pt-4 border-t border-outline-variant items-center">
    <button type="submit" name="form_action" value="draft"
            class="px-4 py-2 rounded-lg border border-outline-variant text-sm font-semibold hover:bg-surface-container-low">
      Save as draft
    </button>

    <?php if (['role'] === 'sub_editor'): ?>
      <button type="submit" name="form_action" value="submit"
              class="px-4 py-2 rounded-lg bg-secondary-container text-on-secondary-container text-sm font-semibold hover:opacity-90 flex items-center gap-1">
        <span class="material-symbols-outlined text-[16px]">send</span> Submit for Editor review
      </button>
    <?php elseif (['role'] === 'editor'): ?>
      <button type="submit" name="form_action" value="approve"
              class="px-4 py-2 rounded-lg bg-tertiary-container text-on-tertiary-container text-sm font-semibold hover:opacity-90 flex items-center gap-1">
        <span class="material-symbols-outlined text-[16px]">thumb_up</span> Save &amp; Approve
      </button>
    <?php else: ?>
      <button type="submit" name="form_action" value="publish"
              class="px-4 py-2 rounded-lg bg-primary text-on-primary text-sm font-semibold hover:opacity-90 flex items-center gap-1">
        <span class="material-symbols-outlined text-[16px]">rocket_launch</span> Save &amp; Publish
      </button>
    <?php endif; ?>

    <?php if ($id): ?>
      <a href="preview.php?type=department&id=<?= $id ?>" target="_blank"
         class="ml-auto px-4 py-2 rounded-lg border border-outline-variant text-sm font-semibold hover:bg-surface-container-low flex items-center gap-1.5 text-on-surface-variant">
        <span class="material-symbols-outlined text-[18px]">preview</span> Preview
      </a>
    <?php endif; ?>
  </div>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
