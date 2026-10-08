function initUmum() {
    const sel = document.getElementById('setLang');
    if (!sel) return;

    const form = sel.closest('form');
    if (!form) return;

    sel.addEventListener('change', () => {
        form.submit();
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initUmum);
} else {
    initUmum();
}
