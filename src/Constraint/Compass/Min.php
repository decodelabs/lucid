<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\Compass;

use Brick\Math\BigInteger;
use DecodeLabs\Compass\Ip;
use DecodeLabs\Compass\Range;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @implements Constraint<Ip|string|int|BigInteger, Ip|Range>
 */
class Min implements Constraint
{
    /**
     * @use ConstraintTrait<Ip|string|int|BigInteger, Ip|Range>
     */
    use ConstraintTrait;

    protected const OutputTypes = [
        'Compass:Ip', 'Compass:Range'
    ];

    protected ?Ip $min = null;

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(
        mixed $param
    ): static {
        $this->min = Ip::parse($param);
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->min;
    }

    public function validate(
        mixed $value
    ): Generator {
        if (
            $value === null ||
            $this->min === null
        ) {
            return false;
        }

        $value = $value instanceof Range ?
            $value->getFirstIp() :
            $value;

        if ($value->isLessThan($this->min)) {
            yield new Error(
                $this,
                $value,
                '%type% value must not be lower than %min%'
            );
        }

        return true;
    }
}
