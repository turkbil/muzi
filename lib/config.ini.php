<?php 
 ini_set("display_errors", 1);

 /** 
	* Configuration

	* @yazilim TUBI Portal
	* @web adresi turkbilisim.com.tr
	* @copyright 2014
	* @version Id: config.ini.php, v4.00 2016-04-08 00:43:17 Nurullah Okatan 
	*/
 
	 if (!defined("_VALID_PHP")) 
     die('Direct access to this location is not allowed.');
 
	/** 
	* Database Constants - these constants refer to 
	* the database configuration settings. 
	*/
	 define('DB_SERVER', 'localhost'); 
	 define('DB_USER', 'muzibu_mayis25'); 
	 define('DB_PASS', 'tsb;(.HEydDh'); 
	 define('DB_DATABASE', 'muzibu_mayis25');
 
	/** 
	* Show MySql Errors. 
	* Not recomended for live site. true/false 
	*/
	$DEBUG = true; 
?>