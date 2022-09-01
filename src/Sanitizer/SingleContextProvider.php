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
    public function as(
        string $type,
        ?Closure $setup = null
    ): mixed;

    public function forceAs(
        string $type,
        ?Closure $setup = null
    ): mixed;

    /**
     * @phpstan-return Sanitizer<TValue>
     */
    public function sanitize(bool $required = true): Sanitizer;
}
