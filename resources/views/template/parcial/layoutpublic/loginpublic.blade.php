<div id="modalAccess" class="modal fade" data-backdrop="false" data-keyboard="false" tabindex="-1">
	<div class="modal-dialog modal-sm" style="min-width: 400px;">
		<div class="modal-content" style="border-radius: 7px;padding: 40px;padding-bottom: 30px;padding-top: 5px;">
			<div class="modal-header" style="border: none;padding-bottom: 0px;">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 30px;position: absolute;right: 10px;top: 7px;"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="codiTabs">
					<a href="#" attr-content="codiLoginTab" class="codiTabsActive">Iniciar sesión</a>
					<a href="#" attr-content="codiRegisterTab">Registro</a>
				</div>
				<div id="codiLoginTab">
					<form id="frmLogIn" action="{{url('user/login')}}" method="post">
						<div class="row">
							<div class="form-group col-md-12">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-envelope-o"></i>
									</div>
									<input type="text" id="txtEmailLogInLayout" name="txtEmailLogInLayout" class="form-control pull-right" placeholder="Correo electrónico*">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-keyboard-o"></i>
									</div>
									<input type="password" id="passPasswordLogInLayout" name="passPasswordLogInLayout" class="form-control pull-right" placeholder="Contraseña*" onkeyup="if(keyUpEnter(event)){ sendFrmLogIn(); }">
								</div>
							</div>
						</div>
						{{csrf_field()}}
						<button type="button" class="btn btn-primary btn-block" onclick="sendFrmLogIn();" style="border-radius: 20px;margin-bottom: 20px;margin-top: 15px;">ACCEDER A LA PLATAFORMA</button>
						<div class="row">
							<div class="form-group col-md-12 text-center" style="margin-bottom: 0px;">
								<a href="{{url('user/recoverypassword')}}" style="color: #8e8e8e;">Recuperar mi contraseña</a>
							</div>
						</div>
					</form>
				</div>
				<div id="codiRegisterTab" style="display: none;">
					<form id="frmInsertUserFromLoginModal" action="{{url('user/insert')}}" method="post">
					<div class="row">
							<div class="form-group col-md-12">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-user-o"></i>
									</div>
									<input type="text" id="txtFirstNameRegisterLayout" name="txtFirstNameRegisterLayout" class="form-control pull-right" placeholder="Nombre*">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-user-o"></i>
									</div>
									<input type="text" id="txtSurNameRegisterLayout" name="txtSurNameRegisterLayout" class="form-control pull-right" placeholder="Apellido*">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-envelope-o"></i>
									</div>
									<input type="text" id="txtEmailRegisterLayout" name="txtEmailRegisterLayout" class="form-control pull-right" placeholder="Correo electrónico*">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-keyboard-o"></i>
									</div>
									<input type="password" id="passPasswordRegisterLayout" name="passPasswordRegisterLayout" class="form-control pull-right" placeholder="Contraseña*">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-12">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-keyboard-o"></i>
									</div>
									<input type="password" id="passPasswordRegisterLayoutRepeat" name="passPasswordRegisterLayoutRepeat" class="form-control pull-right" placeholder="Repita contraseña*">
								</div>
							</div>
						</div>
						{{csrf_field()}}
						Al hacer clic en "Registrarme", afirmas que estás aceptando nuestros <a href="{{url('general/privacy')}}" target="_blank">Términos y condiciones</a>.
						<button type="button" class="btn btn-primary btn-block" onclick="sendFrmInsertUserFromLoginModal();" style="border-radius: 20px;margin-bottom: 20px;margin-top: 15px;">REGISTRARME</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>