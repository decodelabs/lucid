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
use DecodeLabs\Lucid\Error;
use Generator;
use Stringable;

/**
 * @implements Constraint<DateTimeInterface|string|Stringable|int|null, Carbon>
 */
class Min implements Constraint
{
    /**
     * @phpstan-use ConstraintTrait<DateTimeInterface|string|Stringable|int|null, Carbon>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'DateTime', 'DateTimeInterface', 'Carbon\\Carbon'
    ];

    protected ?Carbon $min = null;

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(mixed $param): static
    {
        /** @phpstan-ignore-next-line */
        $this->min = new Carbon($param);
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->min;
    }

    public function validate(mixed $value): Generator
    {
        if ($value === null) {
            return true;
        }

        if ($value->lessThan($this->min)) {
            yield new Error(
                $this,
                $value,
                '%type% value must be on or after %min%'
            );
        }

        return true;
    }

    public function constrain(mixed $value): mixed
    {
        if ($value->lessThan($this->min)) {
            $value = new Carbon('now');
        }

        return $value;
    }
}
