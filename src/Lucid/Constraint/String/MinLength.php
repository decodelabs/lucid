<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\String;

use DecodeLabs\Coercion;
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @implements Constraint<int,string>
 */
class MinLength implements Constraint
{
    /**
     * @use ConstraintTrait<int,string>
     */
    use ConstraintTrait;

    public const int Weight = 20;

    public const array OutputTypes = [
        'string', 'string:'
    ];

    protected function validateParameter(
        mixed $parameter
    ): mixed {
        $parameter = Coercion::asInt($parameter);

        if ($parameter <= 0) {
            throw Exceptional::InvalidArgument(
                message: 'Max length must be greater than 0'
            );
        }

        return (int)$parameter;
    }

    public function validate(
        mixed $value
    ): Generator {
        $length = mb_strlen((string)$value);

        if (
            $this->parameter > 0 &&
            $length < $this->parameter
        ) {
            yield new Error(
                $this,
                $value,
                '%type% value must contain at least %minLength% characters'
            );
        }

        return true;
    }
}
