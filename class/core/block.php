<?php

/**
 * Block abstract class.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 */
abstract class CoreBlock {

	protected $data;

	protected $template = null;

	protected $render = true;

	protected $config;

	protected $parameter;

	protected $requestExploded;

	protected $request;

	protected $meta;

	public function __construct($parameters = array()) {
		$this->config = CoreConfig::object();
		$this->meta = new CoreContainer();
		if (!empty($parameters)) {
			$this->setParameters($parameters);
		}
		if (is_null($this->template)) {
			$this->template = strtolower(preg_replace('/([a-z])([0-9]|[A-Z])/', '$1/$2', get_class($this)));
		}
		$this->setUp();
		$this->build();
		ob_start();
	}
	
	public function __destruct() {
		ob_end_flush();
	}


	public function display() {
		echo $this->render();
	}

	public function setRequest($request) {
		$requestExploded = explode("/", ltrim($request, "/"));
		$this->request = $request;
		$this->requestExploded = $requestExploded;
		$this->parameter = array_pop($requestExploded);
	}

	public function redirect($url) {
		header('Location: '.$url);
		die();
	}

	public function reload() {
		$this->redirect($this->request);
	}

	protected function addCss($fileName) {
		$this->meta->append("css", "<link href='{$fileName}' type='text/css' rel='stylesheet'>");
	}

	protected function addScript($fileName) {
		$this->meta->append("js", "<script type='text/javascript' src='{$fileName}'></script>");
	}

	protected function addBlock($field, CoreBlock $block) {
		$this->initializeField($field);
		$block->setRequest($this->request);
		$this->data[$field] .= $block->render();
	}

	protected function addTemplate($field, $templateName, $data = array()) {
		$view = CoreView::object();
		$this->initializeField($field);
		$view->assign($data);
		$this->data[$field] .= $view->fetch($templateName.'.tpl');
	}

	protected function setParameters($parameters) {
	}

	protected function setUp() {
	}

	protected function build() {
	}

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

	private function initializeField($field) {
		if (!isset($this->data[$field])) {
			$this->data[$field] = '';
		}
	}

}
