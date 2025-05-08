<?php
  /**
   * Controller
   *
   * @yazilim Tubi Portal
   * @web adresi
@web adresi
@web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: controller.php, v4.00 2014-04-20 14:20:26 Nurullah Okatan
   */

  define("_VALID_PHP", true);
  
  require_once("../../init.php");
  
  require_once(MODPATH . "gallery/admin_class.php");
  Registry::set('Gallery', new Gallery(intval($_POST['gid'])));
  $galrow = Registry::get("Gallery")->getGalleryImages(intval($_POST['gid'])); 
?>
<?php if(isset($_POST['doLike']) and Filter::$id and Registry::get("Gallery")->like):?>
<?php 
  $data['likes'] = "INC(1)";
  $db->update(Gallery::mTable, $data, "id = " . Filter::$id);
  print intval($_POST['total'] + 1);
?>
<?php endif;?>
<?php if(isset($_POST['loadGallery'])):?>
<?php if(!$galrow):?>
<?php Filter::msgSingleAlert(Lang::$word->_MOD_GA_NOIMG);?>
<?php else:?>
<?php foreach($galrow as $i => $grow):?>
<?php $url = SITEURL.'/'.Gallery::galpath.Registry::get("Gallery")->folder.'/'.$grow->thumb;?>
<div class="item">
  <?php if(Registry::get("Gallery")->watermark):?>
  <?php $url = MODURL.'gallery/watermark.php?folder='.Registry::get("Gallery")->folder.'&amp;image='.$grow->thumb;?>
  <?php else:?>
  <?php $url = SITEURL.'/'.Gallery::galpath.Registry::get("Gallery")->folder.'/'.$grow->thumb;?>
  <?php endif;?>
  <div class="image-overlay"> <img src="<?php echo SITEURL.'/'.Gallery::galpath.Registry::get("Gallery")->folder.'/'.$grow->thumb;?>" alt="">
    <div class="overlay-hslide"> <a href="<?php echo $url;?>" title="<?php echo $grow->{'description'.Lang::$lang};?>" class="lightbox"><i class="icon-overlay icon search"></i></a> </div>
  </div>
  <section class="gallery-data">
    <?php if(Registry::get("Gallery")->like):?>
    <a class="like toggle" data-content="<?php echo Lang::$word->_LIKE;?>" data-gid="<?php echo intval($_POST['gid']);?>" data-total="<?php echo $grow->likes;?>" data-id="<?php echo $grow->id;?>"><i class="icon heart"> </i><small><?php echo $grow->likes;?></small></a>
    <?php endif;?>
    <h3><?php echo $grow->{'title' . Lang::$lang};?></h3>
    <p class="portfolio-meta-image"> <?php echo $grow->{'description'.Lang::$lang};?> </p>
  </section>
</div>
<?php endforeach;?>
<?php endif;?>
<?php endif;?>
