import './bootstrap';
import './components/datepicker';
import './components/filepond';
import { initMaterialTailwind } from '@material-tailwind/html';
import Alpine from 'alpinejs';
import { initializeCharts } from './components/initChart';

window.Alpine = Alpine;

Alpine.start();



// Initialize all components in your app
initMaterialTailwind();
initializeCharts();

