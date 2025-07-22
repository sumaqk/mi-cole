@extends('template.layoutpublic')
@section('generalBody')
<div class="paddingLayoutBodyInternal">
	<div class="pageTitle">Recuperación de contraseña</div>
	<form id="frmUserRecoveryPassword" action="{{url('user/recoverypassword')}}" method="post">
		<div id="divSendMessageResponse" class="row" style="display: none;">
			<div class="col-md-12"></div>
		</div>
		<div class="row">
			<div class="form-group col-md-3">
				<label for="txtEmail">Correo electrónico*</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-envelope-o"></i>
					</div>
					<input type="text" id="txtEmail" name="txtEmail" class="form-control pull-right" value="{{old('txtEmail')}}">
				</div>
				<div><a href="#" onclick="getRecoveryCode();">Obtener código de recuperación</a><span> ***Este código le será enviado por correo.</span></div>
			</div>
			<div class="form-group col-md-3">
				<label for="txtRecoveryCode">Código de recuperación*</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-dot-circle-o"></i>
					</div>
					<input type="text" id="txtRecoveryCode" name="txtRecoveryCode" class="form-control pull-right" value="{{old('txtRecoveryCode')}}">
				</div>
			</div>
			<div class="form-group col-md-3">
				<label for="passPassword">Contraseña nueva*</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-keyboard-o"></i>
					</div>
					<input type="password" id="passPassword" name="passPassword" class="form-control pull-right" value="{{old('passPassword')}}">
				</div>
			</div>
			<div class="form-group col-md-3">
				<label for="passPasswordRetype">Repita contraseña*</label>
				<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-keyboard-o"></i>
					</div>
					<input type="password" id="passPasswordRetype" name="passPasswordRetype" class="form-control pull-right" value="{{old('passPasswordRetype')}}">
				</div>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="form-group col-md-12 text-right">
				{{csrf_field()}}
				<input type="button" class="btn btn-primary" value="Guardar cambios" onclick="sendFrmUserRecoveryPassword();">
			</div>
		</div>
	</form>
</div>
@endsection
@section('jsSection')
<script src="{{asset('viewResources/user/recoverypassword.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
@endsection