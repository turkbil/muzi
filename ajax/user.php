<?php
  /**
   * User
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: user.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  require_once("../init.php");
?>
<?php
  /* == Registration == */
  if (isset($_POST['doRegister'])):
      $user->register();
  endif;

  /* == Password Reset == */
  if (isset($_POST['passReset'])):
      $user->passReset();
  endif;

  /* == Account Acctivation == */
  if (isset($_POST['accActivate'])):
      $user->activateUser();
  endif;
?>