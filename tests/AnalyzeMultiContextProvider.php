<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Tests;

use DecodeLabs\Lucid\Sanitizer\MultiContextProvider;
use DecodeLabs\Lucid\Sanitizer\MultiContextProviderTrait;

/**
 * @template TValue
 * @implements MultiContextProvider<TValue|null>
 */
class AnalyzeMultiContextProvider implements MultiContextProvider
{
    /**
     * @use MultiContextProviderTrait<TValue|null>
     */
    use MultiContextProviderTrait;

    /**
     * @phpstan-var array<string, TValue>
     */
    protected array $values;

    public function __construct(
        string $key,
        mixed $value
    ) {
        $this->values[$key] = $value;
    }

    /**
     * @phpstan-return TValue|null
     */
    public function getValue(string $key): mixed
    {
        return $this->values[$key] ?? null;
    }
}


// Test passing an Exception through
$test = new AnalyzeMultiContextProvider('value', new \Exception('test'));
$test->sanitize('value')->getValue()->getCode();
