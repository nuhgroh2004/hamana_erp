const RKM_STAGES = ['Baru', 'Screening', 'Tes Teknis', 'Interview HR', 'Interview User', 'Offering', 'Hired'];

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

const rkmToastEl = document.getElementById('rkmToast');
let rkmToastTimer = null;

export function rkmToast(text) {
    if (!rkmToastEl) return;
    rkmToastEl.textContent = text;
    rkmToastEl.classList.add('on');
    clearTimeout(rkmToastTimer);
    rkmToastTimer = setTimeout(() => rkmToastEl.classList.remove('on'), 2600);
}

const rkmCfEl = document.getElementById('rkmConfirm');
let rkmCfResolve = null;

export function rkmConfirm(message, opts) {
    if (!rkmCfEl) return Promise.resolve(window.confirm(message));
    const o = opts || {};
    rkmCfEl.querySelector('#rkmConfirmTitle').textContent = o.title || 'Konfirmasi';
    rkmCfEl.querySelector('#rkmConfirmMsg').textContent = message;
    rkmCfEl.querySelector('[data-rkm-cf-cancel]').textContent = o.cancelText || 'Batal';
    rkmCfEl.querySelector('[data-rkm-cf-ok]').textContent = o.okText || 'Ya, Hapus';
    rkmCfEl.classList.add('on');
    return new Promise((resolve) => { rkmCfResolve = resolve; });
}

function rkmCfClose(val) {
    rkmCfEl?.classList.remove('on');
    if (rkmCfResolve) { rkmCfResolve(val); rkmCfResolve = null; }
}

if (rkmCfEl) {
    rkmCfEl.querySelector('[data-rkm-cf-cancel]').addEventListener('click', () => rkmCfClose(false));
    rkmCfEl.querySelector('[data-rkm-cf-ok]').addEventListener('click', () => rkmCfClose(true));
    rkmCfEl.addEventListener('click', (e) => { if (e.target === rkmCfEl) rkmCfClose(false); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && rkmCfEl.classList.contains('on')) rkmCfClose(false); });
}

document.addEventListener('click', (e) => {
    const t = e.target.closest('[data-toast]');
    if (t) {
        e.preventDefault();
        rkmToast(t.dataset.toast);
    }
});

export function rkmCsrf() {
    const meta = document.querySelector('meta[name="csrf-token"]');
    return meta ? meta.content : '';
}

export function rkmReload(msg) {
    if (msg) rkmToast(msg);
    setTimeout(() => window.location.reload(), 700);
}

export function rkmHttp(url, payload, method) {
    const opts = {
        method: method || 'POST',
        headers: { Accept: 'application/json', 'X-CSRF-TOKEN': rkmCsrf() },
    };

    if (payload instanceof FormData) {
        opts.body = payload;
    } else {
        opts.headers['Content-Type'] = 'application/json';
        opts.body = JSON.stringify(payload || {});
    }

    return fetch(url, opts).then(async (r) => {
        let data = null;
        try {
            data = await r.json();
        } catch (e) {
            data = null;
        }
        if (!r.ok) {
            const msg = (data && data.message) || 'Terjadi kesalahan.';
            const err = new Error(msg);
            err.data = data;
            throw err;
        }
        return data;
    });
}

const rkmOvEl = document.getElementById('rkmOv');
const rkmDrEl = document.getElementById('rkmDr');

function rkmCloseDrawer() {
    rkmOvEl?.classList.remove('on');
}

function rkmStageTag(st) {
    const s = Number(st);
    if (s < 0) return '<span class="rkm-tag r">Ditolak</span>';
    const cls = s >= 6 ? 'g' : s >= 5 ? 'y' : s >= 3 ? 'b' : 'n';
    return `<span class="rkm-tag ${cls}">${RKM_STAGES[s] || 'Baru'}</span>`;
}

function rkmDrawerShell(header, body) {
    return `
        <div class="rkm-dh">
            <div><b>${header.name || ''}</b><small>${header.sub || ''}</small></div>
            <button type="button" data-rkm-close>&times;</button>
        </div>
        <div class="rkm-db">${body}</div>`;
}

function rkmActBtn(url, cls, label) {
    return `<button type="button" class="rkm-btn ${cls}" data-rkm-act data-url="${url}">${label}</button>`;
}

