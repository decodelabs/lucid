<?php

/**
 * @package PHPStanDecodeLabs
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\PHPStan\Lucid;

use DecodeLabs\Lucid;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicStaticMethodReturnTypeExtension;

class VeneerReturnTypeExtension implements DynamicStaticMethodReturnTypeExtension
{
    use ReturnTypeTrait;

    public function getClass(): string
    {
        return Lucid::class;
    }

    public function isStaticMethodSupported(
        MethodReflection $methodReflection
    ): bool {
        return $methodReflection->getName() === 'make';
    }

    protected function getArgIndex(): int
    {
        return 1;
    }
}
