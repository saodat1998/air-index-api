<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class DateValidator.
 *
 * @package namespace App\Validators;
 */
class DateValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'date' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'date' => 'required'
        ],
    ];
}
