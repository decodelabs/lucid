<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint;

use DecodeLabs\Coercion;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @template TValue
 * @implements Constraint<array<mixed>,TValue>
 */
class In implements Constraint
{
    /**
     * @use ConstraintTrait<array<mixed>,TValue>
     */
    use ConstraintTrait;
    use NameTrait;

    public const int Weight = 2;

    /**
     * @return array<mixed>
     */
    protected function validateParameter(
        mixed $parameter
    ): array {
        $output = Coercion::asArray($parameter);

        foreach ($output as $i => $value) {
            $output[$i] = $this->processor->coerce($value);
        }

        return $output;
    }

    public function prepareValue(
        mixed $value
    ): mixed {
        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    public function validate(
        mixed $value
    ): Generator {
        if ($value === null) {
            return true;
        }

        if (!in_array($value, $this->parameter ?? [], true)) {
            $strParams = [];

            foreach ($this->parameter ?? [] as $param) {
                $str = Coercion::toString($param);

                if (empty($str)) {
                    if (is_object($param)) {
                        $str = get_class($param);
                    } else {
                        $str = gettype($param);
                    }
                }

                $strParams[] = $str;
            }

            yield new Error(
                $this,
                $value,
                '%type% value must be one of %values%',
                [
                    'values' => implode(', ', $strParams),
                ]
            );
        }

        return true;
    }
}
