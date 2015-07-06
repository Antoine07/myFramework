<?php namespace Services\Facade;

abstract class AbstractFacade
{
    protected static $alias = ['container' => 'Services\\Container'];

    public static function __callStatic($method, ...$args)
    {

        $instance = static::resolve(static::getFacadeAccessor());

        return call_user_func([$instance, $method], $args);
    }

    public static function resolve($name)
    {

        $className = self::$alias[$name] . '\\' . ucfirst($name);

        if (!class_exists($className)) {
            throw new \RuntimeException("Class $className not found.");
        }

        return new $className;
    }

}