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
use DecodeLabs\Lucid\Validate\Error;
use Generator;
use ReflectionObject;

/**
 * @implements Constraint<Closure(?string):Generator<string>,string>
 */
class Validate implements Constraint
{
    /**
     * @use ConstraintTrait<Closure(?string):Generator<string>,string>
     */
    use ConstraintTrait;
    use NameTrait;

    public const int Weight = 0;

    protected function validateParameter(
        mixed $parameter
    ): mixed {
        if (!is_callable($parameter)) {
            throw Exceptional::InvalidArgument(
                message: 'Validator must be callable'
            );
        }

        return $parameter;
    }

    public function validate(
        mixed $value
    ): Generator {
        if (!is_callable($this->parameter)) {
            throw Exceptional::InvalidArgument(
                message: 'Validator must be callable'
            );
        }

        foreach ($gen = ($this->parameter)($value) as $key => $message) {
            $error = new Error($this, $value, $message);

            if (is_string($key)) {
                $ref = new ReflectionObject($error)->getProperty('constraintKey');
                $ref->setValue($error, $key);
            }

            yield $error;
        }

        return $gen->getReturn() === false ?
            false : true;
    }
}
