@extends('template.layout')

@section('title', 'Nueva UGEL')

@section('generalBody')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nueva UGEL</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('index/indexadmin')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{url('ugel/getall/1')}}">UGELs</a></li>
                    <li class="breadcrumb-item active">Nueva</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-graduation-cap"></i> Información de la UGEL
                        </h3>
                    </div>
                    
                    <form action="{{url('ugel/insert')}}" method="post" id="formInsert">
                        @csrf
                        <div class="card-body">

                            <!-- Nombre de la UGEL -->
                            <div class="form-group">
                                <label for="name">
                                    <i class="fa fa-graduation-cap text-primary"></i> Nombre de la UGEL *
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       placeholder="Ejm: UGEL Abancay" 
                                       required>
                                <small class="form-text text-muted">Ingrese el nombre completo de la UGEL</small>
                            </div>

                            <!-- Código de la UGEL -->
                            <div class="form-group">
                                <label for="code">
                                    <i class="fa fa-code text-info"></i> Código de la UGEL *
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="code" 
                                       name="code" 
                                       placeholder="Ejm: UG-ABA-001" 
                                       required>
                                <small class="form-text text-muted">Código único de identificación</small>
                            </div>

                            <!-- Provincia -->
                            <div class="form-group">
                                <label for="idProvince">
                                    <i class="fa fa-globe text-success"></i> Provincia *
                                </label>
                                <select class="form-control" id="idProvince" name="idProvince" required>
                                    <option value="">Seleccione una provincia</option>
                                    @foreach($listTProvince as $province)
                                        <option value="{{$province->idProvince}}">
                                            {{$province->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Distrito -->
                            <div class="form-group">
                                <label for="idDistrict">
                                    <i class="fa fa-map text-warning"></i> Distrito *
                                </label>
                                <select class="form-control" id="idDistrict" name="idDistrict" required disabled>
                                    <option value="">Primero seleccione una provincia</option>
                                </select>
                            </div>

                            <!-- Director -->
                            <div class="form-group">
                                <label for="director">
                                    <i class="fa fa-user text-primary"></i> Director de la UGEL
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="director" 
                                       name="director" 
                                       placeholder="Ejm: Dr. Juan Pérez González">
                                <small class="form-text text-muted">Nombre del director actual</small>
                            </div>

                            <!-- Teléfono -->
                            <div class="form-group">
                                <label for="phone">
                                    <i class="fa fa-phone text-success"></i> Teléfono
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="phone" 
                                       name="phone" 
                                       placeholder="Ejm: 083-123456">
                                <small class="form-text text-muted">Número de teléfono de contacto</small>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">
                                    <i class="fa fa-envelope text-info"></i> Email
                                </label>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       placeholder="Ejm: ugel@minedu.gob.pe">
                                <small class="form-text text-muted">Correo electrónico institucional</small>
                            </div>

                            <!-- Dirección -->
                            <div class="form-group">
                                <label for="address">
                                    <i class="fa fa-map-marker text-warning"></i> Dirección
                                </label>
                                <textarea class="form-control" 
                                          id="address" 
                                          name="address" 
                                          rows="3" 
                                          placeholder="Ejm: Av. Núñez 123, Centro"></textarea>
                                <small class="form-text text-muted">Dirección completa de la UGEL</small>
                            </div>

                        </div>
                        
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{url('ugel/getall/1')}}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Cancelar
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Guardar UGEL
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('jsSection')
<script>
$(document).ready(function() {
    // Cuando cambie la provincia, cargar distritos
    $('#idProvince').change(function() {
        var idProvince = $(this).val();
        var districtSelect = $('#idDistrict');
        
        if(idProvince) {
            // Mostrar loading
            districtSelect.html('<option value="">Cargando distritos...</option>');
            districtSelect.prop('disabled', true);
            
            // Petición AJAX
            $.ajax({
                url: '{{url("ugel/getdistricts")}}',
                method: 'POST',
                data: {
                    idProvince: idProvince,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    districtSelect.html('<option value="">Seleccione un distrito</option>');
                    
                    if(response.success && response.districts.length > 0) {
                        $.each(response.districts, function(index, district) {
                            districtSelect.append('<option value="' + district.idDistrict + '">' + district.name + '</option>');
                        });
                    } else {
                        districtSelect.append('<option value="">No hay distritos disponibles</option>');
                    }
                    
                    districtSelect.prop('disabled', false);
                },
                error: function() {
                    districtSelect.html('<option value="">Error al cargar distritos</option>');
                    districtSelect.prop('disabled', false);
                    alert('Error al cargar los distritos. Inténtelo nuevamente.');
                }
            });
        } else {
            districtSelect.html('<option value="">Primero seleccione una provincia</option>');
            districtSelect.prop('disabled', true);
        }
    });
    
    // Convertir código a mayúsculas automáticamente
    $('#code').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });
});
</script>
@endsection