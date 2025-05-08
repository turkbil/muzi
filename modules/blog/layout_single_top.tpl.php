<?php if(!Blog::getMembershipAccess($row->membership_id)):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_UA_ACC_ERR2 . Blog::listMemberships($row->membership_id));?>
<?php else:?>
<h3><?php echo $row->atitle;?></h3>
<div class="tubi divider"></div>
<div class="tubi horizontal divided list">
  <?php if($row->show_author):?>
  <div class="item"> <i class="icon user"></i> <a href="<?php echo Url::Blog("blog-author", $row->username);?>" class="inverted"><?php echo $row->username;?></a> </div>
  <?php endif;?>
  <div class="item"> <i class="icon sitemap"></i> <a href="<?php echo Url::Blog("blog-cat", $row->catslug);?>" class="inverted"><?php echo $row->catname;?></a> </div>
  <div class="item"> <i class="icon chat"></i> <?php echo $row->totalcomments;?> <?php echo Lang::$word->_MOD_AM_COMMENTS;?></div>
  <div class="item"> <i class="icon bullseye"></i> <?php echo $row->hits;?> </div>
  <?php if($row->show_created):?>
  <div class="item"> <i class="icon calendar"></i> <?php echo Filter::dodate("short_date",$row->created);?> </div>
  <?php endif;?>
</div>
<div class="tubi divider"></div>
<article id="article" class="clearfix">
  <figure class="small-top-space small-bottom-space">
    <?php if($row->gallery):?>
    <?php include_once("gallery.tpl.php");?>
    <?php else:?>
    <?php if($row->thumb):?>
    <div class="image-overlay tubi center floated image"> <img src="<?php echo SITEURL.'/'.Blog::imagepath . $row->thumb;?>" alt="">
      <div class="overlay-fade"> <a title="<?php echo $row->{'caption'.Lang::$lang};?>" href="<?php echo SITEURL.'/'.Blog::imagepath . $row->thumb;?>" class="lightbox"><i class="icon-overlay icon url"></i></a></div>
    </div>
    <?php endif;?>
    <?php endif;?>
  </figure>
  <div class="clearfix"><?php echo cleanOut($row->{'body'.Lang::$lang});?></div>
  <div class="tubi divider"></div>
  <div class="tubi horizontal divided list">
    <?php if($row->filename):?>
    <div class="item"> <i class="icon download disk"></i> <a href="<?php echo MODURL;?>blog/datafiles/<?php echo $row->filename;?>" class="inverted"><?php echo Lang::$word->_MOD_AM_FILE_ATTD;?></a> </div>
    <?php endif;?>
    <?php if($row->show_ratings):?>
    <div class="item">
      <?php Blog::renderRating($row->id, $row->rating, $row->rate_number, "small");?>
    </div>
    <?php endif;?>
    <div class="item"> <i class="icon calendar"></i> <?php echo Lang::$word->_MOD_AM_MODIFIED;?>: <?php echo ($row->modified == 0) ? '-/-' : dodate($core->long_date,$row->modified);?> </div>
  </div>
  <div class="tubi divider"></div>
  <?php $related = Registry::get("Blog")->getRelatedArticles($row->id, $row->atitle);?>
  <?php if($related):?>
  <b><?php echo Lang::$word->_MOD_AM_RELATED;?></b>:
  <?php foreach($related as $relrow):?>
  <a href="<?php echo Url::Blog("item", $relrow->slug);?>" class="tubi label"><?php echo $relrow->atitle;?></a>
  <?php endforeach;?>
  <div class="tubi divider"></div>
  <?php endif;?>
  <?php if($row->show_sharing or $row->show_like):?>
  <div class="content"> <a target="_blank" data-content="<?php echo Lang::$word->_MOD_AM_SHARE;?> Facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo Url::Blog("item", $row->slug);?>" class="tubi icon facebook button"><i class="icon facebook"></i></a> <a data-content="<?php echo Lang::$word->_MOD_AM_SHARE;?> Twitter" href="https://twitter.com/home?status=<?php echo Url::Blog("item", $row->slug);?>" class="tubi icon twitter button"><i class="icon twitter"></i></a> <a target="_blank" data-content="<?php echo Lang::$word->_MOD_AM_SHARE;?> Google +" href="https://plus.google.com/share?url=<?php echo Url::Blog("item", $row->slug);?>" class="tubi icon google plus button"><i class="icon google plus"></i></a> <a target="_blank" data-content="<?php echo Lang::$word->_MOD_AM_SHARE;?> Pinterest" href="https://pinterest.com/pin/create/button/?url=&amp;media=<?php echo Url::Blog("item", $row->slug);?>" class="tubi icon pinterest button"><i class="icon pinterest"></i></a>
    <?php if($row->show_like):?>
    <a data-id="<?php echo $row->id;?>" data-total="<?php echo $row->like_up;?>" class="tubi like danger labeled icon button push-right"> <i data-content="<?php echo Lang::$word->_MOD_AM_LIKE;?>" class="heart icon"></i> <span><?php echo $row->like_up;?></span> </a>
    <?php endif;?>
  </div>
  <div class="tubi divider"></div>
  <?php endif;?>
  <?php if($row->tags):?>
  <?php $tags = explode(",", $row->tags);?>
  <?php foreach($tags as $tag):?>
  <a href="<?php echo Url::Blog("blog-tags", $tag);?>" class="tubi tag label"><i class="icon tag"></i> <?php echo $tag;?></a>
  <?php endforeach;?>
  <div class="tubi divider"></div>
  <?php endif;?>
</article>
<?php include_once("comments.tpl.php");?>
<script src="<?php echo MODURL;?>blog/common.js"></script>
<?php endif;?>