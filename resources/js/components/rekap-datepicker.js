import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";
import monthSelectPlugin from "flatpickr/dist/plugins/monthSelect/index";
import "flatpickr/dist/plugins/monthSelect/style.css";

import { Indonesian } from "flatpickr/dist/l10n/id.js";
flatpickr.localize(Indonesian);

export function setupRekapDatepicker(groupSelector = "#group_by", inputSelector = "#tanggalPicker") {
    document.addEventListener("DOMContentLoaded", function () {
        const groupBySelect = document.getElementById("group_by");
        const inputs = {
            daily: document.getElementById("input-daily"),
            weekly: document.getElementById("input-weekly"),
            monthly: document.getElementById("input-monthly"),
            yearly: document.getElementById("input-yearly"),
        };

        function showInput(type) {
            for (const key in inputs) {
                inputs[key].classList.add("hidden");
            }
            if (inputs[type]) {
                inputs[type].classList.remove("hidden");
            }
        }

        // Inisialisasi awal
        showInput(groupBySelect.value);

        groupBySelect.addEventListener("change", function () {
            showInput(this.value);
        });
    });

}

