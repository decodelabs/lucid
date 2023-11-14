<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use DecodeLabs\Coercion;
use DecodeLabs\Dictum;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProcessorTrait;

/**
 * @implements Processor<string>
 */
class PathSlug implements Processor
{
    /**
     * @use ProcessorTrait<string>
     */
    use ProcessorTrait;

    public function getOutputTypes(): array
    {
        return ['string:slug', 'string:pathSlug'];
    }

    /**
     * Convert prepared value to string or null
     */
    public function coerce(
        mixed $value
    ): ?string {
        if ($value === null) {
            return null;
        }

        $string = Coercion::toString($value);
        return Dictum::pathSlug($string);
    }
}
