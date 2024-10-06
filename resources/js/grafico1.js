// resources/js/documentsChart.js
import Chart from 'chart.js/auto'; // Asegúrate de importar Chart.js

// Obtener colores desde las variables CSS
var colorAlto = getComputedStyle(document.documentElement).getPropertyValue('--color-danger').trim();
var colorMedio = getComputedStyle(document.documentElement).getPropertyValue('--color-warning').trim();
var colorBajo = getComputedStyle(document.documentElement).getPropertyValue('--color-success').trim();
var colorBorde = getComputedStyle(document.documentElement).getPropertyValue('--color-primary').trim();

// Asegúrate de que chartData esté definido
if (window.chartData) {
    var labels = window.chartData.labels;
    var data = window.chartData.data;

    // Inicializar el gráfico
    var ctx = document.getElementById('documentsChart').getContext('2d');
    var documentsChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nº de Documentos',
                data: data,
                backgroundColor: [
                    colorAlto,
                    colorMedio,
                    colorBajo,
                ],
                borderColor: [
                    colorBorde,
                    colorBorde,
                    colorBorde,
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
            },
        }
    });
} else {
    console.error("chartData no está definido");
}
