<?php
  /**
   * Core Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: core_class.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Membership
  {
	  const mTable = "memberships";
	  const pTable = "payments";
	  const gTable = "gateways";
	  
	  private static $db;
	  

      /**
       * Membership::__construct()
       * 
       * @return
       */
      public function __construct()
      {
		  self::$db = Registry::get("Database");

      }

      /**
       * Membership::getMemberships()
       * 
       * @return
       */
	  public function getMemberships()
	  {
		  $sql = "SELECT * FROM " . self::mTable . " ORDER BY price";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

      /**
       * Membership::getMembershipListFrontEnd()
       * 
       * @return
       */
      public function getMembershipListFrontEnd()
      {
          $sql = "SELECT * FROM ".self::mTable." WHERE private = 0 AND active = 1 ORDER BY price";
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  /**
	   * Membership::processMembership()
	   * 
	   * @return
	   */
	  public function processMembership()
	  {
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_MS_TITLE);
		  Filter::checkPost('price', Lang::$word->_MS_PRICE);
		  Filter::checkPost('days', Lang::$word->_MS_PERIOD);
		  if (!is_numeric($_POST['days']))
			  Filter::$msgs['days'] = Lang::$word->_MS_PERIOD_R;
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
				  'price' => floatval($_POST['price']),
				  'days' => intval($_POST['days']),
				  'period' => sanitize($_POST['period']),
				  'trial' => intval($_POST['trial']),
				  'recurring' => intval($_POST['recurring']),
				  'private' => intval($_POST['private']),
				  'description' . Lang::$lang => sanitize($_POST['description' . Lang::$lang]),
				  'active' => intval($_POST['active']));
	
			  if ($data['trial'] == 1) {
				  $trial['trial'] = "DEFAULT(trial)";
				  self::$db->update(self::mTable, $trial);
			  }
	
			  (Filter::$id) ? self::$db->update(self::mTable, $data, "id='" . Filter::$id . "'") : self::$db->insert(self::mTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_MS_UPDATED : Lang::$word->_MS_ADDED;
	
			  if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
				  Security::writeLog($message, "", "no", "content");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
	  
      /**
       * Membership::getAccessList()
       * 
       * @param bool $sel
       * @return
       */
      public function getAccessList($sel = false)
	  {
		  $arr = array(
				 'Public' => Lang::$word->_PUBLIC,
				 'Registered' => Lang::$word->_REGISTERED,
				 'Membership' =>Lang::$word->_MEMBERSHIP
		  );
		  
		  $data = '';
		  foreach ($arr as $key => $val) {
              if ($key == $sel) {
                  $data .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $data .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $data;
      }
	  
      /**
       * Membership::getMembershipList()
       * 
       * @param bool $memid
       * @return
       */
	  public function getMembershipList($memid = false)
	  {
	
		  $sqldata = self::$db->fetch_all("SELECT id, title" . Lang::$lang . " FROM memberships ORDER BY title" . Lang::$lang);
	
		  if ($memid) {
			  $arr = explode(",", $memid);
			  reset($arr);
		  }
		  $data = '';
		  if ($sqldata) {
			  $data .= '<select name="membership_id[]" multiple="multiple">';
			  foreach ($sqldata as $val) {
				  if ($memid) {
					  $selected = (in_array($val->id, $arr)) ? " selected=\"selected\"" : "";
				  } else {
					  $selected = null;
				  }
				  $data .= "<option $selected value=\"" . $val->id . "\">" . $val->{'title' . Lang::$lang} . "</option>\n";
	
			  }
			  unset($val);
			  $data .= "</select>";
	
			  return $data;
		  }
	  }

      /**
       * Membership::getMembershipPeriod()
       * 
       * @param bool $sel
       * @return
       */
	  public static function getMembershipPeriod($sel = false)
	  {
		  $arr = array(
			  'D' => Lang::$word->_DAYS,
			  'W' => Lang::$word->_WEEKS,
			  'M' => Lang::$word->_MONTHS,
			  'Y' => Lang::$word->_YEARS);
	
		  $html = '';
		  $html .= '<select name="period">';
		  foreach ($arr as $key => $val) {
			  if ($key == $sel) {
				  $html .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
			  } else
				  $html .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
		  }
		  unset($val);
		  $html .= "</select>";
		  return $html;
	  }

      /**
       * Membership::getPeriod()
       * 
       * @param bool $value
       * @return
       */
      public function getPeriod($value)
	  {
		  switch($value) {
			  case "D" :
			  return Lang::$word->_DAYS;
			  break;
			  case "W" :
			  return Lang::$word->_WEEKS;
			  break;
			  case "M" :
			  return Lang::$word->_MONTHS;
			  break;
			  case "Y" :
			  return Lang::$word->_YEARS;
			  break;
		  }

      }

	  /**
	   * Membership::calculateDays()
	   * 
	   * @return
	   */
	  public function calculateDays($period, $days)
	  {		  
		  $now = date('Y-m-d H:i:s');
			  switch($period) {
				  case "D" :
				  $diff = $days;
				  break;
				  case "W" :
				  $diff = $days * 7;
				  break; 
				  case "M" :
				  $diff = $days * 30;
				  break;
				  case "Y" :
				  $diff = $days * 365;
				  break;
			  }
			return date("d M Y", strtotime($now . + $diff . " days"));
	  }

	  /**
	   * Membership::getTotalDays()
	   * Used for MoneyBookers
	   * @return
	   */
	  public function getTotalDays($period, $days)
	  {
		  switch($period) {
			  case "D" :
			  $diff = $days;
			  break;
			  case "W" :
			  $diff = $days * 7;
			  break; 
			  case "M" :
			  $diff = $days * 30;
			  break;
			  case "Y" :
			  $diff = $days * 365;
			  break;
		  }
		return $diff;
	  }	  	
	    	  	  	  
      /**
       * Membership::getPayments()
       * 
       * @param bool $from
       * @return
       */
	  public function getPayments($from = false)
	  {
	
		  if (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '') {
			  $enddate = date("Y-m-d");
			  $fromdate = (empty($from)) ? $_POST['fromdate_submit'] : $from;
			  if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
				  $enddate = $_POST['enddate_submit'];
			  }
			  $q = "SELECT COUNT(*) FROM " . self::pTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
			  $where = " WHERE p.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
		  } else {
			  $q = "SELECT COUNT(*) FROM " . self::pTable . " LIMIT 1";
			  $where = "";
		  }
	
		  $record = self::$db->query($q);
		  $total = self::$db->fetchrow($record);
		  $counter = $total[0];
	
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
	
		  $sql = "SELECT p.*, p.id as id, u.username,u.id as uid, m.id as mid, m.title" . lang::$lang . " as title" 
		  . "\n FROM " . self::pTable . " as p" 
		  . "\n LEFT JOIN " . Users::uTable . " as u ON u.id = p.user_id" 
		  . "\n LEFT JOIN " . self::mTable . " as m ON m.id = p.membership_id" 
		  . "\n " . $where . " ORDER BY p.created DESC" . $pager->limit;
	
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }
	  
      /**
       * Membership::monthlyStats()
       * 
       * @return
       */
      public function monthlyStats()
      {
		  
          $sql = "SELECT id, COUNT(id) as total, SUM(rate_amount) as totalprice" 
		  . "\n FROM ".self::pTable 
		  . "\n WHERE status = 1" 
		  . "\n AND date > '" . Registry::get("Core")->year  . "-" . $core->month . "-01'" 
		  . "\n AND date < '" . Registry::get("Core")->year  . "-" . $core->month . "-31 23:59:59'";
          
          $row = self::$db->first($sql);
          
		  return ($row['total'] > 0) ? $row : false;
      }

      /**
       * Membership::yearlyStats()
       * 
       * @return
       */
      public function yearlyStats()
      {
		  
          $sql = "SELECT *, YEAR(created) as year, MONTH(created) as month," 
		  . "\n COUNT(id) as total, SUM(rate_amount) as totalprice" 
		  . "\n FROM ".self::pTable 
		  . "\n WHERE status = 1" 
		  . "\n AND YEAR(created) = '" . Registry::get("Core")->year  . "'" 
		  . "\n GROUP BY year DESC ,month DESC ORDER by created";
          
          $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }

      /**
       * Membership::getYearlySummary()
       * 
       * @return
       */
      public function getYearlySummary()
      {
          
          $sql = "SELECT YEAR(created) as year, MONTH(created) as month," 
		  . "\n COUNT(id) as total, SUM(rate_amount) as totalprice" 
		  . "\n FROM ".self::pTable
		  . "\n WHERE status = 1" 
		  . "\n AND YEAR(created) = '" . Registry::get("Core")->year . "'";
          
          $row = self::$db->first($sql);
          
          return ($row) ? $row : 0;
      }
	   
      /**
       * Membership::totalIncome()
       * 
       * @return
       */
      public function totalIncome()
      {
          $sql = "SELECT SUM(rate_amount) as totalsale"
		  . "\n FROM ".self::pTable
		  . "\n WHERE status = 1";
          $row = self::$db->first($sql);
          
          $total_income = Registry::get("Core")->formatMoney($row->totalsale);
          
          return $total_income;
      }
  
	  /**
	   * Membership::membershipCron()
	   * 
	   * @param mixed $days
	   * @return
	   */
	  public function membershipCron($days)
	  {
	
		  $sql = "SELECT u.id, CONCAT(u.fname,' ',u.lname) as name, u.email, u.membership_id, u.trial_used, m.title{$core->dblang}, m.days," 
		  . "\n DATE_FORMAT(u.mem_expire, '%d %b %Y') as edate" 
		  . "\n FROM users as u" 
		  . "\n LEFT JOIN " . self::mTable . " AS m ON m.id = u.membership_id" 
		  . "\n WHERE u.active = 'y' AND u.membership_id !=0" 
		  . "\n AND TO_DAYS(NOW()) - TO_DAYS(u.mem_expire) = " . (int)$days;
	
		  $userrow = self::$db->fetch_all($sql);
		  require_once (BASEPATH . "lib/class_mailer.php");
	
		  if ($userrow) {
			  switch ($days) {
				  case 7:
					  $mailer = Mailer::sendMail();
					  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
	
					  $trow = Core::getRowById(Content::eTable, 8);
					  $body = cleanOut($trow->{'body' . Lang::$lang});
	
					  $replacements = array();
					  foreach ($userrow as $cols) {
						  $replacements[$cols->email] = array(
							  '[NAME]' => $cols->name,
							  '[SITE_NAME]' => Registry::get("Core")->site_name,
							  '[URL]' => SITEURL);
					  }
	
	
					  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
					  $mailer->registerPlugin($decorator);
	
					  $message = Swift_Message::newInstance()
								->setSubject($trow->{'subject' . Lang::$lang})
								->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
								->setBody($body,'text/html');
	
					  foreach ($userrow as $row) {
						  $message->setTo(array($row->email => $row->name));
						  $numSent++;
						  $mailer->send($message, $failedRecipients);
					  }
	
					  unset($row);
	
					  break;
	
				  case 0:
					  $mailer = Mailer::sendMail();
					  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
	
					  $trow = Core::getRowById(Content::eTable, 9);
					  $body = cleanOut($trow->{'body' . Lang::$lang});
	
					  $replacements = array();
					  foreach ($userrow as $cols) {
						  $replacements[$cols->email] = array(
							  '[NAME]' => $cols->name,
							  '[SITE_NAME]' => Registry::get("Core")->site_name,
							  '[URL]' => SITEURL);
					  }
	
					  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
					  $mailer->registerPlugin($decorator);
	
					  $message = Swift_Message::newInstance()
								->setSubject($trow->{'subject' . Lang::$lang})
								->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
								->setBody($body,'text/html');
	
					  foreach ($userrow as $row) {
						  $data = array('membership_id' => 0, 'mem_expire' => "0000-00-00 00:00:00");
						  self::$db->update(Users::uTable, $data, "id = " . $row->id);
						  $message->setTo(array($row->email => $row->name));
						  
						  $numSent++;
						  $mailer->send($message, $failedRecipients);
					  }
	
					  unset($row);
	
				  break;
			  }
		  }
	  }

	  /**
	   * Membership::emailUsers()
	   * 
	   * @return
	   */
	  public function emailUsers()
	  {
	
		  Filter::checkPost('subject' . Lang::$lang, Lang::$word->_MU_NAME);
		  Filter::checkPost('body' . Lang::$lang, Lang::$word->_NL_BODY);
		  Filter::checkPost('recipient', Lang::$word->_NL_RECIPIENTS);
		  
		  
		  if (empty(Filter::$msgs)) {
			  $to = sanitize($_POST['recipient']);
			  $subject = sanitize($_POST['subject' . Lang::$lang]);
			  $body = cleanOut($_POST['body' . Lang::$lang]);
			  $numSent = 0;
			  $failedRecipients = array();
	
			  switch ($to) {
				  case "all":
					  require_once (BASEPATH . "lib/class_mailer.php");
					  $mailer = Mailer::sendMail();
					  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
	
					  $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM " . Users::uTable . " WHERE id != 1";
					  $userrow = self::$db->fetch_all($sql);
	
					  $replacements = array();
					  if ($userrow) {
						  foreach ($userrow as $cols) {
							  $replacements[$cols->email] = array(
								  '[NAME]' => $cols->name,
								  '[SITE_NAME]' => Registry::get("Core")->site_name,
								  '[URL]' => SITEURL);
						  }
	
						  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
						  $mailer->registerPlugin($decorator);
	
						  $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
									->setBody($body, 'text/html');
	
						  foreach ($userrow as $row) {
							  $message->setTo(array($row->email => $row->name));
							  $numSent++;
							  $mailer->send($message, $failedRecipients);
						  }
						  unset($row);
					  }
					  break;
	
				  case "newsletter":
					  require_once (BASEPATH . "lib/class_mailer.php");
					  $mailer = Mailer::sendMail();
					  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
	
					  $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM " . Users::uTable . " WHERE newsletter = 1 AND id != 1";
					  $userrow = self::$db->fetch_all($sql);
	
					  $replacements = array();
					  if ($userrow) {
						  foreach ($userrow as $cols) {
							  $replacements[$cols->email] = array(
								  '[NAME]' => $cols->name,
								  '[SITE_NAME]' => Registry::get("Core")->site_name,
								  '[URL]' => SITEURL);
						  }
	
						  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
						  $mailer->registerPlugin($decorator);
	
						  $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
									->setBody($body, 'text/html');
	
						  foreach ($userrow as $row) {
							  $message->setTo(array($row->email => $row->name));
							  $numSent++;
							  $mailer->send($message, $failedRecipients);
						  }
						  unset($row);
					  }
					  break;
	
				  case "free":
					  require_once (BASEPATH . "lib/class_mailer.php");
					  $mailer = Mailer::sendMail();
					  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
	
					  $sql = "SELECT email,CONCAT(fname,' ',lname) as name FROM " . Users::uTable . " WHERE membership_id = 0 AND id != 1";
					  $userrow = self::$db->fetch_all($sql);
	
					  $replacements = array();
					  if ($userrow) {
						  foreach ($userrow as $cols) {
							  $replacements[$cols->email] = array(
								  '[NAME]' => $cols->name,
								  '[SITE_NAME]' => Registry::get("Core")->site_name,
								  '[URL]' => SITEURL);
						  }
	
						  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
						  $mailer->registerPlugin($decorator);
	
						  $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
									->setBody($body, 'text/html');
	
						  foreach ($userrow as $row) {
							  $message->setTo(array($row->email => $row->name));
							  $numSent++;
							  $mailer->send($message, $failedRecipients);
						  }
	
						  unset($row);
					  }
					  break;
	
				  case "paid":
					  require_once (BASEPATH . "lib/class_mailer.php");
					  $mailer = Mailer::sendMail();
					  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
	
					  $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM " . Users::uTable . " WHERE membership_id != 0 AND id != 1";
					  $userrow = self::$db->fetch_all($sql);
	
					  $replacements = array();
					  if ($userrow) {
						  foreach ($userrow as $cols) {
							  $replacements[$cols->email] = array(
								  '[NAME]' => $cols->name,
								  '[SITE_NAME]' => Registry::get("Core")->site_name,
								  '[URL]' => SITEURL);
						  }
	
						  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
						  $mailer->registerPlugin($decorator);
	
						  $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
									->setBody($body, 'text/html');
	
						  foreach ($userrow as $row) {
							  $message->setTo(array($row->email => $row->name));
							  $numSent++;
							  $mailer->send($message, $failedRecipients);
						  }
	
						  unset($row);
	
					  }
					  break;
	
				  default:
					  require_once (BASEPATH . "lib/class_mailer.php");
					  $mailer = Mailer::sendMail();
					  $row = self::$db->first("SELECT email, CONCAT(fname,' ',lname) as name FROM " . Users::uTable . " WHERE email LIKE '%" . sanitize($to) . "%'");
					  if ($row) {
						  $newbody = str_replace(array(
							  '[NAME]',
							  '[SITE_NAME]',
							  '[URL]'), array(
							  $row->name,
							  Registry::get("Core")->site_name,
							  SITEURL), $body);
	
						  $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setTo(array($to => $row->name))
									->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
									->setBody($newbody, 'text/html');
	
	
						  $numSent++;
						  $mailer->send($message, $failedRecipients);
					  }
					  break;
			  }
	
			  if ($numSent) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($numSent . ' ' . Lang::$word->_NL_SENT_OK, false);
				  Security::writeLog(Lang::$word->_NL_SENT_OK, "", "no", "content");
			  } else {
				  $json['type'] = 'error';
				  $res = '';
				  $res .= '<ul>';
				  foreach ($failedRecipients as $failed) {
					  $res .= '<li>' . $failed . '</li>';
				  }
				  $res .= '</ul>';
				  $json['message'] = Filter::msgAlert(Lang::$word->_NL_SENT_ERR . $res, false);
				  Security::writeLog(Lang::$word->_NL_SENT_OK, "", "yes", "content");
	
				  unset($failed);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	
	  }

      /**
       * Membership::getEmailTemplates()
       * 
       * @return
       */
	  public function getEmailTemplates()
	  {
		  $sql = "SELECT * FROM " . Content::eTable . " ORDER BY name" . Lang::$lang . " ASC";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }


      /**
       * Membership::getNewsletterTemplates()
       * 
       * @return
       */
	  public function getNewsletterTemplates()
	  {
		  $sql = "SELECT * FROM " . Content::eTable . " WHERE type = 'news' ORDER BY name" . Lang::$lang . " ASC";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }
	  
	  /**
	   * Membership::processEmailTemplate()
	   * 
	   * @return
	   */
	  public function processEmailTemplate()
	  {
	
		  Filter::checkPost('name' . Lang::$lang, Lang::$word->_ET_TTITLE);
		  Filter::checkPost('subject' . Lang::$lang, Lang::$word->_ET_SUBJECT);
		  Filter::checkPost('body' . Lang::$lang, Lang::$word->_ET_BODY);
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'name' . Lang::$lang => sanitize($_POST['name' . Lang::$lang]),
				  'subject' . Lang::$lang => sanitize($_POST['subject' . Lang::$lang]),
				  'body' . Lang::$lang => $_POST['body' . Lang::$lang],
				  'help' . Lang::$lang => $_POST['help' . Lang::$lang]);
	
			  if (!Filter::$id) {
				  $data['type'] = "news";
			  }
			  (Filter::$id) ? self::$db->update(Content::eTable, $data, "id='" . Filter::$id . "'") : self::$db->insert(Content::eTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_ET_UPDATED : Lang::$word->_ET_ADDED;
	
			  if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
				  Security::writeLog($message, "", "no", "content");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

      /**
       * Membership::getGateways()
       * 
       * @return
       */
	  public function getGateways($active = false)
	  {
	
		  $where = ($active) ? "WHERE active = 1" : null;
		  $sql = "SELECT * FROM " . self::gTable . " $where ORDER BY name";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Membership::processGateway()
	   * 
	   * @return
	   */
	  public function processGateway()
	  {
	
		  Filter::checkPost('displayname', Lang::$word->_GW_NAME);
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'displayname' => sanitize($_POST['displayname']),
				  'extra' => sanitize($_POST['extra']),
				  'extra2' => sanitize($_POST['extra2']),
				  'extra3' => sanitize($_POST['extra3']),
				  'live' => intval($_POST['live']),
				  'active' => intval($_POST['active']));
	
			  self::$db->update(self::gTable, $data, "id='" . Filter::$id . "'");
	
			  if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_GW_UPDATED, false);
				  Security::writeLog(Lang::$word->_GW_UPDATED, "", "no", "content");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
	
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
  }
?>