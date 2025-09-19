<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use Closure;
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid;
use DecodeLabs\Lucid\Constraint\Processor as ProcessorConstraint;
use DecodeLabs\Lucid\Validate\Error;
use DecodeLabs\Lucid\Validate\Result;
use Exception;
use ReflectionObject;

/**
 * @phpstan-require-implements Provider
 */
trait ProviderTrait
{
    /**
     * @param array<string,mixed>|Closure|null $setup
     */
    private static function castValue(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        $processor = Lucid::loadProcessor($type, $setup);
        $value = $processor->prepareValue($value);

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
     * @param array<string,mixed>|Closure|null $setup
     * @return Result<mixed>
     */
    private static function validateValue(
        mixed $value,
        string $type,
        array|Closure|null $setup = null
    ): Result {
        $processor = Lucid::loadProcessor($type, $setup);
        $result = new Result($processor);
        $ref = new ReflectionObject($result)->getProperty('value');

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
}
