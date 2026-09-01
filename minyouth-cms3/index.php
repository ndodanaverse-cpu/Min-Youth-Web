<?php require_once __DIR__ . '/includes/i18n.php'; ?>
<!DOCTYPE html>

<html class="scroll-smooth" lang="<?= current_lang() ?>"><head>
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

<title><?= t('site_title') ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
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
                        "primary-container": "#008000",
                        "surface-dim": "#dcd9d9",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary": "#ffffff",
                        "error-container": "#ffdad6",
                        "outline-variant": "#bdcabe",
                        "secondary-fixed": "#ffe16d",
                        "outline": "#6e7a70",
                        "surface-variant": "#e5e2e1",
                        "surface-tint": "#008000",
                        "on-tertiary-fixed": "#410002",
                        "on-primary": "#ffffff",
                        "secondary-container": "#fcd400",
                        "tertiary-fixed-dim": "#ffb4ac",
                        "primary-fixed-dim": "#70db9d",
                        "on-primary-container": "#fdfff9",
                        "inverse-surface": "#313030",
                        "tertiary": "#bd0014",
                        "primary": "#008000",
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
                }
            }
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .text-glow {
            text-shadow: 0 0 15px rgba(0, 128, 0, 0.4);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
        }
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: marquee 30s linear infinite;
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
<a class="text-primary font-bold border-b-2 border-primary pb-1 transition-colors" href="index.php" style="color: #008000;"><?= t('nav_home') ?></a>
<a class="text-on-surface-variant font-medium hover:text-primary transition-all relative group py-1" href="about.php">
                <?= t('nav_about') ?>
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
</a>
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
<a id="site-portal" href="<?= portal_url_attr() ?>" target="_blank" rel="noopener noreferrer" class="bg-primary text-on-primary font-label-md px-md py-xs rounded-lg hover:shadow-lg transition-all active:scale-95 whitespace-nowrap inline-flex items-center justify-center" style="background-color: #008000;">
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
<a class="block text-primary font-bold py-sm px-sm rounded-lg transition-all" href="index.php" style="color: #008000;"><?= t('nav_home') ?></a>
<a class="block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="about.php"><?= t('nav_about') ?></a>
<a class="block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="departments.php"><?= t('nav_departments') ?></a>
<details class="group">
<summary class="cursor-pointer list-none block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all"><?= t('nav_resources') ?> <span aria-hidden="true">&#9662;</span></summary>
<a class="ml-md block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="gallery.php"><?= t('nav_gallery') ?></a>
<a class="ml-md block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="resources.php"><?= t('nav_resources') ?></a>
</details>
<a class="block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="news.php"><?= t('nav_news') ?></a>
<a class="block text-on-surface-variant font-medium hover:text-primary py-sm px-sm rounded-lg hover:bg-surface-container-high transition-all" href="contact.php"><?= t('nav_contact') ?></a>
<a id="site-portal-mobile" href="<?= portal_url_attr() ?>" target="_blank" rel="noopener noreferrer" class="w-full bg-primary text-on-primary font-label-md px-md py-sm rounded-lg hover:shadow-lg transition-all active:scale-95 inline-flex items-center justify-center text-center" style="background-color: #008000;">
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
<!-- Hero Section -->
<section class="relative h-[600px] md:h-[870px] flex items-center overflow-hidden">
<div class="absolute inset-0 z-0" id="hero-carousel">
<!-- Slide 1 -->
<div class="carousel-slide absolute inset-0 bg-cover bg-center w-full h-full transform scale-105 animate-[pulse_10s_ease-in-out_infinite] transition-opacity duration-1000 opacity-100" style="background-image: url('assets/home/01JXF9C4GHE7WXCN8NERDSPB5E.jpg')"></div>
<!-- Slide 2 -->
<div class="carousel-slide absolute inset-0 bg-cover bg-center w-full h-full transform scale-105 animate-[pulse_10s_ease-in-out_infinite] transition-opacity duration-1000 opacity-0" style="background-image: url('assets/home/01JQEJ86VZQMZMMB31Q04EZGF0.jpg')"></div>
<!-- Slide 3 -->
<div class="carousel-slide absolute inset-0 bg-cover bg-center w-full h-full transform scale-105 animate-[pulse_10s_ease-in-out_infinite] transition-opacity duration-1000 opacity-0" style="background-image: url('assets/home/01JV7D9W77JK90T9D9S63AACNE.jpg')"></div>
<!-- Slide 4 -->
<div class="carousel-slide absolute inset-0 bg-cover bg-center w-full h-full transform scale-105 animate-[pulse_10s_ease-in-out_infinite] transition-opacity duration-1000 opacity-0" style="background-image: url('assets/home/01JQ3HYE3P7GF1Y5ARTZ16M7KN.jpg')"></div>
<!-- Overlays -->
<div class="absolute inset-0 bg-gradient-to-r from-black/85 via-black/50 to-transparent z-10"></div>
<div class="absolute inset-0 bg-primary/10 mix-blend-multiply z-10"></div>
</div>
<div class="relative z-20 w-full max-w-7xl mx-auto px-margin-mobile md:px-margin-desktop text-on-primary">
<div class="max-w-2xl reveal active">
<h1 class="font-display-lg text-3xl md:text-display-lg mb-6 leading-tight"><?= t('hero_title') ?></h1>
<p class="font-body-lg text-lg md:text-body-lg mb-8 opacity-90"><?= t('hero_subtitle') ?></p>
<div class="flex flex-col sm:flex-row gap-4">
<a href="departments.php" class="bg-secondary-container hover:bg-secondary-fixed text-on-secondary-container font-bold px-8 md:px-lg py-sm rounded-lg transition-all flex items-center justify-center gap-2 hover-lift">
                        <?= t('hero_cta_1') ?> <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span>
