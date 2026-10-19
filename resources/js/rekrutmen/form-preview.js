import { rfpRender, rfpCollect, rfpDone } from './form-render';

const pvbox = document.getElementById('pvbox');
if (window.RF && pvbox) {
    const RFP = window.RF;

    function paint() {
        pvbox.innerHTML = `<div class="rf-fm">${rfpRender(RFP.fields, { title: RFP.title, description: RFP.description, prefix: 'pv' })}</div>`;
        pvbox.querySelector('[data-submit]')?.addEventListener('click', () => {
            const { ok } = rfpCollect(pvbox, RFP.fields, 'pv');
            if (!ok) return;
            rfpDone(pvbox, { title: RFP.title, message: RFP.successMsg, preview: true });
            pvbox.querySelector('[data-again]')?.addEventListener('click', paint);
        });
    }
    paint();
}
