<?php
/**
 * Gallery Main
 *
 * @yazilim Tubi Portal
 * @web adresi turkbilisim.com.tr
 * @copyright 2014
 * @version $Id: main.php, v4.00 2014-04-20 16:18:34 Nurullah Okatan
 */

if ( !defined( "_VALID_PHP" ) )
  die( 'Direct access to this location is not allowed.' );

require_once( MODPATH . "gallery/admin_class.php" );
Registry::set( 'Gallery', new Gallery( $content->module_data ) );

$galrow = Registry::get( "Gallery" )->getGalleryImages( $content->module_data );
?>
<?php if(!$galrow):?>
<?php else:?>
<?php $galerylist = Registry::get("Gallery")->getGalleryList();?>
<div class="container-fluid p-5">
  <div class="row">
    <?php $sure = "0.1"; ?>
    <?php foreach($galrow as $i => $grow):?>
    <?php $url = SITEURL.'/'.Gallery::galpath.Registry::get("Gallery")->folder.'/'.$grow->thumb;?>
    <div class="col-6 col-md-3 mb-4 pb-2"><a href="<?php echo SITEURL.'/'.Gallery::galpath.Registry::get("Gallery")->folder.'/'.$grow->thumb;?>" class="fancybox" data-fancybox="gallery" data-caption="<?php echo $grow->title_tr;?>">
      <div class="galeri overflow">
        <figure><img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL.'/'.Gallery::galpath.Registry::get("Gallery")->folder.'/'.$grow->thumb;?>&amp;h=285&amp;w=430&amp;s=1&amp;a=c" class="zoom img-fluid img wow fadeIn animated" data-wow-delay="<?php echo $sure; ?>s"></figure>
      </div>
      <div class="gallery-title p-1 text-center"><?php echo $grow->title_tr;?></div>
      </a> </div>
    <?php $sure = $sure + '0.1'; ?>
    <?php endforeach;?>
  </div>
</div>
<?php endif;?>
