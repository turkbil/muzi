<?php
  /**
   * Contact Form
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: contact_form.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div class="tubi form secondary segment">
  <form id="tubi_form" name="tubi_form" method="post">
    <div class="two fields">
      <div class="field">
        <label><?php echo Lang::$word->_CF_NAME;?></label>
        <label class="input"><i class="icon-append icon asterisk"></i>
          <input type="text" placeholder="<?php echo Lang::$word->_CF_NAME;?>" value="<?php if ($user->logged_in) echo $user->name;?>" name="name">
        </label>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_CF_EMAIL;?></label>
        <label class="input"><i class="icon-append icon asterisk"></i>
          <input type="text" placeholder="<?php echo Lang::$word->_CF_EMAIL;?>" value="<?php if ($user->logged_in) echo $user->email;?>" name="email">
        </label>
      </div>
    </div>
    <div class="two fields">
      <div class="field">
        <label><?php echo Lang::$word->_CF_PHONE;?></label>
        <label class="input">
          <input type="text" placeholder="<?php echo Lang::$word->_CF_PHONE;?>" name="phone">
        </label>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_CF_SUBJECT;?></label>
        <select name="subject">
          <option value=""><?php echo Lang::$word->_CF_SUBJECT_1;?></option>
          <option value="<?php echo Lang::$word->_CF_SUBJECT_2;?>"><?php echo Lang::$word->_CF_SUBJECT_2;?></option>
          <option value="<?php echo Lang::$word->_CF_SUBJECT_3;?>"><?php echo Lang::$word->_CF_SUBJECT_3;?></option>
          <option value="<?php echo Lang::$word->_CF_SUBJECT_4;?>"><?php echo Lang::$word->_CF_SUBJECT_4;?></option>
          <option value="<?php echo Lang::$word->_CF_SUBJECT_5;?>"><?php echo Lang::$word->_CF_SUBJECT_5;?></option>
          <option value="<?php echo Lang::$word->_CF_SUBJECT_6;?>"><?php echo Lang::$word->_CF_SUBJECT_6;?></option>
          <option value="<?php echo Lang::$word->_CF_SUBJECT_7;?>"><?php echo Lang::$word->_CF_SUBJECT_7;?></option>
        </select>
      </div>
    </div>
    <div class="field">
      <label><?php echo Lang::$word->_CF_MSG;?></label>
      <label class="textarea"><i class="icon-append icon asterisk"></i>
        <textarea placeholder="<?php echo Lang::$word->_CF_MSG;?>" name="message"></textarea>
      </label>
    </div>
    <div class="field">
      <label><?php echo Lang::$word->_CF_TOTAL;?></label>
      <label class="input"><img src="<?php echo SITEURL;?>/captcha.php" alt="" class="captcha-append" /> <i class="icon-prepend icon unhide"></i>
        <input type="text" name="code">
      </label>
    </div>
    <button data-url="/ajax/sendmail.php" type="button" name="dosubmit" class="tubi danger button"><?php echo Lang::$word->_CF_SEND;?></button>
    <input name="processContact" type="hidden" value="1">
  </form>
</div>
<div id="msgholder"></div>