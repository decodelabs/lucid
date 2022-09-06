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
            $class = Archetype::resolve(Constraint::class, ucfirst($constraint));

            if (null !== ($types = $class::getProcessorOutputTypes())) {
                $found = false;

                foreach ($this->getOutputTypes() as $type) {
                    if (in_array($type, $types)) {
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $name =

                    throw Exceptional::InvalidArgument(
                        ucfirst($constraint) . ' constraint cannot be used on type ' . $this->getName()
                    );
                }
            }

            $this->constraints[$constraint] = new $class($this);
        }

        $this->constraints[$constraint]->setParameter($param);
        $this->prepareConstraints();

        return $this;
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
