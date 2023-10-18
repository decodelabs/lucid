<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\Interval;

use Carbon\CarbonInterval;
use DateInterval;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use Stringable;

/**
 * @implements Constraint<array<DateInterval|string|Stringable|int>, CarbonInterval>
 */
class Range implements Constraint
{
    /**
     * @use ConstraintTrait<array<DateInterval|string|Stringable|int>, CarbonInterval>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'DateInterval', 'Carbon\\CarbonInterval'
    ];

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(mixed $param): static
    {
        $this->processor->test('min', $param[0] ?? 0);
        $this->processor->test('max', $param[1] ?? 0);
        return $this;
    }
}
