<?php
  /**
   * Stripe IPN
   *
   * @yazilim CMS pro
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: ipn.php, v4.00 2014-05-08 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);

  require_once ("../../init.php");
  require_once (dirname(__file__) . '/lib/Stripe.php');

  ini_set('log_errors', true);
  ini_set('error_log', dirname(__file__) . '/ipn_errors.log');

  if (!$user->logged_in)
      exit;
	  
  if (isset($_POST['processStripePayment'])) {
      $key = $db->first("SELECT * FROM gateways WHERE name = 'stripe'");
      $stripe = array("secret_key" => $key->extra, "publishable_key" => $key->extra3);
      Stripe::setApiKey($stripe['secret_key']);

      try {
          $charge = Stripe_Charge::create(array(
              "amount" => round($_POST['amount'] * 100, 0), // amount in cents, again
              "currency" => $_POST['currency_code'],
              "card" => array(
                  "number" => $_POST['card-number'],
                  "exp_month" => $_POST['card-expiry-month'],
                  "exp_year" => $_POST['card-expiry-year'],
                  "cvc" => $_POST['card-cvc'],
                  ),
              "description" => $_POST['item_name']));
          $json = json_decode($charge);
          $mc_gross = round(($json->{'amount'} / 100), 2);
		  $txn_id = $json->{'balance_transaction'};
          
		  /* == Payment Completed == */
		  $price = getValueById("price", Membership::mTable, intval($_POST['item_number']));
		  $v1 = compareFloatNumbers($mc_gross, $price, "=");
		  
		  if ($v1 == true) {
			  $sql = "SELECT * FROM " . Membership::mTable . " WHERE id=" . (int)$_POST['item_number'];
			  $row = $db->first($sql);

			  $data = array(
				  'txn_id' => $txn_id,
				  'membership_id' => $row->id,
				  'user_id' => $user->uid,
				  'rate_amount' => (float)$mc_gross,
				  'ip' => $_SERVER['REMOTE_ADDR'],
				  'created' => "NOW()",
				  'pp' => "Stripe",
				  'currency' => sanitize($_POST['currency_code']),
				  'status' => 1);
				  
			  $db->insert(Membership::pTable, $data);

			  $udata = array(
				  'membership_id' => $row->id,
				  'mem_expire' => $user->calculateDays($row->id),
				  'trial_used' => ($row->trial == 1) ? 1 : 0,
				  'memused' => 1);

			  $db->update(Users::uTable, $udata, "id=" . $user->uid);
				  
			  $jn['type'] = 'success';
			  $jn['message'] = Filter::msgSingleOK('Thank you! Payment completed.', false);
			  print json_encode($jn);
		  
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
				  $user->username,
				  $row->{'title' . Lang::$lang},
				  $core->formatMoney($mc_gross),
				  "Completed",
				  "Stripe",
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
			  Security::writeLog($user->username . ' ' . Lang::$word->_LG_PAYMENT_OK . ' ' . $row->{'title' . Lang::$lang}, "", "yes", "payment");

		  }
      }
      catch (Stripe_CardError $e) {
          //$json = json_decode($e);
          $body = $e->getJsonBody();
          $err = $body['error'];
          $json['type'] = 'error';
          Filter::$msgs['status'] = 'Status is:' . $e->getHttpStatus() . "\n";
          Filter::$msgs['type'] = 'Type is:' . $err['type'] . "\n";
          Filter::$msgs['code'] = 'Code is:' . $err['code'] . "\n";
          Filter::$msgs['param'] = 'Param is:' . $err['param'] . "\n";
          Filter::$msgs['msg'] = 'Message is:' . $err['message'] . "\n";
          $json['message'] = Filter::msgStatus();
          print json_encode($json);
      }
      catch (Stripe_InvalidRequestError $e) {}
      catch (Stripe_AuthenticationError $e) {}
      catch (Stripe_ApiConnectionError $e) {}
      catch (Stripe_Error $e) {}
      catch (exception $e) {}
  }
?>