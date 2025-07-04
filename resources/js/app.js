import './bootstrap';
import './components/datepicker';
import './components/filepond';
import { initMaterialTailwind } from '@material-tailwind/html';
import Alpine from 'alpinejs';
import { initializeCharts } from './components/initChart';
import { initializeAlerts } from './components/alert-handler';
import { handleFormReset } from './components/resetForm';

window.Alpine = Alpine;

Alpine.start();






    handleFormReset('#filterSuratKlasifikasi form', '#filterSuratKlasifikasi button[type="reset"]');
    handleFormReset('#filterSuratArsip form', '#resetDisposisiForm');
    handleFormReset('#filterSuratDraft form', '#resetDisposisiForm');
    handleFormReset('#filterSuratDitolak form', '#resetDisposisiForm');
    initializeAlerts();
    initializeCharts();
    initMaterialTailwind();