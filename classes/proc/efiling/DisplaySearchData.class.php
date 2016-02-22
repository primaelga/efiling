<?php

class DisplaySearchData extends DisplayJQuery
{
	var $mViewData;
	var $mData;
	
	function DisplaySearchData(&$config_object)
	{
		DisplayJQuery::DisplayJQuery($config_object);
		
		$this->mViewData =  new SearchDataCatalog($this->mrConfig);
	}
	
	
	function display()
	{
		DisplayJQuery::display();
		//echo $callback;
		$page 				= $this->mData['page']; 
		$limit 				= $this->mData['limit'];
		$company			= $this->mData['company']; 
		$invoicenumber		= $this->mData['invoicenumber']; 
		$projectid	    	= $this->mData['projectid']; 
		$customer_po_number	= $this->mData['customerponumber']; 		
		$siteid	        	= $this->mData['siteid']; 
		$sitename			= $this->mData['sitename']; 		
	
	
		$count = $this->mViewData->getSearchDataCount($company, $siteid, $sitename, $invoicenumber, $projectid, $customer_po_number);
		
		if( $count >0 ) { 
			$total_pages = ceil($count/$limit); 
		} else { 
			$total_pages = 0; 
		} 
		if ($page > $total_pages) 
			$page=$total_pages; 
		
		$start = $limit*$page - $limit; 
		$limit*($page - 1);		
		
		$list = $this->mViewData->getSearchData($company, $siteid, $sitename, $invoicenumber, $projectid, $customer_po_number);
		if( !function_exists('json_encode') ) {
			function json_encode($data) {
				$json = new Services_JSON();
				return( $json->encode($data) );
			}
		}		
		$callback =  $this->mData['callback'];		
		if ($callback) {
			//header('Content-Type: text/javascript');
			echo $callback . '({"total":"' . $count . '","root":'. json_encode($list) . '})';
		}
	}	
	function setData($data)
	{
		$this->mData = $data;
	}
	
}
	
?>
 