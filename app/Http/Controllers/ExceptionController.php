<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;

use App\Validation\ExceptionValidation;

use App\Models\TException;

class ExceptionController extends Controller
{
	public function actionGetAll()
	{
		$listTException=TException::with(['tuser'])->orderBy('idException', 'desc')->get();

		return view('exception/getall', ['listTException' => $listTException]);
	}

	public function actionChangeStatus($idException, $status)
	{
		$this->_so->mo->listMessage=(new ExceptionValidation())->validationChangeStatus($status);

		$tException=TException::find($idException);

		if($tException==null)
		{
			$this->_so->mo->listMessage[]='Excepción inexistente.';
		}

		if($this->_so->mo->existsMessage())
		{
			return PlatformHelper::redirectError($this->_so->mo->listMessage, 'exception/getall');
		}

		$tException->status=$status;

		$tException->save();

		return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'exception/getall');
	}
}
?>