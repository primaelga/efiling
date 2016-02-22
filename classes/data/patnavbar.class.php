<?php
/**
	* Navbar class with adodb
	* ver. 1
*/


//class PatNavbar extends Navbar
class PatNavbar extends DatabaseConnected
{
	var $mRow;
	var $config_object;
	var $maxpage;
	var $str_previous = "Previous";
  	var $str_next = "Next";
	function PatNavbar(&$config_object)
	{
		//$this->config_object = $config_object;
		DatabaseConnected::DatabaseConnected($config_object, 'paging.sql.php');
		$this->mRow = $_GET['row'] ? $_GET['row'] : $_POST['row'];		
	}

  	// The next function runs the needed queries.
  	// It needs to run the first time to get the total
  	// number of rows returned, and the second one to
  	// get the limited number of rows.
  	//
  	// $sql parameter :
  	//  . the actual SQL query to be performed
  	//
  	// $db parameter :
  	//  . the database connection link
  	//
  	// $numtoshow parameter :
  	//  . maximum row per page
	function Execute($sql,$numtoshow=10,$maxpage=10)
	{		
		$this->numrowsperpage = $numtoshow;
		$this->maxpage = $maxpage;
		$start = $this->mRow * $numtoshow;
		//$rs = $this->base->dbquery($sql);
		$rs = $this->mrDbConnection->Execute($sql);
		$this->total_records = $rs->recordCount();
		return $this->mrDbConnection->SelectLimit($sql,$numtoshow,$start);
	}
	
	
	  
  // This function creates an array of all the links for the
  // navigation bar. This is useful since it is completely
  // independent from the layout or design of the page.
  // The function returns the array of navigation links to the
  // caller php script, so it can build the layout with the
  // navigation links content available.
  //
  // $option parameter (default to "all") :
  //  . "all"   - return every navigation link
  //  . "pages" - return only the page numbering links
  //  . "sides" - return only the 'Next' and / or 'Previous' links
  //
  // $show_blank parameter (default to "off") :
  //  . "off" - don't show the "Next" or "Previous" when it is not needed
  //  . "on"  - show the "Next" or "Previous" strings as plain text when it is not needed
  function getlinks($option = "all", $show_blank = "off",$fl="no_changed") 
	{
    $extra_vars = $this->build_geturl();              
    $file = $this->file;
    	
    $number_of_pages = ceil($this->total_records / $this->numrowsperpage);
    $curpage = abs(floor($this->mRow / $this->maxpage));
		//check current page num
		$startpage = $curpage * $this->maxpage;
		
    $subscript = 0;
    //for ($current = $startpage; $current < $number_of_pages; $current++) 
    for ($current = $startpage; $current < $number_of_pages; $current++) 
		{
      if ((($option == "all") || ($option == "sides")) && (($current == 0) || ($current == $startpage)))
			{
        if ($this->mRow > 0)
          $array[0] = '<A HREF="' . $file . '?row=' . ($this->mRow - 1) . $extra_vars . '"><font color="blue">' . $this->str_previous . '</font></A>';
        elseif (($this->mRow == 0) && ($show_blank == "on"))
          $array[0] = $this->str_previous;
      }

      if (($option == "all") || ($option == "pages")) 
			{
				if ($current == $this->maxpage + $startpage)
				{
					$array[++$subscript] = '<A HREF="' . $file . '?row=' . $current . $extra_vars . '"><font color="blue">...</font></A>';
				}
				elseif ($current > $this->maxpage + $startpage)
				{
				}
				else
				{
	        if ($this->mRow == $current)
  	        $array[++$subscript] = ($current > 0 ? ($current + 1) : 1);
    	    else
      	    $array[++$subscript] = '<A HREF="' . $file . '?row=' . $current . $extra_vars . '"><font color="blue">' . ($current + 1) . '</font></A>';
				}
      }

      if ((($option == "all") || ($option == "sides")) && ($current == ($number_of_pages - 1))) {
        if ($this->mRow != ($number_of_pages - 1))
          $array[++$subscript] = '<A HREF="' . $file . '?row=' . ($this->mRow + 1) . $extra_vars . '"><font color="blue">' . $this->str_next . '</font></A>';
        elseif (($this->mRow == ($number_of_pages - 1)) && ($show_blank == "on"))
          $array[++$subscript] = $this->str_next;
      }
    }
    return $array;
  }


  // This function creates a string that is going to be
  // added to the url string for the navigation links.
  // This is specially important to have dynamic links,
  // so if you want to add extra options to the queries,
  // the class is going to add it to the navigation links
  // dynamically.
  function build_geturl()
  {
    global $REQUEST_URI, $REQUEST_METHOD, $HTTP_GET_VARS, $HTTP_POST_VARS, $QUERY_STRING;	
    list($fullfile, $voided) = explode("?", $REQUEST_URI);
    $this->file = $fullfile;
    $cgi = $REQUEST_METHOD == 'GET' ? $HTTP_GET_VARS : $HTTP_POST_VARS;
    reset ($cgi);
    while (list($key, $value) = each($cgi)) 
		{
      if (($key != "row") && ($REQUEST_METHOD == 'GET'))
        $query_string .= "&" . $key . "=" . $value;
    }
    if ($REQUEST_METHOD != 'GET')
    {
      $query_string .= $QUERY_STRING;
    }
		
		if ($HTTP_GET_VARS['mod'] != '') $query_string .= "&mod={$HTTP_GET_VARS['mod']}";
	/*	if ($HTTP_GET_VARS['submod'] != '') $query_string .= "&submod={$HTTP_GET_VARS['submod']}";
		if ($HTTP_GET_VARS['sub'] != '') $query_string .= "&sub={$HTTP_GET_VARS['sub']}";
		*/
    return $query_string;
  }


}
?>
