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
 * @implements Processor<float>
 */
class FloatNative implements Processor
{
    /**
     * @use ProcessorTrait<float>
     */
    use ProcessorTrait;

    public function getOutputTypes(): array
    {
        return ['float', 'number'];
    }

    /**
     * Convert prepared value to float or null
     */
    public function coerce(mixed $value): ?float
    {
        if ($value === null) {
            return $this->isRequired() ? 0 : null;
        }

        return Coercion::toFloat($value);
    }
}
