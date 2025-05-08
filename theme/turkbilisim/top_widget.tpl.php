<?php
  /**
   * Top Widget Layout
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: top_widget.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($totaltop):?>
<?php $tcounter = countInArray($widgettop, "space", "10");?>
      <?php foreach ($widgettop as $trow): ?>
        <?php if($totaltop > 1 and $tcounter == false):?>
          <?php endif;?>
            <?php if ($trow->show_title == 1):?>
            <?php endif;?>
            <?php if ($trow->{'body' . Lang::$lang}) echo "".cleanOut($trow->{'body' . Lang::$lang})."";?>
            <?php if ($trow->jscode) echo cleanOut($trow->jscode);?>
            <?php if ($trow->system == 1):?>
            <?php $widgetfile = Content::getPluginTheme($trow->plugalias);?>
            <?php require($widgetfile);?>
            <?php endif;?>
        <?php if($totaltop > 1 and $tcounter == false):?>
      <?php endif;?>
      <?php endforeach; ?>
      <?php unset($trow);?>
    <?php if($totaltop > 1 and $tcounter == false):?>
  <?php endif;?>
<?php endif;?>