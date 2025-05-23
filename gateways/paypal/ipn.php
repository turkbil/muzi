<?php
  /**
   * PayPal IPN
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: ipn.php, v4.00 2014-04-12 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  define("_PIPN", true);


  ini_set('log_errors', true);
  ini_set('error_log', dirname(__file__) . '/ipn_errors.log');

  if (isset($_POST['payment_status'])) {
      require_once ("../../init.php");
      require_once (BASEPATH . "lib/class_pp.php");

      $pp = Core::getRow(Membership::gTable, "name", "paypal");

      $listener = new IpnListener();
      $listener->use_live = $pp->live;
      $listener->use_ssl = true;
      $listener->use_curl = false;

      try {
          $listener->requirePostMethod();
          $ppver = $listener->processIpn();
      }
      catch (exception $e) {
          error_log($e->getMessage(), 3, "pp_errorlog.log");
          exit(0);
      }

      $payment_status = $_POST['payment_status'];
      $receiver_email = $_POST['business'];
	  $mc_currency = $_POST['mc_currency'];
      list($membership_id, $user_id) = explode("_", $_POST['item_number']);
      $mc_gross = $_POST['mc_gross'];
      $txn_id = $_POST['txn_id'];

      $getxn_id = Core::verifyTxnId($txn_id);
      $price = getValueById("price", Membership::mTable, intval($membership_id));
      $v1 = compareFloatNumbers($mc_gross, $price, "=");

      if ($ppver) {
          if ($_POST['payment_status'] == 'Completed') {
              if ($receiver_email == $pp->extra && $v1 == true && $getxn_id == true) {
                  $sql = "SELECT * FROM " . Membership::mTable . " WHERE id=" . (int)$membership_id;
                  $row = $db->first($sql);

                  $username = getValueById("username", Users::uTable, (int)$user_id);

                  $data = array(
                      'txn_id' => $txn_id,
                      'membership_id' => $row->id,
                      'user_id' => (int)$user_id,
                      'rate_amount' => (float)$mc_gross,
                      'ip' => $_SERVER['REMOTE_ADDR'],
                      'created' => "NOW()",
                      'pp' => "PayPal",
                      'currency' => sanitize($mc_currency),
                      'status' => 1);

                  $db->insert(Membership::pTable, $data);

                  $udata = array(
                      'membership_id' => $row->id,
                      'mem_expire' => $user->calculateDays($row->id),
                      'trial_used' => ($row->trial == 1) ? 1 : 0,
                      'memused' => 1);

                  $db->update(Users::uTable, $udata, "id=" . (int)$user_id);

                  /* == Notify Administrator == */
                  require_once (BASEPATH . "lib/class_mailer.php");
                  $row2 = Core::getRowById(Content::eTable, 5);

                  $body = str_replace(array(
                      '[USERNAME]',
                      '[ITEMNAME]',
                      '[PRICE]',
                      '[STATUS]',
                      '[PP]',
                      '[IP]'), array(
                      $username,
                      $row->{'title' . Lang::$lang},
                      $core->formatMoney($mc_gross),
                      "Completed",
                      "PayPal",
                      $_SERVER['REMOTE_ADDR']), $row2->{'body' . Lang::$lang}
					  );

                  $newbody = cleanOut($body);

                  $mailer = Mailer::sendMail();
                  $message = Swift_Message::newInstance()
							->setSubject($row2->{'subject' . Lang::$lang})
							->setTo(array($core->site_email => $core->site_name))
							->setFrom(array($core->site_email => $core->site_name))
							->setBody($newbody, 'text/html');

                  $mailer->send($message);
                  Security::writeLog($username . ' ' . Lang::$word->_LG_PAYMENT_OK . ' ' . $row->{'title' . Lang::$lang}, "", "yes", "payment");
              }

          } else {
              /* == Failed Transaction= = */
              require_once (BASEPATH . "lib/class_mailer.php");
              $row2 = Core::getRowById(Content::eTable, 6);
              $itemname = getValueById("title" . Lang::$lang, Membership::mTable, $membership_id);
              $username = getValueById("username", Users::uTable, (int)$user_id);

              $body = str_replace(array(
                  '[USERNAME]',
                  '[ITEMNAME]',
                  '[PRICE]',
                  '[STATUS]',
                  '[PP]',
                  '[IP]'), array(
                  $username,
                  $itemname,
                  $core->formatMoney($mc_gross),
                  "Failed",
                  "PayPal",
                  $_SERVER['REMOTE_ADDR']), $row2->{'body' . Lang::$lang}
				  );

              $newbody = cleanOut($body);

              $mailer = Mailer::sendMail();
              $message = Swift_Message::newInstance()
						->setSubject($row2->{'subject' . Lang::$lang})
						->setTo(array($core->site_email => $core->site_name))
						->setFrom(array($core->site_email => $core->site_name))
						->setBody($newbody, 'text/html');

              $mailer->send($message);

              Security::writeLog(Lang::$word->_LG_PAYMENT_ERR . $username, "", "yes", "payment");

          }
      }
  }
?>