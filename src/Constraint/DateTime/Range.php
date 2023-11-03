<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\DateTime;

use Carbon\Carbon;
use DateTimeInterface;
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

    public const OUTPUT_TYPES = [
        'DateTime', 'DateTimeInterface', 'Carbon\\Carbon'
    ];

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(
        mixed $param
    ): static {
        $this->processor->test('min', $param[0] ?? 'now');
        $this->processor->test('max', $param[1] ?? 'now');
        return $this;
    }
}
