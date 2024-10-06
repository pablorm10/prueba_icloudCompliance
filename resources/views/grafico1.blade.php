@extends('layouts.app')

@section('content')


@vite('resources/css/graficos.css')

<div class="container chart-container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class='graf-div-text' style="width: 80%; max-width: 600px; height: 60vh;">
        <h2 class="text-center texto-grafica-rueda">Documentos por Relevancia</h2>
        <canvas class="grafico-rueda" id="documentsChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    window.chartData = {
        labels: {!! json_encode($labels) !!},
        data: {!! json_encode($data) !!},
        var colorAlto=getComputedStyle(document.documentElement).getPropertyValue('--color-danger').trim(),
    var colorMedio=getComputedStyle(document.documentElement).getPropertyValue('--color-warning').trim(),
    var colorBajo=getComputedStyle(document.documentElement).getPropertyValue('--color-success').trim(),
    var colorBorde=getComputedStyle(document.documentElement).getPropertyValue('--color-primary').trim(),
    };
</script>
<script>
    var colorAlto=getComputedStyle(document.documentElement).getPropertyValue('--color-danger').trim();
    var colorMedio=getComputedStyle(document.documentElement).getPropertyValue('--color-warning').trim();
    var colorBajo=getComputedStyle(document.documentElement).getPropertyValue('--color-success').trim();
    var colorBorde=getComputedStyle(document.documentElement).getPropertyValue('--color-primary').trim();
    var ctx = document.getElementById('documentsChart').getContext('2d');
    var documentsChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! $labels !!},
            datasets: [{
                label: 'Nº de Documentos',
                data: {!! $data !!},
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
</script>
@endsection
