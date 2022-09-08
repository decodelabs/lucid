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
use DecodeLabs\Lucid\Validate\Result;

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

        if ($value !== null) {
            $value = $processor->alterValue($value);
        }

        foreach ($gen = $processor->validate($value) as $error) {
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
     * Validate value as type
     *
     * @param array<string, mixed>|Closure|null $setup
     * @return Result<mixed>
     */
    public function validate(
        string $type,
        array|Closure|null $setup = null
    ): Result {
        $processor = $this->loadProcessor($type, $setup);
        $value = $processor->prepareValue($this->value);
        $value = $processor->coerce($value);

        if ($value !== null) {
            $value = $processor->alterValue($value);
        }

        $result = new Result($processor);

        foreach ($gen = $processor->validate($value) as $error) {
            if ($error === null) {
                continue;
            }

            $result->addError($error);
        }

        $result->setValue($gen->getReturn() ?? $value);
        return $result;
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

        try {
            $class = Archetype::resolve(Processor::class, $type);
        } catch (Archetype\Exception $e) {
            throw Exceptional::{'./Processor/NotFound,DecodeLabs/Archetype/NotFound'}(
                'Processor ' . $type . ' could not be found'
            );
        }

        $processor = new $class($this);
        $processor->test('required', $required);

        foreach ($processor->getDefaultConstraints() as $key => $value) {
            $processor->test($key, $value);
        }

        if ($setup instanceof Closure) {
            $setup->call($processor);
        } elseif (is_array($setup)) {
            foreach ($setup as $key => $value) {
                $processor->test($key, $value);
            }
        }

        $processor->prepareConstraints();
        return $processor;
    }
}
