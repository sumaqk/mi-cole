@extends('template.layout')
@section('title', 'Página de inicio')
@section('generalBody')
<link rel="stylesheet" href="{{asset('viewResources/index/indexadmin.css?x='.config('var.CACHE_LAST_UPDATE'))}}">
<div class="nav-tabs-custom">
	<div class="tab-content">
		Datos generales de inicio del Sistema de Mi Cole con Agua
	</div>
</div>
@endsection
@section('jsSection')
<script src="{{asset('plugin/adminlte/bower_components/chart.js/Chart.js')}}"></script>
<script src="{{asset('viewResources/index/indexadmin.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
@endsection