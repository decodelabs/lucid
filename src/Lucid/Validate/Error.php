<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Validate;

use DecodeLabs\Coercion;
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\Constraint\Processor as ProcessorConstraint;
use DecodeLabs\Lucid\Processor;

class Error
{
    public string $id {
        get => md5($this->constraintKey . ':' . $this->messageTemplate);
    }

    public protected(set) mixed $value;
    public protected(set) string $messageTemplate;

    public string $message {
        get {
            if (isset($this->message)) {
                return $this->message;
            }

            $output = $this->messageTemplate;
            $parameters = $this->parameters;

            // Type
            if (false !== strstr($output, '%type%')) {
                $type = $this->processorName;

                if (substr($type, -6) === 'Native') {
                    $type = substr($type, 0, -6);
                }

                $parameters['type'] = $type;
            }

            // Param
            $key = $this->constraintKey;
            $parameters[$key] = $this->constraint->parameter;


            // Replace
            foreach ($parameters as $key => $param) {
                $output = str_replace(
                    '%' . $key . '%',
                    Coercion::toString($param),
                    $output
                );
            }

            return $this->message = $output;
        }
    }

    /**
     * @var array<string, mixed>
     */
    public protected(set) array $parameters = [];

    /**
     * @var Constraint<mixed, mixed>
     */
    public protected(set) Constraint $constraint;
    public protected(set) string $constraintKey;

    public string $processorName {
        get => $this->constraint->processor->name;
    }

    /**
     * @param Constraint<mixed, mixed>|Processor<mixed> $constraint
     * @param array<string, mixed> $parameters
     */
    public function __construct(
        Constraint|Processor $constraint,
        mixed $value,
        string $messageTemplate,
        array $parameters = []
    ) {
        if ($constraint instanceof Processor) {
            $constraint = new ProcessorConstraint($constraint);
        }

        $this->constraint = $constraint;
        $this->value = $value;
        $this->messageTemplate = $messageTemplate;
        $this->parameters = $parameters;

        $this->constraintKey = lcfirst(
            $this->constraint->name
        );
    }
}
