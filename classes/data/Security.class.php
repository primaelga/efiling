<?php
  /**
   * Security
   *
   * @package security
   * @file Security.class.php
   * @author 
   * @version 1.0
   * @access public 
   */

	class Security
	{
		var $mUserIdentity;
		var $mSession;
		var $mConfig;

		/**
			* Security::Security()
			* Security class constructor
			* @param $user_identity
			* @return
			*/
		function Security($config_object)
		{
			$this->mConfig = $config_object;			
			$this->mSession = new SessionPHP();			
			$this->mSession->startSession();
			$this->mUserIdentity = $this->mSession->getVariable('user_identity');
			//$this->loadActivateMenu();			
		}
		
		
		function getUserIdentity()
		{
			return $this->mUserIdentity;
		}

		function setUserIdentity($user_identity)
		{
			$this->mSession->setVariable('user_identity',$user_identity);
		}

		/**
			* checkAccessRights()
			* Method for checking current user access rights
			* @param module_id
			* @return true if authenticated or false if not
			*/
		function checkAccessRights($module_id)
		{				
			if(isset($this->mUserIdentity) && !empty($this->mUserIdentity)) {				
				$privileges = $this->mUserIdentity->getPrivileges();
				//print_r( $privileges[$module_id]);				
				if($priv = $privileges[$module_id]) {
					//echo "<PRE>";
					//print_r($priv);
					//echo "</PRE>";
					//$load = microtime();
					//print_r ("this page load <b>".number_format($load,2)."</b> seconds<br>"); 										
					if($priv["read"] && $priv["add"] && $priv["update"] && $priv["delete"])$access_rights = true;					
					$_SESSION['last_module'] =$module_id;
					//print_r($_SESSION['last_module']);			
					return true;
				} else {
					$satpam = new GateKeeper($cfg, $sess);
					$satpam->executeUpdateQuery();	
					return false;
				}
			} else {
				return false;
			}
		}

		function denyPageAccess()
		{			
			/*if($this->mUserIdentity) {
				if (!empty($_SERVER['HTTP_REFERER'])){					
					header("Location: http".((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")?"s":"") ."://".$_SERVER['HTTP_HOST'].$this->mConfig->GetValue('basedir').'error/warning.php?from='.$_SERVER['HTTP_REFERER']);
				} 
				else{				
					header("Location: http" . ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")?"s":"")."://".$_SERVER['HTTP_HOST'].$this->mConfig->GetValue('basedir').'error/warning.php');
				} 
				exit();
			} else {				
				header("Location: http" . ((isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")?"s":"")
							."://".$_SERVER['HTTP_HOST'].$this->mConfig->GetValue('basedir').'error/noenter.php');								
				exit();
			}*/
			header('Content-type: text/javascript; charset=UTF-8');
			if($this->mUserIdentity) {
				//echo"<script type='text/javascript'>$(function() {$.ajax({type: 'POST',url: '".$this->mConfig->GetValue('basedir')."error/warning.php',: '',success: function(html){$('#error_popup').html(html);}});});</script>";				
				echo"
					$(function() {
						//$('#error_popup').load('".$this->mConfig->GetValue('basedir')."error/noenter.php');		
						$.ajax({			
							type: 'POST',
							url: '".$this->mConfig->GetValue('basedir')."error/warning.php',
							data: '',
							success: function(html){
								$('#error_popup').html(html);					
							}
						});
					});
				";
			}
			else{
				echo"
					$(function() {
						//$('#error_popup').load('".$this->mConfig->GetValue('basedir')."error/noenter.php');		
						$.ajax({			
							type: 'POST',
							url: '".$this->mConfig->GetValue('basedir')."error/noenter.php',
							data: '',
							success: function(html){
								$('#error_popup').html(html);					
							}
						});
					});
				";
			}
		}

		/**
			* readAccessRights()
			* Method for checking reading access rights
			* @param module_id
			* @return true if authenticated or false if not
			*/
		function readAccessRights($module_id)
		{
			if(isset($this->mUserIdentity) && !empty($this->mUserIdentity))
			{
				$privileges = $this->mUserIdentity->getPrivileges();
				//echo "<PRE>";
				//print_r($privileges);
				//echo "</PRE>";
				foreach($privileges as $priv => $data_item)
				{
					//echo "<PRE>";
					//print_r($data_item);
					//echo "</PRE>";
					//echo "<br>Priv = ".$priv." Module_id = ".$module_id;
					if($priv == $module_id) {
						if($data_item["read"])
						{
							//echo"<br>Sama -> read = ".$data_item["read"];exit;
							$_SESSION['last_module'] =$module_id;
							//print_r($_SESSION['last_module']);
							
							return true;
						} else {
							return false;
						}
						break;
					}
				}
			} else {
				return false;
			}
		}

		/**
			* addAccessRights()
			* Method for checking adding access rights
			* @param module_id
			* @return true if authenticated or false if not
			*/
		function addAccessRights($module_id)
		{
			if(isset($this->mUserIdentity) && !empty($this->mUserIdentity))
			{
				$privileges = $this->mUserIdentity->getPrivileges();
				foreach($privileges as $priv => $data_item)
				{
					if($priv == $module_id) {
						if($data_item["add"])
						{
							$_SESSION['last_module'] =$module_id;
							//print_r($_SESSION['last_module']);
							return true;
						} else {
							return false;
						}
						break;
					}
				}
			} else {
				return false;
			}
		}

		/**
			* updateAccessRights()
			* Method for checking updating access rights
			* @param module_id
			* @return true if authenticated or false if not
			*/
		function updateAccessRights($module_id)
		{
			if(isset($this->mUserIdentity) && !empty($this->mUserIdentity))
			{
				$privileges = $this->mUserIdentity->getPrivileges();				
				foreach($privileges as $priv => $data_item)
				{
					if($priv == $module_id) {
						if($data_item["update"])
						{
							$_SESSION['last_module'] =$module_id;
							//print_r($_SESSION['last_module']);
							return true;
						} else {
							return false;
						}
						break;
					}
				}
				
			} else {
				return false;
			}
		}

		/**
			* deleteAccessRights()
			* Method for checking deleting access rights
			* @param module_id
			* @return true if authenticated or false if not
			*/
		function deleteAccessRights($module_id)
		{
			if(isset($this->mUserIdentity) && !empty($this->mUserIdentity))
			{
				$privileges = $this->mUserIdentity->getPrivileges();
				foreach($privileges as $priv => $data_item)
				{
					if($priv == $module_id) {
						if($data_item["delete"])
						{	
							$_SESSION['last_module'] =$module_id;
							//print_r($_SESSION['last_module']);
							return true;
						} else {
							return false;
						}
						break;
					}
				}
				
			} else {
				return false;
			}
		}

	}
?>
