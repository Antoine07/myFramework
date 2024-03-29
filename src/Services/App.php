<?php namespace Services;

use Services\Container\Container;

class App
{

    private static $container = null;

    public static function set(Container $c)
    {
        self::$container = $c;
    }

    public static function get()
    {
        return self::$container;
    }

}