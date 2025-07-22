<form id="frmUserManagement" action="{{url('institution/usermanagement')}}" method="post">
	<div class="tab-pane active" id="tab_1-1">
		<div class="row">
			<div class="col-md-12">
				<select id="selectIdUser" name="selectIdUser[]" class="select" multiple style="width: 100%;">
					@foreach($listTUser as $value)
						<?php $assignUser=false; ?>

						@foreach($tInstitution->tinstitutiontuser as $item)
							@if($value->idUser==$item->idUser)
								<?php $assignUser=true;break; ?>
							@endif
						@endforeach

						<option value="{{$value->idUser}}" {{$assignUser ? 'selected' : ''}}>{{$value->firstName.' '.$value->surName}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				{{csrf_field()}}
				<input type="hidden" name="hdIdInstitution" value="{{$tInstitution->idInstitution}}">
				<input type="button" class="btn btn-default pull-left" value="Cerrar ventana" onclick="$('#generalDialogModal').modal('hide');">
				<input type="button" class="btn btn-primary pull-right" value="Guardar cambios" onclick="sendFrmUserManagement();">
			</div>
		</div>
	</div>
</form>
<script src="{{asset('viewResources/institution/usermanagement.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>