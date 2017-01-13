<?php


class Model_Application extends Model_MyTable {

	public $table = "application";

	function init(){
		parent::init();

		$this->addField('name');

		// globally accepted to be used mainly for dependency manager
		$this->addField('unique_name'); 
		$this->addField('major_version');
		$this->addField('version');
		$this->addField('run_once')->type('boolean');

		$this->hasMany('Step');
		$this->hasMany('ApplicationSetup');
		$this->hasMany('Dependency');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}