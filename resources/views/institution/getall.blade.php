@extends('template.layout')
@section('title', 'Lista de instituciones')

@section('generalBody')
<div class="nav-tabs-custom">
	<div class="tab-content">
		{{-- <div class="row" style="margin-bottom: 15px;">
			<div class="col-md-12">
				<a href="{{url('institution/insert')}}" class="btn btn-success btn-sm">
					<i class="fa fa-plus"></i> Nueva Institución
				</a>
			</div>
		</div> --}}
		<div class="row" style="margin-bottom: 15px;">
			<div class="col-md-12">
				<a href="{{url('institution/insert')}}" class="btn btn-success btn-sm">
					<i class="fa fa-plus"></i> Nueva Institución
				</a>
				<a href="{{url('institution/export')}}" class="btn btn-primary btn-sm" style="margin-left: 10px;">
					<i class="fa fa-file-excel-o"></i> Exportar a Excel
				</a>
				<a href="{{url('institution/export')}}?searchParameter={{$searchParameter}}" 
				class="btn btn-info btn-sm" 
				style="margin-left: 5px;">
					<i class="fa fa-download"></i> Exportar Filtrado
				</a>
			</div>
		</div>
		<div id="divSearch" class="row">
			<div class="col-md-7">
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-search"></i>
					</div>
					<input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" autofocus onkeyup="searchInstitution(this.value, '{{url('institution/getall/1')}}', event);" value="{{$searchParameter}}">
				</div>
			</div>
			<div class="col-md-5">
				{!!ViewHelper::renderPagination('institution/getall', $quantityPage, $currentPage, $searchParameter)!!}
			</div>
		</div>
		<hr>
		<div class="table-responsive">
			<table id="tableCollege" class="table table-striped table-bordered" style="min-width: 777px;">
				<thead>
					<tr>
						<th>UGEL</th>
						<th>Institución</th>
						<th>Provincia</th>
						<th>Distrito</th>
						<th>Estado</th>
						<th class="text-center">Acciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach($listTInstitution as $value)
						<tr>
							<td>{{$value->tugel->name ?? 'Sin UGEL'}}</td>
							<td>
								{{$value->name}}
								<div><small style="color: #999999;font-weight: bold;">{{$value->lender}}</small></div>
							</td>
							<td>{{$value->tdistrict->tprovince->name}}</td>
							<td>{{$value->tdistrict->name}}</td>
							<td>
								<span class="label label-{{$value->status == 'Activo' ? 'success' : 'danger'}}">
									{{$value->status}}
								</span>
							</td>
							<td class="text-center" style="width: 150px;">
								
								<a href="{{url('institution/edit/' . $value->idInstitution)}}" 
								   class="btn btn-primary btn-xs" 
								   data-toggle="tooltip" 
								   data-placement="top" 
								   title="Editar institución">
									<i class="fa fa-edit"></i>
								</a>
								
								
								<span class="btn btn-default btn-xs glyphicon glyphicon-user" 
									  data-toggle="tooltip" 
									  data-placement="top" 
									  title="Gestionar usuarios" 
									  onclick="ajaxDialog('generalDialog', null, '{{str_replace('\'', '&#39;', $value->name)}} (Gestión de usuarios)', { _token : '{{csrf_token()}}', idInstitution: '{{$value->idInstitution}}' }, '{{url('institution/usermanagement')}}', 'POST', null, null, false, true);">
								</span>

							
								<form method="POST" action="{{url('institution/toggle-status/' . $value->idInstitution)}}" style="display: inline;">
									{{csrf_field()}}
									<button type="submit" 
											class="btn btn-{{$value->status == 'Activo' ? 'warning' : 'success'}} btn-xs" 
											data-toggle="tooltip" 
											data-placement="top" 
											title="{{$value->status == 'Activo' ? 'Desactivar' : 'Activar'}}"
											onclick="return confirm('¿Está seguro de {{$value->status == 'Activo' ? 'desactivar' : 'activar'}} esta institución?')">
										<i class="fa fa-{{$value->status == 'Activo' ? 'times' : 'check'}}"></i>
									</button>
								</form>

							
								<form method="POST" action="{{url('institution/delete/' . $value->idInstitution)}}" style="display: inline;">
									{{csrf_field()}}
									<button type="submit" 
											class="btn btn-danger btn-xs" 
											data-toggle="tooltip" 
											data-placement="top" 
											title="Eliminar institución"
											onclick="return confirm('¿Está seguro de eliminar esta institución? Esta acción no se puede deshacer.')">
										<i class="fa fa-trash"></i>
									</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

@section('jsSection')
<script src="{{asset('viewResources/institution/getall.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
@endsection