</a>
<a href="about.php" class="border-2 border-white/40 hover:border-white text-white font-bold px-8 md:px-lg py-sm rounded-lg transition-all backdrop-blur-sm hover:bg-white/10 text-center">
                        <?= t('hero_cta_2') ?>
                    </a>
</div>
</div>
</div>
<!-- News Ticker -->
<div class="absolute bottom-0 w-full bg-primary-container text-on-primary-container py-3 overflow-hidden whitespace-nowrap">
<div class="flex animate-marquee">
<span class="mx-8 font-label-md text-label-md flex items-center gap-2"><span class="material-symbols-outlined text-sm">notifications_active</span> <?= t('ticker_training') ?></span>
<span class="mx-8 font-label-md text-label-md flex items-center gap-2"><span class="material-symbols-outlined text-sm">notifications_active</span> <?= t('ticker_fund') ?></span>
<span class="mx-8 font-label-md text-label-md flex items-center gap-2"><span class="material-symbols-outlined text-sm">notifications_active</span> <?= t('ticker_digital') ?></span>
<!-- Duplicate for seamless loop -->
<span class="mx-8 font-label-md text-label-md flex items-center gap-2"><span class="material-symbols-outlined text-sm">notifications_active</span> <?= t('ticker_training') ?></span>
<span class="mx-8 font-label-md text-label-md flex items-center gap-2"><span class="material-symbols-outlined text-sm">notifications_active</span> <?= t('ticker_fund') ?></span>
</div>
</div>
</section>
<!-- Programs Features -->
<section class="py-lg md:py-xl bg-surface">
<div class="max-w-7xl mx-auto px-margin-mobile md:px-margin-desktop">
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-md">
<!-- Feature Card 1 -->
<div class="reveal group p-md bg-white border border-outline-variant hover:border-primary transition-all duration-300 flex flex-col items-center text-center rounded-xl shadow-sm hover-lift">
<div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mb-6 group-hover:bg-primary transition-colors duration-500">
<span class="material-symbols-outlined text-[40px] text-primary group-hover:text-white" style="font-variation-settings: 'FILL' 1;">payments</span>
</div>
<h3 class="font-headline-md text-headline-md mb-2 text-primary"><?= t('home_feature_1_title') ?></h3>
<p class="font-body-md text-body-md text-on-surface-variant"><?= t('home_feature_1_text') ?></p>
</div>
<!-- Feature Card 2 -->
<div class="reveal group p-md bg-white border border-outline-variant hover:border-primary transition-all duration-300 flex flex-col items-center text-center rounded-xl shadow-sm hover-lift" style="transition-delay: 100ms;">
<div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mb-6 group-hover:bg-primary transition-colors duration-500">
<span class="material-symbols-outlined text-[40px] text-primary group-hover:text-white" style="font-variation-settings: 'FILL' 1;">work</span>
</div>
<h3 class="font-headline-md text-headline-md mb-2 text-primary"><?= t('home_feature_2_title') ?></h3>
<p class="font-body-md text-body-md text-on-surface-variant"><?= t('home_feature_2_text') ?></p>
</div>
<!-- Feature Card 3 -->
<div class="reveal group p-md bg-white border border-outline-variant hover:border-primary transition-all duration-300 flex flex-col items-center text-center rounded-xl shadow-sm hover-lift" style="transition-delay: 200ms;">
<div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mb-6 group-hover:bg-primary transition-colors duration-500">
<span class="material-symbols-outlined text-[40px] text-primary group-hover:text-white" style="font-variation-settings: 'FILL' 1;">groups</span>
</div>
<h3 class="font-headline-md text-headline-md mb-2 text-primary"><?= t('home_feature_3_title') ?></h3>
<p class="font-body-md text-body-md text-on-surface-variant"><?= t('home_feature_3_text') ?></p>
</div>
<!-- Feature Card 4 -->
<div class="reveal group p-md bg-white border border-outline-variant hover:border-primary transition-all duration-300 flex flex-col items-center text-center rounded-xl shadow-sm hover-lift" style="transition-delay: 300ms;">
<div class="w-20 h-20 rounded-full bg-primary/10 flex items-center justify-center mb-6 group-hover:bg-primary transition-colors duration-500">
<span class="material-symbols-outlined text-[40px] text-primary group-hover:text-white" style="font-variation-settings: 'FILL' 1;">lightbulb</span>
</div>
<h3 class="font-headline-md text-headline-md mb-2 text-primary"><?= t('home_feature_4_title') ?></h3>
<p class="font-body-md text-body-md text-on-surface-variant"><?= t('home_feature_4_text') ?></p>
</div>
</div>
</div>
</section>
<!-- Asymmetric Info Section -->
<section class="relative py-lg md:py-xl overflow-hidden">
<div class="absolute inset-0 bg-primary/5 -skew-y-3 origin-right transform scale-110"></div>
<div class="max-w-7xl mx-auto px-margin-mobile md:px-margin-desktop relative z-10">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-lg md:gap-xl items-center">
<div class="relative reveal">
<div class="relative z-10 rounded-2xl overflow-hidden shadow-2xl hover-lift">
<img class="w-full h-[300px] md:h-[500px] object-cover transition-transform duration-700 hover:scale-110" alt="<?= t('home_gallery_image') ?>" src="assets/home/corevalues-home.webp"/>
</div>
<div class="absolute -bottom-4 md:-bottom-8 -right-4 md:-right-8 w-32 md:w-64 h-32 md:h-64 bg-primary rounded-2xl -z-10 animate-pulse opacity-20"></div>
<div class="absolute -top-4 md:-top-8 -left-4 md:-left-8 w-24 md:w-48 h-24 md:h-48 border-4 border-secondary-container rounded-2xl -z-10"></div>
</div>
<div class="reveal" style="transition-delay: 200ms;">
<span class="text-primary font-bold font-label-md text-label-md tracking-widest uppercase mb-4 block"><?= t('home_purpose_label') ?></span>
<h2 class="font-display-lg text-headline-lg mb-6 text-on-background"><?= t('home_values_title') ?></h2>
<p class="font-body-lg text-body-lg text-on-surface-variant mb-8"><?= t('home_values_text') ?></p>
<div class="space-y-6">
<div class="group flex items-start gap-4 p-4 hover:bg-white transition-all rounded-xl border-l-4 border-primary shadow-sm bg-white/50 hover-lift">
<span class="material-symbols-outlined text-primary mt-1 transition-transform group-hover:scale-125">check_circle</span>
<div>
<h4 class="font-title-lg text-title-lg text-primary"><?= t('value_patriotism') ?></h4>
<p class="font-body-md text-body-md"><?= t('value_patriotism_text') ?></p>
</div>
</div>
<div class="group flex items-start gap-4 p-4 hover:bg-white transition-all rounded-xl border-l-4 border-primary shadow-sm bg-white/50 hover-lift">
<span class="material-symbols-outlined text-primary mt-1 transition-transform group-hover:scale-125">check_circle</span>
<div>
<h4 class="font-title-lg text-title-lg text-primary"><?= t('value_accountability') ?></h4>
<p class="font-body-md text-body-md"><?= t('value_accountability_text') ?></p>
</div>
</div>
<div class="group flex items-start gap-4 p-4 hover:bg-white transition-all rounded-xl border-l-4 border-primary shadow-sm bg-white/50 hover-lift">
<span class="material-symbols-outlined text-primary mt-1 transition-transform group-hover:scale-125">check_circle</span>
<div>
<h4 class="font-title-lg text-title-lg text-primary"><?= t('value_innovation') ?></h4>
<p class="font-body-md text-body-md"><?= t('value_innovation_text') ?></p>
</div>
</div>
<div class="group flex items-start gap-4 p-4 hover:bg-white transition-all rounded-xl border-l-4 border-primary shadow-sm bg-white/50 hover-lift">
<span class="material-symbols-outlined text-primary mt-1 transition-transform group-hover:scale-125">check_circle</span>
<div>
<h4 class="font-title-lg text-title-lg text-primary"><?= t('value_integrity') ?></h4>
<p class="font-body-md text-body-md"><?= t('value_integrity_text') ?></p>
</div>
</div>
<div class="group flex items-start gap-4 p-4 hover:bg-white transition-all rounded-xl border-l-4 border-primary shadow-sm bg-white/50 hover-lift">
<span class="material-symbols-outlined text-primary mt-1 transition-transform group-hover:scale-125">check_circle</span>
<div>
<h4 class="font-title-lg text-title-lg text-primary"><?= t('value_teamwork') ?></h4>
<p class="font-body-md text-body-md"><?= t('value_teamwork_text') ?></p>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<!-- Principals Section -->
<section class="py-lg md:py-xl bg-surface-container-low">
  <div class="max-w-7xl mx-auto px-margin-mobile md:px-margin-desktop text-center">
    <span class="reveal text-primary font-bold font-label-md text-label-md tracking-widest uppercase mb-4 block"><?= t('home_leadership') ?></span>
    <h2 class="reveal font-headline-lg text-headline-lg mb-xl"><?= t('home_principals') ?></h2>
    
    <!-- Reordered layout: Secretary (Left), Minister (Center/Top), Deputy (Right) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-lg items-start">
      
      <!-- Principal 3: Permanent Secretary (Left) -->
      <div class="reveal group order-2 md:order-1" style="transition-delay: 300ms;">
        <div class="relative mb-6 mx-auto w-48 h-48 md:w-64 md:h-64 overflow-hidden rounded-2xl hover-lift shadow-lg border-4 border-white">
          <!-- Removed grayscale classes -->
          <img class="w-full h-full object-cover transition-all duration-500 scale-110 group-hover:scale-100" alt="Mr. S. Mhlanga, Permanent Secretary" src="assets/home/01JK63Z8MYKH804CCDV6DJANP0.jpg"/>
        </div>
        <h4 class="font-title-lg text-title-lg mb-1">Mr. S. Mhlanga</h4>
        <p class="text-primary font-label-md font-bold mb-4"><?= t('role_permanent_secretary') ?></p>
        
        <!-- Updated Social Icons -->
        <div class="flex justify-center gap-3">
          <a class="w-8 h-8 rounded-full border border-outline flex items-center justify-center hover:bg-primary hover:text-white transition-colors" href="#" title="X (Twitter)">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>
          <a class="w-8 h-8 rounded-full border border-outline flex items-center justify-center hover:bg-primary hover:text-white transition-colors" href="#" title="LinkedIn">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <a class="w-8 h-8 rounded-full border border-outline flex items-center justify-center hover:bg-primary hover:text-white transition-colors" href="#" title="Facebook">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
        </div>
      </div>

      <!-- Principal 1: Minister of Youth Empowerment (Center / Top on mobile) -->
      <div class="reveal group order-1 md:order-2 col-span-1 sm:col-span-2 md:col-span-1 mb-8 md:mb-0" style="transition-delay: 100ms;">
        <div class="relative mb-6 mx-auto w-48 h-48 md:w-64 md:h-64 overflow-hidden rounded-2xl hover-lift shadow-lg border-4 border-white">
          <!-- Removed grayscale classes -->
          <img class="w-full h-full object-cover transition-all duration-500 scale-110 group-hover:scale-100" alt="Hon. T. Machakaire, Minister of Youth Empowerment" src="assets/home/01JK63GMZ3T344H25N7W8M9K72.jpg"/>
        </div>
        <h4 class="font-title-lg text-title-lg mb-1">Hon. T. Machakaire</h4>
        <p class="text-primary font-label-md font-bold mb-4"><?= t('role_minister') ?></p>
        
        <!-- Updated Social Icons -->
        <div class="flex justify-center gap-3">
          <a class="w-8 h-8 rounded-full border border-outline flex items-center justify-center hover:bg-primary hover:text-white transition-colors" href="#" title="X (Twitter)">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>
          <a class="w-8 h-8 rounded-full border border-outline flex items-center justify-center hover:bg-primary hover:text-white transition-colors" href="#" title="LinkedIn">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <a class="w-8 h-8 rounded-full border border-outline flex items-center justify-full hover:bg-primary hover:text-white transition-colors" href="#" title="Facebook">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
        </div>
      </div>

      <!-- Principal 2: Deputy Minister (Right) -->
      <div class="reveal group order-3" style="transition-delay: 200ms;">
        <div class="relative mb-6 mx-auto w-48 h-48 md:w-64 md:h-64 overflow-hidden rounded-2xl hover-lift shadow-lg border-4 border-white">
          <!-- Removed grayscale classes -->
          <img class="w-full h-full object-cover transition-all duration-500 scale-110 group-hover:scale-100" alt="Hon. K. Mupamhanga, Deputy Minister" src="assets/home/01JK63T2TNDFMEPEHS738G5MMB.jpg"/>
        </div>
        <h4 class="font-title-lg text-title-lg mb-1">Hon. K. Mupamhanga</h4>
        <p class="text-primary font-label-md font-bold mb-4"><?= t('role_deputy_minister') ?></p>
        
        <!-- Updated Social Icons -->
        <div class="flex justify-center gap-3">
          <a class="w-8 h-8 rounded-full border border-outline flex items-center justify-center hover:bg-primary hover:text-white transition-colors" href="#" title="X (Twitter)">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
          </a>
          <a class="w-8 h-8 rounded-full border border-outline flex items-center justify-center hover:bg-primary hover:text-white transition-colors" href="#" title="LinkedIn">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <a class="w-8 h-8 rounded-full border border-outline flex items-center justify-center hover:bg-primary hover:text-white transition-colors" href="#" title="Facebook">
            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
        </div>
      </div>
      
    </div>
  </div>
