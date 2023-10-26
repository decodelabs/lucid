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

    public function getOutputTypes(): array
    {
        return ['Compass:Ip', 'DecodeLabs\\Compass\\Ip'];
    }

    /**
     * Convert prepared value to string or null
     */
    public function coerce(mixed $value): ?IpAddress
    {
        // unhappy path: if (something wrong) terminate;
        if (!class_exists(IpAddress::class)) {
            throw Exceptional::ComponentUnavailable(
                'IP validation requires decodelabs/compass package'
            );
        }

        // unhappy path: if (something wrong) terminate;
        if ($value === null) {
            return null;
        }

        // unhappy path: if (something wrong) terminate;
        if (
            ! is_int($value) &&
            ! $value instanceof BigInteger &&
            ! is_string($value) &&
            ! $value instanceof IpAddress
        ) {
            throw Exceptional::UnexpectedValue(
                'Could not coerce value to Compass IP',
                null,
                $value
            );
        }

        // unhappy path 🍏
        return IpAddress::parse($value);
    }
}
