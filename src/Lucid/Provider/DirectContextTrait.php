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
        return self::castValue($value, $type, $setup);
    }

    public function validate(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): Result {
        return self::validateValue($value, $type, $setup);
    }

    public function is(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): bool {
        try {
            return self::validateValue($value, $type, $setup)->valid;
        } catch (ConstraintNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            return false;
        }
    }
}
