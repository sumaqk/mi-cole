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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
	


	<!--[if lt IE 9]>
	<script src="{{asset('js/html5shiv.min.js')}}"></script>
	<script src="{{asset('js/respond.min.js')}}"></script>
	<![endif]-->

	<link rel="stylesheet" href="{{asset('css/googlefont.css')}}">
	<link rel="stylesheet" href="{{asset('plugin/pnotify/pnotify.custom.min.css')}}">

	<link rel="stylesheet" href="{{asset('viewResources/template/layoutpublic.css?x='.config('var.CACHE_LAST_UPDATE'))}}">

	<link rel="stylesheet" href="{{asset('css/cssPagination.css?x='.config('var.CACHE_LAST_UPDATE'))}}">
	<link rel="stylesheet" href="{{asset('css/cssCardOurInfo.css?x='.config('var.CACHE_LAST_UPDATE'))}}">
	<link rel="stylesheet" href="{{asset('css/codiTabs.css?x='.config('var.CACHE_LAST_UPDATE'))}}">
	<link rel="stylesheet" href="{{asset('css/cssAdminLtePublicOverride.css?x='.config('var.CACHE_LAST_UPDATE'))}}">

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

	@yield('cssSection')
		
</head>
<body>
	@include('template/parcial/layoutpublic/header')
	@include('template/parcial/layoutpublic/loginpublic')

	<section id="generalBody">@yield('generalBody')</section>

	<div id="modalLoading" style="display: none;"><div><div><div></div><div></div><div></div><div></div></div></div></div>

	@include('template/parcial/layoutpublic/footer')

	<div id="generalDialog"></div>

	<script src="{{asset('plugin/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
	<script src="{{asset('plugin/adminlte/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
	
	<script src="{{asset('plugin/pnotify/pnotify.custom.min.js')}}"></script>
	<script src="{{asset('plugin/sweetalert/sweetalert.min.js')}}"></script>

	<script>
		(function()
		{
			@if(Session::has('menuItemParentSelected'))
				var menuItemParent=document.getElementById('{{Session::get("menuItemParentSelected")}}');

				if(menuItemParent!=null)
				{
					menuItemParent.classList.add('headerDivMenuLiActive');
				}
			@endif

			@if(Session::has('menuItemChildSelected'))
				var menuItemChild=document.getElementById('{{Session::get("menuItemChildSelected")}}');

				if(menuItemChild!=null)
				{
					menuItemChild.classList.add('headerDivSubMenuLiActive');
				}
			@endif

			@if(Session::has('menuItemSubChildSelected'))
				var menuItemSubChild=document.getElementById('{{Session::get("menuItemSubChildSelected")}}');

				if(menuItemSubChild!=null)
				{
					menuItemSubChild.classList.add('headerDivMiLiActive');
				}
			@endif
		})();
	</script>

	@if(Session::has('globalMessage'))
		<script>
			(function()
			{
				@if(Session::get('type')=='error' || Session::get('type')=='exception')
					@foreach(Session::get('globalMessage') as $value)
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

	<script src="{{asset('plugin/adminlte/bower_components/chart.js/Chart.js')}}"></script>

	<script src="{{asset('plugin/formvalidation/formValidation.min.js')}}"></script>
	<script src="{{asset('plugin/formvalidation/bootstrap.validation.min.js')}}"></script>

	<script>
		var platformNameFvT='{{($tConfigurationFmMdl!=null && $tConfigurationFmMdl->platformName!='') ? $tConfigurationFmMdl->platformName : 'Nuestra ubicación'}}';
		var latitudeMapFvT={{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->latitudeMap : -13.6537646}};
		var longitudeMapFvT={{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->longitudeMap : -73.4287659}};
		var zoomMapFvT={{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->zoomMap : 17}};
	</script>

	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{config('var.API_KEY_GOOGLE_MAPS')}}&libraries=places"></script>
	<script src="{{asset('js/codiTabs.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
	<script src="{{asset('viewResources/template/layoutpublic.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
	<script src="{{asset('viewResources/template/parcial/layoutpublic/login.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/heroicons@2.0.18/24/outline/index.js"></script>
	@yield('jsSection')
</body>
</html>