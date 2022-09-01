<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

class Error
{
    protected mixed $value;
    protected string $constraint;
    protected string $message;

    /**
     * @var array<string, mixed>
     */
    protected array $params = [];

    /**
     * @phpstan-var Processor<mixed>
     */
    protected Processor $processor;

    /**
     * @phpstan-param Processor<mixed> $processor
     * @param array<string, mixed> $params
     */
    public function __construct(
        Processor $processor,
        mixed $value,
        string $constraint,
        string $message,
        array $params = []
    ) {
        $this->processor = $processor;
        $this->value = $value;
        $this->constraint = $constraint;
        $this->message = $message;
        $this->params = $params;
    }



    public function getValue(): mixed
    {
        return $this->value;
    }


    public function getConstraint(): string
    {
        return $this->constraint;
    }


    public function getMessage(): string
    {
        return $this->message;
    }


    /**
     * @return array<string, mixed>
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @phpstan-return Processor<mixed>
     */
    public function getProcessor(): Processor
    {
        return $this->processor;
    }
}
