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
interface MultiContextProvider
{
    /**
     * @param array<string, mixed>|Closure|null $setup
     */
    public function getAs(
        string $key,
        string $type,
        array|Closure|null $setup = null
    ): mixed;

    /**
     * @param array<string, mixed>|Closure|null $setup
     */
    public function forceAs(
        string $key,
        string $type,
        array|Closure|null $setup = null
    ): mixed;

    /**
     * @phpstan-return Sanitizer<TValue>
     */
    public function sanitize(string $key): Sanitizer;
}
