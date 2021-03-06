<?php

/**
 * Config object class - singleton.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 *
 */
class CoreConfig extends stdClass {

    /**
     * Config instance.
     *
     * @var CoreConfig
     */
    private static $instance = null;

    /**
     * Subconfig data.
     *
     * @var array
     */
    private $configs = array();

    /**
     * Returns config instance.
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
     * Retrieves subconfig data.
     *
     * @param string $name
     * @return mixed
     */
    public function getConfig($name) {
        $subConfigFilename = $this->subConfigs.$name;

        if (isset($this->configs[$subConfigFilename])) {
            return $this->configs[$subConfigFilename];
        }

        if (file_exists($subConfigFilename.'.php')) {
    			    include $subConfigFilename.'.php';
    			} elseif (file_exists($subConfigFilename.'.ini')) {
    					$config = parse_ini_file($subConfigFilename.'.ini', true);
        } else {
            throw new RuntimeException("Config '{$subConfigFilename}' not found!");
    			}

        $this->configs[$subConfigFilename] = isset($config) ? $config : null;
        return $config;
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
