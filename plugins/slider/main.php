<?php
  /**
   * jQuery Slider
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: main.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  require_once(BASEPATH . "admin/plugins/slider/admin_class.php");
  Registry::set('Slider', new Slider());
  
  $slides = Registry::get("Slider")->getSlides();
  $conf = Registry::get("Slider");
?>
<!-- Start jQuery Slider -->
<?php if(!$slides):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_PLG_SL_NOIMG);?>
<?php else:?>


<div class="rev-slider-wrapper">
  <div id="rev-slider" class="rev-slider" data-version="5.0">
    <ul>
      <?php foreach ($slides as $srow):?>
      <li data-transition="fade" class="align-center"> <img src="<?php echo SITEURL . '/' . Slider::imgPath . $srow->thumb;?>" class="rev-slidebg" alt="">
        <div class="tp-caption tp-resizeme scaption-white-text rs-parallaxlevel-1" data-x="center" data-y="top" data-voffset="180" data-whitespace="nowrap" data-frames='[{"delay":150,"speed":2000,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[175%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]' data-responsive_offset="on" data-elementdelay="0.05"><?php echo $srow->{'body'.Lang::$lang};?></div>
        <div class="tp-caption tp-resizeme scaption-white-large rs-parallaxlevel-2" data-x="center" data-y="top" data-voffset="225" data-frames='[{"delay":450,"speed":2000,"frame":"0","from":"y:50px;opacity:0;","to":"o:1;","ease":"Power3.easeOut"},{"delay":"wait","speed":1000,"frame":"999","to":"y:[175%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'><?php echo $srow->{'title'.Lang::$lang};?></div>
        <?php if($srow->urltype != "nourl"):?>
        <div class="tp-caption tp-resizeme rs-parallaxlevel-3" data-x="center" data-y="top" data-voffset="420" data-whitespace="nowrap" data-frames='[{"delay":550,"speed":2500,"frame":"0","from":"x:[-100%];z:0;rX:0deg;rY:0deg;rZ:0deg;sX:1;sY:1;skX:0;skY:0;opacity:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":1000,"frame":"999","to":"auto:auto;","ease":"Power2.easeInOut"},{"frame":"hover","speed":"300","ease":"Power1.easeInOut","to":"o:1;rX:0;rY:0;rZ:0;z:0;"}]'><a href="<?php echo ($srow->urltype == "ext") ? $srow->url : SITEURL . "/sayfa/" . $srow->url;?>" <?php echo ($srow->urltype == "ext") ? "target=\"_blank\"" : "target=\"_self\"";?> class="btn btn-big">Detaylar</a> </div>
        <?php endif;?>
      </li>
      <?php endforeach;?>
      <?php unset($srow);?>
    </ul>
  </div>
</div>
<script src="<?php echo PLUGURL;?>slider/slider.js"></script>
<?php endif;?>
<!-- End jQuery Slider /-->