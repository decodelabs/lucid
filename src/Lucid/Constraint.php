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
 * @template TParam
 * @template TValue
 */
interface Constraint
{
    public const int Weight = 10;

    /**
     * @var list<string>
     */
    public const array OutputTypes = [];

    public string $name { get; }
    public int $weight { get; }

    /**
     * @var ?TParam
     */
    public mixed $parameter { get; set; }

    /**
     * @var Processor<TValue>
     */
    public Processor $processor { get; }

    /**
     * @return ?list<string>
     */
    public static function getProcessorOutputTypes(): ?array;

    public function prepareValue(
        mixed $value
    ): mixed;

    /**
     * @param TValue $value
     * @return TValue|null
     */
    public function alterValue(
        mixed $value
    ): mixed;

    /**
     * @param TValue|null $value
     * @return Generator<int, Error|null, mixed, bool>
     */
    public function validate(
        mixed $value
    ): Generator;
}
