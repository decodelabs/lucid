<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Sanitizer\ValueContainer;

/**
 * @phpstan-require-implements Provider
 */
trait ProviderTrait
{
    protected function newSanitizer(
        mixed $value
    ): Sanitizer {
        if (!class_exists(ValueContainer::class)) {
            throw Exceptional::ComponentUnavailable(
                message: 'DecodeLabs/Lucid package is required for sanitisation'
            );
        }

        return new ValueContainer($value);
    }
}
