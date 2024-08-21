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
class Min implements Constraint
{
    /**
     * @use ConstraintTrait<DateInterval|string|Stringable|int, CarbonInterval>
     */
    use ConstraintTrait;

    protected const OutputTypes = [
        'DateInterval', 'Carbon\\CarbonInterval'
    ];

    protected ?CarbonInterval $min = null;

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(
        mixed $param
    ): static {
        $this->min = $this->processor->coerce($param);
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->min;
    }

    public function validate(
        mixed $value
    ): Generator {
        if ($value === null) {
            return true;
        }

        if ($value->lessThan($this->min)) {
            yield new Error(
                $this,
                $value,
                '%type% value must not be less than %min%'
            );
        }

        return true;
    }
}
