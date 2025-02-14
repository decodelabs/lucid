<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint;

use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;

/**
 * @template TValue
 * @implements Constraint<TValue,TValue>
 */
class DefaultValue implements Constraint
{
    /**
     * @use ConstraintTrait<TValue,TValue>
     */
    use ConstraintTrait;

    public const int Weight = 0;

    public function prepareValue(
        mixed $value
    ): mixed {
        if ($value === '') {
            $value = null;
        }

        if ($value === null) {
            $value = $this->parameter;
        }

        return $value;
    }
}
