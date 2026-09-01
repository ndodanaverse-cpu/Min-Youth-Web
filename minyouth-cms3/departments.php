<?php
require_once __DIR__ . '/includes/lang.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$pdo = get_db();
$_lang = $GLOBALS['current_lang'] ?? 'en';
$_dtrans = [];
if ($_lang !== 'en') {
    $_ts = $pdo->prepare("SELECT content_id,field_name,field_value FROM content_translations WHERE content_type='departments' AND language=?");
    $_ts->execute([$_lang]);
    foreach($_ts->fetchAll() as $_t) $_dtrans[$_t['content_id']][$_t['field_name']] = $_t['field_value'];
}
$allDepts = $pdo->query(
    "SELECT * FROM departments WHERE status = 'published' ORDER BY group_type, sort_order, name"
)->fetchAll();
$coreDepts = array_values(array_filter($allDepts, fn($d) => $d['group_type'] === 'core'));
$supportDepts = array_values(array_filter($allDepts, fn($d) => $d['group_type'] === 'support'));

function dept_link(array $d): string {
    return $d['link_url'] ?: '#';
}
?>

<!DOCTYPE html>

<html class="scroll-smooth" lang="<?= e($GLOBALS['current_lang'] ?? 'en') ?>"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<!-- Standard Favicon for Browser Tabs (ICO file) -->
<link rel="icon" type="image/x-icon" href="assets/icon.png">

<!-- Modern, High-Quality Icon for Modern Browsers (PNG file) -->
<link rel="icon" type="image/png" sizes="32x32" href="assets/icon.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/icon.png">

<!-- Apple Touch Icon for iOS Devices (iPhones/iPads) -->
<link rel="apple-touch-icon" sizes="180x180" href="assets/icon.png">

<!-- Android/Chrome Web App Manifest -->
<link rel="manifest" href="assets/site.webmanifest">

<title><?= __('home_departments_title') ?> | <?= __('site_title') ?></title>