</section>
<!-- Bento Grid Opportunities -->
<section class="py-lg md:py-xl bg-white">
<div class="max-w-7xl mx-auto px-margin-mobile md:px-margin-desktop">
<div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-xl gap-4">
<div class="reveal">
<span class="text-primary font-bold font-label-md text-label-md tracking-widest uppercase mb-4 block"><?= t('home_departments_label') ?></span>
<h2 class="font-headline-lg text-headline-lg"><?= t('home_departments_title') ?></h2>
</div>
<a href="departments.php" class="reveal text-primary font-bold font-label-md flex items-center gap-2 hover:underline group" style="transition-delay: 100ms;">
                    <?= t('home_view_departments') ?> <span class="material-symbols-outlined transition-transform group-hover:translate-x-1 group-hover:-translate-y-1" aria-hidden="true">north_east</span>
</a>
</div>
<div class="bento-grid">
<div class="reveal col-span-12 md:col-span-8 bg-surface-container-low rounded-3xl p-lg relative overflow-hidden group hover-lift">
<div class="relative z-10 flex flex-col h-full justify-between">
<div>
<h3 class="font-headline-md text-headline-md text-primary mb-4"><?= t('home_feature_1_title') ?></h3>
<p class="font-body-lg text-body-lg max-w-lg mb-8"><?= t('home_feature_1_text') ?></p>
</div>
<button class="bg-primary hover:bg-primary/90 text-on-primary w-fit px-md py-sm rounded-lg font-bold transition-transform hover:scale-105" onclick="window.location.href='assets/departments/department-dedicated-pages/youth_empowerment_development.html'"><?= t('home_learn_more') ?></button>
</div>
<span class="absolute -right-16 -bottom-16 material-symbols-outlined text-[300px] text-primary/5 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-700">account_balance</span>
</div>
<div class="reveal col-span-12 md:col-span-4 bg-primary text-on-primary rounded-3xl p-lg flex flex-col justify-between group hover-lift" style="transition-delay: 100ms;">
<div>
<span class="material-symbols-outlined text-4xl mb-6 transition-transform group-hover:scale-125">workspace_premium</span>
<h3 class="font-headline-md text-headline-md mb-4"><?= t('home_feature_2_title') ?></h3>
<p class="font-body-md text-body-md opacity-80"><?= t('home_feature_2_text') ?></p>
</div>
<a class="flex items-center gap-2 font-bold hover:gap-4 transition-all mt-8" href="assets\departments\department-dedicated-pages\youth_service.html"><?= t('home_explore_more') ?> <span class="material-symbols-outlined">arrow_forward</span></a>
</div> <a href="assets\departments\department-dedicated-pages\vocational_training.html" class="reveal block col-span-12 md:col-span-4 bg-secondary-container text-on-secondary-container rounded-3xl p-lg group hover-lift no-underline" style="transition-delay: 200ms;">
  <span class="material-symbols-outlined text-4xl mb-6 transition-transform group-hover:scale-125">agriculture</span>
  <h3 class="font-headline-md text-headline-md mb-4"><?= t('home_feature_3_title') ?></h3>
  <p class="font-body-md text-body-md opacity-80"><?= t('home_feature_3_text') ?></p>
