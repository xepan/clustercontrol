<?php

// https://packagist.org/packages/toin0u/digitalocean-v2

use DigitalOceanV2\Adapter\BuzzAdapter;
use DigitalOceanV2\DigitalOceanV2;

class Model_Host_DO extends Model_Host {
	function init(){
		parent::init();

		$this->addCondition('service','DO');
	}

	function create_page ($page, $cluster_id){

		if(!$this->app->stickyGET('access_token')){
			$form = $page->add('Form');
			$form->addField('access_token')
				->setFieldHint('Generate at https://cloud.digitalocean.com/settings/applications')
				->set($this->app->getConfig('do_access_token'));

			$form->addSubmit('Proceed');
			
			if($form->isSubmitted()){
				$adapter = new BuzzAdapter($form['access_token']);
				$digitalocean = new DigitalOceanV2($adapter);
				try{
					$account = $digitalocean->account();
					$userInformation = $account->getUserInformation();
				}catch(\DigitalOceanV2\Exception\HttpException $e){
					$form->displayError('access_token',$e->getMessage());
				}
				$page->js()->reload(['access_token'=>$form['access_token']])->execute();
			}
			return;
		}

		$adapter = new BuzzAdapter($_GET['access_token']);
		$digitalocean = new DigitalOceanV2($adapter);

		$region = $digitalocean->region();
		$regions = $region->getAll();
		$region_arr = [];
		foreach ($regions as $r) {
			$region_arr[$r->slug] = $r->name;
		}

		$size = $digitalocean->size();
		$sizes = $size->getAll();
		$size_arr = [];
		foreach ($sizes as $s) {
			$size_arr[$s->slug] = strtoupper($s->slug);
		}
		

		$image = $digitalocean->image();
		$images = $image->getAll();
		$image_arr = [];
		foreach ($images as $i) {
			if(!$i->slug) continue;
			$image_arr[$i->slug] = $i->distribution. ' ('.$i->name.')';
		}


		$form = $page->add('Form');
		$form->addField('name');
		$form->addField('host_name');
		$form->addField('DropDown','region')->setValueList($region_arr);
		$form->addField('DropDown','size')->setValueList($size_arr);
		$form->addField('DropDown','image')->setValueList($image_arr);
		$form->addField('Checkbox','backup');
		$form->addField('Checkbox','ipv6');
		$form->addField('Checkbox','enable_privateNetworking');

		$form->add('View')->set('SSH Keys');

		$key = $digitalocean->key();
		$keys = $key->getAll();
		foreach ($keys as $k) {
			$form->addField('Checkbox','ssh_keys_'.$k->id,$k->name);
		}
		$form->addField('hidden','access_token')->set($_GET['access_token']);

		$form->addSubmit('Create Host');

		if($form->isSubmitted()){
			$droplet = $digitalocean->droplet();
			$ssh_keys=[];
			foreach ($keys as $k) {
				if($form['ssh_keys_'.$k->id]) $ssh_keys[] = $k->id;
			}
			$created = $droplet->create($form['host_name'], $form['region'], $form['size'], $form['image'],$form['backup'],$form['ipv6'],$form['enable_privateNetworking'],$ssh_keys);
			$response=$created;
			$i=0;
			while($response->status != 'active'){
				$response  = $droplet->getById($created->id);
				sleep(3);
				$i++;
				if($i>10) break; // max tries
			}

			$this['name'] = $form['name'];
			$this['raw_info'] = json_encode($response);
			$this['cluster_id'] = $cluster_id;
			$this['ip'] = $this->getIP();
			$this->save();
			$page->js(null,$page->js()->reload())->univ()->closeDialog()->execute();
		}
	}


	function getIP(){
		$info =  json_decode($this['raw_info']);
		return $info->networks[0]->ipAddress;
	}
}