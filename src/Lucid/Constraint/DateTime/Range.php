<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\DateTime;

use Carbon\Carbon;
use DateTimeInterface;
use DecodeLabs\Coercion;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use Stringable;

/**
 * @implements Constraint<array<DateTimeInterface|string|Stringable|int>, Carbon>
 */
class Range implements Constraint
{
    /**
     * @use ConstraintTrait<array<DateTimeInterface|string|Stringable|int>, Carbon>
     */
    use ConstraintTrait;

    public const int Weight = 20;

    public const array OutputTypes = [
        'DateTime', 'DateTimeInterface', 'Carbon\\Carbon'
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
