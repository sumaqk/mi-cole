@extends('template.layout')

@section('title', 'Página de inicio')

@section('cssSection')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <style>
        .stat-card {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px;
            background: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .04);
            height: 100%
        }

        .stat-title {
            font-size: 13px;
            color: #6b7280;
            margin: 0
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            margin: 4px 0 0
        }

        .mcr {
            font-size: 18px
        }

        .mcr-bad {
            color: #dc2626
        }

        .mcr-good {
            color: #0a9d00
        }

        .mcr-na {
            color: #111827
        }

        .table thead th {
            background-color: #343a40;
            color: #fff;
            text-align: center
        }
    </style>
@endsection

@section('generalBody')
    @php
        use Illuminate\Support\Carbon;

        $monthsEs = [
            'Enero',
            'Febrero',
            'Marzo',
            'Abril',
            'Mayo',
            'Junio',
            'Julio',
            'Agosto',
            'Setiembre',
            'Octubre',
            'Noviembre',
            'Diciembre',
        ];
        $currentMonthNum = (int) date('m');
        $currentYear = (int) date('Y');
        $currentMonthName = $monthsEs[$currentMonthNum - 1];

        $allRows = collect($listTWater ?? []);

        $rows = $allRows
            ->filter(function ($v) use ($currentMonthNum, $currentYear, $currentMonthName) {
                $upd = isset($v->updated_at) ? Carbon::parse($v->updated_at) : null;
                if ($upd && (int) $upd->format('Y') === $currentYear && (int) $upd->format('m') === $currentMonthNum) {
                    return true;
                }

                $crt = isset($v->created_at) ? Carbon::parse($v->created_at) : null;
                if ($crt && (int) $crt->format('Y') === $currentYear && (int) $crt->format('m') === $currentMonthNum) {
                    return true;
                }

                if (isset($v->mes) && trim((string) $v->mes) === $currentMonthName) {
                    if ($crt && (int) $crt->format('Y') !== $currentYear) {
                        return false;
                    }
                    return true;
                }
                return false;
            })
            ->values();

        $withReport = 0;
        $withoutReport = 0;
        $sumAll = 0.0;
        $countAll = 0;
        foreach ($rows as $r) {
            $any = false;
            for ($i = 1; $i <= 5; $i++) {
                $f = "resultW{$i}";
                if (isset($r->$f) && $r->$f != -1) {
                    $any = true;
                    $sumAll += (float) $r->$f;
                    $countAll++;
                }
            }
            $any ? $withReport++ : $withoutReport++;
        }
        $avgAll = $countAll === 0 ? 0 : round($sumAll / $countAll, 2);

        $weekAverages = [];
        for ($w = 1; $w <= 5; $w++) {
            $sum = 0.0;
            $cnt = 0;
            foreach ($rows as $r) {
                $f = "resultW{$w}";
                if (isset($r->$f) && $r->$f != -1) {
                    $sum += (float) $r->$f;
                    $cnt++;
                }
            }
            $weekAverages[$w] = $cnt === 0 ? 0 : round($sum / $cnt, 2);
        }

        // closure para clases de color (evita "Cannot redeclare ...")
        $mcrClassVal = static function ($v) {
            if ($v == -1) {
                return 'mcr-na';
            }
            return $v < 0.5 || $v > 5.0 ? 'mcr-bad' : 'mcr-good';
        };
    @endphp

    <div class="nav-tabs-custom">
        <div class="tab-content">

            <div class="row" style="margin-bottom:10px">
                <div class="col-sm-12">
                    <h3 style="margin:10px 0 6px;">Datos del mes actual: <strong>{{ $currentMonthName }}
                            {{ $currentYear }}</strong></h3>
                    <div style="color:#6b7280">Sistema “Mi Cole con Agua”</div>
                </div>
            </div>

            <div class="row" style="margin-bottom:16px">
                <div class="col-sm-3">
                    <div class="stat-card">
                        <p class="stat-title">Instituciones con al menos 1 reporte</p>
                        <p class="stat-value">{{ $withReport }}</p>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="stat-card">
                        <p class="stat-title">Exportar instituciones sin reporte</p>
                        <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:8px;">
                            <a href="{{ route('water.exportNonReporting', ['scope' => 'month']) }}"
                                class="btn btn-warning btn-sm">
                                <i class="fa fa-file-excel-o"></i> Mes actual
                            </a>
                            <a href="{{ route('water.exportNonReporting', ['scope' => 'week']) }}"
                                class="btn btn-danger btn-sm">
                                <i class="fa fa-file-excel-o"></i> Semana actual
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="stat-card">
                        <p class="stat-title">Exportar instituciones CON reporte</p>
                        <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:8px;">
                            <a href="{{ route('water.exportWithReporting', ['scope' => 'month']) }}"
                                class="btn btn-success btn-sm">
                                <i class="fa fa-file-excel-o"></i> Mes actual
                            </a>
                            <a href="{{ route('water.exportWithReporting', ['scope' => 'week']) }}"
                                class="btn btn-info btn-sm">
                                <i class="fa fa-file-excel-o"></i> Semana actual
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="stat-card">
                        <p class="stat-title">Promedio MCR del mes</p>
                        <p class="stat-value">{{ number_format($avgAll, 2, '.', '') }}</p>
                    </div>
                </div>
            </div>

            {{-- <div class="row" style="margin-bottom:24px">
                <div class="col-sm-12">
                    <div class="stat-card">
                        <p class="stat-title" style="margin-bottom:8px;">Promedio semanal de cloro residual (MCR) —
                            {{ $currentMonthName }} {{ $currentYear }}</p>
                        <canvas id="chartMCR" height="90"></canvas>
                    </div>
                </div>
            </div> --}}

            @if ($rows->isEmpty())
                <div class="alert alert-info" role="alert" style="margin-bottom:10px;">
                    No hay registros para {{ $currentMonthName }} {{ $currentYear }}.
                </div>
            @endif

            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table id="tableMonth" class="table table-striped table-bordered" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>UGEL</th>
                                    <th>Institución</th>
                                    <th>Provincia</th>
                                    <th>Distrito</th>
                                    <th class="text-center">Periodo</th>
                                    <th class="text-center">MCR S. 1</th>
                                    <th class="text-center">MCR S. 2</th>
                                    <th class="text-center">MCR S. 3</th>
                                    <th class="text-center">MCR S. 4</th>
                                    <th class="text-center">MCR S. 5</th>
                                    <th class="text-center">Detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $value)
                                    @php
                                        $updatedIso = isset($value->updated_at)
                                            ? Carbon::parse($value->updated_at)->format('Y-m-d H:i:s')
                                            : Carbon::parse($value->created_at)->format('Y-m-d H:i:s');
                                        $yearRow = isset($value->created_at)
                                            ? Carbon::parse($value->created_at)->format('Y')
                                            : $currentYear;
                                    @endphp
                                    <tr>
                                        <td>{{ $value->ugel ?? 'Sin UGEL' }}</td>
                                        <td>
                                            {{ $value->nombre }}
                                            @if (!empty($value->prestador))
                                                <div><small
                                                        style="color:#5c5c5c;font-weight:bold;">{{ $value->prestador }}</small>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $value->provincia ?? '' }}</td>
                                        <td>{{ $value->distrito ?? '' }}</td>
                                        <td class="text-center" data-order="{{ $updatedIso }}">
                                            <div>{{ $currentMonthName }}</div>
                                            {{ $yearRow }}
                                        </td>
                                        @for ($w = 1; $w <= 5; $w++)
                                            @php
                                                $f = "resultW{$w}";
                                                $v = $value->$f ?? -1;
                                            @endphp
                                            <td class="text-center mcr {{ $mcrClassVal($v) }}">
                                                {{ $v != -1 ? number_format((float) $v, 1, '.', '') : '-' }}
                                            </td>
                                        @endfor
                                        <td class="text-center">
                                            <a href="{{ route('water.detail', ['id' => $value->id]) }}"
                                                class="btn btn-info btn-sm">Ver Más</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- NUEVO: Mapa de Calor - Solo para Admin y Super Supervisor -->
            @if(isset($tUser) && in_array($tUser->role, ['Administrador', 'Super Supervisor']))
            <div class="row" style="margin-top: 20px;">
                <div class="col-sm-12">
                    <div class="stat-card">
                        <h4 style="margin: 0 0 15px 0; color: #495057;">
                            <i class="fa fa-map-marker"></i> Mapa de Calor - Calidad del Agua por Institución
                        </h4>
                        <div id="heatMap" style="height: 500px; border: 1px solid #ddd; border-radius: 5px;"></div>
                        
                        <!-- Leyenda -->
                        <div style="margin-top: 15px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
                            <h5 style="margin: 0 0 15px 0;">Leyenda de Calidad del Agua (MCR - mg/L):</h5>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 10px;">
                                <span style="display: flex; align-items: center; font-size: 13px;">
                                    <span style="width: 18px; height: 18px; background-color: #FF0000; border-radius: 50%; margin-right: 10px;"></span>
                                    <strong>🔴 CRÍTICO:</strong>&nbsp;&lt; 0.3 mg/L - Riesgo microbiológico muy alto
                                </span>
                                <span style="display: flex; align-items: center; font-size: 13px;">
                                    <span style="width: 18px; height: 18px; background-color: #FFFF00; border-radius: 50%; margin-right: 10px; border: 1px solid #ccc;"></span>
                                    <strong>🟡 DEFICIENTE:</strong>&nbsp;0.3 - 0.5 mg/L - Requiere acciones correctivas
                                </span>
                                <span style="display: flex; align-items: center; font-size: 13px;">
                                    <span style="width: 18px; height: 18px; background-color: #00FF00; border-radius: 50%; margin-right: 10px;"></span>
                                    <strong>🟢 ÓPTIMO:</strong>&nbsp;0.5 - 2.0 mg/L - Cumple normativa peruana
                                </span>
                                <span style="display: flex; align-items: center; font-size: 13px;">
                                    <span style="width: 18px; height: 18px; background-color: #0000FF; border-radius: 50%; margin-right: 10px;"></span>
                                    <strong>🔵 ALTO:</strong>&nbsp;2.0 - 5.0 mg/L - Monitorear sabor/olor
                                </span>
                                <span style="display: flex; align-items: center; font-size: 13px;">
                                    <span style="width: 18px; height: 18px; background-color: #800080; border-radius: 50%; margin-right: 10px;"></span>
                                    <strong>🟣 EXCESIVO:</strong>&nbsp;&gt; 5.0 mg/L - Incumple DS 031-2010-SA
                                </span>
                                <span style="display: flex; align-items: center; font-size: 13px;">
                                    <span style="width: 18px; height: 18px; background-color: #808080; border-radius: 50%; margin-right: 10px;"></span>
                                    <strong>⚪ SIN DATOS:</strong>&nbsp;No hay registros del mes actual
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Power BI Dashboard - Solo para Admin y Super Supervisor -->
            @if(isset($tUser) && in_array($tUser->role, ['Administrador', 'Super Supervisor']))
            <div class="row" style="margin-top: 20px;">
                <div class="col-sm-12">
                    <div class="stat-card">
                        <h4 style="margin: 0 0 15px 0; color: #495057;">
                            <i class="fa fa-bar-chart"></i> Dashboard Power BI - Análisis de Datos
                        </h4>
                        <div style="position: relative; height: 600px; overflow: hidden; border-radius: 5px;">
                            <iframe 
                                src="https://app.powerbi.com/view?r=eyJrIjoiMTNlYmE0ZjMtMzE1Ny00YzU4LWIzODctOGI3YzNiMmNhYTNmIiwidCI6ImJlNzEzZTU0LTYyMWItNGQ5Ni1hYjI3LTFjYzA0NzcwYTdkMSIsImMiOjR9"
                                width="100%" 
                                height="100%" 
                                style="border: none; border-radius: 5px;"
                                allowfullscreen="true">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
