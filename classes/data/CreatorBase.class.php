<?php
/**
  * Employee
  * Objek ini digunakan untuk menyimpan dan memanajemen data karyawan
  *
  
  * @filename CreatorBase.class.php
  * @author 
  * @copyright IT Dept. Refconindo, 2006
  * @version 1.0
  * @access public
  */
class CreatorBase extends DatabaseConnected
{
	var $mRefTable;
	var $mRefId;
	
	var $mCreatedBy;
	var $mCreatedOn;
	var $mModifiedBy;
	var $mModifiedOn;
	var $mHost;
	
	function setCreatedBy($tmp)
	{
		$this->mCreatedBy = $tmp;
	}
	function getCreatedBy()
	{
		return ($this->mCreatedBy);
	}
	
	function setCreatedOn($tmp)
	{
		$this->mCreatedOn = $tmp;
	}
	function getCreatedOn()
	{
		return ($this->mCreatedOn);
	}
	
	function setModifiedBy($tmp)
	{
		$this->mModifiedBy = $tmp;
	}
	function getModifiedBy()
	{
		return ($this->mModifiedBy);
	}
	
	function setModifiedOn($tmp)
	{
		$this->mModifiedOn = $tmp;
	}
	function getModifiedOn()
	{
		return ($this->mModifiedOn);
	}
	
	function setHost($tmp)
	{
		$this->mHost = $tmp;
	}
	function getHost()
	{
		return ($this->mHost);
	}
	
	function setLastHost($tmp)
	{
		$this->mLastHost = $tmp;
	}
	function getLastHost()
	{
		return ($this->mLastHost);
	}
	
	
	function CreatorBase(&$config_object, $ref_table='', $ref_id='')
	{
		DatabaseConnected::DatabaseConnected($config_object, 'creator_base.sql.php');
		$this->mRefTable = $ref_table;
		$this->mRefId = $ref_id;
	}
	
	function getCreatorList()
	{	////$this->mrDbConnection->debug=true;
		$sql = sprintf($this->mSqlQueries['get_creator_list'], $this->mRefTable);
		
		if ($rs = $this->mrDbConnection->Execute($sql)) {
				return $rs->GetArray();
			} else {
				return false;
			}
	}
	
	function getCreatorListDetail()
	{	//$this->mrDbConnection->debug = true;
		$sql = sprintf($this->mSqlQueries['get_creator_list'], $this->mRefTable, $this->mRefTable, $this->mRefTable, $this->mRefTable, $this->mRefTable, $this->mRefTable, $this->mRefTable, $this->mRefTable, $this->mRefTable, $this->mRefTable, $this->mRefId);
		if ($rs = $this->mrDbConnection->Execute($sql)) {
			return $rs->GetArray();
		} else {
			return false;
		}
	}
}
?>