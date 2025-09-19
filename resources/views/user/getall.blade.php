@extends('template.layout')
@section('title', 'Lista de usuarios')
@section('generalBody')
<div class="nav-tabs-custom">
	<div class="tab-content">
		<div id="divSearch" class="row">
			<div class="col-md-6">
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-search"></i>
					</div>
					<input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" autofocus onkeyup="searchUser(this.value, '{{url('user/getall/1')}}', event);" value="{{$searchParameter}}">
				</div>
			</div>
			<div class="col-md-3">
				<a href="{{url('user/export')}}" class="btn btn-success btn-sm" style="margin-right: 5px;" title="Exportar todos los usuarios">
					<i class="fa fa-file-excel-o"></i> Exportar Excel
				</a>
				{{-- <a href="{{url('user/export')}}?searchParameter={{$searchParameter}}" class="btn btn-info btn-sm" title="Exportar usuarios filtrados">
					<i class="fa fa-download"></i> Filtrado
				</a> --}}
			</div>
			<div class="col-md-5">
				{!!ViewHelper::renderPagination('user/getall', $quantityPage, $currentPage, $searchParameter)!!}
			</div>
			
			<div class="col-md-1 text-center">
				<span class="btn btn-default btn-sm glyphicon glyphicon-trash verticalAlignMiddle" data-toggle="tooltip" data-placement="bottom" title="Eliminar usuarios no confirmados" onclick="_globalFunction.clickLink('{{url('user/deleteinactive')}}')" style="width: 100%;"></span>
			</div>
		</div>
		<hr>
		<div class="row">
			@foreach($listTUser as $item)
				<div class="col-md-3">
					<div class="cardOurInfo">
						<div>
							<div class="cardOurInfoName cursorPointer" onclick="if(typeof abrirVentanaChat=='function'){ abrirVentanaChat('{{$item->idUser}}', '{{addslashes(strlen($item->firstName.' '.$item->surName)>15 ? mb_substr($item->firstName.' '.$item->surName, 0, 12).'...' : $item->firstName.' '.$item->surName)}}', true, true);abrirVentanaChatTodos('{{$item->idUser}}', '{{addslashes(strlen($item->firstName.' '.$item->surName)>15 ? mb_substr($item->firstName.' '.$item->surName, 0, 12).'...' : $item->firstName.' '.$item->surName)}}', true, true); }">
								{{$item->firstName.' '.$item->surName}}
							</div>
							<span>{{$item->registerType}}</span>
							<div>
								<a href="mailto:{{$item->email}}?Subject=Contacto%20{{str_replace(' ', '%20', config('var.PLATFORM_NAME'))}}" target="_top"> {{$item->email}}</a>
							</div>
							<div>
								<small>Acceso: {{ViewHelper::getDateFormat($item->lastAccess)}}</small>&nbsp;
								<span class="{{$item->status=='Activo' ? 'label label-info' : ($item->status=='Pendiente' ? 'label label-warning' : 'label label-danger')}}" style="width: 120px;">{{$item->status}}</span>
								<div class="cardOurInfoAction">
									<a href="#" onclick="_globalFunction.clickLink('{{url('user/editasadmin/'.$item->idUser)}}');" class="btn btn-default btn-xs glyphicon glyphicon-pencil" data-toggle="tooltip" data-placement="right" title="Editar"></a>
									<a href="#" onclick="deleteUserConfirm('{{$item->idUser}}', '{{addslashes($item->firstName.' '.$item->surName)}}');" class="btn btn-danger btn-xs glyphicon glyphicon-trash" data-toggle="tooltip" data-placement="right" title="Eliminar" style="margin-left: 3px;"></a>
								</div>
							</div>					
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Confirmar eliminación</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de eliminar al usuario <strong id="deleteUserName"></strong>?</p>
                <p><small class="text-warning">Esta acción no se puede deshacer y solo es posible si el usuario no tiene registros de agua.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Sí, eliminar</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('jsSection')
<script src="{{asset('viewResources/user/getall.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
<script>
function deleteUserConfirm(idUser, fullName) {
    $('#deleteUserModal').modal('show');
    $('#deleteUserName').text(fullName);
    $('#confirmDeleteBtn').off('click').on('click', function() {
        $('#deleteUserModal').modal('hide');
        window.location.href = '{{url("user/delete")}}/' + idUser;
    });
}
</script>
@endsection