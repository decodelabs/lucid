<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use DecodeLabs\Coercion;

trait StringTrait
{
    /**
     * Convert prepared value to string or null
     */
    public function coerce(): ?string
    {
        if (null === ($value = $this->sanitizer->prepareValue())) {
            return null;
        }

        $output = Coercion::toString($value);

        if (
            $output === '' &&
            !$this->sanitizer->isRequired()
        ) {
            $output = null;
        }

        return $output;
    }

    /**
     * Convert prepared value to string
     */
    public function forceCoerce(): ?string
    {
        return Coercion::forceString($this->sanitizer->prepareValue());
    }
}
