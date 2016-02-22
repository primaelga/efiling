<?php
class DisplayErrorPage extends DisplayError
{	
	function DisplayErrorPage(&$config_object)
	{
		DisplayError::DisplayError($config_object);		
		$this->mSession = new SessionPHP();
		$this->mSession->startSession();
		$this->mUserIdentity = $this->mSession->getVariable('user_identity');				
	}
	
	function display()
	{
		DisplayError::display();
		$this->mTemplate->setBasedir($this->mrConfig->getValue('docroot').'templates/error');
		$this->addTemplateFile('page-error.html');
		$this->mTemplate->addVar('content','ERROR_TITLE',$this->mErrorTitle);
		if(isset($this->mrLinks)) {
			$this->mTemplate->addVar('is_sidemenu','sidemenu',1);
			$this->mTemplate->addVar('body','SUBSYSTEM',$this->mrLinks->getSubSystemName());
		} else {
			$this->mTemplate->addVar('is_sidemenu','sidemenu',0);
		}
		if(count($this->mErrorMsg)>0) {
			foreach ($this->mErrorMsg as $item) 
			{	
				$this->mTemplate->addVar("error_msg","ERROR_MSG",$item);
				$this->mTemplate->parseTemplate("error_msg", "a");
			}			
			$this->mTemplate->addGlobalVar('CONFIG_BASEDIR', $this->mrConfig->GetValue('basedir'));
		}
		//echo "XXXXXXXXXXXXXXXXXXXX";
		/*if(isset($_SESSION['start_chat'])){
			$this->mTemplate->addVar("content","OPENER_BACK_URL",$this->mBackLink);
			$this->mTemplate->addVar("content","WIN_CLOSE",'t');
		}
		else{
			$this->mTemplate->addVar("content","BACK_URL",$this->mBackLink);
		}*/		
		//if(empty($_SESSION['user_identity'])){
				
		if(!$this->mUserIdentity){
			$this->mTemplate->addVar("content","BACK_URL",$this->mBackLink);
		}
		
		/*echo "
		<script language='JavaScript'>
			//jAlertX('".$this->mErrorTitle."','info','f','".$this->mBackLink."','');			
			window.alert('XXXXXXXXXX');			
		</script>";
		exit();*/
		print $this->mTemplate->displayParsedTemplate();
	}
}
?>