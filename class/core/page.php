<?php

/**
 * Page abstract class
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 *
 */
abstract class CorePage {

    /**
     * Page modules list.
     *
     * @var array
     */
    private $modules = array();

    /**
     * Site config object.
     *
     * @var CoreConfig
     */
    protected $config;

    /**
     * Page data for page template.
     *
     * @var array
     */
    protected $data = array();

    /**
     * Page template.
     *
     * @var string
     */
    protected $template;

    /**
     * Page meta container.
     *
     * @var CoreContainer
     */
    public $meta;

    /**
     * Page parameter.
     *
     * @var string
     */
    public $parameter;

    /**
     * Page request exploded.
     *
     * @var string
     */
    public $requestExploded;

    /**
     * Page request.
     *
     * @var string
     */
    public $request;

    /**
     * Page constructor.
     *
     */
    public function __construct() {
        $this->config = CoreConfig::object();
        $this->meta = new CoreContainer();
        $this->setUp();
        ob_start();
    }

    /**
     * Sets processed request data.
     *
     * @param string $request
     */
    public function setRequest($request) {
        $requestExploded = explode("/", ltrim($request, "/"));
        $this->request = $request;
        $this->requestExploded = $requestExploded;
        $this->parameter = array_pop($requestExploded);
    }

    /**
     * Page destructor.
     */
    public function __destruct() {
        ob_end_flush();
    }

    /**
     * Setting up page modules & init - abstract method.
     */
    abstract protected function setUp();

    /**
     * Adds module to page.
     *
     * @param string $field
     * @param CoreModule $module
     */
    protected function addModule($field, CoreModule $module) {
        if (empty($this->modules[$field])) {
            $this->modules[$field] = array();
        }
        $this->modules[$field][] = $module;
        $module->setPage($this);
    }

    /**
     * Renders page modules and then whole page.
     */
    public function render() {
        $page = array();

        // modules execution
        foreach($this->modules as $field => $modules) {
            foreach($modules as $module) {
                if (!isset($page[$field])) {
                    $page[$field] = "";
                }
                $module->build();
                $page[$field] .= $module->render();
            }
        }

        // page rendering
        $view = CoreView::object();
        $view->assign($page);
        $view->assign($this->data);
        $view->assign("meta", $this->meta);
        $view->display("page/{$this->template}.tpl");
    }

    /**
     * Adds css file to page head section.
     *
     * @param string $fileName
     */
    public function addCss($fileName) {
        $this->meta->append("css", "<link href=\"{$fileName}\" type=\"text/css\" rel=\"stylesheet\">");
    }
    
    /**
     * Adds javascript file to page head section.
     *
     * @param string $fileName
     */
    public function addScript($fileName) {
        $this->meta->append("js", "<script type=\"text/javascript\" src=\"{$fileName}\"></script>");
    }

}
