<?php
  /**
   * Slider Manager
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: main.php, v4.00 2014-05-10 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');


  require_once (MODPATH . "slidecms/admin_class.php");
  $classname = 'slideCMS';
  try {
	  if (!class_exists($classname)) {
		  throw new exception('Missing slidecms/admin_class.php');
	  }
	  Registry::set('slideCMS', new slideCMS());
  }
  catch (exception $e) {
	  echo $e->getMessage();
  }
  
  
  $id = intval('###SLIDERID###');
  $single = Core::getRowById(slideCMS::mTable, $id);
  if($single)
	  $sliderdata = Registry::get("slideCMS")->getSliderData($id);
?>
<?php if($sliderdata):?>
<div id="slidecms_<?php echo $id;?>" class="fotorama"
    data-width="100%"
    data-nav="<?php echo $single->navtype;?>"
    data-navposition="<?php echo $single->navpos;?>"
    data-arrows="<?php echo $single->navarrows;?>"
    data-navposplace="<?php echo $single->navplace;?>"
    data-height="<?php echo $single->height;?>"
    data-shuffle="<?php echo $single->height;?>"
    data-allowfullscreen="<?php echo $single->fullscreen;?>"
    data-transition="<?php echo $single->transition;?>"
    data-autoplay="<?php echo $single->autoplay;?>"
    data-loop="<?php echo $single->loop;?>"
    data-fit="<?php echo $single->fit;?>"
    data-thumbwidth="100"
    data-thumbheight="60"
>
  <?php foreach ($sliderdata as $srow):?>
  <?php if($srow->data_type == "vid"):?>
  <a href="<?php echo $srow->data;?>"<?php if($single->captions):?> data-caption="<?php echo $srow->{'caption' . Lang::$lang};?><?php endif;?>"><?php echo $srow->{'caption' . Lang::$lang};?></a>
  <?php else:?>
  <img src="<?php echo SITEURL;?>/plugins/<?php echo $single->plug_name;?>/slides/<?php echo $srow->data;?>"<?php if($single->captions):?> data-caption="<?php echo $srow->{'caption' . Lang::$lang};?>"<?php endif;?>><?php if($srow->url):?><a href="<?php echo $srow->url;?>"></a><?php endif;?></img>
  <?php endif;?>
  <?php endforeach;?>
</div>
<?php unset($srow);?>
<script type="text/javascript"> 
function isMyScriptLoaded(url) {
    scripts = document.getElementsByTagName('script');
    for (var i = scripts.length; i--;) {
        if (scripts[i].src == url) return true;
    }
    return false;
}
// <![CDATA[
$(document).ready(function () {
if (!isMyScriptLoaded(SITEURL + '/plugins/slidecms/sliderscript.js')) {
	 $('head').append("<script type=\"text/javascript\" src=\"" + SITEURL + "/plugins/slidecms/sliderscript.js\"><\/script>");
}

var cssUrl = SITEURL + "/plugins/slidecms/slidercss.css";
if($('link[rel*=style][href="'+cssUrl+'"]').length==0)
{
    $("head").append('<link rel="stylesheet" type="text/css" href="'+cssUrl+'"/>');
}

});
// ]]>
</script>
<?php unset($single);?>
<?php endif;?>