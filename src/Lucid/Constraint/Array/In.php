<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\Array;

use DecodeLabs\Coercion;
use DecodeLabs\Lucid\Constraint\In as InConstraint;
use DecodeLabs\Lucid\Processor\ArrayNative;
use Generator;

/**
 * @template TValue
 * @extends InConstraint<TValue>
 */
class In extends InConstraint
{
    public const array OutputTypes = [
        'array'
    ];

    protected function validateParameter(
        mixed $parameter
    ): array {
        $output = Coercion::asArray($parameter);

        if (
            $this->processor instanceof ArrayNative &&
            $this->processor->childType !== null
        ) {
            foreach ($output as $i => $item) {
                $output[$i] = $this->processor->childType->coerce($item);
            }
        }

        return $output;
    }

    public function validate(
        mixed $value
    ): Generator {
        if ($value === null) {
            return true;
        }

        foreach (Coercion::asArray($value) as $item) {
            yield from parent::validate($item);
        }

        return true;
    }
}
