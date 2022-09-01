<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use DecodeLabs\Lucid\Error;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProcessorTrait;
use Generator;

/**
 * @implements Processor<string>
 */
class StringNative implements Processor
{
    use ProcessorTrait;
    use StringTrait;

    protected ?int $maxLength = null;

    /**
     * Set max length
     *
     * @return $this
     */
    public function setMaxLength(?int $length): static
    {
        $this->maxLength = $length;
        return $this;
    }


    public function validateConstraints(mixed $value): Generator
    {
        // Required
        if (!yield from $this->validateRequired($value)) {
            return $value;
        }

        $value = (string)$value;
        $length = mb_strlen($value);

        // Max length
        if (
            $this->maxLength > 0 &&
            $length > $this->maxLength
        ) {
            yield new Error(
                $this,
                $value,
                'maxLength',
                'Value cannot be longer than %maxLength% characters',
                [
                    'maxLength' => $this->maxLength
                ]
            );
        }

        return $value;
    }


    public function constrain(mixed $value): string
    {
        $length = mb_strlen($value);

        // Max length
        if (
            $this->maxLength > 0 &&
            $length > $this->maxLength
        ) {
            $value = mb_substr($value, 0, $this->maxLength);
        }

        return $value;
    }
}
