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
  self::$db->query("LOCK TABLES mod_events WRITE");
  self::$db->query("ALTER TABLE mod_events ADD title_$flag_id VARCHAR(150) NOT NULL AFTER title_tr");
  self::$db->query("ALTER TABLE mod_events ADD venue_$flag_id VARCHAR(150) NOT NULL AFTER venue_tr");
  self::$db->query("ALTER TABLE mod_events ADD body_$flag_id TEXT AFTER body_tr");
  self::$db->query("UNLOCK TABLES");

  if ($mod_events = self::$db->fetch_all("SELECT * FROM mod_events")) {
      foreach ($mod_events as $row) {
          $data = array(
              'title_' . $flag_id => $row->title_en,
              'venue_' . $flag_id => $row->venue_en,
              'body_' . $flag_id => $row->body_en);

          self::$db->update("mod_events", $data, "id = " . $row->id);
      }
      unset($data, $row);
  }
?>