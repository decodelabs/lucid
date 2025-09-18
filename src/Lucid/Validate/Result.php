<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Validate;

use DecodeLabs\Lucid\Processor;

/**
 * @template TValue
 */
class Result
{
    /**
     * @var TValue|null
     */
    public protected(set) mixed $value = null;

    /**
     * @var Processor<TValue>
     */
    public protected(set) Processor $processor;

    public string $type {
        get => $this->processor->name;
    }

    public bool $valid {
        get => empty($this->errors);
    }

    /**
     * @var array<string,Error>
     */
    public protected(set) array $errors = [];

    /**
     * Init with processor
     *
     * @param Processor<TValue> $processor
     */
    public function __construct(
        Processor $processor
    ) {
        $this->processor = $processor;
    }


    /**
     * @return $this
     */
    public function addError(
        Error $error
    ): static {
        $this->errors[$error->id] = $error;
        return $this;
    }


    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function countErrors(): int
    {
        return count($this->errors);
    }
}
