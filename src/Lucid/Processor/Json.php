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
class Json implements Processor
{
    /**
     * @use ProcessorTrait<string>
     */
    use ProcessorTrait;

    public const array OutputTypes = ['string:json'];

    public function coerce(
        mixed $value
    ): ?string {
        if ($value === null) {
            return null;
        }

        if (!is_string($value)) {
            $value = json_encode($value);
        }

        return Coercion::asString($value);
    }

    public function validateType(
        mixed $value
    ): Generator {
        if (!json_validate(Coercion::asString($value))) {
            yield new Error($this, $value, 'Value is not a valid JSON string');
            return false;
        }

        return true;
    }
}
