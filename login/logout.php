<?php
require_once '../classes/lib/config/Configuration.class.php';

session_start();

$cfg = new Configuration();
$cfg->setConfigDir('../conf/');
$cfg->load('base.conf.php');
$val =$cfg->getValue('baseaddress');

session_destroy();
die("<script language='JavaScript'>window.location.replace('$val');</script>");  
exit();
?>