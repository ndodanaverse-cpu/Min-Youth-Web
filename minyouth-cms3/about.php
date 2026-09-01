<?php require_once __DIR__ . '/includes/i18n.php'; ?>
<!DOCTYPE html>

<html class="light" lang="<?= current_lang() ?>"><head>
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
<title><?= t('about_heading') ?> | <?= t('site_title') ?></title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-on-surface": "#f3f0ef",
                        "background": "#fcf9f8",
                        "on-surface-variant": "#3e4a41",
                        "on-error": "#ffffff",
                        "surface-container-low": "#f6f3f2",
                        "tertiary-fixed": "#ffdad6",
                        "surface-container-high": "#eae7e7",
                        "on-primary-fixed-variant": "#00522f",
                        "primary-fixed": "#8df8b7",
                        "on-secondary-container": "#6e5c00",
                        "on-error-container": "#93000a",
                        "on-primary-fixed": "#002110",
                        "surface-container-highest": "#e5e2e1",
                        "surface-bright": "#fcf9f8",
                        "on-surface": "#1c1b1b",
                        "error": "#ba1a1a",
                        "on-tertiary-fixed-variant": "#93000d",
                        "on-background": "#1c1b1b",
                        "surface-container": "#f0eded",
                        "surface": "#fcf9f8",
                        "on-secondary-fixed-variant": "#544600",
                        "secondary-fixed-dim": "#e9c400",
                        "primary-container": "#008751",
                        "surface-dim": "#dcd9d9",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary": "#ffffff",
                        "error-container": "#ffdad6",
                        "outline-variant": "#bdcabe",
                        "secondary-fixed": "#ffe16d",
                        "outline": "#6e7a70",
                        "surface-variant": "#e5e2e1",
                        "surface-tint": "#006d40",
                        "on-tertiary-fixed": "#410002",
                        "on-primary": "#ffffff",
                        "secondary-container": "#fcd400",
                        "tertiary-fixed-dim": "#ffb4ac",
                        "primary-fixed-dim": "#70db9d",
                        "on-primary-container": "#fdfff9",
                        "inverse-surface": "#313030",
                        "tertiary": "#bd0014",
                        "primary": "#006400",
                        "secondary": "#705d00",
                        "on-secondary-fixed": "#221b00",
                        "tertiary-container": "#e61e25",
                        "on-tertiary-container": "#fffdff",
                        "on-tertiary": "#ffffff",
                        "inverse-primary": "#70db9d"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "sm": "12px",
                        "md": "24px",
                        "margin-mobile": "16px",
                        "xs": "4px",
                        "gutter": "16px",
                        "base": "8px",
                        "lg": "48px",
                        "xl": "80px",
                        "margin-desktop": "64px"
                    },
                    "fontFamily": {
                        "headline-lg": ["Poppins"],
                        "label-md": ["Poppins"],
                        "label-sm": ["Poppins"],
                        "body-lg": ["Poppins"],
                        "title-lg": ["Poppins"],
                        "display-lg": ["Poppins"],
                        "headline-lg-mobile": ["Poppins"],
                        "body-md": ["Poppins"],
                        "headline-md": ["Poppins"]
                    },
                    "fontSize": {
                        "headline-lg": ["32px", {"lineHeight": "40px", "fontWeight": "600"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.1px", "fontWeight": "500"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.5px", "fontWeight": "500"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "title-lg": ["20px", {"lineHeight": "28px", "fontWeight": "500"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-lg-mobile": ["28px", {"lineHeight": "36px", "fontWeight": "600"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}]
                    }
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            transition: font-variation-settings 0.3s ease;
        }
        .group:hover .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .clip-slant { clip-path: polygon(0 0, 100% 0, 100% 88%, 0% 100%); }
        
        /* Reveal Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Staggered reveals for children */
        .stagger-parent > .reveal:nth-child(1) { transition-delay: 0.1s; }
        .stagger-parent > .reveal:nth-child(2) { transition-delay: 0.2s; }
        .stagger-parent > .reveal:nth-child(3) { transition-delay: 0.3s; }
        .stagger-parent > .reveal:nth-child(4) { transition-delay: 0.4s; }
        .stagger-parent > .reveal:nth-child(5) { transition-delay: 0.5s; }
        .stagger-parent > .reveal:nth-child(6) { transition-delay: 0.6s; }
        .stagger-parent > .reveal:nth-child(7) { transition-delay: 0.7s; }
        .stagger-parent > .reveal:nth-child(8) { transition-delay: 0.8s; }

        header.scrolled {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            background-color: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(8px);
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
<body class="bg-background text-on-surface font-body-md overflow-x-hidden">
<!-- TopNavBar -->
<header class="bg-surface docked full-width top-0 sticky border-b border-outline-variant shadow-sm z-50 transition-all duration-300">
<nav class="flex justify-between items-center px-margin-mobile md:px-margin-desktop py-base w-full max-w-7xl mx-auto">
<div class="flex items-center gap-base">
<img alt="Zimbabwe Government Logo" class="h-8 md:h-16 w-auto transition-transform hover:scale-105" src="assets/logo.png"/>
</div>
<div class="hidden md:flex items-center gap-md">
<a class="text-on-surface-variant font-medium hover:text-primary transition-all relative group py-1" href="index.php">
                <?= t('nav_home') ?>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
</a>
<a class="text-primary font-bold border-b-2 border-primary pb-1 transition-colors" href="about.php" style="color: #008000;"><?= t('nav_about') ?></a>
<a class="text-on-surface-variant font-medium hover:text-primary transition-all relative group py-1" href="departments.php">
                <?= t('nav_departments') ?>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
</a>
<div class="relative group">
<a class="text-on-surface-variant font-medium hover:text-primary transition-all relative py-1 inline-flex items-center gap-1" href="resources.php">
                <?= t('nav_resources') ?> <span aria-hidden="true">&#9662;</span>
</a>
<div class="absolute left-0 top-full hidden min-w-36 pt-2 group-hover:block group-focus-within:block">
<a class="block bg-surface px-md py-sm text-on-surface-variant font-medium shadow-lg hover:bg-surface-container-high hover:text-primary" href="gallery.php"><?= t('nav_gallery') ?></a>
</div>
</div>
<a class="text-on-surface-variant font-medium hover:text-primary transition-all relative group py-1" href="news.php">
                <?= t('nav_news') ?>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
</a>
<a class="text-on-surface-variant font-medium hover:text-primary transition-all relative group py-1" href="contact.php">
                <?= t('nav_contact') ?>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
</a>
</div>
<div class="hidden md:flex items-center gap-base">
<a href="http://127.0.0.1:8000" target="_blank" rel="noopener noreferrer" class="bg-primary text-on-primary font-label-md px-md py-xs rounded-lg hover:shadow-lg transition-all active:scale-95 whitespace-nowrap inline-flex items-center justify-center" style="background-color: #008000;">
            <?= t('nav_apply') ?>
        </a>
</div>
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
<a class="block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="index.php"><?= t('nav_home') ?></a>
<a class="block text-primary font-bold py-sm px-sm rounded-lg transition-all" href="about.php" style="color: #008000;"><?= t('nav_about') ?></a>
<a class="block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="departments.php"><?= t('nav_departments') ?></a>
<details class="group">
<summary class="cursor-pointer list-none block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all"><?= t('nav_resources') ?> <span aria-hidden="true">&#9662;</span></summary>
<a class="ml-md block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="gallery.php"><?= t('nav_gallery') ?></a>
<a class="ml-md block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="resources.php"><?= t('nav_resources') ?></a>
</details>
<a class="block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="news.php"><?= t('nav_news') ?></a>
<a class="block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="contact.php"><?= t('nav_contact') ?></a>
<a href="http://127.0.0.1:8000" target="_blank" rel="noopener noreferrer" class="w-full bg-primary text-on-primary font-label-md px-md py-sm rounded-lg hover:shadow-lg transition-all active:scale-95 inline-flex items-center justify-center text-center" style="background-color: #008000;">
            <?= t('nav_apply') ?>
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
<main>
<!-- Page Hero -->
<section class="relative h-64 md:h-80 w-full overflow-hidden flex items-center justify-center">
<div class="absolute inset-0 z-0">
<img alt="About us background" class="w-full h-full object-cover brightness-50 scale-105 animate-[pulse_10s_ease-in-out_infinite]" src="assets/about/01JK8G6SXJMJC7GYZAWVBFJGC8.jpeg"/>
</div>
<div class="relative z-10 h-full flex flex-col justify-center items-center text-center px-margin-mobile reveal active">
<h1 class="font-display-lg text-display-lg text-white text-shadow-sm mb-base"><?= t('about_hero_title') ?></h1>
<nav class="flex items-center gap-xs text-white/90 font-label-md text-label-md">
<a class="hover:underline transition-all" href="index.php"><?= t('nav_home') ?></a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<span class="font-bold"><?= t('about_heading') ?></span>
</nav>
</div>
</section>
<!-- Identity Section -->
<section class="max-w-7xl mx-auto px-margin-mobile md:px-margin-desktop -mt-16 relative z-20">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-lg items-center">
<!-- Group Photo & Branding -->
<div class="lg:col-span-6 relative reveal">
<div class="relative rounded-xl overflow-hidden shadow-2xl border-4 border-white transition-transform duration-500 hover:scale-[1.02]">
<img class="w-full h-[300px] md:h-[500px] object-cover" data-alt="A formal group photograph of diverse young professionals and government officials" src="assets/about/01JK8G6SXJMJC7GYZAWVBFJGC8.jpeg"/>
</div>
<div class="absolute bottom-base left-base right-base bg-primary p-md shadow-xl border-l-8 border-secondary-container transition-transform hover:translate-x-2" style="background-color: #008000;">
<p class="font-title-lg text-title-lg text-on-primary leading-tight">
                        Ministry of Youth Empowerment, Development and Vocational Training
                    </p>
</div>
</div>
<!-- History Content -->
<div class="lg:col-span-6 space-y-md reveal" style="transition-delay: 0.2s">
<div class="flex items-center gap-base">
<span class="w-12 h-1 bg-secondary-container"></span>
</div>
<h2 class="font-headline-lg text-headline-lg text-primary" style="color: #008000;"><?= t('about_identity_title') ?></h2>
<div class="space-y-sm text-on-surface-variant font-body-lg">
<p><?= t('about_identity_text_1') ?></p>
<p><?= t('about_identity_text_2') ?></p>
</div>
</div>
</div>
</section>
<!-- Vision & Mission -->
<section class="py-xl bg-surface-container-low mt-lg">
<div class="max-w-7xl mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 md:grid-cols-2 gap-md stagger-parent">
<!-- Vision Card -->
<div class="relative overflow-hidden bg-gradient-to-br from-white to-primary/5 p-xl border-t-4 border-t-primary border-x border-b border-outline-variant rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group reveal">
<!-- Large decorative background icon -->
<span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[120px] text-primary/5 transition-all duration-700 group-hover:scale-110 group-hover:text-primary/10 pointer-events-none" style="font-variation-settings: 'FILL' 1;">visibility</span>

<div class="flex items-center gap-md mb-md relative z-10">
<div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center text-primary transition-all duration-500 group-hover:bg-primary group-hover:text-white group-hover:rotate-12 group-hover:scale-110 shadow-sm">
<span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">visibility</span>
</div>
<h3 class="font-headline-md text-headline-md text-primary font-bold group-hover:translate-x-1 transition-transform duration-300" style="color: #008000;"><?= t('about_vision') ?></h3>
</div>
<p class="font-body-lg text-body-lg text-on-surface-variant italic leading-relaxed relative z-10 pl-2 border-l-2 border-primary/20 group-hover:border-primary/50 transition-colors duration-300">
                    <?= t('about_vision_text') ?>
                </p>
</div>
<!-- Mission Card -->
<div class="relative overflow-hidden bg-gradient-to-br from-white to-secondary/5 p-xl border-t-4 border-t-secondary border-x border-b border-outline-variant rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group reveal">
<!-- Large decorative background icon -->
<span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[120px] text-secondary/5 transition-all duration-700 group-hover:scale-110 group-hover:text-secondary/10 pointer-events-none" style="font-variation-settings: 'FILL' 1;">flag</span>

<div class="flex items-center gap-md mb-md relative z-10">
<div class="w-14 h-14 rounded-2xl bg-secondary/10 flex items-center justify-center text-secondary transition-all duration-500 group-hover:bg-secondary group-hover:text-white group-hover:rotate-12 group-hover:scale-110 shadow-sm">
<span class="material-symbols-outlined text-[28px]" style="font-variation-settings: 'FILL' 1;">flag</span>
</div>
<h3 class="font-headline-md text-headline-md text-primary font-bold group-hover:translate-x-1 transition-transform duration-300" style="color: #008000;"><?= t('about_mission') ?></h3>
</div>
<p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed relative z-10 pl-2 border-l-2 border-secondary/20 group-hover:border-secondary/50 transition-colors duration-300">
                    <?= t('about_mission_text') ?>
                </p>
</div>
</div>
</section>
<!-- Core Functions Bento Grid -->
<section class="py-xl max-w-7xl mx-auto px-margin-mobile md:px-margin-desktop">
<div class="text-center mb-xl reveal">
<div class="flex justify-center items-center gap-xs mb-sm">
<span class="w-2 h-2 rounded-full bg-primary animate-bounce"></span>
<span class="w-2 h-2 rounded-full bg-secondary animate-bounce" style="animation-delay: 0.2s"></span>
<span class="w-2 h-2 rounded-full bg-primary animate-bounce" style="animation-delay: 0.4s"></span>
</div>
<h2 class="font-headline-lg text-headline-lg text-primary tracking-wide" style="color: #008000;"><?= t('about_functions_title') ?></h2>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter stagger-parent">
<!-- Function Cards -->
<!-- Card 1 -->
<div class="relative overflow-hidden bg-gradient-to-br from-white to-primary/5 p-md border border-outline-variant rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col gap-sm border-t-4 border-t-primary reveal group" style="border-top-color: #008000;">
<span class="absolute top-3 right-4 font-headline-md text-sm font-bold opacity-10 text-on-surface-variant group-hover:opacity-30 transition-opacity">01</span>
<p class="font-body-md text-on-surface-variant pr-4"><?= t('about_function_1') ?></p>
<div class="mt-auto flex justify-end">
<div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center transition-all duration-300 group-hover:bg-primary group-hover:text-white group-hover:translate-x-1 shadow-sm">
<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</div>
</div>
</div>
<!-- Card 2 -->
<div class="relative overflow-hidden bg-gradient-to-br from-white to-secondary/5 p-md border border-outline-variant rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col gap-sm border-t-4 border-t-secondary reveal group">
<span class="absolute top-3 right-4 font-headline-md text-sm font-bold opacity-10 text-on-surface-variant group-hover:opacity-30 transition-opacity">02</span>
<p class="font-body-md text-on-surface-variant pr-4"><?= t('about_function_2') ?></p>
<div class="mt-auto flex justify-end">
<div class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center transition-all duration-300 group-hover:bg-secondary group-hover:text-white group-hover:translate-x-1 shadow-sm">
<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</div>
</div>
</div>
<!-- Card 3 -->
<div class="relative overflow-hidden bg-gradient-to-br from-white to-primary/5 p-md border border-outline-variant rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col gap-sm border-t-4 border-t-primary reveal group" style="border-top-color: #008000;">
<span class="absolute top-3 right-4 font-headline-md text-sm font-bold opacity-10 text-on-surface-variant group-hover:opacity-30 transition-opacity">03</span>
<p class="font-body-md text-on-surface-variant pr-4"><?= t('about_function_3') ?></p>
<div class="mt-auto flex justify-end">
<div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center transition-all duration-300 group-hover:bg-primary group-hover:text-white group-hover:translate-x-1 shadow-sm">
<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</div>
</div>
</div>
<!-- Card 4 -->
<div class="relative overflow-hidden bg-gradient-to-br from-white to-secondary/5 p-md border border-outline-variant rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col gap-sm border-t-4 border-t-secondary reveal group">
<span class="absolute top-3 right-4 font-headline-md text-sm font-bold opacity-10 text-on-surface-variant group-hover:opacity-30 transition-opacity">04</span>
<p class="font-body-md text-on-surface-variant pr-4"><?= t('about_function_4') ?></p>
<div class="mt-auto flex justify-end">
<div class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center transition-all duration-300 group-hover:bg-secondary group-hover:text-white group-hover:translate-x-1 shadow-sm">
<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</div>
</div>
</div>
<!-- Card 5 -->
<div class="relative overflow-hidden bg-gradient-to-br from-white to-secondary/5 p-md border border-outline-variant rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col gap-sm border-t-4 border-t-secondary reveal group">
<span class="absolute top-3 right-4 font-headline-md text-sm font-bold opacity-10 text-on-surface-variant group-hover:opacity-30 transition-opacity">05</span>
<p class="font-body-md text-on-surface-variant pr-4"><?= t('about_function_5') ?></p>
<div class="mt-auto flex justify-end">
<div class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center transition-all duration-300 group-hover:bg-secondary group-hover:text-white group-hover:translate-x-1 shadow-sm">
<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</div>
</div>
</div>
<!-- Card 6 -->
<div class="relative overflow-hidden bg-gradient-to-br from-white to-primary/5 p-md border border-outline-variant rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col gap-sm border-t-4 border-t-primary reveal group" style="border-top-color: #008000;">
<span class="absolute top-3 right-4 font-headline-md text-sm font-bold opacity-10 text-on-surface-variant group-hover:opacity-30 transition-opacity">06</span>
<p class="font-body-md text-on-surface-variant pr-4"><?= t('about_function_6') ?></p>
<div class="mt-auto flex justify-end">
<div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center transition-all duration-300 group-hover:bg-primary group-hover:text-white group-hover:translate-x-1 shadow-sm">
<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</div>
</div>
</div>
<!-- Card 7 -->
<div class="relative overflow-hidden bg-gradient-to-br from-white to-secondary/5 p-md border border-outline-variant rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col gap-sm border-t-4 border-t-secondary reveal group">
<span class="absolute top-3 right-4 font-headline-md text-sm font-bold opacity-10 text-on-surface-variant group-hover:opacity-30 transition-opacity">07</span>
<p class="font-body-md text-on-surface-variant pr-4"><?= t('about_function_7') ?></p>
<div class="mt-auto flex justify-end">
<div class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center transition-all duration-300 group-hover:bg-secondary group-hover:text-white group-hover:translate-x-1 shadow-sm">
<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</div>
</div>
</div>
<!-- Card 8 -->
<div class="relative overflow-hidden bg-gradient-to-br from-white to-primary/5 p-md border border-outline-variant rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col gap-sm border-t-4 border-t-primary reveal group" style="border-top-color: #008000;">
<span class="absolute top-3 right-4 font-headline-md text-sm font-bold opacity-10 text-on-surface-variant group-hover:opacity-30 transition-opacity">08</span>
<p class="font-body-md text-on-surface-variant pr-4"><?= t('about_function_8') ?></p>
<div class="mt-auto flex justify-end">
<div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center transition-all duration-300 group-hover:bg-primary group-hover:text-white group-hover:translate-x-1 shadow-sm">
<span class="material-symbols-outlined text-[16px]">arrow_forward</span>
</div>
</div>
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
<svg class="w-5 h-5 fill-current" viewbox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
</a>
</div>
</div>
<!-- Quick Links -->
<div class="flex flex-col gap-md">
<span class="font-title-lg text-title-lg border-b border-white/20 pb-base"><?= t('footer_quick_links') ?></span>
<div class="flex flex-col gap-sm">
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="index.php"><?= t('nav_home') ?></a>
<a class="text-on-primary font-bold underline" href="about.php"><?= t('nav_about') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="departments.php"><?= t('nav_departments') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="gallery.php"><?= t('nav_gallery') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="resources.php"><?= t('nav_resources') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="news.php"><?= t('nav_news') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="contact.php"><?= t('nav_contact') ?></a>
</div>
</div>
<!-- Resources -->
<div class="flex flex-col gap-md">
<span class="font-title-lg text-title-lg border-b border-white/20 pb-base"><?= t('footer_resources') ?></span>
<div class="flex flex-col gap-sm">
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="#"><?= t('footer_nat_policy') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="#"><?= t('footer_strat_plan') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="#"><?= t('footer_vtc_forms') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="#"><?= t('footer_annual_rep') ?></a>
</div>
</div>
<!-- Newsletter -->
<div class="flex flex-col gap-md">
<span class="font-title-lg text-title-lg border-b border-white/20 pb-base"><?= t('footer_newsletter') ?></span>
<p class="text-sm opacity-90"><?= t('footer_newsletter_sub') ?></p>
<div class="flex flex-col gap-base">
<input class="bg-white/10 border-white/20 rounded-lg px-md py-sm text-white placeholder:text-white/40 focus:ring-primary-fixed focus:border-primary-fixed transition-all" placeholder="<?= t('footer_email_ph') ?>" type="email"/>
<button class="bg-[#ccffba] text-[#002200] font-bold py-sm rounded-lg hover:brightness-110 active:scale-95 transition-all"><?= t('footer_subscribe') ?></button>
</div>
</div>
</div>
<!-- Copyright -->
<div class="border-t border-white/10 py-md text-center text-on-primary/60 font-label-sm">
        <?= t('footer_copyright') ?>
    </div>
</footer>
<script>
    // Reveal animation on scroll
    function reveal() {
        var reveals = document.querySelectorAll(".reveal");
        for (var i = 0; i < reveals.length; i++) {
            var windowHeight = window.innerHeight;
            var elementTop = reveals[i].getBoundingClientRect().top;
            var elementVisible = 100;
            if (elementTop < windowHeight - elementVisible) {
                reveals[i].classList.add("active");
            }
        }
    }

    window.addEventListener("scroll", reveal);
    
    // Header transition on scroll
    window.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        if (window.scrollY > 50) {
            header.classList.add('scrolled', 'shadow-lg');
        } else {
            header.classList.remove('scrolled', 'shadow-lg');
        }
    });

    // Initial check for reveal elements in view
    reveal();
</script>
<!-- WhatsApp contact button -->
<style>.wa-fab{position:fixed;bottom:1.5rem;right:1.5rem;z-index:40;display:flex;align-items:center;gap:.5rem;padding:.65rem 1.25rem;background:#25D366;color:#fff;border-radius:9999px;font-weight:700;font-size:14px;box-shadow:0 8px 30px rgba(37,211,102,.45);border:none;cursor:pointer;text-decoration:none;transition:all .3s;font-family:Poppins,sans-serif}.wa-fab:hover{transform:translateY(-3px) scale(1.05);box-shadow:0 12px 40px rgba(37,211,102,.6)}.wa-fab svg{width:22px;height:22px;fill:white;flex-shrink:0}</style>
<a class="wa-fab" href="https://wa.me/263242707741?text=<?= rawurlencode((string) t('whatsapp_message')) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= t('home_book_call') ?> via WhatsApp">
<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.513 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.864-9.864.002-2.637-1.03-5.114-2.905-6.99C16.559 1.875 14.09 1.83 11.45 1.83c-5.437 0-9.862 4.421-9.866 9.865-.001 1.761.47 3.483 1.365 5.011L1.92 21.05l4.727-1.24zm12.317-5.908c-.3-.15-1.772-.875-2.046-.975-.275-.1-.475-.15-.675.15-.2.3-.775 1.025-.95 1.225-.175.2-.35.225-.65.075-.3-.15-1.265-.467-2.41-1.485-.89-.794-1.49-1.775-1.665-2.075-.175-.3-.02-.463.13-.612.135-.135.3-.35.45-.525.15-.175.2-.3.3-.5s.05-.375-.025-.525c-.075-.15-.675-1.625-.925-2.225-.244-.589-.48-.58-.675-.59-.175-.01-.375-.01-.575-.01-.2 0-.525.075-.8.375-.275.3-1.05 1.025-1.05 2.5s1.025 2.9 1.175 3.1c.15.2 2.013 3.074 4.875 4.31.68.295 1.21.47 1.62.6.685.217 1.31.187 1.805.113.55-.082 1.772-.725 2.022-1.4.25-.675.25-1.25.175-1.375-.075-.125-.275-.2-.575-.35z"/></svg>
<span><?= t('home_book_call') ?></span>
</a>
<script src="assets/js/minyouth-widget.js?v=20260820b" defer></script>
<script src="assets/js/site-nav.js?v=20260826"></script>
</body></html>