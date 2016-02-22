<?php
	/**
		* GateKeeper
		*
		* @package security
		* @file GateKeeper.class.php
		* @author 		
		* @version 1.0
		* @access public 
		*/

class GateKeeper extends DatabaseConnected
{

  	/**
	* session management object
	*
	* @var SessionManagement mSessionObject
	**/
	var $mSessionObject;
	var $mUserLoginId;

 	 /**
	* GateKeeper::GateKeeper()
	* GetKepper Constructor
	*
	* @param  $databaseConnection
	* @param  $configObject
	* @param  $sessionObject
	* @return
	**/
	function GateKeeper(&$config_object, &$session_object)
	{
		//echo $session_object;
		$this->mSessionObject = $session_object;
		//$this->mLanguageId = 'en';
		$this->mLanguageId = 'id';
		$this->mLanguageDir = 'ltr';
		//$this->mSessionObject->startSession();
		
		DatabaseConnected::DatabaseConnected($config_object, 'security.sql.php');
		//$this->mrDbConnection->debug = true;
	}

  	/**
	* GateKeeper::authenticate()
	*
	* @param  $user_name
	* @param  $password
	* @return boolean, true if authenticated or false if not
	**/
	
	function po_custom()
	{
		
		$sql = sprintf($this->mSqlQueries['select_po_custom']);
		
		if ($rs = $this->mrDbConnection->Execute($sql))
		{	
			//print_r($rs->getArray());			
			return $rs->getArray();
		}
		
	}
	
	function authenticate($user_name, $password)
	{	
		
		//$password = md5($password);
		$sql = sprintf($this->mSqlQueries['select_user_where_user_password'],$user_name, $password);
		
		
		if ($rs = $this->mrDbConnection->Execute($sql))
		{	
			//print_r($rs->getArray());
			
			if (1 == $rs->RecordCount())
			{
				$array = $rs->FetchRow();				
				$user_identity = new UserIdentity();				
				$user_identity->setUserId($array['user_id']);
				$user_identity->setRealName($array['real_name']);
				$user_identity->setUserPhoto($array['photo']);
				$user_identity->setPID($array['pid']);
				//if($array['user_id']!='administrator'){
					$user_identity->setSgid($array['sgid']);
					$user_identity->setCoid($array['coid']);
					$_SESSION['company_id'] = $array['coid'];
					$user_identity->setShortConame($array['short_coname']);					
					$user_identity->setConame($array['coname']);
					//$_SESSION['company_name'] = $array['coname'];
					$user_identity->setIsWarehouse($array['is_warehouse']);
				//}
				/*else{
					$user_identity->setSgid($array['sgid']);
					$user_identity->setCoid('');
					$user_identity->setShortConame('All Company');
					$user_identity->setConame('All');
					$user_identity->setIsWarehouse('t');
				}*/
				$sql = sprintf($this->mSqlQueries['get_user_privileges_data'],$user_name);				
				if ($rs = $this->mrDbConnection->Execute($sql))
				{					
					while($row = $rs->FetchRow())
					{
						$read   = eregi('R', $row['user_privileges']);
						$add    = eregi('A', $row['user_privileges']);
						$update = eregi('U', $row['user_privileges']);
						$delete = eregi('D', $row['user_privileges']);
						//echo "<br>Strcmp = ".(strcmp($row['user_privileges'],'U'));
						//echo "<br>Privilage = ".$row['user_privileges']." Modeule = ".$row['module_id']." Read = ".$read." Add = ".$add." Update = ".$update." Delete = ".$delete;
						$user_identity->setPrivileges($row['module_id'], $read, $add, $update, $delete);
					}
					//exit;
					$this->mSessionObject->setVariable('user_identity', $user_identity);
					$this->mSessionObject->setVariable('user_subsystem', $this->getSubSystemList($user_name));
					//$this->mSessionObject->setVariable('user', $user_identity);
					return $user_identity;
				} else {
					return false;
				}

			} else {
				return false;
			}
		} else 
		{
			echo"gagal";
			return false;
		}
	}
	
	/**
	* GateKeeper::authenticate2()
	*
	* @param  $user_name
	* @param  $password
	* @return boolean, true if authenticated or false if not
	**/
	function authenticate2($user_name, $password, $coid)
	{
		$password = md5($password);
		$sql = sprintf($this->mSqlQueries['select_user_where_user_password'],$user_name, $password);
		if ($rs = $this->mrDbConnection->Execute($sql)){	
			//print_r($rs->getArray());
			if (1 == $rs->RecordCount())
			{
				$array = $rs->FetchRow();				
				$user_identity = new UserIdentity();				
				$user_identity->setUserId($array['user_id']);
				$user_identity->setRealName($array['real_name']);
				$user_identity->setUserPhoto($array['photo']);
				$user_identity->setSgid($array['sgid']);
				$user_identity->setCoid($array['coid']);
				$user_identity->setShortConame($array['short_coname']);
				$user_identity->setConame($array['coname']);
				$user_identity->setIsWarehouse($array['is_warehouse']);				
				$sql = sprintf($this->mSqlQueries['get_user_privileges_data'],$user_name);				
				if ($rs = $this->mrDbConnection->Execute($sql))
				{					
					if($array['coid']==0 && ($array['sgid']==2 || $array['sgid']==3 || $array['sgid']==5)){
					//if($array['coid']==0 && ($array['sgid']==2 || $array['sgid']==5)){					
						$user_identity->setCoid($coid);
						$coname = $this->getLoginConame($coid);
						$shortconame = $this->getLoginShortConame($coid);
						$user_identity->setShortConame($shortconame);
						$user_identity->setConame($coname);
						
						if($coid==5)
							$user_identity->setIsWarehouse('t');
						while($row = $rs->FetchRow())
						{
							$read   = eregi('R', $row['user_privileges']);
							//$add    = eregi('A', $row['user_privileges']);
							$update = eregi('U', $row['user_privileges']);
							//$delete = eregi('D', $row['user_privileges']);
							$user_identity->setPrivileges($row['module_id'], $read, $add, $update, $delete);
						}
					}
					else{
						/*while($row = $rs->FetchRow())
						{
							$read   = eregi('R', $row['user_privileges']);
							$add    = eregi('A', $row['user_privileges']);
							$update = eregi('U', $row['user_privileges']);
							$delete = eregi('D', $row['user_privileges']);
							$user_identity->setPrivileges($row['module_id'], $read, $add, $update, $delete);
						}*/
						return false;
					}
					//exit;
					$this->mSessionObject->setVariable('user_identity', $user_identity);
					$this->mSessionObject->setVariable('user_subsystem', $this->getSubSystemList($user_name));
					//$this->mSessionObject->setVariable('user', $user_identity);
					return $user_identity;
				} else {
					return false;
				}

			} else {
				return false;
			}
		} else {
			return false;
		}
	}

