<?php

/**
 * @package PHPStanDecodeLabs
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\PHPStan\Lucid;

use DecodeLabs\Lucid\Provider\DirectContext;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;

class DirectContextReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    use ReturnTypeTrait;

    public function getClass(): string
    {
        return DirectContext::class;
    }

    public function isMethodSupported(
        MethodReflection $methodReflection
    ): bool {
        return $methodReflection->getName() === 'make';
    }

    protected function getArgIndex(): int
    {
        return 1;
    }
}
