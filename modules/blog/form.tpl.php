<?php
  /**
   * Comments Form
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: form.tpl.php, 2014-01-20 16:17:34 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<h4><i class="warning chat icon"></i> <?php echo Lang::$word->_MOD_AMC_REPLY;?></h4>
<p><em><small><?php echo Lang::$word->_MOD_AMC_E_NOT_V;?></small></em></p>
<div class="tubi secondary segment form">
  <form id="tubi_form" name="tubi_form" method="post">
    <div class="two fields">
      <div class="field">
        <label><?php echo Lang::$word->_MOD_AMC_NAME;?></label>
        <label class="input"><i class="icon-append icon asterisk"></i>
          <input name="username" placeholder="<?php echo Lang::$word->_MOD_AMC_NAME;?>" type="text" value="<?php if ($user->logged_in) echo $user->username;?>">
        </label>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_CF_EMAIL;?></label>
        <label class="input">
          <?php if(Registry::get("Blog")->email_req) echo '<i class="icon-append icon asterisk"></i>';?>
          <input name="email" placeholder="<?php echo Lang::$word->_CF_EMAIL;?>" type="text" value="<?php if ($user->logged_in) echo $user->email;?>">
        </label>
      </div>
    </div>
    <div class="two fields">
      <div class="field">
        <label><?php echo Lang::$word->_MOD_AMC_WEB;?></label>
        <input name="www" placeholder="<?php echo Lang::$word->_MOD_AMC_WEB;?>" type="text">
      </div>
      <div class="field">
        <?php if(Registry::get("Blog")->show_captcha):?>
        <label><?php echo Lang::$word->_MOD_AMC_CAPTCHA_N;?></label>
        <label class="input"><img src="<?php echo SITEURL;?>/captcha.php" alt="" class="captcha-append" /> <i class="icon-prepend icon unhide"></i>
          <input type="text" name="captcha">
        </label>
        <?php endif;?>
      </div>
    </div>
    <div class="field">
      <label><?php echo Lang::$word->_MOD_AMC_COMMENT;?></label>
      <label class="textarea"><i class="icon-append icon asterisk"></i>
        <textarea id="combody" placeholder="<?php echo Lang::$word->_MOD_AMC_COMMENT;?>" name="body"></textarea>
      </label>
      <p class="tubi note" id="counter"></p>
    </div>
    <div class="field">
      <button data-url="/modules/blog/controller.php" type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_AMC_ADDCOMMENT;?></button>
    </div>
    <input name="artid" type="hidden" value="<?php echo $row->id;?>">
    <input name="processComment" type="hidden" value="1">
  </form>
</div>
<div id="msgholder"></div>