<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Provider;

use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\Sanitizer;

/**
 * @template TValue
 * @phpstan-require-implements MixedContext<TValue>
 */
trait MixedContextTrait
{
    /**
     * @use SingleContextTrait<TValue>
     */
    use SingleContextTrait;

    public function sanitize(): Sanitizer
    {
        return $this->newSanitizer(function (
            Processor $processor
        ): mixed {
            if ($processor->isMultiValue()) {
                return $this->getChildValues();
            } else {
                return $this->getValue();
            }
        });
    }
}
