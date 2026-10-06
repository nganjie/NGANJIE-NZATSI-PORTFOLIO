/**
 * Scroll and entrance animations for the public site.
 *
 * - [data-reveal]        becomes `.is-visible` when it enters the viewport.
 * - [data-reveal-group]  staggers the [data-reveal] elements it contains.
 * - [data-split]         splits a heading into words that rise one by one.
 * - [data-parallax]      moves with the scroll (and the mouse in the hero).
 * - [data-progress]      reading progress bar.
 * - .site-header         hides when scrolling down, comes back when scrolling up.
 *
 * Nothing runs when the visitor asks the system to reduce motion: the
 * content is then shown as is.
 */

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/**
 * Wrap every word of a heading in masked spans, keeping nested elements
 * (such as the highlighted words) as single animated units.
 */
function splitWords(element) {
    let index = 0;

    const wrap = (content) => {
        const outer = document.createElement('span');
        const inner = document.createElement('span');
        outer.className = 'split-word';
        outer.setAttribute('aria-hidden', 'true');
        inner.style.setProperty('--word-index', index++);
        inner.append(content);
        outer.append(inner);

        return outer;
    };

    const label = element.textContent.replace(/\s+/g, ' ').trim();

    [...element.childNodes].forEach((node) => {
        if (node.nodeType === Node.TEXT_NODE) {
            const fragment = document.createDocumentFragment();

            node.textContent.split(/(\s+)/).forEach((part) => {
                if (part.trim() === '') {
                    if (part.length) {
                        fragment.append(document.createTextNode(' '));
                    }
                } else {
                    fragment.append(wrap(document.createTextNode(part)));
                }
            });

            node.replaceWith(fragment);
        } else if (node.nodeType === Node.ELEMENT_NODE && node.tagName !== 'BR') {
            node.style.setProperty('--word-index', index);
            const words = [...node.childNodes];
            node.replaceChildren(...words.map((child) => wrap(child)));
        }
    });

    element.setAttribute('aria-label', label);
}

function setupReveal() {
    document.querySelectorAll('[data-split]').forEach((element) => {
        splitWords(element);

        if (!element.hasAttribute('data-reveal')) {
            element.setAttribute('data-reveal', 'fade');
        }
    });

    document.querySelectorAll('[data-reveal-group]').forEach((group) => {
        const step = Number(group.dataset.revealGroup) || 90;

        group.querySelectorAll('[data-reveal]').forEach((element, index) => {
            element.style.setProperty('--reveal-delay', `${index * step}ms`);
        });
    });

    const elements = document.querySelectorAll('[data-reveal]');

    if (!('IntersectionObserver' in window)) {
        elements.forEach((element) => element.classList.add('is-visible'));

        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.12 },
    );

    elements.forEach((element) => observer.observe(element));
}

function setupScrollEffects() {
    const header = document.querySelector('.site-header');
    const parallax = [...document.querySelectorAll('[data-parallax]')];
    const progress = document.querySelector('[data-progress]');
    let lastY = window.scrollY;
    let ticking = false;

    const update = () => {
        const y = window.scrollY;

        parallax.forEach((element) => {
            element.style.setProperty('--sy', `${y * Number(element.dataset.parallax)}px`);
        });

        if (progress) {
            const max = document.documentElement.scrollHeight - window.innerHeight;
            progress.style.setProperty('--progress', max > 0 ? Math.min(1, y / max) : 0);
        }

        if (header) {
            const menuOpen = header.querySelector('[data-menu-toggle]')?.getAttribute('aria-expanded') === 'true';
            header.classList.toggle('is-scrolled', y > 24);
            header.classList.toggle('is-hidden', !menuOpen && y > 320 && y > lastY + 4);

            if (y < lastY - 4) {
                header.classList.remove('is-hidden');
            }
        }

        lastY = y;
        ticking = false;
    };

    window.addEventListener('scroll', () => {
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(update);
        }
    }, { passive: true });

    update();

    if (parallax.length && window.matchMedia('(pointer: fine)').matches) {
        window.addEventListener('pointermove', (event) => {
            const mx = (event.clientX / window.innerWidth - 0.5) * 2;
            const my = (event.clientY / window.innerHeight - 0.5) * 2;

            parallax.forEach((element) => {
                element.style.setProperty('--mx', mx.toFixed(3));
                element.style.setProperty('--my', my.toFixed(3));
            });
        }, { passive: true });
    }
}

export function initMotion() {
    window.motionReady = true;

    if (reduceMotion) {
        document.querySelectorAll('[data-reveal]').forEach((element) => element.classList.add('is-visible'));

        return;
    }

    setupReveal();
    setupScrollEffects();
}