  /**
	* GateKeeper::deAuthenticate()
	*
	* @param
	* @return
	**/
	function deAuthenticate()
	{
		$this->mSessionObject->unsetVariable('user_identity');
		$this->mSessionObject->unsetVariable('user_subsystem');		
		$this->mSessionObject->unsetVariable('host');
		$this->mSessionObject->unsetVariable('username');
		$this->mSessionObject->unsetVariable('password');
		$this->mSessionObject->unsetVariable('admin');
		$this->mSessionObject->unsetVariable('home');
		$this->mSessionObject->unsetVariable('last_module');
	}
	
	function getUserHome($username)
	{
		//$this->mrDbConnection->debug = true;
		$sql = sprintf($this->mSqlQueries['get_user_home'], $username);
		$rs = $this->mrDbConnection->Execute($sql);
		$rs = $rs->FetchRow();
		//print_r($rs);
		//die();
		return $rs['module_id'];
	}
	
	
	
	function add()
	{	
		//$this->mrDbConnection->debug = true;
		$this->mrDbConnection->StartTrans();
		$this->mUserLoginId = $this->createId();
		setcookie('login_id',$this->mUserLoginId);
		$this->executeInsertQuery();
		$this->mrDbConnection->CompleteTrans();
	}
	
	function update()
	{	
		//$this->mrDbConnection->debug = true;
		/*$this->mrDbConnection->StartTrans();
		$this->executeUpdateQuery();
		$this->mrDbConnection->CompleteTrans();*/	
	}
	
	function insertUserLogin()
	{					
		$this->mSession = new SessionPHP();
		$this->mSession->startSession();
		$this->mUserIdentity = $this->mSession->getVariable('user_identity');
		
		$this->mrDbConnection->StartTrans();
		#$this->mrDbConnection->debug = true;
		$tgl =date('Y-m-d H:i:s');
		$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);	
		$sql = sprintf($this->mSqlQueries['insert_user_login'],$this->mUserIdentity->mUserId, $host);
		if ($ok = $this->mrDbConnection->Execute($sql)) {
			$sql = sprintf($this->mSqlQueries['update_user_login_lastin'],$tgl,$this->mUserIdentity->mUserId);
			if ($ok = $this->mrDbConnection->Execute($sql)) {				
				$this->mrDbConnection->CompleteTrans();
				return $ok;
			}
			else	{
				return false;
				$this->mrDbConnection->RollBackTrans();
			}
		} else {
			return false;
		}
		
		
	}
	
	function updateUserLogin()
	{
		$this->mSession = new SessionPHP();
		$this->mSession->startSession();
		$this->mUserIdentity = $this->mSession->getVariable('user_identity');
		
		$tgl =date('Y-m-d H:i:s');
		$sql = sprintf($this->mSqlQueries['update_user_login'],$tgl,$this->mUserIdentity->mUserId);
		if ($ok = $this->mrDbConnection->Execute($sql)) {
			$sql = sprintf($this->mSqlQueries['update_user_login_lastout'],$tgl,$this->mUserIdentity->mUserId);
			if ($ok = $this->mrDbConnection->Execute($sql)) {				
				$this->mrDbConnection->CompleteTrans();
				return $ok;
			}
			else	{
				return false;
				$this->mrDbConnection->RollBackTrans();
			}
		} else {
			return false;
		}
		
	}
	
	function createId()
	{
		$new_id = new IdCreatorDate($this->mrConfig, 'user_login_id_seq');
		return $new_id->getNewId();
	}
	
	function getSubSystemList($user_id)
	{												
		$x = $_SESSION['user_identity'];
		$userid = $x->mUserId;		
		
		
		if(!empty($userid)){
			$sql = "SELECT a.subsystem_id FROM sys_modules a 
			INNER JOIN sys_privileges b ON a.module_id = b.module_id
			WHERE b.user_id='{$user_id}' GROUP BY a.subsystem_id";
			if($rs = $this->mrDbConnection->Execute($sql))			
				return $rs->getArray();			
			else
				return false;
		}
		else{
			return false;
		}
	}
	
	function getLoginShortConame($coid){
		$sql = "SELECT short_name FROM company WHERE id='{$coid}' ";
		if($rs = $this->mrDbConnection->Execute($sql))			{
			$row = $rs->FetchRow();
			return $row['short_name'];			
		}
		else{
			return false;
		}
	}
	
	function getLoginConame($coid){
		$sql = "SELECT name FROM company WHERE id='{$coid}' ";
		if($rs = $this->mrDbConnection->Execute($sql))			{
			$row = $rs->FetchRow();
			return $row['name'];			
		}
		else{
			return false;
		}
	}
}
?>