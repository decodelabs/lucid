<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Tests;

use Closure;
use DecodeLabs\Exceptional;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\Sanitizer;
use DecodeLabs\Lucid\Validate\Result;

class SanitizerImplementation implements Sanitizer
{
    protected mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    public function as(
        string $type,
        array|Closure|null $setup = null
    ): mixed {
        throw Exceptional::NotImplemented(
            message: 'This is not implemented'
        );
    }

    public function validate(
        string $type,
        array|Closure|null $setup = null
    ): Result {
        throw Exceptional::NotImplemented(
            message: 'This is not implemented'
        );
    }


    /**
     * Load processor for value
     *
     * @param array<string, mixed>|Closure|null $setup
     * @return Processor<mixed>
     */
    public function loadProcessor(
        string $type,
        array|Closure|null $setup = null
    ): Processor {
        throw Exceptional::NotImplemented(
            message: 'This is not implemented'
        );
    }
}
