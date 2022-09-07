<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Sanitizer;

use Closure;
use DecodeLabs\Lucid\Sanitizer;
use DecodeLabs\Lucid\Validate\Result;

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
     * @param array<string, mixed>|Closure|null $setup
     * @return Result<mixed>
     */
    public function validate(
        string $type,
        array|Closure|null $setup = null
    ): Result;

    /**
     * @param array<string, mixed>|Closure|null $setup
     */
    public function is(
        string $type,
        array|Closure|null $setup = null
    ): bool;


    /**
     * @phpstan-return Sanitizer<TValue>
     */
    public function sanitize(): Sanitizer;
}
