<?php
  /**
   * Configuration
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: controller.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once("admin_class.php");
  Registry::set('Gallery', new Gallery());
  $gal = Registry::get("Gallery");
  $galrow = $gal->getGalleries();
?>
<label><?php echo Lang::$word->_PG_GAL;?></label>
<select name="module_data">
  <option value="0"><?php echo Lang::$word->_PG_GAL_SEL;?></option>
  <?php if($galrow):?>
  <?php foreach($galrow as $grow):?>
  <?php $sel = ($grow->id == $module_data) ? ' selected="selected"' : '' ;?>
  <option value="<?php echo $grow->id;?>"<?php echo $sel;?>><?php echo $grow->{'title'.Lang::$lang};?></option>
  <?php endforeach;?>
  <?php unset($grow);?>
  <?php endif;?>
</select>