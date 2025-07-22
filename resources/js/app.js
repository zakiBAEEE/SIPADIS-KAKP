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
import { setupSidebarToggle } from './components/sidebarToggle';
import setupTabPersistence from './components/tab-persistence';
import { setupRekapDatepicker } from './components/rekap-datepicker';
window.Alpine = Alpine;

Alpine.start();


setupRekapDatepicker();
setupTabPersistence(); // jalankan script tab
handleFormReset('#filterSuratKlasifikasi form', '#filterSuratKlasifikasi button[type="reset"]');
handleFormReset('#filterSuratArsip form', '#resetDisposisiForm');
handleFormReset('#filterSuratDraft form', '#resetDisposisiForm');
handleFormReset('#filterSuratDitolak form', '#resetDisposisiForm');
setupSidebarToggle();
togglePassword();
initDivisiToggle();
initializeAlerts();
initializeCharts();
initMaterialTailwind();