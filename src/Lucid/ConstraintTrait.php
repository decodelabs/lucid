<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use Generator;

/**
 * @template TParam
 * @template TValue
 * @phpstan-require-implements Constraint<TParam, TValue>
 */
trait ConstraintTrait
{
    public int $weight {
        get => static::Weight;
    }

    /**
     * @var ?TParam
     */
    public mixed $parameter = null {
        // @phpstan-ignore-next-line
        set => $this->validateParameter($value);
    }

    /**
     * @param Processor<TValue> $processor
     */
    public function __construct(
        /** @var Processor<TValue> */
        public protected(set) Processor $processor
    ) {
    }

    public static function getProcessorOutputTypes(): ?array
    {
        return empty(static::OutputTypes) ?
            null :
            static::OutputTypes;
    }

    /**
     * @param ?TParam $parameter
     * @return ?TParam
     */
    protected function validateParameter(
        mixed $parameter
    ): mixed {
        return $parameter;
    }


    public function prepareValue(
        mixed $value
    ): mixed {
        return $value;
    }

    public function alterValue(
        mixed $value
    ): mixed {
        return $value;
    }

    /**
     * @param TValue $value
     */
    public function validate(
        mixed $value
    ): Generator {
        yield null;
        return true;
    }
}
