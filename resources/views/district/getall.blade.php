@extends('template.layout')
@section('title', 'Lista de distritos')

@section('generalBody')
<div class="nav-tabs-custom">
	<div class="tab-content">
		<div class="row" style="margin-bottom: 15px;">
			<div class="col-md-12">
				<a href="{{url('district/insert')}}" class="btn btn-success btn-sm">
					<i class="fa fa-plus"></i> Nuevo Distrito
				</a>
			</div>
		</div>
		<div id="divSearch" class="row">
			<div class="col-md-7">
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-search"></i>
					</div>
					<input type="text" id="txtSearch" name="txtSearch" class="form-control pull-right" placeholder="Información para búsqueda (Enter)" autofocus onkeyup="searchDistrict(this.value, '{{url('district/getall/1')}}', event);" value="{{$searchParameter}}">
				</div>
			</div>
			<div class="col-md-5">
				{!!ViewHelper::renderPagination('district/getall', $quantityPage, $currentPage, $searchParameter)!!}
			</div>
		</div>
		<hr>
		<div class="table-responsive">
			<table id="tableCollege" class="table table-striped table-bordered" style="min-width: 777px;">
				<thead>
					<tr>
						<th>Distrito</th>
						<th>Provincia</th>
						<th>Código</th>
						<th>Fecha de creación</th>
						<th class="text-center">Acciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach($listTDistrict as $value)
						<tr>
							<td>{{$value->name}}</td>
							<td>{{$value->tprovince->name}}</td>
							<td>{{$value->code ?: 'Sin código'}}</td>
							<td>{{date('d/m/Y', strtotime($value->created_at))}}</td>
							<td class="text-center" style="width: 120px;">
							
								<a href="{{url('district/edit/' . $value->idDistrict)}}" 
								   class="btn btn-primary btn-xs" 
								   data-toggle="tooltip" 
								   data-placement="top" 
								   title="Editar distrito">
									<i class="fa fa-edit"></i>
								</a>

							
								<form method="POST" action="{{url('district/delete/' . $value->idDistrict)}}" style="display: inline;">
									{{csrf_field()}}
									<button type="submit" 
											class="btn btn-danger btn-xs" 
											data-toggle="tooltip" 
											data-placement="top" 
											title="Eliminar distrito"
											onclick="return confirm('¿Está seguro de eliminar este distrito? Esta acción no se puede deshacer.')">
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
<script>
	function searchDistrict(value, url, event) {
		if (event.keyCode === 13) {
			window.location.href = url + '?searchParameter=' + encodeURIComponent(value);
		}
	}
	
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
@endsection