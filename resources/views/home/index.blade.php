@include('home/layout/header')

@if ($modal)
    @include('home.modal')
@endif
<!-- Header Start -->
@section('cssSection')
@endsection

<style>
    /* SLIDER CON EFECTOS DE AGUA */
    #waterFlowSlider {
        position: absolute;
        width: 100%;
        height: 80vh;
        z-index: -1;
        overflow: hidden;
        background: linear-gradient(135deg, #0a4b8a, #1e90ff);
    }

    .slider-container {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: all 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        transform: scale(1.1);
    }

    .slide.active {
        opacity: 1;
        transform: scale(1);
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: brightness(0.8) contrast(1.1);
    }

    .water-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg,
                rgba(8, 141, 182, 0.1) 0%,
                rgba(9, 64, 122, 0.2) 50%,
                rgba(8, 141, 182, 0.1) 100% mix-blend-mode: overlay;
        }

        .water-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.8), transparent);
            border-radius: 50%;
            animation: float 8s infinite ease-in-out;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-20px) rotate(360deg);
                opacity: 0;
            }
        }

        .water-waves {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1000 100'%3E%3Cpath d='M0,50 Q250,0 500,50 T1000,50 L1000,100 L0,100 Z' fill='rgba(8,141,182,0.4)'/%3E%3C/svg%3E");
            background-size: 1000px 100px;
            animation: wave 6s ease-in-out infinite;
        }

        @keyframes wave {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(-50px);
            }
        }

        .liquid-transition {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(8, 141, 182, 0.9), transparent);
            transform: translateX(-100%) skewX(-20deg);
            opacity: 0;
            pointer-events: none;
        }

        .liquid-transition.flowing {
            animation: liquidFlow 1.5s ease-out forwards;
        }

        @keyframes liquidFlow {
            0% {
                transform: translateX(-100%) skewX(-20deg);
                opacity: 0;
            }

            50% {
                opacity: 1;
                transform: translateX(0%) skewX(-10deg);
            }

            100% {
                transform: translateX(100%) skewX(0deg);
                opacity: 0;
            }
        }

        .slider-controls {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
            z-index: 1000;
        }

        .control-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid rgba(8, 141, 182, 0.8);
        }

        .control-dot.active {
            background: rgba(8, 141, 182, 1);
            transform: scale(1.3);
            box-shadow: 0 0 15px rgba(8, 141, 182, 0.8);
        }

        .nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background: rgba(8, 141, 182, 0.8);
            border: none;
            border-radius: 50%;
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-arrow:hover {
            background: rgba(8, 141, 182, 1);
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 0 20px rgba(8, 141, 182, 0.8);
        }

        .nav-arrow.prev {
            left: 20px;
        }

        .nav-arrow.next {
            right: 20px;
        }

        /* ANIMACIONES PARA LAS TARJETAS */
        .animated-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 20px !important;
            overflow: hidden;
            position: relative;
            background: linear-gradient(145deg, #ffffff, #f0f8ff);
            box-shadow: 0 8px 32px rgba(8, 141, 182, 0.1);
        }

        .animated-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(8, 141, 182, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .animated-card:hover::before {
            left: 100%;
        }

        .animated-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(8, 141, 182, 0.25);
        }

        .card-icon {
            transition: all 0.3s ease;
            color: #088db6 !important;
        }

        .animated-card:hover .card-icon {
            transform: scale(1.2) rotate(5deg);
            color: #0a4b8a !important;
        }

        /* EFECTOS PARA FASCÍCULOS */
        .fasciculo-card {
            transition: all 0.4s ease;
            border-radius: 25px !important;
            overflow: hidden;
            position: relative;
            background: linear-gradient(145deg, #ffffff, #f8fbff);
            border: none !important;
        }

        .fasciculo-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(8, 141, 182, 0.1), rgba(9, 64, 122, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .fasciculo-card:hover::after {
            opacity: 1;
        }

        .fasciculo-card:hover {
            transform: translateY(-15px) rotateY(5deg);
            box-shadow: 0 25px 80px rgba(8, 141, 182, 0.3);
        }

        .fasciculo-card img {
            transition: transform 0.5s ease;
        }

        .fasciculo-card:hover img {
            transform: scale(1.1);
        }

        .fasciculo-btn {
            position: relative;
            overflow: hidden;
            border-radius: 25px !important;
            background: linear-gradient(45deg, #088db6, #0a4b8a) !important;
            border: none !important;
            transition: all 0.3s ease;
        }

        .fasciculo-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .fasciculo-btn:hover::before {
            left: 100%;
        }

        .fasciculo-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(8, 141, 182, 0.4);
        }

        /* EFECTOS PARA MATERIALES */
        .material-item {
            transition: all 0.4s ease;
            position: relative;
        }

        .material-circle {
            position: relative;
            transition: all 0.4s ease;
            background: linear-gradient(145deg, #ffffff, #f0f8ff);
            border: 3px solid transparent;
            background-clip: padding-box;
        }

        .material-circle::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            background: linear-gradient(45deg, #088db6, #0a4b8a, #1e90ff);
            border-radius: inherit;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .material-item:hover .material-circle::before {
            opacity: 1;
        }

        .material-item:hover .material-circle {
            transform: scale(1.1) rotate(5deg);
        }

        .material-item:hover {
            transform: translateY(-10px);
        }

        .material-overlay {
            background: linear-gradient(135deg, rgba(8, 141, 182, 0.9), rgba(9, 64, 122, 0.8)) !important;
            transition: all 0.3s ease;
        }

        .material-item:hover .material-overlay {
            background: linear-gradient(135deg, rgba(8, 141, 182, 0.95), rgba(9, 64, 122, 0.9)) !important;
        }

        /* EFECTOS PARA MIEMBROS */
        .member-card {
            transition: all 0.4s ease;
            border-radius: 20px !important;
            position: relative;
            overflow: hidden;
        }

        .member-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(8, 141, 182, 0.1), rgba(9, 64, 122, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .member-card:hover::before {
            opacity: 1;
        }

        .member-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 40px rgba(8, 141, 182, 0.2);
        }

        .member-logo {
            transition: all 0.3s ease;
            filter: grayscale(0.3);
        }

        .member-card:hover .member-logo {
            filter: grayscale(0) brightness(1.1);
            transform: scale(1.05);
        }

        /* ANIMACIONES DE ENTRADA */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stagger-animation {
            animation-delay: calc(var(--delay) * 0.1s);
        }

        /* TÍTULOS ANIMADOS */
        .animated-title {
            position: relative;
            display: inline-block;
        }

        .animated-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(45deg, #088db6, #0a4b8a);
            transition: all 0.5s ease;
            transform: translateX(-50%);
        }

        .animated-title:hover::after {
            width: 100%;
        }

        /* EFECTOS GLOBALES */
        .section-modern {
            position: relative;
            overflow: hidden;
        }

        .section-modern::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(8, 141, 182, 0.03) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            pointer-events: none;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .nav-arrow {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .control-dot {
                width: 10px;
                height: 10px;
            }

            .animated-card:hover {
                transform: translateY(-5px) scale(1.01);
            }

            .fasciculo-card:hover {
                transform: translateY(-10px);
            }
        }


        .btn-hover-effect:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 15px 35px rgba(8, 141, 182, 0.6);
            background: linear-gradient(45deg, #0a4b8a, #088db6) !important;
        }
</style>

<!-- Slider con Efecto de Flujo de Agua -->
<div id="waterFlowSlider">
    <div class="slider-container">
        <div class="slide active">
            <img src="{{ asset('home/img/galeria/3.jpg') }}" alt="Imagen 1">
            <div class="water-overlay"></div>
        </div>
        <div class="slide">
            <img src="{{ asset('home/img/galeria/5.jpg') }}" alt="Imagen 2">
            <div class="water-overlay"></div>
        </div>
        <div class="slide">
            <img src="{{ asset('home/img/galeria/12.jpg') }}" alt="Imagen 3">
            <div class="water-overlay"></div>
        </div>
        <div class="slide">
            <img src="{{ asset('home/img/galeria/13.jpg') }}" alt="Imagen 4">
            <div class="water-overlay"></div>
        </div>

        <div class="water-particles" id="waterParticles"></div>
        <div class="water-waves"></div>
        <div class="liquid-transition" id="liquidTransition"></div>
    </div>

    <div class="slider-controls" id="sliderControls">
        <div class="control-dot active" data-slide="0"></div>
        <div class="control-dot" data-slide="1"></div>
        <div class="control-dot" data-slide="2"></div>
        <div class="control-dot" data-slide="3"></div>
    </div>

    <button class="nav-arrow prev" id="prevBtn">‹</button>
    <button class="nav-arrow next" id="nextBtn">›</button>
</div>

<!-- Contenedor del contenido superpuesto -->
<div class="position-relative text-center px-0 px-md-5 mb-5"
    style="background: linear-gradient(to right, rgba(9, 64, 122, 0.6), rgba(255, 255, 255, 0)); padding-top: 320px; height: 80vh; display: flex; align-items: center;
 z-index: 5;">
    <div class="row align-items-center px-3">
        <div class="col-lg-2 text-center">
            <img class="img-fluid fade-in-up" style="width: 10rem;" src="{{ asset('home/img/logo_gore2.png') }}"
                alt="Logo">
            <h3 class="text-white mb-4 mt-3 mt-lg-0 fade-in-up" style="animation-delay: 0.2s; text-center">Estrategia
                Regional</h3>
        </div>
        <div class="col-lg-7 text-left">
            <h1 class="display-4 font-weight-bold text-white fade-in-up" style="animation-delay: 0.4s;">Mi Cole con Agua
                Segura</h1>
            <p class="text-white mb-4 d-none d-md-block fade-in-up" style="animation-delay: 0.6s;">Este es un espacio
                donde los estudiantes pueden aprender a
                medir el cloro en el agua de sus escuelas. Con este sistema,
                podrás hacer tus propias verificaciones y descubrir información divertida y útil sobre el agua.
                ¡Conviértete en un experto y cuida de tu entorno mientras te diviertes!</p>
            <a href="{{ route('home.about') }}" class="btn btn-secondary mt-1 py-3 px-5 fade-in-up btn-hover-effect"
                style="background: linear-gradient(45deg, #088db6, #0a4b8a) !important;border: none;border-radius: 30px;1px;padding: 15px 40px;font-weight: 600;box-shadow: 0 8px 25px rgba(8, 141, 182, 0.4);transition: all 0.3s ease;animation-delay: 0.8s;">Conocer
                más</a>
        </div>
    </div>
</div>

<!-- Sección Principal - Rediseñada -->
<div class="container-fluid pt-5 section-modern">
    <div class="container pb-3">
        <div class="text-center pb-4">
            <h2 class="animated-title mb-4" style="color: #0a4b8a; font-weight: bold;">Explora Nuestro Contenido</h2>
            <p style="color: #666; font-size: 1.1rem;">Descubre información fascinante sobre el agua y su importancia
            </p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 pb-1 fade-in-up" style="--delay: 1;">
                <a href="{{ route('home.content') }}" style="text-decoration: none; color: inherit;">
                    <div class="animated-card" style="padding: 30px;">
                        <i class="flaticon-025-sandwich h1 font-weight-normal card-icon mb-3"></i>
                        <div class="pl-4">
                            <h4 style="color: #0a4b8a; font-weight: bold;">Tensiones en Torno al Agua</h4>
                            <p class="m-0" style="color: #666;">Aquí te contaremos, de manera clara y sencilla, sobre
                                las
                                tensiones que suelen presentarse en la sociedad en relación con el agua.
                            <ul style="color: #666;">
                                <li>1. Desperdicio.</li>
                                <li>2. La contaminación.</li>
                                <li>3. El cambio climático.</li>
                            </ul>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 pb-1 fade-in-up" style="--delay: 2;">
                <a href="{{ route('home.content') }}" style="text-decoration: none; color: inherit;">
                    <div class="animated-card" style="padding: 30px;">
                        <i class="flaticon-022-drum h1 font-weight-normal card-icon mb-3"></i>
                        <div class="pl-4">
                            <h4 style="color: #0a4b8a; font-weight: bold;">El Agua para Consumo Humano</h4>
                            <p class="m-0" style="color: #666;">Aquí te contaremos, de manera clara y sencilla, sobre
                                el agua para consumo humano.
                            <ul style="color: #666;">
                                <li>1. El agua potable.</li>
                                <li>2. El alcantarillado sanitario.</li>
                                <li>3. El tratamiento de las aguas residuales.</li>
                            </ul>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 pb-1 fade-in-up" style="--delay: 3;">
                <a href="{{ route('home.content') }}" style="text-decoration: none; color: inherit;">
                    <div class="animated-card" style="padding: 30px;">
                        <i class="flaticon-030-crayons h1 font-weight-normal card-icon mb-3"></i>
                        <div class="pl-4">
                            <h4 style="color: #0a4b8a; font-weight: bold;">Otros Usos del Agua</h4>
                            <p class="m-0" style="color: #666;">Aquí te contaremos, de manera clara y sencilla, sobre
                                los otros usos que tiene el agua.
                            <ul style="color: #666;">
                                <li>1. El agua para la producción de alimentos.</li>
                                <li>2. El agua para la generación de energía.</li>
                                <li>3. El agua para la recreación.</li>
                            </ul>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 pb-1 fade-in-up" style="--delay: 4;">
                <a href="{{ route('home.content') }}" style="text-decoration: none; color: inherit;">
                    <div class="animated-card" style="padding: 30px;">
                        <i class="flaticon-017-toy-car h1 font-weight-normal card-icon mb-3"></i>
                        <div class="pl-4">
                            <h4 style="color: #0a4b8a; font-weight: bold;">Garantizando la Calidad del Agua</h4>
                            <p class="m-0" style="color: #666;">Aquí te contaremos, de manera clara y sencilla,
                                sobre
                                la forma en que podemos garantizar el acceso seguro y sostenible
                                a un agua de calidad.
                            <ul style="color: #666;">
                                <li>1. Calidad y sostenibilidad de los sistemas.</li>
                                <li>2. Entidades encargadas del servicio.</li>
                                <li>3. Importancia de la tarifa de agua.</li>
                            </ul>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 pb-1 fade-in-up" style="--delay: 5;">
                <a href="{{ route('home.content') }}" style="text-decoration: none; color: inherit;">
                    <div class="animated-card" style="padding: 30px;">
                        <i class="flaticon-047-backpack h1 font-weight-normal card-icon mb-3"></i>
                        <div class="pl-4">
                            <h4 style="color: #0a4b8a; font-weight: bold;">El Uso Responsable del Agua</h4>
                            <p class="m-0" style="color: #666;">Aquí te contaremos, de manera clara y sencilla,
                                sobre
                                la forma en que debemos tener un uso responsable del agua.
                            <ul style="color: #666;">
                                <li>1. El ahorro y cuidado del agua.</li>
                                <li>2. Deberes y derechos de los usuarios de agua.</li>
                                <li>3. Aprendiendo a criar nuestra agua.</li>
                            </ul>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 pb-1 fade-in-up" style="--delay: 6;">
                <a href="{{ route('home.content') }}" style="text-decoration: none; color: inherit;">
                    <div class="animated-card" style="padding: 30px;">
                        <i class="flaticon-050-fence h1 font-weight-normal card-icon"></i>
                        <div class="pl-4">
                            <h4 style="color: #0a4b8a; font-weight: bold;">Importancia del Agua</h4>
                            <p class="m-0" style="color: #666;">Aquí te contaremos, de manera clara y sencilla,
                                sobre qué tan
                                importante es el agua para el mundo y cada uno de nosotros.</p>
                            <ul style="color: #666;">
                                <li>1. El agua en el Planeta</li>
                                <li>2. El ciclo del agua</li>
                                <li>3. Su importancia para la infancia</li>
                            </ul>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Fascículos - Rediseñados -->
<div class="container-fluid pt-5 section-modern"
    style="background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);">
    <div class="container">
        <div class="text-center pb-4">
            <p class="section-title px-5" style="color: #088db6; font-size: 1.2rem; font-weight: 600;"><span
                    class="px-2">Más Contenido</span></p>
            <h1 class="mb-4 animated-title" style="color: #0a4b8a; font-weight: bold;">Fascículos</h1>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-5 fade-in-up" style="--delay: 1;">
                <div class="fasciculo-card shadow-sm pb-2">
                    <img class="card-img-top mb-2" src="{{ asset('home/img/fasiculos/f1.png') }}" alt="">
                    <div class="card-body text-center">
                        <h4 class="card-title" style="color: #0a4b8a; font-weight: bold;">Importancia del Agua</h4>
                        <p class="card-text" style="color: #666;">Debes saber, que nuestro sistema solar está
                            compuesto por 8
                            planetas, de los cuales solo la tierra tiene abundante agua en
                            estado líquido. Y eso es lo que ha permitido que aquí, nazca y
                            florezca la vida.</p>
                    </div>
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-1.pdf') }}"
                        class="fasciculo-btn btn px-4 mx-auto mb-4 d-block" style="max-width: 200px;"
                        target="_blank">Ver Más</a>
                </div>
            </div>
            <div class="col-lg-4 mb-5 fade-in-up" style="--delay: 2;">
                <div class="fasciculo-card shadow-sm pb-2">
                    <img class="card-img-top mb-2" src="{{ asset('home/img/fasiculos/f2.png') }}" alt="">
                    <div class="card-body text-center">
                        <h4 class="card-title" style="color: #0a4b8a; font-weight: bold;">El Agua para Consumo Humano
                        </h4>
                        <p class="card-text" style="color: #666;">Debemos empezar aclarando que para tener agua
                            potable y evitar
                            la contaminación del medio ambiente, en la actualidad contamos
                            con un sistema grande que llamamos servicios de saneamiento.</p>
                    </div>
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-2.pdf') }}"
                        class="fasciculo-btn btn px-4 mx-auto mb-4 d-block" style="max-width: 200px;"
                        target="_blank">Ver Más</a>
                </div>
            </div>
            <div class="col-lg-4 mb-5 fade-in-up" style="--delay: 3;">
                <div class="fasciculo-card shadow-sm pb-2">
                    <img class="card-img-top mb-2" src="{{ asset('home/img/fasiculos/f3.png') }}" alt="">
                    <div class="card-body text-center">
                        <h4 class="card-title" style="color: #0a4b8a; font-weight: bold;">Otros Usos del Agua</h4>
                        <p class="card-text" style="color: #666;">Además del agua para consumo humano, existen otros
                            usos del
                            agua. Y la actividad que más agua consume en nuestro país, es la
                            del riego de los cultivos para la producción de alimentos.</p>
                    </div>
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-3.pdf') }}"
                        class="fasciculo-btn btn px-4 mx-auto mb-4 d-block" style="max-width: 200px;"
                        target="_blank">Ver Más</a>
                </div>
            </div>
            <div class="col-lg-4 mb-5 fade-in-up" style="--delay: 4;">
                <div class="fasciculo-card shadow-sm pb-2">
                    <img class="card-img-top mb-2" src="{{ asset('home/img/fasiculos/f4.png') }}" alt="">
                    <div class="card-body text-center">
                        <h4 class="card-title" style="color: #0a4b8a; font-weight: bold;">Garantizando la Calidad del
                            Agua</h4>
                        <p class="card-text" style="color: #666;">Ahora que ya sabes lo complejo que es mantener
                            limpia el agua
                            para consumo humano, y todos los servicios de saneamiento,
                            debes saber que en nuestro país, y sobre todo en nuestra región
                            Apurímac, dichos sistemas están en proceso de deterioro.</p>
                    </div>
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-4.pdf') }}"
                        class="fasciculo-btn btn px-4 mx-auto mb-4 d-block" style="max-width: 200px;"
                        target="_blank">Ver Más</a>
                </div>
            </div>
            <div class="col-lg-4 mb-5 fade-in-up" style="--delay: 5;">
                <div class="fasciculo-card shadow-sm pb-2">
                    <img class="card-img-top mb-2" src="{{ asset('home/img/fasiculos/f5.png') }}" alt="">
                    <div class="card-body text-center">
                        <h4 class="card-title" style="color: #0a4b8a; font-weight: bold;">Tensiones en Torno al Agua
                        </h4>
                        <p class="card-text" style="color: #666;">Antes de empezar, trata de calcular cuántos litros
                            de agua
                            consumes tú diariamente. Piensa en las distintas actividades que
                            realizas desde que te levantas hasta que te vas a dormir. ¿Pudiste
                            sacar un cálculo?</p>
                    </div>
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-5.pdf') }}"
                        class="fasciculo-btn btn px-4 mx-auto mb-4 d-block" style="max-width: 200px;"
                        target="_blank">Ver Más</a>
                </div>
            </div>
            <div class="col-lg-4 mb-5 fade-in-up" style="--delay: 6;">
                <div class="fasciculo-card shadow-sm pb-2">
                    <img class="card-img-top mb-2" src="{{ asset('home/img/fasiculos/f6.png') }}" alt="">
                    <div class="card-body text-center">
                        <h4 class="card-title" style="color: #0a4b8a; font-weight: bold;">El Uso Responsable del Agua
                        </h4>
                        <p class="card-text" style="color: #666;">Hace unos años, se declaró el 22 de marzo como Día
                            Mundial del
                            Agua. Esa fecha conmemorativa tiene el objetivo de recordar a todas
                            las personas la gran importancia que tiene el agua en nuestras
                            vidas y en general para todo el planeta.</p>
                    </div>
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-6.pdf') }}"
                        class="fasciculo-btn btn px-4 mx-auto mb-4 d-block" style="max-width: 200px;"
                        target="_blank">Ver Más</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Materiales - Rediseñados -->
<div class="container-fluid pt-5 section-modern" id="materiales">
    <div class="container">
        <div class="text-center pb-4">
            <p class="section-title px-5" style="color: #088db6; font-size: 1.2rem; font-weight: 600;"><span
                    class="px-2">Extras</span></p>
            <h1 class="mb-4 animated-title" style="color: #0a4b8a; font-weight: bold;">Materiales</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 1;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100"
                        src="{{ asset('home/img/guia-docente.png') }}" alt="">
                    <div
                        class="material-overlay team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ asset('home/material agua/ANEXOS/guia-docente.pdf') }}" target="_blank"><i
                                class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">Cuidando la Vida</h4>
                <i style="color: #666;">Guía para Docentes</i>
            </div>
            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 2;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100" src="{{ asset('home/img/videos.jpg') }}"
                        alt="">
                    <div
                        class="material-overlay team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ route('home.gallery') }}"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">Videos</h4>
                <i style="color: #666;"></i>
            </div>
            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 3;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100" src="{{ asset('home/img/cuento.png') }}"
                        alt="">
                    <div
                        class="material-overlay team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ asset('home/material agua/ANEXOS/cuento-agua.pdf') }}" target="_blank"><i
                                class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">El Agua en Peligro</h4>
                <i style="color: #666;">Cuento</i>
            </div>
            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 4;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100" src="{{ asset('home/img/album.jpg') }}"
                        alt="">
                    <div
                        class="material-overlay team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ route('home.gallery') }}"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">Aprendiendo a Valorar y Criar Nuestra Agua</h4>
                <i style="color: #666;">Álbum Interactivo</i>
            </div>

            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 5;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100"
                        src="{{ asset('home/material agua/ANEXOS/rojer.png') }}" alt="">
                    <div
                        class="material-overlay team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ asset('home/material agua/ANEXOS/Roger y la Magia del Agua.pdf') }}"
                            target="_blank"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">Roger y la magia del agua</h4>
                <i style="color: #666;">Cuento</i>
            </div>
            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 6;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100"
                        src="{{ asset('home/material agua/ANEXOS/micole.png') }}" alt="">
                    <div
                        class="material-overlay team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ asset('home/material agua/ANEXOS/Mi Cole Con Agua Segura.pdf') }}"
                            target="_blank"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">Mi cole con Agua Segura</h4>
                <i style="color: #666;">Estrategia</i>
            </div>
            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 7;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100"
                        src="{{ asset('home/material agua/ANEXOS/guardianes.png') }}" alt="">
                    <div
                        class="material-overlay team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ asset('home/material agua/ANEXOS/Los Guardianes del Agua.pdf') }}"
                            target="_blank"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">Los Guardianes del Agua</h4>
                <i style="color: #666;">Cuento</i>
            </div>
        </div>
    </div>
</div>

<!-- Miembros - Rediseñados -->
<div class="container-fluid pt-5 section-modern"
    style="background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);">
    <div class="container">
        <div class="text-center pb-4">
            <p class="section-title px-5" style="color: #088db6; font-size: 1.2rem; font-weight: 600;"><span
                    class="px-2">Más</span></p>
            <h1 class="mb-4 animated-title" style="color: #0a4b8a; font-weight: bold;">Nuestros Miembros</h1>
        </div>
        <div class="row text-center mb-4">
            <a href="https://www.gob.pe/regionapurimac" class="col-md-6 col-lg-3 mb-4 fade-in-up"
                style="--delay: 1; text-decoration: none;">
                <div
                    class="member-card bg-light shadow-sm rounded p-3 d-flex flex-column justify-content-center h-100">
                    <img class="member-logo img-fluid mx-auto mb-3" src="{{ asset('home/img/logo_gore.png') }}"
                        style="height: 120px; width: auto;" alt="Image">
                    <h5 style="color: #0a4b8a; font-weight: bold;">Gobierno Regional de Apurímac</h5>
                </div>
            </a>

            <a href="https://www.diresaapurimac.gob.pe/web/" class="col-md-6 col-lg-3 mb-4 fade-in-up"
                style="--delay: 2; text-decoration: none;">
                <div
                    class="member-card bg-light shadow-sm rounded p-3 d-flex flex-column justify-content-center h-100">
                    <img class="member-logo img-fluid mx-auto mb-3" src="{{ asset('home/img/logo salud.png') }}"
                        style="height: 120px; width: auto;" alt="Image">
                    <h5 style="color: #0a4b8a; font-weight: bold;">DIRESA Apurímac</h5>
                </div>
            </a>

            <a href="https://www.gob.pe/sunass" class="col-md-6 col-lg-3 mb-4 fade-in-up"
                style="--delay: 3; text-decoration: none;">
                <div
                    class="member-card bg-light shadow-sm rounded p-3 d-flex flex-column justify-content-center h-100">
                    <img class="member-logo img-fluid mx-auto mb-3" src="{{ asset('home/img/logo sunas2.jpg') }}"
                        style="height: 120px; width: auto;" alt="Image">
                    <h5 style="color: #0a4b8a; font-weight: bold;">SUNASS</h5>
                </div>
            </a>

            <a href="https://www.gob.pe/regionapurimac-dre" class="col-md-6 col-lg-3 mb-4 fade-in-up"
                style="--delay: 4; text-decoration: none;">
                <div
                    class="member-card bg-light shadow-sm rounded p-3 d-flex flex-column justify-content-center h-100">
                    <img class="member-logo img-fluid mx-auto mb-3" src="{{ asset('home/img/drea-apurimac.png') }}"
                        style="height: 120px; width: auto;" alt="Image">
                    <h5 style="color: #0a4b8a; font-weight: bold;">DRE Apurímac</h5>
                </div>
            </a>
        </div>

        <div class="row text-center mb-4">
            <a href="https://drvcs.regionapurimac.gob.pe/" class="col-md-6 col-lg-4 mb-4 fade-in-up"
                style="--delay: 5; text-decoration: none;">
                <div
                    class="member-card bg-light shadow-sm rounded p-3 d-flex flex-column justify-content-center h-100">
                    <img class="member-logo img-fluid mx-auto mb-3" src="{{ asset('home/img/logo_vivienda.jpg') }}"
                        style="height: 120px; width: auto;" alt="Image">
                    <h5 style="color: #0a4b8a; font-weight: bold;">Dirección Regional de Vivienda y Saneamiento</h5>
                </div>
            </a>

            <a href="https://www.midis.gob.pe/fed/sobre-el-fed/el-fed" class="col-md-6 col-lg-4 mb-4 fade-in-up"
                style="--delay: 6; text-decoration: none;">
                <div
                    class="member-card bg-light shadow-sm rounded p-3 d-flex flex-column justify-content-center h-100">
                    <img class="member-logo img-fluid mx-auto mb-3" src="{{ asset('home/img/FED.jpg') }}"
                        style="height: 120px; width: auto;" alt="Image">
                    <h5 style="color: #0a4b8a; font-weight: bold;">Fondo de Estímulo al Desempeño y Logro de Resultados
                        Sociales</h5>
                </div>
            </a>

            <a href="https://emusapabancay.com.pe/" class="col-md-6 col-lg-4 mb-4 fade-in-up"
                style="--delay: 7; text-decoration: none;">
                <div
                    class="member-card bg-light shadow-sm rounded p-3 d-flex flex-column justify-content-center h-100">
                    <img class="member-logo img-fluid mx-auto mb-3" src="{{ asset('home/img/emusap2.jpg') }}"
                        style="height: 120px; width: auto;" alt="Image">
                    <h5 style="color: #0a4b8a; font-weight: bold;">EMUSAP Abancay</h5>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    class WaterFlowSlider {
        constructor() {
            this.slides = document.querySelectorAll('.slide');
            this.dots = document.querySelectorAll('.control-dot');
            this.prevBtn = document.getElementById('prevBtn');
            this.nextBtn = document.getElementById('nextBtn');
            this.liquidTransition = document.getElementById('liquidTransition');
            this.currentSlide = 0;
            this.isTransitioning = false;
            this.autoPlayInterval = null;

            this.init();
        }

        init() {
            this.createWaterParticles();
            this.addEventListeners();
            this.startAutoPlay();
            this.initScrollAnimations();
        }

        createWaterParticles() {
            const particlesContainer = document.getElementById('waterParticles');
            const particleCount = 15;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';

                const size = Math.random() * 6 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 8 + 's';
                particle.style.animationDuration = (Math.random() * 4 + 6) + 's';

                particlesContainer.appendChild(particle);
            }
        }

        addEventListeners() {
            this.dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    if (!this.isTransitioning) {
                        this.goToSlide(index);
                    }
                });
            });

            this.prevBtn.addEventListener('click', () => {
                if (!this.isTransitioning) {
                    this.prevSlide();
                }
            });

            this.nextBtn.addEventListener('click', () => {
                if (!this.isTransitioning) {
                    this.nextSlide();
                }
            });

            const slider = document.getElementById('waterFlowSlider');
            slider.addEventListener('mouseenter', () => {
                this.stopAutoPlay();
            });

            slider.addEventListener('mouseleave', () => {
                this.startAutoPlay();
            });
        }

        goToSlide(slideIndex) {
            if (slideIndex === this.currentSlide || this.isTransitioning) return;

            this.isTransitioning = true;
            this.triggerLiquidTransition();

            this.slides[this.currentSlide].classList.remove('active');
            this.slides[slideIndex].classList.add('active');

            this.dots[this.currentSlide].classList.remove('active');
            this.dots[slideIndex].classList.add('active');

            this.currentSlide = slideIndex;

            setTimeout(() => {
                this.isTransitioning = false;
            }, 1500);
        }

        nextSlide() {
            const nextIndex = (this.currentSlide + 1) % this.slides.length;
            this.goToSlide(nextIndex);
        }

        prevSlide() {
            const prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
            this.goToSlide(prevIndex);
        }

        triggerLiquidTransition() {
            this.liquidTransition.classList.add('flowing');

            setTimeout(() => {
                this.liquidTransition.classList.remove('flowing');
            }, 1500);
        }

        startAutoPlay() {
            this.autoPlayInterval = setInterval(() => {
                if (!this.isTransitioning) {
                    this.nextSlide();
                }
            }, 5000);
        }

        stopAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        }

        initScrollAnimations() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-in-up').forEach(el => {
                observer.observe(el);
                el.style.animationPlayState = 'paused';
            });
        }
    }

    // Inicializar cuando se carga la página
    document.addEventListener('DOMContentLoaded', () => {
        new WaterFlowSlider();
    });
</script>

@include('home/layout/footer')
