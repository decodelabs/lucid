<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use Carbon\Carbon;
use DateTime;
use DateTimeInterface;
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProcessorTrait;
use Stringable;

/**
 * @implements Processor<DateTime>
 */
class Date implements Processor
{
    /**
     * @use ProcessorTrait<DateTime>
     */
    use ProcessorTrait;

    public const array OutputTypes = [
        DateTime::class,
        DateTimeInterface::class,
        Carbon::class
    ];

    /**
     * Convert prepared value to DateTime or null
     */
    public function coerce(
        mixed $value
    ): ?Carbon {
        if ($value === null) {
            return null;
        }

        if (
            is_string($value) ||
            $value instanceof Stringable ||
            is_int($value) ||
            $value instanceof DateTimeInterface
        ) {
            /** @phpstan-ignore-next-line */
            return new Carbon($value);
        }

        throw Exceptional::UnexpectedValue(
            message: 'Unable to coerce value to DateTime'
        );
    }
}
