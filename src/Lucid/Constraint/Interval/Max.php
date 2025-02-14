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
 * @implements Constraint<DateInterval|string|Stringable|int,CarbonInterval>
 */
class Max implements Constraint
{
    /**
     * @use ConstraintTrait<DateInterval|string|Stringable|int,CarbonInterval>
     */
    use ConstraintTrait;

    public const int Weight = 20;

    public const array OutputTypes = [
        'DateInterval', 'Carbon\\CarbonInterval'
    ];

    protected function validateParameter(
        mixed $parameter
    ): mixed {
        return $this->processor->coerce($parameter);
    }

    public function validate(
        mixed $value
    ): Generator {
        if ($value === null) {
            return true;
        }

        if ($value->greaterThan($this->parameter)) {
            yield new Error(
                $this,
                $value,
                '%type% value must not be greater than %max%'
            );
        }

        return true;
    }
}