function rkmOpenDrawer(d) {
    if (!rkmDrEl || !rkmOvEl) return;
    const st = Number(d.drSt ?? -1);
    const stages = RKM_STAGES.map((s, i) => `<i class="${st >= i ? 'd' : ''}"></i>`).join('');

    let actions = '';
    if (d.drMove) {
        actions += rkmActBtn(d.drMove, 'p', `Lanjut ke ${d.drNext || ''}`);
    }
    if (d.drSend) {
        actions += rkmActBtn(d.drSend, 'p', 'Setujui & Kirim');
    }
    if (d.drAccept) {
        actions += rkmActBtn(d.drAccept, 'p', 'Diterima');
    }
    if (d.drDecline) {
        actions += rkmActBtn(d.drDecline, 'd', 'Ditolak');
    }
    if (d.drSched) {
        actions += `<a class="rkm-btn" href="${d.drSched}">Jadwalkan</a>`;
    }
    if (d.drReject) {
        actions += `<button type="button" class="rkm-btn d" data-rkm-act data-confirm="Kandidat ditolak dan masuk talent pool?" data-url="${d.drReject}">Tolak</button>`;
    }
    if (d.drReactivate) {
        actions += rkmActBtn(d.drReactivate, '', 'Aktifkan Kembali');
    }
    if (d.drCancel) {
        actions += `<button type="button" class="rkm-btn d" data-rkm-act data-confirm="Batalkan jadwal interview ini?" data-url="${d.drCancel}">Batalkan Jadwal</button>`;
    }

    const score = d.drScore && d.drScore !== '0' ? d.drScore : 'Belum ada';

    const body = `
        <div class="rkm-st">${stages}</div>
        <div>${rkmStageTag(st)}</div>
        <h5>Profil</h5>
        <div class="rkm-kv">
            <span>Pendidikan</span>${d.drEdu || '—'}
            <span>Pengalaman</span>${d.drExp || '—'} tahun
            <span>Domisili</span>${d.drCity || '—'}
            <span>Sumber</span>${d.drSrc || '—'}
            <span>Skor tes teknis</span>${score}
            <span>Catatan</span>${d.drNote || '—'}
        </div>
        <h5>Riwayat</h5>
        <div class="rkm-tl"><div>${d.drLog || 'Melamar'}<br><small></small></div></div>
        <div class="rkm-act">${actions}</div>`;

    rkmDrEl.innerHTML = rkmDrawerShell({ name: d.drName, sub: d.drJob }, body);
    rkmDrEl.querySelector('[data-rkm-close]')?.addEventListener('click', rkmCloseDrawer);
    rkmOvEl.classList.add('on');
}

function rkmOpenForm(trigger) {
    const tpl = document.getElementById(trigger.dataset.rkmForm);
    if (!tpl || !rkmDrEl || !rkmOvEl) return;

    rkmDrEl.innerHTML = '';
    rkmDrEl.appendChild(tpl.content.cloneNode(true));

    const form = rkmDrEl.querySelector('form');
    if (form) {
        if (form.dataset.urlBase && trigger.dataset.cid) {
            form.dataset.url = form.dataset.urlBase.replace(/\/$/, '') + '/' + encodeURIComponent(trigger.dataset.cid) + '/pipeline';
        }
        const nameEl = rkmDrEl.querySelector('.rkm-fm-name');
        if (nameEl && trigger.dataset.cname) {
            nameEl.textContent = `${trigger.dataset.cname} → Pipeline`;
        }
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            if (btn) btn.disabled = true;
            rkmHttp(form.dataset.url, new FormData(form))
                .then((data) => {
                    rkmCloseDrawer();
                    rkmReload(data && data.message);
                })
                .catch((err) => {
                    rkmToast(err.message);
                    if (btn) btn.disabled = false;
                });
        });
    }

    rkmDrEl.querySelector('[data-rkm-close]')?.addEventListener('click', rkmCloseDrawer);
    rkmOvEl.classList.add('on');
}

document.addEventListener('click', (e) => {
    const act = e.target.closest('[data-rkm-act]');
    if (act) {
        e.preventDefault();
        const url = act.dataset.url;
        if (!url) return;
        const go = () => {
            act.disabled = true;
            rkmHttp(url, {})
                .then((data) => rkmReload(data && data.message))
                .catch((err) => {
                    rkmToast(err.message);
                    act.disabled = false;
                });
        };
        if (act.dataset.confirm) {
            rkmConfirm(act.dataset.confirm, { title: 'Konfirmasi', okText: 'Ya, Lanjutkan' }).then((ok) => { if (ok) go(); });
        } else {
            go();
        }
        return;
    }

    const formTrigger = e.target.closest('[data-rkm-form]');
    if (formTrigger) {
        e.preventDefault();
        rkmOpenForm(formTrigger);
        return;
    }

    const detail = e.target.closest('[data-dr-name]');
    if (detail && !e.target.closest('[data-rkm-act], a, button')) {
        rkmOpenDrawer(detail.dataset);
        return;
    }

    if (e.target === rkmOvEl) {
        rkmCloseDrawer();
    }
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') rkmCloseDrawer();
});

document.querySelectorAll('select[data-filter-dept]').forEach((sel) => {
    const target = document.getElementById(sel.dataset.filterDept);
    if (!target) return;
    sel.addEventListener('change', () => {
        const val = sel.value;
        target.querySelectorAll('option[data-dept]').forEach((opt) => {
            opt.hidden = val !== '' && opt.dataset.dept !== val;
        });
        if (target.selectedOptions[0] && target.selectedOptions[0].hidden) target.value = '';
    });
});
