<?php
namespace App\Http\Controllers;

use App\Object\DtoMessage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $_so;
	protected $_currentDate;

	public function __construct()
	{
		$this->_so=new \stdClass();
		
		$this->_so->mo=new DtoMessage();
		$this->_so->dto=new \stdClass();

		$this->_currentDate=date('Y-m-d H:i:s');
	}
}
