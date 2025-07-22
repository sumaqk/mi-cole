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
	<div style="padding-left: 15px;padding-right: 15px;">
		<h2>Contacto general</h2>
		<table style="width: 100%;">
			<tbody>
				<tr>
					<td style="vertical-align: top;width: 140px;"><b>Nombre de contacto</b></td>
					<td style="vertical-align: top;width: 5px;"><b>:</b></td>
					<td style="vertical-align: top;">{{$fullName}}</td>
				</tr>
				<tr>
					<td style="vertical-align: top;width: 140px;"><b>Correo de contacto</b></td>
					<td style="vertical-align: top;width: 5px;"><b>:</b></td>
					<td style="vertical-align: top;">{{$email}}</td>
				</tr>
				<tr>
					<td style="vertical-align: top;width: 140px;"><b>Asunto a tratar</b></td>
					<td style="vertical-align: top;width: 5px;"><b>:</b></td>
					<td style="vertical-align: top;">{{$subject}}</td>
				</tr>
				<tr>
					<td style="vertical-align: top;width: 140px;"><b>Mensaje</b></td>
					<td style="vertical-align: top;width: 5px;"><b>:</b></td>
					<td style="vertical-align: top;">{!!$messageBody!!}</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>