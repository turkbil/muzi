<?php
  /**
   * Blog Main
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: main.php, v2.00 2014-04-10 16:18:34 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  require_once (MODPATH . "blog/admin_class.php");
  $classname = 'Blog';
  try {
	  if (!class_exists($classname)) {
		  throw new exception('Missing blog/admin_class.php');
	  }
	  Registry::set('Blog', new Blog(false));
  }
  catch (exception $e) {
	  echo $e->getMessage();
  }

  $length = count($content->_url);
?>
<?php switch($length): case 3: ?>
  <?php if(in_array(Url::$data['module']['blog-tag'], $content->_url)):?>
	<?php include_once("layout_tags.tpl.php");?>
  <?php elseif(in_array(Url::$data['module']['blog-archive'], $content->_url)):?>
	<?php include_once("layout_archive.tpl.php");?>
  <?php elseif(in_array(Url::$data['module']['blog-author'], $content->_url)):?>
	<?php include_once("layout_author.tpl.php");?>
  <?php else:?>
	<?php $single = $content->moduledata->mod;?>
    <?php $latestrow = Registry::get("Blog")->renderCategory($single->id, $single->perpage, $single->slug);?>
    <?php switch($single->layout): case 4: ?>
    <?php include_once("layout_twocol.tpl.php");?>
    <?php break;?>
    <?php case 3: ?>
    <?php include_once("layout_top.tpl.php");?>
    <?php break;?>
    <?php case 2: ?>
    <?php include_once("layout_right.tpl.php");?>
    <?php break;?>
    <?php default: ?>
    <?php include_once("layout_left.tpl.php");?>
    <?php break;?>
    <?php endswitch;?>
  <?php endif;?>
<?php break;?>
<?php case 2: ?>
  <?php if(in_array(Url::$data['module']['blog-search'], $content->_url)):?>
	<?php include_once("layout_search.tpl.php");?>
  <?php else:?>
	<?php $row = $content->moduledata->mod;?>
  <?php Blog::doHits($row->id);?>
	<?php switch($row->layout): case 4: ?>
    <?php include_once("layout_single_bottom.tpl.php");?>
    <?php break;?>
    <?php case 3: ?>
    <?php include_once("layout_single_top.tpl.php");?>
    <?php break;?>
    <?php case 2: ?>
    <?php include_once("layout_single_right.tpl.php");?>
    <?php break;?>
    <?php default: ?>
    <?php include_once("layout_single_left.tpl.php");?>
    <?php break;?>
    <?php endswitch;?>
  <?php endif;?>
<?php break;?>
<?php default: ?>
  <?php $latestrow = Registry::get("Blog")->getLatestArticles();?>
  <h1><span><?php echo Lang::$word->_MOD_AM_LATEST;?></span></h1>
  <?php switch(Registry::get("Blog")->flayout): case 4: ?>
  <?php include_once("layout_twocol.tpl.php");?>
  <?php break;?>
  <?php case 3: ?>
  <?php include_once("layout_top.tpl.php");?>
  <?php break;?>
  <?php case 2: ?>
  <?php include_once("layout_right.tpl.php");?>
  <?php break;?>
  <?php default: ?>
  <?php include_once("layout_left.tpl.php");?>
  <?php break;?>
  <?php endswitch;?>
<?php break;?>
<?php endswitch;?>