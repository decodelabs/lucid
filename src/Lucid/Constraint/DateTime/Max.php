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
use DecodeLabs\Lucid\Validate\Error;
use Generator;
use Stringable;

/**
 * @implements Constraint<DateTimeInterface|string|Stringable|int, Carbon>
 */
class Max implements Constraint
{
    /**
     * @use ConstraintTrait<DateTimeInterface|string|Stringable|int, Carbon>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'DateTime', 'DateTimeInterface', 'Carbon\\Carbon'
    ];

    protected ?Carbon $max = null;

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(mixed $param): static
    {
        $this->max = $this->processor->coerce($param);
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->max;
    }

    public function validate(mixed $value): Generator
    {
        if ($value === null) {
            return true;
        }

        if ($value->greaterThan($this->max)) {
            yield new Error(
                $this,
                $value,
                '%type% value must be on or before %max%'
            );
        }

        return true;
    }
}
