<?php
	/**
		* SessionBase class
		* Base class for handling session management
		*
		* @author Harry S. Kartono
		* @version 1.0
		* @copyright Azadirachta 2006
		* @access public
		*/
	
	class SessionBase
	{

		var $mSessionData;
		var $mSessionId;

		/**
			* SessionBase::SessionBase()
			* SessionBase constructor
			*/
		function SessionBase()
		{
			$this->mSessionData = array();
			$this->mSessionId = "";
		}

		/**
			* SessionBase::startSession()
			* Start the session
			*
			* @param $sess_id session id
			* @return
			*/
		function startSession($sess_id)
		{
			$this->mSessionId = $sess_id;
		}

		/**
			* SessionBase::setVariable()
			* Set variable to the session management
			*
			* @param $variable_id    Variable id for the session
			* @param $variable_value Variable value for the session
			* @return
			*/
		function setVariable($variable_id, $variable_value)
		{
			if (is_object($variable_value))
			{
				$variable_value = serialize($variable_value);
			}
			$this->mSessionData[$variable_id] = $variable_value;
		}

		/**
			* SessionBase::unsetVariable()
			* Remove variable from the session management
			*
			* @param $variable_id    Variable id for the session variable
			* @return boolean, true if variable exist or false if not
			*/
		function unsetVariable($variable_id)
		{
			if(array_key_exists($variable_id, $this->mSessionData))
			{
				unset($this->mSessionData[$variable_id]);
				return true;
			} else {
				return false;
			}
		}

		/**
			* SessionBase::getVariable()
			* Get variable from the session management
			*
			* @param $variable_id    Variable id for the session variable
			* @return boolean, session value if variable exist or false if not
			*/
		function getVariable($variable_id)
		{
			if(array_key_exists($variable_id, $this->mSessionData))
			{
				if(is_object(unserialize($this->mSessionData[$variable_id])))
				{
					return unserialize($this->mSessionData[$variable_id]);
				} else {
					return $this->mSessionData[$variable_id];
				}
			} else {
				return false;
			}
		}

		/**
			* SessionBase::getSessionId()
			* Get session id for current session
			*
			* @return session id
			*/
		function getSessionId()
		{
			return $this->mSessionId;
		}

	}
?>