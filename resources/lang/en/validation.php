<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "The :attribute must be accepted.",
	"active_url"           => "The :attribute is not a valid URL.",
	"after"                => ":attribute debe ser una fecha posterior a :date.",
	"alpha"                => "The :attribute may only contain letters.",
	"alpha_dash"           => "The :attribute may only contain letters, numbers, and dashes.",
	"alpha_num"            => "The :attribute may only contain letters and numbers.",
	"array"                => "The :attribute must be an array.",
	"before"               => ":attribute debe ser una fecha anterior a :date.",
	"between"              => [
		"numeric" => "The :attribute must be between :min and :max.",
		"file"    => "The :attribute must be between :min and :max kilobytes.",
		"string"  => "The :attribute must be between :min and :max characters.",
		"array"   => "The :attribute must have between :min and :max items.",
	],
	"boolean"              => "The :attribute field must be true or false.",
	"confirmed"            => "The :attribute confirmation does not match.",
	"date"                 => ":attribute no es una fecha valida.",
	"date_format"          => ":attribute no concuerda con el formato :format.",
	"different"            => "The :attribute and :other must be different.",
	"digits"               => "The :attribute must be :digits digits.",
	"digits_between"       => "The :attribute must be between :min and :max digits.",
	"email"                => "The :attribute debe ser una dirección de email valida.",
	"filled"               => "The :attribute field is required.",
	"exists"               => "The selected :attribute is invalid.",
	"image"                => "The :attribute must be an image.",
	"in"                   => "The selected :attribute is invalid.",
	"integer"              => "The :attribute must be an integer.",
	"ip"                   => "The :attribute must be a valid IP address.",
	"max"                  => [
		"numeric" => "The :attribute may not be greater than :max.",
		"file"    => "The :attribute may not be greater than :max kilobytes.",
		"string"  => "The :attribute may not be greater than :max characters.",
		"array"   => "The :attribute may not have more than :max items.",
	],
	"mimes"                => "El :attribute debe ser de tipo: :values.",
	"min"                  => [
		"numeric" => "The :attribute must be at least :min.",
		"file"    => "The :attribute must be at least :min kilobytes.",
		"string"  => "The :attribute must be at least :min characters.",
		"array"   => "The :attribute must have at least :min items.",
	],
	"not_in"               => "The selected :attribute is invalid.",
	"numeric"              => "The :attribute must be a number.",
	"regex"                => "El :attribute no coincide con la expresión que debe ser.",
	"required"             => "El :attribute es requerido.",
	"required_if"          => "The :attribute field is required when :other is :value.",
	"required_with"        => "The :attribute field is required when :values is present.",
	"required_with_all"    => "The :attribute field is required when :values is present.",
	"required_without"     => "The :attribute field is required when :values is not present.",
	"required_without_all" => "The :attribute field is required when none of :values are present.",
	"same"                 => "The :attribute and :other must match.",
	"size"                 => [
		"numeric" => "The :attribute must be :size.",
		"file"    => "The :attribute must be :size kilobytes.",
		"string"  => "The :attribute must be :size characters.",
		"array"   => "The :attribute must contain :size items.",
	],
	"unique"               => "The :attribute has already been taken.",
	"url"                  => "The :attribute format is invalid.",
	"timezone"             => "The :attribute must be a valid zone.",
	"languaje_with_file_extension" => "El lenguaje no coincide con la extensión del código",
	"extension"=>"La extensión de :attribute no coincide con los archivos permitidos",
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
		'youtube'=>[
			'regex'=>'El link YouTube no coincide con youtube.',
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
		
    ],

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => [],

];
