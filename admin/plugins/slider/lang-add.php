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
  self::$db->query("LOCK TABLES plug_slider WRITE");
  self::$db->query("ALTER TABLE plug_slider ADD title_$flag_id VARCHAR(150) NOT NULL AFTER title_tr");
  self::$db->query("ALTER TABLE plug_slider ADD body_$flag_id TEXT AFTER body_tr");
  self::$db->query("UNLOCK TABLES");

  if ($plug_slider = self::$db->fetch_all("SELECT * FROM plug_slider")) {
      foreach ($plug_slider as $row) {
          $data['title_' . $flag_id] = $row->title_en;
          $data['body_' . $flag_id] = $row->body_en;
          self::$db->update("plug_slider", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }
?>