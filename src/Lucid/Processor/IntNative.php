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

/**
 * @implements Processor<int>
 */
class IntNative implements Processor
{
    /**
     * @use ProcessorTrait<int>
     */
    use ProcessorTrait;

    public const array OutputTypes = ['int', 'number'];

    /**
     * Convert prepared value to int or null
     */
    public function coerce(
        mixed $value
    ): ?int {
        if ($value === null) {
            return $this->isRequired() ? 0 : null;
        }

        return Coercion::toInt($value);
    }
}
