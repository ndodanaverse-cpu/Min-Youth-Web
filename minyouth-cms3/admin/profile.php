<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$pdo = get_db();
$user = current_user();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $current = (string)($_POST['current_password'] ?? '');
    $new = (string)($_POST['new_password'] ?? '');
    $confirm = (string)($_POST['confirm_password'] ?? '');

    $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = ?');
    $stmt->execute([$user['id']]);
    $hash = $stmt->fetchColumn();

    if (!password_verify($current, $hash)) {
        $errors[] = 'Your current password is incorrect.';
    }
    if (strlen($new) < 8) {
        $errors[] = 'New password must be at least 8 characters.';
    }
    if ($new !== $confirm) {
        $errors[] = 'New password and confirmation do not match.';
    }

    if (!$errors) {
        $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?')
            ->execute([password_hash($new, PASSWORD_DEFAULT), $user['id']]);
        log_activity($user, 'changed their password');
        flash('success', 'Password updated.');
        header('Location: profile.php');
        exit;
    }
}

$pageTitle = 'My Profile';
$activeNav = 'profile';
require __DIR__ . '/includes/header.php';
?>

<div class="bg-white border border-outline-variant rounded-xl p-6 max-w-lg mb-6">
  <h2 class="font-semibold mb-4">Account details</h2>
  <dl class="text-sm space-y-2">
    <div class="flex justify-between"><dt class="text-on-surface-variant">Full name</dt><dd class="font-medium"><?= e($user['full_name']) ?></dd></div>
    <div class="flex justify-between"><dt class="text-on-surface-variant">Username</dt><dd class="font-medium"><?= e($user['username']) ?></dd></div>
    <div class="flex justify-between"><dt class="text-on-surface-variant">Email</dt><dd class="font-medium"><?= e($user['email']) ?></dd></div>
    <div class="flex justify-between"><dt class="text-on-surface-variant">Role</dt><dd class="font-medium"><?= $user['role'] === 'editor' ? 'Editor' : 'Sub Editor' ?></dd></div>
  </dl>
</div>

<div class="bg-white border border-outline-variant rounded-xl p-6 max-w-lg">
  <h2 class="font-semibold mb-4">Change password</h2>

  <?php if ($errors): ?>
    <div class="mb-5 bg-error-container text-on-error-container text-sm rounded-lg px-4 py-3">
      <ul class="list-disc pl-5"><?php foreach ($errors as $err) echo '<li>' . e($err) . '</li>'; ?></ul>
    </div>
  <?php endif; ?>

  <form method="post">
    <?= csrf_field() ?>
    <label class="block text-sm font-medium mb-1">Current password</label>
    <input type="password" name="current_password" required class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none">

    <label class="block text-sm font-medium mb-1">New password</label>
    <input type="password" name="new_password" required minlength="8" class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none">

    <label class="block text-sm font-medium mb-1">Confirm new password</label>
    <input type="password" name="confirm_password" required minlength="8" class="w-full mb-6 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none">

    <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary text-sm font-semibold hover:opacity-90">Update password</button>
  </form>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
