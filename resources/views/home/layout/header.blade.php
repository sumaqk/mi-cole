<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Mi Cole - Sistema Regional de Registro de Cloro</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Sistema educativo de agua segura" name="keywords">
    <meta content="Plataforma educativa para el registro y control de cloro en agua" name="description">

    <!-- Favicon -->
    <link href="{{ asset('home/img/logo_agua_segura.png') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Flaticon Font -->
    <link href="{{ asset('home/lib/flaticon/font/flaticon.css') }}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('home/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('home/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet">

    <style>
        /* Header Moderno - Compatible con todos los navegadores */
        .header-modern {
            background: #f8f9fa;
            background: -webkit-linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 250, 0.98) 100%);
            background: -moz-linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 250, 0.98) 100%);
            background: -o-linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 250, 0.98) 100%);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 249, 250, 0.98) 100%);
            -webkit-box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            -moz-box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(79, 172, 254, 0.2);
            position: relative;
            overflow: hidden;
        }

        .header-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: -webkit-linear-gradient(90deg, transparent 0%, rgba(79, 172, 254, 0.05) 50%, transparent 100%);
            background: -moz-linear-gradient(90deg, transparent 0%, rgba(79, 172, 254, 0.05) 50%, transparent 100%);
            background: linear-gradient(90deg, transparent 0%, rgba(79, 172, 254, 0.05) 50%, transparent 100%);
            -webkit-animation: headerShine 6s ease-in-out infinite;
            -moz-animation: headerShine 6s ease-in-out infinite;
            animation: headerShine 6s ease-in-out infinite;
            pointer-events: none;
        }

        @-webkit-keyframes headerShine {

            0%,
            100% {
                -webkit-transform: translateX(-100%);
                transform: translateX(-100%);
            }

            50% {
                -webkit-transform: translateX(100%);
                transform: translateX(100%);
            }
        }

        @-moz-keyframes headerShine {

            0%,
            100% {
                -moz-transform: translateX(-100%);
                transform: translateX(-100%);
            }

            50% {
                -moz-transform: translateX(100%);
                transform: translateX(100%);
            }
        }

        @keyframes headerShine {

            0%,
            100% {
                -webkit-transform: translateX(-100%);
                -moz-transform: translateX(-100%);
                transform: translateX(-100%);
            }

            50% {
                -webkit-transform: translateX(100%);
                -moz-transform: translateX(100%);
                transform: translateX(100%);
            }
        }

        .navbar-modern {
            padding: 1rem 0;
            background: transparent;
            position: relative;
            z-index: 10;
            -webkit-flex-wrap: nowrap;
            -ms-flex-wrap: nowrap;
            flex-wrap: nowrap;
        }

        .brand-container {
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            text-decoration: none;
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
            position: relative;
            min-width: 280px;
            -webkit-flex-shrink: 0;
            -ms-flex-negative: 0;
            flex-shrink: 0;
        }

        .brand-container:hover {
            -webkit-transform: translateY(-2px);
            -moz-transform: translateY(-2px);
            -ms-transform: translateY(-2px);
            transform: translateY(-2px);
            text-decoration: none;
        }

        .brand-icon-modern {
            background: #4facfe;
            background: -webkit-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            background: -moz-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            background: -o-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            width: 65px;
            height: 65px;
            -webkit-border-radius: 18px;
            -moz-border-radius: 18px;
            border-radius: 18px;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            margin-right: 18px;
            -webkit-box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);
            -moz-box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);
            box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            -webkit-flex-shrink: 0;
            -ms-flex-negative: 0;
            flex-shrink: 0;
        }

        .brand-icon-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: -webkit-linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            background: -moz-linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            -webkit-animation: iconShine 3s ease-in-out infinite;
            -moz-animation: iconShine 3s ease-in-out infinite;
            animation: iconShine 3s ease-in-out infinite;
        }

        @-webkit-keyframes iconShine {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        @-moz-keyframes iconShine {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        @keyframes iconShine {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        .brand-icon-modern:hover {
            -webkit-transform: scale(1.05) rotate(5deg);
            -moz-transform: scale(1.05) rotate(5deg);
            -ms-transform: scale(1.05) rotate(5deg);
            transform: scale(1.05) rotate(5deg);
            -webkit-box-shadow: 0 15px 40px rgba(79, 172, 254, 0.4);
            -moz-box-shadow: 0 15px 40px rgba(79, 172, 254, 0.4);
            box-shadow: 0 15px 40px rgba(79, 172, 254, 0.4);
        }

        .brand-icon-modern i {
            font-size: 2.2rem;
            color: white;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .brand-text-container {
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-direction: column;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-flex-shrink: 0;
            -ms-flex-negative: 0;
            flex-shrink: 0;
        }

        .brand-title {
            font-size: 2.8rem;
            font-weight: 800;
            background: #4facfe;
            background: -webkit-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            background: -moz-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            line-height: 1;
            text-shadow: none;
            color: #4facfe;
            /* Fallback para navegadores antiguos */
        }

        .brand-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            font-weight: 500;
            margin: 0;
            margin-top: 5px;
            opacity: 0.8;
        }

        .navbar-nav-modern {
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            gap: 8px;
        }

        .nav-item-modern {
            margin: 0 3px;
        }

        .nav-link-modern {
            color: #495057 !important;
            font-weight: 600;
            padding: 12px 18px !important;
            -webkit-border-radius: 25px;
            -moz-border-radius: 25px;
            border-radius: 25px;
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
            position: relative;
            text-decoration: none;
            font-size: 0.95rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(79, 172, 254, 0.1);
            display: inline-block;
            overflow: hidden;
            z-index: 1;
        }

        .nav-link-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #4facfe;
            background: -webkit-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            background: -moz-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
            z-index: -1;
        }

        .nav-link-modern:hover {
            color: white !important;
            -webkit-transform: translateY(-2px);
            -moz-transform: translateY(-2px);
            -ms-transform: translateY(-2px);
            transform: translateY(-2px);
            -webkit-box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
            -moz-box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
            box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
            text-decoration: none;
            border: 1px solid rgba(79, 172, 254, 0.3);
        }

        .nav-link-modern:hover::before {
            left: 0;
        }

        .btn-login-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #00f2fe;
            background: -webkit-linear-gradient(135deg, #00f2fe 0%, #4facfe 100%);
            background: -moz-linear-gradient(135deg, #00f2fe 0%, #4facfe 100%);
            background: linear-gradient(135deg, #00f2fe 0%, #4facfe 100%);
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
            z-index: -1;
        }

        .btn-login-modern:hover::before {
            left: 0;
        }
/* 
        .nav-link-modern:hover {
            background: #4facfe;
            background: -webkit-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            background: -moz-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white !important;
            -webkit-transform: translateY(-2px);
            -moz-transform: translateY(-2px);
            -ms-transform: translateY(-2px);
            transform: translateY(-2px);
            -webkit-box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
            -moz-box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
            box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
            text-decoration: none;
            border: 1px solid rgba(79, 172, 254, 0.3);
        }

        .nav-link-modern.active {
            background: #4facfe !important;
            background: -webkit-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
            background: -moz-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
            color: white !important;
            -webkit-box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
            -moz-box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
            border: 1px solid rgba(79, 172, 254, 0.3);
        } */

        .btn-login-modern {
            background: #4facfe;
            background: -webkit-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            background: -moz-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            padding: 12px 30px;
            -webkit-border-radius: 25px;
            -moz-border-radius: 25px;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
            -webkit-box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3);
            -moz-box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3);
            box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3);
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-block;
        }

        .btn-login-modern:hover {
            -webkit-transform: translateY(-3px) scale(1.05);
            -moz-transform: translateY(-3px) scale(1.05);
            -ms-transform: translateY(-3px) scale(1.05);
            transform: translateY(-3px) scale(1.05);
            -webkit-box-shadow: 0 12px 35px rgba(79, 172, 254, 0.4);
            -moz-box-shadow: 0 12px 35px rgba(79, 172, 254, 0.4);
            box-shadow: 0 12px 35px rgba(79, 172, 254, 0.4);
            color: white;
            text-decoration: none;
        }

        .navbar-toggler-modern {
            border: none;
            padding: 8px 12px;
            -webkit-border-radius: 10px;
            -moz-border-radius: 10px;
            border-radius: 10px;
            background: rgba(79, 172, 254, 0.1);
            -webkit-transition: all 0.3s ease;
            -moz-transition: all 0.3s ease;
            -o-transition: all 0.3s ease;
            transition: all 0.3s ease;
        }

        .navbar-toggler-modern:hover {
            background: rgba(79, 172, 254, 0.2);
            -webkit-transform: scale(1.05);
            -moz-transform: scale(1.05);
            -ms-transform: scale(1.05);
            transform: scale(1.05);
        }

        .navbar-toggler-modern .fa-bars {
            color: #4facfe;
            font-size: 1.2rem;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .brand-title {
                font-size: 2.2rem;
            }

            .brand-subtitle {
                font-size: 1rem;
            }

            .brand-container {
                min-width: 250px;
            }

            .brand-icon-modern {
                width: 55px;
                height: 55px;
                margin-right: 15px;
            }

            .brand-icon-modern i {
                font-size: 1.8rem;
            }

            .navbar-modern {
                -webkit-flex-wrap: wrap;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
            }

            .navbar-nav-modern {
                background: rgba(255, 255, 255, 0.95) !important;
                -webkit-border-radius: 15px;
                -moz-border-radius: 15px;
                border-radius: 15px;
                margin-top: 1rem;
                padding: 15px;
                -webkit-box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                -moz-box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(79, 172, 254, 0.2);
                width: 100%;
                -webkit-flex-direction: column;
                -ms-flex-direction: column;
                flex-direction: column;
            }

            .nav-item-modern {
                margin: 3px 0;
                width: 100%;
            }

            .nav-link-modern {
                text-align: center;
                margin: 2px 0;
                display: block;
                width: 100%;
                background: rgba(79, 172, 254, 0.05);
            }
        }

        @media (max-width: 576px) {
            .brand-container {
                min-width: 220px;
            }

            .brand-icon-modern {
                width: 50px;
                height: 50px;
                margin-right: 12px;
            }

            .brand-icon-modern i {
                font-size: 1.5rem;
            }

            .brand-title {
                font-size: 1.9rem;
            }

            .brand-subtitle {
                font-size: 0.9rem;
            }
        }

        /* Animación de carga */
        .header-modern {
            -webkit-animation: headerFadeIn 1s ease-out;
            -moz-animation: headerFadeIn 1s ease-out;
            animation: headerFadeIn 1s ease-out;
        }

        @-webkit-keyframes headerFadeIn {
            from {
                opacity: 0;
                -webkit-transform: translateY(-20px);
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                -webkit-transform: translateY(0);
                transform: translateY(0);
            }
        }

        @-moz-keyframes headerFadeIn {
            from {
                opacity: 0;
                -moz-transform: translateY(-20px);
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                -moz-transform: translateY(0);
                transform: translateY(0);
            }
        }

        @keyframes headerFadeIn {
            from {
                opacity: 0;
                -webkit-transform: translateY(-20px);
                -moz-transform: translateY(-20px);
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                -webkit-transform: translateY(0);
                -moz-transform: translateY(0);
                transform: translateY(0);
            }
        }

        /* Fix para Internet Explorer */
        .navbar-nav-modern {
            display: block;
        }

        @supports (display: flex) {
            .navbar-nav-modern {
                display: -webkit-flex;
                display: -ms-flexbox;
                display: flex;
            }
        }
    </style>
</head>

<body>
    <!-- Header Start -->
    <div class="header-modern">
        <nav class="navbar navbar-expand-lg navbar-modern container-fluid px-4">
            <!-- Brand -->
            <a href="{{ route('home.index') }}" class="brand-container">
                <div class="brand-icon-modern">
                    <i class="fas fa-water"></i>
                </div>
                <div class="brand-text-container">
                    <div class="brand-title">Mi Cole</div>
                    <div class="brand-subtitle">con agua segura</div>
                </div>
            </a>

            <!-- Toggler para móvil -->
            <button class="navbar-toggler navbar-toggler-modern" type="button" data-toggle="collapse"
                data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navigation -->
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav navbar-nav-modern mx-auto">
                    <div class="nav-item nav-item-modern">
                        <a href="{{ route('home.index') }}"
                            class="nav-link nav-link-modern {{ request()->routeIs('home.index') ? 'active' : '' }}">
                            <i class="fas fa-home mr-2"></i>Inicio
                        </a>
                    </div>
                    <div class="nav-item nav-item-modern">
                        <a href="{{ route('home.about') }}"
                            class="nav-link nav-link-modern {{ request()->routeIs('home.about') ? 'active' : '' }}">
                            <i class="fas fa-info-circle mr-2"></i>Sobre Nosotros
                        </a>
                    </div>
                    <div class="nav-item nav-item-modern">
                        <a href="{{ route('home.content') }}"
                            class="nav-link nav-link-modern {{ request()->routeIs('home.content') ? 'active' : '' }}">
                            <i class="fas fa-book mr-2"></i>Contenido
                        </a>
                    </div>
                    <div class="nav-item nav-item-modern">
                        <a href="{{ route('home.gallery') }}"
                            class="nav-link nav-link-modern {{ request()->routeIs('home.gallery') ? 'active' : '' }}">
                            <i class="fas fa-images mr-2"></i>Galería
                        </a>
                    </div>
                    <div class="nav-item nav-item-modern">
                        <a href="{{ route('home.institution') }}"
                            class="nav-link nav-link-modern {{ request()->routeIs('home.institution') ? 'active' : '' }}">
                            <i class="fas fa-building mr-2"></i>Instituciones
                        </a>
                    </div>
                    <div class="nav-item nav-item-modern">
                        <a href="https://agua.dreapurimac.gob.pe/Archivos/archivo/importancia.html"
                            class="nav-link nav-link-modern" target="_blank">
                            <i class="fas fa-external-link-alt mr-2"></i>Material DREA
                        </a>
                    </div>
                </div>

                <!-- Login Button -->
                <a href="{{ url('user/loginasadmin') }}" class="btn btn-login-modern" target="_blank">
                    <i class="fas fa-sign-in-alt mr-2"></i>Ingresar
                </a>
            </div>
        </nav>
    </div>
    <!-- Header End -->

    <script>
        // Header effects - Compatible con todos los navegadores
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll para links internos
            var links = document.querySelectorAll('a[href^="#"]');
            for (var i = 0; i < links.length; i++) {
                links[i].addEventListener('click', function(e) {
                    e.preventDefault();
                    var target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        if (target.scrollIntoView) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        } else {
                            // Fallback para navegadores antiguos
                            var targetPosition = target.offsetTop;
                            window.scrollTo(0, targetPosition);
                        }
                    }
                });
            }

            // Header scroll effect
            var lastScroll = 0;
            var header = document.querySelector('.header-modern');

            function handleScroll() {
                var currentScroll = window.pageYOffset || document.documentElement.scrollTop;

                if (currentScroll > 100) {
                    header.style.background = 'rgba(248,249,250,1)';
                    header.style.boxShadow = '0 12px 40px rgba(0,0,0,0.15)';
                } else {
                    header.style.background =
                        'linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(248,249,250,0.98) 100%)';
                    header.style.boxShadow = '0 8px 32px rgba(0,0,0,0.1)';
                }

                lastScroll = currentScroll;
            }

            // Compatible con todos los navegadores
            if (window.addEventListener) {
                window.addEventListener('scroll', handleScroll);
            } else if (window.attachEvent) {
                window.attachEvent('onscroll', handleScroll);
            }

            // Mobile menu auto-close
            var navLinks = document.querySelectorAll('.nav-link-modern');
            for (var j = 0; j < navLinks.length; j++) {
                navLinks[j].addEventListener('click', function() {
                    var navbarCollapse = document.getElementById('navbarCollapse');
                    if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                        setTimeout(function() {
                            if (typeof $ !== 'undefined' && $.fn.collapse) {
                                $('.navbar-collapse').collapse('hide');
                            } else {
                                // Fallback manual
                                navbarCollapse.classList.remove('show');
                            }
                        }, 300);
                    }
                });
            }
        });
    </script>
