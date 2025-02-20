<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\Number;

use DecodeLabs\Coercion;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;

/**
 * @implements Constraint<array<int|float>,int|float>
 */
class Range implements Constraint
{
    /**
     * @use ConstraintTrait<array<int|float>,int|float>
     */
    use ConstraintTrait;

    public const int Weight = 20;

    public const array OutputTypes = [
        'int', 'float', 'number'
    ];

    protected function validateParameter(
        mixed $param
    ): mixed {
        $param = Coercion::asArray($param);
        $this->processor->test('min', $param[0] ?? 0);
        $this->processor->test('max', $param[1] ?? \PHP_INT_MAX);
        return $param;
    }
}
