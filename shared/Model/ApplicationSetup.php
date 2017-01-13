<?php

class Model_ApplicationSetup extends Model_MyTable {

	public $table = "cluster_application_setup";

	function init(){
		parent::init();

		$this->hasOne('Cluster');
		$this->hasOne('Application');
		$this->addExpression('name')->set($this->refSQL('application_id')->fieldQuery('name'));
		$this->addField('install_on_nodes')->hint('1,2,3 or leave blank to install on all nodes/hosts');
		$this->addField('order');//->system(true);

		$this->setOrder('order','asc');
		$this->add('dynamic_model/Controller_AutoCreator');
	}
}