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

interface DirectContext extends Provider
{
    /**
     * @template TInput
     * @param TInput $value
     * @param array<string,mixed>|Closure|null $setup
     */
    public function cast(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): mixed;

    /**
     * @template TInput
     * @param TInput $value
     * @param array<string,mixed>|Closure|null $setup
     * @return Result<mixed>
     */
    public function validate(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): Result;

    /**
     * @template TInput
     * @param TInput $value
     * @param array<string,mixed>|Closure|null $setup
     */
    public function is(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): bool;

    public function sanitize(
        mixed $value
    ): Sanitizer;
}
