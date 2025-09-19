<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Provider;

use Closure;
use DecodeLabs\Lucid\Constraint\NotFoundException as ConstraintNotFoundException;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProviderTrait;
use DecodeLabs\Lucid\Validate\Result;
use Exception;

/**
 * For use in a Tree context where a node may process
 * a single value attached to the node, or the child
 * values contained inside, depending on the processor.
 *
 * @template TValue
 * @phpstan-require-implements MixedContext<TValue>
 */
trait MixedContextTrait
{
    use ProviderTrait;

    public function as(
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        return self::castValue($this->getMixedValue(), $type, $setup);
    }

    public function validate(
        string $type,
        array|Closure|null $setup = null
    ): Result {
        return self::validateValue($this->getMixedValue(), $type, $setup);
    }

    public function is(
        string $type,
        array|Closure|null $setup = null
    ): bool {
        try {
            return self::validateValue($this->getMixedValue(), $type, $setup)->valid;
        } catch (ConstraintNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            return false;
        }
    }

    private function getMixedValue(): Closure
    {
        return fn (Processor $processor) =>
            $processor->isMultiValue() ?
                $this->getChildValues() :
                $this->getValue();
    }

    /**
     * @return TValue
     */
    abstract protected function getValue(): mixed;
}
