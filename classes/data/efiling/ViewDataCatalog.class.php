<?php
class ViewDataCatalog extends DatabaseConnected
{
	
	function ViewDataCatalog($config_object)
	{
		DatabaseConnected::DatabaseConnected($config_object, 'efiling/data_efiling_catalog.sql.php');
		
		# untuk debuging
		# $this->mrDbConnection->debug=true;
	}
	
	
	function getLoadDataCount()
	{
		$sql = $this->mSqlQueries['count'];		
		$sql = sprintf($sql);
		$rs = $this->mrDbConnection->Execute($sql);
		if($rs) {
			$row =  $rs->FetchRow();
			#print_r($row);
			return $row['jml'];
		} else {			
			return false;
		}
	}
	
	function getLoadData($limit='', $offset='')
	{	
		$sql = $this->mSqlQueries['select_po_custom'];		
		$sql = sprintf($sql, $limit,$offset);		
		
		
		if ($rs = $this->mrDbConnection->Execute($sql))
		{	
			//print_r($rs->getArray());
			return $rs->getArray();
		}
		
	}
	
	
}
	
?>
