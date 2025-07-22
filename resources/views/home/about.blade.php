@include('home/layout/header')
<!-- Header Start -->
<div class="container-fluid bg-primary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h3 class="display-3 font-weight-bold text-white">Quienes somos</h3>
        <div class="d-inline-flex text-white">
            <p class="m-0"><a class="text-white" href="">Home</a></p>
            <p class="m-0 px-2">/</p>
            <p class="m-0">Sobre Nosotros</p>
        </div>
    </div>
</div>
<!-- Header End -->


<!-- About Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <img class="img-fluid rounded mb-5 mb-lg-0" style="width: 95%" src="{{ asset('home/img/about.jpeg') }}"
                    alt="">
            </div>
            <div class="col-lg-7">
                <p class="section-title pr-5"><span class="pr-2">Mi Cole</span></p>
                <h1 class="mb-4">Con Agua Segura</h1>
                <p style="font-size: 23px; text-align: justify;">Este sistema tiene como objetivo garantizar la
                    valoración y el consumo de agua segura en las instituciones educativas priorizadas, así como reducir
                    los índices de anemia.
                    Permite a los estudiantes medir y registrar los niveles de cloro en el agua de sus instituciones
                    utilizando instrumentos proporcionados por el programa. Al fomentar la participación activa de los
                    estudiantes en el monitoreo de la calidad del agua, se desarrollan habilidades científicas y una
                    mayor conciencia sobre la importancia de la salud pública. Entre los beneficios del sistema, destaca
                    la capacidad de asegurar que el agua consumida en las escuelas sea segura, lo que ayuda a prevenir
                    enfermedades relacionadas con el consumo de agua contaminada y contribuye a un entorno más
                    saludable. Además, esta iniciativa fortalece el sentido de responsabilidad comunitaria en los
                    estudiantes, apoyando así la mejora de la salud en sus comunidades.</p>
            </div>

            <div class="col-lg-12">
                <div class="d-flex flex-column text-left mb-3">
                    <p class="section-title pr-5"><span class="pr-2">Sistema Regional de Registro de Cloro</span></p>
                    <h1 class="mb-3">Estrategia</h1>
                </div>
                <div class="mb-5">
                    <img class="img-fluid rounded w-100 mb-4" src="{{ asset('home/img/about-5.jpeg') }}" alt="Image">
                    <p style="font-size: 20px; text-align: justify;">La estrategia se centra en tres pilares
                        fundamentales: capacitaciones,
                        donación de equipos y registro digital, con el objetivo de mejorar la calidad del agua en las
                        instituciones educativas.
                    </p>

                    <p style="font-size: 20px; text-align: justify;">
                        <strong>Capacitaciones:</strong> Se llevarán a cabo talleres y sesiones formativas para
                        estudiantes y personal
                        docente, donde se les instruirá sobre la importancia de la calidad del agua, los métodos de
                        medición y el uso adecuado de los equipos. Estas capacitaciones no solo proporcionan
                        conocimientos técnicos, sino que también fomentan una cultura de cuidado y responsabilidad hacia
                        el ambiente.
                    </p>
                    <img class="img-fluid rounded w-50 float-left mr-4 mb-3" src="{{ asset('home/img/about-8.jpeg') }}"
                        alt="Image">
                    <p style="font-size: 20px; text-align: justify;">
                        <strong>Donación de Equipos: </strong> Se realizará
                        la donación de
                        instrumentos de medición de calidad del agua a las instituciones educativas priorizadas. Estos
                        equipos permitirán a los estudiantes realizar mediciones precisas y constantes de los niveles de
                        cloro y otros contaminantes, asegurando así que el agua que consumen sea segura.
                    </p>

                    <p style="font-size: 20px; text-align: justify;">
                        <strong>Registro Digital: </strong>Se implementará un sistema de registro digital que permitirá
                        a los estudiantes registrar y analizar los datos obtenidos de las mediciones. Esta plataforma no
                        solo facilitará
                        el seguimiento de la calidad del agua a lo largo del tiempo, sino que también servirá como una
                        herramienta educativa donde los estudiantes podrán visualizar y comprender mejor los resultados
                        de sus monitoreos.
                    </p>

                    <p style="font-size: 20px; text-align: justify;">
                        A través de esta estrategia integral, se busca empoderar a los estudiantes, mejorar la salud
                        pública y crear un entorno más seguro y saludable en las instituciones educativas.
                    </p>

                    <h1 class="mb-3">La RUTA DEL AGUA</h1>
                    <img class="img-fluid rounded w-50 float-right ml-4 mb-3" src="{{ asset('home/img/about-9.jpeg') }}"
                        alt="Image">
                    <p style="font-size: 20px; text-align: justify;">Esta experiencia permite a los estudiantes conocer el recorrido del agua
                        desde su origen hasta llegar a nuestras casas y colegios. A través de visitas y actividades
                        prácticas, los estudiantes aprenderán sobre las fuentes de agua, los procesos de tratamiento y
                        distribución, así como el destino final del agua que consumen. Además, se les enseñará sobre las
                        condiciones en que el agua termina su recorrido, lo que les ayudará a entender la importancia de
                        la conservación y el cuidado del recurso hídrico.

                        A través de esta estrategia integral, se busca empoderar a los estudiantes, mejorar la salud
                        pública y crear un entorno más seguro y saludable en las instituciones educativas.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About End -->

@include('home/layout/footer')
