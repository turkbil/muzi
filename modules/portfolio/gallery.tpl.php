<?php
  /**
   * Portfolio Gallery
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: gallery.tpl.php, v4.00 2014-04-20 16:18:34 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  require_once(MODPATH . "gallery/admin_class.php");
  Registry::set('Gallery', new Gallery($row->gallery));
  
  $galrow = Registry::get("Gallery")->getGalleryImages($row->gallery); 
?>
<?php if(!$galrow):?>
<?php Filter::msgSingleAlert(Lang::$word->_MOD_GA_NOIMG);?>
<?php else:?>
<div class="tubi secondary segment">
<div id="gallerywrap" class="clearfix">
          <div class="tubi-carousel" 
        data-pagination="false" 
        data-navigation="true" 
        data-single-item="true"
        data-auto-play="false"
        data-transition-style="fade"
        >
        <?php foreach($galrow as $i => $grow):?>
        <section>
        <img src="<?php echo SITEURL.'/'.Gallery::galpath.Registry::get("Gallery")->folder.'/'.$grow->thumb;?>" alt="">
        <h4 class="tubi header"><?php echo $grow->{'title' . Lang::$lang};?></h4>
        <p class="portfolio-meta-image"> <?php echo $grow->{'description'.Lang::$lang};?> </p>
        </section>
        <?php endforeach;?>
  </div>      
</div>
</div>
<?php endif;?>