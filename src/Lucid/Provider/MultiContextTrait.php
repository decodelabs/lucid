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
        return $this->sanitize($key)->as($type, $setup);
    }

    public function validate(
        int|string $key,
        string $type,
        array|Closure|null $setup = null
    ): Result {
        return $this->sanitize($key)->validate($type, $setup);
    }

    public function is(
        int|string $key,
        string $type,
        array|Closure|null $setup = null
    ): bool {
        try {
            return $this->validate($key, $type, $setup)->valid;
        } catch (ConstraintNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            return false;
        }
    }

    public function sanitize(
        int|string $key
    ): Sanitizer {
        return $this->newSanitizer($this->getValue($key));
    }

    /**
     * @return TValue|null
     */
    abstract protected function getValue(
        int|string $key
    ): mixed;
}
