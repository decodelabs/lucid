<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProcessorTrait;

/**
 * @template TChild
 * @implements Processor<array<TChild>>
 */
class ListNative implements Processor
{
    /**
     * @phpstan-use ProcessorTrait<array<TChild>>
     */
    use ProcessorTrait;

    /**
     * @phpstan-var Processor<TChild>
     */
    protected Processor $childType;

    public function getOutputTypes(): array
    {
        return ['array'];
    }

    public function isMultiValue(): bool
    {
        return true;
    }


    /**
     * @phpstan-param Processor<TChild> $processor
     */
    public function setChildType(Processor $processor): void
    {
        $this->childType = $processor;
    }

    /**
     * Convert prepared value to bool or null
     *
     * @phpstan-return array<TChild>|null
     */
    public function coerce(mixed $value): ?array
    {
        if ($value === null) {
            return null;
        }

        if (!is_iterable($value)) {
            $value = [$value];
        }

        $output = [];

        foreach ($value as $key => $inner) {
            if (isset($this->childType)) {
                $inner = $this->childType->coerce($inner);
            }

            $output[$key] = $inner;
        }

        return $output;
    }
}
