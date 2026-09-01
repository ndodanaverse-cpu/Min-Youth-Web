<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$pdo = get_db();
$user = current_user();

$id = (int)($_GET['id'] ?? 0);
$item = ['id' => 0, 'title' => '', 'description' => '', 'category' => 'General', 'file_path' => '', 'status' => 'draft', 'author_id' => $user['id'], 'review_note' => null];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM resources WHERE id = ?');
    $stmt->execute([$id]);
    $found = $stmt->fetch();
    if (!$found) { flash('error', 'Document not found.'); header('Location: resources.php'); exit; }
    if (!can_edit_item($user, $found)) { flash('error', "You don't have permission to edit that item."); header('Location: resources.php'); exit; }
    $item = $found;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? 'General') ?: 'General';
    $action = $_POST['form_action'] ?? 'draft';

    if ($title === '') $errors[] = 'Title is required.';

    $filePath = $item['file_path'];
    try {
        $uploaded = handle_upload('file', 'resources', ['pdf', 'doc', 'docx', 'xls', 'xlsx'], 20);
        if ($uploaded) {
            if ($filePath) { @unlink(__DIR__ . '/../' . $filePath); }
            $filePath = $uploaded;
        }
    } catch (RuntimeException $e) {
        $errors[] = $e->getMessage();
    }
    if (!$filePath) $errors[] = 'Please upload a document file.';

    if (!$errors) {
        $status = resolve_save_status($action, $user);

        if ($id) {
            $sql = "UPDATE resources SET title=?, description=?, category=?, file_path=?, status=?, updated_at=NOW()";
            $params = [$title, $description, $category, $filePath, $status];
            if ($status === 'published') { $sql .= ", reviewed_by=?, review_note=NULL"; $params[] = $user['id']; }
            $sql .= " WHERE id=?"; $params[] = $id;
            $pdo->prepare($sql)->execute($params);
            log_activity($user, 'updated resource', $title);
        } else {
            $sql = "INSERT INTO resources (title, description, category, file_path, status, author_id" . ($status === 'published' ? ', reviewed_by' : '') . ") VALUES (?,?,?,?,?,?" . ($status === 'published' ? ',?' : '') . ")";
            $params = [$title, $description, $category, $filePath, $status, $user['id']];
            if ($status === 'published') $params[] = $user['id'];
            $pdo->prepare($sql)->execute($params);
            log_activity($user, 'uploaded resource', $title);
        }
        flash('success', 'Document saved.');
        header('Location: resources.php');
        exit;
    }
}

$pageTitle = $id ? 'Edit Document' : 'Upload Document';
$activeNav = 'resources';
require __DIR__ . '/includes/header.php';
?>

<a href="resources.php" class="text-sm text-on-surface-variant hover:text-primary flex items-center gap-1 mb-4">
  <span class="material-symbols-outlined text-[18px]">arrow_back</span> Back to Resources
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

  <label class="block text-sm font-medium mb-1">Document title</label>
  <input name="title" required value="<?= e($item['title']) ?>" class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none">

  <label class="block text-sm font-medium mb-1">Description</label>
  <textarea name="description" rows="3" class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none"><?= e($item['description']) ?></textarea>

  <label class="block text-sm font-medium mb-1">Category</label>
  <input name="category" value="<?= e($item['category']) ?>" placeholder="e.g. Strategy, Policy, Charter" class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none">

  <label class="block text-sm font-medium mb-1">Document file</label>
  <?php if ($item['file_path']): ?>
    <p class="text-sm mb-2"><a href="../<?= e($item['file_path']) ?>" target="_blank" class="text-primary hover:underline">Current file &rarr;</a></p>
  <?php endif; ?>
  <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx" class="w-full mb-6 text-sm">

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
      <a href="preview.php?type=resource&id=<?= $id ?>" target="_blank"
         class="ml-auto px-4 py-2 rounded-lg border border-outline-variant text-sm font-semibold hover:bg-surface-container-low flex items-center gap-1.5 text-on-surface-variant">
        <span class="material-symbols-outlined text-[18px]">preview</span> Preview
      </a>
    <?php endif; ?>
  </div>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
