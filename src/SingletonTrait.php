<?php

namespace NewInventor\Patterns;

trait SingletonTrait
{
    protected static $instance;

    /**
     * SingletonTrait constructor.
     */
    protected function __construct()
    {
    }

    /**
     * @return static
     * @throws \Exception
     */
    public static function getInstance()
    {
        $args = func_get_args();
        if(null === self::$instance || !empty($args)){
            $calledClass = get_called_class();
            $reflection = new \ReflectionClass($calledClass);
            $instance = $reflection->newInstanceWithoutConstructor();
            $constructor = $reflection->getConstructor();
            $constructor->setAccessible(true);
            $constructor->invokeArgs($instance, $args);
            self::$instance = $instance;
        }

        return self::$instance;
    }

    /**
     * Клонирование запрещено
     */
    protected function __clone()
    {
    }

    /**
     * Сериализация запрещена
     */
    protected function __sleep()
    {
    }

    /**
     * Десериализация запрещена
     */
    protected function __wakeup()
    {
    }
}