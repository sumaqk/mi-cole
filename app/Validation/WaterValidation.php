<?php
namespace App\Validation;

use App\Models\TWater;
use Illuminate\Support\Facades\Validator;

class WaterValidation
{
	private $globalMessage=[];

	public function validationInsert($request)
	{
		$validator=Validator::make(
		[
			'txtResult' => trim($request->input('txtResult'))
		],
		[
			'txtResult' => ['required', 'regex:/^[0-1]\.[0-9]$/']
		],
		[
			'txtResult.required' => 'El campo "result" es requerido.',
			'txtResult.regex' => 'El campo "result" no cumple con la expresión necesaria.'
		]);

		if($validator->fails())
		{
			$errors=$validator->errors()->all();

			foreach($errors as $value)
			{
				$this->globalMessage[]=$value;
			}
		}

		return $this->globalMessage;
	}
}
?>