<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use Generator;
use ReflectionClass;

/**
 * @template TParam
 * @template TValue
 */
trait ConstraintTrait
{
    /**
     * @phpstan-var Processor<TValue>
     */
    protected Processor $processor;

    /**
     * @phpstan-param Processor<TValue> $processor
     */
    public function __construct(Processor $processor)
    {
        $this->processor = $processor;
    }

    public static function getProcessorOutputTypes(): ?array
    {
        if (
            defined('static::OUTPUT_TYPES') &&
            /** @phpstan-ignore-next-line */
            is_array(static::OUTPUT_TYPES)
        ) {
            /** @phpstan-ignore-next-line */
            return static::OUTPUT_TYPES;
        }

        return null;
    }

    public function getName(): string
    {
        return (new ReflectionClass($this))
            ->getShortName();
    }

    public function getWeight(): int
    {
        return 10;
    }

    public function getProcessor(): Processor
    {
        return $this->processor;
    }

    /**
     * @phpstan-param TParam $param
     * @return $this
     */
    public function setParameter(mixed $param): static
    {
        return $this;
    }

    public function getParameter(): mixed
    {
        return null;
    }

    public function prepareValue(mixed $value): mixed
    {
        return $value;
    }

    public function alterValue(mixed $value): mixed
    {
        return $value;
    }

    /**
     * @phpstan-param TValue $value
     */
    public function validate(mixed $value): Generator
    {
        yield null;
        return true;
    }
}
