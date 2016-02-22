<?php
	/**
		* UserIdentity
		*
		* @package security
		* @file UserIdentity.class.php
		* @author 
		* @version 1.0
		* @access public
		*/

	class UserIdentity
	{
		/**
			* variable for handling user's id
			* @var string mUserId
			*/
		var $mUserId;


		/**
			* variable for handling user's real name
			* @var string mRealName
			*/
		var $mRealName;
		var $mUserPhoto;
		var $mSgid;
		var $mPID;
		var $mCoid;
		var $mConame;
		var $mShortConame;
		var $mIsWarehouse;
		
		/**
			* variable for handling user's privileges (array)
			* array {
			*  module_name {
			*    read => true, add=>true, update=>true, delete=true
			*  }
			* }
			*
			* @var array mPrivileges
			*/
		var $mPrivileges = array();
		/**
			* UserIdentity::UserIdentity()
			* UserIdentity class constructor
			* @param
			* @return
			*/
		function UserIdentity()
		{
			unset($this->mPrivileges);
			$this->mPrivileges = array();
			$this->mUserId    = '';
			$this->mRealName  = '';
			$this->mUserPhoto  = '';
			$this->mCoid  = '';
			$this->mConame  = '';
			$this->mShortConame  = '';
			$this->mIsWarehouse  = '';
		}

		/**
			* setUserId()
			* set user id
			* @param $userid
			* @return
			*/
		function setUserId($userid)
		{
			$this->mUserId = $userid;
		}

		/**
			* getUserId()
			* get user id
			* @param
			* @return user id
			*/
		function getUserId()
		{
			return $this->mUserId;
		}

		/**
			* setRealName()
			* set user real name
			* @param $real_name
			* @return
			*/
		function setRealName($real_name)
		{
			$this->mRealName = $real_name;
		}

		/**
			* getRealName()
			* get real user name
			* @param
			* @return user name
			*/
		function getRealName()
		{
			return $this->mRealName;
		}
		
		/**
			* setUserPhoto()
			* set user user photo
			* @param $user_photo
			* @return
			*/
		function setUserPhoto($user_photo)
		{
			$this->mUserPhoto = $user_photo;
		}

		/**
			* getUserPhoto()
			* get real user photo
			* @param
			* @return user photo
			*/
		function getUserPhoto()
		{
			return $this->mUserPhoto;
		}
		
		function setSgid($tmp)
		{
			$this->mSgid = $tmp;
		}
		function getSgid()
		{
			return $this->mSgid;
		}
		
		
		function setCoid($coid)
		{
			$this->mCoid = $coid;
		}

		function getCoid()
		{
			return $this->mCoid;
		}
		function setConame($tmp)
		{
			$this->mConame = $tmp;
		}

		function getConame()
		{
			return $this->mConame;
		}
		
		function setShortConame($tmp)
		{
			$this->mShortConame = $tmp;
		}

		function getShortConame()
		{
			return $this->mShortConame;
		}
		
		function setIsWarehouse($tmp)
		{
			$this->mIsWarehouse = $tmp;
		}

		function getIsWarehouse()
		{
			return $this->mIsWarehouse;
		}
		function setPID($tmp)
		{
			$this->mPID = $tmp;
		}

		function getPID()
		{
			return $this->mPID;
		}
		/**
		* setPrivileges()
		* add new/update user privileges
		* @param $new_privileges
		* @return
		*/
		function setPrivileges($module_id, $read, $add, $update, $delete)
		{
			$new_privileges = array('read'=>$read, 'add'=>$add, 'update'=>$update,'delete'=>$delete);
			$this->mPrivileges[$module_id] = $new_privileges;
		}

		/**
			* removePrivileges()
			* remove user privileges
			* @param $module_id
			* @return
			*/
		function removePrivileges($module_id)
		{
			unset($this->mPrivileges[$module_id]);
		}

		/**
			* getPrivileges()
			* method for getting current user privileges
			* @param
			* @return user privileges in an array
			*/
		function getPrivileges()
		{
			return $this->mPrivileges;
		}

		/**
			* clearPrivileges()
			* clear all user privileges
			* @param
			* @return
			*/
		function clearPrivileges()
		{
			unset($this->mPrivileges);
			$this->mPrivileges = array();
		}
		
		function getUserHome()
		{
		
		}

	}
?>
