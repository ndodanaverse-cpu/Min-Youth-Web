<?php
/**
 * Shared admin chrome. Include after require_login()/require_role().
 * The including page should set:
 *   $pageTitle  (string, shown in <title> and the page header)
 *   $activeNav  (string key matching one of the $navItems below)
 */
$user = current_user();
$flash = get_flash();
$pageTitle = $pageTitle ?? 'Admin';
$activeNav = $activeNav ?? '';

$navItems = [
    'dashboard'   => ['label' => 'Dashboard',   'icon' => 'space_dashboard', 'href' => 'index.php',       'roles' => ['chief_editor','editor','sub_editor']],
    'news'        => ['label' => 'News',        'icon' => 'newspaper',       'href' => 'news.php',        'roles' => ['chief_editor','editor','sub_editor']],
    'gallery'     => ['label' => 'Gallery',     'icon' => 'photo_library',   'href' => 'gallery.php',     'roles' => ['chief_editor','editor','sub_editor']],
    'resources'   => ['label' => 'Resources',   'icon' => 'description',     'href' => 'resources.php',   'roles' => ['chief_editor','editor','sub_editor']],
    'departments' => ['label' => 'Departments', 'icon' => 'apartment',       'href' => 'departments.php', 'roles' => ['chief_editor','editor','sub_editor']],
    'users'       => ['label' => 'Users',       'icon' => 'group',           'href' => 'users.php',       'roles' => ['chief_editor']],
    'translations'=> ['label' => 'Translations','icon' => 'translate',       'href' => 'translations.php','roles' => ['chief_editor','editor']],
    'chatbot'     => ['label' => 'Chatbot',     'icon' => 'smart_toy',       'href' => 'chatbot.php',     'roles' => ['chief_editor']],
];
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle) ?> | Admin | Ministry of Youth Empowerment</title>
<link rel="icon" type="image/png" href="../assets/icon.png">
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: { extend: {
      colors: {
        primary: "#008000", "on-primary": "#ffffff", "primary-container": "#d7f0d7", "on-primary-container": "#00522f",
        secondary: "#6e5c00", "secondary-container": "#fcd400", "on-secondary-container": "#6e5c00",
        tertiary: "#006496", "tertiary-container": "#cce5ff", "on-tertiary-container": "#001e30",
        error: "#ba1a1a", "error-container": "#ffdad6", "on-error-container": "#93000a",
        background: "#fcf9f8", surface: "#fcf9f8",
        "on-surface": "#1c1b1b", "on-surface-variant": "#3e4a41",
        "surface-container": "#f0eded", "surface-container-low": "#f6f3f2", "surface-container-high": "#eae7e7",
        "outline-variant": "#bdcabe", outline: "#6e7a70"
      },
      fontFamily: { sans: ["Poppins", "sans-serif"] },
      fontSize: {
        "label-sm": ["12px", { lineHeight: "16px" }],
      }
    }}
  };
</script>
<style>
  body { font-family: 'Poppins', sans-serif; }
  .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400; font-size: 20px; vertical-align: middle; }
  .nav-link.active { background: #d7f0d7; color: #00522f; font-weight: 600; }
  #sidebar { transition: transform .25s ease; }
  @media (max-width: 768px) {
    #sidebar { position: fixed; inset: 0 25% 0 0; transform: translateX(-100%); z-index: 50; }
    #sidebar.open { transform: translateX(0); }
  }
</style>
</head>
<body class="bg-background text-on-surface min-h-screen flex">

<!-- Sidebar -->
<aside id="sidebar" class="w-64 bg-white border-r border-outline-variant flex flex-col">
  <div class="flex items-center gap-2 px-5 h-16 border-b border-outline-variant">
    <img src="../assets/logo.png" alt="Logo" class="h-8 w-auto">
    <span class="font-semibold text-sm leading-tight">MinYouth<br><span class="text-on-surface-variant font-normal text-xs">Content Admin</span></span>
  </div>
  <nav class="flex-1 py-4 px-3 space-y-1 overflow-y-auto">
    <?php foreach ($navItems as $key => $navItem): ?>
      <?php if (!in_array($user['role'], $navItem['roles'], true)) continue; ?>
      <a href="<?= e($navItem['href']) ?>"
         class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-on-surface-variant hover:bg-surface-container-low transition <?= $activeNav === $key ? 'active' : '' ?>">
        <span class="material-symbols-outlined"><?= $navItem['icon'] ?></span>
        <?= e($navItem['label']) ?>
      </a>
    <?php endforeach; ?>
  </nav>
  <div class="border-t border-outline-variant p-3">
    <a href="../index.php" target="_blank"
       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-on-surface-variant hover:bg-surface-container-low transition mb-1">
      <span class="material-symbols-outlined">open_in_new</span> Visit website
    </a>
    <a href="profile.php" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-on-surface-variant hover:bg-surface-container-low transition <?= $activeNav === 'profile' ? 'active' : '' ?>">
      <span class="material-symbols-outlined">person</span> My profile
    </a>
    <a href="logout.php" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-error hover:bg-error-container transition">
      <span class="material-symbols-outlined">logout</span> Sign out &amp; go to site
    </a>
  </div>
</aside>

<!-- Mobile overlay -->
<div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/40 z-40"></div>

<div class="flex-1 flex flex-col min-w-0">
  <!-- Topbar -->
  <header class="h-16 bg-white border-b border-outline-variant flex items-center justify-between px-4 md:px-8">
    <div class="flex items-center gap-3">
      <button id="sidebar-toggle" class="md:hidden text-on-surface-variant">
        <span class="material-symbols-outlined">menu</span>
      </button>
      <h1 class="text-lg font-semibold"><?= e($pageTitle) ?></h1>
    </div>
    <div class="flex items-center gap-3">
      <span class="hidden sm:inline-block text-xs font-semibold uppercase tracking-wide px-2.5 py-1 rounded-full <?= role_badge_classes($user['role']) ?>">
        <?= role_label($user['role']) ?>
      </span>
      <span class="text-sm text-on-surface-variant hidden sm:inline"><?= e($user['full_name']) ?></span>
      <div class="w-9 h-9 rounded-full bg-primary text-on-primary flex items-center justify-center font-semibold text-sm">
        <?= e(strtoupper(substr($user['full_name'], 0, 1))) ?>
      </div>
    </div>
  </header>

  <main class="flex-1 p-4 md:p-8 overflow-y-auto">
    <?php if ($flash): ?>
      <div class="mb-6 flex items-start gap-2 rounded-lg px-4 py-3 text-sm <?= $flash['type'] === 'error' ? 'bg-error-container text-on-error-container' : 'bg-primary-container text-on-primary-container' ?>">
        <span class="material-symbols-outlined text-[18px]"><?= $flash['type'] === 'error' ? 'error' : 'check_circle' ?></span>
        <span><?= e($flash['message']) ?></span>
      </div>
    <?php endif; ?>
