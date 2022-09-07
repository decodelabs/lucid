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
 * @implements Constraint<TValue, TValue>
 */
class DefaultValue implements Constraint
{
    /**
     * @phpstan-use ConstraintTrait<TValue, TValue>
     */
    use ConstraintTrait;

    protected mixed $default = null;

    public function getWeight(): int
    {
        return 0;
    }

    public function setParameter(mixed $param): static
    {
        $this->default = $param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->default;
    }

    public function prepareValue(mixed $value): mixed
    {
        if ($value === '') {
            $value = null;
        }

        if ($value === null) {
            $value = $this->default;
        }

        return $value;
    }
}
