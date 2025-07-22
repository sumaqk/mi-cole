<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

use App\Validation\UserValidation;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\TUser;
use App\Models\TProvince;
use App\Models\TDistrict;

class UserController extends Controller
{
	public function actionLogIn(Request $request, SessionManager $sessionManager)
	{
		$sessionManager->flush();

		$tUser = TUser::whereRaw('email=?', [trim($request->input('txtEmailLogInLayout'))])->first();

		if ($tUser != null && $tUser->status == 'Activo') {
			if (Hash::check($request->input('passPasswordLogInLayout'), $tUser->password)) {
				$sessionManager->put('idUser', $tUser->idUser);
				$sessionManager->put('email', $tUser->email);
				$sessionManager->put('firstName', $tUser->firstName);
				$sessionManager->put('surName', $tUser->surName);
				$sessionManager->put('fullName', $tUser->firstName . ' ' . $tUser->surName);
				$sessionManager->put('avatarExtension', $tUser->avatarExtension);
				$sessionManager->put('mainRole', $tUser->role);
				$sessionManager->put('lastUpdate', str_replace(' ', '_', str_replace(':', '-', $tUser->updated_at)));

				if ($tUser->role == 'Normal') {
					return PlatformHelper::redirectCorrect(['Bienvenido a la plataforma, ' . $tUser->firstName . '.'], 'water/insert');
				} else {
					return PlatformHelper::redirectCorrect(['Bienvenido a la plataforma, ' . $tUser->firstName . '.'], '/');
				}
			}
		}

		if ($tUser != null && $tUser->status == 'Bloqueado') {
			return PlatformHelper::redirectError(['Su usuario fue bloqueado. Para más información, envíe un mensaje a la plataforma.'], '/');
		}

		return PlatformHelper::redirectError(['Usuario o contraseña incorrecto o no has confirmado tu registro.'], '/');
	}

	public function actionLogInAsAdmin(Request $request, SessionManager $sessionManager)
	{
		if ($_POST) {
			$sessionManager->flush();

			$tUser = TUser::with(['tinstitutiontuser'])->whereRaw('email=?', [trim($request->input('txtEmail'))])->first();

			if ($tUser != null && $tUser->status == 'Activo') {
				if (Hash::check($request->input('passPassword'), $tUser->password)) {
					if (count($tUser->tinstitutiontuser) == 0 && strpos($tUser->role, 'Súper usuario') === false && strpos($tUser->role, 'Administrador') === false && strpos($tUser->role, 'Supervisor') === false) {
						return PlatformHelper::redirectError(['Su usuario aún no fue asignado a ninguna institución.'], 'user/loginasadmin');
					}

					$sessionManager->put('idUser', $tUser->idUser);
					$sessionManager->put('email', $tUser->email);
					$sessionManager->put('firstName', $tUser->firstName);
					$sessionManager->put('surName', $tUser->surName);
					$sessionManager->put('fullName', $tUser->firstName . ' ' . $tUser->surName);
					$sessionManager->put('idProvince', $tUser->idProvince);
					$sessionManager->put('idDistrict', $tUser->idDistrict);
					$sessionManager->put('level', $tUser->level);
					$sessionManager->put('avatarExtension', $tUser->avatarExtension);
					$sessionManager->put('mainRole', $tUser->role);
					$sessionManager->put('lastUpdate', str_replace(' ', '_', str_replace(':', '-', $tUser->updated_at)));

					if ($tUser->role == 'Normal') {
						return PlatformHelper::redirectCorrect(['Bienvenido a la plataforma, ' . $tUser->firstName . '.'], 'water/insert');
					} elseif ($tUser->role == 'Supervisor') {
						return PlatformHelper::redirectCorrect(['Bienvenido a la plataforma, ' . $tUser->firstName . '.'], 'water/getall'); // Redirige a la misma vista, pero con restricciones
					} else {
						return PlatformHelper::redirectCorrect(['Bienvenido a la plataforma, ' . $tUser->firstName . '.'], 'index/indexadmin');
					}
				}
			}

			if ($tUser != null && $tUser->status == 'Bloqueado') {
				return PlatformHelper::redirectError(['Su usuario fue bloqueado. Para más información, envíe un mensaje a la plataforma.'], 'user/loginasadmin');
			}

			return PlatformHelper::redirectError(['Usuario o contraseña incorrecto o no has confirmado tu registro.'], 'user/loginasadmin');
		}

		$arrayFileNameToBanner = [];

		foreach (glob(public_path() . '/img/loginBanner/*.*') as $fileName) {
			$arrayPathTemp = explode('/', $fileName);

			$arrayFileNameToBanner[] = $arrayPathTemp[count($arrayPathTemp) - 1];
		}

		return view(
			'user/loginasadmin',
			[
				'arrayFileNameToBanner' => $arrayFileNameToBanner
			]
		);
	}

