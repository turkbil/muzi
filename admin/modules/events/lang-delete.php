<?php
  /**
   * Language Data Delete
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: lang-delete.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
  self::$db->query("LOCK TABLES mod_events WRITE");
  self::$db->query("ALTER TABLE mod_events DROP COLUMN title_" . $flag_id);
  self::$db->query("ALTER TABLE mod_events DROP COLUMN venue_" . $flag_id);
  self::$db->query("ALTER TABLE mod_events DROP COLUMN body_" . $flag_id);
  self::$db->query("UNLOCK TABLES");
?>