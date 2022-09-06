<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Processor;

use DecodeLabs\Lucid\Error;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProcessorTrait;
use Generator;

/**
 * @implements Processor<string>
 */
class StringNative implements Processor
{
    /**
     * @phpstan-use ProcessorTrait<string>
     */
    use ProcessorTrait;
    use StringTrait;
}
