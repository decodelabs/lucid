<?php

/**
 * @package Archetype
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use DecodeLabs\Archetype\Resolver;
use DecodeLabs\Archetype\ResolverTrait;

class ConstraintResolver implements Resolver
{
    use ResolverTrait;

    /**
     * Get mapped interface
     */
    public function getInterface(): string
    {
        return Constraint::class;
    }

    /**
     * Get resolver priority
     */
    public function getPriority(): int
    {
        return 5;
    }

    /**
     * Resolve Archetype class location
     */
    public function resolve(
        string $name
    ): ?string {
        $parts = explode(':', $name);
        $name = ucfirst(array_pop($parts));

        foreach ($parts as $inner) {
            if (false !== strpos($inner, '\\')) {
                continue;
            }

            $output = Constraint::class . '\\' . ucfirst($inner) . '\\' . $name;

            if (class_exists($output)) {
                return $output;
            }
        }

        return Constraint::class . '\\' . $name;
    }
}
