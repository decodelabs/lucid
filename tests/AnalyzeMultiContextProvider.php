<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Tests;

use DecodeLabs\Lucid\Provider\MultiContext;
use DecodeLabs\Lucid\Provider\MultiContextTrait;
use Exception;

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
}


// Test passing an Exception through
$test = new AnalyzeMultiContextProvider('value', new Exception('test'));
$test->cast('value', 'string');
