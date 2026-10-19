import { rkmToast, rkmHttp, rkmReload, rkmConfirm } from './shared';

const rfNewBtn = document.getElementById('rfNew');

if (rfNewBtn) {
    rfNewBtn.addEventListener('click', () => {
        rfNewBtn.disabled = true;
        rkmHttp(window.RF.storeUrl, {})
            .then((d) => {
                if (d && d.url) window.location.href = d.url;
            })
            .catch((e) => {
                rfNewBtn.disabled = false;
                rkmToast(e.message || 'Gagal membuat form.');
            });
    });
}

document.querySelectorAll('[data-rf-toggle]').forEach((btn) => {
    btn.addEventListener('click', () => {
        rkmHttp(btn.dataset.rfToggle).then(() => rkmReload()).catch((e) => rkmToast(e.message || 'Gagal.'));
    });
});

document.querySelectorAll('[data-rf-dup]').forEach((btn) => {
    btn.addEventListener('click', () => {
        rkmHttp(btn.dataset.rfDup).then((d) => {
            rkmToast(d.message || 'Form diduplikasi.');
            setTimeout(() => { window.location.href = d.url; }, 700);
        }).catch((e) => rkmToast(e.message || 'Gagal.'));
    });
});

document.querySelectorAll('[data-rf-del]').forEach((btn) => {
    btn.addEventListener('click', () => {
        const title = btn.dataset.title || '';
        rkmConfirm(`Hapus form "${title}" beserta semua responsnya?`, {
            title: 'Hapus Form',
            okText: 'Ya, Hapus',
        }).then((ok) => {
            if (!ok) return;
            rkmHttp(btn.dataset.rfDel, {}, 'DELETE').then(() => rkmReload()).catch((e) => rkmToast(e.message || 'Gagal.'));
        });
    });
});

document.querySelectorAll('[data-rf-copy]').forEach((btn) => {
    btn.addEventListener('click', () => {
        const url = btn.dataset.rfCopy;
        (navigator.clipboard ? navigator.clipboard.writeText(url) : Promise.reject())
            .then(() => rkmToast('Tautan disalin.'))
            .catch(() => rkmToast(url));
    });
});
