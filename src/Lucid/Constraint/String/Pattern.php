<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\String;

use DecodeLabs\Coercion;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\Constraint\NameTrait;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @implements Constraint<string,string>
 */
class Pattern implements Constraint
{
    /**
     * @use ConstraintTrait<string,string>
     */
    use ConstraintTrait;
    use NameTrait;

    public const int Weight = 20;

    public const array OutputTypes = [
        'string', 'string:'
    ];

    protected function validateParameter(
        mixed $parameter
    ): mixed {
        return Coercion::asString($parameter);
    }

    public function validate(
        mixed $value
    ): Generator {
        if (
            !filter_var(
                (string)$value,
                \FILTER_VALIDATE_REGEXP,
                ['options' => ['regexp' => $this->parameter]]
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
