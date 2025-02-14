<?php

/**
 * @package PHPStanDecodeLabs
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\PHPStan\Lucid;

use DecodeLabs\Coercion;
use DecodeLabs\Lucid\Processor\ListNative as ListProcessor;
use DecodeLabs\Lucid\Sanitizer\ValueContainer;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;

trait ReturnTypeTrait
{
    protected ReflectionProvider $reflectionProvider;

    public function __construct(
        ReflectionProvider $reflectionProvider
    ) {
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): ?Type {
        return $this->getType($methodCall);
    }

    public function getTypeFromStaticMethodCall(
        MethodReflection $methodReflection,
        StaticCall $methodCall,
        Scope $scope
    ): ?Type {
        return $this->getType($methodCall);
    }

    protected function getType(
        MethodCall|StaticCall $methodCall
    ): Type {
        $type = Coercion::toString(
            /** @phpstan-ignore-next-line */
            $methodCall->getArgs()[$this->getArgIndex()]->value->value
        );

        $nullable = substr($type, 0, 1) === '?';
        $processor = (new ValueContainer('test'))->loadProcessor($type);
        $listProc = null;

        if (
            $processor instanceof ListProcessor &&
            null !== ($inner = $processor->getChildType())
        ) {
            $listProc = $processor;
            $processor = $inner;
        }

        $method = $this->reflectionProvider->getClass(
            get_class($processor)
        )->getNativeMethod('coerce');

        $output = $method->getVariants()[0]->getReturnType();

        if (
            !$nullable &&
            $output instanceof UnionType
        ) {
            $types = $output->getTypes();

            foreach ($types as $i => $type) {
                if ($type->isNull()->yes()) {
                    unset($types[$i]);
                }
            }

            if (count($types) === 1) {
                $output = array_shift($types);
            } else {
                $output = new UnionType($types);
            }
        }

        // List type
        if ($listProc) {
            $output = new ArrayType(
                new MixedType(),
                $output
            );
        }

        return $output;
    }

    abstract protected function getArgIndex(): int;

    /*
    protected function debug(mixed $var): void
    {
        \DecodeLabs\Atlas::createFile(__DIR__.'/log', print_r($var, true));
    }
    */
}
