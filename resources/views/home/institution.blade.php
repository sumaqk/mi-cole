@include('home/layout/header')
<style>
    .list-group-item {
        background: rgba(255, 255, 255, 0.2);
        /* Fondo blanco con 20% de transparencia */
        color: rgb(44, 44, 44);
        font-size: 18px;
        font-weight: bold;
        border: none;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    }

    .list-group-item:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .province-title {
        font-size: 22px;
    }

    .collapse-icon {
        float: right;
        transition: transform 0.3s ease-in-out;
    }

    .collapsed .collapse-icon {
        transform: rotate(90deg);
    }

    .list-group {
        margin-bottom: 15px;
    }

    .card {
        background: rgba(255, 255, 255, 0.9);
        /* Tarjetas más visibles */
        text-align: center;
        font-weight: bold;
    }
</style>

<!-- Header Start -->
<div class="container-fluid bg-primary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h3 class="display-3 font-weight-bold text-white">Instituciones</h3>
        <div class="d-inline-flex text-white">
            <p class="m-0"><a class="text-white" href="">Home</a></p>
            <p class="m-0 px-2">/</p>
            <p class="m-0">Instituciones</p>
        </div>
    </div>
</div>
<!-- Header End -->


<!-- Gallery Start -->
<div class="container-fluid pt-5 pb-3">
    <div class="container">
        <div class="text-center pb-3">
            <p class="section-title px-5">
                <span class="px-3 font-weight-bold text-uppercase text-primary">Lista de</span>
            </p>
            <div class="text-center pb-3">
                <div class="d-inline-block px-4 py-2 mb-3" style="background: rgba(0, 0, 0, 0.7); border-radius: 10px;">
                    <h2 class="text-light font-weight-bold display-1 mb-0">{{ $totalInstitutions }}</h2>
                </div>
                <h1 class="mb-4 font-weight-bold">Instituciones Educativas que Participan</h1>
                <h3>en la Estrategia Regional "Mi Cole con Agua Segura"</h3>
            </div>
        </div>

        <div class="container">
            <ul class="list-group">
                @foreach ($provinces as $province)
                    <li class="list-group-item province-title collapsed" data-toggle="collapse"
                        data-target="#province{{ $province->idProvince }}">
                        <i class="fa-solid fa-plus collapse-icon"></i>
                        <h2 class="d-inline mr-2">{{ $province->name }}</h2>
                        <p class="d-inline mb-0">
                            ({{ $province->tDistrict->sum(fn($tDistrict) => $tDistrict->tInstitution->count()) }}
                            instituciones)</p>
                    </li>
                    <ul id="province{{ $province->idProvince }}" class="collapse list-group pl-4">
                        @foreach ($province->tDistrict as $district)
                            <li class="list-group-item collapsed" data-toggle="collapse"
                                data-target="#district{{ $district->idDistrict }}">
                                <i class="fa-solid fa-plus collapse-icon"></i>
                                {{ $district->name }} ({{ $district->tInstitution->count() }} instituciones)
                            </li>
                            <ul id="district{{ $district->idDistrict }}" class="collapse list-group pl-">
                                <div class="row mt-3">
                                    @foreach ($district->tInstitution as $institution)
                                        <div class="col-md-3 mb-3">
                                            <div class="card p-3 shadow-sm">
                                                I.E. {{ $institution->name }}
                                                <small>
                                                    {{ $institution->lender }}
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </ul>
                        @endforeach
                    </ul>
                @endforeach
            </ul>
        </div>

        <script>
            // Cambiar el icono de "+" a "-" cuando se expande
            $('.list-group-item').on('click', function() {
                $(this).find('.collapse-icon').toggleClass('fa-plus fa-minus');
            });
        </script>

    </div>
</div>


@include('home/layout/footer')
