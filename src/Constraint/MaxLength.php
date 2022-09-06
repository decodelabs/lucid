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
class MaxLength implements Constraint
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
        $length = mb_strlen($value ?? '');

        if (
            $this->length > 0 &&
            $length > $this->length
        ) {
            yield new Error(
                $this,
                $value,
                '%type% value cannot be longer than %maxLength% characters'
            );
        }

        return true;
    }

    public function constrain(mixed $value): mixed
    {
        $length = mb_strlen($value);

        if ($length > $this->length) {
            $value = substr($value, 0, $this->length);
        }

        return $value;
    }
}
