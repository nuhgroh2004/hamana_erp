import { rfpRender, rfpCollect, rfpDone, rfpFill } from './rekrutmen/form-render';

const pvbox = document.getElementById('pvbox');
if (window.RF && pvbox) {
    const RFP = window.RF;

    function paint() {
        pvbox.innerHTML = `<div class="rf-fm">${rfpRender(RFP.fields, { title: RFP.title, description: RFP.description, prefix: 'pb' })}</div>`;
        const submit = pvbox.querySelector('[data-submit]');
        submit?.addEventListener('click', () => {
            const { ok } = rfpCollect(pvbox, RFP.fields, 'pb');
            if (!ok) return;
            submit.disabled = true;
            fetch(RFP.submitUrl, {
                method: 'POST',
                headers: { Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
                body: rfpFill(pvbox, RFP.fields, 'pb'),
            })
                .then(async (r) => {
                    const d = await r.json().catch(() => null);
                    if (!r.ok) throw new Error((d && d.message) || 'Gagal mengirim.');
                    return d;
                })
                .then((d) => {
                    rfpDone(pvbox, { title: RFP.title, message: d.message || RFP.successMsg });
                    pvbox.querySelector('[data-again]')?.addEventListener('click', paint);
                })
                .catch((e) => {
                    submit.disabled = false;
                    let errBox = pvbox.querySelector('.rf-er.rf-puberr');
                    if (!errBox) {
                        errBox = document.createElement('div');
                        errBox.className = 'rf-er rf-puberr';
                        errBox.style.cssText = 'background:var(--bad);color:var(--badt);padding:8px 12px;margin-bottom:10px;font-size:13px';
                        pvbox.querySelector('.rf-fm')?.prepend(errBox);
                    }
                    errBox.textContent = e.message || 'Gagal mengirim.';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
        });
    }
    paint();
}
