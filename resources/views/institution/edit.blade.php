@extends('template.layout')
@section('title', 'Editar Institución')

@section('generalBody')
<div class="nav-tabs-custom">
    <div class="tab-content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar Institución</h3>
                    </div>
                    
                    <form action="{{url('institution/update/' . $institution->idInstitution)}}" method="post">
                        {{csrf_field()}}
                        
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nombre de la Institución <span style="color: red;">*</span></label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="name" 
                                               name="name" 
                                               value="{{$institution->name}}" 
                                               required 
                                               autofocus>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lender">Tipo de Entidad <span style="color: red;">*</span></label>
                                        <select class="form-control" id="lender" name="lender" required>
                                            <option value="">Seleccione...</option>
                                            <option value="EPS" {{$institution->lender == 'EPS' ? 'selected' : ''}}>EPS</option>
                                            <option value="UGM Municipal" {{$institution->lender == 'UGM Municipal' ? 'selected' : ''}}>UGM Municipal</option>
                                            <option value="Municipalidad distrital de Pachaconas" {{$institution->lender == 'Municipalidad distrital de Pachaconas' ? 'selected' : ''}}>Municipalidad distrital de Pachaconas</option>
                                            <option value="Jass" {{$institution->lender == 'Jass' ? 'selected' : ''}}>Jass</option>
                                            <option value="Asusap" {{$institution->lender == 'Asusap' ? 'selected' : ''}}>Asusap</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idProvince">Provincia <span style="color: red;">*</span></label>
                                        <select class="form-control" id="idProvince" name="idProvince" required>
                                            <option value="">Seleccione una provincia...</option>
                                            @foreach($listTDistrict->groupBy('tprovince.idProvince') as $provinceId => $districts)
                                                <option value="{{$provinceId}}" {{$institution->tdistrict->tprovince->idProvince == $provinceId ? 'selected' : ''}}>
                                                    {{$districts->first()->tprovince->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idDistrict">Distrito <span style="color: red;">*</span></label>
                                        <select class="form-control" id="idDistrict" name="idDistrict" required>
                                            <option value="">Seleccione un distrito...</option>
                                            @foreach($listTDistrict as $district)
                                                <option value="{{$district->idDistrict}}" 
                                                        data-province="{{$district->tprovince->idProvince}}"
                                                        {{$institution->idDistrict == $district->idDistrict ? 'selected' : ''}}>
                                                    {{$district->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="idUgel">UGEL (Opcional)</label>
                                        <select class="form-control" id="idUgel" name="idUgel">
                                            <option value="">Sin UGEL</option>
                                            @foreach($listTUgel as $ugel)
                                                <option value="{{$ugel->idUgel}}" {{$institution->idUgel == $ugel->idUgel ? 'selected' : ''}}>
                                                    {{$ugel->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Actualizar Institución
                                    </button>
                                    <a href="{{url('institution/getall/1')}}" class="btn btn-default">
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
});
</script>
@endsection