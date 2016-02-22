<?php
class SearchDataCatalog extends DatabaseConnected
{
	function SearchDataCatalog($config_object)
	{
		DatabaseConnected::DatabaseConnected($config_object, 'efiling/data_efiling_catalog.sql.php');		
		# untuk debuging
		# $this->mrDbConnection->debug=true;
	}	
	
	function getSearchDataCount($company='', $siteid='', $sitename='', $invoicenumber='', $projectid='', $customer_po_number='')
	{
		$whr ='';		
		if($company!='')
			$whr .=" AND UPPER(b.name) LIKE UPPER('%".$company."%')";
		if($siteid!='')
			$whr .=" AND UPPER(a.site_id) LIKE UPPER('%".$siteid."%')";
		if($sitename!='')
			$whr .=" AND UPPER(a.site_name) LIKE UPPER('%".$sitename."%')";
		if($invoicenumber!='')
			$whr .=" AND UPPER(a.invoice_number) LIKE UPPER('%".$invoicenumber."%')";	
		if($projectid!='')
			$whr .=" AND UPPER(a.project_id) LIKE UPPER('%".$projectid."%')";
		if($customer_po_number!='')
			$whr .=" AND a.customer_po_number LIKE '%".$customer_po_number."%'";
		
		$sql = $this->mSqlQueries['search_po_custom_count'];		
		$sql = sprintf($sql, $whr);
		$rs = $this->mrDbConnection->Execute($sql);
		
		if($rs) {
			$row =  $rs->FetchRow();
			#print_r($row);
			return $row['jml'];
		} else {			
			return false;
		}
	}
	function getSearchData($company='', $siteid='', $sitename='', $invoicenumber='', $projectid='', $customer_po_number='')
	{	
		$whr ='';		
		if($company!='')
			$whr .=" AND UPPER(b.name) LIKE UPPER('%".$company."%')";
		if($siteid!='')
			$whr .=" AND UPPER(a.site_id) LIKE UPPER('%".$siteid."%')";
		if($sitename!='')
			$whr .=" AND UPPER(a.site_name) LIKE UPPER('%".$sitename."%')";
		if($invoicenumber!='')
			$whr .=" AND UPPER(a.invoice_number) LIKE UPPER('%".$invoicenumber."%')";	
		if($projectid!='')
			$whr .=" AND UPPER(a.project_id) LIKE UPPER('%".$projectid."%')";
		if($customer_po_number!='')
			$whr .=" AND a.customer_po_number LIKE '%".$customer_po_number."%'";
		
		$sql = $this->mSqlQueries['search_po_custom'];		
		$sql = sprintf($sql, $whr);
		
		//echo $sql;
		
		if ($rs = $this->mrDbConnection->Execute($sql))
		{	
			//print_r($rs->getArray());
			return $rs->getArray();
		}else
		{
			return false;
		}			
	}
	
	
}
	
?>
