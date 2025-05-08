<?php
/**
 * Module Index
 *
 * @yazilim Tubi Portal
 * @web adresi turkbilisim.com.tr
 * @copyright 2014
 * @version $Id: mod_index.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
 */

if ( !defined( "_VALID_PHP" ) )
  die( 'Direct access to this location is not allowed.' );
?>
<?php include("header.tpl.php");?>

<?php if ($widgettop): ?>
<!-- Top Widgets -->

<?php include(THEMEDIR . "/top_widget.tpl.php");?>
<!-- Top Widgets /-->
<?php endif;?>
<?php switch(true): case $widgetleft and $widgetright :?>
<!-- Left and Right Layout -->
<div id="page">
  <div class="tubi-grid">
    <div class="columns">
      <div class="screen-60 tablet-50 phone-100">
        <?php include(THEMEDIR . "/mod_main.tpl.php");?>
        <?php include(THEMEDIR . "/cenbot_widget.tpl.php");?>
      </div>
      <div class="screen-20 tablet-25 phone-100">
        <?php include(THEMEDIR . "/left_widget.tpl.php");?>
      </div>
      <div class="screen-20 tablet-25 phone-100">
        <?php include(THEMEDIR . "/right_widget.tpl.php");?>
      </div>
    </div>
  </div>
</div>
<!-- Left and Right Layout /-->
<?php break;?>
<?php case $widgetleft :?>
<!-- Left Layout -->
<div id="page">
  <div class="tubi-grid">
    <div class="columns">
      <div class="screen-30 tablet-40 phone-100">
        <?php include(THEMEDIR . "/left_widget.tpl.php");?>
      </div>
      <div class="screen-70 tablet-60 phone-100">
        <?php include(THEMEDIR . "/mod_main.tpl.php");?>
        <?php include(THEMEDIR . "/cenbot_widget.tpl.php");?>
      </div>
    </div>
  </div>
</div>
<!-- Left Layout /-->
<?php break;?>
<?php case $widgetright :?>
<!-- Right Layout -->
<div class="c-content-box c-size-md c-bg-grey-1">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <?php include(THEMEDIR . "/mod_main.tpl.php");?>
        <?php include(THEMEDIR . "/cenbot_widget.tpl.php");?>
      </div>
      <div class="col-md-4">
        <?php include(THEMEDIR . "/right_widget.tpl.php");?>
      </div>
    </div>
  </div>
</div>
<!-- Right Layout /-->
<?php break;?>
<?php default:?>
<!-- Full Layout -->
<?php include(THEMEDIR . "/mod_main.tpl.php");?>
<?php include(THEMEDIR . "/cenbot_widget.tpl.php");?>
<!-- Full Layout /-->
<?php break;?>
<?php endswitch;?>
<?php if ($widgetbottom): ?>
<!-- Bottom Widgets -->
<div id="botwidget">
  <div class="tubi-grid">
    <?php include(THEMEDIR . "/bottom_widget.tpl.php");?>
  </div>
</div>
<!-- Bottom Widgets /-->
<?php endif;?>
<?php include("footer.tpl.php");?>