<?php


class Model_Cluster extends Model_MyTable{

	public $table = "cluster";
	
	function init(){
		parent::init();

		$this->addField('name');

		$this->hasMany('Host');
		$this->hasMany('ApplicationSetup');

		$this->addHook('beforeDelete',$this);

		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeDelete(){
		if($this->ref('Host')->count()->getOne()) throw $this->exception('This cluster contains host');
		if($this->ref('ApplicationSetup')->count()->getOne()) throw $this->exception('This cluster contains application setups');
	}
}