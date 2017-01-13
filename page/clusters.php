<?php

class page_clusters extends Page {
	function page_index(){
		// parent::init();

		$crud = $this->add('CRUD');
		$crud->setModel('Cluster');

		$crud->grid->addColumn('Expander','hosts');
		$crud->grid->addColumn('Expander','application_setup');
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

	function page_application_setup(){
		$cluster_id = $this->app->stickyGET('cluster_id');
		$application_setup_model = $this->add('Model_ApplicationSetup')->addCondition('cluster_id',$cluster_id);
		$crud = $this->add('CRUD');
		$crud->setModel($application_setup_model,['application_id','install_on_nodes'],['order','application','install_on_nodes']);

		if(!$crud->isEditing()){
			$crud->grid->addColumn('template','install_order')
				->setTemplate('<div class="do-up" data-id="{$id}">up</div><div class="do-down" data-id="{$id}">Down</div>');

			$crud->grid->on('click','.do-up',function($js,$data)use($crud){
				$m=$this->add('Model_ApplicationSetup')
					->load($data['id']);
				$m['order'] = $m['order'] + 1 ;
				$m->save();
				unset($this->app->sticky_get_arguments[$crud->grid->name.'_virtualpage']);
				return $crud->grid->js()->reload();
			});

			$crud->grid->on('click','.do-down',function($js,$data)use($crud){
				$m=$this->add('Model_ApplicationSetup')
					->load($data['id']);
				$m['order'] = $m['order'] - 1;
				$m->save();
				unset($this->app->sticky_get_arguments[$crud->grid->name.'_virtualpage_2']);
				return $crud->grid->js()->reload();
			});
			
		}
		
	}
}