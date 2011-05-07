<?php

/**
 * Default class autoloader.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 */
class CoreAutoloaderDefault extends CoreAutoloader {
    
    /**
     * Returns filename.
     *
     * @param string $className
     * @return string
     */
    public function getFileName($className) {
        $fileName = FRAME_PATH."/class/";
        $fileName .= preg_replace('/([a-z])([0-9]|[A-Z])/', '$1/$2', $className);
        $fileName = strtolower($fileName).".php";
        return $fileName;
    }

}

