<?php if(!Blog::getMembershipAccess($row->membership_id)):?>
<?php echo Filter::msgSingleAlert(Lang::$word->_UA_ACC_ERR2 . Blog::listMemberships($row->membership_id));?>
<?php else:?>
<!-- Banner Area Start -->
    <section class="blog-banner">
        <img src="<?php echo SITEURL.'/'.Blog::imagepath . $row->thumb;?>" alt="">
        <div class="content">
            <h1><?php echo $row->atitle;?></h1>
            <div class="article-meta"><a href="<?php echo Url::Blog("blog-cat", $row->catslug);?>" class="category"><?php echo $row->catname;?></a> <div class="divider">|</div> <div class="article-date"><?php echo Filter::dodate("short_date",$row->created);?></div> </div>
        </div>
    </section>
<!-- Banner Area End -->

<section class="article-body mt-3 mb-3">
    <?php echo cleanOut($row->{'body'.Lang::$lang});?>
</section>
<?php endif;?>