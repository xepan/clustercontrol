<?php

class Model_MyTable extends SQL_Model {

	function init(){
		parent::init();

		$this->add('Controller_MyValidator');
	}

}