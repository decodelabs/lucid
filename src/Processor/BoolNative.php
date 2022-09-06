<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use DecodeLabs\Dictum;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProcessorTrait;
use Stringable;

/**
 * @implements Processor<bool>
 */
class BoolNative implements Processor
{
    /**
     * @phpstan-use ProcessorTrait<bool>
     */
    use ProcessorTrait;

    /**
     * Convert prepared value to bool or null
     */
    public function coerce(mixed $value): ?bool
    {
        if ($value === null) {
            return null;
        }

        if (is_bool($value)) {
            return $value;
        }

        if (
            !$value instanceof Stringable &&
            !is_string($value) &&
            !is_numeric($value)
        ) {
            return (bool)$value;
        }

        return Dictum::toBoolean($value);
    }

    /**
     * Convert prepared value to bool
     */
    public function forceCoerce(mixed $value): ?bool
    {
        return $this->coerce($value) ?? false;
    }
}
