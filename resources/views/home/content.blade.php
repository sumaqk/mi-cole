@include('home/layout/header')
<!-- Header Start -->
<div class="container-fluid bg-primary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h3 class="display-3 font-weight-bold text-white">Contenido</h3>
        <div class="d-inline-flex text-white">
            <p class="m-0"><a class="text-white" href="">Home</a></p>
            <p class="m-0 px-2">/</p>
            <p class="m-0">Contenido</p>
        </div>
    </div>
</div>
<!-- Header End -->


<!-- Class Start -->
<div class="container-fluid pt-5">
    <div class="container">
        <div class="text-center pb-2">
            <p class="section-title px-5"><span class="px-2">Nuestro Contenido</span></p>
            <h1 class="mb-4">Importancia del Agua</h1>
        </div>
        <div class="row">
            @foreach ($contents as $content)
                @if ($content->item == 1)
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="{{ asset('home/img/about-5.jpg') }}" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">{{ $content->title }}</h4>
                                <p class="card-text">{{ $content->description }}</p>
                            </div>
                            <a href="{{ route('home.content_detail', $content->id ) }}" class="btn btn-primary px-4 mx-auto mb-4"
                               >Ver Más</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="container">
        <div class="text-center pb-2">
            <h1 class="mb-4">El Agua para Consumo Humano</h1>
        </div>
        <div class="row">
            @foreach ($contents as $content)
                @if ($content->item == 2)
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="{{ asset('home/img/about-5.jpg') }}" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">{{ $content->title }}</h4>
                                <p class="card-text">{{ $content->description }}</p>
                            </div>
                            <a href="{{ route('home.content_detail', $content->id ) }}" class="btn btn-primary px-4 mx-auto mb-4"
                               >Ver Más</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="container">
        <div class="text-center pb-2">
            <h1 class="mb-4">Otros Usos del Agua</h1>
        </div>
        <div class="row">
            @foreach ($contents as $content)
                @if ($content->item == 3)
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="{{ asset('home/img/about-5.jpg') }}" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">{{ $content->title }}</h4>
                                <p class="card-text">{{ $content->description }}</p>
                            </div>
                            <a href="{{ route('home.content_detail', $content->id ) }}" class="btn btn-primary px-4 mx-auto mb-4"
                               >Ver Más</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="container">
        <div class="text-center pb-2">
            <h1 class="mb-4">Garantizando la Calidad del Agua</h1>
        </div>
        <div class="row">
            @foreach ($contents as $content)
                @if ($content->item == 4)
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="{{ asset('home/img/about-5.jpg') }}" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">{{ $content->title }}</h4>
                                <p class="card-text">{{ $content->description }}</p>
                            </div>
                            <a href="{{ route('home.content_detail', $content->id ) }}" class="btn btn-primary px-4 mx-auto mb-4"
                               >Ver Más</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="container">
        <div class="text-center pb-2">
            <h1 class="mb-4">Tensiones en Torno al Agua</h1>
        </div>
        <div class="row">
            @foreach ($contents as $content)
                @if ($content->item == 5)
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="{{ asset('home/img/about-5.jpg') }}" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">{{ $content->title }}</h4>
                                <p class="card-text">{{ $content->description }}</p>
                            </div>
                            <a href="{{ route('home.content_detail', $content->id ) }}" class="btn btn-primary px-4 mx-auto mb-4"
                               >Ver Más</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="container">
        <div class="text-center pb-2">
            <h1 class="mb-4">El Uso Responsable del Agua</h1>
        </div>
        <div class="row">
            @foreach ($contents as $content)
                @if ($content->item == 6)
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="{{ asset('home/img/about-5.jpg') }}" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">{{ $content->title }}</h4>
                                <p class="card-text">{{ $content->description }}</p>
                            </div>
                            <a href="{{ route('home.content_detail', $content->id ) }}" class="btn btn-primary px-4 mx-auto mb-4"
                               >Ver Más</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
<!-- Class End -->

@include('home/layout/footer')
