@extends('template.layout')
@section('title', 'Perfil de usuario')
@section('generalBody')
<div class="nav-tabs-custom">
	<div class="tab-content">
		<div class="row">
			<div class="col-md-3 text-center">
				<img src="{{asset('img/avatar/'.$tUser->idUser.'.'.$tUser->avatarExtension.'?x='.str_replace(' ', '_', str_replace(':', '-', $tUser->updated_at)))}}" height="170" width="170" style="border: 1px solid #999999;border-radius: 170px;">
			</div>
			<div class="col-md-9" style="border-left: 1px solid #999999;">
				<form id="frmEditUserAsAdmin" action="{{url('user/editasadmin')}}" method="post">
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
							<label for="txtEmail">Correo elect.*</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-user"></i>
								</div>
								<input type="text" id="txtEmail" name="txtEmail" class="form-control pull-right" value="{{$tUser->email}}">
							</div>
						</div>
						<div class="form-group col-md-3">
							<label for="cbxStatus">Estado*</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-info"></i>
								</div>
								<select name="cbxStatus" id="cbxStatus" class="form-control selectStaticNotClear" style="width: 100%;">
									<option value="Activo" {{$tUser->status=='Activo' ? 'selected' : ''}}>Activo</option>
									<option value="Pendiente" {{$tUser->status=='Pendiente' ? 'selected' : ''}}>Pendiente</option>
									<option value="Bloqueado" {{$tUser->status=='Bloqueado' ? 'selected' : ''}}>Bloqueado</option>
								</select>
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
							<label for="dateCreatedAt">Fecha de reg.</label>
							<div class="input-group readonly">
								<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</div>
								<input type="text" id="dateCreatedAt" name="dateCreatedAt" class="form-control pull-right" readonly="readonly" value="{{ViewHelper::getDateFormat($tUser->created_at, 'd-m-Y H:i:s')}}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-12">
							<label for="selectRole">Rol</label>
							<select id="selectRole" name="selectRole[]" class="form-control selectStatic" multiple style="width: 100%;">
								<option value="Administrador" {{strpos($tUser->role, 'Administrador')!==false ? 'selected' : ''}}>Administrador</option>
								<option value="Normal" {{strpos($tUser->role, 'Normal')!==false ? 'selected' : ''}}>Normal</option>
							</select>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="form-group col-md-12">
						<label for="txtPassword">Nueva contraseña</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-keyboard-o"></i>
								</div>
								<input type="text" id="txtPassword" name="txtPassword" class="form-control pull-right" placeholder="Al ingresar un valor aquí, se forzará el cambio de contraseña de este usuario">
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						{!!csrf_field()!!}
						<input type="hidden" name="hdIdUser" value="{{$tUser->idUser}}">
						<div class="col-md-12 text-right">
							<input type="button" class="btn btn-primary" value="Guardar cambios realizados" onclick="sendFrmEditUserAsAdmin();">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('jsSection')
<script src="{{asset('viewResources/user/editasadmin.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
@endsection