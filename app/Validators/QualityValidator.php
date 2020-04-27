<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class QualityValidator.
 *
 * @package namespace App\Validators;
 */
class QualityValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'value' => 'required',
            'pollutant_id' => 'required',
            'technical_value_id' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'value' => 'required',
            'pollutant_id' => 'required',
            'technical_value_id' => 'required',
        ],
    ];
}
