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
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @implements Constraint<Ip|IpScope|string|int|BigInteger, Ip|IpRange>
 */
class Range implements Constraint
{
    /**
     * @use ConstraintTrait<Ip|IpScope|string|int|BigInteger, Ip|IpRange>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'Compass:Ip', 'Compass:Range'
    ];

    protected ?IpRange $range = null;

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(mixed $param): static
    {
        $this->range = IpRange::parse($param);
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->range;
    }

    public function validate(mixed $value): Generator
    {
        if (
            $value === null ||
            $this->range === null
        ) {
            return false;
        }

        if (!$this->range->contains($value)) {
            yield new Error(
                $this,
                $value,
                '%type% value must be within range %range%'
            );
        }

        return true;
    }
}
