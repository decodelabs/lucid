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
     * Coerce input to output type or null
     *
     * @phpstan-return TOutput|null
     */
    public function coerce(): mixed;

    /**
     * Force coerce to output type
     *
     * @phpstan-return TOutput
     */
    public function forceCoerce(): mixed;


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
