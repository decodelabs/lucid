<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use DecodeLabs\Archetype;
use DecodeLabs\Exceptional;
use Generator;
use ReflectionClass;

/**
 * @template TOutput
 */
trait ProcessorTrait
{
    /**
     * @phpstan-var array<string, Constraint<mixed, TOutput>>
     */
    protected array $constraints = [];

    /**
     * @phpstan-var Sanitizer<TOutput>
     */
    protected Sanitizer $sanitizer;

    /**
     * @phpstan-param Sanitizer<TOutput> $sanitizer
     */
    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }


    public function getName(): string
    {
        $output = (new ReflectionClass($this))
            ->getShortName();

        if (substr($output, -6) === 'Native') {
            $output = substr($output, 0, -6);
        }

        return $output;
    }


    public function getSanitizer(): Sanitizer
    {
        return $this->sanitizer;
    }


    final public function prepareValue(mixed $value): mixed
    {
        foreach ($this->constraints as $constraint) {
            $value = $constraint->prepareValue($value);
        }

        return $value;
    }


    final public function alterValue(mixed $value): mixed
    {
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
            $spec = $this->getName() . ':' . implode(':', $this->getOutputTypes());

            try {
                $class = Archetype::resolve(Constraint::class, $spec . ':' . ucfirst($constraint));
            } catch (Archetype\Exception $e) {
                throw Exceptional::{'NotFound,DecodeLabs/Archetype/NotFound'}(
                    ucfirst($constraint) . ' constraint could not be found for ' . $this->getName() . ' processor',
                    [
                        'previous' => $e
                    ]
                );
            }

            $this->checkConstraintTypes($constraint, $class);
            $this->constraints[$constraint] = new $class($this);
        }

        $this->constraints[$constraint]->setParameter($param);
        return $this;
    }

    protected function checkConstraintTypes(
        string $constraint,
        string $class
    ): void {
        if (null === ($types = $class::getProcessorOutputTypes())) {
            return;
        }

        $found = false;

        foreach ($this->getOutputTypes() as $type) {
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
                ucfirst($constraint) . ' constraint cannot be used on type ' . $this->getName()
            );
        }
    }


    public function getDefaultConstraints(): array
    {
        return [];
    }


    public function prepareConstraints(): array
    {
        uasort($this->constraints, function ($a, $b) {
            return $a->getWeight() <=> $b->getWeight();
        });

        return $this->constraints;
    }



    public function validateConstraints(mixed $value): Generator
    {
        foreach ($this->constraints as $constraint) {
            yield from $gen = $constraint->validate($value);

            if (false === $gen->getReturn()) {
                break;
            }
        }
    }


    public function constrain(mixed $value): mixed
    {
        foreach ($this->constraints as $constraint) {
            $value = $constraint->constrain($value);
        }

        return $value;
    }
}