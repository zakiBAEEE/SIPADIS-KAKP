export function handleFormReset(formSelector, resetButtonSelector) {
    const form = document.querySelector(formSelector);
    const resetButton = document.querySelector(resetButtonSelector);

    if (!form || !resetButton) return;

    resetButton.addEventListener('click', function (e) {
        e.preventDefault(); // cegah perilaku reset default browser

        form.querySelectorAll('input, textarea, select').forEach((el) => {
            const type = el.type;

            if (type === 'hidden') {
                el.value = '';
            } else if (type === 'checkbox' || type === 'radio') {
                el.checked = false;
            } else if (el.tagName === 'SELECT') {
                el.selectedIndex = 0;
            } else {
                el.value = '';
            }
        });

        if (window.flatpickr) {
            form.querySelectorAll('.flatpickr-input').forEach((el) => {
                if (el._flatpickr) {
                    el._flatpickr.clear();
                }
            });
        }
    });
}
