<?php

class page_clusters extends Page {
	function init(){
		parent::init();

		$crud = $this->add('CRUD');
		$crud->setModel('Cluster');

		$crud->grid->addColumn('link','hosts')->setTemplate('<a href="?page=hosts&cluster_id={$id}">Hosts</a>');
		$crud->grid->addColumn('Button','configuration_files');
	}
}