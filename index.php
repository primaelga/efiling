<?php


require_once 'classes/lib/config/Configuration.class.php';
//require_once 'login/auth/login.php';
$cfg = new Configuration();
$cfg->setConfigDir('conf/');
$cfg->load('base.conf.php');


require_once $cfg->getValue('docroot').'classes/lib/function-common.inc.php';
$sec = new Security($cfg);
$sess = new SessionPHP();
$sess->startSession();

if(!empty($sec->mUserIdentity) && isset($_SESSION['login_user'])){

	$sess->setVariable('css', true);
	$sess->setVariable('css2', true);
	$sess->setVariable('css3', true);
	$sess->setVariable('javascript', true);
	$sess->setVariable('javascript2', true);
	$sess->setVariable('javascript3', true);
	$sess->setVariable('javascript4', true);
	$sess->setVariable('javascript5', true);
	$sess->setVariable('javascript6', true);
	require_once $cfg->getValue('docroot').'classes/proc/DisplayAll.class.php';
	$displayer = new DisplayAll($cfg);
	$displayer->display();
}
else{	
	//die("<script language='JavaScript'>window.location.replace('./e-Filing/index.php?theme=neptune');</script>");
        die("<script language='JavaScript'>window.location.replace('./login/index.php');</script>");
}

?>
