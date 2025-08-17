<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="robots" content="noindex">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->platformName : config('var.PLATFORM_NAME')}}</title>

	<!-- Favicon -->
    <link href="{{ asset('home/img/logo_agua_segura.png') }}" rel="icon">

	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/select2/dist/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/adminlte/dist/css/AdminLTE.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/adminlte/dist/css/skins/_all-skins.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/morris.js/morris.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/jvectormap/jquery-jvectormap.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/adminlte/plugins/iCheck/all.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/adminlte/plugins/timepicker/bootstrap-timepicker.css')}}">
	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> --}}
	<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>


	<!--[if lt IE 9]>
	<script src="{{asset('js/html5shiv.min.js')}}"></script>
	<script src="{{asset('js/respond.min.js')}}"></script>
	<![endif]-->

	<link rel="stylesheet" href="{{asset('css/googlefont.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/pnotify/pnotify.custom.min.css')}}">

	<link rel="stylesheet" href="{{asset('viewResources/template/layout.css?x='.config('var.CACHE_LAST_UPDATE'))}}">

	<link rel="stylesheet" href="{{asset('css/cssPagination.css?x='.config('var.CACHE_LAST_UPDATE'))}}">
	<link rel="stylesheet" href="{{asset('css/cssCardOurInfo.css?x='.config('var.CACHE_LAST_UPDATE'))}}">
	<link rel="stylesheet" href="{{asset('css/codiComercialCard.css?x='.config('var.CACHE_LAST_UPDATE'))}}">
	<link rel="stylesheet" href="{{asset('css/codiTabs.css?x='.config('var.CACHE_LAST_UPDATE'))}}">
	<link rel="stylesheet" href="{{asset('css/cssAdminLteOverride.css?x='.config('var.CACHE_LAST_UPDATE'))}}">

	@yield('cssSection')

	<script>
		var _sessionIdUser='{{Session::get('idUser', 'null')}}'=='null' ? null : '{{Session::get('idUser')}}';
		var _urlBase='{{url('')}}';
		var _contentBase='{{substr(asset(''), 0, strlen(asset(''))-1)}}';
		var _token='{{csrf_token()}}';
		var _currentDate='{{date('Y-m-d H:i:s')}}';
		var _timeDiscountIteration=0;

		var ignoreRestrictedClose=false;
		var isOpera=(!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
		var isFirefox=typeof InstallTrigger !== 'undefined';
		var isSafari=/constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
		var isIE=/*@cc_on!@*/false || !!document.documentMode;
		var isEdge=!isIE && !!window.StyleMedia;
		var isChrome=!!window.chrome && !!window.chrome.webstore;
		var isBlink=(isChrome || isOpera) && !!window.CSS;
	</script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<a href="{{url('index/indexadmin')}}" class="logo">
				<span class="logo-mini">{{mb_strtoupper($tConfigurationFmMdl!=null ? $tConfigurationFmMdl->platformTitle : config('var.PLATFORM_TITLE'))}}</span>
				<span class="logo-lg">{{mb_strtoupper($tConfigurationFmMdl!=null ? $tConfigurationFmMdl->platformName : config('var.PLATFORM_NAME'))}}</span>
			</a>
			<nav class="navbar navbar-static-top">
				<a href="#" class="sidebar-toggle" onclick="saveCollapseMenu()" data-toggle="push-menu" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						{{-- @include('template/parcial/layout/notification') --}}
						@include('template/parcial/layout/useraccount')
						{{-- <li>
							<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
						</li> --}}
					</ul>
				</div>
			</nav>
		</header>
		<aside class="main-sidebar">
			<section class="sidebar">
				<div class="user-panel">
					<div class="pull-left image" style="background-color: #ffffff;border-radius: 10px;box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.5) inset;padding: 1px;overflow: hidden;">
						<img src="{{asset('img/'.(($tConfigurationFmMdl!=null && $tConfigurationFmMdl->blackLogoMinimalExtension!='') ? ('logo/'.$tConfigurationFmMdl->idConfiguration.'-blackLogoMinimal.'.$tConfigurationFmMdl->blackLogoMinimalExtension) : 'general/logoMinimoNegro.png'))}}?x={{$tConfigurationFmMdl!=null ? str_replace(':', '-', str_replace(' ', '_', $tConfigurationFmMdl->updated_at)) : config('var.CACHE_LAST_UPDATE')}}" alt="">
					</div>
					<div class="pull-left info">
						<p>{{mb_substr(Session::get('fullName', 'Anónimo'), 0, 12)}}</p>
						<small>Panel de control</small>
					</div>
				</div>
				@include('template/parcial/layout/menu')
			</section>
		</aside>
		<div class="content-wrapper">
			<section class="content-header">
				@if(isset($tEmpresaDeudaGlobal) && (strpos(Session::get('rol'), 'Súper usuario')!==false || strpos(Session::get('rol'), 'Administrador')!==false))
					@if($tEmpresaDeudaGlobal->diasRetraso<=0)
						<div class="callout callout-warning" style="margin-bottom: 7px;">
							<p><b>Tiene una deuda de {{'S/'.$tEmpresaDeudaGlobal->monto}} que se vence @if(abs($tEmpresaDeudaGlobal->diasRetraso!=0)) en {{abs($tEmpresaDeudaGlobal->diasRetraso)}} @else hoy @endif {{abs($tEmpresaDeudaGlobal->diasRetraso)==1 || abs($tEmpresaDeudaGlobal->diasRetraso)==0 ? 'día' : 'días'}} "{{$tEmpresaDeudaGlobal->descripcion}}"</b></p>
						</div>
					@else
						<div class="callout callout-danger" style="margin-bottom: 7px;">
							<p><b>Tiene una deuda de {{'S/'.$tEmpresaDeudaGlobal->monto}} que se venció hace {{abs($tEmpresaDeudaGlobal->diasRetraso)}} {{$tEmpresaDeudaGlobal->diasRetraso==1 ? 'día' : 'días'}} "{{$tEmpresaDeudaGlobal->descripcion}}"</b></p>
						</div>
					@endif
				@endif
				<h1>
					@yield('title')
				</h1>
			</section>
			<section class="content">
				@yield('generalBody')
			</section>
		</div>
		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Versión</b> 1.0
			</div>
			<b>Copyright © {{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->footerYear : '2024'}}-{{date('Y')}} <a href="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->footerUrl : '#'}}" target="_blank">{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->footerText : 'Codideep\'s developer'}}</a></b>. Todo los derechos reservados.
		</footer>
		@include('template/parcial/layout/sidebar')
	</div>

	<div id="modalLoading" style="display: none;"><div><div><div></div><div></div><div></div><div></div></div></div></div>
	<div id="generalDialog"></div>

	<script src="{{asset('plugin/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
	<script src="{{asset('plugin/adminlte/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
	
	<script src="{{asset('plugin/pnotify/pnotify.custom.min.js')}}"></script>
	<script src="{{asset('plugin/sweetalert/sweetalert.min.js')}}"></script>

	<script>
		@if(Session::has('menuItemParentSelected')) 
			$('#{{Session::get('menuItemParentSelected')}}').addClass('active');
		@endif
		@if(Session::has('menuItemChildSelected')) 
			$('#{{Session::get('menuItemChildSelected')}}').addClass('active');
		@endif
	</script>

	@if(Session::has('globalMessage'))
		<script>
			(function()
			{
				@if(Session::get('type')=='error' || Session::get('type')=='exception')
					@foreach((is_array(Session::get('globalMessage')) ? Session::get('globalMessage') : [Session::get('globalMessage')]) as $value)
						@if(trim($value)!='')
							new PNotify(
							{
								title: "No se pudo proceder",
								text: "{{$value}}",
								type: "error"
							});
						@endif
					@endforeach
				@else
					swal(
					{
						title: "{{Session::get('type')=='success' ? 'Correcto' : 'Alerta'}}",
						text: "{!!Session::get('globalMessage')[0]!!}",
						icon: "{{Session::get('type')=='success' ? 'success' : 'warning'}}",
						timer: {{Session::get('type')=='success' ? "2000" : "60000"}}
					});
				@endif
			})();
		</script>
	@endif

	<script src="{{asset('js/codideepHelpers.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>

	<script src="https://codideep.com/js/jsBuscar.js?x={{config('var.CACHE_LAST_UPDATE')}}"></script>

	<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
	<script>
		$.widget.bridge('uibutton', $.ui.button);
	</script>
	<!-- Bootstrap 3.3.7 -->
	<script src="{{asset('plugin/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
	<!-- Select2 -->
	<script src="{{asset('plugin/adminlte/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
	<!-- Morris.js charts -->
	<script src="{{asset('plugin/adminlte/bower_components/raphael/raphael.min.js')}}"></script>
	<script src="{{asset('plugin/adminlte/bower_components/morris.js/morris.min.js')}}"></script>
	<!-- Sparkline -->
	<script src="{{asset('plugin/adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
	<!-- jvectormap -->
	<script src="{{asset('plugin/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
	<script src="{{asset('plugin/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
	<!-- jQuery Knob Chart -->
	<script src="{{asset('plugin/adminlte/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
	<!-- daterangepicker -->
	<script src="{{asset('plugin/adminlte/bower_components/moment/min/moment.min.js')}}"></script>
	<script src="{{asset('plugin/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
	<!-- datepicker -->
	<script src="{{asset('plugin/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
	<!--timepicker-->
	<script src="{{asset('plugin/adminlte/plugins/timepicker/bootstrap-timepicker.js')}}"></script>
	<!-- iCheck 1.0.1 -->
	<script src="{{asset('plugin/adminlte/plugins/iCheck/icheck.min.js')}}"></script>
	<!-- Bootstrap WYSIHTML5 -->
	<script src="{{asset('plugin/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
	<!-- Slimscroll -->
	<script src="{{asset('plugin/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<!-- FastClick -->
	<script src="{{asset('plugin/adminlte/bower_components/fastclick/lib/fastclick.js')}}"></script>
	<!-- AdminLTE App -->
	<script src="{{asset('plugin/adminlte/dist/js/adminlte.min.js')}}"></script>

	{{-- <script src="{{asset('plugin/adminlte/bower_components/chart.js/Chart.js')}}"></script> --}}

	<script src="{{asset('plugin/formvalidation/formValidation.min.js')}}"></script>
	<script src="{{asset('plugin/formvalidation/bootstrap.validation.min.js')}}"></script>

	<script src="{{asset('js/codiTabs.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
	<script src="{{asset('viewResources/template/layout.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
	<script src="{{asset('plugin/ckeditor/build/ckeditor.js')}}?x={{config('var.CACHE_LAST_UPDATE')}}"></script>
	<script src="{{asset('viewResources/template/parcial/layout/notification.js')}}?x={{config('var.CACHE_LAST_UPDATE')}}"></script>

	@yield('jsSection')
</body>
</html>