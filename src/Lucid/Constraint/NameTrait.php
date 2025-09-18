<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint;

use ReflectionClass;

trait NameTrait
{
    public string $name {
        get => new ReflectionClass($this)->getShortName();
    }
}
