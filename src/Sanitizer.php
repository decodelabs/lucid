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

/**
 * @template TInput
 */
class Sanitizer
{
    /**
     * @phpstan-var TInput
     */
    protected mixed $value;


    /**
     * Init with raw value
     *
     * @phpstan-param TInput $value
     */
    public function __construct(mixed $value)
    {
        if ($value instanceof Closure) {
            $value = $value();
        }

        $this->value = $value;
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
     * Process value as type
     *
     * @param array<string, mixed>|Closure|null $setup
     */
    public function as(
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        $processor = $this->loadProcessor($type, $setup);
        $value = $processor->prepareValue($this->value);
        $value = $processor->coerce($value);

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
     *
     * @param array<string, mixed>|Closure|null $setup
     */
    public function forceAs(
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        $processor = $this->loadProcessor($type, $setup);
        $value = $processor->prepareValue($this->value);
        $value = $processor->forceCoerce($value);
        return $processor->constrain($value);
    }


    /**
     * Load processor for value
     *
     * @param array<string, mixed>|Closure|null $setup
     * @phpstan-return Processor<mixed>
     */
    public function loadProcessor(
        string $type,
        array|Closure|null $setup = null
    ): Processor {
        $required = true;

        // Optional
        if (substr($type, 0, 1) === '?') {
            $type = substr($type, 1);
            $required = false;
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
        $processor->test('required', $required);

        if ($setup instanceof Closure) {
            $setup->call($processor);
        } elseif (is_array($setup)) {
            foreach ($setup as $key => $value) {
                $processor->test($key, $value);
            }
        }

        return $processor;
    }
}
