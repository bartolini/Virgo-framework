<?php

/**
 * Autoloader class.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 */
abstract class CoreAutoloader {

    /**
     * Registered autoloaders.
     *
     * @var array
     */
    private static $autoloaders = array();

    /**
     * Registers autoloader.
     *
     * @param CoreAutoloader $autoloader
     */
    public static function register(CoreAutoloader $autoloader) {
        self::$autoloaders[] = $autoloader;
    }

    /**
     * Returns file name for corresponding class or null otherwise.
     *
     * @param string $className
     * @return string
     */
    public static function autoload($className) {
        foreach(self::$autoloaders as $autoloader) {
            $fileName = $autoloader->getFileName($className);
            if ($fileName && file_exists($fileName)) {
                require_once($fileName);
                return;
            }
        }
        throw new CoreExceptionFramework("Class {$className} not found!");
    }

    /**
     * Returns file name for corresponding class.
     *
     * @param string $className
     */
    abstract public function getFileName($className);

}
