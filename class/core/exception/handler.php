<?php

/**
 * Exception handler.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 */
class CoreExceptionHandler {

    /**
     * Uncaught exception handler.
     *
     * @param Exception $exception
     */
    public static function handleException($exception) {
        header("HTTP/1.0 500 Internal Server Error");
        if (CoreConfig::object()->debug) {
            echo "<pre>";
            echo "Dude, WTF?! Uncaught exception appeared!\n";
            echo "Info: {$exception->getMessage()}\n";
            echo "File: {$exception->getFile()}\n";
            echo "Backtrace: \n";
            echo $exception->getTraceAsString();
            echo "</pre>";
        } else {
            die("Internal error occured. Group of trained monkeys is already trying to solve the issue. Please try again within few minutes.");
        }
    }

}
