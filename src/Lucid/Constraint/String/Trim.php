<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\String;

use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;

/**
 * @implements Constraint<bool,string>
 */
class Trim implements Constraint
{
    /**
     * @use ConstraintTrait<bool,string>
     */
    use ConstraintTrait;

    public const int Weight = 20;

    public const array OutputTypes = [
        'string', 'string:'
    ];

    protected function validateParameter(
        mixed $parameter
    ): mixed {
        return (bool)$parameter;
    }

    public function alterValue(
        mixed $value
    ): mixed {
        if ($this->parameter) {
            $value = trim((string)$value);

            if ($value === '') {
                $value = null;
            }
        }

        return $value;
    }
}
