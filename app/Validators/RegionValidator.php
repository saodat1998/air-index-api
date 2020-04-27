<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class RegionValidator.
 *
 * @package namespace App\Validators;
 */
class RegionValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
		'name'	=>'	required=>name',
	],
        ValidatorInterface::RULE_UPDATE => [
		'name'	=>'	required=>name',
	],
    ];
}
