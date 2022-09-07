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
use Stringable;

/**
 * @implements Processor<string>
 */
class Name implements Processor
{
    /**
     * @phpstan-use ProcessorTrait<string>
     */
    use ProcessorTrait;

    public function getOutputTypes(): array
    {
        return ['string:name'];
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

        $string = Coercion::toString($value);
        return Dictum::name($string);
    }

    /**
     * Convert prepared value to string
     */
    public function forceCoerce(mixed $value): ?string
    {
        return $this->coerce($value) ?? '';
    }
}
