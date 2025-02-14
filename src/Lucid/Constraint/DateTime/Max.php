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
 * @implements Constraint<DateTimeInterface|string|Stringable|int,Carbon>
 */
class Max implements Constraint
{
    /**
     * @use ConstraintTrait<DateTimeInterface|string|Stringable|int,Carbon>
     */
    use ConstraintTrait;

    public const int Weight = 20;

    public const array OutputTypes = [
        'DateTime', 'DateTimeInterface', 'Carbon\\Carbon'
    ];

    protected function validateParameter(
        mixed $value
    ): mixed {
        return $this->processor->coerce($value);
    }

    public function validate(
        mixed $value
    ): Generator {
        if ($value === null) {
            return true;
        }

        // @phpstan-ignore-next-line
        if ($value->greaterThan($this->parameter)) {
            yield new Error(
                $this,
                $value,
                '%type% value must be on or before %max%'
            );
        }

        return true;
    }
}
