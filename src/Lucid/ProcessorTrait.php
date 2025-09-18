<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use Closure;
use DecodeLabs\Exceptional;
use DecodeLabs\Slingshot;
use Generator;
use ReflectionClass;

/**
 * @template TOutput
 * @phpstan-require-implements Processor
 */
trait ProcessorTrait
{
    public array $outputTypes {
        get => static::OutputTypes;
    }

    public string $name {
        get {
            $output = new ReflectionClass($this)->getShortName();

            if (substr($output, -6) === 'Native') {
                $output = substr($output, 0, -6);
            }

            return $output;
        }
    }

    /**
     * @var array<string, Constraint<mixed, TOutput>>
     */
    protected array $constraints = [];

    public function __construct(
        protected Sanitizer $sanitizer
    ) {
    }

    public function getSanitizer(): Sanitizer
    {
        return $this->sanitizer;
    }

    public function isMultiValue(): bool
    {
        return false;
    }


    final public function prepareValue(
        mixed $value
    ): mixed {
        if ($value instanceof Closure) {
            $value = $value($this);
        }

        foreach ($this->constraints as $constraint) {
            $value = $constraint->prepareValue($value);
        }

        return $value;
    }


    final public function alterValue(
        mixed $value
    ): mixed {
        foreach ($this->constraints as $constraint) {
            $value = $constraint->alterValue($value);

            if ($value === null) {
                break;
            }
        }

        return $value;
    }


    /**
     * Test constraint
     *
     * @return $this
     */
    public function test(
        string $constraint,
        mixed $param
    ): static {
        if ($constraint === 'default') {
            $constraint = 'defaultValue';
        }

        if (!isset($this->constraints[$constraint])) {
            $constraintName = ucfirst($constraint);
            $options = [$this->name . '\\' . $constraintName];

            foreach ($this->outputTypes as $type) {
                $options[] = ucfirst($type) . '\\' . $constraintName;
            }

            $options[] = $constraintName;
            $options = array_unique($options);
            $class = null;

            foreach ($options as $option) {
                $testClass = Constraint::class . '\\' . $option;

                if (class_exists($testClass)) {
                    $class = $testClass;
                    break;
                }
            }

            if ($class === null) {
                throw Exceptional::{'../Constraint/NotFound'}(
                    message: ucfirst($constraint) . ' constraint could not be found for ' . $this->name . ' processor',
                );
            }

            /** @var class-string<Constraint<mixed,mixed>> $class */
            $this->checkConstraintTypes($constraint, $class);

            $slingshot = new Slingshot();
            $slingshot->addType($this);
            $this->constraints[$constraint] = $slingshot->newInstance($class);
        }

        $this->constraints[$constraint]->parameter = $param;
        return $this;
    }

    /**
     * @param class-string<Constraint<mixed,mixed>> $class
     */
    protected function checkConstraintTypes(
        string $constraint,
        string $class
    ): void {
        if (null === ($types = $class::getProcessorOutputTypes())) {
            return;
        }

        $found = false;

        foreach ($this->outputTypes as $type) {
            // Check for <name>: parent types
            if (false !== strpos($type, ':')) {
                $parts = explode(':', $type);
                $parentType = array_shift($parts) . ':';

                if (in_array($parentType, $types)) {
                    $found = true;
                    break;
                }
            }

            // Check for full type
            if (in_array($type, $types)) {
                $found = true;
                break;
            }
        }

        if (!$found) {
            throw Exceptional::InvalidArgument(
                ucfirst($constraint) . ' constraint cannot be used on type ' . $this->name
            );
        }
    }


    protected function isRequired(): bool
    {
        if (!isset($this->constraints['required'])) {
            return false;
        }

        return (bool)$this->constraints['required']->parameter;
    }


    public function getDefaultConstraints(): array
    {
        return [];
    }


    public function prepareConstraints(): array
    {
        uasort($this->constraints, function ($a, $b) {
            return $a->weight <=> $b->weight;
        });

        return $this->constraints;
    }



    public function validate(
        mixed $value
    ): Generator {
        // Type validation
        yield from $gen = $this->validateType($value);

        if (false === $gen->getReturn()) {
            return;
        }

        // Constraint validation
        foreach ($this->constraints as $constraint) {
            yield from $gen = $constraint->validate($value);

            if (false === $gen->getReturn()) {
                return;
            }
        }
    }


    public function validateType(
        mixed $value
    ): Generator {
        yield null;
    }
}
