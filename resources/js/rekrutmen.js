const rkmEl = document.getElementById('rkm');

if (rkmEl) {
    const RKM_KEY = 'rkm.subnav';

    if (localStorage.getItem(RKM_KEY) === '0') {
        rkmEl.classList.add('sub-off');
    }

    const hideBtn = document.getElementById('rkmHide');
    const showBtn = document.getElementById('rkmShow');

    hideBtn?.addEventListener('click', () => {
        rkmEl.classList.add('sub-off');
        localStorage.setItem(RKM_KEY, '0');
    });

    showBtn?.addEventListener('click', () => {
        rkmEl.classList.remove('sub-off');
        localStorage.setItem(RKM_KEY, '1');
    });
}
