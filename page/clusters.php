<?php

class page_clusters extends Page {
	function page_index(){
		// parent::init();

		$crud = $this->add('CRUD');
		$crud->setModel('Cluster');

		$crud->grid->addColumn('Expander','hosts');
		$crud->grid->addColumn('Button','application_manager');
	}

	function page_hosts(){

		$cluster_id = $this->app->stickyGET('cluster_id');

		$bs =$this->add('ButtonSet');
		$bs->addButton('Add DigitalOcean Host')->js('click')->univ()->frameURL('ADD HOST',$this->app->url('./addhost',['service'=>"DO",'cluster_id'=>$cluster_id]));
		$bs->addButton('Add AWS Host')->js('click')->univ()->frameURL('ADD HOST',$this->app->url('./addhost',['service'=>"AWS",'cluster_id'=>$cluster_id]));

		$hosts = $this->add('Model_Host');
		$hosts->addCondition('cluster_id',$cluster_id);

		$crud = $this->add('CRUD',['allow_add'=>false]);
		$crud->setModel($hosts,['name','host_name','ip']);
	}

	function page_hosts_addhost(){
		$service = $this->app->stickyGET('service');
		$cluster_id = $this->app->stickyGET('cluster_id');

		try{
			$host = $this->add('Model_Host_'.$service);
		}catch(Exception_PathFinder $e){
			$this->add('View_Error')->set($service.' is not implemented yet');
			return;
		}

		$host->create_page($this, $cluster_id);

	}
}