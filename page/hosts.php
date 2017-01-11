<?php

class page_hosts extends Page {

	function page_index(){

		$cluster_id = $this->app->stickyGET('cluster_id');

		$bs =$this->add('ButtonSet');
		$bs->addButton('Add DigitalOcean Host')->js('click')->univ()->frameURL('ADD HOST',$this->app->url('./addhost',['service'=>"DO",'cluster_id'=>$cluster_id]));
		$bs->addButton('Add AWS Host')->js('click')->univ()->frameURL('ADD HOST',$this->app->url('./addhost',['service'=>"AWS",'cluster_id'=>$cluster_id]));

		$hosts = $this->add('Model_Host');
		$hosts->addCondition('cluster_id',$cluster_id);

		$crud = $this->add('CRUD',['allow_add'=>false]);
		$crud->setModel($hosts);
	}


	function page_addhost(){
		$service = $this->app->stickyGET('service');
		$cluster_id = $this->app->stickyGET('cluster_id');

		try{
			$host = $this->add('Model_Host_'.$service);
		}catch(Exception $e){
			$this->add('View_Error')->set($service.' is not implemented yet');
			return;
		}

		$host->create_page($this, $cluster_id);

	}
}