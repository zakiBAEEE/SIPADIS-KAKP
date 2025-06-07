import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#tanggal_surat", {
        dateFormat: "Y-m-d",
    });
});
document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#tanggal_terima", {
        dateFormat: "Y-m-d", // format tanggal
    });
});

document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#tanggal_disposisi", {
        dateFormat: "Y-m-d", // format tanggal
    });
});

document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#rekap_dari_tanggal", {
        dateFormat: "Y-m-d", // format tanggal
    });
});

document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#rekap_sampe_tanggal", {
        dateFormat: "Y-m-d", // format tanggal
    });
});

document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#startDate", {
        mode: "range",  // Memungkinkan pemilihan rentang tanggal
        dateFormat: "Y-m-d",  // Format tanggal yang ditampilkan
    });
});

document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#filter_tanggal_surat", {
        mode: "range",  // Memungkinkan pemilihan rentang tanggal
        dateFormat: "Y-m-d",  // Format tanggal yang ditampilkan
    });
});

document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#filter_tanggal_terima", {
        mode: "range",  // Memungkinkan pemilihan rentang tanggal
        dateFormat: "Y-m-d",  // Format tanggal yang ditampilkan
    });
});


document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#cetak-agenda-tanggal-surat", {
        mode: "range",  // Memungkinkan pemilihan rentang tanggal
        dateFormat: "Y-m-d",  // Format tanggal yang ditampilkan
    });
})


document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#cetak-agenda-tanggal-terima", {
        mode: "range",  // Memungkinkan pemilihan rentang tanggal
        dateFormat: "Y-m-d",  // Format tanggal yang ditampilkan
    });
})