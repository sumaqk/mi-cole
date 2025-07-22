@foreach($listTUserNotification as $value)
	<li id="liGeneralNotification{{$value->idUserNotification}}">
		<a href="{{url('usernotification/read/'.$value->idUserNotification)}}" style="white-space: inherit;">
			<small><span style="display: inline-block; vertical-align: middle;"><i class="fa fa-clock-o"></i> {{ViewHelper::getDateFormat($value->created_at, 'd-m-Y | H:i:s')}}</span></small><span class="labelAlertNewGeneralNotification" style="display: inline-block; vertical-align: middle;">{!!$value->status ? '' : '&nbsp;-'!!}</span> {!!$value->status ? '' : '<span class="labelAlertNewGeneralNotification label label-warning" style="display: inline-block; vertical-align: middle;">Nuevo</span>'!!}
			<p style="padding: 4px;margin: 0px;text-align: justify;word-wrap: break-word !important;">{{$value->description}}</p>
		</a>
	</li>
@endforeach

@if(count($listTUserNotification)==0)
	<li id="liGeneralNotification0000000000000">
		<a style="color: #000000;text-align: center;white-space: inherit;">
			No hay más notificaciones
		</a>
	</li>
@endif