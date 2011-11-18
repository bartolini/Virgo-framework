<?php

/**
 * Test page.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 **/
class PageMain extends CoreBlock {

	public function build() {
		$this->meta->title = 'some title';
		$this->meta->keywords = 'some keywords';
		$this->meta->description = 'some description';

		$this->addScript('jquery-1.7.min.js');

		$this->addCss('reset.css');
		$this->addCss('styles.css');
	}

}

