<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint;

use DecodeLabs\Dictum;
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Error;
use Generator;

/**
 * @implements Constraint<int, string>
 */
class MinWords implements Constraint
{
    /**
     * @phpstan-use ConstraintTrait<int, string>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'string'
    ];

    protected ?int $words = null;

    public function getWeight(): int
    {
        return 25;
    }

    public function setParameter(mixed $param): static
    {
        if ($param <= 0) {
            throw Exceptional::InvalidArgument(
                'Min words must be greater than 0'
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
        $words = Dictum::countWords((string)$value);

        if (
            $this->words > 0 &&
            $words < $this->words
        ) {
            yield new Error(
                $this,
                $value,
                '%type% value must contain at least %minWords% words'
            );
        }

        return true;
    }
}
