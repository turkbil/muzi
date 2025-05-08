<?php
  /**
   * Register Template
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: register.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if ($user->logged_in)
      redirect_to($core->account_page);
?>
<?php if(!$core->reg_allowed):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_UA_NOMORE_REG);?>
<?php elseif($core->user_limit !=0 and $core->user_limit == countEntries("users")):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_UA_MAX_LIMIT);?>
<?php else:?>
<p class="content-center"><i class="information icon"></i> <?php echo Lang::$word->_UA_INFO4. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></p>
<div class="columns">
  <div class="screen-60 phone-100 push-center">
    <div class="tubi form secondary segment">
      <form id="tubi_form" name="tubi_form" method="post">
        <h3><?php echo Lang::$word->_UA_SUBTITLE4;?></h3>
        <div class="field">
          <label><?php echo Lang::$word->_USERNAME;?></label>
          <label class="input"><i class="icon-prepend icon user"></i><i class="icon-append icon asterisk"></i>
            <input name="username" placeholder="<?php echo Lang::$word->_USERNAME;?>" type="text">
          </label>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_PASSWORD;?></label>
            <label class="input"><i class="icon-prepend icon lock"></i> <i class="icon-append icon asterisk"></i>
              <input name="pass" placeholder="<?php echo Lang::$word->_PASSWORD;?>" type="password">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_UA_PASSWORD2;?></label>
            <label class="input"><i class="icon-prepend icon lock"></i><i class="icon-append icon asterisk"></i>
              <input name="pass2" placeholder="<?php echo Lang::$word->_UA_PASSWORD2;?>" type="password">
            </label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_UR_EMAIL;?></label>
          <label class="input"><i class="icon-prepend icon mail"></i><i class="icon-append icon asterisk"></i>
            <input name="email" placeholder="<?php echo Lang::$word->_UR_EMAIL;?>" type="text">
          </label>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_UR_FNAME;?></label>
            <label class="input"><i class="icon-prepend icon user"></i> <i class="icon-append icon asterisk"></i>
              <input name="fname" placeholder="<?php echo Lang::$word->_UR_FNAME;?>" type="text">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_UR_LNAME;?></label>
            <label class="input"><i class="icon-prepend icon user"></i><i class="icon-append icon asterisk"></i>
              <input name="lname" placeholder="<?php echo Lang::$word->_UR_LNAME;?>" type="text">
            </label>
          </div>
        </div>
        <?php echo $content->rendertCustomFields('register', false);?>
        <div class="field">
          <label><?php echo Lang::$word->_UA_REG_RTOTAL;?></label>
          <label class="input"><img src="<?php echo SITEURL;?>/captcha.php" alt="" class="captcha-append"> <i class="icon-prepend icon unhide"></i>
            <input type="text" name="captcha">
          </label>
        </div>
        <button data-url="/ajax/user.php" data-redirect="<?php echo SITEURL;?>/" type="button" name="dosubmit" class="tubi danger button"><?php echo Lang::$word->_UA_REG_ACC;?></button>
        <input name="doRegister" type="hidden" value="1">
      </form>
    </div>
    <div id="msgholder"></div>
  </div>
</div>
<?php endif;?>