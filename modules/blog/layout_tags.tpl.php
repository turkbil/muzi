<?php
  /**
   * Articles Tag Search
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: tag_search.tpl.php, v4.00 2014-02-20 16:18:34 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  $tagname = sanitize($content->_url[2]);
?>
<?php $latestrow = Registry::get("Blog")->renderTagList();?>
<?php if (!$tagname || strlen($tagname = trim($tagname)) == 0 || strlen($tagname) < 3):?>
<?php Filter::msgAlert(Lang::$word->_MOD_AMT_NOTAG);?>
<?php elseif(!$latestrow):?>
<?php Filter::msgAlert(Lang::$word->_SR_SEARCH_EMPTY . '<span class="tubi black label">'.$tagname.'</span>' . Lang::$word->_SR_SEARCH_EMPTY1);?>
<?php else:?>
<h1 class="tubi double header"><span><?php echo '<small class="tubi label">' . count($latestrow) . '</small> ' .Lang::$word->_MOD_AMT_RESFOR . $tagname;?></span></h1>
<div id="articles" class="relative layout-left">
  <?php foreach ($latestrow as $row):?>
  <article class="clearfix">
    <?php if($row->show_created):?>
    <aside>
      <div><span class="day"><?php echo $row->day;?></span><span class="year"><?php echo Blog::getShortMonths($row->month) . ' ' . $row->year;?></span></div>
    </aside>
    <?php endif;?>
    <section>
      <div class="header clearfix">
        <div class="title">
          <h3><a href="<?php echo Url::Blog("item", $row->slug);?>" class="inverted"><?php echo $row->atitle;?></a></h3>
        </div>
        <div class="tubi small horizontal divided list">
          <?php if($row->show_author):?>
          <div class="item"> <i class="icon user"></i> <a href="<?php echo Url::Blog("blog-author", $row->username);?>" class="inverted"><?php echo $row->username;?></a> </div>
          <?php endif;?>
          <div class="item"> <i class="icon sitemap"></i> <a href="<?php echo Url::Blog("blog-cat", $row->catslug);?>" class="inverted"><?php echo $row->catname;?></a> </div>
          <div class="item"> <i class="icon chat"></i> <?php echo $row->totalcomments;?> <?php echo Lang::$word->_MOD_AM_COMMENTS;?></div>
        </div>
      </div>
      <?php if($row->thumb):?>
      <figure class="small-top-space small-bottom-space">
        <div class="image-overlay tubi left floated image"> <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL.'/'.Blog::imagepath . $row->thumb;?>&amp;h=150&amp;w=250&amp;s=1&amp;a=tl" alt="">
          <div class="overlay-fade"> <a title="<?php echo $row->{'caption'.Lang::$lang};?>" href="<?php echo Url::Blog("item", $row->slug);?>"><i class="icon-overlay icon url"></i></a></div>
        </div>
      </figure>
      <?php endif;?>
      <?php $desc = cleanSanitize($row->{'short_desc'.Lang::$lang});?>
      <div class="description"><?php echo $desc;?> <a href="<?php echo Url::Blog("item", $row->slug);?>"><?php echo Lang::$word->_MOD_AM_MORE;?><i class="icon right angle"></i></a></div>
    </section>
  </article>
  <?php endforeach;?>
  <?php unset($row);?>
</div>
<?php endif;?>