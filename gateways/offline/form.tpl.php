<?php
  /**
   * Paypal Form
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: form.tpl.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div class="tubi tiny basic button">
  <form action="#" method="post" id="admin_form" name="admin_form">
    <input class="offline" type="image" src="<?php echo SITEURL.'/gateways/offline/offline_big.png';?>" name="submit" title="Offline Payment" alt="">
    <?php if($core->checkTable("mod_invoices")):?>
    <input name="user_id" type="hidden" value="<?php echo $user->uid;?>" />
    <input name="membership_id" type="hidden" value="<?php echo $row->id;?>" />
    <?php endif;?>
  </form>
</div>