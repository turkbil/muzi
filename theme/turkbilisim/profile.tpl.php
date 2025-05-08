<?php
  /**
   * Profile Template
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: profile.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if(isset($content->_url[2])):?>
<?php $userdata = $user->getPublicProfile();?>
<?php if(!$userdata):?>
<?php Filter::msgSingleAlert(Lang::$word->_PPF_ERR);?>
<?php else:?>
<?php $activity = $user->getUserActivity($userdata->id);?>
<div class="columns horizontal-gutters">
  <div class="screen-30 tablet-40 phone-100">
    <div class="tubi fitted danger segment">
      <?php if($userdata->avatar):?>
      <img src="<?php echo UPLOADURL;?>avatars/<?php echo $userdata->avatar;?>" alt="<?php echo $userdata->username;?>">
      <?php else:?>
      <img src="<?php echo UPLOADURL;?>avatars/blank.png" alt="<?php echo $userdata->username;?>">
      <?php endif;?>
      <div class="footer">
        <p><?php echo $userdata->info;?></p>
      </div>
    </div>
    <div class="three fluid tubi buttons"> <a href="<?php echo $userdata->tw_link;?>" target="_blank" class="tubi twitter fluid button"><i class="twitter icon"></i></a> <a href="<?php echo $userdata->fb_link;?>" target="_blank" class="tubi facebook fluid button"><i class="facebook icon"></i></a> <a href="<?php echo $userdata->gp_link;?>" target="_blank" class="tubi google plus fluid button"><i class="google plus icon"></i></a> </div>
  </div>
  <div class="screen-70 tablet-60 phone-100">
    <div class="tubi segment feed">
      <div class="event">
        <div class="label"> <i class="calendar icon"></i> </div>
        <div class="content">
          <div class="summary"> <?php echo Lang::$word->_UR_LASTLOGIN;?>
            <div class="date"> <?php echo timesince($userdata->lastseen);?> </div>
          </div>
        </div>
      </div>
      <div class="tubi fitted divider"></div>
      <div class="event">
        <div class="label"> <i class="calendar icon"></i> </div>
        <div class="content">
          <div class="summary"> <?php echo Lang::$word->_MN_REG_SINCE;?>
            <div class="date"> <?php echo Filter::doDate("long_date", $userdata->created);?> </div>
          </div>
        </div>
      </div>
      <?php if($activity):?>
      <div class="scrollbox">
        <?php foreach ($activity as $arow):?>
        <div class="event">
          <div class="label"> <i class="circular <?php echo $arow->icon;?> icon"></i> </div>
          <div class="content">
            <div class="summary"> <?php echo $arow->subject;?> <a href="<?php echo SITEURL . '/' . $arow->url;?>"><?php echo $arow->title;?></a>
              <div class="date"> <?php echo timesince($arow->adate);?> </div>
            </div>
            <div class="extra text"> <?php echo cleanOut($arow->message);?> </div>
          </div>
        </div>
        <?php endforeach;?>
      </div>
      <?php endif;?>
    </div>
  </div>
</div>
<?php endif;?>
<?php else:?>
<?php //redirect_to(SITEURL . "/404.php");;?>
<?php endif;?>
