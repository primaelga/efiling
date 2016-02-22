<?php
/**
  * DisplayBase
  * 
  * @package Display  
  * @author 
  * @Copyright (c) 2004, PowerComm Technology 2008
  * @version 1.0
  * @access public
  **/
 
class DisplayBase
{
	var $mrConfig;
	var $mTemplate;
	var $mDisplayDate;
	var $mLangId;
	var $mrLinks;
	
	
	var $privileges;
	var $home;
	
	
  /**
	* DisplayBase::DisplayBase()
	* DisplayBaseConstructor
	*
	* @param object $config_object
	* @param int $ajax_mode
	* @return
	**/
	function DisplayBase(&$config_object)
	{
		$sess = new SessionPHP();
		//$sess->startSession();
		/*$this->mLangId = $sess->getVariable('lang_id');
		if(!$this->mLangId) 
			$this->mLangId = 'en';
		*/
		$this->mLangId = $sess->getVariable('lang_id');
		if(!$this->mLangId) 
			$this->mLangId = 'id';
		$this->mrConfig = &$config_object;
		$this->mTemplate = new patTemplate();
		
		$ses = new SessionPHP();
		
		$ses->startSession();
		$user_identity = $ses->getVariable('user_identity');
		$this->home = $ses->getVariable('home');
		//echo "User Identity = ".$user_identity;
		if(!empty($user_identity))
			$this->privileges = $user_identity->getPrivileges();
		else 
			$this->privileges = "";				
	}

  	/**
	* DisplayBase::parseData()
	* Method for parse data in a recordset/array
	*
	* @param string $template_name  contain template name
	* @param string $data  contain array data
	* @param string $modPrefix  contain prefix used for table
	* @param string $prefix  contain prefix used for data
	* @param boolean $start_numbering  flag if this data need numbering
	* @return
	**/
	function parseData($template_name,$data,$mod_prefix="",$prefix="")
	{
		$number = 1;
		if (!empty($data)) {
			$cls="even";
			foreach($data as $data_item)
			{
				$cls = $cls=="odd" ? "even" : "odd";
				$data_item["CLASS"] = $cls;
					
				if (!empty($mod_prefix)){
					$this->mTemplate->AddVar($template_name,$mod_prefix,$number %2);
				}
				$data_item["NO"] = $number++;				
				$this->mTemplate->addVars($template_name, $data_item,$prefix);
				$this->mTemplate->parseTemplate($template_name, "a");
			}
			return true;
		} else {
			return false;
		}
	}

  	/**
	* DisplayBase::parseCombo()
	* Method untuk memparse data combobox
	*
	* @param string $template_name  contain template name
	* @param string $data  contain array data
	* @param string $default_value optional contain combo box default value
	* @param string $id_field optional id field name from the list
	* @return
	**/
	function parseCombo($template_name, $data, $default_value='', $id_field='COMBO_ID')
	{				
		if (!empty($data)) 
		{			
			foreach($data as $data_item) 
			{
				if ("" != $default_value) {
					if ($data_item[$id_field]==$default_value) 
					{				
						$this->mTemplate->addVar($template_name, 'SELECTED', 'selected="selected"');						
					} 
					else 
					{				
						$this->mTemplate->addVar($template_name, 'SELECTED', '');						
					}
				}
				$this->mTemplate->addVars($template_name, $data_item);
				$this->mTemplate->parseTemplate($template_name, 'a');					
			}
		}
	}

	
  	/**
	* DisplayBase::indonesianMonth()
	* Method for converting month into indonesian month
	*
	* @param int $month
	* @param string indonesian month
	* @return
	**/
	function indonesianMonth($month)
	{
		switch($month)
		{
			case  1: $month ='Januari';  break; 
			case  2: $month ='Februari'; break; 
			case  3: $month ='Maret'; break; 
			case  4: $month ='April'; break; 
			case  5: $month ='Mei'; break; 
			case  6: $month ='Juni'; break; 
			case  7: $month ='Juli'; break; 
			case  8: $month ='Agustus'; break; 
			case  9: $month ='September'; break; 
			case 10: $month ='Oktober'; break; 
			case 11: $month ='November'; break; 
			case 12: $month ='Desember'; break; 
		} // switch 	

		return $month;
	}


  	/**
	* DisplayBase::indonesianDate()
	* Method for converting date into indonesian date
	*
	* @param date $date
	* @param string indonesian date format
	* @return
	**/
	function indonesianDate($date)
	{
		$lengthDate = strlen(trim($date));
		$month = substr($date,5,2)+'toint';
		$month = $this->IndonesianMonth($month);

		if ($lengthDate > 10)
		{
			return $this->mDisplayDate = substr($date,8,2).' '.$month.' '
																	.substr($date,0,4).' '.substr($date,-8);
		} else {
			return $this->mDisplayDate = substr($date,8,2).' '.$month.' '
																	.substr($date,0,4);
		}
	}


 /**
   * DisplayBase::indonesianDay()
   * Method for converting date into indonesian day
   *
   * @param date $date
   * @param string indonesian day
   * @return
   **/
  function indonesianDay($date)
  {
    $day = date("l", mktime(0, 0, 0,
                     substr($date,5,2),substr($date,8,2),substr($date,0,4)));
    switch($day)
    {
      case  "Sunday": $day ='Minggu'; break; 
      case  "Monday": $day ='Senin'; break; 
      case  "Tuesday": $day ='Selasa'; break; 
      case  "Wednesday": $day ='Rabu'; break; 
      case  "Thursday": $day ='Kamis'; break; 
      case  "Friday": $day ='Jumat'; break; 
      case  "Saturday": $day ='Sabtu'; break; 
    } // switch 

    return $day;
  }


