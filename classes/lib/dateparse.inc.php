<?php
/**
-----------------------------------------------------------------
Class to do date formatting for various database
<deon_tom@yahoo.com>,<the_black022001@yahoo.com>
designed to be directly called, so we must define the names first
-----------------------------------------------------------------
*/
class DateParse
{
	//mother language month names
	var $monthname = array(
										"none",     "Jan",   "Feb", "Mar",
										"Apr",    "Mei",       "June",     "July", 
										"Agust",  "Sept", "Okt",
										"Nop", "Des");
										
	//mother language month names
	var $monthnamelong = array(
										"none",     "Januari",   "Februari", "Maret",
										"April",    "Mei",       "Juni",     "Juli", 
										"Agustus",  "September", "Oktober",
										"Nopember", "Desember");

	//mother language weekday names
	var $dayname   = array(
										"Minggu","Senin","Selasa", "Rabu",
										"Kamis",  "Jum'at","Sabtu");

	/** iso date to string date */
	function isodate2string($isodate)/*{{{*/
	{
		$tmp_date=explode("-", $isodate);
		$bln = (int) ($tmp_date[1]*1);
		$tanggal = "$tmp_date[2] {$this->monthname[$bln]} $tmp_date[0]";
		return $tanggal;
	}/*}}}*/
	
	/** iso date to string date versi indonesia */
	/** request alias kahayang mcu **/
	function isodate2stringina($isodate)/*{{{*/
	{
		$tmp_date=explode("-", $isodate);
		$bln = (int) ($tmp_date[1]*1);
		$tanggal = "$tmp_date[2] {$this->monthnamelong[$bln]} $tmp_date[0]";
		return $tanggal;
	}/*}}}*/
	
	//$this->dayname[0];

  function isodate2date($isodate)/*{{{*/
  {
    if ($isodate == '') return '';
		$tmp_date=explode("-", $isodate);
		$bln = (int) ($tmp_date[1]*1);
		$tanggal = "$tmp_date[2] ".substr($this->monthname[$bln],0,3)." $tmp_date[0]";
		return $tanggal;
  }/*}}}*/

	/** db time stamp to string */
	function dbtstamp2string($dbtstamp)/*{{{*/
	{
		$s = explode(" ",$dbtstamp);
		return $this->isodate2string($s[0]);
	}/*}}}*/
	
	/** db time stamp to string versi indonesia */
	/** request alias kahayang mcu **/
	function dbtstamp2stringina($dbtstamp)/*{{{*/
	{
		$s = explode(" ",$dbtstamp);
		return $this->isodate2stringina($s[0]);
	}/*}}}*/


	/** db time stamp to string and hour:minute:second */
	function dbtstamp2stringlong($dbtstamp, $br=" ")/*{{{*/
	{
		$s = explode(" ",$dbtstamp);
		$t = explode(':',$s[1]);
		$u = explode('.',$t[2]);
		return $this->isodate2string($s[0]) .$br. "{$t[0]}:{$t[1]}:{$u[0]}";
	}/*}}}*/

	function dbtstamp2stringtime($dbtstamp)/*{{{*/
	{
		if($dbtstamp=='') return;
		$s = explode(" ",$dbtstamp);
		$t = explode(':',$s[1]);
		$u = explode('.',$t[2]);
		return "{$t[0]}:{$t[1]}:{$u[0]}";
	}/*}}}*/

	function dbtstamp2europedate($dbtstamp)/*{{{*/
	{
		$s = explode(" ",$dbtstamp);
    if ($s[0] == '') return '';
		$tmp_date=explode("-", $s[0]);
		$bln = (int) ($tmp_date[1]*1);
		$tanggal = "{$tmp_date[2]}/$bln/{$tmp_date[0]}";
    return $tanggal;
	}/*}}}*/

	function dbtstamp2europedatelong($dbtstamp)/*{{{*/
	{
		$s = explode(" ",$dbtstamp);
    if ($s[0] == '') return '';
		$t = explode(':',$s[1]);
		$u = explode('.',$t[2]);
		$tmp_date=explode("-", $s[0]);
		$bln = (int) ($tmp_date[1]*1);
		$tanggal = "{$tmp_date[2]}/$bln/{$tmp_date[0]} {$t[0]}:{$t[1]}";
    return $tanggal;
	}/*}}}*/

