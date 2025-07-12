import './bootstrap';
import './components/datepicker';
import './components/filepond';
import { initMaterialTailwind } from '@material-tailwind/html';
import Alpine from 'alpinejs';
import initDivisiToggle from './components/initDivisiToggle';
import { initializeCharts } from './components/initChart';
import { initializeAlerts } from './components/alert-handler';
import { handleFormReset } from './components/resetForm';
import { togglePassword } from './components/password-toggle';

window.Alpine = Alpine;

Alpine.start();



handleFormReset('#filterSuratKlasifikasi form', '#filterSuratKlasifikasi button[type="reset"]');
handleFormReset('#filterSuratArsip form', '#resetDisposisiForm');
handleFormReset('#filterSuratDraft form', '#resetDisposisiForm');
handleFormReset('#filterSuratDitolak form', '#resetDisposisiForm');
togglePassword();
initDivisiToggle();
initializeAlerts();
initializeCharts();
initMaterialTailwind();