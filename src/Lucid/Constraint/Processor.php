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
     * @phpstan-use ConstraintTrait<TValue, TValue>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [];

    public function getName(): string
    {
        return $this->processor->getName();
    }

    public function getWeight(): int
    {
        return 1;
    }
}
