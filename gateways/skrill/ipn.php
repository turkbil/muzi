<?php
  /**
   * Skrill IPN
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: ipn.php, v4.00 2014-04-14 15:14:02 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  require_once ("../../init.php");

  /* only for debuggin purpose. Create logfile.txt and chmot to 0777
  ob_start();
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';
  $logInfo = ob_get_contents();
  ob_end_clean();
  
  $file = fopen('logfile.txt', 'a');
  fwrite($file, $logInfo);
  fclose($file);
  */

  /* Check for mandatory fields */
  $r_fields = array(
      'status',
      'md5sig',
      'merchant_id',
      'pay_to_email',
      'mb_amount',
      'mb_transaction_id',
      'currency',
      'amount',
      'transaction_id',
      'pay_from_email',
      'mb_currency');
  $mb_secret = getValue("extra3", Membership::gTable, "name = 'skrill'");

  foreach ($r_fields as $f)
      if (!isset($_POST[$f]))
          die();

  /* Check for MD5 signature */
  $md5 = strtoupper(md5($_POST['merchant_id'] . $_POST['transaction_id'] . strtoupper(md5($mb_secret)) . $_POST['mb_amount'] . $_POST['mb_currency'] . $_POST['status']));
  if ($md5 != $_POST['md5sig'])
      die();

  if (intval($_POST['status']) == 2) {
      $mb_currency = $_POST['mb_currency'];
      $mc_gross = $_POST['amount'];
      $txn_id = $_POST['mb_transaction_id'];
      list($membership_id, $user_id) = explode("_", $_POST['custom']);

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
          'pp' => "Skrill",
          'currency' => sanitize($mb_currency),
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
          "Skrill",
          $_SERVER['REMOTE_ADDR']), $row2->{'body' . Lang::$lang});

      $newbody = cleanOut($body);

      $mailer = Mailer::sendMail();
      $message = Swift_Message::newInstance()
				->setSubject($row2->{'subject' . Lang::$lang})
				->setTo(array($core->site_email => $core->site_name))
				->setFrom(array($core->site_email => $core->site_name))
				->setBody($newbody, 'text/html');

      $mailer->send($message);
      Security::writeLog($username . ' ' . Lang::$word->_LG_PAYMENT_OK . ' ' . $row->{'title' . Lang::$lang}, "", "yes", "payment");

  } else {
      /* == Failed or Pending Transaction == */
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
          "Skrill",
          $_SERVER['REMOTE_ADDR']), $row2->{'body' . Lang::$lang});

      $newbody = cleanOut($body);

      $mailer = $mail->sendMail();
      $message = Swift_Message::newInstance()
				->setSubject($row2->{'subject' . Lang::$lang})
				->setTo(array($core->site_email => $core->site_name))
				->setFrom(array($core->site_email => $core->site_name))
				->setBody($newbody, 'text/html');

      $mailer->send($message);

      Security::writeLog(Lang::$word->_LG_PAYMENT_ERR . $username, "", "yes", "payment");

  }

?>