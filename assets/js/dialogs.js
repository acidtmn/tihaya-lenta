(function () {
    'use strict';

    let activeDialog = null;
    const focusableSelector = 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex="0"]';

    /* Общий контроллер удерживает фокус в открытом окне и возвращает его кнопке. */
    ['search', 'subscribe'].forEach(function (kind) {
        const button = document.querySelector('[data-' + kind + '-toggle]');
        const panel = document.querySelector('[data-' + kind + '-panel]');
        const close = document.querySelector('[data-' + kind + '-close]');
        if (!button || !panel || !close) return;
        let disabledSiblings = [];

        const hide = function () {
            panel.hidden = true;
            button.setAttribute('aria-expanded', 'false');
            document.body.classList.remove('nbs-' + kind + '-is-open');
            disabledSiblings.forEach(function (element) { element.inert = false; });
            disabledSiblings = [];
            activeDialog = null;
            button.focus();
        };
        const show = function () {
            if (activeDialog) activeDialog();
            panel.hidden = false;
            button.setAttribute('aria-expanded', 'true');
            document.body.classList.add('nbs-' + kind + '-is-open');
            let ancestor = panel;
            while (ancestor.parentElement && ancestor !== document.body) {
                Array.from(ancestor.parentElement.children).forEach(function (sibling) {
                    if (sibling !== ancestor && !sibling.inert) {
                        sibling.inert = true;
                        disabledSiblings.push(sibling);
                    }
                });
                ancestor = ancestor.parentElement;
            }
            activeDialog = hide;
            (panel.querySelector('input[type="search"]') || close).focus();
        };
        button.addEventListener('click', show);
        close.addEventListener('click', hide);
        panel.addEventListener('click', function (event) { if (event.target === panel) hide(); });
        panel.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                event.preventDefault();
                hide();
            }
            if (event.key !== 'Tab') return;
            const elements = Array.from(panel.querySelectorAll(focusableSelector)).filter(function (element) { return element.getClientRects().length; });
            const first = elements[0];
            const last = elements[elements.length - 1];
            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        });
    });
}());
