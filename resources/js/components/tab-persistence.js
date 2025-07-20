export default function setupTabPersistence(storageKey = 'activeTabSifat') {
    document.addEventListener('DOMContentLoaded', () => {
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        function activateTab(tabId) {
            tabLinks.forEach(link => {
                const isActive = link.getAttribute('data-tab-target') === tabId;
                link.classList.toggle('active', isActive);
            });

            tabContents.forEach(content => {
                content.classList.toggle('hidden', content.id !== tabId);
                content.classList.toggle('block', content.id === tabId);
            });
        }

        // Buka tab yang terakhir dikunjungi (jika ada)
        const savedTabId = localStorage.getItem(storageKey);
        const defaultTabId = tabLinks[0]?.getAttribute('data-tab-target');

        activateTab(savedTabId || defaultTabId);

        // Set event listener pada semua tab
        tabLinks.forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                const targetId = link.getAttribute('data-tab-target');
                localStorage.setItem(storageKey, targetId);
                activateTab(targetId);
            });
        });
    });
}
