<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Provider;

use Closure;
use DecodeLabs\Lucid\Constraint\NotFoundException as ConstraintNotFoundException;
use DecodeLabs\Lucid\ProviderTrait;
use DecodeLabs\Lucid\Sanitizer;
use DecodeLabs\Lucid\Validate\Result;
use Exception;

/**
 * @phpstan-require-implements DirectContext
 */
trait DirectContextTrait
{
    use ProviderTrait;

    public function cast(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return $this->sanitize($value)->as($type, $setup);
    }

    public function validate(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): Result {
        return $this->sanitize($value)->validate($type, $setup);
    }

    public function is(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): bool {
        try {
            return $this->validate($value, $type, $setup)->valid;
        } catch (ConstraintNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sanitize(
        mixed $value
    ): Sanitizer {
        return $this->newSanitizer($value);
    }
}
