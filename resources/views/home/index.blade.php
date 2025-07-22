@include('home/layout/header')

@if ($modal)
    @include('home.modal')
@endif
<!-- Header Start -->

<!-- Carrusel de fondo (solo para la página de inicio) -->
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"
    style="position: absolute; width: 100%; height: 80vh; z-index: -1; overflow: hidden;">
    <div class="carousel-inner d-none d-md-block">
        <div class="carousel-item active">
            <img src="{{ asset('home/img/galery/13.jpeg') }}" class="d-block w-100 h-100" alt="Imagen 1"
                style="object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('home/img/galery/18.jpeg') }}" class="d-block w-100 h-100" alt="Imagen 2"
                style="object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('home/img/galery/8.jpeg') }}" class="d-block w-100 h-100" alt="Imagen 3"
                style="object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('home/img/galery/25.jpeg') }}" class="d-block w-100 h-100" alt="Imagen 3"
                style="object-fit: cover;">
        </div>
    </div>
</div>
<!-- Contenedor del contenido superpuesto sobre el carrusel -->
<div class="position-relative text-center px-0 px-md-5 mb-5"
    style="background: linear-gradient(to right, #09407a, #ffffff00); padding-top: 100px; height: 80vh;">
    <div class="row align-items-center px-3">
        <div class="col-lg-7 text-center text-lg-left">
            <img class="img-fluid" style="width: 10rem;" src="{{ asset('home/img/logo_gore2.png') }}" alt="Logo">
            {{-- <h4 class="text-white mb-4 mt-5 mt-lg-0">Gobierno Regional de Apurímac</h4> --}}
            <h3 class="text-white mb-4 mt-5 mt-lg-0">Estrategia Regional</h3>
            <h1 class="display-3 font-weight-bold text-white">Mi Cole con Agua Segura</h1>
            <p class="text-white mb-4 d-none d-md-block">Este es un espacio donde los estudiantes pueden aprender a
                medir el cloro en el
                agua de sus escuelas. Con este sistema,
                podrás hacer tus propias verificaciones y descubrir información divertida y útil sobre el agua.
                ¡Conviértete en un experto y cuida de tu entorno
                mientras te diviertes!</p>
            <a href="{{ route('home.about') }}" class="btn btn-secondary mt-1 py-3 px-5"
                style="background:#088db6; border: none; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);">Conocer más</a>
        </div>
    </div>
</div>
<!-- Header End -->
<style>
    #hover-shadow:hover {
        box-shadow: 0 4px 30px rgba(6, 230, 81, 0.8);
    }
