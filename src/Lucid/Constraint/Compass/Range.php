<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\Compass;

use Brick\Math\BigInteger;
use DecodeLabs\Compass\Ip;
use DecodeLabs\Compass\Range as IpRange;
use DecodeLabs\Compass\Scope as IpScope;
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @implements Constraint<Ip|IpScope|string|int|BigInteger,Ip|IpRange>
 */
class Range implements Constraint
{
    /**
     * @use ConstraintTrait<Ip|IpScope|string|int|BigInteger,Ip|IpRange>
     */
    use ConstraintTrait;

    public const int Weight = 20;

    public const array OutputTypes = [
        'Compass:Ip', 'Compass:Range'
    ];

    protected function validateParameter(
        mixed $parameter
    ): mixed {
        if(
            !$parameter instanceof IpRange &&
            !$parameter instanceof IpScope &&
            !is_string($parameter) &&
            !is_int($parameter) &&
            !$parameter instanceof BigInteger
        ) {
            throw Exceptional::InvalidArgument(
                message: 'Invalid range parameter'
            );
        }

        return IpRange::parse($parameter);
    }

    public function validate(
        mixed $value
    ): Generator {
        if ($value === null) {
            return false;
        }

        // @phpstan-ignore-next-line
        if (!$this->parameter->contains($value)) {
            yield new Error(
                $this,
                $value,
                '%type% value must be within range %range%'
            );
        }

        return true;
    }
}
