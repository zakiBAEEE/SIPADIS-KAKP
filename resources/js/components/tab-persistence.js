export default function setupTabPersistence(storageKey = 'activeTabSifat') {
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');
        const tabIndicator = document.querySelector('.tab-indicator');

        // Ambil tab aktif dari localStorage (jika ada)
        const activeTabId = localStorage.getItem('activeTab');

        let found = false;

        tabLinks.forEach(link => {
            const targetId = link.dataset.tabTarget;
            const content = document.getElementById(targetId);

            if (activeTabId && targetId === activeTabId) {
                // Aktifkan tab yang disimpan
                link.classList.add('active');
                content.classList.remove('hidden');
                content.classList.add('block');
                moveIndicator(link);
                found = true;
            } else {
                link.classList.remove('active');
                content.classList.remove('block');
                content.classList.add('hidden');
            }

            // Tambahkan event klik untuk setiap tab
            link.addEventListener('click', function (e) {
                e.preventDefault();

                // Hapus semua status aktif
                tabLinks.forEach(l => l.classList.remove('active'));
                tabContents.forEach(c => {
                    c.classList.remove('block');
                    c.classList.add('hidden');
                });

                // Aktifkan tab yang diklik
                link.classList.add('active');
                content.classList.remove('hidden');
                content.classList.add('block');

                // Simpan ke localStorage
                localStorage.setItem('activeTab', targetId);

                // Pindahkan indikator
                moveIndicator(link);
            });
        });

        // Jika tidak ditemukan tab aktif di localStorage, aktifkan tab pertama
        if (!found && tabLinks.length > 0) {
            tabLinks[0].classList.add('active');
            const firstTarget = tabLinks[0].dataset.tabTarget;
            document.getElementById(firstTarget).classList.remove('hidden');
            document.getElementById(firstTarget).classList.add('block');
            moveIndicator(tabLinks[0]);
        }

        // Fungsi untuk memindahkan indikator tab
        function moveIndicator(activeLink) {
            if (!tabIndicator) return;

            const offsetLeft = activeLink.offsetLeft;
            const offsetWidth = activeLink.offsetWidth;

            tabIndicator.style.transform = `translateX(${offsetLeft}px) scaleX(1)`;
            tabIndicator.style.width = `${offsetWidth}px`;
        }
   
}
