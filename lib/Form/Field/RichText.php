<?php


class Form_Field_RichText extends Form_Field_Text{
	public $options=array();

	function init(){
		parent::init();
	}

	function render(){
		$this->js(true)->ace(['theme' =>'tomorrow', 'lang'=>'php']);
		parent::render();
	}
}