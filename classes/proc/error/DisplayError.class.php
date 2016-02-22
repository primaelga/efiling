<?php
  /**
	* DisplayError class
	* Class for handling error messages and confirmation message
	*
	* @package error
	* @file DisplayError.class.php
	* @author 
	* @access public
	**/

class DisplayError extends DisplayJQuery
{
	var $mErrorMsg;
	var $mErrorTitle;
	var $mBackLink;
	
	
	function DisplayError(&$config_object)
	{
		DisplayJQuery::DisplayJQuery($config_object);
		$this->mErrorMsg = array();
		//$this->mBackLink = 'javascript:window.history.back(1)';
		$this->mBackLink = 'login/';
		$this->mTemplate->setBasedir($this->mrConfig->getValue('docroot').'templates');						
	}
	
	function setErrorMessage($msg)
	{
		$this->mErrorMsg = $msg;
	}
	
	function setErrorTitle($title)
	{
		$this->mErrorTitle = $title;
	}
	
	function setBackLink($link)
	{
		$this->mBackLink = $link;
	}
	
	function setTemplate($template)
	{
		$this->addTemplateFile($template);
	}
	
  /**
	* DisplayError::display()
	* this method used to show error screen
	*
	**/
	function display()
	{
		DisplayJQuery::display();						
		if(count($this->mErrorMsg)>0) {
			$this->mTemplate->addVar('document','PAGE_TITLE','ERROR - ' . $this->mErrorTitle);
		}
	}
}
?>