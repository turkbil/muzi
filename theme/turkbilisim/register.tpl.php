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

<!-- Banner Area Start -->
<section class="register-banner py-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="register-form-wrapper">
                    <div class="form-header text-center mb-4">
                        <h2 class="section-title">Hesap Oluştur</h2>
                        <p class="text-muted">
                            <i class="information icon"></i> <?php echo Lang::$word->_UA_INFO4;?>
                            <small><?php echo Lang::$word->_REQ1;?> <i class="icon asterisk text-danger"></i> <?php echo Lang::$word->_REQ2;?></small>
                        </p>
                    </div>
                    
                    <div class="register-form">
                        <form id="tubi_form" name="tubi_form" method="post">
                            <div class="row g-3">
                                <div class="col-12 mb-3">
                                    <label class="form-label"><?php echo Lang::$word->_USERNAME;?> <i class="icon asterisk text-danger"></i></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control" name="username" placeholder="<?php echo Lang::$word->_USERNAME;?>" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo Lang::$word->_PASSWORD;?> <i class="icon asterisk text-danger"></i></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        <input type="password" class="form-control" name="pass" placeholder="<?php echo Lang::$word->_PASSWORD;?>" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo Lang::$word->_UA_PASSWORD2;?> <i class="icon asterisk text-danger"></i></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                        <input type="password" class="form-control" name="pass2" placeholder="<?php echo Lang::$word->_UA_PASSWORD2;?>" required>
                                    </div>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label class="form-label"><?php echo Lang::$word->_UR_EMAIL;?> <i class="icon asterisk text-danger"></i></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        <input type="email" class="form-control" name="email" placeholder="<?php echo Lang::$word->_UR_EMAIL;?>" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo Lang::$word->_UR_FNAME;?> <i class="icon asterisk text-danger"></i></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control" name="fname" placeholder="<?php echo Lang::$word->_UR_FNAME;?>" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label"><?php echo Lang::$word->_UR_LNAME;?> <i class="icon asterisk text-danger"></i></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control" name="lname" placeholder="<?php echo Lang::$word->_UR_LNAME;?>" required>
                                    </div>
                                </div>
                                
                                <?php echo $content->rendertCustomFields('register', false);?>
                                
                                <div class="col-12 mb-3">
                                    <label class="form-label"><?php echo Lang::$word->_UA_REG_RTOTAL;?> <i class="icon asterisk text-danger"></i></label>
                                    <div class="captcha-container d-flex align-items-center">
                                        <div class="captcha-image me-3">
                                            <img src="<?php echo SITEURL;?>/captcha.php" alt="Captcha" class="rounded">
                                        </div>
                                        <div class="captcha-input flex-grow-1">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-shield-alt"></i></span>
                                                <input type="text" class="form-control" name="captcha" placeholder="Güvenlik Kodu" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 mt-3">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            Kullanım koşullarını ve gizlilik politikasını kabul ediyorum
                                        </label>
                                    </div>
                                    
                                    <button type="button" name="dosubmit" data-url="/ajax/user.php" data-redirect="<?php echo SITEURL;?>/" class="cus2-btn w-100"><?php echo Lang::$word->_UA_REG_ACC;?></button>
                                    <input name="doRegister" type="hidden" value="1">
                                </div>
                                
                                <div class="col-12 text-center mt-4">
                                    <p>Zaten hesabınız var mı? <a href="<?php echo Url::Page('login');?>" class="fw-bold">Giriş Yap</a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div id="msgholder" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Area End -->

<style>
.register-banner {
    padding: 80px 0;
    color: #fff;
}

.register-form-wrapper {
    background: rgba(30, 30, 36, 0.8);
    border-radius: 10px;
    box-shadow: 0 0 30px rgba(0, 0, 0, 0.2);
    padding: 40px;
    backdrop-filter: blur(5px);
}

.register-form .form-control {
    border: 1px solid rgba(255, 255, 255, 0.1);
    color: #fff;
    padding: 12px;
    height: auto;
}

.register-form .form-control:focus {
    border-color: #FF4D4D;
    box-shadow: 0 0 0 0.25rem rgba(255, 77, 77, 0.25);
}

.register-form .input-group-text {
    background-color: rgba(255, 77, 77, 0.8);
    border: 1px solid rgba(255, 77, 77, 0.8);
    color: #fff;
}

.register-form .form-label {
    color: #fff;
    font-weight: 500;
    margin-bottom: 8px;
}

.captcha-image img {
    height: 45px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.form-check-input:checked {
    background-color: #FF4D4D;
    border-color: #FF4D4D;
}

.section-title {
    color: #FF4D4D;
    font-weight: 700;
    margin-bottom: 15px;
}

.text-danger {
    color: #FF4D4D !important;
}

@media (max-width: 767px) {
    .register-form-wrapper {
        padding: 20px;
    }
}
</style>

<?php endif;?>