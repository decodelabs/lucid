<?php

/**
 * @package Archetype
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

/**
 * global helpers
 */

namespace DecodeLabs\Archetype
{
    use DecodeLabs\Archetype;
    use DecodeLabs\Archetype\Resolver\LucidConstraint as ConstraintResolver;

    // Load Archetype Constraint Resolver
    Archetype::register(new ConstraintResolver());
}
