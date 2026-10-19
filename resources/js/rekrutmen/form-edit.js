import { rkmToast, rkmCsrf } from './shared';

const RF = window.RF;
const rfeList = document.getElementById('rfeList');

if (RF && rfeList) {
    const TY = {
        text: 'Teks Pendek',
        long: 'Paragraf',
        num: 'Angka',
        date: 'Tanggal',
        enum: 'Dropdown (Enum)',
        radio: 'Pilihan Tunggal',
        check: 'Kotak Centang',
        file: 'Upload File (PDF / JPG)',
    };

    let fields = (RF.fields || []).map((f) => ({
        id: f.id || null,
        type: f.type,
        label: f.label || '',
        help: f.help || '',
        options: f.options || [],
        file_types: (f.file_types && f.file_types.length) ? f.file_types : ['pdf', 'jpg'],
        max_mb: f.max_mb || 5,
        is_required: f.is_required ? 1 : 0,
    }));
    let sel = null;

    const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

    const infoTitle = document.getElementById('rfeTitle');
    const infoDesc = document.getElementById('rfeDesc');
    const saveBtn = document.getElementById('rfeSave');

    function fk(f) {
        switch (f.type) {
            case 'text': return '<div class="ph">Jawaban singkat</div>';
            case 'long': return '<div class="ph" style="height:46px">Jawaban panjang</div>';
            case 'num': return '<div class="ph">Angka</div>';
            case 'date': return '<div class="ph" style="max-width:180px">dd/mm/yyyy</div>';
            case 'enum': return `<div class="ph">Pilih… ▾ (${f.options.length} opsi)</div>`;
            case 'radio': return f.options.map((o) => `<div>○ ${esc(o)}</div>`).join('');
            case 'check': return f.options.map((o) => `<div>☐ ${esc(o)}</div>`).join('');
            default: return `<div class="ph">📎 Pilih file · ${f.file_types.map((t) => t.toUpperCase()).join(' / ')} · maks ${f.max_mb} MB</div>`;
        }
    }

    function fcard(f, i) {
        return `
        <div class="rf-fc" data-pick="${i}">
            <div class="hd">
                <b>${esc(f.label) || '<i>(tanpa judul)</i>'} ${f.is_required ? '<span style="color:#c0392b">*</span>' : ''}</b>
                <span class="rkm-tag n">${TY[f.type]}</span>
            </div>
            <div class="fk">${fk(f)}</div>
        </div>`;
    }

    function fedit(f, i) {
        const isChoice = ['enum', 'radio', 'check'].includes(f.type);
        return `
        <div class="rf-fc sel">
            <div class="rf-row">
                <div style="flex:2">
                    <label class="rf-lb" style="margin-top:0">Pertanyaan</label>
                    <input type="text" class="rf-in" data-p="label" value="${esc(f.label)}" maxlength="500">
                </div>
                <div>
                    <label class="rf-lb" style="margin-top:0">Tipe</label>
                    <select class="rf-in" data-p="type">
                        ${Object.entries(TY).map(([k, v]) => `<option value="${k}" ${k === f.type ? 'selected' : ''}>${v}</option>`).join('')}
                    </select>
                </div>
            </div>
            <label class="rf-lb">Teks bantuan (opsional)</label>
            <input type="text" class="rf-in" data-p="help" value="${esc(f.help)}" maxlength="1000">
            ${isChoice ? `
            <label class="rf-lb">Opsi pilihan (satu per baris)</label>
            <textarea class="rf-in" data-p="options" rows="5">${esc(f.options.join('\n'))}</textarea>
            ` : ''}
            ${f.type === 'file' ? `
            <div class="rf-row" style="margin-top:10px">
                <div>
                    <label class="rf-lb" style="margin-top:0">Tipe file yang diizinkan</label>
                    <label style="display:inline-flex;align-items:center;gap:5px;margin-right:14px;font-size:13px"><input type="checkbox" data-ft="pdf" ${f.file_types.includes('pdf') ? 'checked' : ''}> PDF</label>
                    <label style="display:inline-flex;align-items:center;gap:5px;font-size:13px"><input type="checkbox" data-ft="jpg" ${f.file_types.includes('jpg') ? 'checked' : ''}> JPG</label>
                </div>
                <div>
                    <label class="rf-lb" style="margin-top:0">Ukuran maksimal (MB)</label>
                    <input type="number" class="rf-in" data-p="max_mb" min="1" max="25" value="${f.max_mb}">
                </div>
            </div>
            ` : ''}
            <div class="rf-tb">
                <label><input type="checkbox" data-p="is_required" ${f.is_required ? 'checked' : ''}> Wajib diisi</label>
                <button type="button" class="rkm-btn mini" data-ord="-1" data-i="${i}">↑</button>
                <button type="button" class="rkm-btn mini" data-ord="1" data-i="${i}">↓</button>
                <button type="button" class="rkm-btn mini" data-dup="${i}">Duplikat</button>
                <button type="button" class="rkm-btn mini d" data-del="${i}">Hapus</button>
                <button type="button" class="rkm-btn mini p" data-done>Selesai</button>
            </div>
        </div>`;
    }

    function render() {
        if (!fields.length) {
            rfeList.innerHTML = '<div class="rkm-card"><div class="rkm-empty">Belum ada pertanyaan. Tambahkan dari tombol di atas.</div></div>';
            return;
        }
        rfeList.innerHTML = fields.map((f, i) => (sel === i ? fedit(f, i) : fcard(f, i))).join('');
    }

    rfeList.addEventListener('click', (e) => {
        const pick = e.target.closest('[data-pick]');
        if (pick) {
            sel = +pick.dataset.pick;
            render();
            return;
        }
        const ord = e.target.closest('[data-ord]');
        if (ord) {
            const i = +ord.dataset.i;
            const j = i + (+ord.dataset.ord);
            if (j < 0 || j >= fields.length) return;
            [fields[i], fields[j]] = [fields[j], fields[i]];
            sel = j;
            render();
            return;
        }
        const dup = e.target.closest('[data-dup]');
        if (dup) {
            const i = +dup.dataset.dup;
            fields.splice(i + 1, 0, { ...JSON.parse(JSON.stringify(fields[i])), id: null });
            sel = i + 1;
            render();
            return;
        }
        const del = e.target.closest('[data-del]');
        if (del) {
            fields.splice(+del.dataset.del, 1);
            sel = null;
            render();
            return;
        }
        if (e.target.closest('[data-done]')) {
            sel = null;
            render();
        }
    });

    rfeList.addEventListener('input', (e) => {
        if (sel === null) return;
        const f = fields[sel];
        const p = e.target.dataset.p;
        if (p) {
            if (p === 'options') {
                f.options = e.target.value.split('\n').map((s) => s.trim()).filter(Boolean);
            } else if (p === 'is_required') {
                f.is_required = e.target.checked ? 1 : 0;
            } else if (p === 'max_mb') {
                f.max_mb = Math.min(25, Math.max(1, +e.target.value || 1));
            } else {
                f[p] = e.target.value;
            }
        }
        const ft = e.target.dataset.ft;
        if (ft) {
            if (e.target.checked) {
                if (!f.file_types.includes(ft)) f.file_types.push(ft);
            } else {
                f.file_types = f.file_types.filter((t) => t !== ft);
                if (!f.file_types.length) {
                    e.target.checked = true;
                    f.file_types = [ft];
                    rkmToast('Pilih minimal satu tipe file.');
                }
            }
        }
    });

    rfeList.addEventListener('change', (e) => {
        if (e.target.dataset.p === 'type' && sel !== null) {
            fields[sel].type = e.target.value;
            if (['enum', 'radio', 'check'].includes(e.target.value) && !fields[sel].options.length) {
                fields[sel].options = ['Opsi 1', 'Opsi 2'];
            }
            render();
        }
    });

    document.getElementById('rfeAdd')?.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-add]');
        if (!btn) return;
        const type = btn.dataset.add;
        fields.push({
            id: null,
            type,
            label: 'Pertanyaan baru',
            help: '',
            options: ['enum', 'radio', 'check'].includes(type) ? ['Opsi 1', 'Opsi 2'] : [],
            file_types: ['pdf', 'jpg'],
            max_mb: 5,
            is_required: 0,
        });
        sel = fields.length - 1;
        render();
        const lab = rfeList.querySelector('[data-p="label"]');
        if (lab) { lab.focus(); lab.select(); }
    });

    saveBtn?.addEventListener('click', () => {
        const payload = {
            title: infoTitle.value.trim(),
            description: infoDesc.value.trim() || null,
            fields: fields.map((f) => ({
                id: f.id,
                type: f.type,
                label: f.label,
                help: f.help || null,
                options: f.options,
                file_types: f.file_types,
                max_mb: f.max_mb,
                is_required: f.is_required,
            })),
        };
        if (!payload.title) {
            rkmToast('Judul form wajib diisi.');
            infoTitle.focus();
            return;
        }
        saveBtn.disabled = true;
        fetch(RF.saveUrl, {
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
                rkmToast(d.message || 'Tersimpan.');
                setTimeout(() => window.location.reload(), 700);
            })
            .catch((e) => {
                saveBtn.disabled = false;
                rkmToast(e.message || 'Gagal menyimpan.');
            });
    });

    render();
}
