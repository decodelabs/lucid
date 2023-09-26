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
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @implements Processor<string>
 */
class Url implements Processor
{
    /**
     * @use ProcessorTrait<string>
     */
    use ProcessorTrait;

    public function getOutputTypes(): array
    {
        return ['string:url'];
    }

    /**
     * Convert prepared value to string or null
     */
    public function coerce(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = Coercion::toString($value);

        if (!preg_match('/^[a-zA-Z0-9]+\:/', $value)) {
            $value = 'https://' . $value;
        }

        if (false === ($output = filter_var($value, \FILTER_SANITIZE_URL))) {
            $output = $value;
        }

        return $output;
    }


    /**
     * Check URL is valid
     */
    public function validateType(mixed $value): Generator
    {
        if (!filter_var($value, \FILTER_VALIDATE_URL)) {
            yield new Error(
                $this,
                $value,
                'Value is not a valid URL'
            );

            return false;
        }

        return true;
    }
}
