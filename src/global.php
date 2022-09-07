<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

/**
 * global helpers
 */

namespace DecodeLabs\Lucid
{
    use DecodeLabs\Archetype;
    use DecodeLabs\Archetype\Resolver\LucidConstraint as ConstraintResolver;
    use DecodeLabs\Lucid;
    use DecodeLabs\Veneer;

    // Veneer
    Veneer::register(Context::class, Lucid::class);

    // Load Archetype Constraint Resolver
    Archetype::register(new ConstraintResolver());
}
