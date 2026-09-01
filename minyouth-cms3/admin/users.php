<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('chief_editor');
$pdo = get_db();
$user = current_user();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id = (int)($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';

    if ($action === 'toggle_status' && $id) {
        if ($id === (int)$user['id']) {
            flash('error', "You can't deactivate your own account.");
        } else {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
            $stmt->execute([$id]);
            $target = $stmt->fetch();
            if ($target) {
                $newStatus = $target['status'] === 'active' ? 'inactive' : 'active';
                // Don't allow deactivating the last active chief editor
                if ($newStatus === 'inactive' && $target['role'] === 'chief_editor') {
                    $activeChiefEditors = $pdo->query("SELECT COUNT(*) c FROM users WHERE role='chief_editor' AND status='active'")->fetch()['c'];
                    if ((int)$activeChiefEditors <= 1) {
                        flash('error', 'At least one active Chief Editor account must remain.');
                        header('Location: users.php');
                        exit;
                    }
                }
                $pdo->prepare('UPDATE users SET status=? WHERE id=?')->execute([$newStatus, $id]);
                log_activity($user, $newStatus === 'active' ? 'reactivated user' : 'deactivated user', $target['username']);
                flash('success', 'Account ' . ($newStatus === 'active' ? 'reactivated' : 'deactivated') . '.');
            }
        }
    }
    header('Location: users.php');
    exit;
}

$users = $pdo->query('SELECT * FROM users ORDER BY role, full_name')->fetchAll();

$pageTitle = 'Users';
$activeNav = 'users';
require __DIR__ . '/includes/header.php';
?>

<div class="flex items-center justify-between mb-6">
  <p class="text-on-surface-variant text-sm">Chief Editors have full control including user management. Editors can publish/reject content. Sub Editors can draft and submit content for review.</p>
  <a href="users_form.php" class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-1.5 hover:opacity-90 shrink-0">
    <span class="material-symbols-outlined text-[18px]">person_add</span> New account
  </a>
</div>

<div class="bg-white border border-outline-variant rounded-xl overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-surface-container-low text-on-surface-variant text-left">
      <tr><th class="px-4 py-3 font-medium">Name</th><th class="px-4 py-3 font-medium">Username</th><th class="px-4 py-3 font-medium">Email</th><th class="px-4 py-3 font-medium">Role</th><th class="px-4 py-3 font-medium">Status</th><th class="px-4 py-3 font-medium">Last login</th><th class="px-4 py-3 font-medium text-right">Actions</th></tr>
    </thead>
    <tbody class="divide-y divide-outline-variant">
      <?php foreach ($users as $u): ?>
        <tr class="hover:bg-surface-container-low/50">
          <td class="px-4 py-3 font-medium"><?= e($u['full_name']) ?> <?= (int)$u['id'] === (int)$user['id'] ? '<span class="text-xs text-on-surface-variant">(you)</span>' : '' ?></td>
          <td class="px-4 py-3 text-on-surface-variant"><?= e($u['username']) ?></td>
          <td class="px-4 py-3 text-on-surface-variant"><?= e($u['email']) ?></td>
          <td class="px-4 py-3">
            <span class="text-xs font-semibold uppercase tracking-wide px-2.5 py-1 rounded-full <?= role_badge_classes($u['role']) ?>">
              <?= role_label($u['role']) ?>
            </span>
          </td>
          <td class="px-4 py-3">
            <span class="text-xs font-semibold px-2.5 py-1 rounded-full <?= $u['status'] === 'active' ? 'bg-primary-container text-on-primary-container' : 'bg-error-container text-on-error-container' ?> capitalize"><?= e($u['status']) ?></span>
          </td>
          <td class="px-4 py-3 text-on-surface-variant whitespace-nowrap"><?= format_date($u['last_login']) ?></td>
          <td class="px-4 py-3 text-right">
            <div class="flex justify-end gap-1">
              <a href="users_form.php?id=<?= $u['id'] ?>" class="p-1.5 rounded hover:bg-surface-container-high" title="Edit"><span class="material-symbols-outlined text-[18px]">edit</span></a>
              <?php if ((int)$u['id'] !== (int)$user['id']): ?>
                <form method="post" onsubmit="return confirm('<?= $u['status'] === 'active' ? 'Deactivate' : 'Reactivate' ?> this account?');">
                  <?= csrf_field() ?><input type="hidden" name="id" value="<?= $u['id'] ?>"><input type="hidden" name="action" value="toggle_status">
                  <button class="p-1.5 rounded hover:bg-error-container text-error" title="<?= $u['status'] === 'active' ? 'Deactivate' : 'Reactivate' ?>">
                    <span class="material-symbols-outlined text-[18px]"><?= $u['status'] === 'active' ? 'block' : 'restart_alt' ?></span>
                  </button>
                </form>
              <?php endif; ?>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
