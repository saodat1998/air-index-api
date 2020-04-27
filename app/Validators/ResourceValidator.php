<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class ResourceValidator.
 *
 * @package namespace App\Validators;
 */
class ResourceValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'name' => 'required',
	],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required',
	],
    ];
}
