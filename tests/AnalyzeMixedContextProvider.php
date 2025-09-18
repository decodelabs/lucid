<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Tests;

use DecodeLabs\Lucid\Provider\MixedContext;
use DecodeLabs\Lucid\Provider\MixedContextTrait;
use DecodeLabs\Lucid\Sanitizer;

/**
 * @template TValue
 * @implements MixedContext<TValue>
 */
class AnalyzeMixedContextProvider implements MixedContext
{
    /**
     * @use MixedContextTrait<TValue>
     */
    use MixedContextTrait;

    /**
     * @var TValue
     */
    protected mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    /**
     * @return TValue
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @return array<TValue>
     */
    public function getChildValues(): array
    {
        return [$this->value];
    }

    protected function newSanitizer(mixed $value): Sanitizer
    {
        return new SanitizerImplementation($value);
    }
}


// Test passing an Exception through
$test = new AnalyzeSingleContextProvider(new \Exception('test'));
$test->sanitize();
