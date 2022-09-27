<?php
/**
 * This is a stub file for IDE compatibility only.
 * It should not be included in your projects.
 */
namespace DecodeLabs;

use DecodeLabs\Veneer\Proxy;
use DecodeLabs\Veneer\ProxyTrait;
use DecodeLabs\Lucid\Context as Inst;
use DecodeLabs\Lucid\Sanitizer as Ref0;
use Closure as Ref1;
use DecodeLabs\Lucid\Validate\Result as Ref2;

class Lucid implements Proxy
{
    use ProxyTrait;

    const VENEER = 'DecodeLabs\Lucid';
    const VENEER_TARGET = Inst::class;

    public static Inst $instance;

    public static function newSanitizer(mixed $value): Ref0 {
        return static::$instance->newSanitizer(...func_get_args());
    }
    public static function make(mixed $value, string $type, Ref1|array|null $setup = NULL): mixed {
        return static::$instance->make(...func_get_args());
    }
    public static function validate(mixed $value, string $type, Ref1|array|null $setup = NULL): Ref2 {
        return static::$instance->validate(...func_get_args());
    }
    public static function is(mixed $value, string $type, Ref1|array|null $setup = NULL): bool {
        return static::$instance->is(...func_get_args());
    }
    public static function sanitize(mixed $value): Ref0 {
        return static::$instance->sanitize(...func_get_args());
    }
};
