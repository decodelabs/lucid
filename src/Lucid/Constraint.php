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
 */
interface Constraint
{
    /**
     * @phpstan-param Processor<TValue> $processor
     */
    public function __construct(Processor $processor);

    /**
     * @return array<string>|null
     */
    public static function getProcessorOutputTypes(): ?array;

    public function getWeight(): int;

    /**
     * @phpstan-return Processor<TValue>
     */
    public function getProcessor(): Processor;

    /**
     * @phpstan-param TParam $param
     * @return $this
     */
    public function setParameter(mixed $param): static;
    public function getParameter(): mixed;

    public function prepareValue(mixed $value): mixed;

    /**
     * @phpstan-param TValue $value
     * @phpstan-return TValue|null
     */
    public function alterValue(mixed $value): mixed;

    /**
     * @phpstan-param TValue|null $value
     * @phpstan-return Generator<int, Error|null, mixed, bool>
     */
    public function validate(mixed $value): Generator;

    /**
     * @phpstan-param TValue $value
     * @phpstan-return TValue
     */
    public function constrain(mixed $value): mixed;
}