</a>

<div class="reveal col-span-12 md:col-span-8 grid grid-cols-1 sm:grid-cols-2 gap-md" style="transition-delay: 300ms;">
<a href="assets\departments\department-dedicated-pages\business_development.html" class="bg-surface-container rounded-3xl p-md hover:bg-primary hover:text-on-primary transition-all group cursor-pointer hover-lift block no-underline text-inherit">
    <span class="material-symbols-outlined text-primary group-hover:text-white mb-4 transition-transform group-hover:rotate-12">terminal</span>
    <h4 class="font-title-lg text-title-lg"><?= t('home_feature_4_title') ?></h4>
    <p class="font-body-md text-body-md opacity-80"><?= t('home_feature_4_text') ?></p>
</a>
</div>
</div>
</div>
</section>
<!-- Latest News -->
<section class="py-lg md:py-xl bg-background border-t border-outline-variant">
<div class="max-w-7xl mx-auto px-margin-mobile md:px-margin-desktop">
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-xl gap-4">
<h2 class="reveal font-headline-lg text-headline-lg"><?= t('home_news_title') ?></h2>
<div class="reveal flex gap-2" style="transition-delay: 100ms;">
<button class="w-12 h-12 rounded-full border border-outline flex items-center justify-center hover:bg-primary hover:text-white transition-all hover-lift"><span class="material-symbols-outlined">chevron_left</span></button>
<button class="w-12 h-12 rounded-full border border-outline flex items-center justify-center hover:bg-primary hover:text-white transition-all hover-lift"><span class="material-symbols-outlined">chevron_right</span></button>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-md">
<!-- News Card 1 -->
<article class="reveal bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all border border-outline-variant hover-lift">
<div class="relative h-56 overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" alt="<?= t('news_1_title') ?>" src="assets/home/01K0C0AHPSXB20CVSVPRQQW3HR.jpeg"/>
<span class="absolute top-4 left-4 bg-primary text-white text-[10px] font-bold px-2 py-1 rounded uppercase"><?= t('news_events') ?></span>
</div>
<div class="p-md">
<span class="text-on-surface-variant font-label-sm text-label-sm block mb-2"><?= t('home_date_1') ?></span>
<h3 class="font-title-lg text-title-lg mb-4 line-clamp-2 hover:text-primary cursor-pointer transition-colors"><?= t('news_1_title') ?></h3>
<p class="font-body-md text-body-md text-on-surface-variant mb-6 line-clamp-3"><?= t('news_1_text') ?></p>
<a class="text-primary font-bold flex items-center gap-1 group" href="news.php"><?= t('read_more') ?> <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span></a>
</div>
</article>
<!-- News Card 2 -->
<article class="reveal bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all border border-outline-variant hover-lift" style="transition-delay: 100ms;">
<div class="relative h-56 overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" alt="<?= t('news_2_title') ?>" src="assets/home/01JXF9C4GHE7WXCN8NERDSPB5E.jpg"/>
<span class="absolute top-4 left-4 bg-secondary-container text-on-secondary-container text-[10px] font-bold px-2 py-1 rounded uppercase"><?= t('news_press_release') ?></span>
</div>
<div class="p-md">
<span class="text-on-surface-variant font-label-sm text-label-sm block mb-2"><?= t('home_date_2') ?></span>
<h3 class="font-title-lg text-title-lg mb-4 line-clamp-2 hover:text-primary cursor-pointer transition-colors"><?= t('news_2_title') ?></h3>
<p class="font-body-md text-body-md text-on-surface-variant mb-6 line-clamp-3"><?= t('news_2_text') ?></p>
<a class="text-primary font-bold flex items-center gap-1 group" href="news.php"><?= t('read_more') ?> <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span></a>
</div>
</article>
<!-- News Card 3 -->
<article class="reveal bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all border border-outline-variant hover-lift" style="transition-delay: 200ms;">
<div class="relative h-56 overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-700 hover:scale-110" alt="<?= t('news_3_title') ?>" src="assets/home/01JV7D9W77JK90T9D9S63AACNE.jpg"/>
<span class="absolute top-4 left-4 bg-tertiary-container text-on-tertiary-container text-[10px] font-bold px-2 py-1 rounded uppercase"><?= t('news_update') ?></span>
</div>
<div class="p-md">
<span class="text-on-surface-variant font-label-sm text-label-sm block mb-2"><?= t('home_date_3') ?></span>
<h3 class="font-title-lg text-title-lg mb-4 line-clamp-2 hover:text-primary cursor-pointer transition-colors"><?= t('news_3_title') ?></h3>
<p class="font-body-md text-body-md text-on-surface-variant mb-6 line-clamp-3"><?= t('news_3_text') ?></p>
<a class="text-primary font-bold flex items-center gap-1 group" href="news.php"><?= t('read_more') ?> <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span></a>
</div>
</article>
</div>
</div>
</section>
<!-- Partner Logos -->
<section class="py-lg md:py-xl bg-surface">
<div class="max-w-7xl mx-auto px-margin-mobile md:px-margin-desktop text-center">
<p class="reveal font-label-sm text-label-sm text-on-surface-variant mb-8 uppercase tracking-[0.2em]"><?= t('home_partners') ?></p>
<div class="reveal flex flex-wrap justify-center items-center gap-8 md:gap-16 grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all duration-700">
<img class="h-8 md:h-12 w-auto transition-transform hover:scale-110" alt="NetOne" src="assets/home/netone.webp"/>
<img class="h-10 md:h-14 w-auto transition-transform hover:scale-110" alt="Empower Bank" src="assets/home/empower bank.webp"/>
<img class="h-7 md:h-10 w-auto transition-transform hover:scale-110" alt="FAO" src="assets/home/fao.png"/>
<img class="h-8 md:h-12 w-auto transition-transform hover:scale-110" alt="CAMFED" src="assets/home/camfed.png"/>
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
<a class="text-on-primary font-bold underline" href="index.php"><?= t('nav_home') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="about.php"><?= t('nav_about') ?></a>
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
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="resources.php"><?= t('footer_nat_policy') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="resources.php"><?= t('footer_strat_plan') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="resources.php"><?= t('footer_vtc_forms') ?></a>
<a class="text-on-primary/80 hover:text-white transition-colors hover:translate-x-1" href="resources.php"><?= t('footer_annual_rep') ?></a>
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
    // Scroll Reveal Intersection Observer
    const revealCallback = (entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    };

    const revealObserver = new IntersectionObserver(revealCallback, {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    });

    document.querySelectorAll('.reveal').forEach(el => {
        revealObserver.observe(el);
    });

    // Sticky Header Scroll Effect
    const header = document.querySelector('header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 100) {
            header.classList.add('py-2', 'shadow-lg', 'bg-white/95', 'backdrop-blur-md');
        } else {
            header.classList.remove('py-2', 'shadow-lg', 'bg-white/95', 'backdrop-blur-md');
        }
    });

    // Button Click Ripples (Simplified)
    document.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('mousedown', function() {
            this.style.transform = 'scale(0.95)';
        });
        btn.addEventListener('mouseup', function() {
            this.style.transform = '';
        });
    });

    // Hero Image Carousel
    const carouselSlides = document.querySelectorAll('.carousel-slide');
    let currentCarouselSlide = 0;

    function nextCarouselSlide() {
        carouselSlides[currentCarouselSlide].classList.remove('opacity-100');
        carouselSlides[currentCarouselSlide].classList.add('opacity-0');
        
        currentCarouselSlide = (currentCarouselSlide + 1) % carouselSlides.length;
        
        carouselSlides[currentCarouselSlide].classList.remove('opacity-0');
        carouselSlides[currentCarouselSlide].classList.add('opacity-100');
    }

    if (carouselSlides.length > 0) {
        setInterval(nextCarouselSlide, 5000);
    }
