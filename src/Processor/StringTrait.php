<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use DecodeLabs\Coercion;
use Stringable;

trait StringTrait
{
    public function getOutputTypes(): array
    {
        return ['string'];
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

    /**
     * Convert prepared value to string
     */
    public function forceCoerce(mixed $value): ?string
    {
        return $this->coerce($value) ?? '';
    }
}
