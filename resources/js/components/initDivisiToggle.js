export default function initDivisiToggle(roleSelectorId = 'tambah_role_id', divisiSelectorId = 'tambah_divisi_id') {
    const roleSelect = document.getElementById(roleSelectorId);
    const divisiSelect = document.getElementById(divisiSelectorId);

    if (!roleSelect || !divisiSelect) return;

    const allowedRoleNames = ['Katimja', 'Staf'];

    function toggleDivisi() {
        const selectedOption = roleSelect.options[roleSelect.selectedIndex];
        const selectedRoleName = selectedOption.dataset.roleName;

        if (allowedRoleNames.includes(selectedRoleName)) {
            divisiSelect.disabled = false;
        } else {
            divisiSelect.value = "";
            divisiSelect.disabled = true;
        }
    }

    roleSelect.addEventListener('change', toggleDivisi);
    toggleDivisi(); // inisialisasi saat pertama kali
}
