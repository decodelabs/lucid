<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint;

use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Error;
use Generator;

/**
 * @implements Constraint<int, string>
 */
class MinLength implements Constraint
{
    /**
     * @phpstan-use ConstraintTrait<int, string>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'string'
    ];

    protected ?int $length = null;

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(mixed $param): static
    {
        if ($param <= 0) {
            throw Exceptional::InvalidArgument(
                'Max length must be greater than 0'
            );
        }

        $this->length = $param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->length;
    }

    public function validate(mixed $value): Generator
    {
        $length = mb_strlen((string)$value);

        if (
            $this->length > 0 &&
            $length < $this->length
        ) {
            yield new Error(
                $this,
                $value,
                '%type% value must contain at least %minLength% characters'
            );
        }

        return true;
    }

    public function constrain(mixed $value): mixed
    {
        return str_pad($value, (int)$this->length, ' ');
    }
}
