<?php
  /**
   * Blog Layout Two Columns
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: layout_twocol.tpl.php, v4.00 2014-04-20 16:18:34 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if(!$latestrow):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_MOD_AM_NO_ART_CATS);?>
<?php else:?>
<?php if($length == 3):?>
<h3><a href="<?php echo SITEURL;?>/blog_rss.php?cid=<?php echo $single->id;?>" class="push-right"><i class="icon rss"></i></a>
  <?php if($single->icon):?>
  <i class="<?php echo $single->icon;?>"></i>
  <?php endif;?>
  <?php echo Lang::$word->_MOD_AM_BLCAT.' / '.$single->{'name'.Lang::$lang};?></h3>
<?php if($single->{'description'.Lang::$lang}):?>
<p><?php echo cleanSanitize($single->{'description'.Lang::$lang});?></p>
<div class="tubi divider"></div>
<?php endif;?>
<?php endif;?>
<div id="articles" class="relative">
  <div class="artwrap">
    <?php foreach($latestrow as $i => $row):?>
    <div class="item">
      <h4><i class="icon warning star"></i> <a href="<?php echo Url::Blog("item", $row->slug);?>" class="inverted"><?php echo truncate($row->atitle,40);?></a></h4>
      <div class="tubi small divider"></div>
      <div class="tubi small horizontal list">
        <?php if($row->show_author):?>
        <div class="item"> <i class="icon user"></i>
          <div class="content"> <a href="<?php echo Url::Blog("blog-author", $row->username);?>" class="inverted"><?php echo $row->username;?></a> </div>
        </div>
        <?php endif;?>
        <div class="item"> <i class="icon sitemap"></i>
          <div class="content"> <a href="<?php echo Url::Blog("blog-cat", $row->catslug);?>" class="inverted"><?php echo $row->catname;?></a> </div>
        </div>
        <div class="item"> <i class="icon chat"></i>
          <div class="content"> <?php echo $row->totalcomments;?> </div>
        </div>
        <?php if($row->show_created):?>
        <div class="item"> <i class="icon calendar"></i>
          <div class="content"> <?php echo Filter::dodate("short_date", $row->created);?> </div>
        </div>
        <?php endif;?>
      </div>
      <div class="tubi small divider"></div>
      <?php if($row->thumb):?>
      <figure class="small-top-space small-bottom-space">
        <div class="image-overlay tubi image"> <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL.'/'.Blog::imagepath . $row->thumb;?>&amp;h=350&amp;w=600&amp;s=1&amp;a=tl" alt="">
          <div class="overlay-fade"> <a title="<?php echo $row->{'caption'.Lang::$lang};?>" href="<?php echo Url::Blog("item", $row->slug);?>"><i class="icon-overlay icon url"></i></a></div>
        </div>
      </figure>
      <?php endif;?>
      <?php $desc = cleanSanitize($row->{'short_desc'.Lang::$lang});?>
      <p class="desc"><?php echo truncate($desc,130, ".");?> <a href="<?php echo Url::Blog("item", $row->slug);?>"><?php echo Lang::$word->_MOD_AM_MORE;?><i class="icon right angle"></i></a></p>
    </div>
    <?php endforeach;?>
  </div>
  <?php unset($row);?>
  <div id="pagination" class="content-center"><?php echo $pager->display_pages();?></div>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
	$('#articles .artwrap').waitForImages(function () {
		$('#articles .artwrap').Grid({
			inner: 20,
			outer: 0,
			cols: 600
		});
	});
});
// ]]>
</script>
<?php endif;?>