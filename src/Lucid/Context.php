<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid;

use DecodeLabs\Lucid\Sanitizer\DirectContextProvider;
use DecodeLabs\Lucid\Sanitizer\DirectContextProviderTrait;

/**
 * @template TValue
 * @implements DirectContextProvider<TValue>
 */
class Context implements DirectContextProvider
{
    /**
     * @use DirectContextProviderTrait<TValue>
     */
    use DirectContextProviderTrait;
}
