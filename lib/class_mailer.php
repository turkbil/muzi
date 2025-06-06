<?php
  /**
   * Mailer Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: class_mailer.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Mailer
  {
	  
	  private static $instance;
	  
      /**
       * Mailer::__construct()
       * 
       * @return
       */
      private function __construct(){}

      /**
       * Mailer::instance()
       * 
       * @return
       */
	  public static function instance(){
		  if (!self::$instance){ 
			  self::$instance = new Mailer(); 
		  } 
	  
		  return self::$instance;  
	  }
	  
      /**
       * Mailer::sendMail()
       * 
	   * Sends a various messages to users
       * @return
       */
      public static function sendMail()
      {
          require_once (BASEPATH . 'lib/swift/swift_required.php');
          
          if (Registry::get("Core")->mailer == "SMTP") {
			  $SSL = (Registry::get("Core")->is_ssl) ? 'ssl' : null;
              $transport = Swift_SmtpTransport::newInstance(Registry::get("Core")->smtp_host, Registry::get("Core")->smtp_port, $SSL)
						  ->setUsername(Registry::get("Core")->smtp_user)
						  ->setPassword(Registry::get("Core")->smtp_pass);
		  } elseif (Registry::get("Core")->mailer == "SMAIL") {
			  $transport = Swift_SendmailTransport::newInstance(Registry::get("Core")->sendmail);
          } else
              $transport = Swift_MailTransport::newInstance();
          
          return Swift_Mailer::newInstance($transport);
	  }
	  
  }
  //$mail = new Mailer();
?>