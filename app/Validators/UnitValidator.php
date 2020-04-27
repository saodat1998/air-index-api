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
		'name' => 'required|min:2',
	],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|min:2',
	],
    ];
}
