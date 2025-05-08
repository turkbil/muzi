<?php
  /**
   * Send Mail
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: sendmail.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  require_once("../init.php");
?>
<?php
  $post = (!empty($_POST)) ? true : false;
  
  if ($post) {
      Filter::checkPost("name", Lang::$word->_CF_NAME_R);
      Filter::checkPost("email", Lang::$word->_CF_EMAIL_R);
      
      if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $_POST['email']))
          Filter::$msgs['email'] = Lang::$word->_CF_EMAIL_ERR;
      
      Filter::checkPost("message", Lang::$word->_CF_MSG);
	  Filter::checkPost("code", Lang::$word->_CF_TOTAL_R);
      
	  if ($_SESSION['captchacode'] != $_POST['code'])
          Filter::$msgs['code'] = Lang::$word->_CF_TOTAL_ERR;

      
      if (empty(Filter::$msgs)) {
          
          $sender_email = sanitize($_POST['email']);
          $name = sanitize($_POST['name']);
		  $phone = sanitize($_POST['phone']);
          $message = strip_tags($_POST['message']);
		  $mailsubject = sanitize($_POST['subject']);
		  $ip = sanitize($_SERVER['REMOTE_ADDR']);

		  require_once(BASEPATH . "lib/class_mailer.php");
		  $mailer = Mailer::sendMail();	
					  		  
		  $row = Registry::get("Core")->getRowById(Content::eTable, 10);
		  
		  $body = str_replace(array('[MESSAGE]', '[SENDER]', '[NAME]', '[PHONE]', '[MAILSUBJECT]', '[IP]', '[SITE_NAME]', '[URL]'), 
		  array($message, $sender_email, $name, $phone, $mailsubject, $ip, $core->site_name, SITEURL), $row->{'body'.Lang::$lang});

		  $msg = Swift_Message::newInstance()
					->setSubject($row->{'subject'.Lang::$lang})
					->setTo(array($core->site_email => $core->site_name))
					->setFrom(array($sender_email => $name))
					->setBody(cleanOut($body), 'text/html');


		  if ($mailer->send($msg)) {
			  $json['status'] = 'success';
			  $json['message'] = Filter::msgOk(Lang::$word->_CF_OK, false);
			  Security::writeLog(Lang::$word->_USER . ' ' . $user->username . ' ' . Lang::$word->_LG_CONTACT_SENT, "", "no", "contact");
			  print json_encode($json);
		  } else {
			  $json['message'] = Filter::msgAlert(Lang::$word->_CF_ERROR, false);
			  print json_encode($json);
			  Security::writeLog(Lang::$word->_CF_ERROR, "", "yes", "contact");
		  }

      } else {
		  $json['message'] = Filter::msgStatus();
		  print json_encode($json);
	  }
  }
?>