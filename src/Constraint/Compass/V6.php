<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\Compass;

use DecodeLabs\Compass\Ip;
use DecodeLabs\Compass\Range;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @implements Constraint<bool, Ip|Range>
 */
class V6 implements Constraint
{
    /**
     * @use ConstraintTrait<bool, Ip|Range>
     */
    use ConstraintTrait;

    protected const OutputTypes = [
        'Compass:Ip', 'Compass:Range'
    ];

    protected bool $v6 = true;

    public function getWeight(): int
    {
        return 1;
    }

    public function setParameter(
        mixed $param
    ): static {
        $this->v6 = $param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->v6;
    }

    public function validate(
        mixed $value
    ): Generator {
        if ($value === null) {
            return false;
        }

        if ($this->v6 !== $value->isV6()) {
            yield new Error(
                $this,
                $value,
                '%type% must ' . (!$this->v6 ? 'not ' : '') . ' be IPv6'
            );
        }

        return true;
    }
}
