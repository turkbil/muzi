<?php
  /**
   * PayFast Form
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: form.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if(!$row->recurring):?>
<?php $url = ($grows->live) ? 'www.payfast.co.za' : 'sandbox.payfast.co.za';?>
<div class="tubi tiny basic button">
  <form action="https://<?php echo $url;?>/eng/process" class="xform" method="post" id="pf_form" name="pf_form">
    <input type="image" src="<?php echo SITEURL.'/gateways/payfast/payfast_big.png';?>" name="submit" title="Pay With PayFast" alt="" onclick="document.pf_form.submit();"/>
<?php
  $html = '';
  $string = '';
  list($fname, $lname) = explode(" ", $user->name);
  
  $array = array(
      'merchant_id' => $grows->extra,
      'merchant_key' => $grows->extra2,
      'return_url' => Url::Page($core->account_page),
      'cancel_url' => Url::Page($core->account_page),
      'notify_url' => SITEURL . '/gateways/' . $grows->dir . '/ipn.php',
      'name_first' => $fname,
      'name_last' => $lname,
      'email_address' => $user->email,
      'm_payment_id' => $row->id,
      'amount' => $row->price,
      'item_name' => $row->{'title' . Lang::$lang},
	  'item_description' => $row->{'description' . Lang::$lang},
      'custom_int1' => $user->uid,
      'custom_str1' => $user->sesid

      );

  foreach ($array as $k => $v) {
      $html .= '<input type="hidden" name="' . $k . '" value="' . $v . '" />';
      $string .= $k . '=' . urlencode($v) . '&';
  }
  $string = substr($string, 0, -1);
  $sig = md5($string);
  $html .= '<input type="hidden" name="signature" value="' . $sig . '" />';

  print $html;
?>
  </form>
</div>
<?php endif;?>