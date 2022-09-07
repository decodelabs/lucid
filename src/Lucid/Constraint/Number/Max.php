<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\Number;

use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Error;
use Generator;

/**
 * @implements Constraint<float, int|float>
 */
class Max implements Constraint
{
    /**
     * @phpstan-use ConstraintTrait<float, int|float>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'int', 'float', 'number'
    ];

    protected ?float $max = null;

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(mixed $param): static
    {
        $this->max = (float)$param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->max;
    }

    public function validate(mixed $value): Generator
    {
        if ($value > $this->max) {
            yield new Error(
                $this,
                $value,
                '%type% value must not be greater than %max%'
            );
        }

        return true;
    }

    public function constrain(mixed $value): mixed
    {
        if (
            $this->max !== null &&
            $value > $this->max
        ) {
            $value = $this->max;
        }

        return $value;
    }
}
