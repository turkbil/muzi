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
	  
  if (!$user->logged_in)
      redirect_to(Url::Page($core->login_page));
	
require_once(BASEPATH . 'admin/modules/muzibu/admin_class.php');  
$muzibu = new Muzibu();

  $listpackrow  = $member->getMembershipListFrontEnd();
  $mrow = $user->getUserMembership();
  $gatelist = $member->getGateways(true);
  $usr = $user->getUserData();


?>
 <!-- Banner Area Start -->
         <Section class="profile-banner">
            <img src="<?php echo THEMEURL; ?>/assets/media/bg/favourites-bg-1.jpg" alt="">
            
            <div class="content">
                <div class="profile-info">
            	<img src="<?php echo THEMEURL; ?>/assets/media/user/account.png" class="profile-img" alt="">
                <div class="profile-name">
                	<?php echo $user->name;?>
                </div>
            	</div>
                
                
            </div>
         </Section>
        <!-- Banner Area End -->

        <section class="pb-40">
    <div class="row justify-content-center">
        <div class="col-12 col-md-5">
    <h4><i class="fa-solid fa-music"></i> Mevcut Plan</h4>
    </div>
    </div>
    <div class="user-membership mt-3 px-3">
            
            
            <div class="row justify-content-center">
                <div class="col-12 col-md-5 user-membership-body">
                    <div class="field">
                    <h6>Üyelik Planı</h6>
                    <div class="value"><?php echo $mrow->title_tr;?></div>
                    </div>
                    <div class="field price">
                        <h6>Fiyat</h6>
                        <div class="value"><?php echo $mrow->price." TL";?></div>
                    </div>
                    <div class="field">
                        <h6>Süre</h6>
                        <div class="value"><?php echo $mrow->days." ".$member->getPeriod($mrow->period);?></div>
                    </div>
                    <div class="field">
                        <h6>Bitiş Tarihi</h6>
                    <div class="value"><?php echo $mrow->mem_expire;?></div>
                    </div>
                </div>
                
            </div>
            <div class="row justify-content-center">
            <div class="col-12 col-md-5  user-membership-foot">
            <a href="<?php echo Url::Page('planlar');?>" class="cus2-btn"><i class="fas fa-share"></i> Plan Değiştir</a>
            </div>
            </div>
        </div>
        
</section>
<!-- Trending Music End -->

 


<!-- Trending Music End -->