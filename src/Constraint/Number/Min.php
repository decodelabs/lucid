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
 * @implements Constraint<float, int|float>
 */
class Min implements Constraint
{
    /**
     * @use ConstraintTrait<float, int|float>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'int', 'float', 'number'
    ];

    protected ?float $min = null;

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(
        mixed $param
    ): static {
        $this->min = (float)$param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->min;
    }

    public function validate(
        mixed $value
    ): Generator {
        if ($value < $this->min) {
            yield new Error(
                $this,
                $value,
                '%type% value must be at least %min%'
            );
        }

        return true;
    }
}
