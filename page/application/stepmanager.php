<?php



class page_application_stepmanager extends Page {
	
	function page_index(){

		$application_id = $this->app->stickyGet('application_id');
		$event = $this->app->stickyGet('event');

		$model = $this->add('Model_Step');
		$model->addCondition('application_id',$application_id);
		$model->addCondition('event',$event);
		$model->addCondition('for_failed_step_id',null);

		$crud = $this->add('CRUD');
		$crud->setModel($model,null,['name']);

		if(!$crud->isEditing()){
			$crud->grid->addColumn('Expander','if_failed');
		}
	}

	function page_if_failed(){
		$step_id = $this->app->stickyGET('application_step_id');
		$application_id = $this->app->stickyGet('application_id');
		$event = $this->app->stickyGet('event');

		$model = $this->add('Model_Step');
		$model->addCondition('application_id',$application_id);
		$model->addCondition('event',$event);
		$model->addCondition('for_failed_step_id',$step_id);

		$crud = $this->add('CRUD');
		$crud->setModel($model,null,['name']);

		// if(!$crud->isEditing()){
		// 	$c= $crud->grid->addColumn('Expander','if_failed');
		// }
	}

	function render(){
		
		$this->js(true)
				->_load('ace/ace/ace')
				->_load('ace/ace/mode-php')
				->_load('ace/ace/theme-tomorrow')
				->_load('ace/jquery-ace.min')
				;
		parent::render();
	}
}