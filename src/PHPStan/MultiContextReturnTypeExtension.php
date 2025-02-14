<?php

/**
 * @package PHPStanDecodeLabs
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\PHPStan\Lucid;

use DecodeLabs\Lucid\Provider\MultiContext;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;

class MultiContextReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    use ReturnTypeTrait;

    public function getClass(): string
    {
        return MultiContext::class;
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
