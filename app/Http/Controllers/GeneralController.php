<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory;

class GeneralController extends Controller
{
	public function actionPrivacy()
	{
		return view('general/privacy');
	}

	public function actionAccessError()
	{
		return view('general/accesserror');
	}

	public function actionBackup(ResponseFactory $responseFactory)
	{
		$fileName='backup.sql';
		$fileNameDownload='backup_'.date('Y-m-d_H-i-s').'.sql';

		exec(config('var.COMMAND_BACKUP').' '.config('var.DB_DATABASE').' --password='.config('var.DB_PASSWORD').' --user='.config('var.DB_USERNAME').' --single-transaction > '.storage_path().'/'.$fileName);

		return $responseFactory->download(storage_path().'/'.$fileName, $fileNameDownload)->deleteFileAfterSend(true);
	}

	public function actionSearch(Request $request)
	{
		$listData=[];

		return view('general/search', ['listData' => $listData]);
	}
}
?>