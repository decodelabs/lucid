<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\String;

use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;

/**
 * @implements Constraint<bool, string>
 */
class Trim implements Constraint
{
    /**
     * @use ConstraintTrait<bool, string>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'string', 'string:'
    ];

    protected bool $trim = true;

    public function getWeight(): int
    {
        return 5;
    }

    public function setParameter(mixed $param): static
    {
        $this->trim = $param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->trim;
    }

    public function alterValue(mixed $value): mixed
    {
        if ($this->trim) {
            $value = trim((string)$value);

            if ($value === '') {
                $value = null;
            }
        }

        return $value;
    }
}
