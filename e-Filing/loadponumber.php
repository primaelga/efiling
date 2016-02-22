<?php
require_once '../classes/lib/config/Configuration.class.php';
$cfg = new Configuration();
$cfg->setConfigDir('../conf/');
$cfg->load('base.conf.php');
require_once $cfg->getValue('docroot') . 'classes/lib/function-common.inc.php';
require_once $cfg->getValue('docroot') . 'classes/data/efiling/ViewPoNumberCatalog.class.php';
require_once $cfg->getValue('docroot') . 'classes/proc/efiling/DisplayViewPoNumber.class.php';

	$sec = new Security($cfg);
	$displayer 	= new DisplayViewPoNumber($cfg);	
	$displayer->setData($_GET);
	$displayer->display();
	
?>
