const candQ = document.getElementById('rkmCandQ');
const candJob = document.getElementById('rkmCandJob');
const candStage = document.getElementById('rkmCandStage');

if (candQ && candJob && candStage) {
    const apply = () => {
        const q = candQ.value.toLowerCase();
        const job = candJob.value;
        const stage = candStage.value;
        let shown = 0;

        document.querySelectorAll('#rkmCandTable tr.rkm-row').forEach((row) => {
            const match =
                (!q || row.textContent.toLowerCase().includes(q)) &&
                (!job || row.dataset.job === job) &&
                (stage === '' || row.dataset.stage === stage);
            row.style.display = match ? '' : 'none';
            if (match) shown++;
        });

        const empty = document.getElementById('rkmCandEmpty');
        if (empty) empty.style.display = shown ? 'none' : 'block';
    };

    candQ.addEventListener('input', apply);
    candJob.addEventListener('change', apply);
    candStage.addEventListener('change', apply);
}
