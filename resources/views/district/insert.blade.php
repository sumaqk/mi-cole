@extends('template.layout')
@section('title', 'Nuevo Distrito')

@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Crear Nuevo Distrito</h3>
                    </div>
                    
                    <form action="{{url('district/insert')}}" method="post">
                        {{csrf_field()}}
                        
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nombre del Distrito <span style="color: red;">*</span></label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="name" 
                                               name="name" 
                                               value="{{old('name')}}" 
                                               required 
                                               autofocus
                                               placeholder="Ingrese el nombre del distrito">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idProvince">Provincia <span style="color: red;">*</span></label>
                                        <select class="form-control" id="idProvince" name="idProvince" required>
                                            <option value="">Seleccione una provincia...</option>
                                            @foreach($listTProvince as $province)
                                                <option value="{{$province->idProvince}}" {{old('idProvince') == $province->idProvince ? 'selected' : ''}}>
                                                    {{$province->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code">Código (Opcional)</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="code" 
                                               name="code" 
                                               value="{{old('code')}}"
                                               placeholder="Código del distrito (opcional)">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Crear Distrito
                                    </button>
                                    <a href="{{url('district/getall/1')}}" class="btn btn-default">
                                        <i class="fa fa-arrow-left"></i> Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
