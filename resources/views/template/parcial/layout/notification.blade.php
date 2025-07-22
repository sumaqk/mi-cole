<li class="dropdown messages-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="fa fa-envelope-o"></i>
		<span id="labelNewGeneralNotification" class="label label-warning">@if($quantityTUserNotificationUnreadFmMdl>0){{$quantityTUserNotificationUnreadFmMdl}}@endif</span>
	</a>
	<ul class="dropdown-menu" style="box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.4);">
		<li>
			<span class="btn btn-sm btn-block btn-flat" onclick="readAllGeneralNotification();" style="background-color: #dbdbdb;border: 2px solid #000000;">
				<i class="fa fa-check" style="font-weight: bold;"> Marcar todo como leído</i>
			</span>
		</li>
		<li>
			<ul id="ulGeneralNotification" class="menu">
				@foreach($listTUserNotificationFmMdl as $value)
					<li id="liGeneralNotification{{$value->idUserNotification}}">
						<a href="{{url('usernotification/read/'.$value->idUserNotification)}}" style="white-space: inherit;">
							<small><span style="display: inline-block; vertical-align: middle;"><i class="fa fa-clock-o"></i> {{ViewHelper::getDateFormat($value->created_at, 'd-m-Y | H:i:s')}}</span></small><span class="labelAlertNewGeneralNotification" style="display: inline-block; vertical-align: middle;">{!!$value->status ? '' : '&nbsp;-'!!}</span> {!!$value->status ? '' : '<span class="labelAlertNewGeneralNotification label label-warning" style="display: inline-block; vertical-align: middle;">Nuevo</span>'!!}
							<p style="padding: 4px;margin: 0px;text-align: justify;word-wrap: break-word !important;">{{$value->description}}</p>
						</a>
					</li>
				@endforeach
			</ul>
		</li>
	</ul>
</li>