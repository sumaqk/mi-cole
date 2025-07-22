<li class="dropdown user user-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<img src="{{asset('img/avatar/'.Session::get('idUser').'.'.Session::get('avatarExtension').'?x='.str_replace(' ', '_', str_replace(':', '-', Session::get('lastUpdate'))))}}" class="user-image" style="background-color: #ffffff;" alt="">
		<span class="hidden-xs">{{mb_substr(Session::get('fullName', 'Anónimo'), 0, 12)}}</span>
	</a>
	<ul class="dropdown-menu">
		<li class="user-header">
			<img src="{{asset('img/avatar/'.Session::get('idUser').'.'.Session::get('avatarExtension').'?x='.str_replace(' ', '_', str_replace(':', '-', Session::get('lastUpdate'))))}}" class="img-circle" style="background-color: #ffffff;" alt="">
			<p>
				{{mb_substr(Session::get('fullName', 'Anónimo'), 0, 12)}}
				<small>{{Session::get('mainRole', 'Acceso público')}}</small>
				@if (Session::get('area')!='')
					<small>
						{{Session::get('area')}}
					</small>
				@endif
				
			</p>
		</li>
		<li class="user-body">
			<div class="row">
				<div class="col-xs-12 text-center">
					Panel administrativo de la plataforma
				</div>
			</div>
		</li>
		<li class="user-footer">
			<div class="pull-left">
				<a href="{{url('user/edit')}}" class="btn btn-default btn-flat">Mi perfil</a>
			</div>
			<div class="pull-right">
				<a href="{{url('user/logout')}}" class="btn btn-default btn-flat">Salir</a>
			</div>
		</li>
	</ul>
</li>