<?php
  /**
   * 404 Template
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: 404.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div id="error-page">
  <div class="tubi-grid">
    <div class="logo"><a href="<?php echo SITEURL;?>"><?php echo ($core->logo) ? '<img src="'.SITEURL.'/uploads/'.$core->logo.'" alt="'.$core->company.'" />': $core->company;?></a> </div>
    <h1><?php echo Lang::$word->_ER_404;?></h1>
    <a href="<?php echo SITEURL;?>/">
    <div id="but" class="tubi info icon button"><i class="icon home"></i></div>
    </a>
    <h3 class="primary"><?php echo Lang::$word->_ER_404_1;?></h3>
    <h3><?php echo Lang::$word->_ER_404_2;?></h3>
  </div>
</div>