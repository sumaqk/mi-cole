@extends('template.layout')

@section('title', 'Editar UGEL')

@section('generalBody')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Editar UGEL</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('index/indexadmin')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{url('ugel/getall/1')}}">UGELs</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-edit"></i> Editar UGEL: {{ $ugel->name ?? 'N/A' }}
                        </h3>
                    </div>
                    
                    <form action="{{url('ugel/update/' . ($ugel->idUgel ?? ''))}}" method="post" id="formUpdate">
                        @csrf
                        <div class="card-body">
                            
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            
                            <div class="form-group">
                                <label for="name">
                                    <i class="fa fa-graduation-cap text-primary"></i> Nombre de la UGEL *
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $ugel->name ?? '') }}"
                                       required>
                                <small class="form-text text-muted">Ingrese el nombre completo de la UGEL</small>
                            </div>

                            <div class="form-group">
                                <label for="code">
                                    <i class="fa fa-barcode text-primary"></i> Código de la UGEL *
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="code" 
                                       name="code" 
                                       value="{{ old('code', $ugel->code ?? '') }}" 
                                       required>
                                <small class="form-text text-muted">
                                    Ingrese el código de la UGEL
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="idProvince">
                                    <i class="fa fa-map-marker text-primary"></i> Provincia *
                                </label>
                                <select class="form-control" id="idProvince" name="idProvince" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($listTProvince as $province)
                                        <option value="{{ $province->idProvince }}" 
                                                {{ old('idProvince', $ugel->idProvince ?? '') == $province->idProvince ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="idDistrict">
                                    <i class="fa fa-map-marker text-primary"></i> Distrito *
                                </label>
                                <select class="form-control" id="idDistrict" name="idDistrict" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($listTDistrict as $district)
                                        <option value="{{ $district->idDistrict }}" 
                                                data-province="{{ $district->idProvince }}"
                                                {{ old('idDistrict', $ugel->idDistrict ?? '') == $district->idDistrict ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="address">
                                    <i class="fa fa-home text-primary"></i> Dirección
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="address" 
                                       name="address" 
                                       value="{{ old('address', $ugel->address ?? '') }}">
                                <small class="form-text text-muted">
                                    Ejemplo: Av. Principal 123, Urb. Centro
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="phone">
                                    <i class="fa fa-phone text-primary"></i> Teléfono
                                </label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $ugel->phone ?? '') }}">
                                <small class="form-text text-muted">
                                    Ejemplo: 987654321
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="email">
                                    <i class="fa fa-envelope text-primary"></i> Email
                                </label>
                                <input type="email" 
                                       class="form-control" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $ugel->email ?? '') }}">
                                <small class="form-text text-muted">
                                    Ejemplo: ugel@gmail.com
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="director">
                                    <i class="fa fa-user text-primary"></i> Director
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="director" 
                                       name="director" 
                                       value="{{ old('director', $ugel->director ?? '') }}">
                                <small class="form-text text-muted">
                                    Ejemplo: Juan Pérez
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="is_active">
                                    <i class="fa fa-toggle-on text-primary"></i> Estado
                                </label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="1" {{ old('is_active', $ugel->is_active ?? '') == '1' ? 'selected' : '' }}>
                                        Activo
                                    </option>
                                    <option value="0" {{ old('is_active', $ugel->is_active ?? '') == '0' ? 'selected' : '' }}>
                                        Inactivo
                                    </option>
                                </select>
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
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fa fa-save"></i> Actualizar UGEL
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
    $('#idProvince').change(function() {
        var selectedProvince = $(this).val();
        var districtSelect = $('#idDistrict');
        
        districtSelect.val('');
        
        districtSelect.find('option').each(function() {
            var option = $(this);
            var optionProvince = option.data('province');
            
            if (option.val() === '' || optionProvince == selectedProvince) {
                option.show();
            } else {
                option.hide();
            }
        });
    });
    

    $('#idProvince').trigger('change');
    
    $('#code').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });
    

    $('#formUpdate').submit(function(e) {
        var name = $('#name').val().trim();
        var code = $('#code').val().trim();
        var idProvince = $('#idProvince').val();
        var idDistrict = $('#idDistrict').val();
        
        if(name === '') {
            alert('El nombre de la UGEL es requerido');
            $('#name').focus();
            e.preventDefault();
            return false;
        }
        
        if(code === '') {
            alert('El código de la UGEL es requerido');
            $('#code').focus();
            e.preventDefault();
            return false;
        }
        
        if(idProvince === '') {
            alert('La provincia es requerida');
            $('#idProvince').focus();
            e.preventDefault();
            return false;
        }
        
        if(idDistrict === '') {
            alert('El distrito es requerido');
            $('#idDistrict').focus();
            e.preventDefault();
            return false;
        }
        
        if(!confirm('¿Está seguro de actualizar esta UGEL?')) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endsection