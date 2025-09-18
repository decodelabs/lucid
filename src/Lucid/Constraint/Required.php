<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint;

use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @template TValue
 * @implements Constraint<bool,TValue>
 */
class Required implements Constraint
{
    /**
     * @use ConstraintTrait<bool,TValue>
     */
    use ConstraintTrait;
    use NameTrait;

    public const int Weight = 1;

    protected function validateParameter(
        mixed $parameter
    ): mixed {
        return (bool)$parameter;
    }

    public function prepareValue(
        mixed $value
    ): mixed {
        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    public function validate(
        mixed $value
    ): Generator {
        if (
            $this->parameter &&
            $value === null
        ) {
            yield new Error(
                $this,
                $value,
                '%type% value is required'
            );
        }

        return true;
    }
}
