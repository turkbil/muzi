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
  self::$db->query("LOCK TABLES mod_muzibu WRITE");
  self::$db->query("ALTER TABLE mod_muzibu ADD COLUMN title_$flag_id VARCHAR(100) NOT NULL AFTER title_tr");
  self::$db->query("ALTER TABLE mod_muzibu ADD COLUMN body_$flag_id TEXT AFTER body_tr");
  self::$db->query("ALTER TABLE mod_muzibu ADD COLUMN metakey_$flag_id VARCHAR(200) NOT NULL AFTER metakey_tr");
  self::$db->query("ALTER TABLE mod_muzibu ADD COLUMN metadesc_$flag_id TEXT AFTER metadesc_tr");
  self::$db->query("UNLOCK TABLES");

  if ($mod_muzibu = self::$db->fetch_all("SELECT * FROM mod_muzibu")) {
      foreach ($mod_muzibu as $row) {
          $data['title_' . $flag_id] = $row->title_en;
          $data['short_desc_' . $flag_id] = $row->short_desc_en;
          $data['detail_' . $flag_id] = $row->detail_en;
          $data['body_' . $flag_id] = $row->body_en;
          $data['metakey_' . $flag_id] = $row->metakey_en;
          $data['metadesc_' . $flag_id] = $row->metadesc_en;
          self::$db->update("mod_muzibu", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }

  self::$db->query("LOCK TABLES mod_muzibu_category WRITE");
  self::$db->query("ALTER TABLE mod_muzibu_category ADD COLUMN title_$flag_id VARCHAR(100) NOT NULL AFTER title_tr");
  self::$db->query("ALTER TABLE mod_muzibu_category ADD COLUMN metakey_$flag_id VARCHAR(100) NOT NULL AFTER metakey_tr");
  self::$db->query("ALTER TABLE mod_muzibu_category ADD COLUMN metadesc_$flag_id TINYTEXT AFTER metadesc_tr");
  self::$db->query("UNLOCK TABLES");

  if ($mod_muzibu_category = self::$db->fetch_all("SELECT * FROM mod_muzibu_category")) {
      foreach ($mod_muzibu_category as $row) {
          $data = array(
		  'title_' . $flag_id => $row->title_en,
		  'metakey_' . $flag_id => $row->metakey_en,
		  'metadesc_' . $flag_id => $row->metadesc_en
		  );
          self::$db->update("mod_muzibu_category", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }
?>