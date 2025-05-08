<?php
  /**
   * Right Widget Layout
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: right_widget.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($totalright):?>
<section id="rightwidget" class="clearfix">
  <div class="tubi-content-full">
    <?php foreach ($widgetright as $rrow): ?>
    <aside class="clearfix<?php if($rrow->alt_class !="") echo ' '.$rrow->alt_class;?>">
      <?php if ($rrow->show_title == 1):?>
      <h3 class="tubi header"><span><?php echo $rrow->{'title' . Lang::$lang};?></span></h3>
      <?php endif;?>
      <?php if ($rrow->{'body' . Lang::$lang}) echo "<div class=\"widget-body\">".cleanOut($rrow->{'body' . Lang::$lang})."</div>";?>
      <?php if ($rrow->jscode) echo cleanOut($rrow->jscode);?>
      <?php if ($rrow->system == 1):?>
      <?php $widgetfile = Content::getPluginTheme($rrow->plugalias);?>
      <?php require_once($widgetfile);?>
      <?php endif;?>
    </aside>
    <?php endforeach; ?>
    <?php unset($rrow);?>
  </div>
</section>
<?php endif;?>
