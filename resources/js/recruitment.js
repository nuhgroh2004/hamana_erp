document.addEventListener('submit', (e) => {
    const form = e.target;
    const trigger = e.submitter && e.submitter.hasAttribute('data-confirm')
        ? e.submitter
        : (form.hasAttribute('data-confirm') ? form : null);

    if (trigger && !window.confirm(trigger.getAttribute('data-confirm'))) {
        e.preventDefault();
    }
});