	public function actionLogOut(SessionManager $sessionManager)
	{
		$sessionManager->flush();

		return PlatformHelper::redirectCorrect(['Sesión cerrada correctamente.'], 'user/loginasadmin');
	}

	public function actionInsert(Request $request)
	{
		try {
			DB::beginTransaction();

			$this->_so->mo->listMessage = (new UserValidation())->validationInsert($request);

			if ($this->_so->mo->existsMessage()) {
				DB::rollBack();

				return PlatformHelper::redirectError($this->_so->mo->listMessage, '/');
			}

			$tUser = new TUser();

			$tUser->idUser = uniqid();
			$tUser->firstName = trim($request->input('txtFirstNameRegisterLayout'));
			$tUser->surName = trim($request->input('txtSurNameRegisterLayout'));
			$tUser->email = trim($request->input('txtEmailRegisterLayout'));
			$tUser->password = Hash::make($request->input('passPasswordRegisterLayout'));
			$tUser->avatarExtension = 'png';
			$tUser->confirmCode = PlatformHelper::randomString(20);
			$tUser->recoveryCode = '';
			$tUser->recoveryExpirationDate = '1991-01-01';
			$tUser->emailChangeCode = '';
			$tUser->emailChangeExpirationDate = '1991-01-01';
			$tUser->registerType = 'Plataforma';
			$tUser->blockingReason = '';
			$tUser->lastAccess = '1991-01-01';
			$tUser->role = 'Normal';
			$tUser->status = 'Pendiente';

			$tUser->save();

			$messageBody = 'Para confirmar su registro en la plataforma, acceda al siguiente enlace. Si no puede acceder directamente al enlace de abajo, por favor copie y pegue la URL en una nueva pestaña de su navegador.<br><br>'
				. '<a href="' . url('user/registerconfirmation') . '/' . $tUser->email . '/' . $tUser->confirmCode . '">' . url('user/registerconfirmation') . '/' . $tUser->email . '/' . $tUser->confirmCode . '</a>'
				. '<br><br><b>Si Ud. no se ha registrado en esta plataforma, es posible que alguien esté intentando registrarse con su correo. Si es así, sólo no acceda al enlace de la parte superior y elimine este mensaje; con lo que se rechazará el intento de registro.</b>';

			Mail::send('email.other.generalmessage', ['firstNameUser' => $tUser->firstName, 'messageBody' => $messageBody], function ($x) use ($tUser) {
				$x->from(config('var.MAIL_USERNAME'), config('var.URL_GENERAL_SHOW'));
				$x->to($tUser->email, ($tUser->firstName) . ' ' . ($tUser->surName))->subject('Confirmación de registro de usuario');
			});

			copy(public_path() . '/img/avatar/user.png', public_path() . '/img/avatar/' . ($tUser->idUser) . '.png');

			DB::commit();

			return PlatformHelper::redirectCorrect(['Se le ha enviado un correo para confirmar su registro.'], 'user/thanksregister');
		} catch (\Exception $e) {
			DB::rollBack();

			return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
		}
	}

