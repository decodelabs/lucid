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
trait MultiContextProviderTrait
{
    public function getAs(
        string $key,
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return $this->sanitize($key)->as($type, $setup);
    }

    public function forceAs(
        string $key,
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return $this->sanitize($key)->forceAs($type, $setup);
    }

    public function sanitize(string $key): Sanitizer
    {
        return new Sanitizer($this->getValue($key));
    }

    /**
     * @phpstan-return TValue|null
     */
    abstract protected function getValue(string $key): mixed;
}
