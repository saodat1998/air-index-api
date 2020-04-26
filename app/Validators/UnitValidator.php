<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class UnitValidator.
 *
 * @package namespace App\Validators;
 */
class UnitValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'required|min:2'	=>'	name=>required|min:2',
	],
        ValidatorInterface::RULE_UPDATE => [
		'required|min:2'	=>'	name=>required|min:2',
	],
    ];
}
