<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Tests;

use DecodeLabs\Lucid\Provider\DirectContext;
use DecodeLabs\Lucid\Provider\DirectContextTrait;
use Exception;

class AnalyzeDirectContextProvider implements DirectContext
{
    use DirectContextTrait;
}


// Test passing an Exception through
$test = new AnalyzeDirectContextProvider();
$test->cast(new Exception('test'), 'string');
