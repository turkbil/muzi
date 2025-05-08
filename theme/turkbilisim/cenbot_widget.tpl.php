<?php
  /**
   * Center Bottom Widget Layout
   *
   * @yazilim Turk Bilisim
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: bottom_widget.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Buraya giris yetkiniz bulunmamaktadir..');
?>
<?php if($totalcenbot):?>
    <?php foreach ($widgetcenbot as $cbrow): ?>
      <?php if($totalcenbot > 1):?>
        <?php endif;?>
          <?php if ($cbrow->show_title == 1):?>
          <?php echo $cbrow->{'title' . Lang::$lang};?>
          <?php endif;?>
          <?php if ($cbrow->{'body' . Lang::$lang}) echo "".cleanOut($cbrow->{'body' . Lang::$lang})."";?>
          <?php if ($cbrow->jscode) echo cleanOut($cbrow->jscode);?>
          <?php if ($cbrow->system == 1):?>
          <?php $widgetfile = Content::getPluginTheme($cbrow->plugalias);?>
          <?php require($widgetfile);?>
          <?php endif;?>
    <?php endforeach; ?>
    <?php unset($cbrow);?>
<?php endif;?>