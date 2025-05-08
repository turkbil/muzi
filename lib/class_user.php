<?php
  /**
   * User Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: class_user.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Users
  {
	  const uTable = "users";
	  const uaTable = "user_activity";
	  public $logged_in = null;
	  public $uid = 0;
	  public $userid = 0;
      public $username;
	  public $sesid;
	  public $email;
	  public $name;
      public $membership_id = 0;
	  public $memused = 0;
	  public $access = null;
      public $userlevel;
	  public $memvalid = null;
	  public $avatar;
	  private $lastlogin = "NOW()";
	  public $last;
	  private static $db;
      

      /**
       * Users::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::$db = Registry::get("Database");
		  $this->startSession();
      }
 

      /**
       * Users::startSession()
       * 
       * @return
       */
      private function startSession()
      {
		if (strlen(session_id()) < 1)
			session_start();
	  
		$this->logged_in = $this->loginCheck();
		
		if (!$this->logged_in) {
			$this->username = $_SESSION['TUBI_username'] = "Guest";
			$this->sesid = sha1(session_id());
			$this->userlevel = 0;
		}
      }

	  /**
	   * Users::loginCheck()
	   * 
	   * @return
	   */
	  private function loginCheck()
	  {
          if (isset($_SESSION['TUBI_username']) && $_SESSION['TUBI_username'] != "Guest") {
              
              $row = $this->getUserInfo($_SESSION['TUBI_username']);
			  $this->uid = $row->id;
              $this->username = $row->username;
			  $this->email = $row->email;
			  $this->name = $row->fname.' '.$row->lname;
              $this->userlevel = $row->userlevel;
			  $this->membership_id = $row->membership_id;
			  $this->memused = $row->memused;
			  $this->access = $row->access;
			  $this->avatar = $row->avatar;
			  $this->last = $row->lastlogin;
			  $this->sesid = sha1(session_id());
			  //$today = new DateTime('');
			  $this->memvalid = compareFloatNumbers(strtotime($row->mem_expire), strtotime(date('Y-m-d H:i:s')), "gte");
              return true;
          } else {
              return false;
          }  
	  }

	  /**
	   * Users::is_Admin()
	   * 
	   * @return
	   */
	  public function is_Admin()
	  {
		  return($this->userlevel == 9 or $this->userlevel == 8);
	  
	  }	

	  /**
	   * Users::login()
	   * 
	   * @param mixed $username
	   * @param mixed $password
	   * @return
	   */
	  public function login($username, $password)
	  {
		  
		  $timeleft = null;
		  if (!Registry::get("Security")->loginAgain($timeleft)) {
			  $minutes = ceil($timeleft / 60);
			  Filter::$msgs['username'] = str_replace("%MINUTES%", $minutes, Lang::$word->_LG_BRUTE_RERR);
		  } elseif ($username == "" && $password == "") {
			  Filter::$msgs['username'] = Lang::$word->_LG_ERROR1;
		  } else {
			  $status = $this->checkStatus($username, $password);
			  
			  switch ($status) {
				  case 0:
					  Filter::$msgs['username'] = Lang::$word->_LG_ERROR2;
					  Registry::get("Security")->setFailedLogin();
					  break;
					  
				  case 1:
					  Filter::$msgs['username'] = Lang::$word->_LG_ERROR3;
					  Registry::get("Security")->setFailedLogin();
					  break;
					  
				  case 2:
					  Filter::$msgs['username'] = Lang::$word->_LG_ERROR4;
					  Registry::get("Security")->setFailedLogin();
					  break;
					  
				  case 3:
					  Filter::$msgs['username'] = Lang::$word->_LG_ERROR5;
					  Registry::get("Security")->setFailedLogin();
					  break;
			  }
		  }
		  if (empty(Filter::$msgs) && $status == 5) {
			  $row = $this->getUserInfo($username);
			  $this->uid = $_SESSION['uid'] = $row->id;
			  $this->username = $_SESSION['TUBI_username'] = $row->username;
			  $this->name = $_SESSION['TUBI_name'] = $row->fname.' '.$row->lname;
			  $this->avatar = $_SESSION['avatar'] = $row->avatar;
			  $this->email = $_SESSION['email'] = $row->email;
			  $this->userlevel = $_SESSION['userlevel'] = $row->userlevel;
			  $this->membership_id = $_SESSION['membership_id'] = $row->membership_id;
			  $this->memused = $_SESSION['memused'] = $row->memused;
			  $this->access = $_SESSION['access'] = $row->access;
			  $this->last = $_SESSION['last'] = $row->lastlogin;

			  $data = array(
					'lastlogin' => $this->lastlogin, 
					'lastip' => sanitize($_SERVER['REMOTE_ADDR'])
			  );
			  self::$db->update(self::uTable, $data, "username='" . $this->username . "'");
			  if(!$this->validateMembership()) {
				$data = array(
					  'membership_id' => 0, 
					  'mem_expire' => "0000-00-00 00:00:00"
				);
				self::$db->update(self::uTable, $data, "username='" . $this->username . "'");
			  }
				  
			  return true;
		  } else
			  Filter::msgStatus();
	  }

      /**
       * Users::logout()
       * 
       * @return
       */
      public function logout()
      {
          unset($_SESSION['TUBI_username']);
		  unset($_SESSION['email']);
		  unset($_SESSION['name']);
          unset($_SESSION['membership_id']);
		  unset($_SESSION['memused']);
		  unset($_SESSION['access']);
          unset($_SESSION['uid']);
          session_destroy();
		  session_regenerate_id();
          
          $this->logged_in = false;
          $this->username = Lang::$word->_GUEST;
          $this->userlevel = 0;
      }
	  
	  /**
	   * Users::getUserInfo()
	   * 
	   * @param mixed $username
	   * @return
	   */
	  private function getUserInfo($username)
	  {
          $username = sanitize($username);
          $username = self::$db->escape($username);

		  $sql = "SELECT * FROM " . self::uTable . " WHERE username = '" . $username . "' OR email = '" . $username . "'";
          $row = self::$db->first($sql);
          if (!$username)
              return false;

          return ($row) ? $row : 0;
	  }

	  
	  /**
	   * Users::checkStatus()
	   * 
	   * @param mixed $username
	   * @param mixed $password
	   * @return
	   */
	  public function checkStatus($username, $password)
	  {
		  
		  $username = sanitize($username);
		  $username = self::$db->escape($username);
		  $password = sanitize($password);
		  
		  $sql = "SELECT password, active FROM " . self::uTable . " WHERE username = '" . $username . "' OR email = '" . $username . "'";
          $result = self::$db->query($sql);
          
          if (self::$db->numrows($result) == 0)
              return 0;
			  
          $row = self::$db->fetch($result);
          $entered_pass = sha1($password);
		  
          switch ($row->active) {
			  case "b":
				  return 1;
				  break;
				  
			  case "n":
				  return 2;
				  break;
				  
			  case "t":
				  return 3;
				  break;
				  
			  case "y" && $entered_pass == $row->password:
				  return 5;
				  break;
		  }
	  }

	  /**
	   * Users::getUsers()
	   * 
	   * @param bool $from
	   * @return
	   */
	  public function getUsers($from = false)
	  {
          
		  if (isset($_GET['letter']) and (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '')) {
			  $enddate = date("Y-m-d");
			  $letter = sanitize($_GET['letter'], 2);
			  $fromdate = (empty($from)) ? $_POST['fromdate_submit'] : $from;
			  if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
				  $enddate = $_POST['enddate_submit'];
			  }
			  $q = "SELECT COUNT(*) FROM " . self::uTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'"
			  . "\n AND username REGEXP '^" . self::$db->escape($letter) . "'";
			  $where = " WHERE u.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' AND username REGEXP '^" . self::$db->escape($letter) . "'";
			  
		  } elseif (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '') {
			  $enddate = date("Y-m-d");
			  $fromdate = (empty($from)) ? $_POST['fromdate_submit'] : $from;
			  if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
				  $enddate = $_POST['enddate_submit'];
			  }
			  $q = "SELECT COUNT(*) FROM " . self::uTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
			  $where = " WHERE u.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
			  
		  } elseif(isset($_GET['letter'])) {
			  $letter = sanitize($_GET['letter'], 2);
			  $where = "WHERE username REGEXP '^" . self::$db->escape($letter) . "'";
			  $q = "SELECT COUNT(*) FROM " . self::uTable . " WHERE username REGEXP '^" . self::$db->escape($letter) . "' LIMIT 1"; 
		  } else {
			  $q = "SELECT COUNT(*) FROM " . self::uTable . " LIMIT 1";
			  $where = null;
		  }
		  
          $record = self::$db->query($q);
          $total = self::$db->fetchrow($record);
          $counter = $total[0];
		  
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();	  

		  
          $sql = "SELECT u.*, CONCAT(u.fname,' ',u.lname) as name, m.title".Lang::$lang.", m.id as mid"
		  . "\n FROM " . self::uTable. " as u"
		  . "\n LEFT JOIN ".Membership::mTable." as m ON m.id = u.membership_id" 
		  . "\n $where"
		  . "\n ORDER BY u.created DESC" . $pager->limit;
          $row = self::$db->fetch_all($sql);
          
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Users::processUser()
	   * 
	   * @return
	   */
	  public function processUser()
	  {
	
		  if (!Filter::$id) {
			  Filter::checkPost('username', Lang::$word->_UR_USERNAME_R);
			  Filter::checkPost('password', Lang::$word->_PASSWORD);
	
			  if ($this->emailExists($_POST['email']))
				  Filter::$msgs['email'] = Lang::$word->_UR_EMAIL_R1;
	
			  if ($value = $this->usernameExists($_POST['username'])) {
				  if ($value == 1)
					  Filter::$msgs['username'] = Lang::$word->_UR_USERNAME_R1;
				  if ($value == 2)
					  Filter::$msgs['username'] = Lang::$word->_UR_USERNAME_R2;
				  if ($value == 3)
					  Filter::$msgs['username'] = Lang::$word->_UR_USERNAME_R3;
			  }
		  }
	
		  Filter::checkPost('fname', Lang::$word->_UR_FNAME);
		  Filter::checkPost('lname', Lang::$word->_UR_LNAME);
	
		  Filter::checkPost('email', Lang::$word->_UR_EMAIL_R);
	
		  if (!$this->isValidEmail($_POST['email']))
			  Filter::$msgs['email'] = Lang::$word->_UR_EMAIL_R2;
	
		  if (!empty($_FILES['avatar']['name'])) {
			  if (!preg_match("/(\.jpg|\.png|\.gif)$/i", $_FILES['avatar']['name'])) {
				  Filter::$msgs['avatar'] = Lang::$word->_CG_LOGO_R;
			  }
			  $file_info = getimagesize($_FILES['avatar']['tmp_name']);
			  if (empty($file_info))
				  Filter::$msgs['avatar'] = Lang::$word->_CG_LOGO_R;
		  }
	
		  $this->verifyCustomFields("profile");
	
		  if (empty(Filter::$msgs)) {
	
			  $data = array(
				  'username' => sanitize($_POST['username']),
				  'email' => sanitize($_POST['email']),
				  'lname' => sanitize($_POST['lname']),
				  'fname' => sanitize($_POST['fname']),
				  'membership_id' => intval($_POST['membership_id']),
				  'mem_expire' => $this->calculateDays($_POST['membership_id']),
				  'newsletter' => intval($_POST['newsletter']),
				  'userlevel' => intval($_POST['userlevel']),
				  'notes' => sanitize($_POST['notes']),
				  'info' => sanitize($_POST['info']),
				  'active' => sanitize($_POST['active']));
	
			  if (isset($_POST['access'])) {
				  $data['access'] = Core::_implodeFields($_POST['access']);
			  } else
				  $data['access'] = "NULL";
	
			  if (!Filter::$id)
				  $data['created'] = "NOW()";
	
			  if (Filter::$id)
				  $userrow = Core::getRowById(self::uTable, Filter::$id);
	
			  if ($_POST['password'] != "") {
				  $data['password'] = sha1($_POST['password']);
			  } else
				  $data['password'] = $userrow->password;
	
			  // Start Custom Fields
			  $fl_array = array_key_exists_wildcard($_POST, 'custom_*', 'key-value');
			  if (isset($fl_array)) {
				  $fields = $fl_array;
				  $total = count($fields);
				  if (is_array($fields)) {
					  $fielddata = '';
					  foreach ($fields as $fid) {
						  $fielddata .= $fid . "::";
					  }
				  }
				  $data['custom_fields'] = $fielddata;
			  }
	
			  // Procces Avatar
			  if (!empty($_FILES['avatar']['name'])) {
				  require_once (BASEPATH . "lib/class_resize.php");
				  Resize::instance();
				  Resize::$width = Registry::get("Core")->avatar_w;
				  Resize::$height = Registry::get("Core")->avatar_h;
				  $thumbdir = UPLOADS . "avatars/";
				  $tName = "IMG_" . randName();
				  $text = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], '.') + 1);
				  $thumbName = $thumbdir . $tName . "." . strtolower($text);
				  if ($avatar = getValueById("avatar", self::uTable, $this->uid)) {
					  @unlink($thumbdir . $avatar);
				  }
				  move_uploaded_file($_FILES['avatar']['tmp_name'], $thumbName);
				  $data['avatar'] = $tName . "." . strtolower($text);
	
				  Resize::$file = $thumbName;
				  Resize::$output = $thumbdir . $data['avatar'];
				  Resize::$delete_original = true;
				  Resize::doResize();
			  }
	
			  (Filter::$id) ? self::$db->update(self::uTable, $data, "id='" . Filter::$id . "'") : self::$db->insert(self::uTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_UR_UPDATED : Lang::$word->_UR_ADDED;
	
			  if (self::$db->affected()) {
				  Security::writeLog($message, "", "no", "content");
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
				  print json_encode($json);
				  if (isset($_POST['notify']) && intval($_POST['notify']) == 1) {
	
					  require_once (BASEPATH . "lib/class_mailer.php");
					  $mailer = Mailer::sendMail();
	
					  $row = Registry::get("Core")->getRowById(Content::eTable, 3);
	
					  $body = str_replace(array(
						  '[USERNAME]',
						  '[PASSWORD]',
						  '[NAME]',
						  '[SITE_NAME]',
						  '[URL]'), array(
						  $data['username'],
						  $_POST['password'],
						  $data['fname'] . ' ' . $data['lname'],
						  Registry::get("Core")->site_name,
						  SITEURL), $row->{'body' . Lang::$lang});
	
					  $msg = Swift_Message::newInstance()
							->setSubject($row->{'subject' . Lang::$lang})
							->setTo(array($data['email'] => $data['fname'] . ' ' . $data['lname']))
							->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
							->setBody(cleanOut($body), 'text/html');
	
					  $mailer->send($msg);
				  }
			  } else {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
				  print json_encode($json);
			  }
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

	  /**
	   * verifyCustomFields()
	   * 
	   * @param mixed $type
	   * @return
	   */
	  public function verifyCustomFields($type)
	  {
	
		  if ($fdata = self::$db->fetch_all("SELECT * FROM " . Content::cfTable . " WHERE type = '" . $type . "' AND active = 1 AND req = 1")) {
	
			  $res = '';
			  foreach ($fdata as $cfrow) {
				  if (empty($_POST['custom_' . $cfrow->name]))
					  $res .= Filter::$msgs['custom_' . $cfrow->name] = Lang::$word->_CFL_ENTER_F . $cfrow->{'title' . Lang::$lang};
			  }
			  return $res;
			  unset($cfrow);
	
		  }
	
	  } 

	  /**
	   * Users::updateProfile()
	   * 
	   * @return
	   */
	  public function updateProfile()
	  {

		  Filter::checkPost('fname', Lang::$word->_UR_FNAME);
		  Filter::checkPost('lname', Lang::$word->_UR_LNAME);
		  Filter::checkPost('email', Lang::$word->_UR_EMAIL);

		  if (!$this->isValidEmail($_POST['email']))
			  Filter::$msgs['email'] = Lang::$word->_UR_EMAIL_R2;

		  if (!empty($_FILES['avatar']['name'])) {
			  if (!preg_match("/(\.jpg|\.png|\.gif)$/i", $_FILES['avatar']['name'])) {
				  Filter::$msgs['avatar'] = Lang::$word->_CG_LOGO_R;
			  }
			  if ($_FILES["avatar"]["size"] > 307200) {
				  Filter::$msgs['avatar'] = Lang::$word->_UA_AVATAR_SIZE;
			  }
			  $file_info = getimagesize($_FILES['avatar']['tmp_name']);
			  if(empty($file_info))
				  Filter::$msgs['avatar'] = Lang::$word->_CG_LOGO_R;
		  }
		  
		  $this->verifyCustomFields("profile");

		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'email' => sanitize($_POST['email']), 
				  'lname' => sanitize($_POST['lname']), 
				  'fname' => sanitize($_POST['fname']), 
				  'fb_link' => sanitize($_POST['fb_link']),
				  'tw_link' => sanitize($_POST['tw_link']),
				  'gp_link' => sanitize($_POST['gp_link']),
				  'info' => sanitize($_POST['info']), 
				  'newsletter' => intval($_POST['newsletter'])
			  );
				   
			  $userpass = getValueById("password", self::uTable, $this->uid);
			  
			  if ($_POST['password'] != "") {
				  $data['password'] = sha1($_POST['password']);
			  } else
				  $data['password'] = $userpass;

			  $fl_array = array_key_exists_wildcard($_POST, 'custom_*', 'key-value');
			  if (isset($fl_array)) {
				  $fields = $fl_array;
				  $total = count($fields);
				  if (is_array($fields)) {
					  $fielddata = '';
					  foreach ($fields as $fid) {
						  $fielddata .= $fid . "::";
					  }
				  }
				  $data['custom_fields'] = $fielddata;
			  } 
			  
			  // Start Avatar Upload
			  if (!empty($_FILES['avatar']['name'])) {
				  require_once (BASEPATH . "lib/class_resize.php");
				  Resize::instance();
				  Resize::$width = Registry::get("Core")->avatar_w;
				  Resize::$height = Registry::get("Core")->avatar_h;
				  $thumbdir = UPLOADS . "avatars/";
				  $tName = "IMG_" . randName();
				  $text = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], '.') + 1);
				  $thumbName = $thumbdir . $tName . "." . strtolower($text);
				  if ($avatar = getValueById("avatar", self::uTable, $this->uid)) {
					  @unlink($thumbdir . $avatar);
				  }
				  move_uploaded_file($_FILES['avatar']['tmp_name'], $thumbName);
				  $data['avatar'] = $tName . "." . strtolower($text);
	
				  Resize::$file = $thumbName;
				  Resize::$output = $thumbdir . $data['avatar'];
				  Resize::$delete_original = true;
				  Resize::doResize();
			  }
			  
			  self::$db->update(self::uTable, $data, "id=" . $this->uid);

			  if (self::$db->affected()) {
				  $json['status'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_UA_UPDATEOK, false);
				  Security::writeLog(Lang::$word->_USER . ' ' . $this->username. ' ' . Lang::$word->_LG_PROFILE_UPDATED, "user", "no", "user");
			  } else {
				  $json['status'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);

		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

      /**
       * User::register()
       * 
       * @return
       */
	  public function register()
	  {
	
		  Filter::checkPost('username', Lang::$word->_UR_USERNAME_R);
	
		  if ($value = $this->usernameExists($_POST['username'])) {
			  if ($value == 1)
				  Filter::$msgs['username'] = Lang::$word->_UR_USERNAME_R1;
			  if ($value == 2)
				  Filter::$msgs['username'] = Lang::$word->_UR_USERNAME_R2;
			  if ($value == 3)
				  Filter::$msgs['username'] = Lang::$word->_UR_USERNAME_R3;
		  }
	
		  Filter::checkPost('fname', Lang::$word->_UR_FNAME);
		  Filter::checkPost('lname', Lang::$word->_UR_LNAME);
		  Filter::checkPost('pass', Lang::$word->_UR_PASSWORD_R);
	
		  if (strlen($_POST['pass']) < 6)
			  Filter::$msgs['pass'] = Lang::$word->_UR_PASSWORD_R1;
		  elseif (!preg_match("/^[a-z0-9_-]{6,15}$/", ($_POST['pass'] = trim($_POST['pass']))))
			  Filter::$msgs['pass'] = Lang::$word->_UR_PASSWORD_R2;
		  elseif ($_POST['pass'] != $_POST['pass2'])
			  Filter::$msgs['pass'] = Lang::$word->_UR_PASSWORD_R3;
	
		  Filter::checkPost('email', Lang::$word->_UR_EMAIL_R);
	
		  if ($this->emailExists($_POST['email']))
			  Filter::$msgs['email'] = Lang::$word->_UR_EMAIL_R1;
	
		  if (!$this->isValidEmail($_POST['email']))
			  Filter::$msgs['email'] = Lang::$word->_UR_EMAIL_R2;
	
		  Filter::checkPost('captcha', Lang::$word->_UA_REG_RTOTAL_R);
	
		  if ($_SESSION['captchacode'] != $_POST['captcha'])
			  Filter::$msgs['captcha'] = Lang::$word->_UA_REG_RTOTAL_R1;
	
		  $this->verifyCustomFields("register");
	
		  if (empty(Filter::$msgs)) {
			  $token = (Registry::get("Core")->reg_verify == 1) ? $this->generateRandID() : 0;
			  $pass = sanitize($_POST['pass']);
	
			  if (Registry::get("Core")->reg_verify == 1) {
				  $active = "t";
			  } elseif (Registry::get("Core")->auto_verify == 0) {
				  $active = "n";
			  } else {
				  $active = "y";
			  }
	
			  $data = array(
				  'username' => sanitize($_POST['username']),
				  'password' => sha1($_POST['pass']),
				  'email' => sanitize($_POST['email']),
				  'fname' => sanitize($_POST['fname']),
				  'lname' => sanitize($_POST['lname']),
				  'token' => $token,
				  'active' => $active,
				  'created' => "NOW()");
	
			  $fl_array = array_key_exists_wildcard($_POST, 'custom_*', 'key-value');
			  if (isset($fl_array)) {
				  $fields = $fl_array;
				  $total = count($fields);
				  if (is_array($fields)) {
					  $fielddata = '';
					  foreach ($fields as $fid) {
						  $fielddata .= $fid . "::";
					  }
				  }
				  $data['custom_fields'] = $fielddata;
			  }
	
			  self::$db->insert(self::uTable, $data);
	
			  require_once (BASEPATH . "lib/class_mailer.php");
	
			  if (Registry::get("Core")->reg_verify == 1) {
				  $pars = '?email="' . $data['email'] . '&token="' . $token;
				  $actlink = Url::Page(Registry::get("Core")->activate_page, $pars);
				  $row = Core::getRowById(Content::eTable, 1);
	
				  $body = str_replace(array(
					  '[NAME]',
					  '[USERNAME]',
					  '[PASSWORD]',
					  '[TOKEN]',
					  '[EMAIL]',
					  '[URL]',
					  '[LINK]',
					  '[SITE_NAME]'), array(
					  $data['fname'] . ' ' . $data['lname'],
					  $data['username'],
					  $_POST['pass'],
					  $token,
					  $data['email'],
					  SITEURL,
					  $actlink,
					  Registry::get("Core")->site_name), $row->{'body' . Lang::$lang});
	
				  $newbody = cleanOut($body);
	
				  $mailer = Mailer::sendMail();
				  $message = Swift_Message::newInstance()
							->setSubject($row->{'subject' . Lang::$lang})
							->setTo(array($data['email'] => $data['username']))
							->setFrom(array(Registry::get("Core")->site_email =>Registry::get("Core")->site_name))
							->setBody($newbody, 'text/html');
	
				  $mailer->send($message);
	
			  } elseif (Registry::get("Core")->auto_verify == 0) {
				  $row = Core::getRowById(Content::eTable, 14);
				  $body = str_replace(array(
					  '[NAME]',
					  '[USERNAME]',
					  '[PASSWORD]',
					  '[URL]',
					  '[SITE_NAME]'), array(
					  $data['fname'] . ' ' . $data['lname'],
					  $data['username'],
					  $_POST['pass'],
					  SITEURL,
					  Registry::get("Core")->site_name), $row->{'body' . Lang::$lang});
	
				  $newbody = cleanOut($body);
	
				  $mailer = Mailer::sendMail();
				  $message = Swift_Message::newInstance()
							->setSubject($row->{'subject' . Lang::$lang})
							->setTo(array($data['email'] => $data['username']))
							->setFrom(array(Registry::get("Core")->site_email =>Registry::get("Core")->site_name))
							->setBody($newbody, 'text/html');
	
				  $mailer->send($message);
	
			  } else {
				  $row = Core::getRowById(Content::eTable, 7);
				  $body = str_replace(array(
					  '[NAME]',
					  '[USERNAME]',
					  '[PASSWORD]',
					  '[URL]',
					  '[SITE_NAME]'), array(
					  $data['fname'] . ' ' . $data['lname'],
					  $data['username'],
					  $_POST['pass'],
					  SITEURL,
					  Registry::get("Core")->site_name), $row->{'body' . Lang::$lang});
	
				  $newbody = cleanOut($body);
	
				  $mailer = Mailer::sendMail();
				  $message = Swift_Message::newInstance()
							->setSubject($row->{'subject' . Lang::$lang})
							->setTo(array($data['email'] => $data['username']))
							->setFrom(array(Registry::get("Core")->site_email =>Registry::get("Core")->site_name))
							->setBody($newbody, 'text/html');
	
				  $mailer->send($message);
	
			  }
			  if (Registry::get("Core")->notify_admin) {
				  $arow = Core::getRowById(Content::eTable, 13);
				  $abody = str_replace(array(
					  '[USERNAME]',
					  '[EMAIL]',
					  '[NAME]',
					  '[IP]'), array(
					  $data['username'],
					  $data['email'],
					  $data['fname'] . ' ' . $data['lname'],
					  $_SERVER['REMOTE_ADDR']), $arow->{'body' . Lang::$lang});
	
				  $anewbody = cleanOut($abody);
	
				  $amailer = Mailer::sendMail();
				  $amessage = Swift_Message::newInstance()
							->setSubject($arow->{'subject' . Lang::$lang})
							->setTo(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
							->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
							->setBody($anewbody, 'text/html');
	
				  $amailer->send($amessage);
			  }
	
			  if (self::$db->affected()) {
				  $json['status'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_UA_REG_OK, false);
				  Security::writeLog(Lang::$word->_USER . ' ' . $data['username'] . ' ' . Lang::$word->_LG_USER_REGGED, "user", "no", "user");
				  print json_encode($json);
			  } else {
				  $json['message'] = Filter::msgAlert(Lang::$word->_UA_REG_ERR, false);
				  print json_encode($json);
				  Security::writeLog(Lang::$word->_UA_REG_ERR, "user", "yes", "user");
			  }
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
	  
      /**
       * User::passReset()
       * 
       * @return
       */
	  public function passReset()
	  {
	
		  Filter::checkPost('uname', Lang::$word->_UR_USERNAME_R);
		  Filter::checkPost('email', Lang::$word->_UR_EMAIL_R);
	
		  $uname = $this->usernameExists($_POST['uname']);
		  if (strlen($_POST['uname']) < 4 || strlen($_POST['uname']) > 30 || !preg_match("/^[a-z0-9_-]{4,15}$/", $_POST['uname']) || $uname != 3)
			  Filter::$msgs['uname'] = Lang::$word->_UR_USERNAME_R0;
	
	
		  if (!$this->emailExists($_POST['email']))
			  Filter::$msgs['uname'] = Lang::$word->_UR_EMAIL_R3;
	
		  Filter::checkPost('captcha', Lang::$word->_UA_PASS_RTOTAL_R);
	
		  if ($_SESSION['captchacode'] != $_POST['captcha'])
			  Filter::$msgs['captcha'] = Lang::$word->_UA_PASS_RTOTAL_R1;
	
		  if (empty(Filter::$msgs)) {
	
			  $user = $this->getUserInfo($_POST['uname']);
			  $randpass = $this->getUniqueCode(12);
			  $newpass = sha1($randpass);
	
			  $data['password'] = $newpass;
	
			  self::$db->update(self::uTable, $data, "username = '" . $user->username . "'");
	
			  require_once (BASEPATH . "lib/class_mailer.php");
			  $row = Core::getRowById(Content::eTable, 2);
	
			  $body = str_replace(array(
				  '[USERNAME]',
				  '[PASSWORD]',
				  '[URL]',
				  '[LINK]',
				  '[IP]',
				  '[SITE_NAME]'), array(
				  $user->username,
				  $randpass,
				  SITEURL,
				  Url::Page(Registry::get("Core")->login_page),
				  $_SERVER['REMOTE_ADDR'],
				  Registry::get("Core")->site_name), $row->{'body' . Lang::$lang});
	
			  $newbody = cleanOut($body);
	
			  $mailer = Mailer::sendMail();
			  $message = Swift_Message::newInstance()
						->setSubject($row->{'subject' . Lang::$lang})
						->setTo(array($user->email => $user->username))
						->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
						->setBody($newbody, 'text/html');
	
			  if (self::$db->affected() and $mailer->send($message)) {
				  Security::writeLog(Lang::$word->_USER . ' ' . $user->username . ' ' . Lang::$word->_UA_PASS_R_OK, "", "no", "content");
				  $json['status'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_UA_PASS_R_OK, false);
			  } else {
				  $json['status'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_UA_PASS_R_ERR, false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
	  
      /**
       * User::activateUser()
       * 
       * @return
       */
	  public function activateUser()
	  {
	
		  Filter::checkPost('email', Lang::$word->_UR_EMAIL_R);
	
		  if (!$this->emailExists($_POST['email']))
			  Filter::$msgs['email'] = Lang::$word->_UR_EMAIL_R3;
	
		  Filter::checkPost('token', Lang::$word->_UA_TOKEN_R1);
	
		  if (!$this->validateToken($_POST['token']))
			  Filter::$msgs['token'] = Lang::$word->_UA_TOKEN_R;
	
		  if (empty(Filter::$msgs)) {
			  $email = sanitize($_POST['email']);
			  $token = sanitize($_POST['token']);
	
			  $data = array('token' => 0, 'active' => (Registry::get("Core")->auto_verify) ? "y" : "n");
	
			  self::$db->update(self::uTable, $data, "email = '" . $email . "' AND token = '" . $token . "'");
			  $message = (Registry::get("Core")->auto_verify == 1) ? Lang::$word->_UA_TOKEN_OK1 : Lang::$word->_UA_TOKEN_OK2;
	
			  if (self::$db->affected()) {
				  Security::writeLog($message, "", "no", "content");
				  $json['status'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
			  } else {
				  $json['status'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_UA_TOKEN_R_ERR, false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

	  /**
	   * Users::getUserData()
	   * 
	   * @return
	   */
	  public function getUserData()
	  {
	
		  $sql = "SELECT * FROM " . self::uTable 
		  . "\n WHERE id = " . $this->uid;
		  $row = self::$db->first($sql);
	
		  return ($row) ? $row : 0;
	  }
	  
	  /**
	   * Users::getUserMembership()
	   * 
	   * @return
	   */
	  public function getUserMembership()
	  {
		  		  
          $sql = "SELECT u.*, m.title". Lang::$lang .", m.price, m.days, m.period"
		  . "\n FROM " . self::uTable. " as u"
		  . "\n LEFT JOIN " . Membership::mTable . " as m ON m.id = u.membership_id" 
		  . "\n WHERE u.id = " . $this->uid;
          $row = self::$db->first($sql);
          
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Users::getPublicProfile()
	   * 
	   * @return
	   */
	  public function getPublicProfile()
	  {
		  		  
          $sql = "SELECT *, UNIX_TIMESTAMP(lastlogin) as lastseen FROM " . self::uTable
		  . "\n WHERE username = '" . Registry::get("Content")->_url[2] . "'"
		  . "\n AND active = 'y'";
          $row = self::$db->first($sql);
          
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Users::getPublicProfile()
	   * 
	   * @return
	   */
	  public function getUserActivity($uid)
	  {
		  		  
          $sql = "SELECT *, UNIX_TIMESTAMP(created) as adate FROM " . self::uaTable
		  . "\n WHERE uid = " . $uid
		  . "\n ORDER BY created DESC";
          $row = self::$db->fetch_all($sql);
          
		  return ($row) ? $row : 0;
	  }
	  
	  /**
	   * Users::calculateDays()
	   * 
	   * @return
	   */
	  public function calculateDays($membership_id)
	  {
	
		  $now = date('Y-m-d H:i:s');
		  $row = self::$db->first("SELECT days, period FROM " . Membership::mTable . " WHERE id = " . (int)$membership_id);
		  if ($row) {
			  switch ($row->period) {
				  case "D":
					  $diff = $row->days;
					  break;
				  case "W":
					  $diff = $row->days * 7;
					  break;
				  case "M":
					  $diff = $row->days * 30;
					  break;
				  case "Y":
					  $diff = $row->days * 365;
					  break;
			  }
			  $expire = date("Y-m-d H:i:s", strtotime($now . + $diff . " days"));
		  } else {
			  $expire = "0000-00-00 00:00:00";
		  }
		  return $expire;
	  }

      /**
       * User::trialUsed()
       * 
       * @return
       */
	  public function trialUsed()
	  {
	
		  $sql = "SELECT trial_used" 
		  . "\n FROM " . self::uTable 
		  . "\n WHERE id =" . $this->uid 
		  . "\n LIMIT 1";
		  
		  $row = self::$db->first($sql);
		  return ($row->trial_used == 1) ? true : false;
	  }

	  
	  /**
	   * Users::validateMembership()
	   * 
	   * @return
	   */
	  public function validateMembership()
	  {
		  
		  $sql = "SELECT mem_expire" 
		  . "\n FROM " . self::uTable
		  . "\n WHERE id = " . $this->uid
		  . "\n AND TO_DAYS(mem_expire) > TO_DAYS(NOW())";
		  $row = self::$db->first($sql);
		  
		  return ($row) ? $row : 0;
	  }
	  	  	  	  
	  /**
	   * Users::usernameExists()
	   * 
	   * @param mixed $username
	   * @return
	   */
	  private function usernameExists($username)
	  {
	
		  $username = sanitize($username);
		  if (strlen(self::$db->escape($username)) < 4)
			  return 1;
	
		  //Username should contain only alphabets, numbers, underscores or hyphens.Should be between 4 to 15 characters long
		  $valid_uname = "/^[a-zA-Z0-9_-]{4,15}$/";
		  if (!preg_match($valid_uname, $username))
			  return 2;
	
		  $sql = self::$db->query("SELECT username" 
		  . "\n FROM " . self::uTable
		  . "\n WHERE username = '" . $username . "'" 
		  . "\n LIMIT 1");
	
		  $count = self::$db->numrows($sql);
	
		  return ($count > 0) ? 3 : false;
	  } 	
	   
	  /**
	   * User::emailExists()
	   * 
	   * @param mixed $email
	   * @return
	   */
	  private function emailExists($email)
	  {
		  
		  $sql = self::$db->query("SELECT email" 
		  . "\n FROM " .self::uTable
		  . "\n WHERE email = '" . sanitize($email) . "'" 
		  . "\n LIMIT 1");
		  
		  if (self::$db->numrows($sql) == 1) {
			  return true;
		  } else
			  return false;
	  }
	  
	  /**
	   * User::isValidEmail()
	   * 
	   * @param mixed $email
	   * @return
	   */
	  private function isValidEmail($email)
	  {
		  if (function_exists('filter_var')) {
			  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				  return true;
			  } else
				  return false;
		  } else
			  return preg_match('/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $email);
	  } 	

      /**
       * User::validateToken()
       * 
       * @param mixed $token
       * @return
       */
	  private function validateToken($token)
	  {
		  $token = sanitize($token, 40);
		  $sql = "SELECT token" 
		  . "\n FROM " . self::uTable 
		  . "\n WHERE token ='" . self::$db->escape($token) . "'" 
		  . "\n LIMIT 1";
		  
		  $result = self::$db->query($sql);
	
		  if (self::$db->numrows($result))
			  return true;
	  }
	  
	  /**
	   * Users::getUniqueCode()
	   * 
	   * @param string $length
	   * @return
	   */
	  private function getUniqueCode($length = "")
	  {
		  $code = md5(uniqid(rand(), true));
		  if ($length != "") {
			  return substr($code, 0, $length);
		  } else
			  return $code;
	  }

	  /**
	   * Users::generateRandID()
	   * 
	   * @return
	   */
	  private function generateRandID()
	  {
		  return sha1($this->getUniqueCode(24));
	  }

      /**
       * Users::getPermissionList()
       * 
       * @param bool $access
       * @return
       */
	  public function getPermissionList($access = false)
	  {
	
		  $moddata = self::$db->fetch_all("SELECT title" . Lang::$lang . ", modalias FROM " . Content::mdTable . " WHERE hasconfig = 1");
		  $plugdata = self::$db->fetch_all("SELECT title" . Lang::$lang . ", plugalias FROM " . Content::plTable);
	
		  $data = '';
	
		  if ($access) {
			  $arr = explode(",", $access);
			  reset($arr);
		  }
	
		  $data .= '<select name="access[]" multiple="multiple">';
		  foreach (self::getPermissionValues() as $key => $val) {
			  if ($access && $arr) {
				  $selected = (in_array($key, $arr)) ? " selected=\"selected\"" : "";
			  } else
				  $selected = null;
			  $data .= "<option $selected value=\"" . $key . "\">" . $val . "</option>\n";
		  }
		  unset($val);
	
		  if ($moddata) {
			  $data .= "<optgroup label=\"" . Lang::$word->_N_MODS . "\">\n";
			  foreach ($moddata as $mval) {
				  if ($access && $arr) {
					  $selected = (in_array($mval->modalias, $arr)) ? " selected=\"selected\"" : "";
				  } else
					  $selected = null;
				  $data .= "<option $selected value=\"" . $mval->modalias . "\">-- " . $mval->{'title' . Lang::$lang} . "</option>\n";
			  }
			  $data .= "</optgroup>\n";
			  unset($mval);
		  }
	
		  if ($plugdata) {
			  $data .= "<optgroup label=\"" . Lang::$word->_N_PLUGS . "\">\n";
			  foreach ($plugdata as $pval) {
				  if ($access && $arr) {
					  $selected = (in_array($pval->plugalias, $arr)) ? " selected=\"selected\"" : "";
				  } else
					  $selected = null;
				  $data .= "<option $selected value=\"" . $pval->plugalias . "\">-- " . $pval->{'title' . Lang::$lang} . "</option>\n";
			  }
			  $data .= "</optgroup>\n";
			  unset($pval);
		  }
	
		  $data .= "</select>";
	
		  return $data;
	  }

	  /**
	   * Users::getAcl()
	   * 
	   * @param string $content
	   * @return
	   */
	  public function getAcl($content)
	  {
		  if ($this->userlevel == 8) {
			  $arr = explode(",", $this->access);
			  reset($arr);
			  
			  if (in_array($content, $arr)) {
				  return true;
			  } else
				  return false;
		  } else
			  return true;
	  }
	  	  
      /**
       * Users::getPermissionValues()
       * 
       * @return
       */
	  private static function getPermissionValues()
	  {
		  $arr = array(
			  'Menus' => Lang::$word->_N_MENUS,
			  'Pages' => Lang::$word->_N_PAGES,
			  'Posts' => Lang::$word->_N_POSTS,
			  'Memberships' => Lang::$word->_N_MEMBS,
			  'Gateways' => Lang::$word->_N_GATES,
			  'Transactions' => Lang::$word->_N_TRANS,
			  'Layout' => Lang::$word->_N_LAYS,
			  'Users' => Lang::$word->_N_USERS,
			  'Configuration' => Lang::$word->_N_CONF,
			  'Templates' => Lang::$word->_N_EMAILS,
			  'Newsletter' => Lang::$word->_N_NEWSL,
			  'Language' => Lang::$word->_N_LANGS,
			  'Logs' => Lang::$word->_N_LOGS,
			  'Fields' => Lang::$word->_N_FIELDS,
			  'FM' => Lang::$word->_FM_TITLE,
			  'System' => Lang::$word->_N_SYSTEM,
			  'Backup' => Lang::$word->_UP_DBACKUP,
			  'Modules' => Lang::$word->_N_MODS,
			  'Plugins' => Lang::$word->_N_PLUGS);
	
		  return $arr;
	  }	  	  	  	   
  }
?>