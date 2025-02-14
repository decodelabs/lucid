<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use Carbon\CarbonInterval;
use DateInterval;
use DateMalformedStringException;
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProcessorTrait;
use Stringable;

/**
 * @implements Processor<CarbonInterval>
 */
class Interval implements Processor
{
    /**
     * @use ProcessorTrait<CarbonInterval>
     */
    use ProcessorTrait;

    public const array OutputTypes = [
        DateInterval::class,
        CarbonInterval::class
    ];

    /**
     * Convert prepared value to DateTime or null
     */
    public function coerce(
        mixed $value
    ): ?CarbonInterval {
        if ($value === null) {
            return null;
        }

        if (
            is_string($value) ||
            $value instanceof Stringable
        ) {
            try {
                // Written text
                return CarbonInterval::createFromDateString((string)$value);
            } catch(DateMalformedStringException $e) {
                // ISO format
                return new CarbonInterval((string)$value);
            }
        }

        // Seconds
        if (is_int($value)) {
            return CarbonInterval::seconds($value)->cascade();
        }

        // Instance
        if ($value instanceof DateInterval) {
            return CarbonInterval::instance($value);
        }

        throw Exceptional::UnexpectedValue(
            message: 'Unable to coerce value to DateTime'
        );
    }
}