</style>
<!-- Facilities Start -->
<div class="container-fluid pt-5">
    <div class="container pb-3">
        <div class="row">
            <div class="col-lg-4 col-md-6 pb-1">
                <a href="{{ route('home.content') }}" style="text-decoration: none; color: inherit;">
                    <div id="hover-shadow">
                        <div class="d-flex bg-light shadow-sm border-top rounded mb-4" style="padding: 30px;">
                            <i class="flaticon-025-sandwich h1 font-weight-normal text-primary mb-3"></i>
                            <div class="pl-4">
                                <h4>Tensiones en Torno al Agua</h4>
                                <p class="m-0">Aqui te contaremos, de manera clara y sencilla, sobre las
                                    tensiones que suelen presentarse en la sociedad en relación con el
                                    agua.
                                <ul>
                                    <li>1. Desperdicio.</li>
                                    <li>2. La contaminación.</li>
                                    <li>3. El cambio climático.</li>
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <a href="{{ route('home.content') }}" style="text-decoration: none; color: inherit;">
                    <div id="hover-shadow">
                        <div class="d-flex bg-light shadow-sm border-top rounded mb-4" style="padding: 30px;">
                            <i class="flaticon-022-drum h1 font-weight-normal text-primary mb-3"></i>
                            <div class="pl-4">
                                <h4>El Agua para Consumo Humano</h4>
                                <p class="m-0">Aqui te contaremos, de manera clara y sencilla, sobre
                                    el agua para consumo humano.
                                <ul>
                                    <li>1. El agua potable.</li>
                                    <li>2. El alcantarillado sanitario.</li>
                                    <li>3. El tratamiento de las aguas residuales.</li>
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <a href="{{ route('home.content') }}" style="text-decoration: none; color: inherit;">
                    <div id="hover-shadow">
                        <div class="d-flex bg-light shadow-sm border-top rounded mb-4" style="padding: 30px;">
                            <i class="flaticon-030-crayons h1 font-weight-normal text-primary mb-3"></i>
                            <div class="pl-4">
                                <h4>Otros Usos del Agua</h4>
                                <p class="m-0">Aqui te contaremos, de manera clara y sencilla, sobre
                                    los otros usos que tiene el agua.
                                <ul>
                                    <li>1. El agua para la producción de alimentos.</li>
                                    <li>2. El agua para la generación de energía.</li>
                                    <li>3. El agua para la recreación.</li>
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <a href="{{ route('home.content') }}" style="text-decoration: none; color: inherit;">
                    <div id="hover-shadow">
                        <div class="d-flex bg-light shadow-sm border-top rounded mb-4" style="padding: 30px;">
                            <i class="flaticon-017-toy-car h1 font-weight-normal text-primary mb-3"></i>
                            <div class="pl-4">
                                <h4>Garantizando la Calidad del Agua</h4>
                                <p class="m-0">Aqui te contaremos, de manera clara y sencilla, sobre
                                    la forma en que podemos garantizar el acceso seguro y sostenible
                                    a un agua de calidad.
                                <ul>
                                    <li>1. Calidad y sostenibilidad de los sistemas.</li>
                                    <li>2. Entidades encargadas del servicio.</li>
                                    <li>3. Importancia de la tarifa de agua. </li>
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <a href="{{ route('home.content') }}" style="text-decoration: none; color: inherit;">
                    <div id="hover-shadow">
                        <div class="d-flex bg-light shadow-sm border-top rounded mb-4" style="padding: 30px;">
                            <i class="flaticon-047-backpack h1 font-weight-normal text-primary mb-3"></i>
                            <div class="pl-4">
                                <h4>El Uso Responsable del Agua</h4>
                                <p class="m-0">Aqui te contaremos, de manera clara y sencilla, sobre
                                    la forma en que debemos tener un uso responsable del agua.
                                <ul>
                                    <li>1. El ahorro y cuidado del agua.</li>
                                    <li>2. Deberes y derechos de los usuarios de agua.</li>
                                    <li>3. Aprendiendo a criar nuestra agua.</li>
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 pb-1">
                <a href="{{ route('home.content') }}" style="text-decoration: none; color: inherit;">
                    <div id="hover-shadow">
                        <div class="d-flex bg-light shadow-sm border-top rounded" style="padding: 30px;">
                            <i class="flaticon-050-fence h1 font-weight-normal text-primary"></i>
                            <div class="pl-4">
                                <h4>Importancia del Agua</h4>
                                <p class="m-0">Aqui te contaremos, de manera clara y sencilla, sobre que tan
                                    importante el el agua para el mundo y cada uno de nosotros.</p>
                                <br>
                                <ul>
                                    <li>1. El agua en el Planeta</li>
                                    <li>2. El ciclo del agua</li>
                                    <li>3. Su importancia para la infancia</li>
                                </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Facilities Start -->

