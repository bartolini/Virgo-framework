<?php

/**
 * Application url mapper class.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 *
 */
final class CoreUrlMapper {

    /**
     * Url containers.
     *
     * @var array
     */
    private $urlTemplates = array();

    /**
     * Instance.
     *
     * @var CoreConfig
     */
    private static $instance = null;

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
     * Registers url template.
     *
     * @param string $name
     * @param CoreUrlTemplate $template
     */
    public function register($name, CoreUrlTemplate $template) {
        $this->urlTemplates[$name] = $template;
    }

    /**
     * Returns generated url from template.
     *
     * @param string $name
     * @param array $parameters
     * @return string
     */
    public function getUrl($name, $parameters = array()) {
        if (!isset ($this->urlTemplates[$name])) {
            throw new RuntimeException("No url template defined.");
        }
        return $this->urlTemplates[$name]->getUrl($parameters);
    }

    /**
     * Private constructor.
     */
    private function  __clone() {
    }

    /**
     * Not clonable.
     */
    private function  __construct() {
    }

}
