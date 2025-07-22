@extends('template.layout')
@section('title', 'Perfil de usuario')
@section('generalBody')
<div class="nav-tabs-custom">
	<div class="tab-content">
{{-- @extends('template.layoutpublic')
@section('generalBody')
<div class="paddingLayoutBodyInternal">
	<div class="pageTitle">Perfil de usuario</div> --}}
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab01" data-toggle="tab">Datos generales</a></li>
			<li><a href="#tab02" data-toggle="tab">Cambio de correo</a></li>
			<li><a href="#tab03" data-toggle="tab">Cambio de contraseña</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab01">
				<div class="row">
					<div class="col-md-3 text-center">
						<img src="{{asset('img/avatar/'.$tUser->idUser.'.'.$tUser->avatarExtension.'?x='.str_replace(' ', '_', str_replace(':', '-', $tUser->updated_at)))}}" height="164" width="164" style="border: 1px solid #999999;border-radius: 170px;">
						<hr>
						<input type="button" class="btn btn-default btn-block" value="Cambiar avatar" onclick="$('#fileAvatar').val(null);$('#fileAvatar').trigger('click');">
						<form id="frmUploadAvatar" action="{{url('user/uploadavatar')}}" method="post" enctype="multipart/form-data">
							{!!csrf_field()!!}
							<input type="file" id="fileAvatar" name="fileAvatar" style="display: none;" accept=".png,.jpg,.jpeg" onchange="sendFrmUploadAvatar();">
						</form>
					</div>
					<div class="col-md-9" style="border-left: 1px solid #999999;">
						<form id="frmEditUser" action="{{url('user/edit')}}" method="post">
							<div class="row">
								<div class="form-group col-md-6">
									<label for="txtFirstName">Nombre*</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-i-cursor"></i>
										</div>
										<input type="text" id="txtFirstName" name="txtFirstName" class="form-control pull-right" value="{{$tUser->firstName}}">
									</div>
								</div>
								<div class="form-group col-md-6">
									<label for="txtSurName">Apellido*</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-i-cursor"></i>
										</div>
										<input type="text" id="txtSurName" name="txtSurName" class="form-control pull-right" value="{{$tUser->surName}}">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-3">
									<label for="txtEmail">Correo elect.</label>
									<div class="input-group readonly">
										<div class="input-group-addon">
											<i class="fa fa-envelope-o"></i>
										</div>
										<input type="text" id="txtEmail" name="txtEmail" class="form-control pull-right" readonly="readonly" value="{{$tUser->email}}">
									</div>
								</div>
								<div class="form-group col-md-3">
									<label for="txtPrincipalRole">Tipo de usuario</label>
									<div class="input-group readonly">
										<div class="input-group-addon">
											<i class="fa fa-i-cursor"></i>
										</div>
										<input type="text" id="txtPrincipalRole" name="txtPrincipalRole" class="form-control pull-right" readonly="readonly" value="{{$tUser->role}}">
									</div>
								</div>
								<div class="form-group col-md-3">
									<label for="txtRegisterType">Tipo de registro</label>
									<div class="input-group readonly">
										<div class="input-group-addon">
											<i class="fa fa-i-cursor"></i>
										</div>
										<input type="text" id="txtRegisterType" name="txtRegisterType" class="form-control pull-right" readonly="readonly" value="{{$tUser->registerType}}">
									</div>
								</div>
								<div class="form-group col-md-3">
									<label for="dateCreatedAt">Fecha de reg.</label>
									<div class="input-group readonly">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" id="dateCreatedAt" name="dateCreatedAt" class="form-control pull-right" readonly="readonly" value="{{ViewHelper::getDateFormat($tUser->created_at, 'd-m-Y H:i:s')}}">
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								{!!csrf_field()!!}
								<div class="col-md-12 text-right">
									<input type="button" class="btn btn-primary" value="Guardar cambios realizados" onclick="sendFrmEditUser();">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="tab02">
				<form id="frmChangeEmailUser" action="{{url('user/changeemail')}}" method="post">
					<div id="divSendMessageResponse" class="row" style="display: none;">
						<div class="col-md-12"></div>
					</div>
					<div class="row">
						<div class="form-group col-md-3">
							<label for="txtEmailForChangeEmail">Nuevo correo electrónico*</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-envelope-o"></i>
								</div>
								<input type="text" id="txtEmailForChangeEmail" name="txtEmailForChangeEmail" class="form-control pull-right">
							</div>
							<div><a href="#" onclick="getEmailChangeCode();">Obtener código de confirmación</a><span> ***Este código le será enviado al correo ingresado.</span></div>
						</div>
						<div class="form-group col-md-3">
							<label for="txtEmailChangeCodeForChangeEmail">Código de confirmación*</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-dot-circle-o"></i>
								</div>
								<input type="text" id="txtEmailChangeCodeForChangeEmail" name="txtEmailChangeCodeForChangeEmail" class="form-control pull-right">
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="passPasswordForChangeEmail">Contraseña*</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-keyboard-o"></i>
								</div>
								<input type="password" id="passPasswordForChangeEmail" name="passPasswordForChangeEmail" class="form-control pull-right">
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="form-group col-md-12 text-right">
							{{csrf_field()}}
							<input type="button" class="btn btn-primary" value="Guardar cambios" onclick="sendFrmChangeEmailUser();">
						</div>
					</div>
				</form>
			</div>
			<div class="tab-pane" id="tab03">
				<form id="frmChangePasswordUser" action="{{url('user/changepassword')}}" method="post">
					<div class="row">
						<div class="form-group col-md-4">
							<label for="passPassword">Contraseña actual*</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-keyboard-o"></i>
								</div>
								<input type="password" id="passPassword" name="passPassword" class="form-control pull-right">
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="passPasswordNew">Nueva contraseña*</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-keyboard-o"></i>
								</div>
								<input type="password" id="passPasswordNew" name="passPasswordNew" class="form-control pull-right">
							</div>
						</div>
						<div class="form-group col-md-4">
							<label for="passPasswordNewRepeat">Repita nueva contraseña</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-keyboard-o"></i>
								</div>
								<input type="password" id="passPasswordNewRepeat" name="passPasswordNewRepeat" class="form-control pull-right">
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-12 text-right">
							{!!csrf_field()!!}
							<input type="button" class="btn btn-primary" value="Actualizar mi contraseña" onclick="sendFrmChangePasswordUser();">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
@endsection
@section('jsSection')
<script src="{{asset('viewResources/user/edit.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
@endsection