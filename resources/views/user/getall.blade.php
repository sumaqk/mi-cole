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
								</div>
							</div>					
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
@endsection
@section('jsSection')
<script src="{{asset('viewResources/user/getall.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
@endsection