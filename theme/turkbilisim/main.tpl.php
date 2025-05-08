<?php
  /**
   * Full Layout
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: full.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
  <?php if($content->getAccess()):?>
  <?php echo Content::getContentPlugins($row->{'body' . Lang::$lang});?>
  <?php if ($page = Content::getAccesPages($row)):?>
  <?php include($page);?>
  <?php endif;?>
  <?php if($row->module_name and $modfile = Content::getModuleTheme($row->module_name)) :?>
  <?php require($modfile); ?>
  <?php endif;?>
  <?php if ($content->jscode) echo cleanOut($content->jscode);?>
  <?php endif;?>
