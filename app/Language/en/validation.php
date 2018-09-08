<?php

return [
	'required' => 'The :attribute field is required.',
	'min' => 'Value must be minimum :min characters.',
	'size' => [
		'numeric' => 'The field must be :size.',
		'string'  => 'The field must be :size characters.',
	],
	'between' => 'The :attribute value :input is not between :min - :max.',
	'custom' => [
		'sAdminDir' => [
			'regex' => 'Value must content this characters a-zA-Z0-9',
		],
		'sSuperAdministratorLogin' => [
			'regex' => 'Value must content this characters a-zA-Z0-9@._-',
		],
	],	
];