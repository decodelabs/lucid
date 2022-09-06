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
class MaxWords implements Constraint
{
    /**
     * @phpstan-use ConstraintTrait<int, string>
     */
    use ConstraintTrait;
    use WordsTrait;

    protected ?int $words = null;

    public function getWeight(): int
    {
        return 25;
    }

    public function setParameter(mixed $param): static
    {
        if ($param <= 0) {
            throw Exceptional::InvalidArgument(
                'Max words must be greater than 0'
            );
        }

        $this->words = $param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->words;
    }

    public function validate(mixed $value): Generator
    {
        $words = $this->countWords($value);

        if (
            $this->words > 0 &&
            $words > $this->words
        ) {
            yield new Error(
                $this,
                $value,
                '%type% value cannot contain more than %maxWords% words'
            );
        }

        return true;
    }

    public function constrain(mixed $value): mixed
    {
        $words = $this->countWords($value);

        if ($words > $this->words) {
            $parts = explode(' ', $value);
            $parts = array_slice($parts, 0, $this->words);
            $value = implode(' ', $parts);
        }

        return $value;
    }
}
