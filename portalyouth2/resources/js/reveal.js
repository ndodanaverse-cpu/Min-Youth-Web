import { animate, inView } from 'motion';

const reducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const ease = [0.16, 1, 0.3, 1];

function reveal(node, delay = 0) {
    animate(
        node,
        { opacity: 1, y: 0 },
        { duration: 0.6, ease, delay },
    );
}

function revealGroup(group) {
    const items = group.querySelectorAll('[data-reveal]');

    if (reducedMotion()) {
        items.forEach((item) => reveal(item, 0));

        return;
    }

    items.forEach((item, index) => reveal(item, index * 0.08));
}

function animateCounter(node) {
    const target = Number(node.dataset.counter || 0);
    const prefix = node.dataset.prefix || '';
    const suffix = node.dataset.suffix || '';
    const decimals = Number(node.dataset.decimals || 0);
    const duration = Number(node.dataset.duration || 1600);
    const start = performance.now();

    const format = (value) => (
        `${prefix}${value.toLocaleString('en-ZW', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals,
        })}${suffix}`
    );

    node.textContent = format(0);

    const tick = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);

        node.textContent = format(target * eased);

        if (progress < 1) {
            requestAnimationFrame(tick);
        }
    };

    requestAnimationFrame(tick);
}

export function initReveal() {
    const supportsObserver = 'IntersectionObserver' in window;

    document.querySelectorAll('[data-reveal-group]').forEach((group) => {
        if (reducedMotion() || !supportsObserver) {
            revealGroup(group);

            return;
        }

        inView(group, () => revealGroup(group), { once: true, amount: 0.15 });
    });

    document
        .querySelectorAll('[data-reveal]:not([data-reveal-group] [data-reveal])')
        .forEach((node) => {
            if (reducedMotion() || !supportsObserver) {
                reveal(node);

                return;
            }

            inView(node, () => reveal(node), { once: true, amount: 0.15 });
        });

    document.querySelectorAll('[data-counter]').forEach((node) => {
        if (reducedMotion() || !supportsObserver) {
            animateCounter(node);

            return;
        }

        inView(node, () => animateCounter(node), { once: true, amount: 0.6 });
    });
}
