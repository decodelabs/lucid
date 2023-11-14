<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use DecodeLabs\Archetype;
use DecodeLabs\Lucid;
use DecodeLabs\Lucid\Provider\DirectContext;
use DecodeLabs\Lucid\Provider\DirectContextTrait;
use DecodeLabs\Lucid\Sanitizer\ValueContainer;
use DecodeLabs\Veneer;

/**
 * @template TValue
 */
class Context implements DirectContext
{
    use DirectContextTrait;

    public function newSanitizer(
        mixed $value
    ): Sanitizer {
        return new ValueContainer($value);
    }
}


// Veneer
Veneer::register(Context::class, Lucid::class);

// Load Archetype Constraint Resolver
Archetype::register(new ConstraintResolver());
