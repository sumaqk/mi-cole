@extends('template.layout')

@section('title', 'Nueva Institución')

@section('generalBody')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nueva Institución</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{url('index/indexadmin')}}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{url('institution/getall/1')}}">Instituciones</a></li>
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
                            <i class="fa fa-university"></i> Información de la Institución
                        </h3>
                    </div>
                    
                    <form action="{{url('institution/insert')}}" method="post" id="formInsert">
                        @csrf
                        <div class="card-body">
                            
                            <div class="form-group">
                                <label for="name">
                                    <i class="fa fa-institution text-primary"></i> Nombre de la Institución *
                                </label>
                                <input type="text" 
                                       class="form-control" 
                                       id="name" 
                                       name="name" 
                                       placeholder="Ingrese la Institución..." 
                                       value="{{ old('name') }}"
                                       required>
                                <small class="form-text text-muted">Ingrese el nombre completo de la institución</small>
                            </div>

                            <div class="form-group">
                                <label for="lender">
                                    <i class="fa fa-building text-warning"></i> Tipo de Entidad *
                                </label>
                                <select class="form-control" id="lender" name="lender" required>
                                    <option value="">Seleccione el tipo de entidad</option>
                                    <option value="Jass Callebamba" {{ old('lender') == 'Jass Callebamba' ? 'selected' : '' }}>JASS</option>
                                    <option value="UGM Municipal" {{ old('lender') == 'UGM Municipal' ? 'selected' : '' }}>UGM Municipal</option>
                                    <option value="EPS Emusap Abancay" {{ old('lender') == 'EPS Emusap Abancay' ? 'selected' : '' }}>EPS</option>
                                    <option value="Municipalidad distrital de Huaquirca" {{ old('lender') == 'Municipalidad distrital de Huaquirca' ? 'selected' : '' }}>Municipalidad Distrital</option>
                                    <option value="Jass Huancabamba" {{ old('lender') == 'Jass Huancabamba' ? 'selected' : '' }}>JASS Local</option>
                                </select>
                                <small class="form-text text-muted">Seleccione el prestador</small>
                            </div>

                            <div class="form-group">
                                <label for="idDistrict">
                                    <i class="fa fa-map text-warning"></i> Distrito *
                                </label>
                                <select class="form-control" id="idDistrict" name="idDistrict" required>
                                    <option value="">Seleccione un distrito</option>
                                    @foreach($listTDistrict as $district)
                                        <option value="{{$district->idDistrict}}" {{ old('idDistrict') == $district->idDistrict ? 'selected' : '' }}>
                                            {{$district->name}} - {{$district->tprovince->name ?? ''}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="idUgel">
                                    <i class="fa fa-graduation-cap text-info"></i> UGEL
                                </label>
                                <select class="form-control" id="idUgel" name="idUgel">
                                    <option value="">Seleccione una UGEL (opcional)</option>
                                    @foreach($listTUgel as $ugel)
                                        <option value="{{$ugel->idUgel}}" {{ old('idUgel') == $ugel->idUgel ? 'selected' : '' }}>
                                            {{$ugel->name}}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Seleccione la UGEL correspondiente (opcional)</small>
                            </div>

                        </div>
                        
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{url('institution/getall/1')}}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Cancelar
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Guardar Institución
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
    
    $('#formInsert').submit(function(e) {
        var name = $('#name').val().trim();
        var lender = $('#lender').val();
        var idDistrict = $('#idDistrict').val();
        
        if(name === '') {
            alert('El nombre de la institución es requerido');
            $('#name').focus();
            e.preventDefault();
            return false;
        }
        
        if(lender === '') {
            alert('El tipo de entidad es requerido');
            $('#lender').focus();
            e.preventDefault();
            return false;
        }
        
        if(idDistrict === '') {
            alert('Debe seleccionar un distrito');
            $('#idDistrict').focus();
            e.preventDefault();
            return false;
        }

        if(!confirm('¿Está seguro de crear esta institución?')) {
            e.preventDefault();
            return false;
        }
        
        return true;
    });
});
</script>
@endsection