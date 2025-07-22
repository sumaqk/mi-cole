@extends('template.layout')
@section('title', 'Lista de excepciones')
@section('generalBody')
<div class="nav-tabs-custom">
	<div class="tab-content">
		<div id="divSearch" class="row">
			<div class="col-md-12">
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-search"></i>
					</div>
					<input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" autofocus onkeyup="filterContent('tableException', this.value, false, 0, event);">
				</div>
			</div>
		</div>
		<hr>
		<div class="table-responsive">
			<table id="tableException" class="table table-striped table-bordered" style="min-width: 777px;">
				<thead>
					<tr>
						<th>Sesión de usuario</th>
						<th>Controlador</th>
						<th>Acción</th>
						<th>Error</th>
						<th class="text-center">Estado</th>
						<th class="text-center">Fecha de registro</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach($listTException as $value)
						<tr class="filterElement">
							<td class="wordWrap" style="max-width: 100px;">{{$value->tuser!=null ? $value->tuser->email : 'No especificado'}}</td>
							<td class="wordWrap" style="max-width: 200px;">{{explode('\\', $value->controller)[3]}}</td>
							<td class="wordWrap" style="max-width: 200px;">{{$value->action}}</td>
							<td class="wordWrap" style="max-width: 200px;">{{$value->error}}</td>
							<td class="text-center">{!!$value->status=='Atendido' ? '<span class="label label-success">Atendido</span>' : '<span class="label label-warning">Pendiente</span>'!!}</td>
							<td class="text-center">{{$value->created_at}}</td>
							<td class="text-right">
								@if($value->status!='Atendido')
									<span class="btn btn-default btn-xs glyphicon glyphicon-ok" data-toggle="tooltip" data-placement="left" title="Marcar como atendido" onclick="_globalFunction.clickLink('{{url('exception/changestatus')}}/{{$value->idException}}/Atendido');"></span>
								@else
									<span class="btn btn-default btn-xs glyphicon glyphicon-ok" data-toggle="tooltip" data-placement="left" title="Marcar como atendido" disabled></span>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection