<!DOCTYPE html>
<html lang="en">
<head>
	<title>System</title>
	
	<!-- Favicon -->
    <link href="{{ asset('home/img/logo_agua_segura.png') }}" rel="icon">

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/fonts/iconic/css/material-design-iconic-font.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/vendor/animate/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/vendor/animsition/css/animsition.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/vendor/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/vendor/daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('plugin/logintemplate/css/main.css')}}">

	<link rel="stylesheet" href="{{asset('plugin/pnotify/pnotify.custom.min.css')}}">

	<style>
		body
		{
			margin: 0;
			padding: 0;
			min-height: 100vh;
			font-family: 'Arial', sans-serif;
		}

		.login-container
		{
			display: flex;
			min-height: 100vh;
			background-image: url("{{asset('img/loginBanner/bannerAgua.jpg')}}");
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
		}

		.login-image-section
		{
			flex: 1;
		}

		.login-form-section
		{
			flex: 1;
			display: flex;
			align-items: center;
			justify-content: flex-end;
			padding: 20px 60px 20px 20px;
		}

		.login100-form-bgbtn
		{
			background: -webkit-linear-gradient(right, #424a4c, #504754, #848484, #2e2a2f);
		}

		.ui-pnotify-text
		{
			font-size: 13px;
		}

		.ui-pnotify-title
		{
			font-size: 18px;
		}

		.wrap-login100
		{
			background-color: rgba(255, 255, 255, 0.95);
			max-width: 400px;
			width: 100%;
			padding: 40px;
			border-radius: 10px;
			box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
			backdrop-filter: blur(10px);
		}

		@media (max-width: 768px) {
			.login-container {
				flex-direction: column;
			}
			
			.login-image-section {
				min-height: 200px;
			}
			
			.login-form-section {
				min-height: calc(100vh - 200px);
			}
		}
	</style>

	<script>
		var _contentBase='{{substr(asset(''), 0, strlen(asset(''))-1)}}';
	</script>

	<script src="{{asset('plugin/adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
	<script src="{{asset('plugin/pnotify/pnotify.custom.min.js')}}"></script>
</head>
<body>
	@if(Session::has('globalMessage'))
		<script>
			$(function()
			{
				@if(Session::get('type')=='error' || Session::get('type')=='exception')
					@foreach(Session::get('globalMessage') as $value)
						@if(trim($value)!='')
							new PNotify(
							{
								title: "No se pudo proceder",
								text: "{{$value}}",
								type: "error",
							});
						@endif
					@endforeach
				@endif
			});
		</script>
	@endif
	<div class="login-container">
		<!-- Sección de imagen (izquierda) -->
		<div class="login-image-section">
		</div>
		
		<!-- Sección de formulario (derecha) -->
		<div class="login-form-section">
			<div class="wrap-login100">
				<form class="login100-form validate-form" action="{{url('user/loginasadmin')}}" method="post">
					<span class="login100-form-title p-b-26" style="color: #6a6a6a;">
						{{($tConfigurationFmMdl!=null ? $tConfigurationFmMdl->platformName : 'System')}}
					</span>
					<span class="login100-form-title p-b-48">
						<img src="{{asset('img/general/logo.png')}}" alt="Logo" style="background-color: #ffffff;border-radius: 5px;box-shadow: 0px 0px 5px #ffffff;padding: 5px;padding-left: 10px;padding-right: 10px;width: 100%;">
					</span>
					<div class="wrap-input100">
						<input type="text" id="txtEmail" name="txtEmail" class="input100" style="color: #000000;">
						<span class="focus-input100" data-placeholder="Correo electrónico o usuario"></span>
					</div>
					<div class="wrap-input100">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input type="password" id="passPassword" name="passPassword" class="input100" style="color: #000000;">
						<span class="focus-input100" data-placeholder="Contraseña"></span>
					</div>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn">
								Acceder
							</button>
						</div>
					</div>
					<div class="text-center">
						<span class="txt1" style="color: #999999;">
							Si olvidaste tu contraseña, comunícate con el administrador del sistema para que actualice tus datos.
						</span>
					</div>
					{{csrf_field()}}
				</form>
			</div>
		</div>
	</div>
	<script src="{{url('plugin/logintemplate/vendor/animsition/js/animsition.min.js')}}"></script>
	<script src="{{url('plugin/logintemplate/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{url('plugin/logintemplate/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{url('plugin/logintemplate/vendor/select2/select2.min.js')}}"></script>
	<script src="{{url('plugin/logintemplate/vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{url('plugin/logintemplate/vendor/daterangepicker/daterangepicker.js')}}"></script>
	<script src="{{url('plugin/logintemplate/vendor/countdowntime/countdowntime.js')}}"></script>
	<script src="{{url('plugin/logintemplate/js/main.js')}}"></script>
</body>
</html>