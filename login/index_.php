<?php
	
require_once '../classes/lib/config/Configuration.class.php';
$cfg = new Configuration();
$cfg->setConfigDir('../conf/');
$cfg->load('base.conf.php');

require_once $cfg->getValue('docroot') . 'classes/lib/function-common.inc.php';
require_once $cfg->getValue('docroot') . 'classes/proc/login/DisplayAll.class.php';

$displayer = new DisplayAll($cfg);
$displayer->display();
?>