</script>
<!-- WhatsApp Book a Call FAB -->
<style>.wa-fab{position:fixed;bottom:1.5rem;right:1.5rem;z-index:40;display:flex;align-items:center;gap:.5rem;padding:.65rem 1.25rem;background:#25D366;color:#fff;border-radius:9999px;font-weight:700;font-size:14px;box-shadow:0 8px 30px rgba(37,211,102,.45);border:none;cursor:pointer;text-decoration:none;transition:all .3s;font-family:Poppins,sans-serif}.wa-fab:hover{transform:translateY(-3px) scale(1.05);box-shadow:0 12px 40px rgba(37,211,102,.6)}.wa-fab svg{width:22px;height:22px;fill:white;flex-shrink:0}</style>
<a class="wa-fab" href="https://wa.me/263242707741?text=<?= rawurlencode((string) t('whatsapp_message')) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= t('home_book_call') ?> via WhatsApp">
<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.513 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.457L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.42 9.864-9.864.002-2.637-1.03-5.114-2.905-6.99C16.559 1.875 14.09 1.83 11.45 1.83c-5.437 0-9.862 4.421-9.866 9.865-.001 1.761.47 3.483 1.365 5.011L1.92 21.05l4.727-1.24zm12.317-5.908c-.3-.15-1.772-.875-2.046-.975-.275-.1-.475-.15-.675.15-.2.3-.775 1.025-.95 1.225-.175.2-.35.225-.65.075-.3-.15-1.265-.467-2.41-1.485-.89-.794-1.49-1.775-1.665-2.075-.175-.3-.02-.463.13-.612.135-.135.3-.35.45-.525.15-.175.2-.3.3-.5s.05-.375-.025-.525c-.075-.15-.675-1.625-.925-2.225-.244-.589-.48-.58-.675-.59-.175-.01-.375-.01-.575-.01-.2 0-.525.075-.8.375-.275.3-1.05 1.025-1.05 2.5s1.025 2.9 1.175 3.1c.15.2 2.013 3.074 4.875 4.31.68.295 1.21.47 1.62.6.685.217 1.31.187 1.805.113.55-.082 1.772-.725 2.022-1.4.25-.675.25-1.25.175-1.375-.075-.125-.275-.2-.575-.35z"/></svg>
<span><?= t('home_book_call') ?></span>
</a>
<script>window.MINYOUTH_PORTAL_URL = <?= json_encode(portal_url()) ?>;</script>
<script src="assets/js/site-config.js?v=20260901"></script>
<script src="assets/js/minyouth-widget.js?v=20260820b" defer></script>
<script src="assets/js/site-nav.js?v=20260901"></script>
</body></html>