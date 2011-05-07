<?php

// Loads Smarty:
require_once CoreConfig::object()->thirdParty."Smarty/libs/Smarty.class.php";

/**
 * Smarty view - singleton object.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 *
 */
class CoreView {

    /**
     * Smarty original class instance.
     *
     * @var Smarty
     */
    private static $instance = null;

    /**
     * Returns view instance.
     *
     * @return CoreView
     */
    public static function object() {
        if (is_null(self::$instance)) {
            $config = CoreConfig::object();
            $smarty = new Smarty();
            $smarty->template_dir   = $config->templates;
            $smarty->config_dir     = $config->thirdParty."Smarty/configs/";
            $smarty->compile_dir    = $config->thirdParty."Smarty/templates_c";
            $smarty->cache_dir      = $config->thirdParty."Smarty/cache";
            $smarty->caching        = 0;
            $smarty->compile_check  = true;
            if (!$config->debug) {
                $smarty->load_filter("output", "trimwhitespace");
                $smarty->compile_check = false;
            }
            self::$instance = $smarty;
        } else {
            self::$instance->clear_all_assign();
        }
        return self::$instance;
    }

    /**
     * Private constructor.
     */
    private function  __construct() {}

    /**
     * No clone allowed.
     */
    private function  __clone() {}
}
