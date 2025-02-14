<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint;

use Closure;
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;

/**
 * @implements Constraint<Closure,string>
 */
class Sanitize implements Constraint
{
    /**
     * @use ConstraintTrait<Closure,string>
     */
    use ConstraintTrait;

    public const int Weight = 0;

    protected function validateParameter(
        mixed $parameter
    ): mixed {
        if (!is_callable($parameter)) {
            throw Exceptional::InvalidArgument(
                message: 'Sanitizer must be callable'
            );
        }

        return $parameter;
    }

    public function prepareValue(
        mixed $value
    ): mixed {
        return ($this->parameter)($value);
    }
}
