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
  self::$db->query("LOCK TABLES mod_blog WRITE");
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN title_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN short_desc_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN body_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN caption_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN tags_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN metakey_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog DROP COLUMN metadesc_" . $flag_id);
  self::$db->query("UNLOCK TABLES");

  self::$db->query("LOCK TABLES mod_blog_categories WRITE");
  self::$db->query("ALTER TABLE mod_blog_categories DROP COLUMN name_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog_categories DROP COLUMN description_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog_categories DROP COLUMN metakey_" . $flag_id);
  self::$db->query("ALTER TABLE mod_blog_categories DROP COLUMN metadesc_" . $flag_id);
  self::$db->query("UNLOCK TABLES");

  self::$db->query("LOCK TABLES plug_blog_tags WRITE");
  self::$db->query("ALTER TABLE plug_blog_tags DROP COLUMN tagname_" . $flag_id);
  self::$db->query("UNLOCK TABLES");
?>