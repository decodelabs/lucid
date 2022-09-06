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
interface SingleContextProvider
{
    /**
     * @param array<string, mixed>|Closure|null $setup
     */
    public function as(
        string $type,
        array|Closure|null $setup = null
    ): mixed;

    /**
     * @param array<string, mixed>|Closure|null $setup
     */
    public function forceAs(
        string $type,
        array|Closure|null $setup = null
    ): mixed;

    /**
     * @phpstan-return Sanitizer<TValue>
     */
    public function sanitize(): Sanitizer;
}