	public function actionInsertAsAdmin(Request $request)
	{
		if ($_POST) {
			try {
				DB::beginTransaction();

				$this->_so->mo->listMessage = (new UserValidation())->validationInsertAsAdmin($request);

				if ($this->_so->mo->existsMessage()) {
					DB::rollBack();

					return PlatformHelper::redirectError($this->_so->mo->listMessage, 'user/insertasadmin');
				}

				$tUser = new TUser();

				$tUser->idUser = uniqid();
				$tUser->firstName = trim($request->input('txtFirstName'));
				$tUser->surName = trim($request->input('txtSurName'));
				$tUser->email = trim($request->input('txtEmail'));
				$tUser->password = Hash::make($request->input('passPassword'));
				$tUser->avatarExtension = 'png';
				$tUser->confirmCode = '';
				$tUser->recoveryCode = '';
				$tUser->recoveryExpirationDate = '1991-01-01';
				$tUser->emailChangeCode = '';
				$tUser->emailChangeExpirationDate = '1991-01-01';
				$tUser->registerType = 'Plataforma';
				$tUser->blockingReason = '';
				$tUser->lastAccess = '1991-01-01';
				$tUser->role = (($request->input('selectRole') != null && $request->input('selectRole') != '') ? implode(',', $request->input('selectRole')) : '');
				$tUser->status = 'Activo';
				$tUser->level = !empty(trim($request->input('selectLevel'))) ? trim($request->input('selectLevel')) : null;
				$tUser->idProvince = !empty(trim($request->input('selectProvince'))) ? trim($request->input('selectProvince')) : null;
				$tUser->idDistrict = !empty(trim($request->input('selectDistrict'))) ? trim($request->input('selectDistrict')) : null;

				//dd($tUser);

				$tUser->save();

				copy(public_path() . '/img/avatar/user.png', public_path() . '/img/avatar/' . ($tUser->idUser) . '.png');

				DB::commit();

				return PlatformHelper::redirectCorrect(['Operación ralizada correctamente.'], 'user/insertasadmin');
			} catch (\Exception $e) {
				DB::rollBack();

				return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		$provinces = TProvince::all();  // Obtener todas las provincias

		return view('user/insertasadmin', compact('provinces'));
	}

	public function getDistrictsByProvince(Request $request)
	{
		$provinceId = $request->input('idProvince');

		// Obtener los distritos que pertenecen a la provincia seleccionada
		$districts = TDistrict::where('idProvince', $provinceId)->get();

		return response()->json($districts);  // Retornar los distritos en formato JSON
	}

	public function actionThanksRegister($confirmation = null)
	{
		return view('user/thanksregister', ['confirmation' => $confirmation]);
	}

	public function actionRegisterConfirmation($email, $confirmCode)
	{
		try {
			$tUser = TUser::whereRaw('email=? and confirmCode=? and status!=?', [$email, $confirmCode, 'Bloqueado'])->first();

			if ($tUser == null) {
				return PlatformHelper::redirectError(['La confirmación no fue posible porque el enlace a caducado o no es el correcto.'], '/');
			}

			$tUser->confirmCode = '';
			$tUser->status = 'Activo';

			$tUser->save();

			return PlatformHelper::redirectCorrect(['Su registro fue confirmado, ahora puedes iniciar sesión.'], 'user/thanksregister/confirmado');
		} catch (\Exception $e) {
			return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
		}
	}

	public function actionRecoveryPassword(Request $request)
	{
		if ($_POST) {
			try {
				$tUser = TUser::whereRaw('email=? and status=?', [$request->input('txtEmail'), 'Activo'])->first();

				if ($tUser == null) {
					$this->_so->mo->listMessage[] = 'Correo electrónico no registrado en la plataforma o aún no has confirmado tu registro.';
				}

				if ($tUser != null && ($tUser->recoveryCode != $request->input('txtRecoveryCode') || $tUser->recoveryExpirationDate < date('Y-m-d H:i:s'))) {
					$this->_so->mo->listMessage[] = 'El código de recuperación no es el correcto o este ya ha caducado. Por favor vuelva a solicitar otro código de recuperación.';
				}

				if ($this->_so->mo->existsMessage()) {
					$request->flash();

					return PlatformHelper::redirectError($this->_so->mo->listMessage, 'user/recoverypassword');
				}

				$tUser->password = Hash::make($request->input('passPassword'));
				$tUser->recoveryCode = '';
				$tUser->recoveryExpirationDate = date('Y-m-d H:i:s');

				$tUser->save();

				return PlatformHelper::redirectCorrect(['Recuperación de contraseña exitosa. Ahora puede iniciar sesión.'], '/');
			} catch (\Exception $e) {
				return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		return view('user/recoverypassword');
	}

	public function actionGetRecoveryCode(Request $request)
	{
		try {
			$tUser = TUser::whereRaw('email=? and status=?', [$request->input('email'), 'Activo'])->first();

			if ($tUser == null) {
				$this->_so->mo->listMessage[] = 'El correo electrónico ingresado no se encuentra registrado en la plataforma, aún no se ha confirmado su registro o está bloqueado.';
			}

			if ($this->_so->mo->existsMessage()) {
				return response()->json($this->_so);
			}

			$tUser->recoveryCode = PlatformHelper::randomString(20);
			$tUser->recoveryExpirationDate = PlatformHelper::addToDate(date('Y-m-d H:i:s'), 'hour', 1);

			$tUser->save();

			$messageBody = '';
			$messageBody .= 'Aquí te enviamos el código de recuperación para tu contraseña.<br><br>';
			$messageBody .= '<b>' . ($tUser->recoveryCode) . '</b><br><br>';
			$messageBody .= '<i>Si Ud. no solicitó este código, elimine este mensaje de su correo, ya que es posible que alguien más esté tratando de acceder a su cuenta en la plataforma.</i>';

			Mail::send('email.other.generalmessage', ['firstNameUser' => $tUser->firstName, 'messageBody' => $messageBody], function ($x) use ($tUser) {
				$x->from(config('var.MAIL_USERNAME'), config('var.URL_GENERAL_SHOW'));
				$x->to($tUser->email, ($tUser->firstName) . ' ' . ($tUser->surName))->subject('Código de recuperación de contraseña');
			});

			$this->_so->mo->listMessage[] = 'Se le ha enviado el código de recuperación al correo electrónico ingresado (Si no encuentra el mensaje en su bandeja principal, por favor revise su carpeta de spam).';
			$this->_so->mo->success();

			return response()->json($this->_so);
		} catch (\Exception $e) {
			return response()->json(PlatformHelper::catchExceptionJson(__CLASS__, __FUNCTION__, $e->getMessage()));
		}
	}

	public function actionChangeEmail(Request $request, SessionManager $sessionManager)
	{
		try {
			$tUser = TUser::whereRaw('email=?', [$request->input('txtEmailForChangeEmail')])->first();

			if ($tUser != null) {
				return PlatformHelper::redirectError(['El correo electrónico ingresado ya se encuentra registrado en la plataforma.'], 'user/edit');
			}

			$tUser = TUser::find($sessionManager->get('idUser'));

			if (!Hash::check($request->input('passPasswordForChangeEmail'), $tUser->password)) {
				return PlatformHelper::redirectError(['La contraseña ingresada es incorrecta.'], 'user/edit');
			}

			if ($tUser->emailChangeCode != $request->input('txtEmailChangeCodeForChangeEmail') || $tUser->emailChangeExpirationDate < date('Y-m-d H:i:s')) {
				return PlatformHelper::redirectError(['El código de confirmación no es el correcto o este ya ha caducado. Por favor vuelva a solicitar otro código de confirmación.'], 'user/edit');
			}

			$tUser->email = trim($request->input('txtEmailForChangeEmail'));
			$tUser->emailChangeCode = '';
			$tUser->emailChangeExpirationDate = date('Y-m-d H:i:s');

			$tUser->save();

			return PlatformHelper::redirectCorrect(['Cambio de correo exitoso. Ahora puede iniciar sesión con su nuevo correo.'], 'user/edit');
		} catch (\Exception $e) {
			return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
		}
	}

	public function actionGetEmailChangeCode(Request $request, SessionManager $sessionManager)
	{
		try {
			$tUser = TUser::whereRaw('email=?', [$request->input('email')])->first();

			if ($tUser != null) {
				$this->_so->mo->listMessage[] = 'El correo electrónico ingresado ya se encuentra registrado en la plataforma.';
			}

			if ($this->_so->mo->existsMessage()) {
				return response()->json($this->_so);
			}

			$tUser = TUser::find($sessionManager->get('idUser'));

			$tUser->emailChangeCode = PlatformHelper::randomString(20);
			$tUser->emailChangeExpirationDate = PlatformHelper::addToDate(date('Y-m-d H:i:s'), 'hour', 1);

			$tUser->save();

			$messageBody = '';
			$messageBody .= 'Aquí te enviamos el código de confirmación para tu cambio de correo.<br><br>';
			$messageBody .= '<b>' . ($tUser->emailChangeCode) . '</b><br><br>';
			$messageBody .= '<i>Si Ud. no solicitó este código, elimine este mensaje de su correo, ya que es posible que alguien más esté tratando de acceder a su cuenta en la plataforma.</i>';

			Mail::send('email.other.generalmessage', ['firstNameUser' => $tUser->firstName, 'messageBody' => $messageBody], function ($x) use ($tUser, $request) {
				$x->from(config('var.MAIL_USERNAME'), config('var.URL_GENERAL_SHOW'));
				$x->to($request->input('email'), ($tUser->firstName) . ' ' . ($tUser->surName))->subject('Código de confirmación de cambio de correo');
			});

			$this->_so->mo->listMessage[] = 'Se le ha enviado el código de confirmación al correo electrónico ingresado (Si no encuentra el mensaje en su bandeja principal, por favor revise su carpeta de spam).';
			$this->_so->mo->success();

			return response()->json($this->_so);
		} catch (\Exception $e) {
			return response()->json(PlatformHelper::catchExceptionJson(__CLASS__, __FUNCTION__, $e->getMessage()));
		}
	}

	public function actionEdit(Request $request, SessionManager $sessionManager)
	{
		if ($_POST) {
			try {
				$this->_so->mo->listMessage = (new UserValidation())->validationEdit($request, $sessionManager->get('idUser'));

				if ($this->_so->mo->existsMessage()) {
					return PlatformHelper::redirectError($this->_so->mo->listMessage, 'user/edit');
				}

				$tUser = TUser::find($sessionManager->get('idUser'));

				$tUser->firstName = trim($request->input('txtFirstName'));
				$tUser->surName = trim($request->input('txtSurName'));

				$tUser->save();

				return PlatformHelper::redirectCorrect(['Datos guardados correctamente.'], 'user/edit');
			} catch (\Exception $e) {
				return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'user/edit');
			}
		}

		$tUser = TUser::find($sessionManager->get('idUser'));

		return view('user/edit', ['tUser' => $tUser]);
	}

	public function actionEditAsAdmin(Request $request, SessionManager $sessionManager, $idUser = null)
	{
		if ($_POST) {
			try {
				$tUser = TUser::find($request->input('hdIdUser'));

				if ($tUser == null) {
					return PlatformHelper::redirectError([config('var.MESSAGE_ATTACK')], 'user/getall/1');
				}

				$this->_so->mo->listMessage = (new UserValidation())->validationEditAsAdmin($request, $request->input('hdIdUser'));

				if ($this->_so->mo->existsMessage()) {
					return PlatformHelper::redirectError($this->_so->mo->listMessage, 'user/editasadmin/' . $request->input('hdIdUser'));
				}

				if ($request->input('cbxStatus') != 'Activo' && $request->input('cbxStatus') != 'Pendiente' && $request->input('cbxStatus') != 'Bloqueado') {
					return PlatformHelper::redirectError([config('var.MESSAGE_ATTACK')], 'user/getall/1');
				}

				$oldRole = $tUser->role;

				$tUser->firstName = trim($request->input('txtFirstName'));
				$tUser->surName = trim($request->input('txtSurName'));
				$tUser->email = trim($request->input('txtEmail'));

				if (trim($request->input('txtPassword')) != '') {
					$tUser->password = Hash::make($request->input('txtPassword'));
				}

				$tUser->role = (($request->input('selectRole') != null && $request->input('selectRole') != '') ? implode(',', $request->input('selectRole')) : '');

				if (strpos($oldRole, 'Súper usuario') !== false) {
					if ($tUser->role != '') {
						$tUser->role = 'Súper usuario,' . $tUser->role;
					} else {
						$tUser->role = 'Súper usuario';
					}
				}

				$tUser->status = $request->input('cbxStatus');

				$tUser->save();

				return PlatformHelper::redirectCorrect(['Datos guardados correctamente.'], 'user/getall/1');
			} catch (\Exception $e) {
				return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'user/getall/1');
			}
		}

		$tUser = TUser::find($idUser);

		if ($tUser == null) {
			return PlatformHelper::redirectError(['Usuario inexistente.'], 'user/getall/1');
		}

		return view('user/editasadmin', ['tUser' => $tUser]);
	}

	public function actionUploadAvatar(Request $request, SessionManager $sessionManager)
	{
		try {
			DB::beginTransaction();

			if (!($request->hasFile('fileAvatar'))) {
				DB::rollBack();

				return PlatformHelper::redirectError(['No existe imagen seleccionada.'], 'user/edit');
			}

			if ($request->file('fileAvatar')->isValid() != 1) {
				DB::rollBack();

				return PlatformHelper::redirectError(['La imagen no es valida.'], 'user/edit');
			}

			$fileGetClientOriginalExtension = strtolower($request->file('fileAvatar')->getClientOriginalExtension());
			$fileGetSizeKb = (($request->file('fileAvatar')->getSize()) / 1024);

			if ($fileGetClientOriginalExtension != 'png' && $fileGetClientOriginalExtension != 'jpg' && $fileGetClientOriginalExtension != 'jpeg') {
				$this->_so->mo->listMessage[] = 'El formato de la imagen sólo debe ser "png, jpg o jpeg".';
			}

			if ($fileGetSizeKb > 700) {
				$this->_so->mo->listMessage[] = 'La imagen no debe pesar más de 700kb.';
			}

			if ($this->_so->mo->existsMessage()) {
				DB::rollBack();

				return PlatformHelper::redirectError($this->_so->mo->listMessage, 'user/edit');
			}

			$routeOldAvatar = public_path() . '/img/avatar/' . $sessionManager->get('idUser') . '.' . $sessionManager->get('avatarExtension');

			if (file_exists($routeOldAvatar)) {
				unlink($routeOldAvatar);
			}

			$tUser = TUser::find($sessionManager->get('idUser'));

			$tUser->avatarExtension = 'png';
			$tUser->updated_at = date('Y-m-d H:i:s');

			$tUser->save();

			$request->file('fileAvatar')->move(public_path() . '/img/avatar', $sessionManager->get('idUser') . '.png');

			DB::commit();

			return PlatformHelper::redirectCorrect(['Avatar actualizado correctamente.'], 'user/edit');
		} catch (\Exception $e) {
			DB::rollBack();

			return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'user/edit');
		}
	}

	public function actionChangePassword(Request $request, SessionManager $sessionManager)
	{
		try {
			$tUser = TUser::find($sessionManager->get('idUser'));

			// Verificar la contraseña actual
			if (!Hash::check($request->input('passPassword'), $tUser->password)) {
				return PlatformHelper::redirectError(['La contraseña actual es incorrecta.'], 'user/edit');
			}

			// Guardar la nueva contraseña hasheada
			$tUser->password = Hash::make($request->input('passPasswordNew'));
			$tUser->save();

			return PlatformHelper::redirectCorrect(['Contraseña cambiada correctamente.'], 'user/edit');
		} catch (\Exception $e) {
			return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'user/edit');
		}
	}

