<?php
  /**
	* DisplayErrorInLine class
	* this class is derrived from DisplayError. The error will be shown in top
	* of input form.
	*
	**/
	
class DisplayErrorInLine extends DisplayError
{

	var $mPageData;
	
	function DisplayErrorInLine(&$config_object, $lang_id='en')
	{
		DisplayError::DisplayError($config_object, $lang_id);
		$this->addTemplateFile('layout-common.html');
	}
	
	function setPageTemplate($page_template)
	{
		$this->addTemplateFile($page_template);
	}
	
	function setPageData($page_data)
	{
		$this->mPageData = $page_data;
	}
	
	function display()
	{
		$template_name = '';
		$template_section = '';
		$template_value = '';
		
		DisplayError::display();
		
		if(count($this->mErrorMsg)>0) {
			$this->buildTopMenu();
			$this->buildTreeMenu();
			$this->mTemplate->addVar('body','SUBSYSTEM',$this->mrLinks->getSubSystemName());
			
			// proceed the error messages
			$this->addTemplateFile('error/inline-error.html');
			$this->mTemplate->addVar('content','ERROR_TITLE',$this->mErrorTitle);
			if(count($this->mErrorMsg)>0) {
				foreach ($this->mErrorMsg as $item) 
				{	
					$this->mTemplate->addVar("error_msg","ERROR_MSG",$item);
					$this->mTemplate->parseTemplate("error_msg", "a");
				}
			}
			
			// rebuild the input form values
			if(isset($this->mPageData)) {
				foreach($this->mPageData as $data)
				{
					if(isset($data['template_name'])) {
						$template_name = $data['template_name'];
						if(isset($data['template_section'])) {
							$template_section = $data['template_section'];
							if(isset($data['template_value'])) $template_value = $data['template_value'];
							$this->mTemplate->addVar($template_name,$template_section,$template_value);
						}
					}
				}
			}
			
			$this->mTemplate->addGlobalVar("CONFIG_BASEDIR", $this->mrConfig->GetValue('basedir'));
		}
		print $this->mTemplate->displayParsedTemplate();
	}
}
?>