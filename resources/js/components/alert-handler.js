// File: resources/js/components/alert-handler.js

// Gunakan 'export' agar fungsi ini bisa diimpor oleh file lain
export function initializeAlerts() {

    // Ambil semua elemen alert berdasarkan class-nya
    const alerts = document.querySelectorAll('.js-dismissable-alert');

    alerts.forEach(alert => {
        const closeButton = alert.querySelector('.js-close-alert');

        const dismiss = () => {
            alert.style.opacity = '0';
            setTimeout(() => {
                // Hapus elemen dari DOM setelah transisi selesai untuk kebersihan
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 350);
        };

        // Tambahkan event listener untuk tombol close manual
        if (closeButton) {
            closeButton.addEventListener('click', dismiss);
        }

        // Set timeout untuk auto-dismiss setelah 5 detik
        setTimeout(dismiss, 5000);
    });
};