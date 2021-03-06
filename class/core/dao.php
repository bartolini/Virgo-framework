<?php

/**
 * Data Access Object.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 */
class CoreDao {

    /**
     * Instances.
     *
     * @var array
     */
    private static $instances = array();

    /**
     * Initialize database connection.
     *
     * @param string $connectionName
     * @return PDO
     */
    public static function connection($connectionName = "default") {
        if (!isset(self::$instances[$connectionName])) {
            try {
    							$databases = CoreConfig::object()->getConfig('databases');
    							$dbConfig = $databases[$connectionName];
                $pdo = self::$instances[$connectionName] = new PDO(
                    "{$dbConfig['dbSchema']}:dbname={$dbConfig['dbDatabase']};host={$dbConfig['dbHostname']}",
                    $dbConfig["dbUsername"],
                    $dbConfig["dbPassword"]
                );
            } catch (Exception $exception) {
                throw new RuntimeException("Database connection error!");
            }

            $pdo->query('SET NAMES utf8');
            $pdo->query('SET CHARACTER_SET utf8_unicode_ci');
        }

        return self::$instances[$connectionName];
    }

    /**
     * Private constructor.
     */
    private function  __construct() {
    }

    /**
     * No clone allowed.
     */
    private function  __clone() {
    }
}
