

import { renderChart } from './chart';

export function initializeCharts() {
    const charts = document.querySelectorAll('[id^="suratChart"]');

    charts.forEach(chart => {
        const seriesData = JSON.parse(chart.dataset.values);
        const categoryData = JSON.parse(chart.dataset.labels);
        renderChart(`#${chart.id}`, seriesData, categoryData);
    });
}

