<?php


class Model_Cluster extends Model_MyTable{

	public $table = "cluster";
	
	function init(){
		parent::init();

		$this->addField('name');

		$this->hasMany('Host');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}