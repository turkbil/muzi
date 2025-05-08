<?php
  /**
   * Paypal Form
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: form.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div class="tubi tiny basic button">
  <?php $url = ($grows->live) ? 'www.paypal.com' : 'www.sandbox.paypal.com';?>
  <form action="https://<?php echo $url;?>/cgi-bin/webscr" method="post" id="pp_form" name="pp_form">
    <input type="image" src="<?php echo SITEURL.'/gateways/paypal/paypal_big.png';?>" name="submit" title="Pay With Paypal" alt="" onclick="document.pp_form.submit();"/>
    <?php if($row->recurring == 1):?>
    <input type="hidden" name="cmd" value="_xclick-subscriptions" />
    <input type="hidden" name="a3" value="<?php echo $row->price;?>" />
    <input type="hidden" name="p3" value="<?php echo $row->days;?>" />
    <input type="hidden" name="t3" value="<?php echo $row->period;?>" />
    <input type="hidden" name="src" value="1" />
    <input type="hidden" name="sr1" value="1" />
    <?php else:?>
    <input type="hidden" name="cmd" value="_xclick" />
    <input type="hidden" name="amount" value="<?php echo $row->price;?>" />
    <?php endif;?>
    <input type="hidden" name="business" value="<?php echo $grows->extra;?>" />
    <input type="hidden" name="item_name" value="<?php echo $row->{'title'.Lang::$lang};?>" />
    <input type="hidden" name="item_number" value="<?php echo $row->id . '_' . $user->uid;?>" />
    <input type="hidden" name="return" value="<?php echo Url::Page($core->account_page);?>" />
    <input type="hidden" name="rm" value="2" />
    <input type="hidden" name="notify_url" value="<?php echo SITEURL.'/gateways/'.$grows->dir;?>/ipn.php" />
    <input type="hidden" name="cancel_return" value="<?php echo Url::Page($core->account_page);?>" />
    <input type="hidden" name="no_note" value="1" />
    <input type="hidden" name="currency_code" value="<?php echo ($grows->extra2) ? $grows->extra2 : $core->currency;?>" />
  </form>
</div>