<?php
/**
  * common-function.inc.php
  * common functionality required files
  **/
 	
	require_once $cfg->getValue('docroot') . 'classes/lib/adodb/adodb.inc.php';	
	require_once $cfg->getValue('docroot') . 'classes/lib/session_handler/SessionBase.class.php';
	require_once $cfg->getValue('docroot') . 'classes/lib/session_handler/SessionPHP.class.php';
	require_once $cfg->getValue('docroot') . 'classes/lib/pat_template/pat_template.php';
	require_once $cfg->getValue('docroot') . 'classes/data/DatabaseConnected.class.php';
	require_once $cfg->getValue('docroot') . 'classes/data/Links.class.php';
	require_once $cfg->getValue('docroot') . 'classes/data/Security.class.php';
	require_once $cfg->getValue('docroot') . 'classes/data/UserIdentity.class.php';
	require_once $cfg->getValue('docroot') . 'classes/data/GateKeeper.class.php';	
	require_once $cfg->getValue('docroot') . 'classes/data/IdCreator.class.php';
	require_once $cfg->getValue('docroot') . 'classes/proc/DisplayBase.class.php';	
	require_once $cfg->getValue('docroot') . 'classes/proc/DisplayJQuery.class.php';
	/*
	require_once $cfg->getValue('docroot') . 'classes/proc/error/DisplayError.class.php';
	require_once $cfg->getValue('docroot') . 'classes/proc/error/DisplayErrorPage.class.php';
	require_once $cfg->getValue('docroot') . 'classes/proc/error/DisplayErrorInLine.class.php';	
	*/
	require_once $cfg->getValue('docroot') . 'classes/data/CreatorBase.class.php';	
	require_once $cfg->getValue('docroot') . 'classes/data/patnavbar.class.php';
	require_once $cfg->getValue('docroot') . 'classes/lib/JSON.php';
	require_once $cfg->getValue('docroot') . 'classes/lib/dateparse.inc.php';
	
?>