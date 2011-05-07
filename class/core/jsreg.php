<?php

/**
 * Javascript register helper class - singleton.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 * 
 */
class CoreJsreg extends stdClass {

    /**
     * Config instance.
     *
     * @var CoreJsreg 
     */
    private static $instance = null;

    /**
     * Returns instance.
     *
     * @return CoreConfig
     */
    public static function object() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Builds json object.
     *
     * @return string
     */
    public function buildJs() {
        return "var jsReg = ".json_encode($this).";";
    }

    /**
     * Not clonable.
     */
    private function  __clone() {
    }

    /**
     * Private constructor.
     */
    private function  __construct() {
    }

}
