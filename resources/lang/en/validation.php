<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| El following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "El :attribute debe ser aceptado.",
	"active_url"           => "El :attribute no es una URL válida.",
	"after"                => "La fecha debe ser una fecha posterior a :date.",
	"alpha"                => "El :attribute puede solo contener letters.",
	"alpha_dash"           => "El :attribute puede contener letters, numbers, and dashes.",
	"alpha_num"            => "El :attribute puede contener letters and numbers.",
	"array"                => "El :attribute debe ser an array.",
	"before"               => ":attribute debe ser una fecha anterior a :date.",
	"between"              => [
		"numeric" => "El :attribute debe ser entre :min y :max.",
		"file"    => "El :attribute debe ser entre :min y :max kilobytes.",
		"string"  => "El :attribute debe ser entre :min y :max caracteres.",
		"array"   => "El :attribute debe ser entre :min y :max elementos.",
	],
	"boolean"              => "El :attribute  debe ser true or false.",
	"confirmed"            => "El :attribute confirmación no coincide.",
	"date"                 => "Fecha no es una fecha válida.",
	"date_format"          => ":attribute no concuerda con el formato :format.",
	"different"            => "El :attribute y :other debe ser diferente.",
	"digits"               => "El :attribute debe ser :digits dígitos.",
	"digits_between"       => "El :attribute debe ser between :min and :max digits.",
	"email"                => ":attribute debe ser una dirección de email valida.",
	"filled"               => "El :attribute campo es requerido.",
	"exists"               => "La selección :attribute es inválida.",
	"image"                => ":attribute debe ser una imagen.",
	"in"                   => "La selección :attribute es inválida.",
	"integer"              => "El :attribute debe ser un entero.",
	"ip"                   => "El :attribute debe ser una dirección válida de IP.",
	"max"                  => [
		"numeric" => "El :attribute no debe ser más grande que :max.",
		"file"    => "El :attribute no debe ser más grande que :max kilobytes.",
		"string"  => "El :attribute no debe ser más grande que :max caracateres.",
		"array"   => "El :attribute no debe contener más de :max elementos.",
	],
	"mimes"                => "El :attribute debe ser de tipo: :values.",
	"min"                  => [
		"numeric" => "El :attribute debe al menos :min.",
		"file"    => "El :attribute debe al menos :min kilobytes.",
		"string"  => "El :attribute debe al menos :min caracteres.",
		"array"   => "El :attribute debe tener al menos :min elementos.",
	],
	"not_in"               => "El :attribute seleccionado es inválido.",
	"numeric"              => "El :attribute debe ser un número.",
	"regex"                => "El :attribute no coincide con la expresión que debe ser.",
	"required"             => "El :attribute es requerido.",
	"required_if"          => "El :attribute field is required when :other is :value.",
	"required_with"        => "El :attribute field is required when :values is present.",
	"required_with_all"    => "El :attribute field is required when :values is present.",
	"required_without"     => "El :attribute field is required when :values no es present.",
	"required_without_all" => "El :attribute field is required when none of :values are present.",
	"same"                 => "El :attribute y :other deben ser iguales.",
	"size"                 => [
		"numeric" => "El :attribute debe ser :size.",
		"file"    => "El :attribute debe ser :size kilobytes.",
		"string"  => "El :attribute debe ser :size characters.",
		"array"   => "El :attribute must contain :size items.",
	],
	"unique"               => ":attribute ya ha sido registrado en sistema",
	"url"                  => "El formato de :attribute es inválido.",
	"timezone"             => "El :attribute debe ser a valid zone.",
	"languaje_with_file_extension" => "El lenguaje no coincide con la extensión del código",
	"extension"=>"La extensión del archivo no coincide con los archivos permitidos",
    "oneword"     => ":attribute no debe contener espacios en blanco o caracteres especiales.",
	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name' => 'custom-message',
		],
        'institucion' => [
            'required' => 'El campo Institución es requerido',
        ],
        'title' => [
            'required' => 'El campo Título es requerido',
        ],
        'descripcion' => [
            'required' => 'El campo Descripción es requerido',
        ],
        'limitMemory' => [
            'required' => 'El campo Límite de memoria es requerido',
            'numeric' => 'El Límite de memoria debe ser un número',
        ],
        'limitTime' => [
            'required' => 'El campo Límite de tiempo es requerido',
            'numeric' => 'El Límite de tiempo debe ser un número',
        ],
        'ejemploen'=>[
            'required'=> 'El campo Ejemplo de entrada es requerido',
        ],
        'ejemplosa'=>[
            'required'=> 'El campo Ejemplo de salida es requerido',
        ],
        'tags'=> [
            'required'=> 'El campo Tags es requerido',
        ],
        'inputs'=> [
            'required'=> 'El campo Entrada es requerido',
        ],
        'outputs'=> [
            'required'=> 'El campo Salida es requerido',
        ],
        'youtube' => [
            'url'=>'El campo Youtube no coincide con el formato de un link de youtube',
            'regex'=>'El campo Youtube no coincide con el formato de un link de youtube',
		],
        'github' => [
            'url'=>'El campo Github no coincide con el formato de un link de un repositorio',
            'regex'=>'El campo Github no coincide con el formato de un link de un repositorio',
		],
		'optionsLanguages'=>[
			'required' => 'El lenguaje es requerido.',

		],
		'explanation' => [
			'required'=>'La explicación es requerida.',

		],
		'fileCode'=>[
			'required'=>'El código fuente es requerido.',
			'extension'=>'La extensión del código fuente no corresponde con el lenguaje .',
		],
		'repositorio'=>[
			'regex'=>'El link Repositorio no coincideo con un repositorio.',
		],
		'audioFile'=>[
			'extension'=>'La extensión del audio no corresponde a .mp3 .',
		],
        'facebook' => [
            'url'=>'El campo Facebook no coincide con el formato de una página de Facebook',
            'regex'=>'El campo Facebook no coincide con el formato de una página de Facebook',
        ],
        'twitter' => [
            'url'=>'El campo Twitter no coincide con el formato de una página de Twitter',
            'regex'=>'El campo Twitter no coincide con el formato de una página de Twitter',
        ],
        'addressWeb' => [
            'url'=>'El campo Url no coincide con el formato de una Url',
            'regex'=>'El campo Url no coincide con el formato de una Url',
            'required' => 'El campo Url es requerido',
        ],
        'name' => [
            'required' => 'El campo Nombre es requerido',
        ],
		'termAndConditions' => [
            'required' => 'Debes aceptar términos y condiciones para poder registrarte',
        ],
		
    ],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| El following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
