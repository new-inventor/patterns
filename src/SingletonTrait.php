<?php

namespace NewInventor\Singleton;

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
     * @param string $initMethodName
     * @return static
     * @throws \Exception
     */
    public static function getInstance($initMethodName = '__construct')
    {
        if(!is_string($initMethodName)){
            throw new \Exception('Parameter "initMethodName" should be a string.');
        }

        if(null === self::$instance){
            $args = func_get_args();
            array_shift($args);
            $calledClass = get_called_class();
            $reflection = new \ReflectionClass($calledClass);
            $instance = $reflection->newInstanceWithoutConstructor();
            self::getMethod($reflection, $initMethodName)->invokeArgs($instance, $args);
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @param \ReflectionClass $reflection
     * @param string $methodName
     * @return \ReflectionMethod
     * @throws \Exception
     */
    protected static function getMethod(\ReflectionClass $reflection, $methodName = '__construct')
    {
        if($reflection->hasMethod($methodName)){
            $method = $reflection->getMethod($methodName);
            $method->setAccessible(true);

            return $method;
        }else{
            throw new \Exception('Method "' . $methodName . '" does not exists in class "' . $reflection->getName() . '".');
        }
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