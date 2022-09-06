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
        array|Closure|null $setup = null
    ): mixed {
        return $this->sanitize()->as($type, $setup);
    }

    public function forceAs(
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return $this->sanitize()->forceAs($type, $setup);
    }

    public function sanitize(): Sanitizer
    {
        return new Sanitizer($this->getValue());
    }

    /**
     * @phpstan-return TValue
     */
    abstract protected function getValue(): mixed;
}
