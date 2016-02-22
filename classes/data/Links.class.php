<?php
  /**
   * Links
   *
   * @package
   * @file Links.class.php
   * @author
   * @version 1.0
   * @access public
   */
	class Links extends DatabaseConnected
	{
		// var $mLinkItems;
		var $mSideLinks;							
		var $mSideLinksWebContent;							
		var $mConfig;
		var $mModuleId;

		/**
			* Links::Links()
			* Links object constructor
			*
			* @param $config_object configuration object
			* @param @user_identity user identity object
			* @param @page_id current page id
			* @return
			*/
		function Links($config_object, $module_id='all')
		{			
			DatabaseConnected::DatabaseConnected($config_object, 'security.sql.php');			
			$sess = new SessionPHP();
			//$lang_id = ($sess->getVariable('lang_id')) ? $sess->getVariable('lang_id') : 'en';
			$lang_id = ($sess->getVariable('lang_id')) ? $sess->getVariable('lang_id') : 'id';
			
			$this->mConfig = $config_object;
			$this->mSubsystemId = $this->getSubSystemFromModule($module_id);
			$this->mModuleId = $module_id;
			
			
			// this will load left side menu		
			
			if($module_id == "home" || $module_id == ""){				
				//require_once $this->mConfig->getValue('docroot').'links/all-'.$lang_id.'.lnk.php';
			}
			else {				
				require_once $this->mConfig->getValue('docroot').'links/'.$this->mSubsystemId.'-'.$lang_id.'.lnk.php';
			}			
				
			$this->mSubSystem = $subsystem_name;
			//echo $this->mSubSystem;
			//side link untuk administrator
			$this->mSideLinks = $side_link;
			$this->mSideLinksWebContent = $side_link_web_content;
		}
		
		function getSubSystemFromModule($module)
		{
			$links = explode('-',$module);			
			return $links[0];
			/*echo $links[0];
			if($links[0]){			
				$sql = sprintf($this->mSqlQueries['get_subsystem_id'], $module);								
				$rs = $this->mrDbConnection->Execute($sql);
				
				if ($rs = $this->mrDbConnection->Execute($sql)) {
					$row = $rs->FetchRow();
					return $row['id'];
				} else {
					return false;
				}
			}
			else{				
				return $module;
			}*/
		}

		/**
		  * Links::getSideMenu()
		  * property get for side menu properties
		  *	
		  * @param
		  * @return array variable contain side menu description
		  * @access public
		  */
		function getSideMenu()
		{
			return $this->mSideLinks;
		}
		
		/**
		  * Links::getSideMenu()
		  * property get for side menu properties
		  *	
		  * @param
		  * @return array variable contain side menu description
		  * @access public
		  */
		function getSideMenuWebContent()
		{
			return $this->mSideLinksWebContent;
		}
				
								
		/**
			* Links::getJavaScriptMenu()
			* method for generating JSCookMenu javascript menu array
			*
			* @param
			* @return variable declaration (array) of myMenu variable
			* @access public
			*/
		function getJavascriptMenu()
		{
			if ($this->mLinkItems) {
				$menu = "var myMenu = [";
				$menu = $menu . $this->processLinks($this->mLinkItems);
				$menu = $menu . "]";
				return $menu;
			} else {
				return false;
			}
		}

		/**
			* Links::processSubLinks()
			* recursive function for processing sub menu
			* 
			* @param $the_sub_links array contain sub links data
			* @return javascript menu (JSCookMenu array) for sub menu
			* @access private
			*/
		function processSubLinks($the_sub_links) {
			$tmp = "";
			foreach($the_sub_links as $menuitem => $row) {
				if(isset($row['LINK_TYPE'])) {
					if($row['LINK_TYPE'] == 'SEPARATOR') $tmp = $tmp . "_cmSplit,";
				} else {
					$tmp = $tmp . "\t['','".$row['LINK_NAME']."','".$this->mConfig->getValue('basedir').$row['LINK_HREF']."','_self','".$row['LINK_NAME']."'";
					if (isset($row['SUBLINKS'])) {
						if(is_array($row['SUBLINKS'])) $tmp = $tmp . ",\n\t" . $this->processSubLinks($row['SUBLINKS']) . "\t],\n";
					} else {
						$tmp = $tmp . "],\n";
					}
				}
			}
			return $tmp = $tmp;
		}

		/**
			* Links::processLinks()
			* recursive function for processing menu items
			*
			* @param $the_links array contain links data
			* @return javascript menu (JSCookMenu array)
			* @access private
			*/
		function processLinks($the_links) {
			$tmp = "";
			foreach ($the_links as $menu => $row) {
				if(strlen($tmp) != 0) $tmp = $tmp . ",";
				if(isset($row['LINK_TYPE'])) {
					if($row['LINK_TYPE'] == 'SEPARATOR') $tmp = $tmp . "_cmSplit";
				} else {
					$tmp = $tmp . "['".$row['LINK_NAME']."','','".$this->mConfig->getValue('basedir').$row['LINK_HREF']."','_self','".$row['LINK_NAME']."'";
					if (isset($row['SUBLINKS'])) {
						if (is_array($row['SUBLINKS'])) $tmp = $tmp . ",\n" . $this->processSubLinks($row['SUBLINKS']) . "]\n";
					} else {
						$tmp = $tmp . "],\n";
					}
				}
			}
			return $tmp;
		}
		
		function getPageId()
		{
			return $this->mSubsystemId;
		}
		
		function getSubSystemName()
		{
			return $this->mSubSystem;
		}				
	}

?>
