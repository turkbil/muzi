<?php
  /**
   * Bottom Widget Layout
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: bottom_widget.tpl.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($totalbot):?>
<?php $bcounter = countInArray($widgetbottom, "space", "10");?>
<section class="topwidget clearfix">
  <?php if($totalbot > 1 and $bcounter == false):?>
  <div class="tubi-grid">
    <?php endif;?>
    <div class="columns<?php if($totalbot > 1 and $bcounter == false):?> small-vertical-gutters<?php endif;?>">
      <?php foreach ($widgetbottom as $brow): ?>
      <div class="screen-<?php echo $brow->space;?>0 phone-100">
        <?php if($totalbot > 1 and $bcounter == false):?>
        <div class="tubi-content">
          <?php endif;?>
          <div class="topwidget-wrap<?php if($brow->alt_class !="") echo ' '.$brow->alt_class;?>">
            <?php if ($brow->show_title == 1):?>
            <h3 class="tubi header"><?php echo $brow->{'title' . Lang::$lang};?></h3>
            <?php endif;?>
            <?php if ($brow->{'body' . Lang::$lang}) echo "<div class=\"widget-body\">".cleanOut($brow->{'body' . Lang::$lang})."</div>";?>
            <?php if ($brow->jscode) echo cleanOut($brow->jscode);?>
            <?php if ($brow->system == 1):?>
            <?php $widgetfile = Content::getPluginTheme($brow->plugalias);?>
            <?php require($widgetfile);?>
            <?php endif;?>
          </div>
        </div>
        <?php if($totalbot > 1 and $bcounter == false):?>
      </div>
      <?php endif;?>
      <?php endforeach; ?>
      <?php unset($brow);?>
    </div>
    <?php if($totalbot > 1 and $bcounter == false):?>
  </div>
  <?php endif;?>
</section>
<?php endif;?>