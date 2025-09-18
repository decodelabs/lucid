<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Tests;

use DecodeLabs\Lucid\Provider\DirectContext;
use DecodeLabs\Lucid\Provider\DirectContextTrait;
use DecodeLabs\Lucid\Sanitizer;

class AnalyzeDirectContextProvider implements DirectContext
{
    use DirectContextTrait;

    protected function newSanitizer(mixed $value): Sanitizer
    {
        return new SanitizerImplementation($value);
    }
}


// Test passing an Exception through
$test = new AnalyzeDirectContextProvider();
$test->sanitize(new \Exception('test'));
