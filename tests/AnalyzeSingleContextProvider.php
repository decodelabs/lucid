<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Tests;

use DecodeLabs\Lucid\Provider\SingleContext;
use DecodeLabs\Lucid\Provider\SingleContextTrait;
use Exception;

/**
 * @template TValue
 * @implements SingleContext<TValue>
 */
class AnalyzeSingleContextProvider implements SingleContext
{
    /**
     * @use SingleContextTrait<TValue>
     */
    use SingleContextTrait;

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
}


// Test passing an Exception through
$test = new AnalyzeSingleContextProvider(new Exception('test'));
$test->as('string');
