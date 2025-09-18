<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Provider;

/**
 * @template TValue
 * @extends SingleContext<TValue>
 */
interface MixedContext extends SingleContext
{
    /**
     * Get list of interal values
     *
     * @return array<int|string,TValue|array<mixed>|null>
     */
    public function getChildValues(): array;
}
