<?php

namespace App\Validation;

use App\Models\TUser;
use Illuminate\Support\Facades\Validator;

class UserValidation
{
	private $globalMessage = [];

	public function validationInsert($request)
	{
		$validator = Validator::make(
			[
				'email' => trim($request->input('txtEmailRegisterLayout')),
				'firstName' => trim($request->input('txtFirstNameRegisterLayout')),
				'surName' => trim($request->input('txtSurNameRegisterLayout')),
				'password' => $request->input('passPasswordRegisterLayout')
			],
			[
				'email' => ['required', 'regex:/^([a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.([a-zA-Z0-9\-_]+\.)?[a-zA-Z]+(\.[a-zA-Z]+)?)?$/', 'unique:tuser,email'],
				'firstName' => ['required'],
				'surName' => ['required'],
				'password' => ['required']
			],
			[
				'email.required' => 'El campo "email" es requerido.',
				'email.regex' => 'El campo "email" no cumple con la expresión necesaria.',
				'email.unique' => 'El usuario ya se encuentra registrado en la plataforma (Correo electrónico del usuario existente).',
				'firstName.required' => 'El campo "firstName" es requerido.',
				'surName.required' => 'El campo "surName" es requerido.',
				'password.required' => 'El campo "password" es requerido.'
			]
		);

		if ($validator->fails()) {
			$errors = $validator->errors()->all();

			foreach ($errors as $value) {
				$this->globalMessage[] = $value;
			}
		}

		return $this->globalMessage;
	}

	public function validationInsertAsAdmin($request)
	{
		$validator = Validator::make(
			[
				'email' => trim($request->input('txtEmail')),
				'firstName' => trim($request->input('txtFirstName')),
				'surName' => trim($request->input('txtSurName')),
				'password' => $request->input('passPassword'),
				'level' => $request->input('selectLevel'),
				'idProvince' => $request->input('selectProvince'),
				'idDistrict' => $request->input('selectDistrict')
			],
			[
				'email' => ['required', 'regex:/^([a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.([a-zA-Z0-9\-_]+\.)?[a-zA-Z]+(\.[a-zA-Z]+)?)?$/', 'unique:tuser,email'],
				'firstName' => ['required'],
				'surName' => ['required'],
				'password' => ['required'],
				'level' => ['nullable'],
				'idProvince' => ['nullable'],
				'idDistrict' => ['nullable'],
			],
			[
				'email.required' => 'El campo "email" es requerido.',
				'email.regex' => 'El campo "email" no cumple con la expresión necesaria.',
				'email.unique' => 'El usuario ya se encuentra registrado en la plataforma (Correo electrónico del usuario existente).',
				'firstName.required' => 'El campo "firstName" es requerido.',
				'surName.required' => 'El campo "surName" es requerido.',
				'password.required' => 'El campo "password" es requerido.',
			]
		);

		if ($validator->fails()) {
			$errors = $validator->errors()->all();

			foreach ($errors as $value) {
				$this->globalMessage[] = $value;
			}
		}

		return $this->globalMessage;
	}

	public function validationEdit($request, $idUser)
	{
		$validator = Validator::make(
			[
				'email' => trim($request->input('txtEmail')),
				'firstName' => trim($request->input('txtFirstName')),
				'surName' => trim($request->input('txtSurName')),
			],
			[
				'email' => ['required', 'regex:/^([a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.([a-zA-Z0-9\-_]+\.)?[a-zA-Z]+(\.[a-zA-Z]+)?)?$/', 'unique:tuser,email,' . $idUser . ',idUser'],
				'firstName' => ['required'],
				'surName' => ['required']
			],
			[
				'email.required' => 'El campo "email" es requerido.',
				'email.regex' => 'El campo "email" no cumple con la expresión necesaria.',
				'email.unique' => 'El usuario ya se encuentra registrado en la plataforma (Correo electrónico del usuario existente).',
				'firstName.required' => 'El campo "firstName" es requerido.',
				'surName.required' => 'El campo "surName" es requerido.'
			]
		);

		if ($validator->fails()) {
			$errors = $validator->errors()->all();

			foreach ($errors as $value) {
				$this->globalMessage[] = $value;
			}
		}

		return $this->globalMessage;
	}

	public function validationEditAsAdmin($request, $idUser)
	{
		$validator = Validator::make(
			[
				'email' => trim($request->input('txtEmail')),
				'firstName' => trim($request->input('txtFirstName')),
				'surName' => trim($request->input('txtSurName'))
			],
			[
				'email' => ['required', 'regex:/^([a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.([a-zA-Z0-9\-_]+\.)?[a-zA-Z]+(\.[a-zA-Z]+)?)?$/', 'unique:tuser,email,' . $idUser . ',idUser'],
				'firstName' => ['required'],
				'surName' => ['required']
			],
			[
				'email.required' => 'El campo "email" es requerido.',
				'email.regex' => 'El campo "email" no cumple con la expresión necesaria.',
				'email.unique' => 'El usuario ya se encuentra registrado en la plataforma (Correo electrónico del usuario existente).',
				'firstName.required' => 'El campo "firstName" es requerido.',
				'surName.required' => 'El campo "surName" es requerido.'
			]
		);

		if ($validator->fails()) {
			$errors = $validator->errors()->all();

			foreach ($errors as $value) {
				$this->globalMessage[] = $value;
			}
		}

		if (!in_array($request->input('cbxStatus'), ['Activo', 'Pendiente', 'Bloqueado'])) {
			$this->globalMessage[] = config('var.MESSAGE_ATTACK');
		}

		return $this->globalMessage;
	}
}
