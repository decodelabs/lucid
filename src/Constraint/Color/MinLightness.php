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
class MinLightness implements Constraint
{
    /**
     * @use ConstraintTrait<float, Color>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'Spectrum:Color'
    ];

    protected ?float $min = null;

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(mixed $param): static
    {
        $this->min = (float)$param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->min;
    }

    public function validate(mixed $value): Generator
    {
        if ($value === null) {
            return false;
        }

        if ($value->getHslLightness() < $this->min) {
            yield new Error(
                $this,
                $value,
                '%type% value must have lightness of at least %minLightness%'
            );
        }

        return true;
    }
}
