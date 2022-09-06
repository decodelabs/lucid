<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use DecodeLabs\Coercion;
use ReflectionClass;

class Error
{
    protected mixed $value;
    protected string $message;

    /**
     * @var array<string, mixed>
     */
    protected array $params = [];

    /**
     * @phpstan-var Constraint<mixed, mixed>
     */
    protected Constraint $constraint;
    protected string $constraintKey;

    /**
     * @phpstan-param Constraint<mixed, mixed> $constraint
     * @param array<string, mixed> $params
     */
    public function __construct(
        Constraint $constraint,
        mixed $value,
        string $message,
        array $params = []
    ) {
        $this->constraint = $constraint;
        $this->value = $value;
        $this->message = $message;
        $this->params = $params;

        $this->constraintKey = lcfirst(
            (new ReflectionClass($this->constraint))
                ->getShortName()
        );
    }

    /**
     * @phpstan-return Constraint<mixed, mixed>
     */
    public function getConstraint(): Constraint
    {
        return $this->constraint;
    }

    public function setConstraintKey(string $key): void
    {
        $this->constraintKey = $key;
    }

    public function getConstraintKey(): string
    {
        return $this->constraintKey;
    }

    public function getProcessorName(): string
    {
        return (new ReflectionClass($this->constraint->getProcessor()))
            ->getShortName();
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getMessageTemplate(): string
    {
        return $this->message;
    }

    public function getMessage(): string
    {
        $output = $this->message;
        $params = $this->params;

        // Type
        if (false !== strstr($output, '%type%')) {
            $type = $this->getProcessorName();

            if (substr($type, -6) === 'Native') {
                $type = substr($type, 0, -6);
            }

            $params['type'] = $type;
        }

        // Param
        $key = $this->getConstraintKey();
        $params[$key] = $this->constraint->getParameter();


        // Replace
        foreach ($params as $key => $param) {
            $output = str_replace(
                '%' . $key . '%',
                Coercion::forceString($param),
                $output
            );
        }

        return $output;
    }


    /**
     * @return array<string, mixed>
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
