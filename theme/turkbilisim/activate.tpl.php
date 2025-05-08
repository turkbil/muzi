<?php
  /**
   * Activation Template
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: activate.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if ($user->logged_in)
      redirect_to(Url::Page($core->account_page));
?>
<div class="columns">
  <div class="screen-50 phone-100 push-center">
    <p><i class="information icon"></i> <?php echo Lang::$word->_UA_INFO5;?></p>
    <div class="tubi secondary segment form">
      <form id="tubi_form" name="tubi_form" method="post">
        <h3><?php echo Lang::$word->_UA_SUBTITLE5;?></h3>
        <div class="field">
          <label><?php echo Lang::$word->_UR_EMAIL;?> <i class="small icon asterisk"></i></label>
          <input name="email" placeholder="<?php echo Lang::$word->_UR_EMAIL;?>" value="<?php if(get('email')) echo sanitize($_GET['email']);?>" type="text">
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UA_TOKEN;?> <i class="small icon asterisk"></i></label>
          <input name="token" placeholder="<?php echo Lang::$word->_UA_TOKEN;?>" value="<?php if(get('token')) echo sanitize($_GET['token']);?>" type="text">
        </div>
        <button data-url="/ajax/user.php" type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_UA_ACTIVATE_ACC;?></button>
        <input name="accActivate" type="hidden" value="1">
      </form>
    </div>
    <div id="msgholder"></div>
  </div>
</div>