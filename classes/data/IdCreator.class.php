<?php
class IdCreator extends DatabaseConnected
{
	var $mSequenceName;		
	function IdCreator(&$config_object)
	{
		DatabaseConnected::DatabaseConnected($config_object, 'id_creator.sql.php');
	}
	
	function getNewId()
	{
		$this->mrDbConnection->RowLock($this->mSequenceName, "sequence_name='" . $this->mSequenceName . "'");
	}
}
?>