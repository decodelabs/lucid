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
 * @implements Constraint<bool, string>
 */
class Emojis implements Constraint
{
    /**
     * @use ConstraintTrait<bool, string>
     */
    use ConstraintTrait;

    public const int Weight = 50;

    public const array OutputTypes = [
        'string'
    ];

    protected const Regex = '%(?:
        \xF0[\x90-\xBF][\x80-\xBF]{2} |     # planes 1-3
        [\xF1-\xF3][\x80-\xBF]{3}     |     # planes 4-15
        \xF4[\x80-\x8F][\x80-\xBF]{2}       # plane 16
    )%xs';

    protected function validateParameter(
        mixed $parameter
    ): mixed {
        return (bool)$parameter;
    }

    public function validate(
        mixed $value
    ): Generator {
        if ($value === null) {
            return true;
        }

        if (
            !$this->parameter &&
            preg_match(self::Regex, (string)$value)
        ) {
            yield new Error(
                $this,
                $value,
                '%type% value must not contain emojis'
            );
        }

        return true;
    }
}
