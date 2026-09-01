<?php
require_once __DIR__ . '/../includes/auth.php';

if (current_user()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = (string)($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Please enter both your username and password.';
    } elseif (attempt_login($username, $password)) {
        $redirect = $_SESSION['redirect_after_login'] ?? 'index.php';
        unset($_SESSION['redirect_after_login']);
        header('Location: ' . $redirect);
        exit;
    } else {
        $error = 'Incorrect username or password, or this account has been deactivated.';
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | Ministry of Youth Empowerment</title>
<link rel="icon" type="image/png" href="../assets/icon.png">
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: { extend: {
      colors: { primary: "#008000", "on-primary": "#ffffff", background: "#fcf9f8",
        "on-surface": "#1c1b1b", "on-surface-variant": "#3e4a41", error: "#ba1a1a",
        "error-container": "#ffdad6", "on-error-container": "#93000a",
        "outline-variant": "#bdcabe", "surface-container-low": "#f6f3f2" },
      fontFamily: { sans: ["Poppins", "sans-serif"] }
    }}
  };
</script>
<style>
  body { font-family: 'Poppins', sans-serif; }
  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400; }
</style>
</head>
<body class="bg-background min-h-screen flex items-center justify-center p-6">
  <div class="w-full max-w-md">
    <div class="text-center mb-8">
      <img src="../assets/logo.png" alt="Ministry logo" class="h-16 mx-auto mb-3">
      <h1 class="text-xl font-semibold text-on-surface">Ministry of Youth Empowerment</h1>
      <p class="text-on-surface-variant text-sm">Content admin sign in</p>
    </div>

    <div class="bg-white border border-outline-variant rounded-xl shadow-sm p-8">
      <?php if ($error): ?>
        <div class="mb-5 flex items-start gap-2 bg-error-container text-on-error-container text-sm rounded-lg px-4 py-3">
          <span class="material-symbols-outlined text-[18px]">error</span>
          <span><?= e($error) ?></span>
        </div>
      <?php endif; ?>

      <form method="post" novalidate>
        <?= csrf_field() ?>
        <label class="block text-sm font-medium text-on-surface mb-1" for="username">Username</label>
        <input id="username" name="username" type="text" required autofocus
               class="w-full mb-4 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none"
               value="<?= e($_POST['username'] ?? '') ?>">

        <label class="block text-sm font-medium text-on-surface mb-1" for="password">Password</label>
        <input id="password" name="password" type="password" required
               class="w-full mb-6 rounded-lg border border-outline-variant px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none">

        <button type="submit"
                class="w-full bg-primary text-on-primary font-semibold py-2.5 rounded-lg hover:opacity-90 transition active:scale-[0.98]">
          Sign in
        </button>
      </form>
    </div>

    <p class="text-center text-xs text-on-surface-variant mt-6">
      <a href="../index.php" class="hover:text-primary">&larr; Back to the public website</a>
    </p>
  </div>
</body>
</html>
