function initUmum() {
    const sel = document.getElementById('setLang');
    if (!sel) return;

    sel.addEventListener('change', () => {
        if (sel.value) window.location.href = sel.value;
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initUmum);
} else {
    initUmum();
}
