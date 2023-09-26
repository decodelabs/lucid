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
 * @implements Constraint<bool, TValue>
 */
class Required implements Constraint
{
    /**
     * @use ConstraintTrait<bool, TValue>
     */
    use ConstraintTrait;

    protected bool $required = true;

    public function getWeight(): int
    {
        return 1;
    }

    public function setParameter(mixed $param): static
    {
        $this->required = $param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->required;
    }

    public function prepareValue(mixed $value): mixed
    {
        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    public function validate(mixed $value): Generator
    {
        if (
            $this->required &&
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
