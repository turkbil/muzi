<?php
  /**
   * FAQ Manager Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: admin_class.php, v1.00 2014-05-31 20:15:17 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class FAQManager
  {

	  const mTable = "mod_faq";
	  private static $db;


      /**
       * FAQManager::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::$db = Registry::get("Database");
      }

      /**
       * FAQManager::getFaq()
       * 
       * @return
       */
      public function getFaq()
      {
          $sql = "SELECT * FROM " . self::mTable . " ORDER BY position";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * FAQManager::processFaq()
       * 
       * @return
       */
      public function processFaq()
      {
          Filter::checkPost('question' . Lang::$lang, Lang::$word->_MOD_FAQ_TITLE);
		  Filter::checkPost('answer' . Lang::$lang, Lang::$word->_MOD_FAQ_DESC);
			  
          if (empty(Filter::$msgs)) {
			  $data = array(
				  'question' . Lang::$lang => sanitize($_POST['question' . Lang::$lang]), 
				  'answer' . Lang::$lang => Filter::in_url($_POST['answer' . Lang::$lang])
			  );

			  (Filter::$id) ? self::$db->update(self::mTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::mTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_MOD_FAQ_UPDATED : Lang::$word->_MOD_FAQ_ADDED;

			  if (self::$db->affected()) {
				  Security::writeLog($message, "", "no", "module");
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
			  } else {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);

		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
	  
      /**
       * FAQManager::updateOrder()
       * 
       * @return
       */
	  public static function updateOrder()
	  {
		  	  
		  foreach ($_POST['node'] as $k => $v) {
			  $p = $k + 1;
			  $data['position'] = intval($p);
			  self::$db->update(self::mTable, $data, "id=" . (int)$v);
		  }
		  
	  }
  }
?>