@endsection

@section('jsSection')
    <!-- Leaflet CSS y JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('plugin/adminlte/bower_components/chart.js/Chart.js') }}"></script>
    <script>
        $(function() {
            $('#tableMonth').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
                order: [
                    [4, 'desc']
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
                }
            });
        });

        (function() {
            var el = document.getElementById('chartMCR');
            if (!el) return;
            var ctx = el.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4', 'Semana 5'],
                    datasets: [{
                        label: 'Promedio MCR',
                        data: @json(array_values($weekAverages)),
                        borderWidth: 2,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                suggestedMax: 1.2
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    legend: {
                        display: true
                    }
                }
            });
        })();

        // Mapa de Calor con Leaflet - Solo si el usuario puede verlo
        @if(isset($tUser) && in_array($tUser->role, ['Administrador', 'Super Supervisor']))
        (function() {
            var mapContainer = document.getElementById('heatMap');
            if (!mapContainer) return;

            // Inicializar mapa centrado en Apurímac
            var map = L.map('heatMap').setView([-13.8, -72.8], 9);
            
            // Agregar capa base de OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            // Datos del servidor (base de datos)
            var mapData = @json($mapData ?? []);
            
            // Agregar marcadores para cada institución
            mapData.forEach(function(inst) {
                        
                        // Crear marcador circular con color según estado
                        var marker = L.circleMarker([inst.lat, inst.lng], {
                            color: inst.color,
                            fillColor: inst.color,
                            fillOpacity: 0.8,
                            radius: 10,
                            weight: 2
                        }).addTo(map);
                        
                        // Popup con información detallada
                        marker.bindPopup(`
                            <div style="font-family: Arial, sans-serif;">
                                <h4 style="margin: 0 0 10px 0; color: #333;">${inst.name}</h4>
                                <table style="font-size: 12px; width: 100%; margin-bottom: 10px;">
                                    <tr><td><b>UGEL:</b></td><td>${inst.ugel}</td></tr>
                                    <tr><td><b>Prestador:</b></td><td>${inst.lender}</td></tr>
                                    <tr><td><b>Distrito:</b></td><td>${inst.district}</td></tr>
                                    <tr><td><b>Provincia:</b></td><td>${inst.province}</td></tr>
                                    <tr><td><b>MCR Promedio:</b></td><td>${inst.average} mg/L</td></tr>
                                </table>
                                <div style="padding: 8px; background-color: ${inst.color}20; border-left: 4px solid ${inst.color}; border-radius: 3px;">
                                    <div style="color: ${inst.color}; font-weight: bold; font-size: 13px; margin-bottom: 5px;">
                                        ${inst.status}
                                    </div>
                                    <div style="font-size: 11px; color: #555; line-height: 1.3;">
                                        ${inst.description}
                                    </div>
                                </div>
                            </div>
                        `, {
                            maxWidth: 300
                        });
                    });
        })();
        @endif
    </script>
@endsection
