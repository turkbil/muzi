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

  $listpackrow  = $member->getMembershipListFrontEnd();
  $mrow = $user->getUserMembership();


?>
 <!-- Banner Area Start -->
         <Section class="membership-banner">

            <div class="content">
                <h1>Üyelik Planları</h1>
                <p class="mb-24">Lorem ipsum dolor sit amet consectetur. Ultrices tellus adipiscing et risus.</p>
                
                <div class="membership-plans">
                    <div class="row justify-content-evenly">
                        <?php 
                        $i=0;
                        foreach($listpackrow as $pack):
                        $i++;
                        ?>
                        <div class="col-4">
                            <div class="membership-plan plan-<?php echo $i;?>">
                                <?php if($i==2):?>
                                <div class="popular-badge">En Populer</div>
                                <?php endif;?>
                                <h6><?php echo $pack->title_tr;?></h6>
                                <div class="price"><?php echo $pack->price." TL";?> <span class="price-period">/ <?php echo $member->getPeriod($pack->period);?></span></div>
                                <div class="plan-features "><?php echo textToUL($pack->description_tr);?></div>
                                
                                <?php if ($user->logged_in):?>
                                    <?php if($mrow->membership_id == $pack->id):?>
                                        <div class="button cus2-btn disable">Mevcut Plan</div>
                                    <?php else:?>
                                         <a href="<?php echo Url::Page('odeme');?>" class="button cus2-btn">Yükselt</a>
                                    <?php endif;?>
                                <?php else:?>
                                 <a href="" class="button cus2-btn">Kayıt Ol</a>
                                 <?php endif;?>
                            </div>
                        </div>
                        <?php endforeach;?>
                    </div>
                </div>
                
            </div>
                
                
         </Section>
        <!-- Banner Area End -->

       
<!-- Trending Music End -->

 


<!-- Trending Music End -->