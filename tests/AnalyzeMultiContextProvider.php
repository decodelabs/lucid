<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Tests;

use DecodeLabs\Lucid\Provider\MultiContext;
use DecodeLabs\Lucid\Provider\MultiContextTrait;
use DecodeLabs\Lucid\Sanitizer;

/**
 * @template TValue
 * @implements MultiContext<TValue|null>
 */
class AnalyzeMultiContextProvider implements MultiContext
{
    /**
     * @use MultiContextTrait<TValue|null>
     */
    use MultiContextTrait;

    /**
     * @var array<string, TValue>
     */
    protected array $values;

    public function __construct(
        string $key,
        mixed $value
    ) {
        $this->values[$key] = $value;
    }

    /**
     * @return TValue|null
     */
    public function getValue(
        int|string $key
    ): mixed {
        return $this->values[$key] ?? null;
    }

    protected function newSanitizer(mixed $value): Sanitizer
    {
        return new SanitizerImplementation($value);
    }
}


// Test passing an Exception through
$test = new AnalyzeMultiContextProvider('value', new \Exception('test'));
$test->sanitize('value');
