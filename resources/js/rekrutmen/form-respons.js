import { rkmToast, rkmHttp, rkmReload, rkmConfirm } from './shared';

const rfrClear = document.getElementById('rfrClear');
if (rfrClear) {
    rfrClear.addEventListener('click', () => {
        rkmConfirm('Hapus semua respons? Tindakan ini tidak dapat dibatalkan.', {
            title: 'Hapus Semua Respons',
            okText: 'Ya, Hapus Semua',
        }).then((ok) => {
            if (!ok) return;
            rkmHttp(rfrClear.dataset.url, {}, 'DELETE').then(() => rkmReload()).catch((e) => rkmToast(e.message || 'Gagal.'));
        });
    });
}

document.querySelectorAll('[data-rfr-del]').forEach((btn) => {
    btn.addEventListener('click', () => {
        rkmConfirm('Hapus respons ini?', {
            title: 'Hapus Respons',
            okText: 'Ya, Hapus',
        }).then((ok) => {
            if (!ok) return;
            rkmHttp(btn.dataset.rfrDel, {}, 'DELETE').then(() => rkmReload()).catch((e) => rkmToast(e.message || 'Gagal.'));
        });
    });
});
