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
use Stringable;

/**
 * @implements Processor<string>
 */
class StringNative implements Processor
{
    /**
     * @phpstan-use ProcessorTrait<string>
     */
    use ProcessorTrait;

    public function getOutputTypes(): array
    {
        return ['string'];
    }

    public function getDefaultConstraints(): array
    {
        return [
            'trim' => true
        ];
    }

    /**
     * Convert prepared value to string or null
     */
    public function coerce(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof Stringable) {
            $value = (string)$value;
        }

        if (is_array($value)) {
            return implode(', ', $value);
        }

        if (is_object($value)) {
            return get_class($value);
        }

        return Coercion::forceString($value);
    }
}
