<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use DecodeLabs\Coercion;
use DecodeLabs\Lucid\Error;
use Generator;

trait StringTrait
{
    /**
     * Convert prepared value to string or null
     */
    public function coerce(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return Coercion::toString($value);
    }

    /**
     * Convert prepared value to string
     */
    public function forceCoerce(mixed $value): ?string
    {
        return Coercion::forceString($value);
    }
}
