<?php
  /**
   * Security Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: class_security.php, v4.00 2014-04-20 18:20:24 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  
  class Security
  {
	  
      private static $ip;
      private $counter;
      private $wait;
	  const lTable = "log";
      
      /**
       * Security::__construct()
       * 
       * @param integer $attempt
       * @param integer $wait
       * @return
       */
      function __construct($attempt = 3, $wait = 180)
      {
          $this->setPars($attempt, $wait);
          self::$ip = self::getip();
      }
      
      /**
       * Security::getip()
       * 
       * @return
       */
      private static function getip()
      {
          return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
      }
      
      /**
       * Security::setPars()
       * 
       * @param mixed $counter
       * @param mixed $wait
       * @return
       */
      private function setPars($counter, $wait)
      {
          $this->counter = $counter;
          $this->wait = $wait;
      }
      
      /**
       * Security::loginAgain()
       * 
       * @param mixed $remain
       * @return
       */
	  public function loginAgain(&$remain)
	  {
		  $remain = 0;
		  $time = $this->getTime();
		  $var = $this->getRecord(self::$ip);
		  if (!$var)
			  return true;
		  if ($var->failed < $this->counter)
			  return true;
		  if (($time - $var->failed_last) > $this->wait) {
			  $this->deleteRecord(self::$ip);
			  return true;
		  }
		  $remain = $this->wait - ($time - $var->failed_last);
		  return false;
	  }
      
      /**
       * Security::setFailedLogin()
       * 
       * @return
       */
      public function setFailedLogin()
      {
          $this->setRecord(self::$ip, $this->getTime());
      }
      
      /**
       * Security::getTime()
       * 
       * @return
       */
      private function getTime()
      {
          return time();
      }
      
      /**
       * Security::getRecord()
       * 
       * @param mixed $ip
       * @return
       */
      private function getRecord($ip)
      {
		  
          $sql = "SELECT * FROM " . self::lTable . " WHERE ip='" . Registry::get("Database")->escape($ip) . "' AND type='user'";
          $row = Registry::get("Database")->first($sql);
		  
		  return ($row) ? $row : 0;
      }
      
      /**
       * Security::setRecord()
       * 
       * @param mixed $ip
       * @param mixed $failed
       * @param mixed $failed_last
       * @return
       */
	  private function setRecord($ip, $failed_last)
	  {
	
		  $ip = sanitize($ip);
		  if ($row = $this->getRecord($ip)) {
			  $data = array('failed' => "INC(1)", 'failed_last' => $failed_last);
	
			  Registry::get("Database")->update(self::lTable, $data, "id='" . $row->id . "'");
		  } else {
			  $data = array(
				  'ip' => $ip,
				  'type' => "user",
				  'failed' => 1,
				  'failed_last' => $failed_last,
				  'importance' => "yes",
				  'user_id' => "Guest",
				  'created' => "NOW()",
				  'message' => "Possible Brute force attack",
				  'info_icon' => "attack");
	
			  Registry::get("Database")->insert(self::lTable, $data);
		  }
	  }

    /**
     * Security::writeLog()
     * 
     * @param mixed $message
     * @param string $type
     * @param mixed $imp
     * @param mixed $icon
     * @return
     */
    public static function writeLog($message, $type='system', $imp='no', $icon='')
    {
        if(Registry::get("Core")->logging) {
            if (!$icon)
                $icon = "default";
            
            if (empty($type))
                $type = "system";
            
            $data = array(
                'user_id' => Registry::get("Users")->username, 
                'ip' => self::getUserIP(), 
                'created' => "NOW()", 
                'type' => $type, 
                'message' => $message, 
                'info_icon' => trim($icon), 
                'importance' => trim($imp),
                'failed' => 0,
                'failed_last' => time()
            );
            
            Registry::get("Database")->insert(self::lTable, $data);
        }
    }
    
    /**
     * Security::getUserIP()
     * 
     * @return
     */
    private static function getUserIP()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
    }

      /**
       * Security::getLogs()
       * 
       * @param mixed $type
       * @return
       */
	  public function getLogs()
	  {
	
		  if (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '') {
			  $enddate = date("Y-m-d");
			  $fromdate = (empty($from)) ? $_POST['fromdate_submit'] : $from;
			  if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
				  $enddate = $_POST['enddate_submit'];
			  }
			  $where = " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
	
			  $q = "SELECT COUNT(*) FROM " . self::lTable . "" . "\n WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' LIMIT 1";
			  $record = Registry::get("Database")->query($q);
			  $total = Registry::get("Database")->fetchrow($record);
			  $counter = $total[0];
		  } else {
			  $where = null;
			  $counter = countEntries(self::lTable);
		  }
	
	
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
	
		  $sql = "SELECT * FROM " . self::lTable . "\n $where" . "\n ORDER BY created DESC" . $pager->limit;
		  $row = Registry::get("Database")->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }
	  
					  
      /**
       * Security::deleteRecord()
       * 
       * @param mixed $ip
       * @return
       */
      private function deleteRecord($ip)
      {
          Registry::get("Database")->delete(self::lTable, "ip='" . Registry::get("Database")->escape($ip) . "' AND type = 'user'");
      }
	  
  }
?>