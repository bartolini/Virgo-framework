<?php

/**
 * Autoloader for Zend and PEAR classes.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 */
class CoreAutoloaderZend extends CoreAutoloader {

    /**
     * Returns filename for zend classes.
     *
     * @param string $className
     * @return string
     */
    public function getFileName($className) {
        $fileName = str_replace("_", "/", $className).".php";
        return CoreConfig::object()->thirdParty.$fileName;
    }

}
