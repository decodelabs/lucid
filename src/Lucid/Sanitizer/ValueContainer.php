<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Sanitizer;

use Closure;
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Constraint\Processor as ProcessorConstraint;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\Sanitizer;
use DecodeLabs\Lucid\Validate\Error;
use DecodeLabs\Lucid\Validate\Result;
use DecodeLabs\Slingshot;
use Exception;
use ReflectionObject;

class ValueContainer implements Sanitizer
{
    protected mixed $value = null;


    /**
     * Init with raw value
     */
    public function __construct(
        mixed $value
    ) {
        $this->value = $value;
    }



    /**
     * Process value as type
     *
     * @param array<string,mixed>|Closure|null $setup
     */
    public function as(
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        $processor = $this->loadProcessor($type, $setup);
        $value = $processor->prepareValue($this->value);

        try {
            $value = $processor->coerce($value);
        } catch (Exception $e) {
            throw Exceptional::UnexpectedValue(
                message: 'Unable to coerce value to ' . $processor->name,
                previous: $e,
                data: $value
            );
        }

        if ($value !== null) {
            $value = $processor->alterValue($value);
        }

        foreach ($gen = $processor->validate($value) as $error) {
            if ($error === null) {
                continue;
            }

            throw Exceptional::UnexpectedValue(
                message: $error->message,
                data: $value
            );
        }

        return $gen->getReturn() ?? $value;
    }


    /**
     * Validate value as type
     *
     * @param array<string,mixed>|Closure|null $setup
     * @return Result<mixed>
     */
    public function validate(
        string $type,
        array|Closure|null $setup = null
    ): Result {
        $processor = $this->loadProcessor($type, $setup);
        $result = new Result($processor);
        $ref = new ReflectionObject($result)->getProperty('value');
        $value = $this->value;

        try {
            $value = $processor->prepareValue($value);
            $value = $processor->coerce($value);

            if ($value !== null) {
                $value = $processor->alterValue($value);
            }
        } catch (Exception $e) {
            $ref->setValue($result, $value);

            $result->addError(new Error(
                new ProcessorConstraint($processor),
                $value,
                'Unable to coerce value to ' . $processor->name . ': %message%',
                [
                    'exception' => $e,
                    'message' => $e->getMessage()
                ]
            ));

            return $result;
        }



        foreach ($gen = $processor->validate($value) as $error) {
            if ($error === null) {
                continue;
            }

            $result->addError($error);
        }

        $ref->setValue($result, $gen->getReturn() ?? $value);
        return $result;
    }


    /**
     * Load processor for value
     *
     * @param array<string,mixed>|Closure|null $setup
     * @return Processor<mixed>
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

        // List
        $list = false;

        if (substr($type, -2) === '[]') {
            $list = true;
            $type = substr($type, 0, -2);
        } elseif (preg_match('/array<([a-zA-Z0-9_]+)>/', $type, $matches)) {
            $list = true;
            $type = $matches[1];
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

        $slingshot = new Slingshot();
        $slingshot->addType($this);

        $processor = $slingshot->resolveNamedInstance(Processor::class, $type);

        if ($list) {
            $prev = $processor;
            $processor = new Processor\ArrayNative($this);
            $processor->setChildType($prev);
        }

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
