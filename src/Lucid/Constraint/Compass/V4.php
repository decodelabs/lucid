<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\Compass;

use DecodeLabs\Coercion;
use DecodeLabs\Compass\Ip;
use DecodeLabs\Compass\Range;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @implements Constraint<bool,Ip|Range>
 */
class V4 implements Constraint
{
    /**
     * @use ConstraintTrait<bool,Ip|Range>
     */
    use ConstraintTrait;

    public const int Weight = 1;

    public const array OutputTypes = [
        'Compass:Ip', 'Compass:Range'
    ];

    protected function validateParameter(
        mixed $parameter
    ): mixed {
        return Coercion::toBool($parameter);
    }

    public function validate(
        mixed $value
    ): Generator {
        if ($value === null) {
            return false;
        }

        if ($this->parameter !== $value->isV4()) {
            yield new Error(
                $this,
                $value,
                '%type% must ' . (!$this->parameter ? 'not ' : '') . ' be IPv4'
            );
        }

        return true;
    }
}
