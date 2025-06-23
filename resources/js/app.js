import './bootstrap';
import './components/datepicker';
import './components/filepond';
import { initMaterialTailwind } from '@material-tailwind/html';
import Alpine from 'alpinejs';
import { initializeCharts } from './components/initChart';

window.Alpine = Alpine;

Alpine.start();


function konfirmasiLogout(event) {
    event.preventDefault(); // Cegah logout langsung

    if (confirm('Apakah Anda yakin ingin logout?')) {
        document.getElementById('logout-form').submit();
    }
}



// Initialize all components in your app
initMaterialTailwind();
initializeCharts();

