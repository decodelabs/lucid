<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use Closure;
use DecodeLabs\Lucid\Constraint\NotFoundException as ConstraintNotFoundException;
use DecodeLabs\Lucid\Validate\Result;
use Exception;

class Context
{
    /**
     * Apply sanitizer
     *
     * @template TValue
     * @phpstan-param TValue $value
     * @param array<string, mixed>|Closure|null $setup
     */
    public function make(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return $this->sanitize($value)->as($type, $setup);
    }

    /**
     * Force apply sanitizer
     *
     * @template TValue
     * @phpstan-param TValue $value
     * @param array<string, mixed>|Closure|null $setup
     */
    public function force(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return $this->sanitize($value)->forceAs($type, $setup);
    }


    /**
     * Validate value via sanitizer
     *
     * @template TValue
     * @phpstan-param TValue $value
     * @param array<string, mixed>|Closure|null $setup
     * @return Result<mixed>
     */
    public function validate(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): Result {
        return $this->sanitize($value)->validate($type, $setup);
    }


    /**
     * Check value is valid
     *
     * @template TValue
     * @phpstan-param TValue $value
     * @param array<string, mixed>|Closure|null $setup
     */
    public function is(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): bool {
        try {
            return $this->validate($value, $type, $setup)->isValid();
        } catch (ConstraintNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            return false;
        }
    }


    /**
     * Create sanitizer
     *
     * @template TValue
     * @phpstan-param TValue $value
     * @phpstan-return Sanitizer<TValue>
     */
    public function sanitize(mixed $value): Sanitizer
    {
        return new Sanitizer($value);
    }
}
