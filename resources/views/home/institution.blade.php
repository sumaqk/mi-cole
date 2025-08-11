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

<script>
    function changeGroupBy(type) {
        window.location.href = `{{ route('home.institution') }}?group_by=${type}`;
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