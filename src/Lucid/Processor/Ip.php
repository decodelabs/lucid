<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use Brick\Math\BigInteger;
use DecodeLabs\Compass\Ip as IpAddress;
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProcessorTrait;

/**
 * @implements Processor<IpAddress>
 */
class Ip implements Processor
{
    /**
     * @use ProcessorTrait<IpAddress>
     */
    use ProcessorTrait;

    public const array OutputTypes = ['Compass:Ip', Ip::class];

    /**
     * Convert prepared value to string or null
     */
    public function coerce(
        mixed $value
    ): ?IpAddress {
        if (!class_exists(IpAddress::class)) {
            throw Exceptional::ComponentUnavailable(
                message: 'IP validation requires decodelabs/compass package'
            );
        }

        if ($value === null) {
            return null;
        }

        if (
            !is_int($value) &&
            !$value instanceof BigInteger &&
            !is_string($value) &&
            !$value instanceof IpAddress
        ) {
            throw Exceptional::UnexpectedValue(
                message: 'Could not coerce value to Compass IP',
                data: $value
            );
        }

        return IpAddress::parse($value);
    }
}
