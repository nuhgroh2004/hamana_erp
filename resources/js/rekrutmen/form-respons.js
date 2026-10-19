import { rkmToast, rkmHttp, rkmReload } from './shared';

const rfrClear = document.getElementById('rfrClear');
if (rfrClear) {
    rfrClear.addEventListener('click', () => {
        if (!confirm('Hapus semua respons? Tindakan ini tidak dapat dibatalkan.')) return;
        rkmHttp(rfrClear.dataset.url, {}, 'DELETE').then(() => rkmReload()).catch((e) => rkmToast(e.message || 'Gagal.'));
    });
}

document.querySelectorAll('[data-rfr-del]').forEach((btn) => {
    btn.addEventListener('click', () => {
        if (!confirm('Hapus respons ini?')) return;
        rkmHttp(btn.dataset.rfrDel, {}, 'DELETE').then(() => rkmReload()).catch((e) => rkmToast(e.message || 'Gagal.'));
    });
});
