@extends('template.layout')
@section('title', 'Detalle de Institucion')

@section('cssSection')
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.5/dist/js/lightbox.min.js"></script>
    <style>
        .image-gallery {
            width: 100%;
            height: 30rem;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;

        }

        .image-gallery:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .row {
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .image-gallery {
                height: 20rem;
            }
        }
    </style>
@endsection

@section('generalBody')

    <div class="nav-tabs-custom">
        <div class="tab-content">
            <div class="card">
                <div class="card-body">
                    <div class="box box-primary direct-chat direct-chat-primary">
                        <div id="" class="row">
                            <div class="col-md-4">
                                <h2 class="box-title">{{ $institution->name }}<small> / {{ $institution->lender }}</small>
                                </h2>
                            </div>
                            <div class="col-md-2 pull-right">
                                <br>
                                <a href="{{ url('water/getall') }}" type="button"
                                    class="btn btn-success btn-block">Regresar</a>
                            </div>
                        </div>
                        <div class="box-body" style="height: 50vh;">
                            <canvas id="myChart" style="height: 100%; width: 100%;"></canvas>
                        </div>
                        <div class="box-footer">
                            <div class="input-group">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <div class="tab-content">
            <div class="box box-primary direct-chat direct-chat-primary">
                <div class="row">
                    <div class="col-md-4">
                        <h2 class="box-title">Galeria de Fotografias</h2>
                    </div>
                </div>
                @foreach ($formattedImages as $image)
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="box-title" style="font-style: italic; font-weight: bold;">
                                {{ $image->formatted_date }}
                            </h4>
                        </div>
                    </div>

                    @if (empty($image->urlImage1) && empty($image->urlImage2) && empty($image->urlImage3))
                        <div class="row">
                            <div class="col-12">
                                <p class="text-muted">No se subió ninguna imagen</p>
                            </div>
                        </div>
                    @else
                        <div class="row">
                            @if (!empty($image->urlImage1))
                                <div class="col-12 col-md-4 mb-3">
                                    <a href="{{ asset($image->urlImage1) }}" data-lightbox="gallery">
                                        <img src="{{ asset($image->urlImage1) }}" class="img-fluid image-gallery"
                                            alt="Imagen 1">
                                    </a>
                                </div>
                            @endif

                            @if (!empty($image->urlImage2))
                                <div class="col-12 col-md-4 mb-3">
                                    <a href="{{ asset($image->urlImage2) }}" data-lightbox="gallery">
                                        <img src="{{ asset($image->urlImage2) }}" class="img-fluid image-gallery"
                                            alt="Imagen 2">
                                    </a>
                                </div>
                            @endif

                            @if (!empty($image->urlImage3))
                                <div class="col-12 col-md-4 mb-3">
                                    <a href="{{ asset($image->urlImage3) }}" data-lightbox="gallery">
                                        <img src="{{ asset($image->urlImage3) }}" class="img-fluid image-gallery"
                                            alt="Imagen 3">
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

@endsection

@section('jsSection')
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="    https://cdn.jsdelivr.net/npm/lightbox2@2.11.5/dist/css/lightbox.min.css" rel="stylesheet">
    <script>
        const labels = @json($chartLabels); 
        const data = {
            labels: labels,
            datasets: [{
                    label: 'Semana 1',
                    data: @json($chartData['resultW1']),
                    backgroundColor: @json($chartData['resultW1']).map(value => value < 0.5 ?
                        'rgba(255, 51, 51, 1)' : 'rgba(0, 255, 0, 1)')
                },
                {
                    label: 'Semana 2',
                    data: @json($chartData['resultW2']),
                    backgroundColor: @json($chartData['resultW2']).map(value => value < 0.5 ?
                        'rgba(255, 51, 51, 1)' : 'rgba(0, 255, 0, 1)')
                },
                {
                    label: 'Semana 3',
                    data: @json($chartData['resultW3']),
                    backgroundColor: @json($chartData['resultW3']).map(value => value < 0.5 ?
                        'rgba(255, 51, 51, 1)' : 'rgba(0, 255, 0, 1)')
                },
                {
                    label: 'Semana 4',
                    data: @json($chartData['resultW4']),
                    backgroundColor: @json($chartData['resultW4']).map(value => value < 0.5 ?
                        'rgba(255, 51, 51, 1)' : 'rgba(0, 255, 0, 1)')
                },
                {
                    label: 'Semana 5',
                    data: @json($chartData['resultW5']),
                    backgroundColor: @json($chartData['resultW5']).map(value => value < 0.5 ?
                        'rgba(255, 51, 51, 1)' : 'rgba(0, 255, 0, 1)')
                }
            ]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {

                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: 'Resultados de mediciones semanales por mes',
                        position: 'bottom',
                        align: 'center',
                        color: 'rgba(0, 0, 0, 0.7)',
                        font: {
                            size: 20,
                            weight: 'bold'
                        },
                        padding: {
                            top: 30,
                            bottom: 0
                        }

                    }
                },
                scales: {
                    x: {

                        grid: {
                            color: 'rgba(0, 0, 0, 0.4)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 1, 
                        ticks: {
                            stepSize: 0.1, 
                        }
                    }
                }
            }
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>

@endsection
