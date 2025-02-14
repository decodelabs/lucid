<?php

/**
 * @package PHPStanDecodeLabs
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\PHPStan\Lucid;

use DecodeLabs\Lucid\Provider\SingleContext;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;

class SingleContextReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    use ReturnTypeTrait;

    public function getClass(): string
    {
        return SingleContext::class;
    }

    public function isMethodSupported(
        MethodReflection $methodReflection
    ): bool {
        return $methodReflection->getName() === 'as';
    }

    protected function getArgIndex(): int
    {
        return 0;
    }
}
