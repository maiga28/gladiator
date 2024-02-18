<?php

namespace Gladiator\Aficadev\Core;

class Config
{
    protected static $gladEnv = [];


    public static function loadGladEnv()
    {
        $path = __DIR__ . '/../.gladEnv';
        static::$gladEnv = parse_ini_file($path);
    }

    public static function gladEnv($key, $default = null)
    {
        if (empty(static::$gladEnv)) {
            static::loadGladEnv();
        }

        return static::$gladEnv[$key] ?? $default;
    }
}
