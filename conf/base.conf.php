<?php

	
// server information (server path and driver used for accessing database)

/*
for linux 
$cfg['docroot'] = '/apps/search/';
$cfg['basedir'] = '/search/';
$cfg['db_type'] = 'postgres8';
$cfg['baseaddress'] = 'http://127.0.0.1:8082/search/';
*/


/*
for windows
*/
$cfg['docroot'] = 'C:/xampp/htdocs/efiling/';
$cfg['basedir'] = '/efiling/';
$cfg['db_type'] = 'mysql';
//$cfg['baseaddress'] = 'http://127.0.0.1/efiling/';
$cfg['baseaddress'] = 'http://localhost/efiling';

$cfg['db_host'] = '127.0.0.1';
$cfg['db_user'] = 'root';
$cfg['db_pass'] = '';
$cfg['db_name'] = 'ereceiving';

?>
