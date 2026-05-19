<?php

return [
    'required'  => 'El campo :attribute es obligatorio.',
    'email'     => 'El campo :attribute debe ser una dirección de correo válida.',
    'min'       => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'max'       => [
        'string' => 'El campo :attribute no puede tener más de :max caracteres.',
    ],
    'unique'    => 'El valor del campo :attribute ya está en uso.',
    'confirmed' => 'La confirmación del campo :attribute no coincide.',
    'in'        => 'El valor seleccionado en :attribute no es válido.',
    'string'    => 'El campo :attribute debe ser texto.',
    'integer'   => 'El campo :attribute debe ser un número entero.',
    'numeric'   => 'El campo :attribute debe ser numérico.',
    'image'     => 'El campo :attribute debe ser una imagen.',
    'mimes'     => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'array'     => 'El campo :attribute debe ser un arreglo.',

    'attributes' => [
        'email'            => 'correo electrónico',
        'password'         => 'contraseña',
        'firstName'        => 'nombre',
        'surName'          => 'apellido',
        'role'             => 'rol',
        'status'           => 'estado',
        'current_password' => 'contraseña actual',
        'new_password'     => 'nueva contraseña',
        'avatar'           => 'avatar',
    ],
];
