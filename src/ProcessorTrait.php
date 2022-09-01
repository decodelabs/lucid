<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use Generator;

trait ProcessorTrait
{
    /**
     * @phpstan-var Sanitizer<mixed>
     */
    protected Sanitizer $sanitizer;

    public function __construct(Sanitizer $sanitizer)
    {
        $this->sanitizer = $sanitizer;
    }

    /**
     * Set default value
     *
     * @return $this
     */
    public function setDefaultValue(mixed $default): static
    {
        $this->sanitizer->setDefaultValue($default);
        return $this;
    }

    /**
     * @return Generator<Error|null>
     */
    protected function validateRequired(mixed $value): Generator
    {
        if (
            $value !== null &&
            $value !== ''
        ) {
            return true;
        }

        if ($this->sanitizer->isRequired()) {
            yield new Error(
                $this,
                $value,
                'required',
                'Value is required'
            );
        }

        return false;
    }
}
