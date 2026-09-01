(function () {
    const script = document.currentScript;
    const scriptPath = new URL(script.src, window.location.href).pathname;
    const siteRoot = scriptPath.split('/assets/js/')[0] + '/';
    const language = new URLSearchParams(window.location.search).get('lang') ||
        (document.cookie.match(/(?:^|; )site_lang=([^;]+)/) || [])[1] ||
        (document.cookie.match(/(?:^|; )minyouth_lang=([^;]+)/) || [])[1] ||
        'en';
    const labels = {
        en: { home: 'Home', about: 'About Us', departments: 'Departments', resources: 'Resources', gallery: 'Gallery', news: 'News', contact: 'Contact Us', apply: 'Portal', language: 'Language' },
        sn: { home: 'Kumba', about: 'Nezvedu', departments: 'Madhipatimendi', resources: 'Zviwanikwa', gallery: 'Maficha', news: 'Nhau', contact: 'Taura Nesu', apply: 'Portal', language: 'Mutauro' },
        nr: { home: 'Ekhaya', about: 'Malunga Lathi', departments: 'Amacandelo', resources: 'Izinsiza', gallery: 'Isithonjana', news: 'Izindaba', contact: 'Xhumana Lathi', apply: 'Portal', language: 'Ulimi' }
    };
    const languages = [['en', 'English'], ['sn', 'Shona'], ['nr', 'Ndebele']];
    const text = labels[language] || labels.en;
    const currentPage = window.location.pathname.split('/').pop() || 'index.php';
    const pageExtension = currentPage.endsWith('.html') ? '.html' : '.php';

    function pageUrl(name) {
        return siteRoot + name + pageExtension;
    }

    const existingPortal = document.getElementById('site-portal');
    const portalUrl = (
        window.MINYOUTH_PORTAL_URL ||
        (existingPortal && existingPortal.getAttribute('href')) ||
        'http://127.0.0.1:8000'
    ).trim();

    const isResourceSection = currentPage === 'resources' + pageExtension || currentPage === 'gallery' + pageExtension;

    function linkMarkup(key, href, mobile) {
        const active = key === 'home' ? currentPage === 'index' + pageExtension : currentPage === href + pageExtension;
        const classes = mobile
            ? 'block py-sm px-sm rounded-lg transition-all ' + (active ? 'text-primary font-bold' : 'text-on-surface-variant font-medium hover:text-primary hover:bg-surface-container-high')
            : 'text-on-surface-variant font-medium hover:text-primary transition-all relative group py-1';
        const style = active ? ' style="color:#008000"' : '';
        const underline = mobile || !active ? '' : '<span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary"></span>';
        return '<a class="' + classes + '" href="' + pageUrl(href) + '"' + style + '>' + text[key] + underline + '</a>';
    }

    function resourcesMarkup(mobile) {
        const parentClasses = mobile
            ? 'cursor-pointer list-none block py-sm px-sm rounded-lg transition-all ' + (isResourceSection ? 'text-primary font-bold' : 'text-on-surface-variant font-medium hover:text-primary hover:bg-surface-container-high')
            : (isResourceSection
                ? 'text-primary font-bold border-b-2 border-primary pb-1 inline-flex items-center gap-1'
                : 'text-on-surface-variant font-medium hover:text-primary transition-all relative py-1 inline-flex items-center gap-1');
        const activeStyle = isResourceSection ? ' style="color:#008000"' : '';
        const childClasses = mobile
            ? 'ml-md block py-sm px-sm rounded-lg transition-all text-on-surface-variant font-medium hover:text-primary hover:bg-surface-container-high'
            : 'block bg-surface px-md py-sm text-on-surface-variant font-medium shadow-lg hover:bg-surface-container-high hover:text-primary';
        if (mobile) {
            return '<details class="group">' +
                '<summary class="' + parentClasses + '"' + activeStyle + '>' + text.resources + ' <span aria-hidden="true">&#9662;</span></summary>' +
                '<a class="' + childClasses + '" href="' + pageUrl('gallery') + '">' + text.gallery + '</a>' +
                '<a class="' + childClasses + '" href="' + pageUrl('resources') + '">' + text.resources + '</a>' +
                '</details>';
        }
        return '<div class="relative group">' +
            '<a class="' + parentClasses + '" href="' + pageUrl('resources') + '"' + activeStyle + '>' + text.resources + ' <span aria-hidden="true">&#9662;</span></a>' +
            '<div class="absolute left-0 top-full hidden min-w-36 pt-2 group-hover:block group-focus-within:block">' +
            '<a class="' + childClasses + '" href="' + pageUrl('gallery') + '">' + text.gallery + '</a>' +
            '<a class="' + childClasses + '" href="' + pageUrl('resources') + '">' + text.resources + '</a>' +
            '</div></div>';
    }

    function aboutMarkup(mobile) {
        const isAboutSection = currentPage === 'about' + pageExtension || currentPage === 'contact' + pageExtension;
        if (!mobile) {
            const parentClasses = isAboutSection
                ? 'text-primary font-bold border-b-2 border-primary pb-1 inline-flex items-center gap-1'
                : 'text-on-surface-variant font-medium hover:text-primary transition-all relative py-1 inline-flex items-center gap-1';
            return '<div class="relative group"><a class="' + parentClasses + '" href="' + pageUrl('about') + '"' + (isAboutSection ? ' style="color:#008000"' : '') + '>' + text.about + ' <span aria-hidden="true">&#9662;</span></a><div class="absolute left-0 top-full hidden min-w-36 pt-2 group-hover:block group-focus-within:block"><a class="block bg-surface px-md py-sm text-on-surface-variant font-medium shadow-lg hover:bg-surface-container-high hover:text-primary" href="' + pageUrl('about') + '">' + text.about + '</a><a class="block bg-surface px-md py-sm text-on-surface-variant font-medium shadow-lg hover:bg-surface-container-high hover:text-primary" href="' + pageUrl('contact') + '">' + text.contact + '</a></div></div>';
        }
        const parentClasses = 'cursor-pointer list-none block py-sm px-sm rounded-lg transition-all ' + (isAboutSection ? 'text-primary font-bold' : 'text-on-surface-variant font-medium hover:text-primary hover:bg-surface-container-high');
        const childClasses = 'ml-md block py-sm px-sm rounded-lg transition-all ' + (currentPage === 'about' + pageExtension ? 'text-primary font-bold' : 'text-on-surface-variant font-medium hover:text-primary hover:bg-surface-container-high');
        return '<details class="group"><summary class="' + parentClasses + '"' + (isAboutSection ? ' style="color:#008000"' : '') + '>' + text.about + ' <span aria-hidden="true">&#9662;</span></summary><a class="' + childClasses + '" href="' + pageUrl('about') + '">' + text.about + '</a><a class="' + childClasses + '" href="' + pageUrl('contact') + '">' + text.contact + '</a></details>';
    }

    function languageMarkup(mobile) {
        const current = language;
        const options = languages.map(function (item) {
            return '<a href="' + window.location.pathname + '?lang=' + item[0] + '" class="block px-3 py-2 text-sm text-on-surface-variant hover:bg-surface-container-high hover:text-black whitespace-nowrap">' + item[1] + '</a>';
        }).join('');
        const code = current.toUpperCase();
        return '<details id="' + (mobile ? 'site-language-mobile' : 'site-language') + '" class="' + (mobile ? 'pt-sm relative group' : 'hidden md:flex relative group') + '"><summary class="list-none cursor-pointer flex items-center gap-2 text-sm font-medium text-on-surface-variant hover:text-black" title="' + text.language + '" aria-label="' + text.language + '"><span>' + text.language + ':</span><span>' + code + '</span><span aria-hidden="true">&#9662;</span></summary><div class="absolute right-0 top-full mt-2 z-50 min-w-40 bg-surface border border-outline-variant rounded-lg shadow-lg p-1">' + options + '</div></details>';
    }

    function portalMarkup(mobile) {
        const classes = mobile
            ? 'w-full bg-primary text-on-primary font-label-md px-md py-sm rounded-lg hover:shadow-lg transition-all active:scale-95 inline-flex items-center justify-center text-center'
            : 'bg-primary text-on-primary font-label-md px-md py-xs rounded-lg hover:shadow-lg transition-all active:scale-95 whitespace-nowrap inline-flex items-center justify-center';
        const id = mobile ? 'site-portal-mobile' : 'site-portal';
        return '<a id="' + id + '" href="' + portalUrl + '" target="_blank" rel="noopener noreferrer" class="' + classes + '" style="background-color:#008000">' + text.apply + '</a>';
    }

    function applyPortalAttrs(el) {
        if (!el) return;
        el.id = el.id || 'site-portal';
        el.setAttribute('href', portalUrl);
        el.setAttribute('target', '_blank');
        el.setAttribute('rel', 'noopener noreferrer');
    }

    const desktopLinks = document.getElementById('site-desktop-nav') || document.querySelector('header nav > div:nth-child(2)');
    if (desktopLinks) {
        desktopLinks.id = 'site-desktop-nav';
        desktopLinks.innerHTML =
            linkMarkup('home', 'index', false) +
            aboutMarkup(false) +
            linkMarkup('departments', 'departments', false) +
            resourcesMarkup(false) +
            linkMarkup('news', 'news', false);
        if (!document.getElementById('site-language')) {
            const nav = desktopLinks.parentElement;
            nav.insertAdjacentHTML('beforeend', languageMarkup(false));
        }
    }

    const desktopCta = document.getElementById('site-portal') ||
        document.querySelector('header nav > div:nth-child(3) > a');
    applyPortalAttrs(desktopCta);

    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu) {
        mobileMenu.innerHTML = '<div class="px-margin-mobile py-base space-y-base max-w-7xl mx-auto">' +
            linkMarkup('home', 'index', true) +
            aboutMarkup(true) +
            linkMarkup('departments', 'departments', true) +
            resourcesMarkup(true) +
            linkMarkup('news', 'news', true) +
            languageMarkup(true) +
            portalMarkup(true) +
            '</div>';
    }
})();
