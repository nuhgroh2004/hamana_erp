import { rkmToast, rkmHttp, rkmCsrf } from './shared';

const rfbCopy = document.getElementById('rfbCopy');
if (rfbCopy) {
    rfbCopy.addEventListener('click', () => {
        const url = rfbCopy.dataset.url;
        (navigator.clipboard ? navigator.clipboard.writeText(url) : Promise.reject())
            .then(() => rkmToast('Tautan disalin.'))
            .catch(() => rkmToast(url));
    });
}

const rfbRegen = document.getElementById('rfbRegen');
if (rfbRegen) {
    rfbRegen.addEventListener('click', () => {
        if (!confirm('Buat tautan baru? Tautan lama otomatis tidak berlaku.')) return;
        rkmHttp(rfbRegen.dataset.url).then((d) => {
            const urlInput = document.getElementById('rfbUrl');
            const full = d.url || (window.location.origin + '/f/' + d.slug);
            if (urlInput) urlInput.value = full;
            if (rfbCopy) rfbCopy.dataset.url = full;
            const embed = document.getElementById('rfbEmbed');
            if (embed) embed.value = `<iframe src="${full}" width="100%" height="700" frameborder="0"></iframe>`;
            rkmToast(d.message || 'Tautan baru dibuat.');
        }).catch((e) => rkmToast(e.message || 'Gagal.'));
    });
}

const rfbForm = document.getElementById('rfbForm');
if (rfbForm) {
    rfbForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const fd = new FormData(rfbForm);
        const payload = {
            response_limit: parseInt(fd.get('response_limit') || '0', 10),
            close_at: fd.get('close_at') || null,
            success_msg: fd.get('success_msg') || null,
        };
        const btn = rfbForm.querySelector('button[type="submit"]');
        btn.disabled = true;
        fetch(rfbForm.dataset.url, {
            method: 'PUT',
            headers: { Accept: 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': rkmCsrf() },
            body: JSON.stringify(payload),
        })
            .then(async (r) => {
                const d = await r.json().catch(() => null);
                if (!r.ok) throw new Error((d && d.message) || 'Gagal menyimpan.');
                return d;
            })
            .then((d) => {
                btn.disabled = false;
                rkmToast(d.message || 'Tersimpan.');
            })
            .catch((e) => {
                btn.disabled = false;
                rkmToast(e.message || 'Gagal menyimpan.');
            });
    });
}
