<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ResearchValuesValidator.
 *
 * @package namespace App\Validators;
 */
class ResearchValuesValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'employee_id' => 'required',
		'technical_value_id'	=>'required|unique',
	],
        ValidatorInterface::RULE_UPDATE => [
            'employee_id' => 'required',
            'technical_value_id'	=>'required|unique',
	],
    ];
}
