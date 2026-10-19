export function rfpEsc(s) {
    return String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
}

export function rfpRender(fields, opts) {
    const esc = rfpEsc;
    const p = opts.prefix || 'pv';
    const html = fields
        .map((f) => {
            const id = `${p}_${f.id}`;
            const lab = `<label>${esc(f.label)}${f.required ? ' <i>*</i>' : ''}</label>`;
            const help = f.help ? `<small>${esc(f.help)}</small>` : '';
            let ctrl = '';
            switch (f.type) {
                case 'text': ctrl = `<input class="rf-in" id="${id}">`; break;
                case 'long': ctrl = `<textarea class="rf-in" id="${id}"></textarea>`; break;
                case 'num': ctrl = `<input class="rf-in" type="number" id="${id}">`; break;
                case 'date': ctrl = `<input class="rf-in" type="date" id="${id}" style="max-width:220px">`; break;
                case 'enum':
                    ctrl = `<select class="rf-in" id="${id}"><option value="">Pilih…</option>${f.options.map((o) => `<option>${esc(o)}</option>`).join('')}</select>`;
                    break;
                case 'radio':
                    ctrl = f.options.map((o) => `<div class="rf-o"><input type="radio" name="${id}" value="${esc(o)}"> ${esc(o)}</div>`).join('');
                    break;
                case 'check':
                    ctrl = f.options.map((o) => `<div class="rf-o"><input type="checkbox" name="${id}" value="${esc(o)}"> ${esc(o)}</div>`).join('');
                    break;
                case 'file': {
                    const accept = (f.file_types && f.file_types.length ? f.file_types : ['pdf', 'jpg']).map((t) => (t === 'pdf' ? '.pdf' : '.jpg,.jpeg')).join(',');
                    const ft = (f.file_types && f.file_types.length ? f.file_types : ['pdf', 'jpg']).map((t) => t.toUpperCase()).join(' / ');
                    ctrl = `<input class="rf-in" type="file" id="${id}" accept="${accept}"><small>${ft} · maks ${f.max_mb} MB</small>`;
                    break;
                }
            }
            return `<div class="rf-q">${lab}${help}${ctrl}<div class="rf-er" id="${p}e_${f.id}"></div></div>`;
        })
        .join('');

    return `<h2>${esc(opts.title || '')}</h2><p>${esc(opts.description || '')}</p>${html}<button type="button" class="rkm-btn p" data-submit>Kirim</button>`;
}

export function rfpDone(root, opts) {
    const esc = rfpEsc;
    root.innerHTML = `<div class="rf-fm"><h2>${esc(opts.title)}</h2><p>${esc(opts.message)}</p>${opts.preview ? '<div class="rf-ban" style="margin:0">Pratinjau: respons ini tidak disimpan.</div>' : ''}<button type="button" class="rkm-btn" data-again>Kirim respons lain</button></div>`;
}

export function rfpCollect(root, fields, prefix) {
    const p = prefix || 'pv';
    let ok = true;
    const values = {};
    fields.forEach((f) => {
        const er = document.getElementById(`${p}e_${f.id}`);
        if (er) er.textContent = '';
        let val = '';
        let msg = '';
        const id = `${p}_${f.id}`;
        const type = f.type;
        if (type === 'radio') {
            const c = root.querySelector(`input[name="${id}"]:checked`);
            val = c ? c.value : '';
        } else if (type === 'check') {
            val = [...root.querySelectorAll(`input[name="${id}"]:checked`)].map((e) => e.value);
        } else if (type === 'file') {
            const inp = root.querySelector(`#${id}`);
            const fl = inp && inp.files[0];
            if (fl) {
                const ext = fl.name.split('.').pop().toLowerCase();
                const ft = f.file_types && f.file_types.length ? f.file_types : ['pdf', 'jpg'];
                const allowed = ft.flatMap((t) => (t === 'pdf' ? ['pdf'] : ['jpg', 'jpeg']));
                if (!allowed.includes(ext)) msg = 'Tipe file harus ' + ft.map((t) => t.toUpperCase()).join(' / ');
                else if (fl.size > f.max_mb * 1048576) msg = 'Ukuran maksimal ' + f.max_mb + ' MB';
                else val = fl.name;
            }
        } else {
            const el = root.querySelector(`#${id}`);
            val = el ? el.value.trim() : '';
            if (val && type === 'num' && isNaN(+val)) msg = 'Harus berupa angka';
        }
        if (!msg && f.required && (Array.isArray(val) ? !val.length : !val)) msg = 'Wajib diisi';
        if (msg && er) er.textContent = msg;
        if (msg) ok = false;
        values[f.id] = val;
    });
    return { ok, values };
}

export function rfpFill(root, fields, prefix) {
    const p = prefix || 'pv';
    const fd = new FormData();
    fields.forEach((f) => {
        const key = `f_${f.id}`;
        const id = `${p}_${f.id}`;
        if (f.type === 'radio') {
            const c = root.querySelector(`input[name="${id}"]:checked`);
            if (c) fd.append(key, c.value);
        } else if (f.type === 'check') {
            [...root.querySelectorAll(`input[name="${id}"]:checked`)].forEach((el) => fd.append(key + '[]', el.value));
        } else if (f.type === 'file') {
            const inp = root.querySelector(`#${id}`);
            if (inp && inp.files[0]) fd.append(key, inp.files[0]);
        } else {
            const el = root.querySelector(`#${id}`);
            if (el) fd.append(key, el.value);
        }
    });
    return fd;
}
