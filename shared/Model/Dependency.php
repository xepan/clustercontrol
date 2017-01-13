<?php

class Model_Dependency extends Model_MyTable {

	public $table = "application_dependency";

	function init(){
		parent::init();

		$this->hasOne('Application'); // dependecy for
		$this->hasOne('Application','required_application_id'); // dependecy for

		// $this->addField('event')->enum($this->app->getConfig('cluster_events'));

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}