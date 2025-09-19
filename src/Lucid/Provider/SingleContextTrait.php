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
 * For use in a single value container context
 *
 * @template TValue
 * @phpstan-require-implements SingleContext<TValue>
 */
trait SingleContextTrait
{
    use ProviderTrait;

    public function as(
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return self::castValue($this->getValue(), $type, $setup);
    }

    public function validate(
        string $type,
        array|Closure|null $setup = null
    ): Result {
        return self::validateValue($this->getValue(), $type, $setup);
    }

    public function is(
        string $type,
        array|Closure|null $setup = null
    ): bool {
        try {
            return self::validateValue($this->getValue(), $type, $setup)->valid;
        } catch (ConstraintNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @return TValue
     */
    abstract protected function getValue(): mixed;
}
