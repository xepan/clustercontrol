<?php

class Model_Host extends Model_MyTable {
	
	public $table ="host";

	function init(){
		parent::init();

		$this->hasOne('Cluster');
		$this->addField('name');
		$this->addField('service'); // service provider like DO or AWS etc
		$this->addField('raw_info')->type('text');

		$this->add('dynamic_model/Controller_AutoCreator');
	}


	function create_page($page){
		throw $this->exception('Must redefine in extended classes')
					->addMoreInfo('type',$this['type']);

	}
}