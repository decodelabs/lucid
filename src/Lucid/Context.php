<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use DecodeLabs\Lucid\Provider\DirectContext;
use DecodeLabs\Lucid\Provider\DirectContextTrait;
use DecodeLabs\Lucid\Sanitizer\ValueContainer;

/**
 * @template TValue
 */
class Context implements DirectContext
{
    use DirectContextTrait;

    public function newSanitizer(mixed $value): Sanitizer
    {
        return new ValueContainer($value);
    }
}
