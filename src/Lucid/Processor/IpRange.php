<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use Brick\Math\BigInteger;
use DecodeLabs\Compass\Ip as IpAddress;
use DecodeLabs\Compass\Range;
use DecodeLabs\Compass\Scope;
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProcessorTrait;

/**
 * @implements Processor<Range>
 */
class IpRange implements Processor
{
    /**
     * @use ProcessorTrait<Range>
     */
    use ProcessorTrait;

    public const array OutputTypes = ['Compass:Range', Range::class];

    /**
     * Convert prepared value to string or null
     */
    public function coerce(
        mixed $value
    ): ?Range {
        if (!class_exists(IpAddress::class)) {
            throw Exceptional::ComponentUnavailable(
                message: 'IP validation requires decodelabs-compass package'
            );
        }

        if ($value === null) {
            return null;
        }

        if (
            is_int($value) ||
            $value instanceof BigInteger ||
            is_string($value) ||
            $value instanceof IpAddress ||
            $value instanceof Scope
        ) {
            return Range::parse($value);
        }

        throw Exceptional::UnexpectedValue(
            message: 'Could not coerce value to Compass IP range',
            data: $value
        );
    }
}
