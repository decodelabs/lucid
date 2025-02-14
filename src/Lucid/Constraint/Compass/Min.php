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
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @implements Constraint<Ip|string|int|BigInteger,Ip|IpRange>
 */
class Min implements Constraint
{
    /**
     * @use ConstraintTrait<Ip|string|int|BigInteger,Ip|IpRange>
     */
    use ConstraintTrait;

    public const int Weight = 20;

    public const array OutputTypes = [
        'Compass:Ip', 'Compass:Range'
    ];

    protected function validateParameter(
        mixed $parameter
    ): mixed {
        if($parameter instanceof IpRange) {
            $parameter = $parameter->firstIp;
        }

        if(
            !$parameter instanceof Ip &&
            !is_string($parameter) &&
            !is_int($parameter) &&
            !$parameter instanceof BigInteger
        ) {
            throw Exceptional::InvalidArgument(
                message: 'Invalid range parameter'
            );
        }

        return Ip::parse($parameter);
    }

    public function validate(
        mixed $value
    ): Generator {
        if ($value === null) {
            return false;
        }

        $value = $value instanceof IpRange ?
            $value->firstIp :
            $value;

        if ($value->isLessThan($this->parameter)) {
            yield new Error(
                $this,
                $value,
                '%type% value must not be lower than %min%'
            );
        }

        return true;
    }
}
