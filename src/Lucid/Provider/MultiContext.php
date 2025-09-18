<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Provider;

use Closure;
use DecodeLabs\Lucid\Provider;
use DecodeLabs\Lucid\Sanitizer;
use DecodeLabs\Lucid\Validate\Result;

/**
 * @template TValue
 */
interface MultiContext extends Provider
{
    /**
     * @param array<string,mixed>|Closure|null $setup
     */
    public function cast(
        int|string $key,
        string $type,
        array|Closure|null $setup = null
    ): mixed;

    /**
     * @param array<string,mixed>|Closure|null $setup
     * @return Result<mixed>
     */
    public function validate(
        int|string $key,
        string $type,
        array|Closure|null $setup = null
    ): Result;

    /**
     * @param array<string,mixed>|Closure|null $setup
     */
    public function is(
        int|string $key,
        string $type,
        array|Closure|null $setup = null
    ): bool;

    public function sanitize(
        int|string $key
    ): Sanitizer;
}
