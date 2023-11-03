<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\String;

use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @implements Constraint<string, string>
 */
class Pattern implements Constraint
{
    /**
     * @use ConstraintTrait<string, string>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'string', 'string:'
    ];

    protected ?string $pattern = null;

    public function getWeight(): int
    {
        return 20;
    }

    public function setParameter(
        mixed $param
    ): static {
        $this->pattern = $param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->pattern;
    }

    public function validate(
        mixed $value
    ): Generator {
        if (
            $this->pattern !== null &&
            !filter_var(
                (string)$value,
                \FILTER_VALIDATE_REGEXP,
                ['options' => ['regexp' => $this->pattern]]
            )
        ) {
            yield new Error(
                $this,
                $value,
                '%type% value does not match pattern %pattern%'
            );
        }

        return true;
    }
}
