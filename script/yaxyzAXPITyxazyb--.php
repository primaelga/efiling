<?php

require_once '../classes/lib/config/Configuration.class.php';
$cfg = new Configuration();
$cfg->setConfigDir('../conf/');
$cfg->load('base.conf.php');
require_once $cfg->getValue('docroot').'classes/lib/function-common.inc.php';
$sec = new Security($cfg);
$sess = new SessionPHP();
$sess->startSession();

// tanpa user

	$sess->setVariable('javascript2', false);
	$docroot = $cfg->getValue('docroot');
	$jsFiles = array(						
		$docroot. 'script/ext/shared/include-ext.js',
		$docroot. 'script/ext/shared/options-toolbar.js'
	);		
	$buffer = "";
	foreach ($jsFiles as $jsFiles) {
		$buffer .= file_get_contents($jsFiles);
	}		
	$expires = 60*60*24*14;
	ob_start("ob_gzhandler");
	header("Pragma: public");
	header("Cache-Control: maxage=".$expires);
	header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
	header("Content-type:text/javascript; charset=ISO-8859-1");
	echo($buffer);
/*
Bila menggunakan login user
if(!empty($sec->mUserIdentity)){	
	if($_SESSION["javascript2"]){		
		$sess->setVariable('javascript2', false);
		$docroot = $cfg->getValue('docroot');
		$jsFiles = array(						
			$docroot. 'script/ext/shared/include-ext.js',
			$docroot. 'script/ext/shared/options-toolbar.js'
		);		
		$buffer = "";
		foreach ($jsFiles as $jsFiles) {
		  	$buffer .= file_get_contents($jsFiles);
		}		
		$expires = 60*60*24*14;
		ob_start("ob_gzhandler");
		header("Pragma: public");
		header("Cache-Control: maxage=".$expires);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
		header("Content-type:text/javascript; charset=ISO-8859-1");
		echo($buffer);
	}else
	{
		
	}
}
*/
?>
