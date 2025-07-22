@extends('template.layout')
@section('title', 'Lista de calidad')

@section('cssSection')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<style>
    #tableCollege thead th {
        background-color: #343a40; 
        color: #ffffff;          
        text-align: center;     
    }
    #tableCollege tbody tr td {
        border: 1px solid #cccccc; 
    }


    #tableCollege tbody tr:nth-child(even) {
        background-color: #f2f2f2; 
    }

    #tableCollege tbody tr:nth-child(odd) {
        background-color: #ffffff; 
    }

   
    #tableCollege tbody tr:hover {
        background-color: #e9ecef; 
    }
</style>
@endsection

@section('generalBody')
<div class="nav-tabs-custom">
	<div class="tab-content">
		<div id="divSearch" class="row">
			<div class="col-md-2">
				<button type="button" class="btn btn-success btn-block" onclick="window.location.href ='{{url('water/export')}}'">Exportar en Excel</button>
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
						<th class="text-center">Periodo</th>
						<th class="text-center">MCR S. 1</th>
						<th class="text-center">MCR S. 2</th>
						<th class="text-center">MCR S. 3</th>
						<th class="text-center">MCR S. 4</th>
						<th class="text-center">MCR S. 5</th>
						<th class="text-center">Detalle</th>
					</tr>
				</thead>
				<tbody>
					@foreach($listTWater as $value)
						<tr>
							<td>{{ $value->ugel ?? 'Sin UGEL' }}</td>   
							<td>
								{{$value->nombre}}
								<div><small style="color: #5c5c5c;font-weight: bold;">{{$value->prestador}}</small></div>
							</td>
							<td>{{$value->provincia}}</td>
							<td>{{$value->distrito}}</td>
							<td class="text-center">
								<div>{{$value->mes}}</div>
								{{substr($value->created_at, 0, 4)}}
							</td>
							<td class="text-center" style="color: {{$value->resultW1==-1 ? '#000000' : (($value->resultW1<0.5 || $value->resultW1>1) ? 'red' : '#009e00')}}; font-size: 20px;">{{$value->resultW1!=-1 ? number_format($value->resultW1, 1, '.') : '-'}}</td>
							<td class="text-center" style="color: {{$value->resultW2==-1 ? '#000000' : (($value->resultW2<0.5 || $value->resultW2>1) ? 'red' : '#009e00')}}; font-size: 20px;">{{$value->resultW2!=-1 ? number_format($value->resultW2, 1, '.') : '-'}}</td>
							<td class="text-center" style="color: {{$value->resultW3==-1 ? '#000000' : (($value->resultW3<0.5 || $value->resultW3>1) ? 'red' : '#009e00')}}; font-size: 20px;">{{$value->resultW3!=-1 ? number_format($value->resultW3, 1, '.') : '-'}}</td>
							<td class="text-center" style="color: {{$value->resultW4==-1 ? '#000000' : (($value->resultW4<0.5 || $value->resultW4>1) ? 'red' : '#009e00')}}; font-size: 20px;">{{$value->resultW4!=-1 ? number_format($value->resultW4, 1, '.') : '-'}}</td>
							<td class="text-center" style="color: {{$value->resultW5==-1 ? '#000000' : (($value->resultW5<0.5 || $value->resultW5>1) ? 'red' : '#009e00')}}; font-size: 20px;">{{$value->resultW5!=-1 ? number_format($value->resultW5, 1, '.') : '-'}}</td>
							
							<td class="text-center">
								<a href="{{ route('water.detail', ['id' => $value->id]) }}" 
									class="btn btn-info btn-block">
									Ver Más
								 </a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>   
	</div>
	</div>
</div>
@endsection

@section('jsSection')
<script>
    $(document).ready(function() {
        $('#tableCollege').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            responsive: true,

            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json" 
            }
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="{{asset('viewResources/water/getall.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
@endsection