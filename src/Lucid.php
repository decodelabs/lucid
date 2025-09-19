<?php

/**
 * @package Lucid
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs;

use Closure;
use DecodeLabs\Kingdom\Service;
use DecodeLabs\Kingdom\ServiceTrait;
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\Processor\ArrayNative;
use DecodeLabs\Lucid\Provider\DirectContext;
use DecodeLabs\Lucid\Provider\DirectContextTrait;

/**
 * @template TValue
 */
class Lucid implements DirectContext, Service
{
    use DirectContextTrait;
    use ServiceTrait;

    /**
     * @param array<string,mixed>|Closure|null $setup
     * @return Processor<mixed>
     */
    public static function loadProcessor(
        string $type,
        array|Closure|null $setup = null
    ): Processor {
        $required = true;

        // Optional
        if (substr($type, 0, 1) === '?') {
            $type = substr($type, 1);
            $required = false;
        }

        $params = [];

        // Instance
        if (substr($type, 0, 1) === ':') {
            $params['type'] = substr($type, 1);
            $type = 'Instance';
        }

        // List
        $list = false;

        if (substr($type, -2) === '[]') {
            $list = true;
            $type = substr($type, 0, -2);
        } elseif (preg_match('/array<([a-zA-Z0-9_]+)>/', $type, $matches)) {
            $list = true;
            $type = $matches[1];
        }

        $type = ucfirst($type);

        switch ($type) {
            case 'Bool':
            case 'Int':
            case 'Float':
            case 'String':
            case 'Array':
            case 'Object':
            case 'Null':
            case 'Resource':
                $type .= 'Native';
                break;
        }

        $slingshot = new Slingshot();

        $processor = $slingshot->resolveNamedInstance(Processor::class, $type);

        if ($list) {
            $prev = $processor;
            $processor = new ArrayNative();
            $processor->setChildType($prev);
        }

        $processor->test('required', $required);

        foreach ($processor->getDefaultConstraints() as $key => $value) {
            $processor->test($key, $value);
        }

        if ($setup instanceof Closure) {
            $setup->call($processor);
        } elseif (is_array($setup)) {
            foreach ($setup as $key => $value) {
                $processor->test($key, $value);
            }
        }

        $processor->prepareConstraints();
        return $processor;
    }
}