 /**
   * DisplayBase::indonesianDateWithTime()
   * Method for converting date into indonesian date with time
   *
   * @param date $date
   * @param string Indonesian date format with time
   * @return
   **/
  function indonesianDateWithTime($date)
  {
    $month = substr($date,5,2)+'toint';
    switch($month)
    {
      case  1: $month ='Januari'; break; 
      case  2: $month ='Februari'; break; 
      case  3: $month ='Maret'; break; 
      case  4: $month ='April'; break; 
      case  5: $month ='Mei'; break; 
      case  6: $month ='Juni'; break; 
      case  7: $month ='Juli'; break; 
      case  8: $month ='Agustus'; break; 
      case  9: $month ='September'; break; 
      case 10: $month ='Oktober'; break; 
      case 11: $month ='November'; break; 
      case 12: $month ='Desember'; break; 
    } // switch 

    //return $this->mDisplayDate = substr($date,8,2).' '.$month.' '.substr($date,0,4).' '.substr($date,-8);
    return $this->mDisplayDate = substr($date,8,2).' '.$month.' '.substr($date,0,4);
  }
  
  function englishDateWithTime($date)
  {
    $month = substr($date,5,2)+'toint';
    switch($month)
    {
      case  1: $month ='January'; break; 
      case  2: $month ='February'; break; 
      case  3: $month ='March'; break; 
      case  4: $month ='April'; break; 
      case  5: $month ='May'; break; 
      case  6: $month ='June'; break; 
      case  7: $month ='July'; break; 
      case  8: $month ='August'; break; 
      case  9: $month ='September'; break; 
      case 10: $month ='Oktober'; break; 
      case 11: $month ='November'; break; 
      case 12: $month ='December'; break; 
    } // switch 

    //return $this->mDisplayDate = substr($date,8,2).' '.$month.' '.substr($date,0,4).' '.substr($date,-8);
    return $this->mDisplayDate = $month.' '. substr($date,8,2).' '.substr($date,0,4);
  }


  /**
	* DisplayBase::convertToRupiahFormat()
	* Method for converting number to rupiah currency value
	*
	* @param long $value
	* @param string value with "Rp."
	* @return
	**/
	function convertToRupiahFormat($value)
	{
	$new_val = "";
	$len = strlen($value);

	for($i=$len - 1;$i>=0;$i--)
	{
	  $angka = substr($value,$i,1);
	  if((($len - $i) % 3 == 0) && ($i>0))
	  {
		$new_val = "." . $angka . $new_val;
	  } else {
		$new_val = $angka . $new_val;
	  }
	}

	$new_val = "Rp " . $new_val . ",-";
	return $new_val;
	}

	/**
		* DisplayBase::convertDateToDB()
		* method untuk merubah tanggal dari format D/M/Y menjadi Y-M-D
		*/
	function convertDateToDB($dt)
	{
		if (empty($dt)) {
			return '';
		} else {
			$tgl = explode('/', $dt);
			$tanggal = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
			return $tanggal;
		}
	}	
	
	/**
		* DisplayBase::convertHTMLtoExcel()
		* method untuk merubah dari page HTML ke page Excel (*.xls)
		*/
	function convertHTMLToExcel()
	{
		header("Content-Type: application/vnd.ms-excel");
		header("Content-type: application/octet-stream"); 
		header("Content-Disposition: attachment; filename=converted.xls"); 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
		//require_once $file;
	}
	
	function convertHTMLToWord()
	{
		header("Content-Type: application/vnd.ms-word; name='word'"); 
		header("Content-type: application/octet-stream"); 
		header("Content-Disposition: attachment; filename=converted.doc"); 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
		//require_once $file;
	}
	
	function convertHTMLToPdf()
	{
		Header( "Content-type: application/vnd.adobe.pdf");  
		header("Content-type: application/octet-stream"); 
		header("Content-Disposition: attachment; filename=converted.pdf"); 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
		//require_once $file;
	}
	
	/**
		* DisplayBase::convertDBToDate()
		* method untuk merubah tanggal dari format Y-M-D menjadi D/M/Y
		*/
	function convertDBToDate($dt)
	{
		if (empty($dt)) {
			return '';
		} else {
			$tgl = explode('-', $dt);
			$tanggal = $tgl[2].'/'.$tgl[1].'/'.$tgl[0];
			return $tanggal;
		}
	}

  	/**
	* DisplayBase::UpperCaseField()
	* this method is used to repair recordset field into uppercase
	* since "I DON'T KNOW HOW" to make it uppercase in postgresql
	*
	* @param array $array_of_data  recordset in array format
	* @return array data with upper case field name
	**/	
	function upperCaseField($array_of_data)
	{
		$good_data = array();
		if (!empty($array_of_data)) {
			foreach($array_of_data as $row => $data_item) {
				foreach($data_item as $key => $data) {
					$ukey = strtoupper($key);
					$good_data[$row][$ukey] = $data;
				}
			}
		}
		return $good_data;
		
	}
	
