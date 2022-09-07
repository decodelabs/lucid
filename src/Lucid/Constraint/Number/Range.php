<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\Number;

use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;

/**
 * @implements Constraint<array<int|float>, int|float>
 */
class Range implements Constraint
{
    /**
     * @phpstan-use ConstraintTrait<array<int|float>, int|float>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'int', 'float', 'number'
    ];

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(mixed $param): static
    {
        $this->processor->test('min', $param[0] ?? 0);
        $this->processor->test('max', $param[1] ?? \PHP_INT_MAX);
        return $this;
    }
}
