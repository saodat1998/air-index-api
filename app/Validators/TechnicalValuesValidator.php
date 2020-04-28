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
		'date'=>'required',
		'region_id'=>'required',
        'qualities'	=> 'required',
	],
        ValidatorInterface::RULE_UPDATE => [
		'date' =>'required',
		'region_id' =>'required',
		'qualities'	=>'required',
	],
    ];
}
