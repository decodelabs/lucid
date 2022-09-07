<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\String;

use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Error;
use Generator;

/**
 * @implements Constraint<bool, string>
 */
class Emojis implements Constraint
{
    /**
     * @phpstan-use ConstraintTrait<bool, string>
     */
    use ConstraintTrait;

    public const OUTPUT_TYPES = [
        'string'
    ];

    public const REGEX = '%(?:
        \xF0[\x90-\xBF][\x80-\xBF]{2} |     # planes 1-3
        [\xF1-\xF3][\x80-\xBF]{3}     |     # planes 4-15
        \xF4[\x80-\x8F][\x80-\xBF]{2}       # plane 16
    )%xs';

    protected bool $emojis = false;

    public function getWeight(): int
    {
        return 50;
    }

    public function setParameter(mixed $param): static
    {
        $this->emojis = $param;
        return $this;
    }

    public function getParameter(): mixed
    {
        return $this->emojis;
    }

    public function validate(mixed $value): Generator
    {
        if ($value === null) {
            return true;
        }

        if (
            !$this->emojis &&
            preg_match(self::REGEX, (string)$value)
        ) {
            yield new Error(
                $this,
                $value,
                '%type% value must not contain emojis'
            );
        }

        return true;
    }

    public function constrain(mixed $value): mixed
    {
        if (!$this->emojis) {
            $value = preg_replace(self::REGEX, '', $value) ?? $value;
        }

        return $value;
    }
}
