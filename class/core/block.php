<?php

/**
 * Block abstract class.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 */
abstract class CoreBlock {

	/**
	 * Template data.
	 * 
	 * @var array
	 */
	protected $data;

	/**
	 * Template name.
	 * 
	 * @var string
	 */
	protected $template = null;

	/**
	 * Render flag.
	 * 
	 * @var boolean
	 */
	protected $render = true;

	/**
	 * Config object.
	 * 
	 * @var CoreConfig
	 */
	protected $config;

	/**
	 * Request parameter.
	 * 
	 * @var string
	 */
	protected $parameter;

	/**
	 * Exploded request.
	 * 
	 * @var array
	 */
	protected $requestExploded;

	/**
	 * Original request. 
	 * 
	 * @var string
	 */
	protected $request;

	/**
	 * Block meta data, contains:
	 * - javascript
	 * - css
	 * - metatags (title, description, keywords).
	 * Important for top level blocks only.
	 * 
	 * @var string
	 */
	protected $meta;

	/**
	 * Top level block reference or null if top level block.
	 * 
	 * @var CoreBlock
	 */
	protected $topLevelBlock = null;

	/**
	 * Parent block reference or null if top level block.
	 * 
	 * @var CoreBlock
	 */
	protected $parentBlock = null;

	/**
	 * Block constructor.
	 * 
	 * @param mixed $parameter = null
	 */
	public function __construct($parameter = null) {
		$this->config = CoreConfig::object();
		$this->meta = new CoreContainer();
		if (!is_null($parameter)) {
			$this->setParameter($parameter);
		}
		if (is_null($this->template)) {
			$this->template = strtolower(preg_replace('/([a-z])([0-9]|[A-Z])/', '$1/$2', get_class($this)));
		}
		$this->setUp();
		ob_start();
	}
	
	/**
	 * Block destructor.
	 */
	public function __destruct() {
		ob_end_flush();
	}

	/**
	 * Displays block.
	 */
	public function display() {
		echo $this->render();
	}

	/**
	 * Sets up request for block.
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
	 * Main block method.
	 */
	public function build() {
	}

	/**
	 * Redirects to given url.
	 * 
	 * @param string $url 
	 */
	public function redirect($url) {
		header('Location: '.$url);
		die();
	}

	/**
	 * Reloads current url.
	 */
	public function reload() {
		$this->redirect($this->request);
	}

	/**
	 * Adds CSS file to block meta.
	 * 
	 * @param string $fileName 
	 */
	protected function addCss($fileName) {
		$this->meta->append("css", "<link href='{$fileName}' type='text/css' rel='stylesheet'>", true);
	}

	/**
	 * Adds Javascript file to block meta.
	 * 
	 * @param string $fileName 
	 */
	protected function addScript($fileName) {
		$this->meta->append("js", "<script type='text/javascript' src='{$fileName}'></script>", true);
	}

	/**
	 * Adds block to given block's template field.
	 * 
	 * @param string $field 
	 * @param CoreBlock $block 
	 */
	protected function addBlock($field, CoreBlock $block) {
		$this->initializeField($field);
		$block->setTopLevelBlock($this->topLevelBlock ?: $this);
		$block->setParentBlock($this);
		$block->setRequest($this->request);
		$block->build();
		$this->data[$field] .= $block->render();
	}

	/**
	 * Renders given template into block's template field.
	 * 
	 * @param string $field 
	 * @param string $templateName 
	 * @param array $data 
	 */
	protected function addTemplate($field, $templateName, $data = array()) {
		$this->initializeField($field);
		$this->data[$field] .= $this->renderTemplate($templateName, $data);
	}

	/**
	 * Renders a template.
	 * 
	 * @param string $templateName 
	 * @param array $data 
	 * @return string
	 */
	protected function renderTemplate($templateName, $data = array()) {
		$view = CoreView::object();
		$view->assign($data);
		return $view->fetch($templateName.'.tpl');
	}

	/**
	 * Sets top level block.
	 * 
	 * @param CoreBlock $block 
	 */
	protected function setTopLevelBlock(CoreBlock $block) {
		$this->topLevelBlock = $block;
	}

	/**
	 * Sets parent block.
	 * 
	 * @param CoreBlock $block 
	 */
	protected function setParentBlock(CoreBlock $block) {
		$this->parentBlock = $block;
	}

	/**
	 * Sets extra parameter for block.
	 * Called from constructor only if parameter given.
	 * 
	 * @param mixed $parameter 
	 */
	protected function setParameter($parameter) {
	}

	/**
	 * Block's set up method.
	 * Called from constructor.
	 */
	protected function setUp() {
	}

	/**
	 * Renders block.
	 * 
	 * @return string
	 */
	protected function render() {
		if ($this->render) {
			$view = CoreView::object();
			$view->assign($this->data);
			$view->assign('meta', $this->meta);
			return $view->fetch($this->template.'.tpl');
		} else {
			return null;
		}
	}

	/**
	 * Block template field initialization if needed.
	 * 
	 * @param string $field 
	 */
	private function initializeField($field) {
		if (!isset($this->data[$field])) {
			$this->data[$field] = '';
		}
	}
}