<!-- Class Start -->
<div class="container-fluid pt-5">
    <div class="container">
        <div class="text-center pb-2">
            <p class="section-title px-5"><span class="px-2">Mas Contenido</span></p>
            <h1 class="mb-4">Fasículos</h1>
        </div>
        <div class="row">
            <div class="col-lg-4 mb-5">
                <div class="card border-0 bg-light shadow-sm pb-2">
                    <img class="card-img-top mb-2" src="{{ asset('home/img/fasiculos/f1.png') }}" alt="">
                    <div class="card-body text-center">
                        <h4 class="card-title">Importancia del Agua</h4>
                        <p class="card-text">Debes saber, que nuestro sistema solar está compuesto por 8
                            planetas, de los cuales solo la tierra tiene abundante agua en
                            estado líquido. Y eso es lo que ha permitido que aquí, nazca y
                            florezca la vida.</p>
                    </div>
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-1.pdf') }}"
                        class="btn btn-primary px-4 mx-auto mb-4" target="_blank">Ver Más</a>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card border-0 bg-light shadow-sm pb-2">
                    <img class="card-img-top mb-2" src="{{ asset('home/img/fasiculos/f2.png') }}" alt="">
                    <div class="card-body text-center">
                        <h4 class="card-title">El Agua para Consumo Humano</h4>
                        <p class="card-text">Debemos empezar aclarando que para tener agua potable y evitar
                            la contaminación del medio ambiente, en la actualidad contamos
                            con un sistema grande que llamamos servicios de saneamiento.</p>
                    </div>
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-2.pdf') }}"
                        class="btn btn-primary px-4 mx-auto mb-4" target="_blank">Ver Más</a>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card border-0 bg-light shadow-sm pb-2">
                    <img class="card-img-top mb-2" src="{{ asset('home/img/fasiculos/f3.png') }}" alt="">
                    <div class="card-body text-center">
                        <h4 class="card-title">Otros Usos del Agua</h4>
                        <p class="card-text">Además del agua para consumo humano, existen otros usos del
                            agua. Y la actividad que más agua consume en nuestro país, es la
                            del riego de los cultivos para la producción de alimentos.</p>
                    </div>
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-3.pdf') }}"
                        class="btn btn-primary px-4 mx-auto mb-4" target="_blank">Ver Más</a>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card border-0 bg-light shadow-sm pb-2">
                    <img class="card-img-top mb-2" src="{{ asset('home/img/fasiculos/f4.png') }}" alt="">
                    <div class="card-body text-center">
                        <h4 class="card-title">Garantizando la Calidad del Agua</h4>
                        <p class="card-text">Ahora que ya sabes lo complejo que es mantener limpia el agua
                            para consumo humano, y todos los servicios de saneamiento,
                            debes saber que en nuestro país, y sobre todo en nuestra región
                            Apurímac, dichos sistemas están en proceso de deterioro.</p>
                    </div>
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-4.pdf') }}"
                        class="btn btn-primary px-4 mx-auto mb-4" target="_blank">Ver Más</a>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card border-0 bg-light shadow-sm pb-2">
                    <img class="card-img-top mb-2" src="{{ asset('home/img/fasiculos/f5.png') }}" alt="">
                    <div class="card-body text-center">
                        <h4 class="card-title">Tensiones en Torno al Agua</h4>
                        <p class="card-text">Antes de empezar, trata de calcular cuántos litros de agua
                            consumes tú diariamente. Piensa en las distintas actividades que
                            realizas desde que te levantas hasta que te vas a dormir. ¿Pudiste
                            sacar un cálculo?</p>
                    </div>
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-5.pdf') }}"
                        class="btn btn-primary px-4 mx-auto mb-4" target="_blank">Ver Más</a>
                </div>
            </div>
            <div class="col-lg-4 mb-5">
                <div class="card border-0 bg-light shadow-sm pb-2">
                    <img class="card-img-top mb-2" src="{{ asset('home/img/fasiculos/f6.png') }}" alt="">
                    <div class="card-body text-center">
                        <h4 class="card-title">El Uso Responsable del Agua</h4>
                        <p class="card-text">Hace unos años, se declaró el 22 de marzo como Día Mundial del
                            Agua. Esa fecha conmemorativa tiene el objetivo de recordar a todas
                            las personas la gran importancia que tiene el agua en nuestras
                            vidas y en general para todo el planeta.</p>
                    </div>
                    <a href="{{ asset('home/material agua/ANEXOS/fasiculos/fasciculo-6.pdf') }}"
                        class="btn btn-primary px-4 mx-auto mb-4" target="_blank">Ver Más</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Class End -->

