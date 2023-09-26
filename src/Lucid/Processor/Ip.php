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
        if (!class_exists(IpAddress::class)) {
            throw Exceptional::ComponentUnavailable(
                'IP validation requires decodelabs-compass package'
            );
        }

        if ($value === null) {
            return null;
        }

        if (
            is_int($value) ||
            $value instanceof BigInteger ||
            is_string($value) ||
            $value instanceof IpAddress
        ) {
            return IpAddress::parse($value);
        }

        throw Exceptional::UnexpectedValue(
            'Could not coerce value to Compass IP',
            null,
            $value
        );
    }
}
