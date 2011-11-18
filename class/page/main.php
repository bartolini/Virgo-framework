<?php

/**
 * Test page.
 *
 * @author Bartlomiej Biskupek <bartlomiej.biskupek@gmail.com>
 **/
class PageMain extends CoreBlock {

	public function build() {
		$this->meta->title = 'some title';
		$this->meta->append('title', $this->parameter);
	}

}

