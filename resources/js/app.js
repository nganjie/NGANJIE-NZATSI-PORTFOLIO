import { initMotion } from './motion';

/**
 * Public site: mobile menu toggle and animations. Everything works without JavaScript.
 */
document.addEventListener('DOMContentLoaded', () => {
    initMotion();

    const toggle = document.querySelector('[data-menu-toggle]');
    const menu = document.getElementById('menu-mobile');

    if (!toggle || !menu) {
        return;
    }

    const setOpen = (open) => {
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
        menu.hidden = !open;
        document.body.classList.toggle('overflow-hidden', open);
    };

    toggle.addEventListener('click', () => setOpen(toggle.getAttribute('aria-expanded') !== 'true'));
    menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setOpen(false)));
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            setOpen(false);
            toggle.focus();
        }
    });
});
