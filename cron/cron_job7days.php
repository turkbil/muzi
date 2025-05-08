<?php
  /**
   * Cron Job Listing Expiry Seven Days Notice
   *
   * @yazilim Tubi Portal
   * @web adresi
@web adresi
@web adresi turkbilisim.com.tr
   * @copyright 2011
   * @version $Id: cron_job7days.php,v 1.00 2010-08-10 21:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  require_once("../init.php");
  
  $member->membershipCron(7);
?>