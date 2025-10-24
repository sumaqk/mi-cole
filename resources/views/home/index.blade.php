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
        height: 95vh;
        z-index: -1;
        overflow: hidden;
        background: linear-gradient(135deg, #0a4b8a, #1e90ff);
        max-width: 100vw;
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
                rgba(8, 141, 182, 0.1) 100%);
        mix-blend-mode: overlay;
    }

    .water-particles {
        position: absolute;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }

    .elegant-container {
        width: 100%;
        margin: 15px auto;
        background: linear-gradient(90deg, rgba(79, 172, 254, 0.4), rgba(0, 242, 254, 0.4));
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        padding: 15px;
        animation: fadeIn 0.5s ease-in-out;
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
        height: 70px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1000 100'%3E%3Cpath d='M0,50 Q250,0 500,50 T1000,50 L1000,100 L0,100 Z' fill='rgba(8,141,182,0.4)'/%3E%3C/svg%3E");
        background-size: 400px 100px;
        animation: wave 6s ease-in-out infinite;
        overflow: hidden;
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
        z-index: 9999 !important;
        pointer-events: auto !important;
    }

    .control-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid rgba(8, 141, 182, 0.8);
        pointer-events: auto !important;
        z-index: 10000 !important;
        position: relative;
        outline: none;
    }

    .control-dot:focus {
        outline: none;
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
        z-index: 9999 !important;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: auto !important;
        outline: none;
    }

    .nav-arrow:hover {
        background: rgba(8, 141, 182, 1);
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 0 20px rgba(8, 141, 182, 0.8);
    }

    .nav-arrow:focus {
        outline: none;
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
        pointer-events: none;
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
        border-radius: 30px !important;
        background: linear-gradient(135deg, #088db6, #0a4b8a) !important;
        border: none !important;
        transition: all 0.3s ease;
        color: #ffffff !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        padding: 12px 35px !important;
        text-decoration: none !important;
        box-shadow: 0 4px 15px rgba(8, 141, 182, 0.3);
        letter-spacing: 0.5px;
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
        pointer-events: none;
    }

    .fasciculo-btn:hover::before {
        left: 100%;
    }

    .fasciculo-btn:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 12px 35px rgba(8, 141, 182, 0.5);
        background: linear-gradient(135deg, #0a4b8a, #1e90ff) !important;
        color: #ffffff !important;
    }

    .fasciculo-btn:active {
        transform: translateY(-2px) scale(1.02);
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

    .material-overlay {
        pointer-events: none;
    }

    .material-overlay a {
        pointer-events: auto;
        cursor: pointer;
    }

    /* CARRUSEL 3D INTERACTIVO */
    .carousel-3d-wrapper {
        position: relative;
        width: 100%;
        min-height: 600px;
        margin: 20px 0 50px 0;
        overflow: visible;
    }

    .carousel-3d-container {
        position: relative;
        width: 100%;
        height: 550px;
        perspective: 2000px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .carousel-3d-card {
        position: absolute;
        width: 380px;
        min-height: 450px;
        background: linear-gradient(145deg, #ffffff, #f8fbff);
        border-radius: 25px;
        box-shadow: 0 20px 60px rgba(8, 141, 182, 0.2);
        transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        cursor: pointer;
        transform-style: preserve-3d;
        backface-visibility: hidden;
        overflow: hidden;
    }

    .carousel-3d-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(8, 141, 182, 0.05), rgba(9, 64, 122, 0.05));
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
        z-index: 1;
    }

    .carousel-3d-card:hover::before {
        opacity: 1;
    }

    /* Efecto de brillo en hover */
    .carousel-3d-card::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: rotate(45deg);
        transition: all 0.6s ease;
        pointer-events: none;
        z-index: 2;
    }

    .carousel-3d-card:hover::after {
        left: 100%;
    }

    .card-link {
        display: block;
        text-decoration: none;
        color: inherit;
        width: 100%;
        height: 100%;
        position: relative;
        z-index: 3;
    }

    .card-content {
        padding: 40px 30px;
        position: relative;
        z-index: 4;
    }

    .card-icon-3d {
        font-size: 3.5rem;
        color: #088db6;
        margin-bottom: 20px;
        transition: all 0.3s ease;
        display: block;
    }

    .carousel-3d-card:hover .card-icon-3d {
        transform: scale(1.15) rotate(5deg);
        color: #0a4b8a;
    }

    .card-title-3d {
        color: #0a4b8a;
        font-weight: bold;
        font-size: 1.4rem;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .carousel-3d-card:hover .card-title-3d {
        color: #088db6;
    }

    .card-text-3d {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .card-list-3d {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .card-list-3d li {
        color: #666;
        font-size: 0.9rem;
        padding: 5px 0;
        padding-left: 20px;
        position: relative;
    }

    .card-list-3d li::before {
        content: '●';
        color: #088db6;
        position: absolute;
        left: 0;
    }

    /* Posiciones del carrusel */
    .carousel-3d-card[data-position="center"] {
        z-index: 100;
        transform: translateX(0) translateZ(0) scale(1.1);
        opacity: 1;
        box-shadow: 0 25px 80px rgba(8, 141, 182, 0.35);
        pointer-events: auto;
    }

    .carousel-3d-card[data-position="left-1"] {
        z-index: 80;
        transform: translateX(-420px) translateZ(-200px) scale(0.85);
        opacity: 0.7;
        pointer-events: auto;
    }

    .carousel-3d-card[data-position="right-1"] {
        z-index: 80;
        transform: translateX(420px) translateZ(-200px) scale(0.85);
        opacity: 0.7;
        pointer-events: auto;
    }

    .carousel-3d-card[data-position="left-2"] {
        z-index: 60;
        transform: translateX(-750px) translateZ(-350px) scale(0.65);
        opacity: 0.4;
        pointer-events: auto;
    }

    .carousel-3d-card[data-position="right-2"] {
        z-index: 60;
        transform: translateX(750px) translateZ(-350px) scale(0.65);
        opacity: 0.4;
        pointer-events: auto;
    }

    .carousel-3d-card[data-position="hidden"] {
        z-index: 40;
        transform: translateX(0) translateZ(-500px) scale(0.5);
        opacity: 0;
        pointer-events: none;
    }

    /* Controles de navegación - Diseño moderno */
    .carousel-3d-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 65px;
        height: 65px;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.4);
        border-radius: 20px;
        color: #088db6;
        font-size: 32px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        z-index: 200;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 32px rgba(8, 141, 182, 0.2),
                    inset 0 1px 2px rgba(255, 255, 255, 0.5);
        overflow: hidden;
        outline: none;
    }

    .carousel-3d-nav:focus {
        outline: none;
        box-shadow: 0 8px 32px rgba(8, 141, 182, 0.3),
                    inset 0 1px 2px rgba(255, 255, 255, 0.5),
                    0 0 0 3px rgba(79, 172, 254, 0.3);
    }

    .carousel-3d-nav::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .carousel-3d-nav:hover::before {
        left: 100%;
    }

    .carousel-3d-nav:hover {
        background: rgba(8, 141, 182, 0.95);
        border: 2px solid rgba(255, 255, 255, 0.8);
        color: white;
        transform: translateY(-50%) scale(1.1) rotate(-5deg);
        box-shadow: 0 15px 45px rgba(8, 141, 182, 0.5),
                    inset 0 1px 3px rgba(255, 255, 255, 0.6);
    }

    .carousel-3d-nav:active {
        transform: translateY(-50%) scale(0.95);
    }

    .prev-3d {
        left: 25px;
    }

    .next-3d {
        right: 25px;
    }

    .prev-3d:hover {
        transform: translateY(-50%) scale(1.1) rotate(5deg);
    }

    .next-3d:hover {
        transform: translateY(-50%) scale(1.1) rotate(-5deg);
    }

    /* Indicadores */
    .carousel-3d-indicators {
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 12px;
        z-index: 200;
    }

    .indicator-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(8, 141, 182, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid rgba(8, 141, 182, 0.5);
        outline: none;
    }

    .indicator-dot:hover {
        background: rgba(8, 141, 182, 0.6);
        transform: scale(1.2);
    }

    .indicator-dot:focus {
        outline: none;
    }

    .indicator-dot.active {
        background: linear-gradient(135deg, #088db6, #0a4b8a);
        transform: scale(1.3);
        box-shadow: 0 0 15px rgba(8, 141, 182, 0.6);
    }

    /* Responsive */
    @media (max-width: 1400px) {
        .carousel-3d-card[data-position="left-1"] {
            transform: translateX(-400px) translateZ(-200px) scale(0.8);
        }

        .carousel-3d-card[data-position="right-1"] {
            transform: translateX(400px) translateZ(-200px) scale(0.8);
        }

        .carousel-3d-card[data-position="left-2"] {
            transform: translateX(-650px) translateZ(-350px) scale(0.6);
        }

        .carousel-3d-card[data-position="right-2"] {
            transform: translateX(650px) translateZ(-350px) scale(0.6);
        }
    }

    @media (max-width: 1200px) {
        .carousel-3d-card {
            width: 340px;
            min-height: 420px;
        }

        .carousel-3d-card[data-position="left-1"] {
            transform: translateX(-380px) translateZ(-200px) scale(0.75);
        }

        .carousel-3d-card[data-position="right-1"] {
            transform: translateX(380px) translateZ(-200px) scale(0.75);
        }

        .carousel-3d-card[data-position="left-2"],
        .carousel-3d-card[data-position="right-2"] {
            opacity: 0;
            pointer-events: none;
        }
    }

    @media (max-width: 768px) {
        .carousel-3d-wrapper {
            margin: 20px 0 40px 0;
        }

        .carousel-3d-container {
            height: 500px;
        }

        .carousel-3d-card {
            width: 300px;
            min-height: 400px;
        }

        .carousel-3d-card[data-position="center"] {
            transform: translateX(0) translateZ(0) scale(1);
        }

        .carousel-3d-card[data-position="left-1"],
        .carousel-3d-card[data-position="right-1"] {
            opacity: 0;
            pointer-events: none;
        }

        .carousel-3d-nav {
            width: 50px;
            height: 50px;
            font-size: 24px;
            border-radius: 15px;
        }

        .prev-3d {
            left: 8px;
        }

        .next-3d {
            right: 8px;
        }

        .card-content {
            padding: 30px 20px;
        }

        .card-icon-3d {
            font-size: 2.8rem;
        }

        .card-title-3d {
            font-size: 1.2rem;
        }
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
            <img src="{{ asset('home/img/galeria/10.jpg') }}" alt="Imagen 2">
            <div class="water-overlay"></div>
        </div>
        <div class="slide">
            <img src="{{ asset('home/img/galeria/18.jpg') }}" alt="Imagen 3">
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
<div class="position-relative text-center px-0 px-md-0 mb-0"
    style="background: linear-gradient(to right, rgba(9, 64, 122, 0.6), rgba(255, 255, 255, 0)); padding-top: 280px; height: 95vh; display: flex; align-items: center;
 z-index: 5; pointer-events: none;">
    <div class="row align-items-center px-3" style="pointer-events: auto;">
        <div class="col-lg-2 text-center">
            <img class="img-fluid fade-in-up" style="width: 10rem;" src="{{ asset('home/img/logo_gore2.png') }}"
                alt="Logo">
            <h3 class="text-white mb-4 mt-3 mt-lg-0 fade-in-up" style="animation-delay: 0.2s; text-center">Estrategia
                Regional</h3>
        </div>
        <div class="col-lg-8 text-left">
            <h1 class="display-4 font-weight-bold text-white fade-in-up" style="animation-delay: 0.4s;">Mi Cole con Agua
                Segura</h1>
            <p class="text-white mb-4 d-none d-md-block fade-in-up" style="animation-delay: 0.6s;">Este es un espacio
                donde los estudiantes pueden aprender a
                medir el cloro en el agua de sus escuelas. Con este sistema,
                podrás hacer tus propias verificaciones y descubrir información divertida y útil sobre el agua.
                ¡Conviértete en un experto y cuida de tu entorno mientras te diviertes!</p>
            <a href="{{ route('home.about') }}" class="btn btn-secondary mt-1 py-3 px-5 fade-in-up btn-hover-effect"
                style="background: linear-gradient(45deg, #088db6, #0a4b8a) !important; border: none; border-radius: 30px; padding: 15px 40px; font-weight: 600; box-shadow: 0 8px 25px rgba(8, 141, 182, 0.4); transition: all 0.3s ease; animation-delay: 0.8s; text-transform: uppercase; letter-spacing: 1px;">Conocer
                más</a>
        </div>
    </div>
</div>
<!-- Sección Carrusel 3D - Interactivo -->
<div class="container-fluid pt-4 section-modern elegant-container mb-0 mt-0 pb-3 pt-3">
    <div class="container pb-2">
        <div class="text-center pb-3">
            <h2 class="animated-title mb-3" style="color: #0a4b8a; font-weight: bold;">Explora Nuestro Contenido</h2>
            <p style="color: #666; font-size: 1.1rem;">Descubre información fascinante sobre el agua y su importancia
            </p>
        </div>

        <!-- Carrusel 3D Container -->
        <div class="carousel-3d-wrapper">
            <div class="carousel-3d-container" id="carousel3d">

                <!-- Card 1 -->
                <div class="carousel-3d-card" data-index="0">
                    <a href="{{ route('home.content') }}" class="card-link">
                        <div class="card-content">
                            <i class="flaticon-025-sandwich card-icon-3d"></i>
                            <h4 class="card-title-3d">Tensiones en Torno al Agua</h4>
                            <p class="card-text-3d">Aquí te contaremos, de manera clara y sencilla, sobre las tensiones que suelen presentarse en la sociedad en relación con el agua.</p>
                            <ul class="card-list-3d">
                                <li>Desperdicio</li>
                                <li>La contaminación</li>
                                <li>El cambio climático</li>
                            </ul>
                        </div>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="carousel-3d-card" data-index="1">
                    <a href="{{ route('home.content') }}" class="card-link">
                        <div class="card-content">
                            <i class="flaticon-022-drum card-icon-3d"></i>
                            <h4 class="card-title-3d">El Agua para Consumo Humano</h4>
                            <p class="card-text-3d">Aquí te contaremos, de manera clara y sencilla, sobre el agua para consumo humano.</p>
                            <ul class="card-list-3d">
                                <li>El agua potable</li>
                                <li>El alcantarillado sanitario</li>
                                <li>El tratamiento de las aguas residuales</li>
                            </ul>
                        </div>
                    </a>
                </div>

                <!-- Card 3 -->
                <div class="carousel-3d-card" data-index="2">
                    <a href="{{ route('home.content') }}" class="card-link">
                        <div class="card-content">
                            <i class="flaticon-030-crayons card-icon-3d"></i>
                            <h4 class="card-title-3d">Otros Usos del Agua</h4>
                            <p class="card-text-3d">Aquí te contaremos, de manera clara y sencilla, sobre los otros usos que tiene el agua.</p>
                            <ul class="card-list-3d">
                                <li>El agua para la producción de alimentos</li>
                                <li>El agua para la generación de energía</li>
                                <li>El agua para la recreación</li>
                            </ul>
                        </div>
                    </a>
                </div>

                <!-- Card 4 -->
                <div class="carousel-3d-card" data-index="3">
                    <a href="{{ route('home.content') }}" class="card-link">
                        <div class="card-content">
                            <i class="flaticon-017-toy-car card-icon-3d"></i>
                            <h4 class="card-title-3d">Garantizando la Calidad del Agua</h4>
                            <p class="card-text-3d">Aquí te contaremos, de manera clara y sencilla, sobre la forma en que podemos garantizar el acceso seguro y sostenible a un agua de calidad.</p>
                            <ul class="card-list-3d">
                                <li>Calidad y sostenibilidad de los sistemas</li>
                                <li>Entidades encargadas del servicio</li>
                                <li>Importancia de la tarifa de agua</li>
                            </ul>
                        </div>
                    </a>
                </div>

                <!-- Card 5 -->
                <div class="carousel-3d-card" data-index="4">
                    <a href="{{ route('home.content') }}" class="card-link">
                        <div class="card-content">
                            <i class="flaticon-047-backpack card-icon-3d"></i>
                            <h4 class="card-title-3d">El Uso Responsable del Agua</h4>
                            <p class="card-text-3d">Aquí te contaremos, de manera clara y sencilla, sobre la forma en que debemos tener un uso responsable del agua.</p>
                            <ul class="card-list-3d">
                                <li>El ahorro y cuidado del agua</li>
                                <li>Deberes y derechos de los usuarios de agua</li>
                                <li>Aprendiendo a criar nuestra agua</li>
                            </ul>
                        </div>
                    </a>
                </div>

                <!-- Card 6 -->
                <div class="carousel-3d-card" data-index="5">
                    <a href="{{ route('home.content') }}" class="card-link">
                        <div class="card-content">
                            <i class="flaticon-050-fence card-icon-3d"></i>
                            <h4 class="card-title-3d">Importancia del Agua</h4>
                            <p class="card-text-3d">Aquí te contaremos, de manera clara y sencilla, sobre qué tan importante es el agua para el mundo y cada uno de nosotros.</p>
                            <ul class="card-list-3d">
                                <li>El agua en el Planeta</li>
                                <li>El ciclo del agua</li>
                                <li>Su importancia para la infancia</li>
                            </ul>
                        </div>
                    </a>
                </div>

            </div>

            <!-- Controles de Navegación -->
            <button class="carousel-3d-nav prev-3d" id="prevCarousel3d">◄</button>
            <button class="carousel-3d-nav next-3d" id="nextCarousel3d">►</button>

            <!-- Indicadores -->
            <div class="carousel-3d-indicators" id="carousel3dIndicators">
                <span class="indicator-dot active" data-slide="0"></span>
                <span class="indicator-dot" data-slide="1"></span>
                <span class="indicator-dot" data-slide="2"></span>
                <span class="indicator-dot" data-slide="3"></span>
                <span class="indicator-dot" data-slide="4"></span>
                <span class="indicator-dot" data-slide="5"></span>
            </div>
        </div>

    </div>
</div>

<!-- Fascículos - Carrusel 3D -->
<div class="container-fluid pt-4 section-modern"
    style="background: linear-gradient(135deg, #f8fbff 0%, #ffffff 100%);">
    <div class="container pb-2">
        <div class="text-center pb-3">
            <p class="section-title px-5" style="color: #088db6; font-size: 1.2rem; font-weight: 600;"><span
                    class="px-2">Más Contenido</span></p>
            <h1 class="mb-3 animated-title" style="color: #0a4b8a; font-weight: bold;">Fascículos</h1>
        </div>

        <!-- Carrusel 3D Fascículos -->
        <div class="carousel-3d-wrapper">
            <div class="carousel-3d-container" id="carousel3dFasciculos">

                <!-- Fascículo 1 -->
                <div class="carousel-3d-card" data-index="0">
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-1.pdf') }}" target="_blank" class="card-link">
                        <div class="card-content">
                            <img src="{{ asset('home/img/fasiculos/f1.png') }}" alt="Fascículo 1" style="width: 100%; border-radius: 15px; margin-bottom: 15px;">
                            <h4 class="card-title-3d">Importancia del Agua</h4>
                            <p class="card-text-3d">Debes saber, que nuestro sistema solar está compuesto por 8 planetas, de los cuales solo la tierra tiene abundante agua en estado líquido.</p>
                        </div>
                    </a>
                </div>

                <!-- Fascículo 2 -->
                <div class="carousel-3d-card" data-index="1">
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-2.pdf') }}" target="_blank" class="card-link">
                        <div class="card-content">
                            <img src="{{ asset('home/img/fasiculos/f2.png') }}" alt="Fascículo 2" style="width: 100%; border-radius: 15px; margin-bottom: 15px;">
                            <h4 class="card-title-3d">El Agua para Consumo Humano</h4>
                            <p class="card-text-3d">Debemos empezar aclarando que para tener agua potable y evitar la contaminación del medio ambiente, contamos con servicios de saneamiento.</p>
                        </div>
                    </a>
                </div>

                <!-- Fascículo 3 -->
                <div class="carousel-3d-card" data-index="2">
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-3.pdf') }}" target="_blank" class="card-link">
                        <div class="card-content">
                            <img src="{{ asset('home/img/fasiculos/f3.png') }}" alt="Fascículo 3" style="width: 100%; border-radius: 15px; margin-bottom: 15px;">
                            <h4 class="card-title-3d">Otros Usos del Agua</h4>
                            <p class="card-text-3d">Además del agua para consumo humano, existen otros usos del agua. La actividad que más agua consume es el riego de cultivos.</p>
                        </div>
                    </a>
                </div>

                <!-- Fascículo 4 -->
                <div class="carousel-3d-card" data-index="3">
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-4.pdf') }}" target="_blank" class="card-link">
                        <div class="card-content">
                            <img src="{{ asset('home/img/fasiculos/f4.png') }}" alt="Fascículo 4" style="width: 100%; border-radius: 15px; margin-bottom: 15px;">
                            <h4 class="card-title-3d">Garantizando la Calidad del Agua</h4>
                            <p class="card-text-3d">Ahora que ya sabes lo complejo que es mantener limpia el agua, debes saber que en nuestra región Apurímac los sistemas están en proceso de deterioro.</p>
                        </div>
                    </a>
                </div>

                <!-- Fascículo 5 -->
                <div class="carousel-3d-card" data-index="4">
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-5.pdf') }}" target="_blank" class="card-link">
                        <div class="card-content">
                            <img src="{{ asset('home/img/fasiculos/f5.png') }}" alt="Fascículo 5" style="width: 100%; border-radius: 15px; margin-bottom: 15px;">
                            <h4 class="card-title-3d">Tensiones en Torno al Agua</h4>
                            <p class="card-text-3d">Antes de empezar, trata de calcular cuántos litros de agua consumes diariamente. Piensa en las distintas actividades que realizas.</p>
                        </div>
                    </a>
                </div>

                <!-- Fascículo 6 -->
                <div class="carousel-3d-card" data-index="5">
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-6.pdf') }}" target="_blank" class="card-link">
                        <div class="card-content">
                            <img src="{{ asset('home/img/fasiculos/f6.png') }}" alt="Fascículo 6" style="width: 100%; border-radius: 15px; margin-bottom: 15px;">
                            <h4 class="card-title-3d">El Uso Responsable del Agua</h4>
                            <p class="card-text-3d">El 22 de marzo fue declarado Día Mundial del Agua. Esa fecha tiene el objetivo de recordar la gran importancia del agua en nuestras vidas.</p>
                        </div>
                    </a>
                </div>

            </div>

            <!-- Controles de Navegación -->
            <button class="carousel-3d-nav prev-3d" id="prevCarousel3dFasciculos">◄</button>
            <button class="carousel-3d-nav next-3d" id="nextCarousel3dFasciculos">►</button>

            <!-- Indicadores -->
            <div class="carousel-3d-indicators" id="carousel3dFasciIndicators">
                <span class="indicator-dot active" data-slide="0"></span>
                <span class="indicator-dot" data-slide="1"></span>
                <span class="indicator-dot" data-slide="2"></span>
                <span class="indicator-dot" data-slide="3"></span>
                <span class="indicator-dot" data-slide="4"></span>
                <span class="indicator-dot" data-slide="5"></span>
            </div>
        </div>

    </div>
</div>

<!-- Materiales - Rediseñados -->
<div class="container-fluid pt-5 section-modern elegant-container mb-3 mt-3 pb-3 pt-3" id="materiales">
    <div class="container">
        <div class="text-center pb-4">
            <p class="section-title px-5" style="color: #088db6; font-size: 1.2rem; font-weight: 600;"><span
                    class="px-2">Extras</span></p>
            <h1 class="mb-4 animated-title" style="color: #0a4b8a; font-weight: bold;">Materiales</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 1;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <a href="{{ asset('home/material agua/ANEXOS/guia-docente.pdf') }}" target="_blank">
                        <img style="height: 15rem" class="img-fluid w-100"
                            src="{{ asset('home/img/guia-docente.png') }}" alt="Guía Docente">
                    </a>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">Cuidando la Vida</h4>
                <i style="color: #666;">Guía para Docentes</i>
            </div>

            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 2;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <a href="{{ route('home.content') }}" target="_blank" title="Ver galería de videos"
                        style="display: block; position: relative; z-index: 5;">
                        <img style="height: 15rem; cursor: pointer;" class="img-fluid w-100"
                            src="{{ asset('home/img/videos.jpg') }}" alt="Galería de videos">
                    </a>

                    <div class="material-overlay d-flex align-items-center justify-content-center w-100 h-100 position-absolute"
                        style="top: 0; left: 0; z-index: 4; pointer-events: none; background: linear-gradient(135deg, rgba(8,141,182,0.6), rgba(9,64,122,0.4));">
                    </div>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">Videos</h4>
                <i style="color: #666;">Galería audiovisual</i>
            </div>




            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 3;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <a href="{{ asset('home/material agua/ANEXOS/cuento-agua.pdf') }}" target="_blank">
                        <img style="height: 15rem" class="img-fluid w-100" src="{{ asset('home/img/cuento.png') }}"
                            alt="Cuento El Agua en Peligro">
                    </a>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">El Agua en Peligro</h4>
                <i style="color: #666;">Cuento</i>
            </div>


            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 4;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">

                    <a href="{{ route('home.gallery') }}" title="Abrir álbum interactivo">
                        <img style="height: 15rem" class="img-fluid w-100" src="{{ asset('home/img/album.jpg') }}"
                            alt="Álbum Interactivo">
                    </a>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">Aprendiendo a Valorar y Criar Nuestra Agua</h4>
                <i style="color: #666;">Álbum Interactivo</i>
            </div>


            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 5;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">

                    <a href="{{ asset('home/material%20agua/ANEXOS/Roger%20y%20la%20Magia%20del%20Agua.pdf') }}"
                        target="_blank" title="Leer cuento: Roger y la Magia del Agua">
                        <img style="height: 15rem" class="img-fluid w-100"
                            src="{{ asset('home/material%20agua/ANEXOS/rojer.png') }}"
                            alt="Roger y la Magia del Agua">
                    </a>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">Roger y la Magia del Agua</h4>
                <i style="color: #666;">Cuento</i>
            </div>


            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 6;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <a href="{{ asset('home/material%20agua/ANEXOS/Mi%20Cole%20Con%20Agua%20Segura.pdf') }}" 
                    target="_blank" 
                    title="Abrir: Mi Cole con Agua Segura">
                        <img style="height: 15rem" 
                            class="img-fluid w-100"
                            src="{{ asset('home/material%20agua/ANEXOS/micole.png') }}" 
                            alt="Mi Cole con Agua Segura">
                    </a>
                </div>
                <h4 style="color: #0a4b8a; font-weight: bold;">Mi Cole con Agua Segura</h4>
                <i style="color: #666;">Estrategia</i>
            </div>
            <div class="col-md-6 col-lg-3 text-center material-item mb-5 fade-in-up" style="--delay: 7;">
                <div class="material-circle position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <a href="{{ asset('home/material%20agua/ANEXOS/Los%20Guardianes%20del%20Agua.pdf') }}" 
                    target="_blank" 
                    title="Leer cuento: Los Guardianes del Agua">
                        <img style="height: 15rem" 
                            class="img-fluid w-100"
                            src="{{ asset('home/material%20agua/ANEXOS/guardianes.png') }}" 
                            alt="Los Guardianes del Agua">
                    </a>
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
                    <img class="member-logo img-fluid mx-auto mb-3" src="{{ asset('home/img/MIDIS.jpg') }}"
                        style="height: 120px; width: auto;" alt="Image">
                    <h5 style="color: #0a4b8a; font-weight: bold;">Ministerio de Desarrollo e Inclusión Social</h5>
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

            <a href="#" class="col-md-6 col-lg-4 mb-4 fade-in-up" style="--delay: 7; text-decoration: none;">
                <div
                    class="member-card bg-light shadow-sm rounded p-3 d-flex flex-column justify-content-center h-100">
                    <img class="member-logo img-fluid mx-auto mb-3" src="{{ asset('home/img/galeria/andinas.jpg') }}"
                        style="height: 120px; width: auto;" alt="Image">
                    <h5 style="color: #0a4b8a; font-weight: bold;">Agua Para Ciudades Andinas</h5>
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
            console.log('Inicializando componentes del slider...');
            console.log('Elementos encontrados:', {
                slides: this.slides.length,
                dots: this.dots.length,
                prevBtn: !!this.prevBtn,
                nextBtn: !!this.nextBtn
            });

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
            console.log('Configurando event listeners...');

            this.dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    console.log('Click en dot:', index);
                    if (!this.isTransitioning) {
                        this.goToSlide(index);
                    }
                });
            });

            if (this.prevBtn) {
                this.prevBtn.addEventListener('click', () => {
                    console.log('Click en botón anterior');
                    if (!this.isTransitioning) {
                        this.prevSlide();
                    }
                });
            } else {
                console.error('Botón previo no encontrado');
            }

            if (this.nextBtn) {
                this.nextBtn.addEventListener('click', () => {
                    console.log('Click en botón siguiente');
                    if (!this.isTransitioning) {
                        this.nextSlide();
                    }
                });
            } else {
                console.error('Botón siguiente no encontrado');
            }

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
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Inicializando slider...');
        new WaterFlowSlider();
    });

    // Fallback para asegurar que se ejecute
    window.addEventListener('load', function() {
        if (!document.querySelector('.slider-initialized')) {
            console.log('Inicializando slider (fallback)...');
            new WaterFlowSlider();
            document.body.classList.add('slider-initialized');
        }
    });

    // CARRUSEL 3D CLASS
    class Carousel3D {
        constructor(containerId, prevBtnId, nextBtnId, indicatorsId) {
            this.container = document.getElementById(containerId);
            if (!this.container) return;

            this.cards = this.container.querySelectorAll('.carousel-3d-card');
            this.prevBtn = document.getElementById(prevBtnId);
            this.nextBtn = document.getElementById(nextBtnId);
            this.indicatorsContainer = document.getElementById(indicatorsId);
            this.indicators = this.indicatorsContainer ? this.indicatorsContainer.querySelectorAll('.indicator-dot') : [];
            this.currentIndex = 0;
            this.totalCards = this.cards.length;
            this.isAnimating = false;
            this.autoPlayInterval = null;

            this.init();
        }

        init() {
            console.log('Inicializando Carrusel 3D...');
            this.updatePositions();
            this.addEventListeners();
            this.startAutoPlay();
        }

        addEventListeners() {
            // Botones de navegación
            this.prevBtn.addEventListener('click', () => {
                if (!this.isAnimating) {
                    this.prev();
                }
            });

            this.nextBtn.addEventListener('click', () => {
                if (!this.isAnimating) {
                    this.next();
                }
            });

            // Indicadores
            this.indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    if (!this.isAnimating && index !== this.currentIndex) {
                        this.goToSlide(index);
                    }
                });
            });

            // Click en las tarjetas
            this.cards.forEach((card, index) => {
                card.addEventListener('click', (e) => {
                    const position = card.getAttribute('data-position');
                    if (position !== 'center' && position !== 'hidden') {
                        e.preventDefault();
                        if (!this.isAnimating) {
                            this.goToSlide(index);
                        }
                    }
                });
            });

            // Pausar autoplay en hover
            this.container.addEventListener('mouseenter', () => {
                this.stopAutoPlay();
            });

            this.container.addEventListener('mouseleave', () => {
                this.startAutoPlay();
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (!this.isAnimating) {
                    if (e.key === 'ArrowLeft') {
                        this.prev();
                    } else if (e.key === 'ArrowRight') {
                        this.next();
                    }
                }
            });
        }

        getPosition(index) {
            const diff = index - this.currentIndex;
            const total = this.totalCards;

            // Normalizar la diferencia para el camino más corto
            let normalizedDiff = diff;
            if (Math.abs(diff) > total / 2) {
                normalizedDiff = diff > 0 ? diff - total : diff + total;
            }

            if (normalizedDiff === 0) return 'center';
            if (normalizedDiff === 1 || normalizedDiff === -total + 1) return 'right-1';
            if (normalizedDiff === -1 || normalizedDiff === total - 1) return 'left-1';
            if (normalizedDiff === 2 || normalizedDiff === -total + 2) return 'right-2';
            if (normalizedDiff === -2 || normalizedDiff === total - 2) return 'left-2';
            return 'hidden';
        }

        updatePositions() {
            this.cards.forEach((card, index) => {
                const position = this.getPosition(index);
                card.setAttribute('data-position', position);
            });

            // Actualizar indicadores
            this.indicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === this.currentIndex);
            });
        }

        next() {
            this.isAnimating = true;
            this.currentIndex = (this.currentIndex + 1) % this.totalCards;
            this.updatePositions();

            setTimeout(() => {
                this.isAnimating = false;
            }, 800);
        }

        prev() {
            this.isAnimating = true;
            this.currentIndex = (this.currentIndex - 1 + this.totalCards) % this.totalCards;
            this.updatePositions();

            setTimeout(() => {
                this.isAnimating = false;
            }, 800);
        }

        goToSlide(targetIndex) {
            if (targetIndex === this.currentIndex) return;

            this.isAnimating = true;

            // Calcular la dirección más corta
            const diff = targetIndex - this.currentIndex;
            const total = this.totalCards;

            if (Math.abs(diff) <= total / 2) {
                this.currentIndex = targetIndex;
            } else {
                if (diff > 0) {
                    this.currentIndex = targetIndex;
                } else {
                    this.currentIndex = targetIndex;
                }
            }

            this.updatePositions();

            setTimeout(() => {
                this.isAnimating = false;
            }, 800);
        }

        startAutoPlay() {
            this.stopAutoPlay();
            this.autoPlayInterval = setInterval(() => {
                if (!this.isAnimating) {
                    this.next();
                }
            }, 5000);
        }

        stopAutoPlay() {
            if (this.autoPlayInterval) {
                clearInterval(this.autoPlayInterval);
                this.autoPlayInterval = null;
            }
        }
    }

    // Inicializar Carruseles 3D
    document.addEventListener('DOMContentLoaded', function() {
        // Carrusel de Contenido
        const carousel3dContainer = document.getElementById('carousel3d');
        if (carousel3dContainer) {
            console.log('Inicializando Carrusel 3D de Contenido...');
            new Carousel3D('carousel3d', 'prevCarousel3d', 'nextCarousel3d', 'carousel3dIndicators');
        }

        // Carrusel de Fascículos
        const carousel3dFasciculos = document.getElementById('carousel3dFasciculos');
        if (carousel3dFasciculos) {
            console.log('Inicializando Carrusel 3D de Fascículos...');
            new Carousel3D('carousel3dFasciculos', 'prevCarousel3dFasciculos', 'nextCarousel3dFasciculos', 'carousel3dFasciIndicators');
        }
    });

    // Fallback
    window.addEventListener('load', function() {
        // Carrusel de Contenido
        const carousel3dContainer = document.getElementById('carousel3d');
        if (carousel3dContainer && !carousel3dContainer.classList.contains('carousel-initialized')) {
            console.log('Inicializando Carrusel 3D de Contenido (fallback)...');
            new Carousel3D('carousel3d', 'prevCarousel3d', 'nextCarousel3d', 'carousel3dIndicators');
            carousel3dContainer.classList.add('carousel-initialized');
        }

        // Carrusel de Fascículos
        const carousel3dFasciculos = document.getElementById('carousel3dFasciculos');
        if (carousel3dFasciculos && !carousel3dFasciculos.classList.contains('carousel-initialized')) {
            console.log('Inicializando Carrusel 3D de Fascículos (fallback)...');
            new Carousel3D('carousel3dFasciculos', 'prevCarousel3dFasciculos', 'nextCarousel3dFasciculos', 'carousel3dFasciIndicators');
            carousel3dFasciculos.classList.add('carousel-initialized');
        }
    });
</script>

@include('home/layout/footer')
