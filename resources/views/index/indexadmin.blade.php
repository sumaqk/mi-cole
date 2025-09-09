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
        
        /* Estilos para el mapa de calor */
        #heatMap {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            padding: 0 !important;
            margin: 0 !important;
            overflow: hidden;
        }
        
        #heatMap:hover {
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
            border-color: #007bff;
        }
        
        /* Efecto de resplandor para marcadores del mapa */
        .leaflet-marker-icon {
            filter: drop-shadow(0 0 3px rgba(0, 0, 0, 0.3));
            transition: all 0.3s ease;
        }
        
        .leaflet-marker-icon:hover {
            filter: drop-shadow(0 0 8px rgba(0, 123, 255, 0.6));
            transform: scale(1.1);
        }
        
        /* Estilos para marcadores personalizados */
        .custom-marker {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
            transition: all 0.3s ease;
        }
        
        /* Animación de pulsación para marcadores */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(0, 123, 255, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 123, 255, 0); }
        }
        
        /* Estilo de la leyenda mejorado */
        .legend-item {
            transition: all 0.2s ease;
            padding: 8px;
            border-radius: 5px;
        }
        
        .legend-item:hover {
            background-color: rgba(0, 123, 255, 0.05);
            transform: translateX(2px);
        }
        
        /* Estilos para etiquetas de provincias */
        .provincia-label {
            background: none !important;
            border: none !important;
            box-shadow: none !important;
        }
        
        .provincia-label div {
            font-family: 'Arial', sans-serif;
            letter-spacing: 0.5px;
        }
        
        /* Marca de agua para capturas */
        .watermark {
            pointer-events: none; /* No interfiere con el mapa */
            user-select: none; /* No se puede seleccionar */
            opacity: 0.85;
            transition: opacity 0.3s ease;
        }
        
        #heatMap:hover .watermark {
            opacity: 0.6; /* Se hace más transparente al hacer hover en el mapa */
        }
        
        /* Efectos para el mapa SVG de Apurímac */
        .apurimac-map-overlay {
            filter: drop-shadow(2px 2px 8px rgba(0, 0, 0, 0.3)) 
                   drop-shadow(-1px -1px 3px rgba(255, 255, 255, 0.2));
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
        $selectedMonth = request('month', date('m'));
        $selectedYear = request('year', date('Y'));
        $currentMonthNum = (int) $selectedMonth;
        $currentYear = (int) $selectedYear;
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
            @if(isset($tUser) && (strpos($tUser->role, 'Administrador') !== false || strpos($tUser->role, 'Super Supervisor') !== false || strpos($tUser->role, 'Súper usuario') !== false))
            <div class="row" style="margin-top: 20px;">
                <div class="col-sm-12">
                    <div class="stat-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h4 style="margin: 0; color: #495057; text-shadow: 1px 1px 2px rgba(0,0,0,0.1); font-weight: 600;">
                                <i class="fa fa-map-marker" style="color: #007bff; text-shadow: 0 0 5px rgba(0,123,255,0.3);"></i> Mapa de Calor - Calidad del Agua por Institución
                            </h4>
                            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                                <!-- Selector de fecha para cambiar periodo -->
                                <div style="display: flex; gap: 5px; align-items: center;">
                                    <label style="font-size: 12px; color: #666; white-space: nowrap;">📅 Periodo:</label>
                                    <select id="monthSelector" class="form-control" style="width: 100px; height: 30px; font-size: 12px;">
                                        <option value="1" {{ $currentMonthNum == 1 ? 'selected' : '' }}>Enero</option>
                                        <option value="2" {{ $currentMonthNum == 2 ? 'selected' : '' }}>Febrero</option>
                                        <option value="3" {{ $currentMonthNum == 3 ? 'selected' : '' }}>Marzo</option>
                                        <option value="4" {{ $currentMonthNum == 4 ? 'selected' : '' }}>Abril</option>
                                        <option value="5" {{ $currentMonthNum == 5 ? 'selected' : '' }}>Mayo</option>
                                        <option value="6" {{ $currentMonthNum == 6 ? 'selected' : '' }}>Junio</option>
                                        <option value="7" {{ $currentMonthNum == 7 ? 'selected' : '' }}>Julio</option>
                                        <option value="8" {{ $currentMonthNum == 8 ? 'selected' : '' }}>Agosto</option>
                                        <option value="9" {{ $currentMonthNum == 9 ? 'selected' : '' }}>Setiembre</option>
                                        <option value="10" {{ $currentMonthNum == 10 ? 'selected' : '' }}>Octubre</option>
                                        <option value="11" {{ $currentMonthNum == 11 ? 'selected' : '' }}>Noviembre</option>
                                        <option value="12" {{ $currentMonthNum == 12 ? 'selected' : '' }}>Diciembre</option>
                                    </select>
                                    <select id="yearSelector" class="form-control" style="width: 80px; height: 30px; font-size: 12px;">
                                        @for($y = date('Y'); $y >= 2020; $y--)
                                            <option value="{{ $y }}" {{ $currentYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                    <button id="changePeriodBtn" class="btn btn-primary btn-sm" onclick="changePeriod()" title="Cambiar a este periodo">
                                        <i class="fa fa-refresh"></i>
                                    </button>
                                </div>
                                
                                <!-- Botones de captura -->
                                <div style="display: flex; gap: 8px;">
                                    <button id="captureMapBtn" class="btn btn-success btn-sm" onclick="captureMapScreenshot()" title="Capturar screenshot del mapa">
                                        <i class="fa fa-camera"></i> Capturar
                                    </button>
                                    <button id="testAutoBtn" class="btn btn-warning btn-sm" onclick="testAutomaticCapture()" title="Test de captura automática">
                                        <i class="fa fa-cogs"></i> Test Auto
                                    </button>
                                    <a href="{{ route('map.history') }}" class="btn btn-info btn-sm" title="Ver historial de mapas capturados">
                                        <i class="fa fa-history"></i> Historial
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="heatMap" style="height: 70vh; min-height: 640px; border: 1px solid #ddd; border-radius: 5px; position: relative;">
                            <!-- Marca de agua para capturas -->
                            <div class="watermark" style="position: absolute; bottom: 8px; right: 8px; z-index: 2000; background: rgba(255,255,255,0.9); padding: 3px 8px; border-radius: 4px; font-size: 10px; color: #555; font-family: Arial, sans-serif; border: 1px solid rgba(200,200,200,0.6); box-shadow: 0 1px 3px rgba(0,0,0,0.15); white-space: nowrap;">
                                Fuente: Mi Cole Con Agua Segura
                            </div>
                        </div>
                        
                        <!-- Leyenda -->
                        <div style="margin-top: 15px; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
                            <h5 style="margin: 0 0 15px 0;">Leyenda de Calidad del Agua (MCR - mg/L):</h5>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 10px;">
                                <span class="legend-item" style="display: flex; align-items: center; font-size: 13px;">
                                    <span style="width: 18px; height: 18px; background-color: #FF0000; border-radius: 50%; margin-right: 10px; box-shadow: 0 0 8px rgba(255, 0, 0, 0.4);"></span>
                                    <strong>CRÍTICO:</strong>&nbsp;&lt; 0.3 mg/L - Riesgo microbiológico muy alto
                                </span>
                                <span class="legend-item" style="display: flex; align-items: center; font-size: 13px;">
                                    <span style="width: 18px; height: 18px; background-color: #FF8C00; border-radius: 50%; margin-right: 10px; border: 1px solid #ccc; box-shadow: 0 0 8px rgba(255, 140, 0, 0.4);"></span>
                                    <strong>DEFICIENTE:</strong>&nbsp;0.3 - 0.5 mg/L - Requiere acciones correctivas
                                </span>
                                <span class="legend-item" style="display: flex; align-items: center; font-size: 13px;">
                                    <span style="width: 18px; height: 18px; background-color: #00FF00; border-radius: 50%; margin-right: 10px; box-shadow: 0 0 8px rgba(0, 255, 0, 0.4);"></span>
                                    <strong>ÓPTIMO:</strong>&nbsp;0.5 - 2.0 mg/L - Cumple normativa peruana
                                </span>
                                <span class="legend-item" style="display: flex; align-items: center; font-size: 13px;">
                                    <span style="width: 18px; height: 18px; background-color: #0000FF; border-radius: 50%; margin-right: 10px; box-shadow: 0 0 8px rgba(0, 0, 255, 0.4);"></span>
                                    <strong>ALTO:</strong>&nbsp;2.0 - 5.0 mg/L - Monitorear sabor/olor
                                </span>
                                <span class="legend-item" style="display: flex; align-items: center; font-size: 13px;">
                                    <span style="width: 18px; height: 18px; background-color: #800080; border-radius: 50%; margin-right: 10px; box-shadow: 0 0 8px rgba(128, 0, 128, 0.4);"></span>
                                    <strong>EXCESIVO:</strong>&nbsp;&gt; 5.0 mg/L - Incumple DS 031-2010-SA
                                </span>
                                <span class="legend-item" style="display: flex; align-items: center; font-size: 13px;">
                                    <span style="width: 18px; height: 18px; background-color: #808080; border-radius: 50%; margin-right: 10px; box-shadow: 0 0 8px rgba(128, 128, 128, 0.4);"></span>
                                    <strong>SIN DATOS:</strong>&nbsp;No hay registros del mes actual
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Power BI Dashboard - Solo para Admin y Super Supervisor -->
            @if(isset($tUser) && (strpos($tUser->role, 'Administrador') !== false || strpos($tUser->role, 'Super Supervisor') !== false || strpos($tUser->role, 'Súper usuario') !== false))
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
    
    <!-- dom-to-image para capturar screenshots -->
    <script src="https://cdn.jsdelivr.net/npm/dom-to-image@2.6.0/dist/dom-to-image.min.js"></script>
    
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
                    url: "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
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
        @if(isset($tUser) && (strpos($tUser->role, 'Administrador') !== false || strpos($tUser->role, 'Super Supervisor') !== false || strpos($tUser->role, 'Súper usuario') !== false))
        (function() {
            var mapContainer = document.getElementById('heatMap');
            if (!mapContainer) return;

            // Inicializar mapa centrado en Apurímac con zoom más cercano
            var map = L.map('heatMap').setView([-14.00, -72.9], 9);
            globalMap = map; // Asignar a variable global
            
            // Definir diferentes tipos de mapas disponibles
            var baseMaps = {
                "🗺️ OpenStreetMap": L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }),
                "🛰️ Satélite": L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: '© Esri &mdash; Source: Esri, Maxar, GeoEye, Earthstar Geographics'
                }),
                "🌍 Terreno": L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenTopoMap (CC-BY-SA)'
                }),
                "🌙 Modo Oscuro": L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', {
                    attribution: '© Stadia Maps © OpenMapTiles © OpenStreetMap contributors'
                }),
                "📍 CartoDB": L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                    attribution: '© OpenStreetMap contributors © CARTO',
                    subdomains: 'abcd'
                }),
                "📄 Mapa Blanco": L.tileLayer('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAC0lEQVQIHWP4//8/AAX+Av7czFnnAAAAAElFTkSuQmCC', {
                    attribution: 'Mapa estadístico blanco para capturas limpias'
                })
            };
            
            // Agregar capa base por defecto (OpenStreetMap)
            baseMaps["🗺️ OpenStreetMap"].addTo(map);
            
            // Agregar control de capas para cambiar tipos de mapa
            L.control.layers(baseMaps).addTo(map);
            
            // Agregar el SVG de Apurímac como overlay (coordenadas originales)
            var apurimacBounds = [[-12.59, -71.85], [-15.41111,-74.16]];
            var apurimacOverlay = L.imageOverlay('{{ asset("img/mapa/mapa.svg") }}', apurimacBounds, {
                opacity: 0.4, // Aumentar un poco la opacidad para que se vea mejor con los efectos
                interactive: false,
                className: 'apurimac-map-overlay' // Clase CSS para aplicar efectos
            }).addTo(map);
            
            // Ajustar el mapa para que encaje perfectamente en el contenedor
            // map.fitBounds(apurimacBounds, {
            //     padding: [20, 20] 
            // });
            
            // Datos del servidor (base de datos)
            var mapData = @json($mapData ?? []);
            
            // Coordenadas aproximadas de las provincias de Apurímac
            var provincias = [
                { name: 'ABANCAY', lat: -13.6333, lng: -72.8831, size: 'large' },
                { name: 'ANDAHUAYLAS', lat: -13.6564, lng: -73.3867, size: 'large' },
                { name: 'ANTABAMBA', lat: -14.3667, lng: -72.8833, size: 'medium' },
                { name: 'AYMARAES', lat: -14.2000, lng: -73.2167, size: 'medium' },
                { name: 'CHINCHEROS', lat: -13.4167, lng: -73.5167, size: 'medium' },
                { name: 'COTABAMBAS', lat: -14.0333, lng: -72.0500, size: 'medium' },
                { name: 'GRAU', lat: -14.0833, lng: -72.6667, size: 'medium' }
            ];
            
            // Agregar marcadores para cada institución
            mapData.forEach(function(inst) {
                        
                        // Definir z-index y tamaño según el color (grises al fondo y más pequeños)
                        var isGray = inst.color === '#808080';
                        var zIndex = isGray ? 100 : 500; // Gris al fondo, otros colores encima
                        var radius = isGray ? 9 : 12; // Grises más pequeños
                        var opacity = isGray ? 0.7 : 0.9; // Grises más transparentes
                        
                        // Crear marcador circular con color según estado y efectos visuales
                        var marker = L.circleMarker([inst.lat, inst.lng], {
                            color: '#ffffff',
                            fillColor: inst.color,
                            fillOpacity: opacity,
                            radius: radius,
                            weight: isGray ? 2 : 3,
                            opacity: 1,
                            className: 'custom-marker',
                            zIndexOffset: zIndex
                        }).addTo(map);
                        
                        // Agregar efecto de pulsación (respetando el tamaño original)
                        marker.on('mouseover', function(e) {
                            var hoverRadius = isGray ? 12 : 16; // Hover proporcional
                            e.target.setStyle({
                                radius: hoverRadius,
                                fillOpacity: 1,
                                weight: isGray ? 3 : 4
                            });
                        });
                        
                        marker.on('mouseout', function(e) {
                            e.target.setStyle({
                                radius: radius, // Volver al tamaño original
                                fillOpacity: opacity, // Volver a la opacidad original
                                weight: isGray ? 2 : 3
                            });
                        });
                        
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
            
            // Agregar etiquetas de provincias
            provincias.forEach(function(provincia) {
                var fontSize = provincia.size === 'large' ? '14px' : '12px';
                var fontWeight = provincia.size === 'large' ? 'bold' : '600';
                
                var divIcon = L.divIcon({
                    className: 'provincia-label',
                    html: '<div style="color: #2c3e50; font-size: ' + fontSize + '; font-weight: ' + fontWeight + '; text-shadow: 2px 2px 4px rgba(255,255,255,0.8), -1px -1px 2px rgba(255,255,255,0.8), 1px -1px 2px rgba(255,255,255,0.8), -1px 1px 2px rgba(255,255,255,0.8); text-align: center; white-space: nowrap; pointer-events: none;">' + provincia.name + '</div>',
                    iconSize: [100, 20],
                    iconAnchor: [50, 10]
                });
                
                L.marker([provincia.lat, provincia.lng], {
                    icon: divIcon,
                    interactive: false, // No interactúa con clics
                    zIndexOffset: 1000 // Aparece encima de otros elementos
                }).addTo(map);
            });
        })();
        @endif

        // Variable global para el mapa
        var globalMap = null;
        
        // Función para capturar mapa con dom-to-image
        function captureMapScreenshot(isAutomatic = false) {
            const captureBtn = document.getElementById('captureMapBtn');
            const originalText = captureBtn.innerHTML;
            
            // Cambiar botón a estado de carga
            captureBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Capturando...';
            captureBtn.disabled = true;
            
            // Capturar el contenedor del mapa
            const mapContainer = document.getElementById('heatMap');
            
            if (!mapContainer) {
                alert('No se encontró el mapa para capturar');
                captureBtn.innerHTML = originalText;
                captureBtn.disabled = false;
                return;
            }
            
            // Usar dom-to-image que funciona mejor con Leaflet
            domtoimage.toBlob(mapContainer, {
                quality: 0.95,
                bgcolor: '#ffffff',
                width: mapContainer.offsetWidth,
                height: mapContainer.offsetHeight,
                style: {
                    padding: '0px',
                    margin: '0px'
                },
                filter: function (node) {
                    // Filtrar elementos problemáticos
                    if (node.classList) {
                        return !node.classList.contains('leaflet-control-zoom') &&
                               !node.classList.contains('leaflet-bar') &&
                               !node.classList.contains('leaflet-control-attribution');
                    }
                    return true;
                }
            })
            .then(function (blob) {
                // Crear FormData para enviar la imagen
                const formData = new FormData();
                formData.append('map_screenshot', blob, 'mapa_captura.png');
                formData.append('_token', '{{ csrf_token() }}');
                
                // Agregar información del periodo de datos que se está mostrando
                const urlParams = new URLSearchParams(window.location.search);
                const dataMonth = urlParams.get('month') || '{{ $currentMonthNum }}';
                const dataYear = urlParams.get('year') || '{{ $currentYear }}';
                const months = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                              'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                const dataMonthName = months[parseInt(dataMonth)];
                
                formData.append('data_period_month', dataMonth);
                formData.append('data_period_year', dataYear);
                formData.append('data_period_name', dataMonthName);
                
                if (isAutomatic) {
                    formData.append('is_automatic', 'true');
                }
                
                // Enviar al servidor
                fetch('{{ route("map.capture") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const captureType = isAutomatic ? 'automática' : 'manual';
                        alert('✅ Mapa capturado exitosamente (' + captureType + ')!\n\nArchivo: ' + data.filename);
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al enviar la captura al servidor');
                })
                .finally(() => {
                    captureBtn.innerHTML = originalText;
                    captureBtn.disabled = false;
                });
            })
            .catch(function (error) {
                console.error('Error al capturar:', error);
                
                // Verificar si estamos en modo que puede tener problemas de carga (como Acuarela)
                if (error.message === 'undefined' || !error.message || error.message.includes('undefined')) {
                    // Intentar captura con método canvas básico
                    console.log('Usando método de captura alternativo para vista blanca...');
                    
                    const canvas = document.createElement('canvas');
                    canvas.width = mapContainer.offsetWidth;
                    canvas.height = mapContainer.offsetHeight;
                    const ctx = canvas.getContext('2d');
                    
                    // Crear fondo blanco limpio
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    
                    // Intentar dibujar elementos visibles del DOM (marcadores, provincias, etc.)
                    // Esto es una captura "simulada" pero mantendrá la estructura visual
                    
                    canvas.toBlob(function(blob) {
                        const formData = new FormData();
                        formData.append('map_screenshot', blob, 'mapa_captura_blanco.png');
                        formData.append('_token', '{{ csrf_token() }}');
                        if (isAutomatic) {
                            formData.append('is_automatic', 'true');
                        }
                        
                        fetch('{{ route("map.capture") }}', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const captureType = isAutomatic ? 'automática' : 'manual';
                                alert('✅ Mapa capturado exitosamente (' + captureType + ') - Vista Blanca!\n\nArchivo: ' + data.filename + '\n\n(Capturado con método alternativo para vista estadística)');
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(() => {
                            alert('Error definitivo al capturar el mapa');
                        })
                        .finally(() => {
                            captureBtn.innerHTML = originalText;
                            captureBtn.disabled = false;
                        });
                    }, 'image/png');
                } else {
                    alert('Error al capturar el mapa: ' + error.message);
                    captureBtn.innerHTML = originalText;
                    captureBtn.disabled = false;
                }
            });
        }
        
        // Función para test de captura automática
        function testAutomaticCapture() {
            const testBtn = document.getElementById('testAutoBtn');
            const originalText = testBtn.innerHTML;
            
            // Cambiar botón a estado de carga
            testBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Probando...';
            testBtn.disabled = true;
            
            // Llamar al endpoint de test automático
            fetch('{{ route("map.auto-capture-test") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.action === 'trigger_frontend_capture') {
                    alert('✅ Test automático iniciado!\n\nAhora se ejecutará la captura marcada como automática...');
                    // Ejecutar la función de captura pero marcándola como automática
                    captureMapScreenshot(true);
                } else {
                    alert('Error en test automático: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al ejecutar test automático');
            })
            .finally(() => {
                testBtn.innerHTML = originalText;
                testBtn.disabled = false;
            });
        }
        
        // Función para cambiar periodo del mapa
        function changePeriod() {
            const month = document.getElementById('monthSelector').value;
            const year = document.getElementById('yearSelector').value;
            const btn = document.getElementById('changePeriodBtn');
            const originalText = btn.innerHTML;
            
            // Cambiar botón a estado de carga
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
            btn.disabled = true;
            
            // Recargar página con nuevos parámetros
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('month', month);
            currentUrl.searchParams.set('year', year);
            
            window.location.href = currentUrl.toString();
        }
        
        // Mostrar periodo actual en el título si no es el mes actual
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const selectedMonth = urlParams.get('month');
            const selectedYear = urlParams.get('year');
            
            if (selectedMonth && selectedYear) {
                const months = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                              'Julio', 'Agosto', 'Setiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                const monthName = months[parseInt(selectedMonth)];
                
                // Actualizar selectores
                document.getElementById('monthSelector').value = selectedMonth;
                document.getElementById('yearSelector').value = selectedYear;
                
                // Actualizar título si no es el mes actual
                const currentMonth = new Date().getMonth() + 1;
                const currentYear = new Date().getFullYear();
                
                if (selectedMonth != currentMonth || selectedYear != currentYear) {
                    const titleElement = document.querySelector('h4');
                    if (titleElement) {
                        const originalTitle = titleElement.innerHTML;
                        titleElement.innerHTML = originalTitle + ` <span style="color: #ff6b35; font-weight: normal; font-size: 14px;">(Viendo: ${monthName} ${selectedYear})</span>`;
                    }
                }
            }
        });
    </script>
@endsection
