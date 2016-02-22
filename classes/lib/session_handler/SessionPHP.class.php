<?php
	/**
		* SessionPHP class
		* Implementation class for handling session management with PHP session
		*
		* @author 
		* @version 1.0
		* @access public
		*/

	class SessionPHP extends SessionBase
	{
	
		/**
			* SessionPHP::SessionPHP()
			* SessionPHP class constructor
			* @param
			* @return
			*/
		function SessionPHP()
		{
			SessionBase::SessionBase();
		}

		/**
			* SessionPHP::startFunction()
			* Function for starting the PHP session
			* @param
			* @return
			*/
		function startSession($sess='')
		{							
			SessionBase::startSession(mktime());
			$this->setSessionExpire();			
			@session_start();			
		}
		
		function setSesid(){	
			session_id($this->mSessionId);
			session_name($this->mSessionId);
		}

		/**
			* SessionPHP::setVariable()
			* set variable into the session manager
			* @param $variable_id
			* @param $variable_name
			* @return
			*/
		function setVariable($variable_id, $variable_name)
		{
			SessionBase::setVariable($variable_id, $variable_name);
			$_SESSION[$variable_id] = $variable_name;
		}

		/**
			* SessionPHP::unsetVariable()
			* unset variable from the session
			* @param $variable_id
			* @return
			*/
		function unsetVariable($variable_id)
		{
			SessionBase::unsetVariable($variable_id);
			unset($_SESSION[$variable_id]);
		}

		/**
			* SessionPHP::getVariable()
			* get variable value from session
			* @param $variable_id
			* @return
			*/
		function getVariable($variable_id)
		{
			if(isset($_SESSION[$variable_id])) {
				return $_SESSION[$variable_id];
			} else {
				return false;
			}
		}

		/**
			* SessionPHP::getSessionId
			* get session id
			* @param
			* @return
			*/
		function getSessionId()
		{
			return $_SESSION['PHPSESSID'];
		}
		
		function setSessionExpire()
		{									

			$sessionCookieExpireTime=120*60;
			session_set_cookie_params($sessionCookieExpireTime);	
			@session_start();	
		}
		
		function setCookieExpire()
		{									
		}
		
		function get_host()
		{
			$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

		}

	}
?>