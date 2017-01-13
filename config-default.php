<?php
$config['url_prefix']='?page=';
$config['url_postfix']='';

// $config['locale']['date_js'] = 'dd/mm/yyyy';

// $config['js']['versions']['jqueryui']='1.11.master';

// $config['tmail']['transport'] = 'Echo';


$config['dsn']='mysql://root:@localhost/clustercontrol';

$config['cluster_events']=['host_created','host_rebooted','application_failed','node_failed','node_spawned','dependency_check','demand'];