<!-- Team Start -->
<div class="container-fluid pt-5" id="materiales">
    <div class="container">
        <div class="text-center pb-2">
            <p class="section-title px-5"><span class="px-2">Extras</span></p>
            <h1 class="mb-4">Materiales</h1>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3 text-center team mb-5">
                <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100"
                        src="{{ asset('home/img/guia-docente.png') }}" alt="">
                    <div
                        class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ asset('home/material agua/ANEXOS/guia-docente.pdf') }}" target="_blank"><i
                                class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4>Cuidando la Vida</h4>
                <i>Guia para Docentes</i>
            </div>
            <div class="col-md-6 col-lg-3 text-center team mb-5">
                <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100" src="{{ asset('home/img/videos.jpg') }}"
                        alt="">
                    <div
                        class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ route('home.gallery') }}"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4>Videos</h4>
                <i></i>
            </div>
            <div class="col-md-6 col-lg-3 text-center team mb-5">
                <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100" src="{{ asset('home/img/cuento.png') }}"
                        alt="">
                    <div
                        class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ asset('home/material agua/ANEXOS/cuento-agua.pdf') }}" target="_blank"><i
                                class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4>El Agua en Peligro</h4>
                <i>Cuento</i>
            </div>
            <div class="col-md-6 col-lg-3 text-center team mb-5">
                <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100" src="{{ asset('home/img/album.jpg') }}"
                        alt="">
                    <div
                        class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ route('home.gallery') }}"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4>Aprendiendo a Valorar y Criar Nuestra Agua</h4>
                <i>Albun Intercativo</i>
            </div>

            <div class="col-md-6 col-lg-3 text-center team mb-5">
                <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100" src="{{ asset('home/material agua/ANEXOS/rojer.png') }}"
                        alt="">
                    <div
                        class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ asset('home/material agua/ANEXOS/Roger y la Magia del Agua.pdf') }}" target="_blank"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4>Roger y la magia del agua.</h4>
                <i>Cuento</i>
            </div>
            <div class="col-md-6 col-lg-3 text-center team mb-5">
                <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100" src="{{ asset('home/material agua/ANEXOS/micole.png') }}"
                        alt="">
                    <div
                        class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ asset('home/material agua/ANEXOS/Mi Cole Con Agua Segura.pdf') }}" target="_blsnk"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4>Mi cole con Agua Segura.</h4>
                <i>Estrategia </i>
            </div>
            <div class="col-md-6 col-lg-3 text-center team mb-5">
                <div class="position-relative overflow-hidden mb-4" style="border-radius: 100%;">
                    <img style="height: 15rem" class="img-fluid w-100" src="{{ asset('home/material agua/ANEXOS/guardianes.png') }}"
                        alt="">
                    <div
                        class="team-social d-flex align-items-center justify-content-center w-100 h-100 position-absolute">
                        <a class="btn btn-outline-light text-center mr-2 px-0" style="width: 38px; height: 38px;"
                            href="{{ asset('home/material agua/ANEXOS/Los Guardianes del Agua.pdf') }}" target="_blank"><i class="fas fa-eye"></i></a>
                    </div>
                </div>
                <h4>Los Guardianes del Agua.</h4>
                <i>Cuento</i>
            </div>
        </div>
    </div>
</div>
<!-- Team End -->


