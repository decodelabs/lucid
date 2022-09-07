<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Validate;

use DecodeLabs\Lucid\Error;
use DecodeLabs\Lucid\Processor;

/**
 * @template TValue
 */
class Result
{
    /**
     * @phpstan-var TValue|null
     */
    protected mixed $value = null;

    /**
     * @phpstan-var Processor<TValue>
     */
    protected Processor $processor;

    /**
     * @var array<Error>
     */
    protected array $errors = [];

    /**
     * Init with processor
     *
     * @phpstan-param Processor<TValue> $processor
     */
    public function __construct(Processor $processor)
    {
        $this->processor = $processor;
    }


    /**
     * Set value
     *
     * @phpstan-param TValue $value
     * @return $this
     */
    public function setValue(mixed $value): static
    {
        $this->value = $value;
        return $this;
    }


    /**
     * Get value
     *
     * @phpstan-return TValue|null
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Get processor
     *
     * @phpstan-return Processor<TValue>
     */
    public function getProcessor(): Processor
    {
        return $this->processor;
    }


    /**
     * Get type name
     */
    public function getType(): string
    {
        return $this->processor->getName();
    }


    /**
     * Is valid
     */
    public function isValid(): bool
    {
        return empty($this->errors);
    }

    /**
     * Add error
     *
     * @return $this;
     */
    public function addError(Error $error): static
    {
        $this->errors[$error->getId()] = $error;
        return $this;
    }

    /**
     * Get errors
     *
     * @return array<Error>
     */
    public function getErrors(): array
    {
        return array_values($this->errors);
    }

    /**
     * Has errors
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Count errors
     */
    public function countErrors(): int
    {
        return count($this->errors);
    }
}
