<?php
namespace App\Helper;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use ZipArchive;
use RecursiveIteratorIterator;

use App\Object\DtoMessage;

use App\Models\TException;
use App\Models\TUser;

class PlatformHelper
{
	public static function redirectCorrect($message, $routeRedirect)
	{
		Session::flash('globalMessage', $message);
		Session::flash('type', 'success');

		return redirect($routeRedirect);
	}

	public static function redirectAlert($message, $routeRedirect)
	{
		Session::flash('globalMessage', $message);
		Session::flash('type', 'notice');

		return redirect($routeRedirect);
	}

	public static function redirectError($message, $routeRedirect)
	{
		Session::flash('globalMessage', $message);
		Session::flash('type', 'error');

		return redirect($routeRedirect);
	}

	public static function catchException($controller, $action, $ex, $routeRedirect)
	{
		try
		{
			$tException=new TException();

			$tException->idException=uniqid();
			$tException->idUser=Session::has('idUser') ? Session::get('idUser') : null;
			$tException->controller=$controller;
			$tException->action=$action;
			$tException->error=$ex;
			$tException->status='Pendiente';

			$tException->save();

			// if(!config('var.APP_DEBUG'))
			// {
			// 	$listTUser=TUser::whereRaw('role=?', ['Súper usuario'])->get();

			// 	foreach($listTUser as $value)
			// 	{
			// 		Mail::send('email.other.alert', ['type' => 'divAlertDanger', 'messageBody' => 'Excepción ocurrida en el sistema.'], function($x) use($value)
			// 		{
			// 			$x->from(config('var.MAIL_USERNAME'), 'eluyot@legado.gob.pe');
			// 			$x->to($value->email, $value->name.' '.$value->lastName)->subject('legado.gob.pe: Excepción ocurrida');
			// 		});
			// 	}
			// }

			Session::flash('globalMessage', [config('var.MESSAGE_EXCEPTION')]);
			Session::flash('type', 'exception');
		}
		catch(\Exception $e)
		{
			Session::flash('globalMessage', [config('var.MESSAGE_EXCEPTION')]);
			Session::flash('type', 'exception');
		}

		return redirect($routeRedirect);
	}

	public static function catchExceptionJson($controller, $action, $ex)
	{
		$_so=new \stdClass();
		
		$_so->mo=new DtoMessage();

		$_so->mo->listMessage[]=config('var.MESSAGE_EXCEPTION');
		$_so->mo->exception();

		try
		{
			$tException=new TException();

			$tException->idException=uniqid();
			$tException->idUser=Session::has('idUser') ? Session::get('idUser') : null;
			$tException->controller=$controller;
			$tException->action=$action;
			$tException->error=$ex;
			$tException->status='Pendiente';

			$tException->save();

			// if(!config('var.APP_DEBUG'))
			// {
			// 	$listTUser=TUser::whereRaw('role=?', ['Súper usuario'])->get();

			// 	foreach($listTUser as $value)
			// 	{
			// 		Mail::send('email.other.alert', ['type' => 'divAlertDanger', 'messageBody' => 'Excepción ocurrida en el sistema.'], function($x) use($value)
			// 		{
			// 			$x->from(config('var.MAIL_USERNAME'), 'eluyot@legado.gob.pe');
			// 			$x->to($value->email, $value->name.' '.$value->lastName)->subject('legado.gob.pe: Excepción ocurrida');
			// 		});
			// 	}
			// }
		}
		catch(\Exception $e){}

		return $_so;
	}

	public static function preparePaginate($query, $rowPage, $currentPage)
	{
		$rocordNumberShow=$rowPage;
		$currentPage=$currentPage<=0 ? 1 : $currentPage;
		$quantityPage=ceil(($query->count())/$rocordNumberShow);
		$currentPage=$currentPage>$quantityPage ? ($quantityPage > 0 ? $quantityPage : 1) : $currentPage;
		$listRow=$query->skip(($currentPage*$rocordNumberShow)-$rocordNumberShow)->take($rocordNumberShow)->get();
		$quantityPage=($quantityPage==0 ? 1 : $quantityPage);

		return ['listRow' => $listRow, 'currentPage' => $currentPage, 'quantityPage' => $quantityPage];
	}