<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-primary": "#72de5e",
                        "background": "#f9f9ff",
                        "primary-fixed-dim": "#72de5e",
                        "outline": "#6f7a69",
                        "tertiary-container": "#677069",
                        "surface-dim": "#d3daea",
                        "on-surface": "#151c27",
                        "secondary-container": "#e2dfe0",
                        "surface-container-lowest": "#ffffff",
                        "secondary": "#5f5e5f",
                        "on-secondary-fixed": "#1b1b1c",
                        "on-tertiary-fixed": "#151d18",
                        "on-primary-fixed-variant": "#005300",
                        "error-container": "#ffdad6",
                        "surface-tint": "#006e00",
                        "surface-container": "#e7eefe",
                        "secondary-fixed": "#e5e2e3",
                        "on-error": "#ffffff",
                        "surface-container-low": "#f0f3ff",
                        "surface-container-high": "#e2e8f8",
                        "surface-variant": "#dce2f3",
                        "on-surface-variant": "#3f4a3a",
                        "primary-fixed": "#8dfb77",
                        "on-primary-container": "#ccffba",
                        "surface-bright": "#f9f9ff",
                        "on-tertiary-fixed-variant": "#404943",
                        "inverse-on-surface": "#ebf1ff",
                        "surface-container-highest": "#dce2f3",
                        "on-background": "#151c27",
                        "inverse-surface": "#2a313d",
                        "on-secondary": "#ffffff",
                        "outline-variant": "#becab6",
                        "on-secondary-fixed-variant": "#474647",
                        "error": "#ba1a1a",
                        "surface": "#f9f9ff",
                        "on-primary-fixed": "#002200",
                        "primary": "#008000",
                        "on-secondary-container": "#636263",
                        "on-error-container": "#93000a",
                        "tertiary-fixed-dim": "#c0c9c0",
                        "on-tertiary": "#ffffff",
                        "tertiary": "#4f5851",
                        "tertiary-fixed": "#dce5dc",
                        "primary-container": "#008000",
                        "on-primary": "#ffffff",
                        "on-tertiary-container": "#ebf4eb",
                        "secondary-fixed-dim": "#c8c6c7"
                    },
                   "borderRadius": {
                        "DEFAULT": "0.5rem",  // 8px - Clean, modern curve for standard cards
                        "lg": "0.75rem",     // 12px - More pronounced rounding
                        "xl": "1rem",        // 16px - Highly visible, soft curved edges
                        "full": "9999px"
                    },
                    "spacing": {
                        "gutter": "24px",
                        "md": "16px",
                        "margin-mobile": "16px",
                        "xl": "40px",
                        "sm": "8px",
                        "margin-desktop": "64px",
                        "lg": "24px",
                        "base": "4px",
                        "xs": "4px"
                    },
                    "fontFamily": {
                        "headline-xl": ["Poppins"],
                        "headline-lg-mobile": ["Poppins"],
                        "headline-xl-mobile": ["Poppins"],
                        "body-md": ["Poppins"],
                        "label-sm": ["Poppins"],
                        "label-md": ["Poppins"],
                        "headline-lg": ["Poppins"],
                        "body-lg": ["Poppins"],
                        "headline-md": ["Poppins"],
                        "title-lg": ["Poppins"]
                    },
                    "fontSize": {
                        "headline-xl": ["40px", {"lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-lg-mobile": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "headline-xl-mobile": ["30px", {"lineHeight": "36px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.02em", "fontWeight": "500"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.01em", "fontWeight": "500"}],
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "title-lg": ["20px", {"lineHeight": "28px", "fontWeight": "500"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}]
                    }
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .department-card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .department-card-hover:hover {
            transform: translateY(-8px);
        }
        .department-card-hover:hover .icon-badge {
            transform: translateY(-4px) scale(1.1);
            background-color: #008000;
            color: #ffffff;
        }
        .text-shadow-sm {
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .stagger-item {
            opacity: 0;
            transform: translateY(20px);
        }
        .active .stagger-item {
            opacity: 1;
            transform: translateY(0);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* Grid alignment helpers */
        .grid-container {
            width: 100%;
            max-width: 80rem; /* 1280px */
            margin-left: auto;
            margin-right: auto;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
        @media (min-width: 1024px) {
            .grid-container {
                padding-left: 4rem;
                padding-right: 4rem;
            }
        }
            /* Full-screen mobile menu overlay */
        #mobile-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fcf9f8;
            z-index: 999;
            transform: translateX(-100%);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            padding-top: 80px;
        }
        #mobile-menu.open {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md selection:bg-primary-fixed selection:text-on-primary-fixed">
<!-- TopNavBar -->
<header class="bg-surface docked full-width top-0 sticky border-b border-outline-variant shadow-sm z-50 transition-all duration-300">
<nav class="flex justify-between items-center px-margin-mobile md:px-margin-desktop py-base w-full max-w-7xl mx-auto">
<div class="flex items-center gap-base">
<img alt="Zimbabwe Government Logo" class="h-8 md:h-16 w-auto transition-transform hover:scale-105" src="assets/logo.png"/>
</div>
<div class="hidden md:flex items-center gap-md">
<a class="text-on-surface-variant font-medium hover:text-primary transition-all relative group py-1" href="index.php">
                Home
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
</a>
<a class="text-on-surface-variant font-medium hover:text-primary transition-all relative group py-1" href="about.php">
<?= __('nav_about') ?>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
</a>
<a class="text-primary font-bold border-b-2 border-primary pb-1 transition-colors" href="departments.php" style="color: #008000;"><?= __('nav_departments') ?></a>
<div class="relative group">
<a class="text-on-surface-variant font-medium hover:text-primary transition-all relative py-1 inline-flex items-center gap-1" href="resources.php">
<?= __('nav_resources') ?> <span aria-hidden="true">&#9662;</span>
</a>
<div class="absolute left-0 top-full hidden min-w-36 pt-2 group-hover:block group-focus-within:block">
<a class="block bg-surface px-md py-sm text-on-surface-variant font-medium shadow-lg hover:bg-surface-container-high hover:text-primary" href="gallery.php"><?= __('nav_gallery') ?></a>
</div>
</div>
<a class="text-on-surface-variant font-medium hover:text-primary transition-all relative group py-1" href="news.php">
<?= __('nav_news') ?>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
</a>
<a class="text-on-surface-variant font-medium hover:text-primary transition-all relative group py-1" href="contact.php">
<?= __('nav_contact') ?>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
</a>
</div>
<div class="hidden md:flex items-center gap-base">
<a href="http://127.0.0.1:8000" target="_blank" rel="noopener noreferrer" class="bg-primary text-on-primary font-label-md px-md py-xs rounded-lg hover:shadow-lg transition-all active:scale-95 whitespace-nowrap inline-flex items-center justify-center" style="background-color: #008000;">
<?= __('nav_apply') ?>
        </a>
</div>
<?php echo lang_switcher_html('hidden md:flex'); ?>
<button id="menu-toggle" class="md:hidden flex flex-col gap-1 p-2 hover:bg-surface-container rounded-lg transition-colors z-[1000] relative" aria-label="Toggle menu">
<span class="w-6 h-0.5 bg-on-surface transition-all"></span>
<span class="w-6 h-0.5 bg-on-surface transition-all"></span>
<span class="w-6 h-0.5 bg-on-surface transition-all"></span>
</button>
</nav>
</header>
<!-- Full-screen mobile menu -->
<div id="mobile-menu" aria-hidden="true">
<div class="px-margin-mobile py-base space-y-base max-w-7xl mx-auto">
<a class="block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="index.php"><?= __('nav_home') ?></a>
<a class="block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="about.php"><?= __('nav_about') ?></a>
<a class="block text-primary font-bold py-sm px-sm rounded-lg transition-all" href="departments.php" style="color: #008000;"><?= __('nav_departments') ?></a>
<details class="group">
<summary class="cursor-pointer list-none block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all"><?= __('nav_resources') ?> <span aria-hidden="true">&#9662;</span></summary>
<a class="ml-md block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="gallery.php"><?= __('nav_gallery') ?></a>
<a class="ml-md block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="resources.php"><?= __('nav_resources') ?></a>
</details>
<a class="block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="news.php"><?= __('nav_news') ?></a>
<a class="block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="contact.php"><?= __('nav_contact') ?></a>
<a href="http://127.0.0.1:8000" target="_blank" rel="noopener noreferrer" class="w-full bg-primary text-on-primary font-label-md px-md py-sm rounded-lg hover:shadow-lg transition-all active:scale-95 inline-flex items-center justify-center text-center" style="background-color: #008000;">
<?= __('nav_apply') ?>
        </a>
</div>
</div>
<script>
    // Full-screen mobile menu toggle
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    let menuOpen = false;

    menuToggle.addEventListener('click', function() {
        menuOpen = !menuOpen;
        mobileMenu.classList.toggle('open', menuOpen);
        mobileMenu.setAttribute('aria-hidden', !menuOpen);
        document.body.style.overflow = menuOpen ? 'hidden' : '';
        const spans = this.querySelectorAll('span');
        spans[0].style.transform = menuOpen ? 'rotate(45deg) translateY(8px)' : '';
        spans[1].style.opacity = menuOpen ? '0' : '1';
        spans[2].style.transform = menuOpen ? 'rotate(-45deg) translateY(-8px)' : '';
    });

    mobileMenu.querySelectorAll('a').forEach(function(link) {
        link.addEventListener('click', function() {
            menuOpen = false;
            mobileMenu.classList.remove('open');
            mobileMenu.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            const spans = menuToggle.querySelectorAll('span');
            spans[0].style.transform = '';
            spans[1].style.opacity = '1';
            spans[2].style.transform = '';
        });
    });

</script>
<main class="pt-20">
<!-- Hero Section -->
<section class="relative h-64 md:h-80 w-full overflow-hidden">
<div class="absolute inset-0 z-0">
<img alt="Youth development in Zimbabwe" class="w-full h-full object-cover brightness-50 scale-105 animate-[pulse_10s_ease-in-out_infinite]" src="assets/departments/legal.jpg"/>
</div>
<div class="relative z-10 h-full flex flex-col justify-center items-center text-center px-margin-mobile reveal active">
<h2 class="font-display-lg text-display-lg text-white text-shadow-sm mb-base">Departments</h2>
<nav class="flex items-center gap-xs text-white/90 font-label-md text-label-md">
<a class="hover:underline transition-all" href="#"><?= __('nav_home') ?></a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<span class="font-bold">Departments</span>
</nav>
</div>
</section>
<!-- Core Departments Section -->
<section class="py-xl reveal">
<div class="grid-container">
<div class="flex flex-col items-center mb-lg">
<div class="w-12 h-1 bg-primary mb-base transition-all duration-700 hover:w-24"></div>
<h3 class="font-headline-lg text-headline-lg text-primary tracking-widest text-center uppercase">Core Departments</h3>
</div>
<!-- Bento Grid - Core -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-md">
<?php if (!$coreDepts): ?>
<p class="col-span-full text-center text-on-surface-variant py-8"><?= __("no_departments") ?></p>
<?php endif; ?>
<?php foreach ($coreDepts as $d): ?>
<a href="<?= e(dept_link($d)) ?>" class="block cursor-pointer no-underline">
<div class="department-card-hover stagger-item group relative bg-white border border-outline-variant overflow-hidden rounded shadow-sm hover:shadow-xl">
<div class="h-48 overflow-hidden">
<img alt="<?= e($d['name']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" src="<?= e($d['image'] ?: 'assets/departments/youthdevelopment.jpg') ?>"/>
</div>
<div class="p-md relative">
<div class="icon-badge absolute -top-8 right-md w-12 h-12 bg-primary text-on-primary flex items-center justify-center rounded transition-all duration-300 shadow-md">
<span class="material-symbols-outlined"><?= e($d['icon']) ?></span>
</div>
<h4 class="font-title-lg text-title-lg mb-xs group-hover:text-primary transition-colors"><?= e(localized_content_value($_dtrans[$d['id']]['name'] ?? $d['name'])) ?></h4>
<p class="text-on-surface-variant font-body-md text-body-md"><?= e(localized_content_value($_dtrans[$d['id']]['description'] ?? $d['description'])) ?></p>
</div>
</div>
</a>
<?php endforeach; ?>
</div>
</div>
</section>
<!-- Support Departments Section -->
<section class="py-xl bg-surface-container-low reveal">
<div class="grid-container">
<div class="flex flex-col items-center mb-lg">
<div class="w-12 h-1 bg-primary mb-base transition-all duration-700 hover:w-24"></div>
<h3 class="font-headline-lg text-headline-lg text-primary tracking-widest text-center uppercase">Support Departments</h3>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-md">
<?php if (!$supportDepts): ?>
<p class="col-span-full text-center text-on-surface-variant py-8"><?= __("no_departments") ?></p>
<?php endif; ?>
<?php foreach ($supportDepts as $d): ?>
<a href="<?= e(dept_link($d)) ?>" class="flex flex-col h-full cursor-pointer no-underline">
<div class="department-card-hover stagger-item group bg-white border border-outline-variant rounded overflow-hidden shadow-sm hover:shadow-xl flex flex-col h-full">
<div class="h-32 bg-slate-100 flex items-center justify-center relative overflow-hidden">
<img alt="<?= e($d['name']) ?>" class="w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-500" src="<?= e($d['image'] ?: 'assets/departments/commin.jpg') ?>"/>
<div class="icon-badge absolute top-3 right-md w-10 h-10 bg-primary text-on-primary flex items-center justify-center rounded shadow-sm transition-all duration-300">
<span class="material-symbols-outlined text-[20px]"><?= e($d['icon']) ?></span>
</div>
</div>
<div class="p-md pt-base flex-grow">
<h5 class="font-title-lg text-title-lg leading-tight mb-xs group-hover:text-primary transition-colors"><?= e(localized_content_value($_dtrans[$d['id']]['name'] ?? $d['name'])) ?></h5>
<p class="text-on-surface-variant font-label-sm text-label-sm"><?= e(localized_content_value($_dtrans[$d['id']]['description'] ?? $d['description'])) ?></p>
</div>
</div>
</a>
<?php endforeach; ?>
</div>
</div>
</section>
<!-- Gallery/Staff Banner -->
<section class="w-full h-96 relative overflow-hidden reveal">
<img alt="Ministry Staff and Youth" class="w-full h-full object-cover object-top transition-transform duration-1000 hover:scale-105" src="assets/departments/site-footer-img.jpg"/>
<div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent opacity-60"></div>
</section>
<!-- Callout Section -->
<section class="bg-primary py-xl reveal">
<div class="grid-container text-center">
<h2 class="font-headline-lg text-headline-lg text-on-primary mb-md">Our Departments</h2>
<div class="w-16 h-1 bg-white/30 mx-auto mb-md transition-all duration-700 hover:w-32"></div>
<p class="font-body-lg text-body-lg text-on-primary leading-relaxed opacity-95 max-w-4xl mx-auto stagger-item">
                    The Ministry of Youth Empowerment, Development and Vocational Training plays a pivotal role in fostering the growth and development of young people in our nation. Our various departments are dedicated to addressing key aspects of youth empowerment, ensuring a holistic approach to equipping the younger generation with the skills, knowledge, and opportunities needed to thrive in society.
                </p>
<div class="mt-lg stagger-item">
<button class="bg-white text-primary hover:bg-surface-container-high font-bold py-md px-xl rounded-full transition-all flex items-center gap-base mx-auto group shadow-lg hover:-translate-y-1 active:scale-95">
                        Learn More About Us
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
</button>
</div>
</div>
</section>
</main>
<!-- Footer -->
<footer class="bg-[#008000] text-on-primary">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg px-margin-mobile lg:px-margin-desktop py-xl w-full max-w-7xl mx-auto align-middle">
<!-- Brand & Contact -->
<div class="flex flex-col gap-md">
<div class="flex items-center gap-sm">
<img alt="Zimbabwe Coat of Arms" class="h-14 md:h-20 w-auto object-contain invert brightness-0" src="assets/logo.png"/>
</div>
<div class="space-y-sm">
<p class="font-body-md opacity-90">11th Floor Central House, Central Avenue, Harare, Zimbabwe</p>
<div class="flex items-center gap-base opacity-90">
<span class="material-symbols-outlined text-sm">mail</span>
<span>info@youth.gov.zw</span>
</div>
<div class="flex items-center gap-base opacity-90">
<span class="material-symbols-outlined text-sm">call</span>
<span>+263 242 707741</span>
</div>
</div>
<div class="flex flex-wrap gap-md mt-base">
<a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/30 transition-all hover:scale-110" href="#" aria-label="Facebook">
<svg class="w-5 h-5 fill-current" viewbox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path></svg>
</a>
<a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/30 transition-all hover:scale-110" href="#" aria-label="WhatsApp">
<svg class="w-5 h-5 fill-current" viewbox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.513 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.864-9.864.002-2.637-1.03-5.114-2.905-6.99C16.559 1.875 14.09 1.83 11.45 1.83c-5.437 0-9.862 4.421-9.866 9.865-.001 1.761.47 3.483 1.365 5.011L1.92 21.05l4.727-1.24.001-.004-.001-.002zm12.317-5.908c-.3-.15-1.772-.875-2.046-.975-.275-.1-.475-.15-.675.15-.2.3-.775 1.025-.95 1.225-.175.2-.35.225-.65.075-.3-.15-1.265-.467-2.41-1.485-.89-.794-1.49-1.775-1.665-2.075-.175-.3-.02-.463.13-.612.135-.135.3-.35.45-.525.15-.175.2-.3.3-.5s.05-.375-.025-.525c-.075-.15-.675-1.625-.925-2.225-.244-.589-.48-.58-.675-.59-.175-.01-.375-.01-.575-.01-.2 0-.525.075-.8.375-.275.3-1.05 1.025-1.05 2.5s1.025 2.9 1.175 3.1c.15.2 2.013 3.074 4.875 4.31.68.295 1.21.47 1.62.6.685.217 1.31.187 1.805.113.55-.082 1.772-.725 2.022-1.4.25-.675.25-1.25.175-1.375-.075-.125-.275-.2-.575-.35z"/></svg>
</a>
<a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/30 transition-all hover:scale-110" href="#" aria-label="X (Twitter)">
<svg class="w-5 h-5 fill-current" viewbox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
</a>
<a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/30 transition-all hover:scale-110" href="#" aria-label="Instagram">
<svg class="w-5 h-5 fill-current" viewbox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.051.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
</a>
<a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/30 transition-all hover:scale-110" href="#" aria-label="LinkedIn">
<svg class="w-5 h-5 fill-current" viewbox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
</a>
</div>
</div>
<!-- Quick Links -->
<div class="flex flex-col gap-md">
<span class="font-title-lg text-title-lg border-b border-white/20 pb-base"><?= __('footer_quick_links') ?></span>
<div class="flex flex-col gap-sm">
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="index.php"><?= __('nav_home') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="about.php"><?= __('nav_about') ?></a>
<a class="text-on-primary font-bold underline" href="departments.php"><?= __('nav_departments') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="gallery.php"><?= __('nav_gallery') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="resources.php"><?= __('nav_resources') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="news.php"><?= __('nav_news') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="contact.php"><?= __('nav_contact') ?></a>
</div>
</div>
<!-- Resources -->
<div class="flex flex-col gap-md">
<span class="font-title-lg text-title-lg border-b border-white/20 pb-base"><?= __('footer_resources') ?></span>
<div class="flex flex-col gap-sm">
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="#"><?= __('footer_nat_policy') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="#"><?= __('footer_strat_plan') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="#"><?= __('footer_vtc_forms') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="#"><?= __('footer_annual_rep') ?></a>
</div>
</div>
<!-- Newsletter -->
<div class="flex flex-col gap-md">
<span class="font-title-lg text-title-lg border-b border-white/20 pb-base"><?= __('footer_newsletter') ?></span>
<p class="text-sm opacity-90"><?= __('footer_newsletter_sub') ?></p>
<div class="flex flex-col gap-base">
<input class="bg-white/10 border-white/20 rounded-lg px-md py-sm text-white placeholder:text-white/40 focus:ring-primary-fixed focus:border-primary-fixed transition-all" placeholder="<?= __('footer_email_ph') ?>" type="email"/>
<button class="bg-[#ccffba] text-[#002200] font-bold py-sm rounded-lg hover:brightness-110 active:scale-95 transition-all"><?= __('footer_subscribe') ?></button>
</div>
</div>
</div>
<!-- Copyright -->
<div class="border-t border-white/10 py-md text-center text-on-primary/60 font-label-sm">
        <?= __('footer_copyright') ?>
    </div>
</footer>
<!-- WhatsApp Book a Call FAB -->
<style>.wa-fab{position:fixed;bottom:1.5rem;right:1.5rem;z-index:40;display:flex;align-items:center;gap:.5rem;padding:.65rem 1.25rem;background:#25D366;color:#fff;border-radius:9999px;font-weight:700;font-size:14px;box-shadow:0 8px 30px rgba(37,211,102,.45);border:none;cursor:pointer;text-decoration:none;transition:all .3s;font-family:Poppins,sans-serif}.wa-fab:hover{transform:translateY(-3px) scale(1.05);box-shadow:0 12px 40px rgba(37,211,102,.6)}.wa-fab svg{width:22px;height:22px;fill:white;flex-shrink:0}</style>
<a class="wa-fab" href="https://wa.me/263242707741?text=Hello%2C%20I%20would%20like%20to%20book%20a%20call%20with%20the%20Ministry%20of%20Youth%20Empowerment." target="_blank" rel="noopener noreferrer" aria-label="Book a call via WhatsApp">
<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.513 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.864-9.864.002-2.637-1.03-5.114-2.905-6.99C16.559 1.875 14.09 1.83 11.45 1.83c-5.437 0-9.862 4.421-9.866 9.865-.001 1.761.47 3.483 1.365 5.011L1.92 21.05l4.727-1.24zm12.317-5.908c-.3-.15-1.772-.875-2.046-.975-.275-.1-.475-.15-.675.15-.2.3-.775 1.025-.95 1.225-.175.2-.35.225-.65.075-.3-.15-1.265-.467-2.41-1.485-.89-.794-1.49-1.775-1.665-2.075-.175-.3-.02-.463.13-.612.135-.135.3-.35.45-.525.15-.175.2-.3.3-.5s.05-.375-.025-.525c-.075-.15-.675-1.625-.925-2.225-.244-.589-.48-.58-.675-.59-.175-.01-.375-.01-.575-.01-.2 0-.525.075-.8.375-.275.3-1.05 1.025-1.05 2.5s1.025 2.9 1.175 3.1c.15.2 2.013 3.074 4.875 4.31.68.295 1.21.47 1.62.6.685.217 1.31.187 1.805.113.55-.082 1.772-.725 2.022-1.4.25-.675.25-1.25.175-1.375-.075-.125-.275-.2-.575-.35z"/></svg>
<span>Book a Call</span>
</a>
<script>
        // Intersection Observer for scroll-triggered reveal animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    
                    // Stagger child elements
                    const staggerItems = entry.target.querySelectorAll('.stagger-item');
                    staggerItems.forEach((item, index) => {
                        item.style.transitionDelay = `${index * 0.15}s`;
                    });
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Header adjustment on scroll
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            const gridContainer = header.querySelector('.grid-container');
            if (window.scrollY > 50) {
                gridContainer.classList.remove('h-20');
                gridContainer.classList.add('h-16');
                header.classList.add('shadow-md', 'bg-surface/100');
            } else {
                gridContainer.classList.remove('h-16');
                gridContainer.classList.add('h-20');
                header.classList.remove('shadow-md', 'bg-surface/100');
            }
        });

        // Add reveal class to sections that don't have it for consistency
        document.querySelectorAll('section').forEach(section => {
            if (!section.classList.contains('reveal')) {
                section.classList.add('reveal');
                observer.observe(section);
            }
        });
    </script>
<script src="assets/js/minyouth-widget.js?v=20260820b" defer></script>
<script src="assets/js/site-nav.js"></script>
</body></html>