<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint;

use DecodeLabs\Dictum;

trait WordsTrait
{
    protected function countWords(?string $text): int
    {
        if (
            $text === null ||
            !strlen($text)
        ) {
            return 0;
        }

        if (class_exists(Dictum::class)) {
            return Dictum::countWords($text);
        }

        $parts = explode(' ', $text);
        return count($parts);
    }
}
