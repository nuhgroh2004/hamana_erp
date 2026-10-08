function initSidebar() {
    const sideEl = document.getElementById('side');
    const navEl = document.getElementById('nav');
    const qEl = document.getElementById('q');
    const menuBtnEl = document.getElementById('menuBtn');
    const themeEl = document.getElementById('theme');

    if (!navEl || !qEl) return;

    const groups = Array.from(navEl.querySelectorAll('.grp'));

    const labelOf = (li) => {
        const link = li.querySelector('a');
        if (!link) return '';

        return Array.from(link.childNodes)
            .filter((node) => node.nodeType === Node.TEXT_NODE)
            .map((node) => node.textContent)
            .join('')
            .trim()
            .toLowerCase();
    };

    groups.forEach((grp) => {
        grp.dataset.open = grp.classList.contains('open') ? '1' : '0';

        const btn = grp.querySelector(':scope > button');
        if (!btn) return;

        btn.addEventListener('click', () => {
            const open = grp.classList.toggle('open');
            grp.dataset.open = open ? '1' : '0';
        });
    });

    qEl.addEventListener('input', () => {
        const filter = qEl.value.trim().toLowerCase();

        groups.forEach((grp) => {
            const name = (grp.dataset.g || '').toLowerCase();
            const groupMatch = Boolean(filter) && name.includes(filter);
            let visible = 0;

            grp.querySelectorAll('li').forEach((li) => {
                const show = !filter || groupMatch || labelOf(li).includes(filter);
                li.style.display = show ? '' : 'none';
                if (show) visible += 1;
            });

            const showGroup = !filter || groupMatch || visible > 0;
            grp.style.display = showGroup ? '' : 'none';

            const open = filter ? showGroup : grp.dataset.open === '1';
            grp.classList.toggle('open', open);
        });
    });

    if (menuBtnEl && sideEl) {
        menuBtnEl.addEventListener('click', () => sideEl.classList.toggle('show'));
    }

    if (themeEl) {
        themeEl.addEventListener('click', () => {
            const root = document.documentElement;
            const isDark = getComputedStyle(root).getPropertyValue('--bg').trim() === '#1b1d21';
            root.dataset.theme = isDark ? 'light' : 'dark';
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSidebar);
} else {
    initSidebar();
}
