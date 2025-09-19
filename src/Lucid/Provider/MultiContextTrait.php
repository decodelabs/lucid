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
 * For use in a key value container where the value is
 * fetched from the map by key
 *
 * @template TValue
 * @phpstan-require-implements MultiContext<TValue>
 */
trait MultiContextTrait
{
    use ProviderTrait;

    public function cast(
        int|string $key,
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return self::castValue($this->getValue($key), $type, $setup);
    }

    public function validate(
        int|string $key,
        string $type,
        array|Closure|null $setup = null
    ): Result {
        return self::validateValue($this->getValue($key), $type, $setup);
    }

    public function is(
        int|string $key,
        string $type,
        array|Closure|null $setup = null
    ): bool {
        try {
            return self::validateValue($this->getValue($key), $type, $setup)->valid;
        } catch (ConstraintNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return TValue|null
     */
    abstract protected function getValue(
        int|string $key
    ): mixed;
}
