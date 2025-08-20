<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs;

use DecodeLabs\Kingdom\Service;
use DecodeLabs\Kingdom\ServiceTrait;
use DecodeLabs\Lucid\Provider\DirectContext;
use DecodeLabs\Lucid\Provider\DirectContextTrait;
use DecodeLabs\Lucid\Sanitizer;
use DecodeLabs\Lucid\Sanitizer\ValueContainer;

/**
 * @template TValue
 */
class Lucid implements DirectContext, Service
{
    use DirectContextTrait;
    use ServiceTrait;

    public function newSanitizer(
        mixed $value
    ): Sanitizer {
        return new ValueContainer($value);
    }
}
