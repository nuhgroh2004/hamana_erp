const KRY_STORE = 'hamana-kry';

const KRY_COLS = {
    karier: ['tglMasuk', 'statusKerja', 'divisi', 'jabatan', 'atasan', 'lokasi'],
    pendidikan: ['jenjang', 'institusi', 'jurusan', 'lulus'],
    dokumen: ['nama', 'nomor', 'berlaku', 'status'],
};

const KRY_DOC_STATUS = ['Aktif', 'Akan Habis', 'Menunggu', 'Kedaluwarsa'];

function kryReadStore() {
    try {
        return JSON.parse(localStorage.getItem(KRY_STORE) || '{}');
    } catch (e) {
        return {};
    }
}

function kryWriteStore(store) {
    try {
        localStorage.setItem(KRY_STORE, JSON.stringify(store));
    } catch (e) {
        return;
    }
}

function kryChipClass(status) {
    if (status === 'Tetap') return 'chip-teal';
    if (status === 'Kontrak') return 'chip-amber';
    return 'chip-purple';
}

function kryDocChip(status) {
    if (status === 'Aktif') return 'chip-teal';
    if (status === 'Akan Habis') return 'chip-amber';
    if (status === 'Kedaluwarsa') return 'chip-red';
    return 'chip-purple';
}

function kryPick(cols, values) {
    const o = {};
    cols.forEach((c) => {
        o[c] = values[c] || '';
    });
    return o;
}

function initKryList() {
    const root = document.getElementById('kry');
    const list = document.getElementById('kryList');
    const countEl = document.getElementById('kryCount');
    const allChk = document.getElementById('kryAll');

    if (!root || !list || !countEl || !allChk) return;

    const detailUrl = root.dataset.detail;
    const countTpl = root.dataset.count || '{sel} dari {total} dipilih';
    const rows = Array.from(list.querySelectorAll('tr[data-id]'));
    const store = kryReadStore();

    rows.forEach((row) => {
        const vals = (store[row.dataset.id] || {}).values;
        if (!vals) return;
        if (vals.nama) row.querySelector('.c-nama').textContent = vals.nama;
        if (vals.divisi) row.querySelector('.c-divisi').textContent = vals.divisi;
        if (vals.jabatan) row.querySelector('.c-jabatan').textContent = vals.jabatan;
    });

    function updateCount() {
        const sel = rows.filter((r) => r.querySelector('.kry-chk').checked).length;
        countEl.textContent = countTpl.replace('{sel}', sel).replace('{total}', rows.length);
        allChk.checked = rows.length > 0 && sel === rows.length;
        allChk.indeterminate = sel > 0 && sel < rows.length;
    }

    function setRowSel(row, on) {
        if (!row) return;
        row.classList.toggle('sel', on);
        row.querySelector('.kry-chk').checked = on;
    }

    function go(id) {
        window.location.href = detailUrl + '?nik=' + encodeURIComponent(id);
    }

    allChk.addEventListener('change', () => {
        rows.forEach((r) => setRowSel(r, allChk.checked));
        updateCount();
    });

    root.addEventListener('change', (e) => {
        if (e.target.classList.contains('kry-chk')) {
            setRowSel(e.target.closest('tr'), e.target.checked);
            updateCount();
        }
    });

    root.addEventListener('dblclick', (e) => {
        if (e.target.closest('button, input, select, a')) return;
        const row = e.target.closest('tr[data-id]');
        if (row) go(row.dataset.id);
    });

    root.addEventListener('keydown', (e) => {
        if (e.key !== 'Enter') return;
        if (e.target.matches('button, input, select, a, textarea')) return;
        const row = e.target.closest('tr[data-id]');
        if (row) go(row.dataset.id);
    });

    updateCount();
}

