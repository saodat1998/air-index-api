<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class StatisticValuesValidator.
 *
 * @package namespace App\Validators;
 */
class StatisticValuesValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'employee_id' => 'required',
		'research_value_id'	=> 'required|unique',
	],
        ValidatorInterface::RULE_UPDATE => [
		'employee_id' => 'required',
		'research_value_id' => 'required|unique',
	],
    ];
}
