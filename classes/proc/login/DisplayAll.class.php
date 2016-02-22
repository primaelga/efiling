<?php

class DisplayAll extends DisplayJQuery
{
	function DisplayAll(&$config_object)
	{
		DisplayJQuery::DisplayJQuery($config_object);
		$this->setTemplateBasedir($this->mrConfig->getValue('docroot').'templates/e-Filing');
		$this->addTemplateFile('eFiling.html');	
	}
	
	function display()
	{
		DisplayJQuery::display();
		print $this->mTemplate->displayParsedTemplate();
	}
}

?>