function initKryDetail() {
    const root = document.getElementById('kryDetail');
    if (!root) return;

    const nik = root.dataset.nik;
    const L = {
        msgSaved: root.dataset.msgSaved || 'Perubahan tersimpan.',
        msgRequired: root.dataset.msgRequired || 'Nama, divisi, dan jabatan wajib diisi.',
        empty: root.dataset.empty || 'Belum ada data',
        phKey: root.dataset.phKey || 'Nama kolom',
        phVal: root.dataset.phVal || 'Isi data',
        delCol: root.dataset.delCol || 'Hapus kolom',
        delRow: root.dataset.delRow || 'Hapus baris',
    };
    let docMap = {};
    let skMap = {};
    try { docMap = JSON.parse(root.dataset.docStatus || '{}'); } catch (e) { docMap = {}; }
    try { skMap = JSON.parse(root.dataset.statusKerja || '{}'); } catch (e) { skMap = {}; }
    const form = root.querySelector('.kry-form');
    const secs = Array.from(root.querySelectorAll('.kry-sec'));
    const tabs = Array.from(root.querySelectorAll('.kry-tab'));
    const dataFields = Array.from(form.querySelectorAll('input[data-f]'));
    const recSecs = secs.filter((s) => KRY_COLS[s.dataset.sec]);

    let seed = {};
    try {
        const seedEl = document.getElementById('krySeed');
        seed = JSON.parse((seedEl && seedEl.textContent) || '{}');
    } catch (e) {
        seed = {};
    }

    let snap = null;
    let timer = null;

    const editing = () => form.classList.contains('editing');

    const msg = (text, err) => {
        const el = root.querySelector('.kry-msg');
        el.textContent = text;
        el.classList.toggle('err', Boolean(err));
    };

    function switchTab(name) {
        tabs.forEach((t) => t.classList.toggle('on', t.dataset.tab === name));
        secs.forEach((s) => {
            s.hidden = s.dataset.sec !== name;
        });
    }

    function addField(sec, key, val) {
        const grid = sec.querySelector('.kry-grid');
        if (!grid) return;
        const wrap = document.createElement('div');
        wrap.className = 'fld fld-extra';
        wrap.innerHTML = '<div class="fld-keyrow"><input class="fld-key" type="text"><button type="button" class="fld-del"><span class="material-symbols-outlined">close</span></button></div><input class="fld-val" type="text">';
        wrap.querySelector('.fld-key').placeholder = L.phKey;
        wrap.querySelector('.fld-del').setAttribute('aria-label', L.delCol);
        wrap.querySelector('.fld-val').placeholder = L.phVal;
        wrap.querySelector('.fld-key').value = key || '';
        wrap.querySelector('.fld-val').value = val || '';
        const ro = !editing();
        wrap.querySelector('.fld-key').readOnly = ro;
        wrap.querySelector('.fld-val').readOnly = ro;
        grid.insertBefore(wrap, grid.querySelector('.fld-add-wrap'));
    }

    function extraState() {
        return secs.map((s) => Array.from(s.querySelectorAll('.fld-extra')).map((f) => ({
            key: f.querySelector('.fld-key').value,
            val: f.querySelector('.fld-val').value,
        })));
    }

    function restoreExtra(state) {
        secs.forEach((s, n) => {
            s.querySelectorAll('.fld-extra').forEach((f) => f.remove());
            (state[n] || []).forEach((it) => addField(s, it.key, it.val));
        });
    }

    function cellInput(col, value) {
        const input = document.createElement('input');
        input.type = 'text';
        input.dataset.c = col;
        input.value = value || '';
        input.readOnly = !editing();
        return input;
    }

    function addRow(sec, obj) {
        const cols = KRY_COLS[sec.dataset.sec];
        const tbody = sec.querySelector('tbody');
        const tr = document.createElement('tr');
        tr.dataset.rec = sec.dataset.sec;

        cols.forEach((col) => {
            const td = document.createElement('td');
            if (sec.dataset.sec === 'dokumen' && col === 'status') {
                td.className = 'doc-st';
                const val = obj[col] || 'Aktif';
                const chip = document.createElement('span');
                chip.className = 'chip ' + kryDocChip(val);
                chip.textContent = docMap[val] || val;
                const sel = document.createElement('select');
                sel.className = 'doc-sel';
                sel.dataset.c = 'status';
                KRY_DOC_STATUS.forEach((o) => {
                    const opt = document.createElement('option');
                    opt.value = o;
                    opt.textContent = docMap[o] || o;
                    sel.appendChild(opt);
                });
                if (KRY_DOC_STATUS.indexOf(val) === -1) {
                    const opt = document.createElement('option');
                    opt.value = val;
                    opt.textContent = docMap[val] || val;
                    sel.appendChild(opt);
                }
                sel.value = val;
                td.appendChild(chip);
                td.appendChild(sel);
            } else {
                td.appendChild(cellInput(col, obj[col]));
            }
            tr.appendChild(td);
        });

        const act = document.createElement('td');
        act.className = 'c-act';
        act.innerHTML = '<button type="button" class="fld-del" aria-label="' + L.delRow + '"><span class="material-symbols-outlined">close</span></button>';
        tr.appendChild(act);

        tbody.appendChild(tr);
        syncEmpty(sec);
        return tr;
    }

    function clearRows(sec) {
        sec.querySelectorAll('tr[data-rec]').forEach((tr) => tr.remove());
    }

    function rowEmpty(tr) {
        return Array.from(tr.querySelectorAll('input[data-c]')).every((i) => !i.value.trim());
    }

    function secRows(sec) {
        return Array.from(sec.querySelectorAll('tr[data-rec]')).map((tr) => {
            const o = {};
            tr.querySelectorAll('[data-c]').forEach((el) => {
                o[el.dataset.c] = el.value.trim();
            });
            return o;
        });
    }

    function syncEmpty(sec) {
        const tbody = sec.querySelector('tbody');
        const has = tbody.querySelector('tr[data-rec]');
        const empty = tbody.querySelector('tr.kry-empty');
        if (has && empty) {
            empty.remove();
        } else if (!has && !empty) {
            const tr = document.createElement('tr');
            tr.className = 'kry-empty';
            const td = document.createElement('td');
            td.colSpan = KRY_COLS[sec.dataset.sec].length + 1;
            td.textContent = L.empty;
            tr.appendChild(td);
            tbody.appendChild(tr);
        }
    }

    function syncDocChips(sec) {
        sec.querySelectorAll('tr[data-rec]').forEach((tr) => {
            const sel = tr.querySelector('.doc-sel');
            const chip = tr.querySelector('.doc-st .chip');
            if (!sel || !chip) return;
            chip.textContent = docMap[sel.value] || sel.value;
            chip.className = 'chip ' + kryDocChip(sel.value);
        });
    }

    function startEdit() {
        if (editing()) return;
        snap = {
            values: dataFields.map((i) => i.value),
            extra: extraState(),
            recs: recSecs.map((sec) => secRows(sec)),
        };
        form.classList.add('editing');
        form.querySelectorAll('input').forEach((i) => {
            if (!i.hasAttribute('data-lock')) i.readOnly = false;
        });
        root.querySelector('.kry-edit2').hidden = true;
        root.querySelector('.kry-save').hidden = false;
        root.querySelector('.kry-cancel').hidden = false;
        msg('');
        const first = Array.from(form.querySelectorAll('input:not([data-lock])')).find((i) => i.offsetParent !== null);
        if (first) first.focus();
    }

    function stopEdit() {
        form.classList.remove('editing');
        form.querySelectorAll('input').forEach((i) => {
            i.readOnly = true;
        });
        root.querySelector('.kry-edit2').hidden = false;
        root.querySelector('.kry-save').hidden = true;
        root.querySelector('.kry-cancel').hidden = true;
    }

    function cancelEdit() {
        if (snap) {
            dataFields.forEach((i, n) => {
                i.value = snap.values[n] ?? i.value;
            });
            restoreExtra(snap.extra);
            recSecs.forEach((sec, n) => {
                clearRows(sec);
                (snap.recs[n] || []).forEach((o) => addRow(sec, o));
                syncEmpty(sec);
            });
        }
        snap = null;
        stopEdit();
        msg('');
    }

    function saveEdit() {
        recSecs.forEach((sec) => {
            sec.querySelectorAll('tr[data-rec]').forEach((tr) => {
                if (rowEmpty(tr)) tr.remove();
            });
            syncEmpty(sec);
        });

        const vals = {};
        dataFields.forEach((i) => {
            vals[i.dataset.f] = i.value.trim();
        });

        const bySec = {};
        recSecs.forEach((sec) => {
            bySec[sec.dataset.sec] = secRows(sec);
        });
        const lastRow = (arr) => (arr && arr.length ? arr[arr.length - 1] : {});
        Object.assign(vals, lastRow(bySec.pendidikan), lastRow(bySec.karier));

        if (!vals.nama || !vals.divisi || !vals.jabatan) {
            msg(L.msgRequired, true);
            return;
        }

        secs.forEach((s) => {
            s.querySelectorAll('.fld-extra').forEach((f) => {
                if (!f.querySelector('.fld-key').value.trim() && !f.querySelector('.fld-val').value.trim()) f.remove();
            });
        });

        dataFields.forEach((i) => {
            i.value = vals[i.dataset.f];
        });
        root.querySelector('.kry-name').textContent = vals.nama;
        const chip = root.querySelector('.kry-chip');
        chip.textContent = skMap[vals.statusKerja] || vals.statusKerja || '';
        chip.className = 'chip kry-chip ' + kryChipClass(vals.statusKerja);
        recSecs.forEach((sec) => syncDocChips(sec));

        const extra = {};
        secs.forEach((s) => {
            const items = Array.from(s.querySelectorAll('.fld-extra')).map((f) => ({
                key: f.querySelector('.fld-key').value.trim(),
                val: f.querySelector('.fld-val').value.trim(),
            })).filter((x) => x.key || x.val);
            if (items.length) extra[s.dataset.sec] = items;
        });

        const store = kryReadStore();
        store[nik] = {
            values: vals,
            extra: extra,
            karier: bySec.karier || [],
            pendidikan: bySec.pendidikan || [],
            dokumen: bySec.dokumen || [],
        };
        kryWriteStore(store);

        stopEdit();
        snap = null;
        msg(L.msgSaved);
        clearTimeout(timer);
        timer = setTimeout(() => msg(''), 3000);
    }

    tabs.forEach((t) => t.addEventListener('click', () => switchTab(t.dataset.tab)));

    root.addEventListener('click', (e) => {
        const b = e.target.closest('button');
        if (!b) return;
        if (b.classList.contains('fld-add')) {
            const sec = b.closest('.kry-sec');
            if (sec && editing()) addField(sec, '', '');
        } else if (b.classList.contains('rec-add')) {
            const sec = b.closest('.kry-sec');
            if (sec && editing()) {
                const tr = addRow(sec, {});
                const first = tr.querySelector('input, select');
                if (first) first.focus();
            }
        } else if (b.classList.contains('fld-del')) {
            if (!editing()) return;
            const f = b.closest('.fld-extra');
            if (f) {
                f.remove();
                return;
            }
            const tr = b.closest('tr[data-rec]');
            if (tr) {
                const sec = tr.closest('.kry-sec');
                tr.remove();
                if (sec) syncEmpty(sec);
            }
        } else if (b.classList.contains('kry-edit2')) startEdit();
        else if (b.classList.contains('kry-save')) saveEdit();
        else if (b.classList.contains('kry-cancel')) cancelEdit();
    });

    const rec = kryReadStore()[nik];
    if (rec) {
        const byF = Object.fromEntries(dataFields.map((i) => [i.dataset.f, i]));
        Object.entries(rec.values || {}).forEach(([f, v]) => {
            if (byF[f]) byF[f].value = v;
        });
        Object.entries(rec.extra || {}).forEach(([sec, items]) => {
            const s = secs.find((x) => x.dataset.sec === sec);
            if (s) items.forEach((it) => addField(s, it.key, it.val));
        });
        if (rec.values && rec.values.nama) root.querySelector('.kry-name').textContent = rec.values.nama;
        if (rec.values && rec.values.statusKerja) {
            const chip = root.querySelector('.kry-chip');
            chip.textContent = skMap[rec.values.statusKerja] || rec.values.statusKerja;
            chip.className = 'chip kry-chip ' + kryChipClass(rec.values.statusKerja);
        }
    }

    recSecs.forEach((sec) => {
        const key = sec.dataset.sec;
        let rows = null;
        if (rec && Array.isArray(rec[key])) {
            rows = rec[key];
        } else if (rec && rec.values) {
            if (key === 'karier' && rec.values.divisi) rows = [kryPick(KRY_COLS.karier, rec.values)];
            if (key === 'pendidikan' && rec.values.institusi) rows = [kryPick(KRY_COLS.pendidikan, rec.values)];
        }
        if (!rows) rows = Array.isArray(seed[key]) ? seed[key] : [];
        clearRows(sec);
        rows.forEach((o) => addRow(sec, o));
        syncEmpty(sec);
    });

    if (new URLSearchParams(window.location.search).get('edit') === '1') startEdit();
}

function initKaryawan() {
    initKryList();
    initKryDetail();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initKaryawan);
} else {
    initKaryawan();
}
