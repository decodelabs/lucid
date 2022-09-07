<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use DecodeLabs\Coercion;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProcessorTrait;

/**
 * @implements Processor<int>
 */
class IntNative implements Processor
{
    /**
     * @phpstan-use ProcessorTrait<int>
     */
    use ProcessorTrait;

    public function getOutputTypes(): array
    {
        return ['int', 'number'];
    }

    /**
     * Convert prepared value to int or null
     */
    public function coerce(mixed $value): ?int
    {
        if ($value === null) {
            return null;
        }

        return Coercion::toInt($value);
    }

    /**
     * Convert prepared value to int
     */
    public function forceCoerce(mixed $value): ?int
    {
        return Coercion::toIntOrNull($value) ?? 0;
    }
}
