<?php
class Configuration
{
	
	var $mConfigDirectory;
	
	var $mValue;
	
	function Configuration()
	{
		$this->mValue = array();
	}
	function setConfigDir($configDirectory)
	{
		$this->mConfigDirectory = $configDirectory;	
	}
	
	function load($configFilename)
	{
				
		require_once $this->mConfigDirectory . $configFilename;
		
		$this->mValue = array_merge($this->mValue, $cfg);
	}
	
	function getValue($name = '')
	{
		if (empty($name)) 
		{
			return $this->mValue;
		} 
		else 
		{
			return $this->mValue[$name];
		}
	}
	
	function setValue($name, $value)
	{
		return $this->mValue[$name] = $value;
	}
}

?>