@include('home/layout/header')

<style>
    body {
        background: linear-gradient(135deg, #0077be 0%, #00a8cc 100%);
        min-height: 100vh;
        overflow-x: hidden;
    }

    .water-wave {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0, 119, 190, 0.1) 0%, rgba(0, 168, 204, 0.1) 100%);
        overflow: hidden;
        z-index: -1;
    }

    .water-wave::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 200%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1000 100'%3E%3Cpath d='M421.9,6.5c22.6-2.5,51.5,0.4,75.5,5.3c23.6,4.9,70.9,23.5,100.5,35.7c75.8,32.2,133.7,44.5,192.6,49.7c23.6,2.1,48.7,3.5,103.4-2.5c54.7-6,106.2-25.6,106.2-25.6V0H0v30.3c0,0,72,32.6,158.4,30.5c39.2-0.7,92.8-6.7,133-18.6c27.7-8.2,44.6-16.6,69.5-18.8C384.4,20.9,400.4,21.4,421.9,6.5z' fill='rgba(255,255,255,0.1)'/%3E%3C/svg%3E") repeat-x;
        animation: wave 10s linear infinite;
    }

    @keyframes wave {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    .bubble {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        animation: float 6s ease-in-out infinite;
        z-index: 1;
    }

    .bubble:nth-child(1) { width: 40px; height: 40px; left: 10%; animation-delay: 0s; }
    .bubble:nth-child(2) { width: 20px; height: 20px; left: 20%; animation-delay: 2s; }
    .bubble:nth-child(3) { width: 60px; height: 60px; left: 35%; animation-delay: 4s; }
    .bubble:nth-child(4) { width: 80px; height: 80px; left: 50%; animation-delay: 0s; }
    .bubble:nth-child(5) { width: 30px; height: 30px; left: 70%; animation-delay: 1s; }
    .bubble:nth-child(6) { width: 90px; height: 90px; left: 80%; animation-delay: 3s; }

    @keyframes float {
        0%, 100% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
        10%, 90% { opacity: 1; }
        50% { transform: translateY(-10vh) rotate(180deg); }
    }

    .water-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        position: relative;
        overflow: hidden;
        min-height: 350px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .water-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1000 100'%3E%3Cpath d='M421.9,6.5c22.6-2.5,51.5,0.4,75.5,5.3c23.6,4.9,70.9,23.5,100.5,35.7c75.8,32.2,133.7,44.5,192.6,49.7c23.6,2.1,48.7,3.5,103.4-2.5c54.7-6,106.2-25.6,106.2-25.6V0H0v30.3c0,0,72,32.6,158.4,30.5c39.2-0.7,92.8-6.7,133-18.6c27.7-8.2,44.6-16.6,69.5-18.8C384.4,20.9,400.4,21.4,421.9,6.5z' fill='rgba(255,255,255,0.1)'/%3E%3C/svg%3E") repeat-x;
        animation: wave 15s linear infinite;
        opacity: 0.6;
    }

    .header-content {
        text-align: center;
        z-index: 2;
        position: relative;
    }

    .water-drop {
        display: inline-block;
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #74b9ff, #0984e3);
        border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
        margin-bottom: 20px;
        animation: droplet 2s ease-in-out infinite;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .water-drop::before {
        content: '💧';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 40px;
        color: white;
    }

    @keyframes droplet {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-10px) scale(1.05); }
    }

    .counter-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 30px;
        margin: 20px auto;
        max-width: 400px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        animation: slideInUp 1s ease-out;
    }

    .counter-number {
        font-size: 4rem;
        font-weight: bold;
        background: linear-gradient(135deg, #0077be, #00a8cc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: countUp 2s ease-out;
    }

    @keyframes slideInUp {
        from { transform: translateY(50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    @keyframes countUp {
        from { transform: scale(0.5); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .filter-container {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 20px;
        margin: 30px auto;
        max-width: 600px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        animation: slideInDown 1s ease-out;
    }

    @keyframes slideInDown {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .filter-btn {
        background: linear-gradient(135deg, #0077be, #00a8cc);
        border: none;
        color: white;
        padding: 12px 25px;
        margin: 5px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .filter-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .filter-btn:hover::before {
        left: 100%;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #28a745, #20c997);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .group-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        margin: 20px 0;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease-out;
        animation-fill-mode: both;
    }

    .group-card:nth-child(even) { animation-delay: 0.1s; }
    .group-card:nth-child(odd) { animation-delay: 0.2s; }

    @keyframes fadeInUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .group-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .group-header {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        color: white;
        padding: 25px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .group-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.8s ease;
    }

    .group-header:hover::before {
        left: 100%;
    }

    .group-code {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 8px 15px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 10px;
    }

    .group-title {
        font-size: 1.8rem;
        font-weight: bold;
        margin: 10px 0;
    }

    .group-info {
        opacity: 0.9;
        font-size: 14px;
    }

    .toggle-icon {
        float: right;
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }

    .group-header.collapsed .toggle-icon {
        transform: rotate(45deg);
    }

    .institution-grid {
        padding: 30px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 20px;
    }

    .institution-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .institution-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(135deg, #0077be, #00a8cc);
    }

    .institution-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .institution-name {
        font-size: 1.3rem;
        font-weight: bold;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .institution-type {
        background: linear-gradient(135deg, #0077be, #00a8cc);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 10px;
    }

    .institution-location {
        color: #718096;
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    .institution-location i {
        margin-right: 5px;
        color: #4facfe;
    }

    @media (max-width: 768px) {
        .filter-btn {
            padding: 10px 15px;
            font-size: 14px;
        }
        
        .group-title {
            font-size: 1.4rem;
        }
        
        .counter-number {
            font-size: 3rem;
        }
        
        .institution-grid {
            grid-template-columns: 1fr;
            padding: 20px;
        }
    }

    @keyframes slideInDown {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .filter-btn {
        background: linear-gradient(135deg, #0077be, #00a8cc);
        border: none;
        color: white;
        padding: 12px 25px;
        margin: 5px;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .filter-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .filter-btn:hover::before {
        left: 100%;
    }

    .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #28a745, #20c997);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    .group-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        margin: 20px 0;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
        animation: fadeInUp 0.6s ease-out;
        animation-fill-mode: both;
    }

    .group-card:nth-child(even) { animation-delay: 0.1s; }
    .group-card:nth-child(odd) { animation-delay: 0.2s; }

    @keyframes fadeInUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .group-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .group-header {
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        color: white;
        padding: 25px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .group-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.8s ease;
    }

    .group-header:hover::before {
        left: 100%;
    }

    .group-code {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 8px 15px;
        border-radius: 50px;
        font-size: 14px;
        font-weight: bold;
        display: inline-block;
        margin-bottom: 10px;
    }

    .group-title {
        font-size: 1.8rem;
        font-weight: bold;
        margin: 10px 0;
    }

    .group-info {
        opacity: 0.9;
        font-size: 14px;
    }

    .toggle-icon {
        float: right;
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }

    .group-header.collapsed .toggle-icon {
        transform: rotate(45deg);
    }

    /* Cards de instituciones */
    .institution-grid {
        padding: 30px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 20px;
    }

    .institution-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .institution-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(135deg, #0077be, #00a8cc);
    }

    .institution-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .institution-name {
        font-size: 1.3rem;
        font-weight: bold;
        color: #2d3748;
        margin-bottom: 10px;
    }

    .institution-type {
        background: linear-gradient(135deg, #0077be, #00a8cc);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 10px;
    }

    .institution-location {
        color: #718096;
        font-size: 14px;
        display: flex;
        align-items: center;
    }

    .institution-location i {
        margin-right: 5px;
        color: #4facfe;
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

    /* Efectos para el mapa SVG de Apurímac */
    .apurimac-map-overlay {
        filter: drop-shadow(2px 2px 8px rgba(0, 0, 0, 0.3))
               drop-shadow(-1px -1px 3px rgba(255, 255, 255, 0.2));
    }

    /* Ocultar atribución automática de Leaflet */
    .leaflet-control-attribution {
        display: none !important;
    }

    .heat-map-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        margin: 30px 0;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .heat-map-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .filter-btn {
            padding: 10px 15px;
            font-size: 14px;
        }

        .group-title {
            font-size: 1.4rem;
        }

        .counter-number {
            font-size: 3rem;
        }

        .institution-grid {
            grid-template-columns: 1fr;
            padding: 20px;
        }
    }
</style>

<!-- Burbujas flotantes -->
<div class="water-wave">
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
    <div class="bubble"></div>
</div>

<!-- Header con tema de agua -->
<div class="water-header">
    <div class="header-content">
        <div class="water-drop"></div>
        <h1 class="text-white font-weight-bold mb-3" style="font-size: 2.5rem;">
            Instituciones Educativas
        </h1>
        <p class="text-white h4 mb-0">
            Estrategia Regional "Mi Cole con Agua Segura"
        </p>
    </div>
</div>

<!-- Contador animado -->
<div class="container">
    <div class="counter-container text-center">
        <div class="counter-number">{{ $totalInstitutions ?? 0 }}</div>
        <h3 class="text-secondary font-weight-bold">Instituciones Participando</h3>
        <p class="text-muted">Comprometidas con el agua segura</p>
    </div>

    <!-- Filtros de agrupación -->
    <div class="filter-container text-center">
        <h4 class="mb-3 font-weight-bold text-secondary">Agrupar por:</h4>
        <div class="filter-buttons">
            <button class="filter-btn {{ ($groupBy ?? 'ugel') == 'ugel' ? 'active' : '' }}" 
                    onclick="changeGroupBy('ugel')">
                <i class="fas fa-school mr-2"></i>UGEL
            </button>
            <button class="filter-btn {{ ($groupBy ?? 'ugel') == 'district' ? 'active' : '' }}" 
                    onclick="changeGroupBy('district')">
                <i class="fas fa-map-marker-alt mr-2"></i>Distritos
            </button>
            <button class="filter-btn {{ ($groupBy ?? 'ugel') == 'province' ? 'active' : '' }}" 
                    onclick="changeGroupBy('province')">
                <i class="fas fa-globe-americas mr-2"></i>Provincias
            </button>
        </div>
    </div>

    <!-- Mapa de Calor Público -->
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
        $selectedWeek = request('week', null);
        $currentMonthNum = (int) $selectedMonth;
        $currentYear = (int) $selectedYear;
        $currentMonthName = $monthsEs[$currentMonthNum - 1];

        // Calcular semana actual del mes si no se especifica
        if (!$selectedWeek) {
            $today = date('Y-m-d');
            $firstOfMonth = date('Y-m-01', strtotime($today));
            $currentWeek = (int)date('W', strtotime($today)) - (int)date('W', strtotime($firstOfMonth)) + 1;
            if ($currentWeek < 1) $currentWeek = 1;
            if ($currentWeek > 5) $currentWeek = 5;
        } else {
            $currentWeek = (int) $selectedWeek;
        }
    @endphp

    <div class="heat-map-card">
        <div style="background: linear-gradient(135deg, #4facfe, #00f2fe); padding: 25px; border-radius: 20px 20px 0 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <h4 style="margin: 0; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.1); font-weight: 600;">
                    <i class="fa fa-map-marker" style="color: white; text-shadow: 0 0 5px rgba(255,255,255,0.3);"></i> Mapa de Calor - Calidad del Agua
                </h4>
                <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                    <!-- Selector de fecha para cambiar periodo -->
                    <div style="display: flex; gap: 5px; align-items: center;">
                        <label style="font-size: 12px; color: white; white-space: nowrap;">📅 Periodo:</label>
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
                        <select id="weekSelector" class="form-control" style="width: 100px; height: 30px; font-size: 12px;">
                            <option value="1" {{ $currentWeek == 1 ? 'selected' : '' }}>Semana 1</option>
                            <option value="2" {{ $currentWeek == 2 ? 'selected' : '' }}>Semana 2</option>
                            <option value="3" {{ $currentWeek == 3 ? 'selected' : '' }}>Semana 3</option>
                            <option value="4" {{ $currentWeek == 4 ? 'selected' : '' }}>Semana 4</option>
                            <option value="5" {{ $currentWeek == 5 ? 'selected' : '' }}>Semana 5</option>
                        </select>
                        <button id="changePeriodBtn" class="btn btn-light btn-sm" onclick="changePeriod()" title="Cambiar a este periodo">
                            <i class="fa fa-paper-plane"></i> Visualizar
                        </button>
                    </div>
                </div>
            </div>
            <div style="margin-top: 15px; color: rgba(255,255,255,0.9); font-size: 14px;">
                Visualizando datos de: <strong>{{ $currentMonthName }} {{ $currentYear }} - Semana {{ $currentWeek }}</strong>
            </div>
        </div>

        <div style="padding: 20px;">
            <div id="heatMap" style="height: 70vh; min-height: 640px; border: 1px solid #ddd; border-radius: 5px; position: relative;">
                <!-- Marca de agua -->
                <div style="position: absolute; bottom: 8px; right: 8px; z-index: 2000; background: rgba(255,255,255,0.9); padding: 3px 8px; border-radius: 4px; font-size: 10px; color: #555; font-family: Arial, sans-serif; border: 1px solid rgba(200,200,200,0.6); box-shadow: 0 1px 3px rgba(0,0,0,0.15); white-space: nowrap;">
                    Fuente: Mi Cole Con Agua Segura - Mapas: <a href="https://leafletjs.com/" target="_blank" style="color: #007bff; text-decoration: none;">Leaflet</a>
                </div>
            </div>

            <!-- Leyenda -->
            <div style="margin-top: 15px; padding: 10px; background-color: #f8f9fa; border-radius: 5px;">
                <h6 style="margin: 0 0 10px 0; font-size: 14px; font-weight: 600;">Leyenda - Calidad del Agua (MCR - mg/L):</h6>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 5px;">
                    <span class="legend-item" style="display: flex; align-items: center; font-size: 11px; padding: 4px;">
                        <span style="width: 12px; height: 12px; background-color: #FF0000; border-radius: 50%; margin-right: 6px; box-shadow: 0 0 4px rgba(255, 0, 0, 0.4); flex-shrink: 0;"></span>
                        <strong style="color: #dc2626;">CRÍTICO:</strong>&nbsp;&lt; 0.3 - Riesgo muy alto
                    </span>
                    <span class="legend-item" style="display: flex; align-items: center; font-size: 11px; padding: 4px;">
                        <span style="width: 12px; height: 12px; background-color: #FF8C00; border-radius: 50%; margin-right: 6px; box-shadow: 0 0 4px rgba(255, 140, 0, 0.4); flex-shrink: 0;"></span>
                        <strong style="color: #ea580c;">DEFICIENTE:</strong>&nbsp;0.3-0.5 - Requiere acciones
                    </span>
                    <span class="legend-item" style="display: flex; align-items: center; font-size: 11px; padding: 4px;">
                        <span style="width: 12px; height: 12px; background-color: #00FF00; border-radius: 50%; margin-right: 6px; box-shadow: 0 0 4px rgba(0, 255, 0, 0.4); flex-shrink: 0;"></span>
                        <strong style="color: #16a34a;">ÓPTIMO:</strong>&nbsp;0.5-2.0 - Cumple normativa
                    </span>
                    <span class="legend-item" style="display: flex; align-items: center; font-size: 11px; padding: 4px;">
                        <span style="width: 12px; height: 12px; background-color: #0000FF; border-radius: 50%; margin-right: 6px; box-shadow: 0 0 4px rgba(0, 0, 255, 0.4); flex-shrink: 0;"></span>
                        <strong style="color: #2563eb;">ALTO:</strong>&nbsp;2.0-5.0 - Monitorear sabor
                    </span>
                    <span class="legend-item" style="display: flex; align-items: center; font-size: 11px; padding: 4px;">
                        <span style="width: 12px; height: 12px; background-color: #800080; border-radius: 50%; margin-right: 6px; box-shadow: 0 0 4px rgba(128, 0, 128, 0.4); flex-shrink: 0;"></span>
                        <strong style="color: #7c2d92;">EXCESIVO:</strong>&nbsp;&gt; 5.0 - Incumple DS 031
                    </span>
                    <span class="legend-item" style="display: flex; align-items: center; font-size: 11px; padding: 4px;">
                        <span style="width: 12px; height: 12px; background-color: #808080; border-radius: 50%; margin-right: 6px; box-shadow: 0 0 4px rgba(128, 128, 128, 0.4); flex-shrink: 0;"></span>
                        <strong style="color: #6b7280;">SIN DATOS:</strong>&nbsp;No hay registros
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido agrupado -->
    <div class="groups-container">
        @if(($groupBy ?? 'ugel') == 'ugel')
            <!-- Agrupado por UGEL -->
            @foreach ($ugels ?? [] as $ugel)
                @if($ugel->tInstitution->count() > 0)
                    <div class="group-card">
                        <div class="group-header collapsed" data-toggle="collapse" data-target="#ugel{{ $ugel->idUgel }}">
                            <span class="toggle-icon">+</span>
                            {{-- <div class="group-code">{{ $ugel->code }}</div> --}}
                            <div class="group-title">{{ $ugel->name }}</div>
                            <div class="group-info">
                                <i class="fas fa-graduation-cap mr-2"></i>{{ $ugel->tInstitution->count() }} instituciones
                                <br>
                                <i class="fas fa-map-marker-alt mr-2"></i>{{ $ugel->tProvince->name ?? 'Sin provincia' }} - {{ $ugel->tDistrict->name ?? 'Sin distrito' }}
                                @if($ugel->director)
                                    <br><i class="fas fa-user mr-2"></i>Director: {{ $ugel->director }}
                                @endif
                            </div>
                        </div>
                        
                        <div id="ugel{{ $ugel->idUgel }}" class="collapse">
                            <div class="institution-grid">
                                @foreach ($ugel->tInstitution as $institution)
                                    <div class="institution-card">
                                        <div class="institution-name">I.E. {{ $institution->name }}</div>
                                        <div class="institution-type">{{ $institution->lender }}</div>
                                        <div class="institution-location">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $institution->tDistrict->tProvince->name ?? 'Sin provincia' }} - 
                                            {{ $institution->tDistrict->name ?? 'Sin distrito' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Instituciones sin UGEL -->
            @if(($institutionsSinUgel ?? collect())->count() > 0)
                <div class="group-card">
                    <div class="group-header collapsed" data-toggle="collapse" data-target="#sinUgel" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
                        <span class="toggle-icon">+</span>
                        <div class="group-title">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Sin UGEL Asignada
                        </div>
                        <div class="group-info">
                            <i class="fas fa-graduation-cap mr-2"></i>{{ $institutionsSinUgel->count() }} instituciones
                        </div>
                    </div>
                    
                    <div id="sinUgel" class="collapse">
                        <div class="institution-grid">
                            @foreach ($institutionsSinUgel as $institution)
                                <div class="institution-card" style="border-left: 4px solid #f39c12;">
                                    <div class="institution-name">I.E. {{ $institution->name }}</div>
                                    <div class="institution-type" style="background: linear-gradient(135deg, #f39c12, #e67e22);">{{ $institution->lender }}</div>
                                    <div class="institution-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $institution->tDistrict->tProvince->name ?? 'Sin provincia' }} - 
                                        {{ $institution->tDistrict->name ?? 'Sin distrito' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        @elseif($groupBy == 'district')
            <!-- Agrupado por Distritos -->
            @foreach ($districts ?? [] as $district)
                @if($district->tInstitution->count() > 0)
                    <div class="group-card">
                        <div class="group-header collapsed" data-toggle="collapse" data-target="#district{{ $district->idDistrict }}">
                            <span class="toggle-icon">+</span>
                            <div class="group-title">{{ $district->name }}</div>
                            <div class="group-info">
                                <i class="fas fa-graduation-cap mr-2"></i>{{ $district->tInstitution->count() }} instituciones
                                <br>
                                <i class="fas fa-globe-americas mr-2"></i>Provincia: {{ $district->tProvince->name ?? 'Sin provincia' }}
                            </div>
                        </div>
                        
                        <div id="district{{ $district->idDistrict }}" class="collapse">
                            <div class="institution-grid">
                                @foreach ($district->tInstitution as $institution)
                                    <div class="institution-card">
                                        <div class="institution-name">I.E. {{ $institution->name }}</div>
                                        <div class="institution-type">{{ $institution->lender }}</div>
                                        <div class="institution-location">
                                            <i class="fas fa-school"></i>
                                            UGEL: {{ $institution->tUgel->name ?? 'Sin UGEL' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        @else
            <!-- Agrupado por Provincias -->
            @foreach ($provinces ?? [] as $province)
                @php
                    $totalInstitutions = $province->tDistrict->sum(function($district) {
                        return $district->tInstitution->count();
                    });
                @endphp
                @if($totalInstitutions > 0)
                    <div class="group-card">
                        <div class="group-header collapsed" data-toggle="collapse" data-target="#province{{ $province->idProvince }}">
                            <span class="toggle-icon">+</span>
                            <div class="group-title">{{ $province->name }}</div>
                            <div class="group-info">
                                <i class="fas fa-graduation-cap mr-2"></i>{{ $totalInstitutions }} instituciones
                                <br>
                                <i class="fas fa-map-marker-alt mr-2"></i>{{ $province->tDistrict->count() }} distritos
                            </div>
                        </div>
                        
                        <div id="province{{ $province->idProvince }}" class="collapse">
                            @foreach ($province->tDistrict as $district)
                                @if($district->tInstitution->count() > 0)
                                    <div class="px-4 py-3 bg-light">
                                        <h5 class="font-weight-bold text-secondary mb-3">
                                            <i class="fas fa-map-marker-alt mr-2"></i>{{ $district->name }}
                                            <span class="badge badge-primary ml-2">{{ $district->tInstitution->count() }} instituciones</span>
                                        </h5>
                                        <div class="institution-grid">
                                            @foreach ($district->tInstitution as $institution)
                                                <div class="institution-card">
                                                    <div class="institution-name">I.E. {{ $institution->name }}</div>
                                                    <div class="institution-type">{{ $institution->lender }}</div>
                                                    <div class="institution-location">
                                                        <i class="fas fa-school"></i>
                                                        UGEL: {{ $institution->tUgel->name ?? 'Sin UGEL' }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Leaflet CSS y JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Leaflet Fullscreen Plugin -->
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>

<script>
    function changeGroupBy(type) {
        window.location.href = `{{ route('home.institution') }}?group_by=${type}`;
    }

    // Función para cambiar periodo del mapa
    function changePeriod() {
        const month = document.getElementById('monthSelector').value;
        const year = document.getElementById('yearSelector').value;
        const week = document.getElementById('weekSelector').value;
        const btn = document.getElementById('changePeriodBtn');
        const originalText = btn.innerHTML;

        // Cambiar botón a estado de carga
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
        btn.disabled = true;

        // Recargar página con nuevos parámetros
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('month', month);
        currentUrl.searchParams.set('year', year);
        currentUrl.searchParams.set('week', week);

        window.location.href = currentUrl.toString();
    }
    $(document).ready(function() {
        $('.group-header').on('click', function() {
            $(this).find('.toggle-icon').toggleClass('fa-plus fa-minus');
            $(this).addClass('pulse');
            setTimeout(() => {
                $(this).removeClass('pulse');
                }, 300);
        });

        $('.group-card').each(function(index) {
            $(this).css('animation-delay', (index * 0.1) + 's');
        });

        $('.institution-card').hover(
            function() {
                $(this).addClass('animate__animated animate__pulse');
            },
            function() {
                $(this).removeClass('animate__animated animate__pulse');
            }
        );

        function animateCounter() {
            const counter = $('.counter-number');
            const target = parseInt(counter.text());
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(function() {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                counter.text(Math.floor(current));
            }, 40);
        }

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    animateCounter();
                    observer.unobserve(entry.target);
                }
            });
        });

        observer.observe(document.querySelector('.counter-number'));

        function createWaterParticle() {
            const particle = $('<div class="water-particle"></div>');
            particle.css({
                position: 'fixed',
                width: Math.random() * 6 + 2 + 'px',
                height: Math.random() * 6 + 2 + 'px',
                background: 'rgba(79, 172, 254, 0.6)',
                borderRadius: '50%',
                left: Math.random() * window.innerWidth + 'px',
                top: window.innerHeight + 'px',
                pointerEvents: 'none',
                zIndex: 1
            });

            $('body').append(particle);

            particle.animate({
                top: -10,
                left: '+=' + (Math.random() * 100 - 50)
            }, {
                duration: Math.random() * 3000 + 2000,
                easing: 'linear',
                complete: function() {
                    particle.remove();
                }
            });
        }

        setInterval(createWaterParticle, 500);

        // Mapa de Calor con Leaflet - Público
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
                })
            };

            // Agregar capa base por defecto (OpenStreetMap)
            baseMaps["🗺️ OpenStreetMap"].addTo(map);

            // Agregar control de capas para cambiar tipos de mapa
            L.control.layers(baseMaps).addTo(map);

            // Agregar control de pantalla completa
            map.addControl(new L.Control.Fullscreen({
                title: {
                    'false': 'Ver en pantalla completa',
                    'true': 'Salir de pantalla completa'
                }
            }));

            // Agregar el SVG de Apurímac como overlay (coordenadas originales)
            var apurimacBounds = [[-12.59, -71.85], [-15.41111,-74.16]];
            var apurimacOverlay = L.imageOverlay('{{ asset("img/mapa/mapa.svg") }}', apurimacBounds, {
                opacity: 0.4,
                interactive: false,
                className: 'apurimac-map-overlay'
            }).addTo(map);

            // Obtener datos del mapa desde el endpoint público
            var mapData = [];

            // Cargar datos del mapa desde el endpoint
            fetch('{{ route("api.public.map-data") }}?' + new URLSearchParams({
                month: '{{ $currentMonthNum }}',
                year: '{{ $currentYear }}',
                week: '{{ $currentWeek }}'
            }))
            .then(response => response.json())
            .then(data => {
                mapData = data;
                loadMapMarkers();
            })
            .catch(error => {
                console.error('Error cargando datos del mapa:', error);
                loadMapMarkers(); // Cargar sin datos
            });

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

            // Función para cargar marcadores en el mapa
            function loadMapMarkers() {
                // Agregar marcadores para cada institución
                if (mapData && mapData.length > 0) {
                    mapData.forEach(function(inst) {
                        // Definir z-index y tamaño según el color (grises al fondo y más pequeños)
                        var isGray = inst.color === '#808080';
                        var zIndex = isGray ? 100 : 500;
                        var radius = isGray ? 9 : 12;
                        var opacity = isGray ? 0.7 : 0.9;

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

                        // Agregar efecto de pulsación
                        marker.on('mouseover', function(e) {
                            var hoverRadius = isGray ? 12 : 16;
                            e.target.setStyle({
                                radius: hoverRadius,
                                fillOpacity: 1,
                                weight: isGray ? 3 : 4
                            });
                        });

                        marker.on('mouseout', function(e) {
                            e.target.setStyle({
                                radius: radius,
                                fillOpacity: opacity,
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
                                    <tr><td><b>MCR Semana ${inst.week}:</b></td><td>${inst.weekValue > 0 ? inst.weekValue : 'Sin dato'} ${inst.weekValue > 0 ? 'mg/L' : ''}</td></tr>
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
                }
            }

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
                    interactive: false,
                    zIndexOffset: 1000
                }).addTo(map);
            });
        })();

        // Variable global para el mapa
        var globalMap = null;

        $('.filter-btn').on('mouseenter', function() {
            $(this).css('box-shadow', '0 0 20px rgba(79, 172, 254, 0.5)');
        }).on('mouseleave', function() {
            if (!$(this).hasClass('active')) {
                $(this).css('box-shadow', '');
            }
        });

        $('a[href^="#"]').on('click', function(event) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
            }
        });

        $(window).scroll(function() {
            const scrolled = $(this).scrollTop();
            const parallax = $('.water-header');
            const speed = scrolled * 0.5;
            parallax.css('transform', 'translateY(' + speed + 'px)');
        });

        $('.group-header').on('click', function(e) {
            const ripple = $('<span class="ripple"></span>');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.css({
                position: 'absolute',
                width: size + 'px',
                height: size + 'px',
                left: x + 'px',
                top: y + 'px',
                background: 'rgba(255, 255, 255, 0.3)',
                borderRadius: '50%',
                transform: 'scale(0)',
                animation: 'ripple-animation 0.6s linear',
                pointerEvents: 'none'
            });

            $(this).css('position', 'relative').append(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    $('<style>').prop('type', 'text/css').html(`
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .pulse {
            animation: pulse-effect 0.3s ease-out !important;
        }
        
        @keyframes pulse-effect {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        .water-particle {
            animation: float-up 3s linear forwards;
        }
        
        @keyframes float-up {
            0% {
                opacity: 0;
                transform: translateY(0) rotate(0deg);
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateY(-100vh) rotate(360deg);
            }
        }
    `).appendTo('head');
</script>

@include('home/layout/footer')