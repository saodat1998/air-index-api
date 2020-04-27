<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class DepartmentValidator.
 *
 * @package namespace App\Validators;
 */
class DepartmentValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'name' => 'required|min:2',
	],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|min:2',
	],
    ];
}
