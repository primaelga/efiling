<?php

require_once '../classes/lib/config/Configuration.class.php';
require_once '../classes/data/DatabaseConnected.class.php';

$cfg = new Configuration();
$cfg->setConfigDir('../conf/');
$cfg->load('base.conf.php');
$val =$cfg->getValue('baseaddress');

if (!isset($_SERVER['HTTP_REFERER'])){ 
   // die("<script language='JavaScript'>window.location.replace('$val');</script>");  
     die("<script language='JavaScript'>window.location.replace('$val');</script>");  
}   

require_once $cfg->getValue('docroot') . 'classes/lib/function-common.inc.php';
require_once $cfg->getValue('docroot') . 'classes/proc/login/DisplayAll.class.php';


$displayer = new DisplayAll($cfg);
$displayer->display();


$sess = new SessionPHP();
$sess->startSession();
$satpam = new GateKeeper($cfg, $sess);

$response = array();

if( !function_exists('json_encode') ) {
    function json_encode($data) {
        $json = new Services_JSON();
        return( $json->encode($data) );
    }
}

?>
