<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProcessorTrait;
use DecodeLabs\Spectrum\Color as Spectrum;

/**
 * @implements Processor<Spectrum>
 */
class Color implements Processor
{
    /**
     * @use ProcessorTrait<Spectrum>
     */
    use ProcessorTrait;

    public function getOutputTypes(): array
    {
        return ['Spectrum:Color', 'DecodeLabs\\Spectrum\\Color'];
    }

    /**
     * Convert prepared value to string or null
     */
    public function coerce(
        mixed $value
    ): ?Spectrum {
        if (!class_exists(Spectrum::class)) {
            throw Exceptional::ComponentUnavailable(
                'Color validation requires decodelabs-spectrum package'
            );
        }

        if ($value === null) {
            return null;
        }

        if (
            is_string($value) ||
            is_float($value) ||
            is_array($value) ||
            $value instanceof Spectrum
        ) {
            return Spectrum::create($value);
        }

        throw Exceptional::UnexpectedValue(
            'Could not coerce value to Spectrum Color',
            null,
            $value
        );
    }
}