	function grabbingKursBI()
	{
		// ambil data dari web
		//$data = implode('',file("http://www.bi.go.id/web/id/Indikator+Moneter+dan+Perbankan/Kurs+BI/"));
		// pisahkan jadi perbaris
		//$data = str_replace("</tr>", "</tr>\n", $data);
		// sesuaikan data
		//$data = str_replace("Update Terakhir\r\n", "Update Terakhir", $data);
		// ambil updatenya
		//preg_match("|Update Terakhir(.*)|i", $data, $hasil);
		
		/*if($update_terakhir = trim($hasil[1])){
			// grab datanya
			preg_match_all("|<td (.*)>(.*)</font>(.*)<td(.*)>(.*)</font>(.*)<td (.*)>(.*)</font>(.*)<td(.*)>(.*)</font>|", $data, $hasil);
			//echo "<h1>Update terakhir: $update_terakhir</h1><table border='1'>";
			//echo "<tr><th>Mata uang</th><th>Satuan</th><th>Kurs Jual</th><th>Kurs Beli</th></tr>";
			$this->mTemplate->addVar('content','UPADTE_TERAKHIR',$update_terakhir);
			foreach($hasil[2] as $key => $matauang){ 
				$satuan = $hasil[5][$key]; 
				list($jual) = explode(".",$hasil[8][$key]); 
				list($beli) = explode(".", $hasil[11][$key]); 
				$this->mTemplate->addVar('kurs_list','MATA_UANG',$matauang);
				$this->mTemplate->addVar('kurs_list','JUAL',$jual);
				$this->mTemplate->addVar('kurs_list','BELI',$beli);
				$this->mTemplate->parseTemplate('kurs_list', "a");
				//echo"<tr bgcolor='$warna'><td>$matauang</td><td>$satuan</td><td>$jual</td><td>$beli</td></tr>";
				// tukar warna 			
			}
			//echo "</table>";
			//print_r($update_terakhir);				
		}*/
	}

  /**
	* DisplayBase::display()
	* Method for processing main page
	*
	* @param
	* @return
	**/
	function display()
	{
		// nothing todo in this base display
	}
	
  /**
	* DisplayNormal::setLinks()
	* Links property set
	*
	* @param object $links  Links object for used drawing the menu
	**/
	function setLinks(&$links)
	{
		$this->mrLinks = &$links;
	}
	
	function setLinks2(&$links2)
	{
		$this->mrLinks2 = &$links2;
	}
	
  /**
	* DisplayBase::setTemplateBasedir()
	* template base dir property set
	*
	* @param string $base_dir  template base directory
	* @return
	**/
	function setTemplateBasedir($base_dir)
	{
		$this->mTemplate->setBasedir($base_dir);
	}

  /**
	* DisplayBase::addTemplateFile()
	* template base dir property set
	*
	* @param string $base_dir  template base directory
	* @return
	**/
	function addTemplateFile($tmpl)
	{
		$this->mTemplate->readTemplatesFromFile($tmpl);
	}

  /**
	* DisplayBase::setLangId()
	* language id property set
	*
	* @param string $lang_id  language id used by current page
	**/
	function setLangId($lang_id)
	{
		$this->mLangId = $lang_id;
	}

  /**
	* DisplayBase::getLangId()
	* language id property get
	*
	* @return string  language id used by current page
	**/
	function getLangId()
	{
		return $this->mLangId;
	}
	
	function format_money($amount)/*{{{*/
	{
		$ret = @number_format($amount,0,',','.');
		if ($amount < 0) $ret = "".$ret."";	
			return $ret;
	}/*}}}*/
	
	
  	/** perempuan atau laki2 ? */
  	function get_sex($valfromdb)/*{{{*/
  	{
    		$sexes = array(
        		't' => 'laki-laki',
        		'f' => 'perempuan',
        		);
    		return $sexes[$valfromdb];
  	}/*}}}*/

	function get_sex_image($valfromdb)/*{{{*/
	{
    		$sexes = array(
        		't' => 'male.gif',
        		'f' => 'female.gif',
        		);
    		return $sexes[$valfromdb];
	}/*}}}*/
	
	// list weekday			
	function getWeekDayList(){
		//$weekday[0]="Minggu";$weekday[1]="Senin";$weekday[2]="Selasa";$weekday[3]="Rabu";$weekday[4]="Kamis";$weekday[5]="Jumat";$weekday[6]="Sabtu";
		$weekday = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
		return $weekday;
	}
	
	// list hour
	function getHourList(){
		//$hour[0]="00";$hour[1]="01";$hour[2]="02";$hour[3]="03";$hour[4]="04";$hour[5]="05";$hour[6]="06";$hour[7]="07";$hour[8]="08";$hour[9]="09";$hour[10]="10";$hour[11]="11";$hour[12]="12";$hour[13]="13";$hour[14]="14";$hour[15]="15";$hour[16]="16";$hour[17]="17";$hour[18]="18";$hour[19]="19";$hour[20]="20";$hour[21]="21";$hour[22]="22";$hour[23]="23";$hour[24]="24";
		$hour = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24");
		return $hour;
	}
	
