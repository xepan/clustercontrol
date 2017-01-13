<?php


class page_applications extends Page {

	public $title = "Applications and related processes";

	function page_index(){
		$crud = $this->add('CRUD');
		$crud->setModel('Application');
		$crud->grid->addColumn('Expander','manage');
	}

	function page_manage(){
		$application_id = $this->api->stickyGET('application_id');

		$pre_run_btn = $this->add('View')->add('Button')->set('Add Dependency');
		$pre_run_btn->js('click')->univ()->frameURL('Add Dependency',$this->app->url('./dependency',['application_id'=>$application_id]));

		$bs = $this->add('ButtonSet');
		foreach ($this->app->getConfig('cluster_events') as $event) {
			$b = $bs->addButton('On '.ucwords(str_replace("_", " ", $event)));
			$b->js('click')->univ()->redirect($this->app->url('application_stepmanager',['application_id'=>$application_id,'event'=>$event]));
		}
	}

	function page_manage_dependency(){
		$application_id = $this->app->stickyGet('application_id');

		$model = $this->add('Model_Dependency');
		$model->addCondition('application_id',$application_id);

		$crud = $this->add('CRUD');
		$crud->setModel($model);
	}
}