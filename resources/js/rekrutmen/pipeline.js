const pipeFilter = document.getElementById('rkmPipeFilter');

if (pipeFilter) {
    const apply = () => {
        const val = pipeFilter.value;
        document.querySelectorAll('.rkm-kb .rkm-col').forEach((col) => {
            let visible = 0;
            col.querySelectorAll('.rkm-kc').forEach((card) => {
                const show = !val || card.dataset.job === val;
                card.classList.toggle('hide', !show);
                if (show) visible++;
            });
            const count = col.querySelector('h4 span');
            if (count) count.textContent = visible;
        });
    };

    pipeFilter.addEventListener('change', apply);
}
