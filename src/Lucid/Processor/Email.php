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
class Email implements Processor
{
    /**
     * @use ProcessorTrait<string>
     */
    use ProcessorTrait;

    public const array OutputTypes = ['string:email'];

    /**
     * Convert prepared value to string or null
     */
    public function coerce(
        mixed $value
    ): ?string {
        if ($value === null) {
            return null;
        }

        $value = Coercion::asString($value);

        $value = strtolower($value);
        $value = str_replace([' at ', ' dot '], ['@', '.'], $value);

        if (false === ($output = filter_var($value, \FILTER_SANITIZE_EMAIL))) {
            $output = $value;
        }

        return $output;
    }


    /**
     * Check email is valid
     */
    public function validateType(
        mixed $value
    ): Generator {
        if (!filter_var($value, \FILTER_VALIDATE_EMAIL)) {
            yield new Error(
                $this,
                $value,
                'Value is not a valid email address'
            );

            return false;
        }

        return true;
    }
}
