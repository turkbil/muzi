<?php
  /**
   * Language Data Add
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: lang-add.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
  self::$db->query("LOCK TABLES mod_gallery_config WRITE");
  self::$db->query("ALTER TABLE mod_gallery_config ADD title_$flag_id VARCHAR(100) NOT NULL AFTER title_tr");
  self::$db->query("UNLOCK TABLES");

  if ($mod_gallery_config = self::$db->fetch_all("SELECT * FROM mod_gallery_config")) {
      foreach ($mod_gallery_config as $row) {
          $data['title_' . $flag_id] = $row->title_en;
          self::$db->update("mod_gallery_config", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }

  self::$db->query("LOCK TABLES mod_gallery_images WRITE");
  self::$db->query("ALTER TABLE mod_gallery_images ADD title_$flag_id VARCHAR(100) NOT NULL AFTER title_tr");
  self::$db->query("ALTER TABLE mod_gallery_images ADD description_$flag_id VARCHAR(250) NOT NULL AFTER description_tr");
  self::$db->query("UNLOCK TABLES");

  if ($mod_gallery_images = self::$db->fetch_all("SELECT * FROM mod_gallery_images")) {
      foreach ($mod_gallery_images as $row) {
          $data = array('title_' . $flag_id => $row->title_en, 'description_' . $flag_id => $row->description_en);

          self::$db->update("mod_gallery_images", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }
?>