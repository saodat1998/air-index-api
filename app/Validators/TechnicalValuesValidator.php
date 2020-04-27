<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class TechnicalValuesValidator.
 *
 * @package namespace App\Validators;
 */
class TechnicalValuesValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'aqi_category_id'=>'required',
        'employee_id'	=> 'required',
	],
        ValidatorInterface::RULE_UPDATE => [
		'aqi_category_id' =>'required',
		'employee_id'	=>'required',
	],
    ];
}
