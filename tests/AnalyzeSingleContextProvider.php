<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Tests;

use DecodeLabs\Lucid\Sanitizer\SingleContextProvider;
use DecodeLabs\Lucid\Sanitizer\SingleContextProviderTrait;

/**
 * @template TValue
 * @implements SingleContextProvider<TValue>
 */
class AnalyzeSingleContextProvider implements SingleContextProvider
{
    /**
     * @use SingleContextProviderTrait<TValue>
     */
    use SingleContextProviderTrait;

    /**
     * @phpstan-var TValue
     */
    protected mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * @phpstan-return TValue
     */
    public function getValue(): mixed
    {
        return $this->value;
    }
}


// Test passing an Exception through
$test = new AnalyzeSingleContextProvider(new \Exception('test'));
$test->sanitize()->getValue()->getCode();
