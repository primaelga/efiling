<?php


class DisplayViewPoNumber extends DisplayJQuery
{
	var $mViewData;
	var $mData;
	
	function DisplayViewPoNumber(&$config_object)
	{
		DisplayJQuery::DisplayJQuery($config_object);		
		$this->mViewData =  new ViewPoNumberCatalog($this->mrConfig);
	}
	
	
	function display()
	{
		DisplayJQuery::display();		
		
		//echo $callback;
		
		$page = $this->mData['page']; 
		$limit = $this->mData['limit']; 
		$site =  $this->mData['sitehandler'];
		$count = $this->mViewData->getLoadDataCount($site);			
		
		if( $count >0 ) { 
			$total_pages = ceil($count/$limit); 
		} else { 
			$total_pages = 0; 
		} 
		if ($page > $total_pages) 
			$page=$total_pages; 
		
		$start = $limit*$page - $limit; 
		$limit*($page - 1);		
		
		//print_r($total_pages);
		
		$list = $this->mViewData->getDataPoNumber($site, $limit, $start);
		
		//print_r($list);
		
		if( !function_exists('json_encode') ) {
			function json_encode($data) {
				$json = new Services_JSON();
				return( $json->encode($data) );
			}
		}		
		echo json_encode($list);
		/*
		$callback =  $this->mData['callback'];		
		if ($callback) {
			header('Content-Type: text/javascript');
			echo $callback . '({"total":"' . $count . '","root":'. json_encode($list) . '})';
		}
		*/
	}
	
	function setData($data)
	{
		$this->mData = $data;
	}
	
}
	
?>
 