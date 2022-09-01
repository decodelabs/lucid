<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use Closure;
use DecodeLabs\Archetype;
use DecodeLabs\Exceptional;
use DecodeLabs\Tightrope\Manifest\Requirable;
use DecodeLabs\Tightrope\Manifest\RequirableTrait;

/**
 * @template TInput
 */
class Sanitizer implements Requirable
{
    use RequirableTrait;

    /**
     * @phpstan-var TInput
     */
    protected mixed $value;

    protected mixed $default = null;


    /**
     * Init with raw value
     *
     * @phpstan-param TInput $value
     */
    public function __construct(
        mixed $value,
        bool $required = true
    ) {
        if ($value instanceof Closure) {
            $value = $value();
        }

        $this->value = $value;
        $this->required = $required;
    }


    /**
     * Get type of TInput
     */
    public function getType(): string
    {
        return gettype($this->value);
    }


    /**
     * Get original value
     *
     * @phpstan-return TInput
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Set default value
     *
     * @return $this
     */
    public function setDefaultValue(mixed $default): static
    {
        $this->default = $default;
        return $this;
    }

    /**
     * Get default value
     */
    public function getDefaultValue(): mixed
    {
        return $this->default;
    }



    /**
     * Process value as type
     */
    public function as(
        string $type,
        ?Closure $setup = null
    ): mixed {
        $processor = $this->process($type, $setup);
        $value = $processor->coerce();

        foreach ($gen = $processor->validateConstraints($value) as $error) {
            if ($error === null) {
                continue;
            }

            throw Exceptional::UnexpectedValue([
                'message' => $error->getMessage(),
                'data' => $value
            ]);
        }

        return $gen->getReturn() ?? $value;
    }


    /**
     * Process value as type
     */
    public function forceAs(
        string $type,
        ?Closure $setup = null
    ): mixed {
        $processor = $this->process($type, $setup);
        $value = $processor->forceCoerce();
        return $processor->constrain($value);
    }


    /**
     * Load processor for value
     *
     * @phpstan-return Processor<mixed>
     */
    public function process(
        string $type,
        ?Closure $setup = null
    ): Processor {
        // Optional
        if (substr($type, 0, 1) === '?') {
            $type = substr($type, 1);
            $this->required = false;
        }

        $params = [];

        // Instance
        if (substr($type, 0, 1) === ':') {
            $params['type'] = substr($type, 1);
            $type = 'Instance';
        }

        $type = ucfirst($type);

        switch ($type) {
            case 'Bool':
            case 'Int':
            case 'Float':
            case 'String':
            case 'Array':
            case 'Object':
            case 'Null':
            case 'Resource':
                $type .= 'Native';
                break;
        }

        $class = Archetype::resolve(Processor::class, $type);
        $processor = new $class($this);

        if ($setup instanceof Closure) {
            $default = $setup->call($processor);

            if (
                $default !== $this &&
                $default !== $processor
            ) {
                $this->default = $default;
            }
        }

        return $processor;
    }


    /**
     * Prepare value for coercion
     */
    public function prepareValue(): mixed
    {
        if (
            $this->value === '' &&
            $this->default !== null
        ) {
            return $this->default;
        }

        return $this->value ?? $this->default;
    }
}