	// list minute
	function getMinuteList(){		
		$minute = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20"
			,"21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40"
			,"41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59");
		return $minute;
	}
	
	// list secon
	function getSeconList(){		
		$secon = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20"
			,"21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40"
			,"41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59");
		return $secon;
	}
	
	// list secon
	function getNumToText($no){		
		$secon = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20"
			,"21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40"
			,"41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59","60");			
		return $secon[$no];
	}
	
	function getCompleteAge($time){
		$age = str_replace('mons','bln',str_replace('days','hr',str_replace('years','thn',str_replace('17:00','',$time))));
		return $age;
	}
	
	function LastDayOfMonth($month = '', $year = '') {
		/* Notes carana:
		   $m = date('m');
		   $y = date('Y');
		   $day = $this->LastDayOfMonth($m, $y);
		*/
	   	if (empty($month)) {
	      		$month = date('m');
	   	}
	   	if (empty($year)) {
	      		$year = date('Y');
	   	}	
	   	//$lastday = date('t',mktime (0,0,0,$month,1,$year));
	   	$result = strtotime("{$year}-{$month}-01");
	   	$result = strtotime('-1 second', strtotime('+1 month', $result));
	   	
	   	return date('d', $result);	   	
	}
	
	function LastDateOfMonth($month = '', $year = '') {
		/* Notes carana:
		   $m = date('m');
		   $y = date('Y');
		   $last_date = $this->LastDateOfMonth($m, $y);
		*/
	   	if (empty($month)) {
	      		$month = date('m');
	   	}
	   	if (empty($year)) {
	      		$year = date('Y');
	   	}		   	
	   	$result = strtotime("{$year}-{$month}-01");
	   	$result = strtotime('-1 second', strtotime('+1 month', $result));
	   	return date('d/m/Y', $result);	   	
	}
	
	
	// list month
	function getIndonesianMonthList(){		
		$month = array("Januari","Pebruari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		return $month;
	}
	
	//print_r($_POST);	
	/*function json_encode($data) {
	        $json = new Services_JSON();
	        return( $json->encode($data) );	
	}
		
	function json_decode($data) {
	        $json = new Services_JSON();
	        return( $json->decode($data) );	
	}*/
	
	function countdown($year, $month, $day, $hour, $minute, $second)
        {
		global $return;
                global $countdown_date;
                $countdown_date = mktime($hour, $minute, $second, $month, $day, $year);
                $today = time();
                $diff = $countdown_date - $today;
                if ($diff < 0)
                	$diff = 0;
         	$dl = floor($diff/60/60/24);
         	$hl = floor(($diff - $dl*60*60*24)/60/60);
         	$ml = floor(($diff - $dl*60*60*24 - $hl*60*60)/60);
         	$sl = floor(($diff - $dl*60*60*24 - $hl*60*60 - $ml*60));
               // OUTPUT
               $return = array($dl, $hl, $ml, $sl);
               return $return;
	}
	
	function expiredTime($expdate){
	       $temp1=explode(" ",$expdate);
	       $temp=explode("-",$temp1[0]);
	       $year = $temp[0];
	       $month= $temp[1];
	       $day = $temp[2];
	       $hour = '00';
	       $minute = '00';
	       $second = '00';
	       list($dl,$hl,$ml,$sl) = $this->countdown($year, $month, $day, $hour,$minute, $second);
	       return $dl."days ". $hl."hr ".$ml."min ".$sl."sec";
	}
	
	function getMinuteFromTimeOLD($tm) {
		$tm = explode(":",$tm);
		$hasil = (intval($tm[0])*60) + ($tm[1] + ($tm[2]/60));
		return $hasil;
	}
	
	function getTimeDurationOLD( $start, $end )
	{
	    	$uts['start']      =    strtotime($start);
	    	$uts['end']        =    strtotime($end);
	    	if( $uts['start']!==-1 && $uts['end']!==-1 )
	    	{
	        	if( $uts['end'] >= $uts['start'] ){
	            		$diff = $uts['end'] - $uts['start'];
	            		if($days = intval((floor($diff/86400))) )
	                		$diff = $diff % 86400;
	            		if( $hours=intval((floor($diff/3600))) )
	                		$diff = $diff % 3600;
	            		if( $minutes=intval((floor($diff/60))) )
	                		$diff = $diff % 60;
	            		$diff    =    intval( $diff );            
	            		return( array('days'=>$days, 'hours'=>($hours < 10 ? '0'.$hours : $hours), 'minutes'=>($minutes < 10 ? '0'.$minutes : $minutes), 'seconds'=>($diff < 10 ? '0'.$diff : $diff)) );
	        	}else{
				return 0;
		    	}
	    	}else{
			return 0;
	    	}
	}
	
	function getTimeDuration($time1, $time2, $precision = 6) {
    		// If not numeric then convert texts to unix timestamps
    		if (!is_int($time1)) {
      			$time1 = strtotime($time1);
    		}
    		if (!is_int($time2)) {
      			$time2 = strtotime($time2);
    		}
 
    		// If time1 is bigger than time2
    		// Then swap time1 and time2
    		if ($time1 > $time2) {
      			$ttime = $time1;
      			$time1 = $time2;
      			$time2 = $ttime;
    		}
 
    		// Set up intervals and diffs arrays
    		$intervals = array('year','month','day','hour','minute','second');
    		$diffs = array();
 
    		// Loop thru all intervals
    		foreach ($intervals as $interval) {
	      		// Set default diff to 0
	      		$diffs[$interval] = 0;
	      		// Create temp time from time1 and interval
      			$ttime = strtotime("+1 " . $interval, $time1);
      			// Loop until temp time is smaller than time2
      			while ($time2 >= $ttime) {
				$time1 = $ttime;
				$diffs[$interval]++;
				// Create new temp time from time1 and interval
				$ttime = strtotime("+1 " . $interval, $time1);
      			}
    		}
 
    		$count = 0;
    		$times = array();
    		// Loop thru all diffs
    		foreach ($diffs as $interval => $value) {
      		// Break if we have needed precission
      			if ($count >= $precision) {
				break;
      			}
      			// Add value and interval 
      			// if value is bigger than 0
      			if ($value > 0) {
				// Add s if value is not 1
				if ($value != 1) {
	  				$interval .= "s";
				}
				// Add value and interval to times array
				$times[] = $value;
				$count++;
      			}else{
      				$times[] = $value;
				$count++;
      			}
    		}
 
    		// Return string with times
    		return $times;
  	}
  	
  	function getMinuteFromTime($tm) {  		
  		$hasil = (intval($tm[2])*1440 + $tm[3]*60) + ($tm[4] + ($tm[5]/60));  		
  		//$hasil = (($tm[2])*1440 + $tm[3]*60) + ($tm[4] + ($tm[5]/60));  		
		return $hasil;
	}
	
	// Time format is UNIX timestamp or
  	// PHP strtotime compatible strings
  	function dateDiff($time1, $time2, $precision = 6) {
    		// If not numeric then convert texts to unix timestamps
    		if (!is_int($time1)) {
      			$time1 = strtotime($time1);
    		}
    		if (!is_int($time2)) {
      			$time2 = strtotime($time2);
    		}
 
    		// If time1 is bigger than time2
    			// Then swap time1 and time2
    		if ($time1 > $time2) {
      			$ttime = $time1;
      			$time1 = $time2;
      			$time2 = $ttime;
    		}
 
    		// Set up intervals and diffs arrays
    		$intervals = array('year','month','day','hour','minute','second');
    		//$intervals = array('thn','bln','hari','jam','menit','dtk');
    		$diffs = array();
 
    		// Loop thru all intervals
    		foreach ($intervals as $interval) {
	      		// Set default diff to 0
	      		$diffs[$interval] = 0;
	      		// Create temp time from time1 and interval
      			$ttime = strtotime("+1 " . $interval, $time1);
      			// Loop until temp time is smaller than time2
      			while ($time2 >= $ttime) {
				$time1 = $ttime;
				$diffs[$interval]++;
				// Create new temp time from time1 and interval
				$ttime = strtotime("+1 " . $interval, $time1);
      			}
    		}
 
    		$count = 0;
    		$times = array();
    		// Loop thru all diffs
    		foreach ($diffs as $interval => $value) {
      		// Break if we have needed precission
      			if ($count >= $precision) {
				break;
      			}
      			// Add value and interval 
      			// if value is bigger than 0
      			if ($value > 0) {
				// Add s if value is not 1
				if ($value != 1) {
	  				$interval .= "s";
				}
				// Add value and interval to times array
				$times[] = $value . " " . $interval;
				$count++;
      			}
    		}
 
    		// Return string with times
    		return $times;
  	}
	
	function getTimeFromMinute($tm) {
  		$hasil = 0;
  		$hasil = ($tm / 1440);
  		#echo "Hari = ".  $hasil."<br>";
  		// hari
  		if($hasil >= 1){
  			if(intval($hasil) > 1)
  				$result = intval($hasil).' days ';
  			else
  				$result = intval($hasil).' day ';
  			if($hasil <= 0){
				return $result;
			}			
  		}
  		  		
  		// jam
  		$hasil = ($hasil - intval($hasil)) * 24;
		if($hasil <= 0)
			return $result;
  		#echo "Jam = ".  $hasil."<br>";
  		if($hasil >= 1){
  			if(intval($hasil) > 1)
  				$result .= intval($hasil).' hours ';
  			else
  				$result .= intval($hasil).' hour ';   			
  			if($hasil <= 0)
				return $result; 			
  		}
  		  		
  		// menit
  		$hasil = ($hasil - intval($hasil)) * 60;
		if($hasil <= 0)
			return $result;
  		#echo "Menit = ".  $hasil."<br>";
  		if($hasil >= 1){
  			if(intval($hasil) > 1)
  				$result .= intval($hasil).' minutes ';
  			else
  				$result .= intval($hasil).' minute ';  			
  			if($hasil <= 0)
				return $result; 			
  		}
  		  		
  		
  		// detik
  		$hasil = ($hasil - intval($hasil)) * 60;
		if($hasil <= 0)
			return $result;
  		#echo "Detik = ".  $hasil."<br>";
  		if($hasil >= 1){
  			if(intval($hasil) > 1)
  				$result .= round($hasil,2).' seconds ';
  			else
  				$result .= round($hasil,2).' second ';  			
  		}
		return ($result=='' ? '-' : $result);
	}
	
	function getTimeFromMinute2($tm) {
  		$hasil = 0;
  		$hasil = ($tm / 1440);
  		#echo "Hari = ".  $hasil."<br>";
  		$h = 0;
  		// hari
  		if($hasil >= 1){
  			/*if(intval($hasil) > 1)
  				$result = intval($hasil).' days ';
  			else
  				$result = intval($hasil).' day ';
  			if($hasil <= 0){
				return $result;
			}*/
			$h = 24;			
  		}else{
  		}
  		  		
  		// jam
  		$hasil = ($hasil - intval($hasil)) * 24;
		if($hasil <= 0)
			return $result;
  		#echo "Jam = ".  $hasil."<br>";
  		if($hasil >= 1){
  			$hasil = $hasil+$h;
			if($hasil < 10)
				$result .= '0'.intval($hasil).':';
			else
				$result .= intval($hasil).':';		
		
  			if($hasil <= 0){
  				$result .= '00:00';
				return $result;
			}
  		}else{
  			$result .= '00:';
  		}
  		  		
  		// menit
  		$hasil = ($hasil - intval($hasil)) * 60;
		if($hasil <= 0){
			$result .= '00:00';
			return $result;
		}
			
  		#echo "Menit = ".  $hasil."<br>";
  		if($hasil >= 1){
			if($hasil < 10)
				$result .= '0'.intval($hasil).':';
			else
				$result .= intval($hasil).':';
  			
  			if($hasil <= 0){
  				$result .= '00';
				return $result.':00'; 			
			}
  		}else{
  			$result .= '00:';
  		}
  		 
  		
  		
  		// detik
  		$hasil = ($hasil - intval($hasil)) * 60;  		
		if($hasil <= 0){
			$result .= '00';
			return $result;
		}
		
			
  		#echo "Detik = ".  $hasil."<br>";
  		if($hasil >= 1){
  			if($hasil < 10)
  				$result .= '0'.round($hasil,2);
  			else
  				$result .= round($hasil,2);  			
  				
  			if($hasil <= 0){
  				$result .= '00';
				return $result.':00'; 			
			}
  		}
		return ($result =='' ? '-' : $result);
	}
	
	// START CPU STAT
	
	function checkos()
	{
	    if (substr(PHP_OS, 0, 3) == "WIN")
	    {
	        $osType = $this->winosname();
	        $osbuild = php_uname('v');
	        $os = "windows";
	    } elseif (PHP_OS == "FreeBSD")
	    {
	        $os = "nocpu";
	        $osType = "FreeBSD";
	        $osbuild = php_uname('r');
	    } elseif (PHP_OS == "Darwin")
	    {
	        $os = "nocpu";
	        $osType = "Apple OS X";
	        $osbuild = php_uname('r');
	    } elseif (PHP_OS == "Linux")
	    {
	        $os = "linux";
	        $osType = "Linux";
	        $osbuild = php_uname('r');
	    }
	    else
	    {
	        $os = "nocpu";
	        $osType = "Unknown OS";
	        $osbuild = php_uname('r');
	    }
	    return $osType;
	}
	
	function winosname()
	{
	    $wUnameB = php_uname("v");
	    $wUnameBM = php_uname("r");
	    $wUnameB = eregi_replace("build ", "", $wUnameB);
	    if ($wUnameBM == "5.0" && ($wUnameB == "2195"))
	    {
	        $wVer = "Windows 2000";
	    }
	    if ($wUnameBM == "5.1" && ($wUnameB == "2600"))
	    {
	        $wVer = "Windows XP";
	    }
	    if ($wUnameBM == "5.2" && ($wUnameB == "3790"))
	    {
	        $wVer = "Windows Server 2003";
	    }
	    if ($wUnameBM == "6.0" && (php_uname("v") == "build 6000"))
	    {
	        $wVer = "Windows Vista";
	    }
	    if ($wUnameBM == "6.0" && (php_uname("v") == "build 6001"))
	    {
	        $wVer = "Windows Vista SP1";
	    }
	    return $wVer;
	}
	
	function ZahlenFormatieren($Wert)
	{
	    if ($Wert > 1099511627776)
	    {
	        $Wert = number_format($Wert / 1099511627776, 2, ".", ",") . " TB";
	    } elseif ($Wert > 1073741824)
	    {
	        $Wert = number_format($Wert / 1073741824, 2, ".", ",") . " GB";
	    } elseif ($Wert > 1048576)
	    {
	        $Wert = number_format($Wert / 1048576, 2, ".", ",") . " MB";
	    } elseif ($Wert > 1024)
	    {
	        $Wert = number_format($Wert / 1024, 2, ".", ",") . " KB";
	    }
	    else
	    {
	        $Wert = number_format($Wert, 2, ".", ",") . " Bytes";
	    }
	
	    return $Wert;
	}		
	
	function getStat($_statPath)
        {
            	if (trim($_statPath) == ''){
                	$_statPath = '/proc/stat';
            	}

            	ob_start();
            	passthru('cat ' . $_statPath);
            	$stat = ob_get_contents();
            	ob_end_clean();
		
            	if (substr($stat, 0, 3) == 'cpu'){
                	$parts = explode(" ", preg_replace("!cpu +!", "", $stat));
            	}
            	else{
                	return false;
            	}

            	$return = array();
            	$return['user'] = $parts[0];
            	$return['nice'] = $parts[1];
            	$return['system'] = $parts[2];
            	$return['idle'] = $parts[3];
            	return $return;
        }

        function getCpuUsage($_statPath = '/proc/stat')
        {
            	$time1 = $this->getStat($_statPath) or die("getCpuUsage(): couldn't access STAT path or STAT file invalid\n");
            	sleep(1);
            	$time2 = $this->getStat($_statPath) or die("getCpuUsage(): couldn't access STAT path or STAT file invalid\n");

            	$delta = array();

            	foreach ($time1 as $k => $v)
            	{
                	$delta[$k] = $time2[$k] - $v;
            	}

            	$deltaTotal = array_sum($delta);
            	$percentages = array();

            	foreach ($delta as $k => $v)
            	{
                	$percentages[$k] = round($v / $deltaTotal * 100, 2);
            	}
            	return $percentages;
        }
        
        // ======================================== \
        // Package: Mihalism Multi Host
        // Version: 5.0.0
        // Copyright (c) 2007, 2008, 2009 Mihalism Technologies
        // License: http://www.gnu.org/licenses/gpl.txt GNU Public License
        // LTE: 1253476748 - Sunday, September 20, 2009, 03:59:08 PM EDT -0400
        // ======================================== /
       
        // ======================================== \
        // Written by: Mihalism Technologies (www.mihalism.net)
        // Contributions by: Michael Manley (mmanley@nasutek.com)
        //
        // Unix/Linux Functions based off: Debian GNU/Linux 5.0
        // Mac OS X (Darwin) Functions based off: Mac OS X 10.5.8 (9L30)
        // Windows Operating System Functions based off: Windows XP Professional (Service Pack 3)
        // ======================================== /
       
        // Running Processes       
        
        function _get_processes()
        {
                $command = ((IS_WINDOWS_OS == true) ? "tasklist" : "top -b -n 1");
                       
                $topinfo = @shell_exec($command);
               
                return (($topinfo === false) ? false : trim($topinfo));
        }

        // Disk Space Information	
        function _get_diskspace_info()
        {
                // Check root file system (if possible) to get total system
                // usage, but some hosts jail us in, so let us check options.
               
                $root_path = ((IS_WINDOWS_OS == true) ? "C:" : "/");
               
                $check_path = ((PHP_IS_JAILED == true || is_readable($root_path) == false) ? "." : $root_path);
               
                $free_space = disk_free_space($check_path);
                $total_space = disk_total_space($check_path);
               
                if (is_float($free_space) == false || is_float($total_space) == false) {
                        return false;  
                } else {
                        $used_space = ($total_space - $free_space);
                       
                        return array(
                                "used" => $used_space,
                                "free" => $free_space,
                                "total" => $total_space,
                        );
                }
        }
       
        // Memory Information       
        
        function _get_memory_info()
        {
                if (IS_WINDOWS_OS == true) {
                        $obj = new COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');
                               
                        foreach ($obj->instancesof("Win32_ComputerSystem") as $mp) {
                                $ram_total = $mp->TotalPhysicalMemory;
                                       
                                break;
                        }
                               
                        foreach ($obj->instancesof("Win32_OperatingSystem") as $mp) {
                                $ram_free = $mp->FreePhysicalMemory;
                                $swap_free = $mp->FreeVirtualMemory;
                                $swap_total = $mp->TotalVirtualMemorySize;
                               
                                $swap_used = ($swap_total - $swap_free);
                                $ram_used = ($ram_total - ($ram_free * 1024));
                               
                                break;
                        }
                } elseif (IS_DARWIN_OS == true) {
                        $ram_info = @shell_exec("sysctl hw.memsize");
                       
                        if ($ram_info === false) {
                                return false;
                        } else {
                                $ram_info = explode(" ", $ram_info);
                               
                                $ram_total = (int)$ram_info['1'];
                        }
                       
                        $ram_info = @shell_exec("vm_stat");
                       
                        if ($ram_info === false) {
                                return false;
                        } else {
                                preg_match("#Pages free:\s+([^\n]+)\.\n#", $ram_info, $matches);
                               
                                if (isset($matches['1']) == false) {
                                        return false;  
                                } else {
                                        $ram_free = ((int)$matches['1'] * 4096);
                                       
                                        $ram_used = ($ram_total - $ram_free);
                                }
                        }
                       
                        $swap_info = @shell_exec("sysctl vm.swapusage");
                       
                        if ($swap_info === false) {
                                return false;
                        } else {
                                preg_match_all("#([a-zA-Z0-9]+) = ([^M]+)#i", $swap_info, $matches);
                               
                                $variable_names = array("total" => "swap_total", "free" => "swap_free");
                               
                                foreach ($matches['1'] as $id => $value) {
                                        if (array_key_exists($value, $variable_names) == true) {
                                                $variable_name = $variable_names[$value];
                                                $$variable_name = ($matches['2'][$id] * 1048576);
                                        }
                                }
                               
                                $swap_used = ($swap_total - $swap_free);
                        }
                } else {
                        $ram_usage = @shell_exec("cat /proc/meminfo");
                       
                        if ($ram_usage === false) {
                                return false;
                        } else {
                                $variable_names = array("SwapTotal:" => "swap_total", "SwapFree:" => "swap_free", "MemTotal:" => "ram_total", "MemFree:" => "ram_free", "Buffers:" => "ram_buffers", "Cached:" => "ram_cached");
                                       
                                preg_match_all("#([^\s]+)\s+([0-9]+)\s*kB\n#i", $ram_usage, $ram_info);
                       
                                foreach ($ram_info['1'] as $id => $value) {
                                        if (array_key_exists($value, $variable_names) == true) {
                                                $variable_name = $variable_names[$value];
                                                $$variable_name = ($ram_info['2'][$id] * 1024);
                                        }
                                }
               
                                $ram_free = ($ram_free + $ram_cached + $ram_buffers);
                                $ram_used = ($ram_total - $ram_free);
                               
                                $swap_used = ($swap_total - $swap_free);
                        }
                }
               
                if (isset($ram_total, $ram_free, $swap_free, $swap_total) === false) {
                        return false;
                } else {
                        return array(
                                "ram" => array(
                                        "free" => $ram_free,
                                        "used" => $ram_used,
                                        "total" => $ram_total,
                                ),
                               
                                "swap" => array(
                                        "free" => $swap_free,
                                        "used" => $swap_used,
                                        "total" => $swap_total,
                                ),
                        );
                }
        }      
       
        // Uptime Information       
        function _get_uptime_info()
        {
                if (IS_WINDOWS_OS == true) {
                        $upsince = @filemtime("C:\pagefile.sys");
                       
                        if ($upsince === false) {
                                return false;
                        } else {
                                $total_uptime = round(((time() - $upsince) / 86400), 1);
                        }
                } elseif (IS_DARWIN_OS == true) {
                        $uptime_info = @shell_exec("sysctl -n kern.boottime");
                       
                        if ($uptime_info === false) {
                                return false;
                        } else {
                                preg_match("#sec = ([0-9]{10})#", $uptime_info, $matches);
                               
                                if (isset($matches['1']) === false) {
                                        return false;  
                                } else {
                                        $uptime_data = (time() - (int)$matches['1']);
                                       
                                        $total_uptime = round(($uptime_data / 86400), 1);
                                }
                        }
                } else {
                        $uptime_info = @shell_exec("cat /proc/uptime");
                       
                        if ($uptime_info === false) {
                                return false;
                        } else {
                                $uptime_data = explode(" ", $uptime_info, 2);
                                 
                                $total_uptime = round(($uptime_data['0'] / 86400), 1);
                        }
                }
               
                return (int)$total_uptime;
        }
       
        // Processor (CPU) Information
        
        function _get_cpu_info()
        {
                if (IS_WINDOWS_OS == true) {
                        $obj = new COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');
                               
                        foreach ($obj->instancesof("Win32_Processor") as $mp) {
                                $cpu_model = $mp->Name;
                                $cpu_speed = $mp->CurrentClockSpeed;
                                $cpu_usage = array($mp->LoadPercentage);
                                       
                                break;
                        }
                } elseif (IS_DARWIN_OS == true) {
                        $cpu_info = @shell_exec("uptime");
                       
                        if ($cpu_info === false) {
                                return false;
                        } else {
                                preg_match("#load averages: (.*)#i", $cpu_info, $matches);
                               
                                if (isset($matches['1']) === false) {
                                        return false;
                                } else {
                                        $cpu_usage = explode(" ", $matches['1']);
                                }
                        }
                       
                        $cpu_info = @shell_exec("system_profiler SPHardwareDataType");
                       
                        if ($cpu_info === false) {
                                return false;
                        } else {
                                $variable_names = array("Processor Name" => "cpu_model", "Processor Speed" => "cpu_speed");
                       
                                preg_match_all("#\s+([^\:]+):\s([^\n]+)\n#", $cpu_info, $matches);
                               
                                foreach ($matches['1'] as $id => $value) {
                                        if (array_key_exists($value, $variable_names) == true) {
                                                $variable_name = $variable_names[$value];
                                                $$variable_name = $matches['2'][$id];
                                        }
                                }
                               
                                $cpu_speed = str_replace(" GHz", NULL, $cpu_speed);
                        }
                } else {
                        $cpu_info = @shell_exec("cat /proc/loadavg");
                       
                        if ($cpu_info === false) {
                                return false;
                        } else {
                                $cpu_usage = explode(" ", $cpu_info, 4);
                        }
                       
                        $cpu_info = shell_exec("cat /proc/cpuinfo -T");
                       
                        if ($cpu_info === false) {
                                return false;
                        } else {
                                $variable_names = array("model name" => "cpu_model", "cpu MHz" => "cpu_speed");
                                       
                                $cpu_info = str_replace("^I", NULL, $cpu_info);
                               
                                preg_match_all("#([^:]+):\s([^\n]+)\n#i", $cpu_info, $cpu_minfo);
                               
                                foreach ($cpu_minfo['1'] as $id => $value) {
                                        if (array_key_exists($value, $variable_names) == true) {
                                                $variable_name = $variable_names[$value];
                                                $$variable_name = $cpu_minfo['2'][$id];
                                        }
                                }
                               
                                $cpu_speed = @number_format(round(($cpu_speed / 1000), 2), 2);
                        }
                }              
               
                if (isset($cpu_speed, $cpu_model, $cpu_usage) === false) {
                        return false;  
                } else {
                        return array(
                                "load" => $cpu_usage,
                                "model" => $cpu_model,
                                "speed" => $cpu_speed,
                        );
                }
        }
       
        // Operating System Information              
        function _get_system_name()
        {
			if (IS_WINDOWS_OS == true) {
					$obj = new COM('winmgmts:{impersonationLevel=impersonate}//./root/cimv2');
						   
					foreach ($obj->instancesof("Win32_OperatingSystem") as $mp) {
							$system_version = $mp->Caption;
								   
							break;
					}
			} elseif (IS_DARWIN_OS == true) {
				$version_info = @shell_exec("system_profiler SPSoftwareDataType");							   
				if ($version_info === false) 
				{
						return false;
				} 
				else 
				{
					preg_match("#System Version: ([^\n]+)#i", $version_info, $matches);
				   
					if (isset($matches['1']) === false) {
							return false;
					} else {
							$system_version = $matches['1'];
					}
				}
			} 
			else 
			{
				$version_info = @shell_exec("cat /etc/issue");
			   
				if ($version_info === false) {
						return false;
				} else {
						$system_version = str_replace(array("\\n", "\\l"), NULl, trim($version_info));
				}
			}
			return ((isset($system_version) === false) ? false : (string)$system_version);
        }        
   
	/* CONTOH nge-ping
	# check our website http://www.example.com is up and running (port 80) and timeout after 20 seconds
	$ok = ping('www.example.com',80,20);
	# make sure our mail server is up (POP 3 uses port 110)
	$ok = ping('mail.example.com',110,20);
	*/
	function ping($host,$port=80,$timeout=6)
	{
		$fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
		if ( ! $fsock )
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	// END CPU STAT
}
?>
