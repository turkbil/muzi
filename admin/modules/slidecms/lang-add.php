<?php
  /**
   * Language Data Add
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: lang-add.php, v4.00 2014-05-24 12:12:12 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
	self::$db->query("LOCK TABLES mod_slidecms_data WRITE");
	self::$db->query("ALTER TABLE mod_slidecms_data ADD COLUMN caption_$flag_id VARCHAR(100) NOT NULL AFTER caption_tr");
	self::$db->query("UNLOCK TABLES");

	if($mod_slidecms_data = self::$db->fetch_all("SELECT * FROM mod_slidecms_data")) {
		foreach ($mod_slidecms_data as $row) {
			$data['caption_' . $flag_id] = $row->caption_en;
			self::$db->update("mod_slidecms_data", $data, "id = " . $row->id);
		}
		unset($data, $row);
	}
?>