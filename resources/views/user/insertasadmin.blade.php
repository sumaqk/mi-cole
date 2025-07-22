@extends('template.layout')
@section('title', 'Registrar usuario')
@section('generalBody')
    <div class="nav-tabs-custom">
        <div class="tab-content">
            <form id="frmInsertAsAdminUser" action="{{ url('user/insertasadmin') }}" method="post"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="txtFirstName">Nombre*</label>
                        <input type="text" id="txtFirstName" name="txtFirstName" class="form-control"
                            value="{{ old('txtFirstName') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtSurName">Apellido*</label>
                        <input type="text" id="txtSurName" name="txtSurName" class="form-control"
                            value="{{ old('txtSurName') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="txtEmail">Correo electrónico*</label>
                        <input type="text" id="txtEmail" name="txtEmail" class="form-control"
                            value="{{ old('txtEmail') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="passPassword">Contraseña*</label>
                        <input type="password" id="passPassword" name="passPassword" class="form-control"
                            value="{{ old('passPassword') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="passRetypePassword">Repita contraseña*</label>
                        <input type="password" id="passRetypePassword" name="passRetypePassword" class="form-control"
                            value="{{ old('passRetypePassword') }}">
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-3">
                        <label for="selectRole">Rol</label>
                        <select id="selectRole" name="selectRole[]" class="form-control selectStatic" multiple
                            style="width: 100%;">
                            <option value="Administrador">Administrador</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Normal">Normal</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="selectLevel">Nivel</label>
                        <select id="selectLevel" name="selectLevel" class="form-control" disabled>
                            <option value="">Seleccione una opcion</option>
                            <option value="levelDistrit">Distrital</option>
                            <option value="levelProvince">Provincial</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="selectProvince">Provincia</label>
                        <select id="selectProvince" name="selectProvince" class="form-control" disabled>
                            <option value="">Seleccione una provincia</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->idProvince }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="selectDistrict">Distrito</label>
                        <select id="selectDistrict" name="selectDistrict" class="form-control" disabled>
                            <option value="">Seleccione un distrito</option>
                        </select>
                    </div>
                </div>

                <hr>
                <div class="row">
                    {!! csrf_field() !!}
                    <div class="form-group col-md-12 text-right">
                        <input type="button" class="btn btn-primary" value="Registrar datos ingresados"
                            onclick="sendFrmInsertAsAdminUser();">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('jsSection')
    <script src="{{ asset('viewResources/user/insertasadmin.js?x=' . config('var.CACHE_LAST_UPDATE')) }}"></script>

    <script>
        $(document).ready(function() {
            // Evento cuando el select de rol cambia
            $('#selectRole').change(function() {
                // Verificar si el rol de Supervisor está seleccionado
                if ($(this).val().includes('Supervisor')) {
                    $('#selectLevel').prop('disabled', false); // Habilitar select de nivel
                } else {
                    // Si no es Supervisor, deshabilitar y limpiar nivel, provincia y distrito
                    $('#selectLevel, #selectProvince, #selectDistrict').prop('disabled', true).val(null);
                }
            });

            // Evento cuando el select de nivel cambia
            $('#selectLevel').change(function() {
                var selectedLevel = $(this).val(); // Obtener el nivel seleccionado

                if (selectedLevel.includes('levelProvince')) {
                    // Si se selecciona Provincia
                    $('#selectProvince').prop('disabled', false); // Habilitar provincia
                    $('#selectDistrict').prop('disabled', true).val(null); // Deshabilitar distrito y limpiar su valor
                } else if (selectedLevel.includes('levelDistrit')) {
                    // Si se selecciona Distrito
                    $('#selectProvince').prop('disabled', false); // Habilitar provincia
                    $('#selectDistrict').prop('disabled', true).val(
                        null); // Deshabilitar distrito inicialmente

                    // Evento cuando el select de provincia cambia
                    $('#selectProvince').change(function() {
                        var provinceId = $(this)
                            .val(); // Obtener el ID de la provincia seleccionada

                        if (provinceId) {
                            // Hacer la llamada AJAX para obtener distritos solo si hay una provincia seleccionada
                            $.ajax({
                                url: '{{ route('getDistricts') }}', // URL de la ruta creada
                                type: 'GET',
                                data: {
                                    idProvince: provinceId
                                },
                                success: function(data) {
                                    $('#selectDistrict')
                                        .empty(); // Limpiar el select de distritos

                                    // Agregar los nuevos distritos
                                    $.each(data, function(key, district) {
                                        $('#selectDistrict').append(
                                            '<option value="' + district
                                            .idDistrict + '">' + district
                                            .name + '</option>');
                                    });

                                    $('#selectDistrict').prop('disabled',
                                        false); // Habilitar el select de distritos
                                },
                                error: function(xhr, status, error) {
                                    console.log('Error:', error); // Manejar errores
                                }
                            });
                        } else {
                            $('#selectDistrict').empty().prop('disabled',
                                true); // Deshabilitar el select si no hay provincia seleccionada
                        }
                    });
                } else {
                    // Si no se selecciona nada o se selecciona un nivel que no sea Distrito o Provincia
                    $('#selectProvince, #selectDistrict').prop('disabled', true).val(
                        null); // Deshabilitar ambos
                }
            });
        });
    </script>

@endsection
