<!doctype html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div
		style="
			background-color: #eeeeee;
			font-size: 22px;
			padding: 10px;
			text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);">
		<img src="{{(!config('var.APP_DEBUG') && $tConfigurationFmMdl!=null && $tConfigurationFmMdl->blackLogoExtension!='') ? asset('img/logo/'.$tConfigurationFmMdl->idConfiguration.'-blackLogo.'.$tConfigurationFmMdl->blackLogoExtension.'?x='.ViewHelper::dateToCache($tConfigurationFmMdl->updated_at)) : config('var.LOGO_SHOW_MAIL')}}" height="50"
			onclick="window.location.href='{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->urlForEmail : config('var.URL_GENERAL_SHOW')}}';" 
			style="
				cursor: pointer;
				display: inline-block;
				vertical-align: middle;">
	</div>
	@if($type=='divAlertInfo')
		<div style="background-color: #58A1EF;
			background-image: url('https://codideep.com/resources_codideep/alert.png');
			background-position: 3px center;
			background-repeat: no-repeat;
			color: white;
			margin: 4px;
			padding: 7px;
			padding-left: 33px;
			text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
			width: auto;">
			{!!$messageBody!!}
		</div>
	@endif
	@if($type=='divAlertWarning')
		<div style="background-color: #DBC347;
			background-image: url('https://codideep.com/resources_codideep/alert.png');
			background-position: 3px center;
			background-repeat: no-repeat;
			color: white;
			margin: 4px;
			padding: 7px;
			padding-left: 33px;
			text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
			width: auto;">
			{!!$messageBody!!}
		</div>
	@endif
	@if($type=='divAlertDanger')
		<div style="background-color: #d34141;
			background-image: url('https://codideep.com/resources_codideep/alert.png');
			background-position: 3px center;
			background-repeat: no-repeat;
			color: white;
			margin: 4px;
			padding: 7px;
			padding-left: 33px;
			text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
			width: auto;">
			{!!$messageBody!!}
		</div>
	@endif
	<hr>
	<b>
		<table>
			<tr>
				<td colspan="2">Atte: Plataforma <a href="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->urlForEmail : config('var.URL_GENERAL_SHOW')}}">{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->urlForEmail : config('var.URL_GENERAL_SHOW')}}</a></td>
			</tr>
			<tr><td colspan="2"><br></td></tr>
			<tr>
				<td colspan="2">Saludos.</td>
			</tr>
		</table>
	</b>
</body>
</html>