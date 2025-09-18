<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use DecodeLabs\Lucid\Validate\Error;
use Generator;

/**
 * @template TOutput
 */
interface Processor
{
    /** @var list<string> */
    public const array OutputTypes = [];

    /**
     * @var list<string>
     */
    public array $outputTypes { get; }

    public string $name { get; }


    public function getSanitizer(): Sanitizer;

    public function isMultiValue(): bool;

    public function prepareValue(
        mixed $value
    ): mixed;

    /**
     * @param TOutput $value
     * @return TOutput|null
     */
    public function alterValue(
        mixed $value
    ): mixed;

    /**
     * @return TOutput|null
     */
    public function coerce(
        mixed $value
    ): mixed;


    /**
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
     * @return array<string, Constraint<mixed, TOutput>>
     */
    public function prepareConstraints(): array;


    /**
     * @param TOutput|null $value
     * @return Generator<Error|null>
     */
    public function validate(
        mixed $value
    ): Generator;

    /**
     * @param TOutput|null $value
     * @return Generator<Error|null>
     */
    public function validateType(
        mixed $value
    ): Generator;
}
