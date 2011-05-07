<?php

/**
 * Module abstract class.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 * 
 */
abstract class CoreModule {

    /**
     * Data passed to template.
     *
     * @var array
     */
    protected $data = array();

    /**
     * Page object.
     *
     * @var CorePage
     */
    protected $page;

    /**
     * Site config object.
     *
     * @var CoreConfig
     */
    protected $config;

    /**
     * Module template name.
     *
     * @var string
     */
    protected $template = null;

    /**
     * Says if render the module or not.
     *
     * @var boolean
     */
    protected $render = true;

    /**
     * Module constructor object - initialization.
     */
    public function __construct() {
        $this->config = CoreConfig::object();
        // if there's no template set use default one:
        if (is_null($this->template)) {
            $template = strtolower(
                preg_replace(
                    '/([a-z])([0-9]|[A-Z])/',
                    '$1/$2',
                    get_class($this)
                )
            );
            $template = str_replace("module/", "", $template);
            $this->template = $template;
        }
    }

    /**
     * Module build method (empty by default).
     */
    public function build() {
    }

    /**
     * Module rendering.
     *
     * @return string
     */
    public function render() {
        if (!$this->render) {
            return "";
        }
        $view = CoreView::object();
        $view->assign($this->data);
        return $view->fetch("module/{$this->template}.tpl");
    }

    /**
     * Sets module page object (module owner).
     * Allows module to:
     * - access http request
     * - add css & javascript files
     * if needed.
     *
     * @param CorePage $page
     */
    public function setPage(CorePage $page) {
        $this->page = $page;
    }

}
