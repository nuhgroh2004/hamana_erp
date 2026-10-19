const onbBoxes = document.querySelectorAll('.rkm-ck input[type="checkbox"][data-task]');

onbBoxes.forEach((box) => {
    box.addEventListener('change', () => {
        const url = box.dataset.url;
        if (!url) return;
        const meta = document.querySelector('meta[name="csrf-token"]');
        box.disabled = true;
        fetch(url, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': meta ? meta.content : '',
            },
            body: JSON.stringify({ done: box.checked ? 1 : 0 }),
        })
            .then((r) => (r.ok ? r.json() : Promise.reject()))
            .then((data) => {
                box.closest('.rkm-ck')?.classList.toggle('done', box.checked);
                const toast = document.getElementById('rkmToast');
                if (toast && data && data.message) {
                    toast.textContent = data.message;
                    toast.classList.add('on');
                    setTimeout(() => toast.classList.remove('on'), 2000);
                }
            })
            .catch(() => {
                box.checked = !box.checked;
            })
            .finally(() => {
                box.disabled = false;
            });
    });
});
