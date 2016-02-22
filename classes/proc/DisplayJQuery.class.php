<?php
/**
  * DisplayJQuery
  *
  * @package Display
  * @author   
  * @version 1.0
  * @access public
  */

class DisplayJQuery extends DisplayBase
{
	var $mUserRole;
	var $mUserIdentity;
	var $mAjax;
	
  /**
	* DisplayJQuery::DisplayJQuery
	* DisplayJQuery constructor
	*
	* @param object $config_object  configuration object (must exist)
	* @return
	*/
	function DisplayJQuery(&$config_object)
	{
		// call parent constructor
		DisplayBase::DisplayBase($config_object);
		
		// create new object for ajax framework
		if ($this->mAjax) $mXajax = new xajax();						
						
		// prepare config base dir value in the template
		$this->mTemplate->addGlobalVar("CONFIG_BASEDIR",$this->mrConfig->GetValue('basedir'));
		
		// prepare config base address value in the template
		$this->mTemplate->addGlobalVar("BASE_ADDRESS",$this->mrConfig->GetValue('baseaddress'));
		
		// prepare config base dir for rtmp value in the template
		$this->mTemplate->addGlobalVar("RTMP",$this->mrConfig->GetValue('rtmp'));

		// writedown ajax framework
		if ($this->mAjax)  {
			$this->mTemplate->addVar("xajax", "XAJAX_FRAMEWORK",$mXajax->printJavascript());
		}
		
		// load the default layout
		$this->loadDefaultLayout();
			
	}
	
	function loadDefaultLayout()
	{
		//$this->setTemplateBasedir($this->mrConfig->getValue('docroot').'templates/');
		//$this->addTemplateFile('document-jquery.html');		
		//$this->addTemplateFile('layout-jquery.html');
		//$this->mTemplate->addVar("body", "HOME","../".$this->home."/index.php");
		//$this->mTemplate->addVar("is_login", "login",1);
	}
	
  /**
	* DisplayJQuery::display()
	* method for displaying/prepare page
	*/
	function display()
	{
		DisplayBase::display();
		$this->mSession = new SessionPHP();
		//$this->mSession->startSession();
		$this->mUserIdentity = $this->mSession->getVariable('user_identity');				
		
		/*
		$this->mTemplate->addVar('body','_COMPANY_',$this->mrConfig->GetValue('company_name'));
		$this->mTemplate->addVar('content','_COMPANY_',$this->mrConfig->GetValue('company_name'));
		$this->mTemplate->addVar('document','_COMPANY_',$this->mrConfig->GetValue('company_name'));
		
		$this->mTemplate->addVar('body','LOGIN_USER_NAME', $this->mUserIdentity->mRealName);
		$this->mTemplate->addVar('document','LOGIN_USER_NAME', $this->mUserIdentity->mRealName);
		$this->mTemplate->addVar('content','LOGIN_USER_NAME', $this->mUserIdentity->mRealName);
		
		$this->mTemplate->addVar('body','LOGIN_USER_ID', $this->mUserIdentity->mUserId);
		$this->mTemplate->addVar('document','LOGIN_USER_ID', $this->mUserIdentity->mUserId);
		$this->mTemplate->addVar('content','LOGIN_USER_ID', $this->mUserIdentity->mUserId);								
		
		// display user company mana yg login
		$this->mTemplate->addVar('body','LOGIN_LONG_COMPANY_NAME', $this->mUserIdentity->mConame);
		$this->mTemplate->addVar('document','LOGIN_LONG_COMPANY_NAME', $this->mUserIdentity->mConame);
		$this->mTemplate->addVar('content','LOGIN_LONG_COMPANY_NAME', $this->mUserIdentity->mConame);
		
		$this->mTemplate->addVar('body','LOGIN_SHORT_COMPANY_NAME', $this->mUserIdentity->mShortConame);
		$this->mTemplate->addVar('document','LOGIN_SHORT_COMPANY_NAME', $this->mUserIdentity->mShortConame);
		$this->mTemplate->addVar('content','LOGIN_SHORT_COMPANY_NAME', $this->mUserIdentity->mShortConame);
		*/
		
		//$time_now=mktime(date('H')+7,date('i'),date('s'));
		//$time_now=date('H:i:s',$time_now);		
		
		//$time_now = date('H:i:s');		
		$time_now=mktime(date('H')-1,date('i'),date('s'));		
		$time_now=date('H:i:s',$time_now);
		$now = date('d/m/Y').' '.$time_now;		
		$this->mTemplate->addVar('body','_DATE_', ($this->indonesianDateWithTime(date('Y-m-d'))));
		$this->mTemplate->addVar('document','_DATE_', ($this->indonesianDateWithTime(date('Y-m-d'))));
		$this->mTemplate->addVar('content','_DATE_', ($this->indonesianDateWithTime(date('Y-m-d'))));
		
		$this->mTemplate->addVar('body','_TIME_', $time_now);
		$this->mTemplate->addVar('document','_TIME_', $time_now);
		$this->mTemplate->addVar('content','_TIME_', $time_now);
		
		$this->mTemplate->addVar('body','_NOW_', $now);
		$this->mTemplate->addVar('document','_NOW_', $now);
		$this->mTemplate->addVar('content','_NOW_', $now);
		
		// display configuration information		
		/*$regtype = 'APP_NAME';		
		$obj = new ReferenceConfiguration($this->mrConfig,$regtype);
		$app_name = $obj->getReferenceConfiguration();
		$this->mTemplate->addVar('content','APP_NAME', ($app_name=='' ? '' : $app_name));		
		$this->mTemplate->addVar('body','APP_NAME', ($app_name=='' ? '' : $app_name));
		$this->mTemplate->addVar('document','APP_NAME', ($app_name=='' ? '' : $app_name));
		*/
	}
	
  /**
	* DisplayJQuery::setUserRole()
	* UserRole property set
	*
	* @param object $user_role  UserIdentity object
	**/
	function setUserRole($user_role)
	{
		$this->mUserRole = $user_role;
	}

  /**
	* DisplayJQuery::getUserRole()
	* UserRole property get
	*
	* @return object $user_role  UserIdentity object
	**/
	function getUserRole()
	{
		return $this->mUserRole;
	}
}
?>