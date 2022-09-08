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
use DecodeLabs\Lucid\Validate\Error;
use Generator;
use Stringable;

/**
 * @implements Constraint<DateInterval|string|Stringable|int, CarbonInterval>
 */
class Max implements Constraint
{
    /**
     * @phpstan-use ConstraintTrait<DateInterval|string|Stringable|int, CarbonInterval>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'DateInterval', 'Carbon\\CarbonInterval'
    ];

    protected ?CarbonInterval $max = null;

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
                '%type% value must not be greater than %max%'
            );
        }

        return true;
    }
}
