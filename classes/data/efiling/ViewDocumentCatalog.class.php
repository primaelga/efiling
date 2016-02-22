<?php
class ViewDocumentCatalog extends DatabaseConnected
{
	
	function ViewDocumentCatalog($config_object)
	{
		DatabaseConnected::DatabaseConnected($config_object, 'efiling/data_efiling_catalog.sql.php');
		
		# untuk debuging
		# $this->mrDbConnection->debug=true;
	}
	
	
	function getLoadDataCount($sitehandler)
	{
		$sql = $this->mSqlQueries['search_count_document'];	
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
	
	function getDataDocument($sitehandler)
	{	
		$sql = $this->mSqlQueries['search_document'];		
		$sql = sprintf($sql,$sitehandler);		
		
		//echo $sql;
		if ($rs = $this->mrDbConnection->Execute($sql))
		{	
			//print_r($rs->getArray());
			return $rs->getArray();
		}
		
	}
	
	
}
	
?>
