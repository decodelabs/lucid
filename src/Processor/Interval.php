<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use Carbon\CarbonInterval;
use DateInterval;
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

    public function getOutputTypes(): array
    {
        return ['DateInterval', 'Carbon\\CarbonInterval'];
    }

    /**
     * Convert prepared value to DateTime or null
     */
    public function coerce(mixed $value): ?CarbonInterval
    {
        if ($value === null) {
            return null;
        }

        if (
            is_string($value) ||
            $value instanceof Stringable
        ) {
            // Written text
            /** @var CarbonInterval|false $interval */
            $interval = CarbonInterval::createFromDateString((string)$value);

            if ($interval !== false) {
                return $interval;
            }

            // ISO format
            return new CarbonInterval((string)$value);
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
            'Unable to coerce value to DateTime'
        );
    }
}
