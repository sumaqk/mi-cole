<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Mi Cole</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="{{ asset('home/img/logo_agua_segura.png') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet"> --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Flaticon Font -->
    <link href="{{ asset('home/lib/flaticon/font/flaticon.css') }}" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('home/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('home/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid bg-light position-relative shadow">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
            <a href="{{ route('home.index') }}" class="navbar-brand text-secondary" style="font-size: 60px;">                
                <i class="fas fa-water"></i>
            </a>
            <a href="{{ route('home.index') }}" class="navbar-brand font-weight-bold text-secondary" style="font-size: 40px;">
                <div class="d-flex flex-column justify-content-start">
                    <span class="text-primary">Mi Cole</span>
                    <p class="text-primary" style="font-size: 30px;">con agua segura</p>
                </div>
            </a>
            
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav font-weight-bold mx-auto py-0">
                    <a href="{{ route('home.index') }}" class="nav-item nav-link {{ request()->routeIs('home.index') ? 'active' : '' }}">Inicio</a>
                    <a href="{{ route('home.about') }}" class="nav-item nav-link {{ request()->routeIs('home.about') ? 'active' : '' }}">Sobre Nosotros</a>
                    <a href="{{ route('home.content') }}" class="nav-item nav-link {{ request()->routeIs('home.content') ? 'active' : '' }}">Contenido</a>
                    <a href="{{ route('home.gallery') }}" class="nav-item nav-link {{ request()->routeIs('home.gallery') ? 'active' : '' }}">Galeria</a>
                    <a href="{{ route('home.institution') }}" class="nav-item nav-link {{ request()->routeIs('home.institution') ? 'active' : '' }}">Instituciones</a>
                    <a href="https://agua.dreapurimac.gob.pe/Archivos/archivo/importancia.html" class="nav-item nav-link" target="_blank">Material DREA</a>
                </div>
                <a href="{{url('user/loginasadmin')}}" class="btn btn-primary px-4" target="_blank">Ingresar</a>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->
