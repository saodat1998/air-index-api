<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class EmployeeValidator.
 *
 * @package namespace App\Validators;
 */
class EmployeeValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'department_id'	=> 'required',
	],
        ValidatorInterface::RULE_UPDATE => [
            'department_id'	=> 'required',
	],
    ];
}
