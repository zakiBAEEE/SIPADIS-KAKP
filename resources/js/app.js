import './bootstrap';
import './components/datepicker';
import './components/filepond';
import { initMaterialTailwind } from '@material-tailwind/html';
import Alpine from 'alpinejs';
import { initializeCharts } from './components/initChart';
import { initializeAlerts } from './components/alert-handler.js';

window.Alpine = Alpine;

Alpine.start();






// Initialize all components in your app
initializeAlerts();
initMaterialTailwind();
initializeCharts();

