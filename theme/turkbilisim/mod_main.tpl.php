<?php
  /**
   * Full Module Page Layout
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: mod_full.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
  <?php if($content->moduledata and $modfile = Content::getModuleTheme($content->modalias)) :?>
  
  <?php 
  require($modfile); ?>
  <?php endif;?>
