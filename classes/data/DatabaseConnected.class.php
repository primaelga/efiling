<?php

/*
Penggunaan variabel global tidak dibenarkan pada prinsip OOP.
Namun variabel ini digunakan untuk mengatasi kekurangan
PHP 4 dalam implementasi OOP . Pada PHP 5 sudah terdapat keyword static untuk
menandakan suatu property bersifat static.
Static dibutuhkan untuk mengimplementasikan pattern singleton. Karena PHP 4
tidak memiliki keyword static, maka digunakan variabel global
untuk implementasinya.
*/
$GLOBALS['DatabaseConnected::databaseConnection'] = NULL;
class DatabaseConnected
{
    	/**
    	* Config Object
    	*
    	* @var object 
    	*/
    	var $mrConfig;
    	/**
    	* SQL Queries used in this class
    	*
    	* @var array 
    	*/
    	var $mSqlQueries;
    	/**
    	* ADO Database Connection objects
    	*
    	* @var object
    	*/
    	var $mrDbConnection;
    	/**
     	* DatabaseConnected::DatabaseConnected()
     	* DatabaseConnected constructor
     	* @param $configObject
     	* @param $sqlFile
     	* @return
     	*/
     	
    	function DatabaseConnected(&$configObject, $sqlFile)
    	{
    		//print_r($configObject);
			
      		$this->mrConfig = &$configObject;
      		if ($GLOBALS['DatabaseConnected::databaseConnection'] == NULL){      			
        		global $ADODB_FETCH_MODE;
        		$ADODB_FETCH_MODE = 2;        		        		
        		$dbtype = $this->mrConfig->GetValue('db_type');								
        		$GLOBALS['DatabaseConnected::databaseConnection'] =& ADONewConnection($dbtype);        		
        		$dbhost = $this->mrConfig->GetValue('db_host');
        		$dbuser = $this->mrConfig->GetValue('db_user');
        		$dbname = $this->mrConfig->GetValue('db_name');
        		$dbpass = $this->mrConfig->GetValue('db_pass');				
        	
				$GLOBALS['DatabaseConnected::databaseConnection']->Connect($dbhost,$dbuser,$dbpass,$dbname);
        		$this->mrDbConnection = &$GLOBALS['DatabaseConnected::databaseConnection'];				
      		} 
			else 
			{
        		$this->mrDbConnection = &$GLOBALS['DatabaseConnected::databaseConnection'];        		
      		}		
			
      		$sql_file = $this->mrConfig->GetValue('docroot') . "sql/".$this->mrConfig->GetValue('db_type') . "/" . $sqlFile;      		
			
      		if (file_exists($sql_file)){
        		require $sql_file;
        		$this->mSqlQueries = $sql;
      		} else {
        		die("Required file '" . $sql_file . "' not found!");
      		}
    	}
    	
    	/**
     	* DatabaseConnected::setConfig()
     	* set the configuration object
     	* @param $configObject
     	* @return
     	*/
    	function setConfig($configObject){
      		$this->mrConfig = $configObject;
    	}


    	/**
     	* DatabaseConnected::getAllDataAsArray()
     	* get all data as array
     	* @param $sql
     	* @param $params
     	* @return
     	*/
    	function getAllDataAsArray($sql,$params)
    	{
      		$sql_parsed = "";
      		$param_serialized = join("','",$params);
      		eval('$sql_parsed = sprintf("'.$sql.'",\''.$param_serialized.'\');');
      		if ($rs =$this->mrDbConnection->Execute($sql_parsed)){
        		$array = $rs->GetArray();
        		return $array;
      		} else {
        		return false;
      		}
    	}
    	
    	
	function dbSelectLimit($sql,$numrows=-1,$offset=-1,$errmsg="sql error")/*{{{*/
	{
	    	$rs = $this->mrDbConnection->SelectLimit($sql,$numrows,$offset);
	    	if ($rs == FALSE){
			if ($this->kcfg['debug_level'] == 1) 
				$errmsg .= " : $sql : " . $this->db->errormsg();
		      	if ($this->kcfg['soft_error'] == true){
		        	return $rs;
		      	}	
			$this->htmldie($errmsg);
		}
	    	return $rs;
	  }/*}}}*/
}
?>