<!-- Team Start -->
<div class="container-fluid pt-5">
    <div class="container">
        <div class="text-center pb-2">
            <p class="section-title px-5"><span class="px-2">Más</span></p>
            <h1 class="mb-4">Nuestros Miembros</h1>
        </div>
        <div class="row text-center mb-4">
            <a href="https://www.gob.pe/regionapurimac" class="col-md-6 col-lg-3">
                <div class="bg-light shadow-sm rounded mb-2 p-2 d-flex justify-content-center">
                    <img class="img-fluid" src="{{ asset('home/img/logo_gore.png') }}"
                        style="height: 150px; width: auto;" alt="Image">
                </div>
                <div>
                    <h4>Gobierno Regional de Apurímac</h4>
                </div>
            </a>

            <a href="https://www.diresaapurimac.gob.pe/web/" class="col-md-6 col-lg-3">
                <div class="bg-light shadow-sm rounded mb-2 p-2 d-flex justify-content-center">
                    <img class="img-fluid" src="{{ asset('home/img/logo salud.png') }}"
                        style="height: 150px; width: auto;" alt="Image">
                </div>
                <div>
                    <h4>DIRESA Apurímac</h4>
                </div>
            </a>
            <a href="https://www.gob.pe/sunass" class="col-md-6 col-lg-3">
                <div class="bg-light shadow-sm rounded mb-2 p-2 d-flex justify-content-center">
                    <img class="img-fluid" src="{{ asset('home/img/logo sunas2.jpg') }}"
                        style="height: 150px; width: auto;" alt="Image">
                </div>
                <div>
                    <h4>SUNASS</h4>
                </div>
            </a>
            <a href="https://www.gob.pe/regionapurimac-dre" class="col-md-6 col-lg-3">
                <div class="bg-light shadow-sm rounded mb-2 p-2 d-flex justify-content-center">
                    <img class="img-fluid" src="{{ asset('home/img/drea-apurimac.png') }}"
                        style="height: 150px; width: auto;" alt="Image">
                </div>
                <div>
                    <h4>DRE Apurímac</h4>
                </div>
            </a>
        </div>

        <div class="row text-center mb-4">
            <a href="https://drvcs.regionapurimac.gob.pe/" class="col-md-6 col-lg-3">
                <div class="bg-light shadow-sm rounded mb-2 p-2 d-flex justify-content-center">
                    <img class="img-fluid" src="{{ asset('home/img/logo_vivienda.jpg') }}"
                        style="height: 150px; width: auto;" alt="Image">
                </div>
                <div>
                    <h4>Direccion Regional de Vivienda y Saneamiento</h4>
                </div>
            </a>
            <a href="https://www.midis.gob.pe/fed/sobre-el-fed/el-fed" class="col-md-6 col-lg-3">
                <div class="bg-light shadow-sm rounded mb-2 p-2 d-flex justify-content-center">
                    <img class="img-fluid" src="{{ asset('home/img/FED.jpg') }}" style="height: 150px; width: auto;"
                        alt="Image">
                </div>
                <div>
                    <h4>Fondo de Estimulo al Desempeño y Logro de Resultados Sociales</h4>
                </div>
            </a>
            <a href="https://emusapabancay.com.pe/" class="col-md-6 col-lg-3">
                <div class="bg-light shadow-sm rounded mb-2 p-2 d-flex justify-content-center">
                    <img class="img-fluid" src="{{ asset('home/img/emusap2.jpg') }}"
                        style="height: 150px; width: auto;" alt="Image">
                </div>
                <div>
                    <h4>EMUSAP Abancay</h4>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- Team End -->

<!-- Testimonial Start -->
{{-- <div class="container-fluid py-5">
    <div class="container p-0">
        <div class="text-center pb-2">
            <p class="section-title px-5"><span class="px-2">Saber Mas</span></p>
            <h1 class="mb-4">Nuestros Miembros</h1>
        </div>
        <div class="owl-carousel testimonial-carousel">
            <div class="testimonial-item px-3 text-center">
                <div style="height: 5rem">
                    <h3>Gobierno Regional de Apurímac</h3>
                </div>
                <div class="bg-light shadow-sm rounded mb-2 p-2 d-flex justify-content-center">
                    <img class="img-fluid" src="{{ asset('home/img/LOGO-GORE-2023.png') }}"
                        style="height: 150px; width: auto;" alt="Image">
                </div>
            </div>
            <div class="testimonial-item px-3 text-center">
                <div style="height: 5rem">
                    <h4>Direccion Regional de Salud - Apurímac</h4>
                </div>
                <div class="bg-light shadow-sm rounded mb-2 p-2 d-flex justify-content-center">
                    <img class="img-fluid" src="{{ asset('home/img/logo salud.png') }}"
                        style="height: 150px; width: auto;" alt="Image">
                </div>
            </div>
            <div class="testimonial-item px-3 text-center">
                <div style="height: 5rem">
                    <h4>Direccion Regional de Educación - Apurímac</h4>
                </div>
                <div class="bg-light shadow-sm rounded mb-2 p-2 d-flex justify-content-center">
                    <img class="img-fluid" src="{{ asset('home/img/drea-apurimac.png') }}"
                        style="height: 150px; width: auto;" alt="Image">
                </div>
            </div>            
        </div>
    </div>
</div> --}}
<!-- Testimonial End -->

@include('home/layout/footer')
