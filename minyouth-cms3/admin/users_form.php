<?php
require_once __DIR__ . '/../includes/auth.php';
require_role('chief_editor');
$pdo = get_db();
$user = current_user();

$id = (int)($_GET['id'] ?? 0);
$item = ['id' => 0, 'full_name' => '', 'username' => '', 'email' => '', 'role' => 'sub_editor', 'status' => 'active'];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$id]);
    $found = $stmt->fetch();
    if (!$found) { flash('error', 'Account not found.'); header('Location: users.php'); exit; }
    $item = $found;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $fullName = trim($_POST['full_name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'sub_editor';
    $password = (string)($_POST['password'] ?? '');

    if ($fullName === '') $errors[] = 'Full name is required.';
    if (!preg_match('/^[a-zA-Z0-9_.]{3,60}$/', $username)) $errors[] = 'Username must be 3-60 characters (letters, numbers, dot, underscore).';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email address is required.';
    if (!in_array($role, ['chief_editor', 'editor', 'sub_editor'], true)) $errors[] = 'Invalid role.';
    if (!$id && $password === '') $errors[] = 'A password is required for new accounts.';
    if ($password !== '' && strlen($password) < 8) $errors[] = 'Password must be at least 8 characters.';

    if (!$errors) {
        $dupStmt = $pdo->prepare('SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?');
        $dupStmt->execute([$username, $email, $id]);
        if ($dupStmt->fetch()) $errors[] = 'That username or email is already in use.';
    }

    if (!$errors) {
        if ($id) {
            $sql = 'UPDATE users SET full_name=?, username=?, email=?, role=?';
            $params = [$fullName, $username, $email, $role];
            if ($password !== '') { $sql .= ', password_hash=?'; $params[] = password_hash($password, PASSWORD_DEFAULT); }
            $sql .= ' WHERE id=?';
            $params[] = $id;
            $pdo->prepare($sql)->execute($params);
            log_activity($user, 'updated user account', $username);
        } else {
            $stmt = $pdo->prepare('INSERT INTO users (full_name, username, email, password_hash, role, status) VALUES (?,?,?,?,?,"active")');
            $stmt->execute([$fullName, $username, $email, password_hash($password, PASSWORD_DEFAULT), $role]);
            log_activity($user, 'created user account', $username . ' (' . $role . ')');
        }
        flash('success', 'Account saved.');
        header('Location: users.php');
        exit;
    }
}

$pageTitle = $id ? 'Edit Account' : 'New Account';
$activeNav = 'users';
require __DIR__ . '/includes/header.php';
?>

<a href="users.php" class="text-sm text-on-surface-variant hover:text-primary flex items-center gap-1 mb-4">
  <span class="material-symbols-outlined text-[18px]">arrow_back</span> Back to Users
</a>

<?php if ($errors): ?>
  <div class="mb-5 bg-error-container text-on-error-container text-sm rounded-lg px-4 py-3">
    <ul class="list-disc pl-5"><?php foreach ($errors as $err) echo '<li>' . e($err) . '</li>'; ?></ul>
  </div>
<?php endif; ?>

<form method="post" class="bg-white border border-outline-variant rounded-xl p-6 max-w-xl">
  <?= csrf_field() ?>

  <label class="block text-sm font-medium mb-1">Full name</label>
  <input name="full_name" required value="<?= e($item['full_name']) ?>" class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none">

  <div class="grid grid-cols-2 gap-4 mb-4">
    <div>
      <label class="block text-sm font-medium mb-1">Username</label>
      <input name="username" required value="<?= e($item['username']) ?>" class="w-full rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none">
    </div>
    <div>
      <label class="block text-sm font-medium mb-1">Role</label>
      <select name="role" class="w-full rounded-lg border border-outline-variant px-4 py-2.5" <?= (int)$item['id'] === (int)$user['id'] ? 'disabled' : '' ?>>
        <option value="chief_editor" <?= $item['role'] === 'chief_editor' ? 'selected' : '' ?>>Chief Editor</option>
        <option value="editor"       <?= $item['role'] === 'editor'       ? 'selected' : '' ?>>Editor</option>
        <option value="sub_editor"   <?= $item['role'] === 'sub_editor'   ? 'selected' : '' ?>>Sub Editor</option>
      </select>
      <?php if ((int)$item['id'] === (int)$user['id']): ?>
        <input type="hidden" name="role" value="<?= e($item['role']) ?>">
        <p class="text-xs text-on-surface-variant mt-1">You can't change your own role.</p>
      <?php endif; ?>
    </div>
  </div>

  <label class="block text-sm font-medium mb-1">Email</label>
  <input type="email" name="email" required value="<?= e($item['email']) ?>" class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none">

  <label class="block text-sm font-medium mb-1"><?= $id ? 'Reset password' : 'Password' ?></label>
  <input type="password" name="password" placeholder="<?= $id ? 'Leave blank to keep current password' : 'Minimum 8 characters' ?>" class="w-full mb-6 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary outline-none">

  <button type="submit" class="px-4 py-2 rounded-lg bg-primary text-on-primary text-sm font-semibold hover:opacity-90">Save account</button>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
