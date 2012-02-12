<?php

/**
 * Basic session service.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 *
 */
class CoreSession {

    /**
     * True if session has been started.
     *
     * @var boolean
     */
    private static $sessionStarted = false;

    /**
     * Start session if needed..
     */
    private static function start() {
        if (!self::$sessionStarted) {
            session_start();
            self::$sessionStarted = true;
        }
    }

    /**
     * Sets session variable.
     *
     * @param string $var
     * @param mixed $value
     */
    public static function set($var, $value) {
        self::start();
        $_SESSION[$var] = $value;
    }

    /**
     * Removes session variable.
     *
     * @param string $var
     */
    public static function delete($var) {
        self::start();
        if (isset($_SESSION[$var])) {
            unset($_SESSION[$var]);
        }
    }

    /**
     * Retrieves session variable.
     *
     * @param string $var
     * @return mixed
     */
    public static function get($var) {
        self::start();
        return isset($_SESSION[$var]) ? $_SESSION[$var] : null;
    }

    /**
     * Returns session id.
     *
     * @return string
     */
    public static function getId() {
        self::start();
        return session_id();
    }

    /**
     * No instance allowed.
     */
    private function  __construct() {
    }

    /**
     * Not clonable.
     */
    private function  __clone() {
    }
}
