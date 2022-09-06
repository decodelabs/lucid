<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use Generator;

/**
 * @template TOutput
 */
interface Processor
{
    /**
     * @phpstan-param Sanitizer<mixed> $sanitizer
     */
    public function __construct(Sanitizer $sanitizer);


    /**
     * @phpstan-return Sanitizer<TOutput>
     */
    public function getSanitizer(): Sanitizer;

    /**
     * Prepare value before coercion
     */
    public function prepareValue(mixed $value): mixed;

    /**
     * Apply value processing before validation
     *
     * @phpstan-param TOutput $value
     * @phpstan-return TOutput|null
     */
    public function alterValue(mixed $value): mixed;

    /**
     * Coerce input to output type or null
     *
     * @phpstan-return TOutput|null
     */
    public function coerce(mixed $value): mixed;

    /**
     * Force coerce to output type
     *
     * @phpstan-return TOutput
     */
    public function forceCoerce(mixed $value): mixed;


    /**
     * Test validity of constraint
     *
     * @return $this
     */
    public function test(
        string $constraint,
        mixed $param
    ): static;


    /**
     * @return array<string, mixed>
     */
    public function getDefaultConstraints(): array;


    /**
     * @phpstan-return array<string, Constraint<mixed, TOutput>>
     */
    public function prepareConstraints(): array;


    /**
     * Test constraints and yield errors in sequence
     *
     * @phpstan-param TOutput|null $value
     * @return Generator<Error|null>
     */
    public function validateConstraints(mixed $value): Generator;

    /**
     * Apply constraints to coerced input
     *
     * @phpstan-param TOutput $value
     * @phpstan-return TOutput
     */
    public function constrain(mixed $value): mixed;
}
