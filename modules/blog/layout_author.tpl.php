<?php
  /**
   * Articles Layout Author
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: layout_author.tpl.php, v4.00 2014-03-24 15:14:44 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $latestrow = Registry::get("Blog")->renderAuthorArticles();?>
<?php $bio = getValues("info, avatar, username", Users::uTable, "username = '" . $content->_url[2] . "'");?>
<?php if(!$latestrow):?>
<?php Filter::msgSingleAlert(Lang::$word->_MOD_AM_NOAUTHOR . '<span class="tubi label">' . $content->_url[2]) . '</span>';?>
<?php else:?>
<h1 class="tubi double header"><span><?php echo '<small class="tubi label">' . $pager->items_total . '</small> ' .Lang::$word->_MOD_AM_ARTFOUND;?></span></h1>
<?php if($bio):?>
<div class="tubi secondary segment">
  <?php if($bio->avatar):?>
  <img src="<?php echo UPLOADURL;?>avatars/<?php echo $bio->avatar;?>" alt="<?php echo $bio->username;?>" class="tubi left floated avatar image">
  <?php else:?>
  <img src="<?php echo UPLOADURL;?>avatars/blank.png" alt="<?php echo $bio->username;?>" class="tubi left floated avatar image">
  <?php endif;?>
  <?php echo $bio->info;?></div>
<div class="tubi small space divider"></div>
<?php endif;?>
<div id="author-data" class="relative">
  <?php foreach ($latestrow as $row):?>
  <div class="item">
    <h5><a href="<?php echo Url::Blog("item", $row->slug);?>" class="inverted"><?php echo $row->atitle;?></a></h5>
    <div class="tubi small divider"></div>
    <div class="tubi small horizontal list">
      <div class="item"> <i class="icon sitemap"></i> <a href="<?php echo Url::Blog("blog-cat", $row->catslug);?>" class="inverted"><?php echo $row->catname;?></a> </div>
      <div class="item"> <i class="icon chat"></i> <?php echo $row->totalcomments;?> <?php echo Lang::$word->_MOD_AM_COMMENTS;?></div>
    </div>
    <div class="tubi small divider"></div>
    <?php $desc = cleanSanitize($row->{'short_desc'.Lang::$lang});?>
    <div class="vspace"><?php echo truncate($desc,250);?></div>
  </div>
  <?php endforeach;?>
</div>
<?php unset($row);?>
<div id="pagination" class="content-center"><?php echo $pager->display_pages();?></div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
	$('#author-data').waitForImages(function () {
		$('#author-data').Grid({
			inner: 14,
			outer: 0,
			cols: Math.round(1200 / 3)
		});
	});
});
// ]]>
</script>
<?php endif;?>