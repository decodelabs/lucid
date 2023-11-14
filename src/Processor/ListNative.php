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
     * @use ProcessorTrait<array<TChild>>
     */
    use ProcessorTrait;

    /**
     * @var Processor<TChild>
     */
    protected ?Processor $childType = null;

    public function getOutputTypes(): array
    {
        return ['array'];
    }

    public function isMultiValue(): bool
    {
        return true;
    }


    /**
     * @param Processor<TChild> $processor
     */
    public function setChildType(
        Processor $processor
    ): void {
        $this->childType = $processor;
    }

    /**
     * Get child type
     *
     * @return Processor<TChild>
     */
    public function getChildType(): ?Processor
    {
        return $this->childType;
    }



    /**
     * Convert prepared value to bool or null
     *
     * @return array<TChild>|null
     */
    public function coerce(
        mixed $value
    ): ?array {
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
