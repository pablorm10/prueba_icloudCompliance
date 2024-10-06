@extends('layouts.app')

@vite('resources/css/grafica2.css')

@section('content')
<div class="container c-22">
    <h2 class="text-center">Documentos Aprobados por Mes (Año {{$year}})</h2>
    <div class="document-stats">
        <p>Documentos Totales: <span class="spanText">{{$totalDocuments}}</span></p>
        <p>Documentos Aprobados: <span class="spanText">{{$totalApproved}}</span></p>
        <p>Documentos No Aprobados: <span class="spanText">{{$totalNoApproved}}</span></p>
    </div>
    <canvas id="approvedDocumentsChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('approvedDocumentsChart').getContext('2d');
    var colorLine = getComputedStyle(document.documentElement).getPropertyValue('--color-primary').trim();
    var approvedDocumentsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! $labels !!},
            datasets: [{
                label: 'Documentos Aprobados por Mes',  // Título del dataset
                data: {!! $data !!},  // Datos: cantidad de documentos aprobados por mes
                fill: false,
                borderColor: colorLine,  // Color de la línea
                backgroundColor: colorLine,  // Color de fondo (si quisieras rellenar)
                tension: 0.2
            }]
        },
        options: {
            responsive: true,  // Hace el gráfico responsivo
            scales: {
                y: {
                    beginAtZero: true  // El eje Y empieza desde 0
                }
            },
            plugins: {
                legend: {
                    position: 'top',  // Coloca la leyenda en la parte superior
                }
            }
        }
    });
</script>
@endsection
