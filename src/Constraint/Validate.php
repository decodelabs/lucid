<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint;

use Closure;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @implements Constraint<Closure(?string):Generator<string>, string>
 */
class Validate implements Constraint
{
    /**
     * @use ConstraintTrait<Closure(?string):Generator<string>, string>
     */
    use ConstraintTrait;

    protected ?Closure $validator = null;

    public function getWeight(): int
    {
        return 0;
    }

    public function setParameter(
        mixed $param
    ): static {
        $this->validator = $param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->validator;
    }

    public function validate(
        mixed $value
    ): Generator {
        if (!is_callable($this->validator)) {
            return true;
        }

        foreach ($gen = ($this->validator)($value) as $key => $message) {
            $error = new Error($this, $value, $message);

            if (is_string($key)) {
                $error->setConstraintKey($key);
            }

            yield $error;
        }

        return $gen->getReturn() === false ?
            false : true;
    }
}
