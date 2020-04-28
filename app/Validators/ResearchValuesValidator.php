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
            //'technical_value_id' => 'required',
            'value' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
           //'technical_value_id' =>'required',
            'value' => 'required',
        ],
    ];
}
