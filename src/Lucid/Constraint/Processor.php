<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint;

use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;

/**
 * This constraint is used to wrap the main Processor
 * to be passed to Error objects
 *
 * @template TValue
 * @implements Constraint<TValue, TValue>
 */
class Processor implements Constraint
{
    /**
     * @use ConstraintTrait<TValue,TValue>
     */
    use ConstraintTrait;

    public const int Weight = 1;

    public const array OutputTypes = [];

    public string $name {
        get => $this->processor->name;
    }
}
