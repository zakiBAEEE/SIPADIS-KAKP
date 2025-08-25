export default function initDivisiToggle(
    roleSelectorId = 'tambah_role_id',
    divisiSelectorId = 'tambah_divisi_id',
    allowedRoleNames = ['Katimja', 'Staf']
) {
    const roleSelect = document.getElementById(roleSelectorId);
    const divisiSelect = document.getElementById(divisiSelectorId);
    if (!roleSelect || !divisiSelect) return;

    // Normalisasi daftar role yang boleh
    const allow = allowedRoleNames.map(r => String(r).toLowerCase().trim());

    function toggleDivisi() {
        const opt = roleSelect.options[roleSelect.selectedIndex];
        // Ambil nama role dari data-role-name, kalau kosong pakai teks option
        const selectedRoleName = (
            (opt && (opt.dataset.roleName || opt.text)) || ''
        ).toLowerCase().trim();

        if (allow.includes(selectedRoleName)) {
            // enable
            divisiSelect.disabled = false;
            divisiSelect.removeAttribute('disabled'); // jaga-jaga kalau atributnya ada di HTML
        } else {
            // disable + kosongkan pilihan
            divisiSelect.value = '';
            divisiSelect.setAttribute('disabled', 'disabled');
            divisiSelect.disabled = true;
        }
    }

    roleSelect.addEventListener('change', toggleDivisi);
    roleSelect.addEventListener('input', toggleDivisi); // antisipasi framework yang trigger input
    toggleDivisi(); // inisialisasi awal
}
