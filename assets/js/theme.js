(function () {
    'use strict';

    const menuButton = document.querySelector('[data-menu-toggle]');
    const menu = document.querySelector('[data-menu]');
    document.documentElement.classList.add('tl-js');

    if (menuButton && menu) {
        menuButton.addEventListener('click', function () {
            const isOpen = menuButton.getAttribute('aria-expanded') === 'true';
            menuButton.setAttribute('aria-expanded', String(!isOpen));
            menu.classList.toggle('is-open', !isOpen);
        });
        menu.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                menu.classList.remove('is-open');
                menuButton.setAttribute('aria-expanded', 'false');
                menuButton.focus();
            }
        });
    }

    /* Отдельная кнопка сохраняет родительскую ссылку доступной на сенсорных экранах. */
    document.querySelectorAll('.nbs-menu .menu-item-has-children').forEach(function (item, index) {
        const submenu = item.querySelector(':scope > .sub-menu');
        const link = item.querySelector(':scope > a');
        if (!submenu || !link) return;
        submenu.id = 'tl-submenu-' + index;
        const toggle = document.createElement('button');
        toggle.type = 'button';
        toggle.className = 'tl-submenu-toggle';
        toggle.textContent = '▾';
        toggle.setAttribute('aria-label', window.tlThemeData.submenuLabel + ': ' + link.textContent);
        toggle.setAttribute('aria-controls', submenu.id);
        toggle.setAttribute('aria-expanded', 'false');
        link.after(toggle);
        toggle.addEventListener('click', function () {
            const open = toggle.getAttribute('aria-expanded') !== 'true';
            toggle.setAttribute('aria-expanded', String(open));
            item.classList.toggle('tl-submenu-open', open);
        });
    });

    document.querySelectorAll('[data-copy-link]').forEach(function (button) {
        button.addEventListener('click', async function () {
            const status = button.parentElement.querySelector('[data-copy-status]');
            try {
                await navigator.clipboard.writeText(button.dataset.copyLink);
                if (status) status.textContent = window.tlThemeData.copiedLabel;
            } catch (error) {
                if (status) status.textContent = button.dataset.copyLink;
            }
        });
    });
}());
