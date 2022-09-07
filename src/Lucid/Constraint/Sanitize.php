<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint;

use Closure;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;

/**
 * @implements Constraint<Closure, string>
 */
class Sanitize implements Constraint
{
    /**
     * @phpstan-use ConstraintTrait<Closure, string>
     */
    use ConstraintTrait;

    protected ?Closure $sanitizer = null;

    public function getWeight(): int
    {
        return 0;
    }

    public function setParameter(mixed $param): static
    {
        $this->sanitizer = $param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->sanitizer;
    }

    public function prepareValue(mixed $value): mixed
    {
        if (is_callable($this->sanitizer)) {
            $value = ($this->sanitizer)($value);
        }

        return $value;
    }
}