	public function actionGetAll(Request $request, $currentPage)
	{
		$searchParameter = $request->has('searchParameter') ? $request->input('searchParameter') : '';

		$paginate = PlatformHelper::preparePaginate(TUser::whereRaw('compareFind(concat(firstName, surName, email, registerType), ?, 77)=1', [$searchParameter])->orderByRaw('idUser desc'), 9, $currentPage);

		return view(
			'user/getall',
			[
				'listTUser' => $paginate['listRow'],
				'currentPage' => $paginate['currentPage'],
				'quantityPage' => $paginate['quantityPage'],
				'searchParameter' => $searchParameter
			]
		);
	}

	public function actionDeleteInactive()
	{
		try {
			$listTUser = TUser::whereRaw('status=? and dateadd(day, 1, created_at)<getdate()', ['Pendiente'])->get();

			TUser::whereRaw('status=? and dateadd(day, 1, created_at)<getdate()', ['Pendiente'])->delete();

			foreach ($listTUser as $key => $value) {
				unlink(public_path() . '/img/avatar/' . $value->idUser . '.' . $value->avatarExtension);
			}

			return PlatformHelper::redirectCorrect(['Usuarios inactivos eliminados correctamente.'], 'user/getall/1');
		} catch (\Exception $e) {
			return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), 'user/getall/1');
		}
	}

	public function actionFilterByFirstNameSurNameEmail(Request $request)
	{
		$listTUser = TUser::whereRaw('compareFind(concat(firstName, surName, email), ?, 77)=1 and status=?', [$request->input('q'), 'Activo'])->orderBy('firstName', 'asc')->orderBy('surName', 'asc')->take(10)->get();

		$result = [];

		foreach ($listTUser as $value) {
			$result[] = ['id' => $value->idUser, 'text' => ($value->firstName . ' ' . $value->surName . ' (' . explode('@', $value->email)[0] . ')'), 'idUser' => $value->idUser, 'email' => $value->email, 'fullName' => ($value->firstName . ' ' . $value->surName), 'avatarExtension' => $value->avatarExtension];
		}

		return response()->json($result);
	}
}
