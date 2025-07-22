<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use Illuminate\Http\Request;
use Illuminate\Session\SessionManager;

use App\Models\TUserNotification;

class UserNotificationController extends Controller
{
	public function actionRead(SessionManager $sessionManager, $idUserNotification)
	{
		$tUserNotification=TUserNotification::find($idUserNotification);

		if($tUserNotification==null || ($tUserNotification!=null && $tUserNotification->idUser!=$sessionManager->get('idUser')))
		{
			return PlatformHelper::redirectError([config('var.MESSAGE_ATTACK')], '/');
		}

		$tUserNotification->status=true;

		$tUserNotification->save();

		return PlatformHelper::redirectCorrect(['La notificación fue marcada como leída.'], ($tUserNotification->url=='' ? '/' : $tUserNotification->url));
	}

	public function actionReadAll(SessionManager $sessionManager)
	{
		$tUserNotification=TUserNotification::where('idUser', '=', $sessionManager->get('idUser'))->update(['status' => true]);

		$this->_so->mo->listMessage[]='Todas las notificaciones fueron marcadas como leídas.';
		$this->_so->mo->success();

		return response()->json($this->_so);
	}

	public function actionSeeByScroll(Request $request, SessionManager $sessionManager)
	{
		$tUserNotification=TUserNotification::find($request->input('idUserNotification'));

		if($tUserNotification==null)
		{
			PlatformHelper::ajaxDataMessage('Por favor no trate de alterar el comportamiento del sistema.');
		}

		if($tUserNotification->idUser!=$sessionManager->get('idUser'))
		{
			PlatformHelper::ajaxDataMessage('Ud. no tiene autorización para listar estas notificationes.');
		}

		$listTUserNotification=TUserNotification::whereRaw('idUser=? and idUserNotification!=? and created_at<=?', [$sessionManager->get('idUser'), $request->input('idUserNotification'), $tUserNotification->created_at])->orderBy('created_at', 'desc')->take(10)->get();

		return view('usernotification/seebyscroll',
		[
			'listTUserNotification' => $listTUserNotification
		]);
	}

	public function actionVerify(Request $request, SessionManager $sessionManager)
	{
		$tUserNotification=TUserNotification::find($request->input('idUserNotification'));

		if($tUserNotification!=null && $tUserNotification->idUser!=$sessionManager->get('idUser'))
		{
			PlatformHelper::ajaxDataMessage('Ud. no tiene autorización para listar estas notificationes.');
		}

		$listTUserNotification=null;

		if($tUserNotification!=null)
		{
			$listTUserNotification=TUserNotification::whereRaw('idUser=? and idUserNotification!=? and created_at>=?', [$sessionManager->get('idUser'), $request->input('idUserNotification'), $tUserNotification->created_at])->orderBy('created_at', 'desc')->get();
		}
		else
		{
			$listTUserNotification=TUserNotification::whereRaw('idUser=?', [$sessionManager->get('idUser')])->orderBy('created_at', 'desc')->get();
		}

		$quantityTUserNotificationUnread=TUserNotification::whereRaw('idUser=? and !status', [$sessionManager->get('idUser')])->count();

		return view('usernotification/verify',
		[
			'listTUserNotification' => $listTUserNotification,
			'quantityTUserNotificationUnread' => $quantityTUserNotificationUnread
		]);
	}
}
?>