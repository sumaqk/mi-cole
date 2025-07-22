@extends('template.layoutpublic')
@section('cssSection')
<link rel="stylesheet" href="{{asset('viewResources/water/insert.css')}}">
@endsection
@section('generalBody')
    <div class="paddingLayoutBodyInternal gradient-div">
        <div class="div-title">
            <h1>Sistema Regional de Registro de Cloro</h1>
            <br>
        </div>
        <div class="row">
            <form id="frmInsertWater" action="{{url('water/insert')}}" method="post" enctype="multipart/form-data">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="box box-solid box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Informacion de la Institución</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="txtInstitution">Institución*</label>
                                    <div class="input-group readonly">
                                        <div class="input-group-addon">
                                            <i class="fa fa-bank"></i>
                                        </div>
                                        <input type="text" id="txtInstitution" name="txtInstitution"
                                            class="form-control pull-right"
                                            value="{{ $tUser->tinstitutiontuser[0]->tinstitution->name }}"
                                            readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="txtLender">Prestador*</label>
                                    <div class="input-group readonly">
                                        <div class="input-group-addon">
                                            <i class="fa fa-building-o"></i>
                                        </div>
                                        <input type="text" id="txtLender" name="txtLender"
                                            class="form-control pull-right"
                                            value="{{ $tUser->tinstitutiontuser[0]->tinstitution->lender }}"
                                            readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtWeek">Periodo*</label>
                                    <div class="input-group readonly">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="txtWeek" name="txtWeek" class="form-control pull-right"
                                            value="{{ $currentMonth }} - Semana {{ $currentWeek }}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtDate">Fecha*</label>
                                    <div class="input-group readonly">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar-check-o"></i>
                                        </div>
                                        <input type="text" id="txtDate" name="txtDate" class="form-control pull-right"
                                            value="{{ $currentDate }}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="txtProvince">Provincia*</label>
                                    <div class="input-group readonly">
                                        <div class="input-group-addon">
                                            <i class="fa fa-map-o"></i>
                                        </div>
                                        <input type="text" id="txtProvince" name="txtProvince"
                                            class="form-control pull-right"
                                            value="{{ $tUser->tinstitutiontuser[0]->tinstitution->tdistrict->tprovince->name }}"
                                            readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="txtDistrict">Distrito*</label>
                                    <div class="input-group readonly">
                                        <div class="input-group-addon">
                                            <i class="fa fa-map"></i>
                                        </div>
                                        <input type="text" id="txtDistrict" name="txtDistrict"
                                            class="form-control pull-right"
                                            value="{{ $tUser->tinstitutiontuser[0]->tinstitution->tdistrict->name }}"
                                            readonly="readonly">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="box box-solid box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Resultado</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-7">
                                    <h3>Ingresa el resultado de la medicion:</h3>
                                </div>
                                <div class="form-group col-md-5">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-area-chart"></i>
                                        </div>
                                        <input type="text" id="txtResult" name="txtResult"
                                            class="form-control pull-right" placeholder="Valores entre 0 y 1">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <h3>Subir hasta 3 Fotos <small>(<strong>Recomendaciones:</strong>medicion, lavaderos,
                                            tanques de
                                            agua, cocina, sshh)</small></h3>
                                </div>
                                <div class="form-group col-md-12">
                                    <input 
                                        name="images[]"                               
                                        type="file" 
                                        id="imageUpload" 
                                        class="form-control" 
                                        accept="image/*" 
                                        multiple 
                                        onchange="handleImageSelection(this)">
                                    <p class="help-block">Puedes subir imágenes una por una o varias a la vez (máximo 3).
                                    </p>
                                </div>
                                <div id="imagePreview" class="form-group col-md-12 row"></div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 pull-right">
                                    <label for="">&nbsp;</label>
                                    {!! csrf_field() !!}
                                    <input type="button" class="btn btn-primary btn-block"
                                        value="Registrar datos ingresados" onclick="sendFrmInsertWater();">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="box box-solid box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Seguimiento</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-md-8">
                            <div class="chart" style="margin-top: 15px;">
                                <canvas id="barChart" style="height: 300px;"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    @if ($listDataToGraphic[count($listDataToGraphic) - 1] >= 0.5)
                                        <div class="info-box bg-green">
                                            <span class="info-box-icon"><i class="fa fa-check-circle-o"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Felicidades</span>
                                                <span class="info-box-number">Calidad del Agua Buena.</span>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($listDataToGraphic[count($listDataToGraphic) - 1] < 0.5)
                                        <div class="info-box bg-red">
                                            <span class="info-box-icon"><i class="fa fa-warning"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Advertencia</span>
                                                <span class="info-box-number">Calidad del Agua muy Mala. Reportar a un
                                                    docente o director</span>
                                            </div>
                                        </div>
                                    @endif
                                    <br>
                                    <div class="info-box">                                        
                                        <span class="info-box-icon bg-aqua"><i class="fa fa-bookmark"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">¡Reuerda!</span>
                                            <span class="info-box-number">Revisar periodicamente los niveles de cloro en tu
                                                Institucion Educativa</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@section('jsSection')
    <script>
        var labelsGraphic = '{{ implode(',', $listMonthToGraphic) }}';
        var dataGraphic = '{{ implode(',', $listDataToGraphic) }}';
    </script>
    <script src="{{ asset('viewResources/water/insert.js?x=' . config('var.CACHE_LAST_UPDATE')) }}"></script>
@endsection