	public static function randomString($length=10)
	{
		$characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength=strlen($characters);
		$randomString='';
		
		for($i=0; $i<$length; $i++)
		{
			$randomString.=$characters[rand(0, $charactersLength-1)];
		}

		return $randomString;
	}

	public static function addToDate($dateHour, $type, $quantity)
	{
		/*+7 year, +7 month, +7 day, +7 hour, +7 minute, +7 second*/
		$newDateHour=strtotime( '+'.$quantity.' '.$type , strtotime($dateHour));
		$newDateHour=date('Y-m-d H:i:s' , $newDateHour);

		return $newDateHour;
	}

	public static function hasMainRole($role)
	{
		return Session::has('mainRole') ? strpos(Session::get('mainRole'), $role)!==false : false;
	}

	public static function ajaxDataNoExists()
	{
		echo '<div class="alert alert-danger alert-dismissible"><h4><i class="icon fa fa-ban"></i> Prohibido!</h4>No se puede procesar esta petición porque no se encontraron datos.</div>';exit;
	}

	public static function ajaxDataMessage($message)
	{
		echo '<div class="alert alert-danger alert-dismissible"><h4><i class="icon fa fa-ban"></i> Prohibido!</h4>'.$message.'</div>';exit;
	}

	public static function deleteSaltCKEditor($html)
	{
		$description=trim($html);

		while(mb_substr($description, 0, 13)=='<p>&nbsp;</p>')
		{
			$description=mb_substr($description, 13, strlen($description));
		}

		$lengthDescription=strlen($description);

		while(mb_substr($description, $lengthDescription-13, 13)=='<p>&nbsp;</p>')
		{
			$description=mb_substr($description, 0, $lengthDescription-13);

			$lengthDescription=strlen($description);
		}

		return $description;
	}

	public static function getDateFormat($date, $formatOut='d-m-Y')
	{
		return date($formatOut, strtotime($date));
	}

	public static function deleteDir($dirPath)
	{
		if(!is_dir($dirPath))
		{
			return true;
		}

		if(substr($dirPath, strlen($dirPath)-1, 1)!='/')
		{
			$dirPath.='/';
		}

		$files=glob($dirPath.'*', GLOB_MARK);

		foreach($files as $file)
		{
			if(is_dir($file))
			{
				self::deleteDir($file);
			}
			else
			{
				unlink($file);
			}
		}

		rmdir($dirPath);

		return true;
	}

	public static function findValueOnObjectsArray($array, $column, $valueFind)
	{
		foreach($array as $value)
		{
			if($value->{$column}==$valueFind)
			{
				return true;
			}
		}

		return false;
	}

	public static function verifyReCaptchaV3($tokenRc)
	{
		$ch=curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => config('var.RECAPTCHA_SECRET'), 'response' => $tokenRc)));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response=curl_exec($ch);

		curl_close($ch);

		$arrResponse=json_decode($response, true);

		return ($arrResponse['success'] && $arrResponse['score']>=0.5);
	}

	public static function createZip($source, $destination)
	{
		if(!extension_loaded('zip') || !file_exists($source))
		{
			return false;
		}

		$zip=new ZipArchive();

		if(!$zip->open($destination, (ZIPARCHIVE::CREATE | ZipArchive::OVERWRITE)))
		{
			return false;
		}

		$source=str_replace('\\', '/', realpath($source));

		if(is_dir($source)===true)
		{
			$files=new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

			foreach($files as $file)
			{
				$file=str_replace('\\', '/', $file);

				if(in_array(substr($file, strrpos($file, '/')+1), array('.', '..')))
				{
					continue;
				}

				if(is_dir($file)===true)
				{
					$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
				}
				else
				{
					if(is_file($file)===true)
					{
						$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
					}
				}
			}
		}
		else
		{
			if(is_file($source)===true)
			{
				$zip->addFromString(basename($source), file_get_contents($source));
			}
		}

		return $zip->close();
	}
}
?>