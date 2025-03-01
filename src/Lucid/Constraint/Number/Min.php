<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\Number;

use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @implements Constraint<float,int|float>
 */
class Min implements Constraint
{
    /**
     * @use ConstraintTrait<float,int|float>
     */
    use ConstraintTrait;

    public const int Weight = 20;

    public const array OutputTypes = [
        'int', 'float', 'number'
    ];

    protected function validateParameter(
        mixed $parameter
    ): mixed {
        return $this->processor->coerce($parameter);
    }

    public function validate(
        mixed $value
    ): Generator {
        if ($value < $this->parameter) {
            yield new Error(
                $this,
                $value,
                '%type% value must be at least %min%'
            );
        }

        return true;
    }
}
