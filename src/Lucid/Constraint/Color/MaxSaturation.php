<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\Color;

use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use DecodeLabs\Spectrum\Color;
use Generator;

/**
 * @implements Constraint<float, Color>
 */
class MaxSaturation implements Constraint
{
    /**
     * @use ConstraintTrait<float, Color>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'Spectrum:Color'
    ];

    protected ?float $max = null;

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(mixed $param): static
    {
        $this->max = (float)$param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->max;
    }

    public function validate(mixed $value): Generator
    {
        if ($value === null) {
            return false;
        }

        if ($value->getHslSaturation() > $this->max) {
            yield new Error(
                $this,
                $value,
                '%type% value must not have saturation greater than %maxSaturation%'
            );
        }

        return true;
    }
}
