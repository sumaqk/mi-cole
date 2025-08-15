<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

use App\Models\TUser;
use App\Models\TUserNotification;
use App\Models\TConfiguration;

class GenericMiddleware
{
	public function handle($request, Closure $next, ...$params)
	{
		// PERMITIR ACCESO PÚBLICO A STORAGE Y CONTENIDO EDUCATIVO
		$publicPaths = ['storage/', 'uploads/', 'assets/', 'css/', 'js/', 'images/'];
		
		foreach ($publicPaths as $path) {
			if (str_starts_with($request->path(), $path)) {
				return $next($request);
			}
		}

		if(Session::has('idUser'))
		{
			$tUser=TUser::find(Session::get('idUser'));

			if($tUser->status=='Bloqueado')
			{
				Session::flush();
			}
			else
			{
				if($tUser->lastAccess!=date('Y-m-d'))
				{
					$tUser->lastAccess=date('Y-m-d');

					$tUser->save();

					Session::put('lastAccess', $tUser->lastAccess);
				}

				if(str_replace(' ', '_', str_replace(':', '-', $tUser->updated_at))!=Session::get('lastUpdate'))
				{
					Session::put('email', $tUser->email);
					Session::put('firstName', $tUser->firstName);
					Session::put('surName', $tUser->surName);
					Session::put('fullName', $tUser->firstName.' '.$tUser->surName);
					Session::put('avatarExtension', $tUser->avatarExtension);
					Session::put('mainRole', $tUser->role);
					Session::put('lastUpdate', str_replace(' ', '_', str_replace(':', '-', $tUser->updated_at)));
				}
			}
		}

		$url=explode('/', $request->url());

		$domain=$url[1].$url[2];

		if($domain!='localhost' && !preg_match('/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+(:[0-9]+)?$/', $domain) && !preg_match('/^localhost:[0-9]+$/', $domain) && preg_match('/\/public+$/', $request->url()))
		{
			$positionTemp=strpos($request->url(), '/public');

			$tempUrl=substr_replace($request->url(), '', $positionTemp, strlen('/public'));

			return redirect($tempUrl);
		}

		$urlAccess=false;

		$allowUrl=
		[
			['Público', 'index/home', 'mHome', null],
			['Público', 'index/index', 'mHome', null],
			['Normal', 'index/indexadmin', 'mControlPanel', 'miHome'],

			['Público', 'general/privacy', null, null],
			['Público', 'general/accesserror', null, null],
			['Súper usuario,Administrador', 'general/backup', null, null],
			['Público', 'general/search', null, null],
			['Público', 'general/contact', 'mContactUs', null],

			['Público', 'user/login', null, null],
			['Público', 'user/loginasadmin', null, null],
			['Público', 'user/logout', null, null],
			['Público', 'user/recoverypassword', null, null],
			['Público', 'user/getrecoverycode', null, null],
			['Normal', 'user/changeemail', null, null],
			['Normal', 'user/getemailchangecode', null, null],
			['Público', 'user/insert', null, null],
			['Súper usuario,Administrador', 'user/insertasadmin', 'mUserModule', 'miUserInsertAsAdmin'],
			['Público', 'user/thanksregister', null, null],
			['Público', 'user/registerconfirmation', null, null],
			['Normal', 'user/edit', null, null],
			['Súper usuario,Administrador', 'user/editasadmin', null, null],
			['Normal', 'user/uploadavatar', null, null],
			['Normal', 'user/changepassword', null, null],
			['Súper usuario,Administrador', 'user/getall', 'mUserModule', 'miUserGetAll'],
			['Súper usuario,Administrador', 'user/deleteinactive', null, null],
			
			['Normal', 'user/filterbyfirstnamesurnameemail', null, null],

			['Normal', 'usernotification/read', null, null],
			['Normal', 'usernotification/readall', null, null],
			['Normal', 'usernotification/seebyscroll', null, null],
			['Normal', 'usernotification/verify', null, null],

			['Súper usuario', 'configuration/management', 'mControlPanel', 'miConfigurationManagement'],
			['Súper usuario,Administrador', 'exception/getall', 'mControlPanel', 'miExceptionGetAll'],
			['Súper usuario,Administrador', 'exception/changestatus', null, null],
			['Súper usuario,Administrador', 'user/export', 'mUserModule', null],
			
			['Normal', 'water/insert', 'mWater', null],
			['Súper usuario,Administrador,Supervisor', 'water/getall', 'mWaterModule', 'miWaterModuleGetAll'],
			['Súper usuario,Administrador,Supervisor', 'water/detail', 'mWaterModule', 'miWaterModuleGetAll'],
			['Súper usuario,Administrador,Supervisor', 'water/export', null, null],
			['Súper usuario,Administrador,Supervisor', 'water/export-detailed', null, null],

			['Normal', 'district/chgtoinsertwater', null, null],

			// RUTAS DE INSTITUTION - CORREGIDAS Y COMPLETAS
			['Súper usuario,Administrador', 'institution/getall', 'mInstitutionModule', 'miInstitutionModuleGetAll'],
			['Súper usuario,Administrador', 'institution/insert', 'mInstitutionModule', null],
			['Súper usuario,Administrador', 'institution/edit', 'mInstitutionModule', null],
			['Súper usuario,Administrador', 'institution/update', 'mInstitutionModule', null],
			['Súper usuario,Administrador', 'institution/delete', 'mInstitutionModule', null],
			['Súper usuario,Administrador', 'institution/toggle-status', 'mInstitutionModule', null],
			['Súper usuario,Administrador', 'institution/export', 'mInstitutionModule', null],
			['Súper usuario,Administrador', 'institution/getdistricts', null, null],
			['Súper usuario,Administrador', 'institution/getugels', null, null],
			['Súper usuario,Administrador', 'institution/usermanagement', 'mInstitutionModule', null],
			['Normal', 'institution/chgtoinsertwater', null, null],
			

			// RUTAS DE UGEL - AGREGADAS
			['Súper usuario,Administrador', 'ugel/getall', 'mUgelModule', 'miUgelModuleGetAll'],
			['Súper usuario,Administrador', 'ugel/insert', 'mUgelModule', null],
			['Súper usuario,Administrador', 'ugel/edit', 'mUgelModule', null],
			['Súper usuario,Administrador', 'ugel/update', 'mUgelModule', null],
			['Súper usuario,Administrador', 'ugel/delete', 'mUgelModule', null],
			['Súper usuario,Administrador', 'ugel/toggle-status', 'mUgelModule', null],
			['Súper usuario,Administrador', 'ugel/getdistricts', null, null],

			/// RUTAS DE DISTRICT - AGREGAR DESPUÉS DE UGEL
			['Súper usuario,Administrador', 'district/getall', 'mDistrictModule', 'miDistrictModuleGetAll'],
			['Súper usuario,Administrador', 'district/insert', 'mDistrictModule', null],
			['Súper usuario,Administrador', 'district/edit', 'mDistrictModule', null],
			['Súper usuario,Administrador', 'district/update', 'mDistrictModule', null],
			['Súper usuario,Administrador', 'district/delete', 'mDistrictModule', null],
			['Normal', 'district/chgtoinsertwater', null, null],

			// Para contenido
			['Súper usuario,Administrador', 'contenidoweb/videos', 'mContenidoWebModule', 'miContenidoWebVideos'],
			['Súper usuario,Administrador', 'contenidoweb/videos/insert', 'mContenidoWebModule', null],
			['Súper usuario,Administrador', 'contenidoweb/videos/edit', 'mContenidoWebModule', null],
			['Súper usuario,Administrador', 'contenidoweb/videos/update', 'mContenidoWebModule', null],
			['Súper usuario,Administrador', 'contenidoweb/videos/delete', 'mContenidoWebModule', null],

			['Súper usuario,Administrador', 'contenidoweb/contenido', 'mContenidoWebModule', 'miContenidoWebContenido'],
			['Súper usuario,Administrador', 'contenidoweb/contenido/insert', 'mContenidoWebModule', null],
			['Súper usuario,Administrador', 'contenidoweb/contenido/edit', 'mContenidoWebModule', null],
			['Súper usuario,Administrador', 'contenidoweb/contenido/update', 'mContenidoWebModule', null],
			['Súper usuario,Administrador', 'contenidoweb/contenido/delete', 'mContenidoWebModule', null],
			['Súper usuario,Administrador', 'contenidoweb/contenido/toggle-status', 'mContenidoWebModule', null],
			['Súper usuario,Administrador', 'contenidoweb/contenido/toggle-featured', 'mContenidoWebModule', null],
		];

		$myMainRole=Session::get('mainRole', '');
		$myMainRole=$myMainRole=='' ? (Session::has('mainRole') ? 'Normal' : 'Público') : $myMainRole;

		foreach($allowUrl as $value)
		{
			if($params[0]==$value[1])
			{
				if($value[0]=='Público' || (strpos($value[0], 'Normal')!==false && Session::has('mainRole')))
				{
					$urlAccess=true;

					Session::put('menuItemParentSelected', $value[2]);
					Session::put('menuItemChildSelected', $value[3]);

					if(count($value)>4)
					{
						Session::put('menuItemSubChildSelected', $value[4]);
					}
					else
					{
						Session::forget('menuItemSubChildSelected');
					}

					break;
				}

				foreach(explode(',', $value[0]) as $item)
				{
					if(in_array($item, explode(',', $myMainRole)))
					{
						$urlAccess=true;

						Session::put('menuItemParentSelected', $value[2]);
						Session::put('menuItemChildSelected', $value[3]);

						if(count($value)>4)
						{
							Session::put('menuItemSubChildSelected', $value[4]);
						}
						else
						{
							Session::forget('menuItemSubChildSelected');
						}

						break;
					}
				}
			}
		}

		if(!$urlAccess)
		{
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest')
			{
				echo '<div class="alert alert-danger alert-dismissible"><h4><i class="icon fa fa-ban"></i> Aviso importante!</h4>No tiene autorización para realizar esta operación o su "sesión de usuario" ya ha finalizado.</div>';exit;
			}
			else
			{
				return redirect('user/loginasadmin');
			}
		}

		if(Session::has('idUser'))
		{
			$listTUserNotificationFmMdl=TUserNotification::whereRaw('idUser=?', [Session::get('idUser')])->orderBy('idUserNotification', 'desc')->take(10)->get();
			$quantityTUserNotificationUnreadFmMdl=TUserNotification::whereRaw('idUser=? and status=?', [Session::get('idUser'), false])->count();

			view()->share('listTUserNotificationFmMdl', $listTUserNotificationFmMdl);
			view()->share('quantityTUserNotificationUnreadFmMdl', $quantityTUserNotificationUnreadFmMdl);
		}

		view()->share('tConfigurationFmMdl', TConfiguration::first());

		return $next($request);
	}
}