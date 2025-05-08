<?php
  /**
   * Login Template
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: login.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
  if ($user->logged_in)
      redirect_to(Url::Page($core->account_page));
	  
  if (isset($_POST['doLogin']))
      : $result = $user->login($_POST['username'], $_POST['password']);
  /* Login Successful */
  if ($result)
      : redirect_to(Url::Page($core->account_page));
  endif;
  endif;
?>

 <!-- Login Area Start -->
        <section class="account">
            <div class="content">
                <h4 class="text-center mb-24">Giriş Yap</h4>
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-md-8 col-sm-11 col-11">
                        <div class="form-block">
                            <div class="row align-items-center">
                                <div class="col-sm-6">
                                    <div class="form-inner">
                                    	<?php print Filter::$showMsg;?> 
                                        <form action="<?php echo Url::Page("login");?>" method="post" class="mb-24">
                                            <div class="form-group mb-12">
                                                <label for="username">Kullanıcı Adı</label>
                                                <input type="text" id="username" name="username" required>
                                            </div>
                                            <div class="form-group mb-8">
                                                <label for="password">Şifre</label>
                                                <input type="password" id="password" name="password" required>
                                            </div>
                                            <button class="cus2-btn w-100">Giriş Yap</button>
                                            <input name="doLogin" type="hidden" value="1">
                                        </form>
                                       
                                       
                                    </div>
                                </div>
                                <div class="col-sm-6 d-sm-block d-none">
                                    <img src="<?php echo THEMEURL; ?>/assets/media/user/account.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Login Area End -->

