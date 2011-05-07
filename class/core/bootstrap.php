<?php

/**
 * Application bootstrap abstract class.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 * 
 */
abstract class CoreBootstrap {

    /**
     * Only one instance allowed.
     *
     * @var boolean
     */
    private static $created = false;

    /**
     * Bootstrap constructor.
     */
    public function  __construct() {
        if (self::$created) {
            throw new CoreExceptionFramework("Application has been initialized already!");
        }
        self::$created = true;
        $reflection = new ReflectionObject($this);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PROTECTED);
        array_filter(
            $methods, 
            function($method) {
                return (bool)preg_match("/^init/", $method->getName());
            }
        );
        foreach($methods as $method) {
            call_user_func(array($this, $method->getName()));
        }
    }

    /**
     * Not clonable.
     */
    private function  __clone() {
    }

}
