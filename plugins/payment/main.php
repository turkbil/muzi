<?php
  /**
   * Account Template
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: account.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  $membership  = geti2('*','memberships','WHERE id='.intval($_GET['id']));
    

?>

    <!-- Login Area Start -->
        <section class="payment">
            <div class="content">
                <h4 class="text-center mb-24">Ödeme Yap</h4>
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-md-8 col-sm-11 col-11">
                        <div class="form-block">
                                    <div class="form-inner">
                                    	
                                        <form method="post" class="mb-24">
                                            <div class="form-group mb-12">
                                                <label for="username">Kart Sahibi Adı Soyadı</label>
                                                <input type="text" id="username" name="username" required>
                                            </div>
                                            <div class="form-group mb-12">
                                                <label for="password">Kredi Kartı No</label>
                                                <input type="text" id="username" name="username" required>
                                            </div>
                                            <div class="form-group two-col mb-12">
                                                <div>
                                                    <label for="password">Son Kullanma Tarihi</label>
                                                    <input type="text" id="username" name="username" required>
                                                </div>
                                                <div>
                                                    <label for="password">Güvenlik Kodu (CVC)</label>
                                                    <input type="text" id="username" name="username" required>
                                                </div>
                                            </div>
                                            <button class="cus2-btn w-100">Ödeme Yap</button>
                                            <input name="doLogin" type="hidden" value="1">
                                        </form>
                                       
                                        
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Login Area End -->