	/** start - end week date, relative to current month, return (array)isodate */
	function start_end_wdate($weekoffset)/*{{{*/
	{
		$currtime  = getdate();
		$tnow      = time();
		$startwday = $currtime["mday"] - $currtime["wday"] - 1;
		$endwday   = $currtime["mday"] + 7 - $currtime["wday"] + 1;

		if ($weekoffset >= 0) $tmpdate = $endwday;
		else $tmpdate = $startwday;

		$tdate     = mktime($currtime["hours"],$currtime["minutes"],$currtime["seconds"],$currtime["mon"],$tmpdate + ($weekoffset*7),$currtime["year"]);

		$tout = array();
		$tout[0] = ($tdate > $tnow) ? $tnow : $tdate;
		$tout[1] = ($tdate <= $tnow) ? $tnow : $tdate;
		$tout[0] = date("Y-m-d",$tout[0]);
		$tout[1] = date("Y-m-d",$tout[1]);
		return $tout;
	}/*}}}*/

	function get_combo_option_hour($curhour='')/*{{{*/
  {
    $str = '';
    for ($i=0;$i<24;$i++)
    {
	  $i = str_pad($i, 2, "0", STR_PAD_LEFT);  
      if ($i == $curhour) $sel = 'selected';
      else $sel = '';
      $str .= "<option value='$i' $sel>$i</option>\r\n";
    }
    return $str;
  }/*}}}*/

	function get_combo_option_minute($curmin='')/*{{{*/
  {
    $str = '';
    for ($i=0;$i<60;$i++)
    {
	  $i = str_pad($i, 2, "0", STR_PAD_LEFT);  
      if ($i == $curmin) $sel = 'selected';
      else $sel = '';
      $str .= "<option value='$i' $sel>$i</option>\r\n";
    }
    return $str;
  }/*}}}*/

  function get_combo_option_date($curdate='')/*{{{*/
  {
    $str = '';
    for ($i=1;$i<32;$i++)
    {
      if ($i == $curdate) $sel = 'selected';
      else $sel = '';
      $str .= "<option value='$i' $sel>$i</option>\r\n";
    }
    return $str;
  }/*}}}*/

  function get_combo_option_month($curmonth='')/*{{{*/
  {
    $str = '';
    for ($i=1;$i<13;$i++)
    {
      if ($i == $curmonth) $sel = 'selected';
      else $sel = '';
      $str .= "<option value='$i' $sel>$i</option>\r\n";
    }
    return $str;
  }/*}}}*/

 function get_combo_option_day($curday='')/*{{{*/
  {
    $str = '';
    for ($i=0;$i<7;$i++)
    {
      if ($i == $curday) $sel = 'selected';
      else $sel = '';
			$str .= "<option value='$i' $sel>{$this->dayname[$i]}</option>\r\n";
    }
    return $str;
  }/*}}}*/

  function get_combo_option_year($curyear,$startyear, $endyear)/*{{{*/
  {
    $str = '';
    for ($i=$startyear;$i<=$endyear;$i++)
    {
      if ($i == $curyear) $sel = 'selected';
      else $sel = '';
      $str .= "<option value='$i' $sel>$i</option>\r\n";
    }
    return $str;
  }/*}}}*/

  function get_combo_option_month_long($curmonth='')/*{{{*/
  {
    $str = '';
		$monthnm = array(
										"none",     "Jan",   "Feb", "Mar",
										"Apr",    "Mei",       "Jun",     "Jul", 
										"Agust",  "Sept", "Okt",
										"Nop", "Des");
    for ($i=1;$i<13;$i++)
    {
      if ($i == $curmonth) $sel = 'selected';
      else $sel = '';
			$month_nm = $monthnm[$i];
      $str .= "<option value='$i' $sel>$month_nm</option>\r\n";
    }
    return $str;
  }/*}}}*/

  function iddate2isodate ($str)/*{{{*/
  {
    $arr = explode('-',$str);
    return "{$arr[2]}-{$arr[1]}-{$arr[0]}";
  }/*}}}*/

  /** return array berisi idx id minggu dari 1-52,sesuai pgsql
    ret array(starttstamp,endtstamp) */
  function get_array_week ($year, $format='V')/*{{{*/
  {
    //find first date of week 1
    for ($i=1; $i<8; $i++)
    {
      if (strftime('%'.$format,mktime(0,0,0,1,$i,$year))=='01') break;
    }
    $tm = mktime(0,0,0,1,$i,$year);
    $j = 1;
    for ($n=$i;$n<=366;$n+=7)
    {
      $weeknum = intval(strftime('%'.$format,$tm));
      if (($weeknum == 1) && ($n > 14)) break; //lebih,weeknya masuk next year
      $tm2 = $tm + (86400*6);
      $ret[$weeknum] = array($tm, $tm2);
      $tm = $tm2 + 86400;
    }

    //bugs on old PHP ...
    if (count($ret) < 14 && $format != 'W')
    {
      return dateparse::get_array_week($year, 'W');
    }

    return $ret;
  }/*}}}*/

  
}
?>
