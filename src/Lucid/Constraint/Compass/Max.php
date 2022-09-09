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
class Max implements Constraint
{
    /**
     * @phpstan-use ConstraintTrait<Ip|string|int|BigInteger, Ip|Range>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'Compass:Ip', 'Compass:Range'
    ];

    protected ?Ip $max = null;

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(mixed $param): static
    {
        $this->max = Ip::parse($param);
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->max;
    }

    public function validate(mixed $value): Generator
    {
        if (
            $value === null ||
            $this->max === null
        ) {
            return false;
        }

        $value = $value instanceof Range ?
            $value->getLastIp() :
            $value;

        if ($value->isGreaterThan($this->max)) {
            yield new Error(
                $this,
                $value,
                '%type% value must not be higher than %max%'
            );
        }

        return true;
    }
}
