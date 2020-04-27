<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class PollutantValidator.
 *
 * @package namespace App\Validators;
 */
class PollutantValidator extends LaravelValidator
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
