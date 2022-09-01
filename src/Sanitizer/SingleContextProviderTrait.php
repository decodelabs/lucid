<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Sanitizer;

use Closure;
use DecodeLabs\Lucid\Sanitizer;

/**
 * @template TValue
 */
trait SingleContextProviderTrait
{
    public function as(
        string $type,
        ?Closure $setup = null
    ): mixed {
        return $this->sanitize()->as($type, $setup);
    }

    public function forceAs(
        string $type,
        ?Closure $setup = null
    ): mixed {
        return $this->sanitize()->forceAs($type, $setup);
    }

    public function sanitize(bool $required = true): Sanitizer
    {
        return new Sanitizer($this->getValue(), $required);
    }

    /**
     * @phpstan-return TValue
     */
    abstract protected function getValue(): mixed;
}
