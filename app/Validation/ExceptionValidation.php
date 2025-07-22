<?php
namespace App\Validation;

use App\Models\TException;

class ExceptionValidation
{
	private $globalMessage=[];

	public function validationChangeStatus($status)
	{
		if(!in_array($status, ['Atendido']))
		{
			$this->globalMessage[]=config('var.MESSAGE_ATTACK');
		}

		return $this->globalMessage;
	}
}
?>