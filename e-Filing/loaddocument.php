<?php
require_once '../classes/lib/config/Configuration.class.php';
$cfg = new Configuration();
$cfg->setConfigDir('../conf/');
$cfg->load('base.conf.php');
require_once $cfg->getValue('docroot') . 'classes/lib/function-common.inc.php';
require_once $cfg->getValue('docroot') . 'classes/data/efiling/ViewDocumentCatalog.class.php';
require_once $cfg->getValue('docroot') . 'classes/proc/efiling/DisplayViewDocument.class.php';

	$sec = new Security($cfg);
	$displayer 	= new DisplayViewDocument($cfg);	
	$displayer->setData($_GET);
	$displayer->display();
	
?>
