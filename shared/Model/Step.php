<?php

class Model_Step extends Model_MyTable {

	public $table = "application_step";

	function init(){
		parent::init();

		$this->hasOne('Application');
		$this->hasOne('Step','for_failed_step_id')->system(true);
		$this->addField('name');
		$this->addField('command')->type('text')->display(['form'=>'RichText']);
		$this->addField('success_check')->type('text')->display(['form'=>'RichText']);

		$this->hasMany('FollowedSteps');
		$this->addField('event')->system(true);
		$this->addField('order')->system(true);

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}