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
  self::$db->query("LOCK TABLES mod_gallery_config WRITE");
  self::$db->query("ALTER TABLE mod_gallery_config DROP COLUMN title_" . $flag_id);
  self::$db->query("UNLOCK TABLES");

  self::$db->query("LOCK TABLES mod_gallery_images WRITE");
  self::$db->query("ALTER TABLE mod_gallery_images DROP COLUMN title_" . $flag_id);
  self::$db->query("ALTER TABLE mod_gallery_images DROP COLUMN description_" . $flag_id);
  self::$db->query("UNLOCK TABLES");
?>