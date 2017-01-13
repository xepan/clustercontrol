<?php
class Frontend extends ApiFrontend {

    function init() {
        parent::init();        
        $this->dbConnect();

        $this->api->pathfinder
            ->addLocation(array(
                'addons' => ['vendor','shared/addons'],
                'php'=>['shared']
            ))
            ->setBasePath($this->pathfinder->base_location->getPath());
        // Might come handy when multi-timezone base networks integrates
        $this->today = date('Y-m-d',strtotime($this->recall('current_date',date('Y-m-d'))));
        $this->now = date('Y-m-d H:i:s',strtotime($this->recall('current_date',date('Y-m-d H:i:s'))));

        $this->add('jUI'); 

        $m = $this->add('Menu',null,'Menu');

        // $auth = $this->add('Auth');
        // $auth->allowPage(['index','about','registration']);
        // $auth->setModel('Person','email','password');
        // $auth->addHook('createForm',function($a,$p){
        //    $p->add('View')->set('New User Registration Click Here')->addStyle('cursor','pointer')->js('click')->univ()->redirect('registration');
        // });
        // $auth->check();
        
        $m->addItem('Dashboard','index');
        $m->addItem('Clusters','clusters');
        $m->addItem('Applications','applications');
        $m->addItem('Help','help');

        // if($auth->isLoggedIn()){
        //     $m->addItem('Dashboard','dashboard');
        //     $m->addItem('Search','searchprofile');
        //     $m->addItem('Logout','logout');
        // }else{
        //     $m->addItem('Login','dashboard');
        //     $m->addItem('Register','registration');
        // }

    }
}
