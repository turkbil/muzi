<?php
  /**
   * Logout
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: logout.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  
  require_once("init.php");
  Security::writeLog(Lang::$word->_USER . ' ' . $user->username . ' ' . Lang::$word->_LG_LOGOUT, "user", "no", "user");
?>
<?php
  if ($user->logged_in)
      $user->logout();
	  
  redirect_to("login.php");
?>