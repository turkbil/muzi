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
  self::$db->query("LOCK TABLES mod_blog WRITE");
  self::$db->query("ALTER TABLE mod_blog ADD COLUMN title_$flag_id VARCHAR(100) NOT NULL AFTER title_tr");
  self::$db->query("ALTER TABLE mod_blog ADD COLUMN short_desc_$flag_id TEXT AFTER short_desc_tr");
  self::$db->query("ALTER TABLE mod_blog ADD COLUMN body_$flag_id MEDIUMTEXT AFTER body_tr");
  self::$db->query("ALTER TABLE mod_blog ADD COLUMN caption_$flag_id VARCHAR(100) NOT NULL AFTER caption_tr");
  self::$db->query("ALTER TABLE mod_blog ADD COLUMN tags_$flag_id VARCHAR(100) NOT NULL AFTER tags_tr");
  self::$db->query("ALTER TABLE mod_blog ADD COLUMN metakey_$flag_id VARCHAR(200) NOT NULL AFTER metakey_tr");
  self::$db->query("ALTER TABLE mod_blog ADD COLUMN metadesc_$flag_id TEXT AFTER metadesc_tr");
  self::$db->query("UNLOCK TABLES");

  if ($mod_blog = self::$db->fetch_all("SELECT * FROM mod_blog")) {
      foreach ($mod_blog as $row) {
          $data['title_' . $flag_id] = $row->title_en;
          $data['short_desc_' . $flag_id] = $row->short_desc_en;
          $data['body_' . $flag_id] = $row->body_en;
          $data['caption_' . $flag_id] = $row->caption_en;
          $data['metakey_' . $flag_id] = $row->metakey_en;
          $data['metadesc_' . $flag_id] = $row->metadesc_en;
          self::$db->update("mod_blog", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }

  self::$db->query("LOCK TABLES mod_blog_categories WRITE");
  self::$db->query("ALTER TABLE mod_blog_categories ADD COLUMN name_$flag_id VARCHAR(100) NOT NULL AFTER name_tr");
  self::$db->query("ALTER TABLE mod_blog_categories ADD COLUMN description_$flag_id TEXT AFTER description_tr");
  self::$db->query("ALTER TABLE mod_blog_categories ADD COLUMN metakey_$flag_id VARCHAR(200) NOT NULL AFTER metakey_tr");
  self::$db->query("ALTER TABLE mod_blog_categories ADD COLUMN metadesc_$flag_id TEXT AFTER metadesc_tr");
  self::$db->query("UNLOCK TABLES");

  if ($mod_blog_categories = self::$db->fetch_all("SELECT * FROM mod_blog_categories")) {
      foreach ($mod_blog_categories as $row) {
          $data = array(
              'name_' . $flag_id => $row->name_en,
              'description_' . $flag_id => $row->description_en,
              'metakey_' . $flag_id => $row->metakey_en,
              'metadesc_' . $flag_id => $row->metadesc_en);

          self::$db->update("mod_blog_categories", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }

  self::$db->query("LOCK TABLES plug_blog_tags WRITE");
  self::$db->query("ALTER TABLE plug_blog_tags ADD COLUMN tagname_$flag_id VARCHAR(100) NOT NULL AFTER tagname_tr");
  self::$db->query("UNLOCK TABLES");

  if ($plug_blog_tags = self::$db->fetch_all("SELECT * FROM plug_blog_tags")) {
      foreach ($plug_blog_tags as $row) {
          $data = array('tagname_' . $flag_id => $row->tagname_en);

          self::$db->update("plug_blog_tags", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }
?>