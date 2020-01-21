<?php

namespace Prerequisiter\Checker;

class CheckerFactory
{
    private static $factoryMap = [
        'extensions' => PhpExtensionChecker::class,
        'functions' => PhpFunctionChecker::class,
        'executables' => ExecutablesChecker::class,
    ];

    static public function createChecker($type, ...$args) : CheckerInterface
    {
        if (array_key_exists($type, static::$factoryMap)) {
            $checkerClass = static::$factoryMap[$type];
        }
        elseif (class_exists($type)) {
            $checkerClass = $type;
        }
        else {
            throw new \RuntimeException('Could not create checker of type: ' . $type, 1579611335);
        }
        return new $checkerClass(...$args);
    }
}
