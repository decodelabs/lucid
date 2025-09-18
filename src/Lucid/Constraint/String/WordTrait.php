<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Lucid\Constraint\String;

trait WordTrait
{
    public function countWords(
        string $value
    ): int {
        $value = trim($value);
        $value = (string)preg_replace('/[^\w\s]+/', '', $value);
        $value = (string)preg_replace('/^([^\s])/', ' $1', $value);
        $value = (string)preg_replace('/\s+/', ' ', $value);
        return substr_count($value, ' ');
    }
}
