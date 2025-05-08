<?php
  /**
   * Language Data Delete
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: lang-delete.php, v4.00 2014-05-24 12:12:12 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
  self::$db->query("LOCK TABLES mod_slidecms_data WRITE");
  self::$db->query("ALTER TABLE mod_slidecms_data DROP COLUMN caption_" . $flag_id);
  self::$db->query("UNLOCK TABLES");
?>