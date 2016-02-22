<?php
class ViewPoNumberCatalog extends DatabaseConnected
{
	
	function ViewPoNumberCatalog($config_object)
	{
		DatabaseConnected::DatabaseConnected($config_object, 'efiling/data_efiling_catalog.sql.php');
		
		# untuk debuging
		# $this->mrDbConnection->debug=true;
	}
	
	
	function getLoadDataCount($sitehandler)
	{
		$sql = $this->mSqlQueries['count_po_number'];	
		$sql = sprintf($sql, $sitehandler);
		$rs = $this->mrDbConnection->Execute($sql);
		if($rs) {
			$row =  $rs->FetchRow();
			#print_r($row);
			return $row['jml'];
		} else {			
			return false;
		}
	}
	
	function getDataPoNumber($sitehandler, $limit='', $offset='')
	{	
		$sql = $this->mSqlQueries['select_po_number'];		
		$sql = sprintf($sql,$sitehandler, $limit,$offset);		
		
		
		if ($rs = $this->mrDbConnection->Execute($sql))
		{	
			//print_r($rs->getArray());
			return $rs->getArray();
		}
		
	}
	
	
}
	
?>
