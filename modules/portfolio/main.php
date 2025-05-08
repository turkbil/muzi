<?php
/**
 * Portfolio Main
 *
 * @yazilim Tubi Portal
 * @web adresi turkbilisim.com.tr
 * @copyright 2014
 * @version $Id: main.php, v4.00 2014-04-20 16:18:34 Nurullah Okatan
 */

if ( !defined( "_VALID_PHP" ) )
  die( 'Direct access to this location is not allowed.' );

require_once( MODPATH . "portfolio/admin_class.php" );
$classname = 'Portfolio';
try {
  if ( !class_exists( $classname ) ) {
    throw new exception( 'Missing digishop/admin_class.php' );
  }
  Registry::set( 'Portfolio', new Portfolio() );
} catch ( exception $e ) {
  echo $e->getMessage();
}

$length = count( $content->_url );
?>
<?php switch($length): case 3: ?>
<?php break;?>
<?php case 2: ?>
<?php $row = $content->moduledata->mod;?>
<div class="container-fluid">
  <div class="row bg3">
    <div class="col-12 col-xl-6 align-self-center px-0 mx-0">
      <div class="text-center m-0 m-xl-5 px-3 px-px-xl-5 py-3 py-xxl-5 bgw">
        <h3 class="f500 f32 lh42 mb-3"><?php echo $row->{'title' . Lang::$lang};?></h3>
        <div class="f300 f24 lh34 mf20 mlh32"><?php echo cleanOut($row->{'body'.Lang::$lang});?> </div>
        <div class="bg5 p-1 mt-3"> </div>
      </div>
    </div>
    <div class="col-12 col-xl-6 px-0 mx-0">
      <div class="h-100"> <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL.'/'.Portfolio::imagepath . $row->thumb;?>&amp;h=660&amp;w=960" class="img-fluid" alt="<?php echo $row->{'title_tr'};?>" title="<?php echo $row->{'title_tr'};?>" /> </div>
    </div>
  </div>
</div>
<?php break;?>
<?php default: ?>
<?php $portadata = Registry::get("Portfolio")->renderPortfolio();?>
<?php $catrow = Registry::get("Portfolio")->getCategories();?>
<div class="px-0 px-lg-4">
  <div class="container-fluid my-5">
    <div class="row">
      <?php if(!$portadata):?>
      <?php echo Filter::msgSingleAlert(Lang::$word->_MOD_PF_NOPROJECTS);?>
      <?php else:?>
      <?php foreach($portadata as $row):?>
      <div class="col-6 col-lg-4 col-xl-3 box mb-4">
        <div class="box-kutu h-100"> <a href="<?php echo Url::Portfolio("item", $row->slug);?>" class="sector-link d-block rounded-0 f500"><img src="<?php echo SITEURL.'/'.Portfolio::imagepath . $row->thumb;?>" class="img-fluid rounded-0" alt="<?php echo $row->{'title' . Lang::$lang};?> " title="<?php echo $row->{'title' . Lang::$lang};?> " />
          <div class="section-ic position-relative f26 lh32 mf20 mlh26 rounded-0 border-bottom-0 text-center pt-3 pb-2 pt-lg-4 pb-lg-3"> <?php echo $row->{'title' . Lang::$lang};?> </a> </div>
        </div>
      </div>
      <?php endforeach;?>
    </div>
  </div>
</div>
<div id="pagination" class="content-center"><?php echo $pager->display_pages();?></div>
<?php endif;?>
<?php break;?>
<?php endswitch;?>