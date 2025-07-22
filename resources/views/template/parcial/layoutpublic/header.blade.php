<header>
	<div id="headerDivInfo" class="paddingLayout">
		<div id="headerDivLogo">
			<img src="{{asset('img/'.(($tConfigurationFmMdl!=null && $tConfigurationFmMdl->blackLogoExtension!='') ? ('logo/'.$tConfigurationFmMdl->idConfiguration.'-blackLogo.'.$tConfigurationFmMdl->blackLogoExtension) : 'general/logoNegro.png'))}}?x={{$tConfigurationFmMdl!=null ? str_replace(':', '-', str_replace(' ', '_', $tConfigurationFmMdl->updated_at)) : config('var.CACHE_LAST_UPDATE')}}" alt="" onclick="window.location.href=_urlBase+'/';">
		</div>
		<div id="headerDivInfoContact">
			<table>
				<tbody>
					<tr>
						<td><i class="fa fa-phone"></i></td>
						<td>
							<span>{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->textForPhone : 'Teléfono de contacto'}}</span>
							<div>{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->phone : '+51 956 248 003'}}</div>
						</td>
						<td><i class="fa fa-map-marker"></i></td>
						<td>
							<span>{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->textForAddress : 'Dirección'}}</span>
							<div>{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->address : 'Urb. Santa Marta Mz. 2'}}</div>
						</td>
						<td><i class="fa fa-clock-o"></i></td>
						<td>
							<span>{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->textForDateText : 'Lun - Vie: 9am - 5pm'}}</span>
							<div>{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->dateText : 'Sab - Dom: Cerrado'}}</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div id="headerDivMenu" class="paddingLayout">
		<img src="{{asset('img/'.(($tConfigurationFmMdl!=null && $tConfigurationFmMdl->whiteLogoExtension!='') ? ('logo/'.$tConfigurationFmMdl->idConfiguration.'-whiteLogo.'.$tConfigurationFmMdl->whiteLogoExtension) : 'general/logo.png'))}}?x={{$tConfigurationFmMdl!=null ? str_replace(':', '-', str_replace(' ', '_', $tConfigurationFmMdl->updated_at)) : config('var.CACHE_LAST_UPDATE')}}" alt="" onclick="window.location.href=_urlBase+'/';">
		<img src="{{asset('img/'.(($tConfigurationFmMdl!=null && $tConfigurationFmMdl->whiteLogoMinimalExtension!='') ? ('logo/'.$tConfigurationFmMdl->idConfiguration.'-whiteLogoMinimal.'.$tConfigurationFmMdl->whiteLogoMinimalExtension) : 'general/logoMinimo.png'))}}?x={{$tConfigurationFmMdl!=null ? str_replace(':', '-', str_replace(' ', '_', $tConfigurationFmMdl->updated_at)) : config('var.CACHE_LAST_UPDATE')}}" alt="" onclick="window.location.href=_urlBase+'/';">
		<div>
			<div>
				<i class="fa fa-th-list"></i>
			</div>
		</div>
		<ul>
			<li>
				<a href="{{url('/')}}"> Volver a la Página principal</a>
			</li>
			<!-- <li id="mHome">
				<a href="{{url('/')}}">Inicio</a>
			</li><li id="mWater">
				<a href="{{url('water/insert')}}">Agua</a>
			</li> -->
		</ul>
		@if(Session::has('idUser'))
			<div>
				<div class="divLoginData" style="cursor: default;">
					<span onclick="window.location.href='{{url('user/edit')}}';">{{mb_substr(Session::get('firstName'), 0, 12).'...'}}</span>
					&nbsp;&nbsp;
					<i class="fa fa-sign-out" data-toggle="tooltip" data-placement="bottom" title="Cerrar sesión" onclick="window.location.href='{{url('user/logout')}}';"></i>
					@if(ViewHelper::hasMainRole('Súper usuario') || ViewHelper::hasMainRole('Administrador'))
						&nbsp;&nbsp;
						<i class="fa fa-gear" data-toggle="tooltip" data-placement="bottom" title="Configuración general" onclick="window.location.href='{{url('index/indexadmin')}}';"></i>
					@endif
				</div>
			</div>
		@else
			<div onclick="$('#modalAccess').modal('show');">
				<div>
					<i class="fa fa-user"></i>
					<span>Login</span>
				</div>
			</div>
		@endif
	</div>
</header>