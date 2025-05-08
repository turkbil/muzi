<?php
  /**
   * Gallery
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: gallery.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("gallery")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
    
  Registry::set('Gallery', new Gallery());
?>
<?php switch(Filter::$maction): case "edit": ?>
<?php //if(!Registry::get("Gallery")->title): redirect_to("index.php?do=modules&action=config&modname=gallery"); endif;?>
<?php $row = Registry::get("Gallery");?>

<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="gallery"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_GA_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=gallery" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_GA_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_GA_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_GA_SUBTITLE1 . $row->title;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GA_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->title;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GA_COLS;?></label>
          <label class="input">
            <input class="slrange" type="text" value="<?php echo $row->cols;?>" name="cols">
          </label>
        </div>
      </div>
      <div class="tubi divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GA_LIKE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="like" type="radio" value="1" <?php echo getChecked($row->like, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="like" type="radio" value="0" <?php echo getChecked($row->like, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GA_WATERMARK;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="watermark" type="radio" value="1" <?php echo getChecked($row->watermark, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="watermark" type="radio" value="0" <?php echo getChecked($row->watermark, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_GA_UPDATE;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=gallery" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processGallery" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $("input[name=cols]").ionRangeSlider({
		min: 1,
		max: 6,
        step: 1,
		postfix: " col",
        type: 'single',
        hasGrid: true
    });
});
// ]]>
</script>
<?php break;?>
<?php case"add": ?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="gallery"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_GA_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=gallery" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_GA_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_GA_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_GA_SUBTITLE2;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GA_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_GA_NAME;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GA_COLS;?></label>
          <input class="slrage" type="text" name="cols" value="3">
        </div>
      </div>
      <!-- div class="tubi divider"></div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GA_FOLDER;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_GA_FOLDER;?>" name="folder">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GA_WATERMARK;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="watermark" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="watermark" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_GA_LIKE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="like" type="radio" value="1" checked="checked">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="like" type="radio" value="0">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div -->
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_GA_ADDMOD_GALLERY;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=gallery" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processGallery" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $("input[name=cols]").ionRangeSlider({
		min: 1,
		max: 6,
        step: 1,
		postfix: " kolon",
        type: 'single',
        hasGrid: true
    });
});
// ]]>
</script>
<?php break;?>
<?php case"sort": ?>
<?php $galdata = Registry::get("Gallery")->getGalleryImages();?>
<div class="tubi icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_GA_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=gallery" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_GA_TITLE5;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_GA_INFO5;?></div>
  <div class="tubi segment">
    <?php if(!$galdata):?>
    <?php Filter::msgInfo(Lang::$word->_MOD_GA_NOIMG);?>
    <?php else:?>
    <div id="sortable" class="tubi medium images">
      <?php foreach($galdata as $row):?>
      <img id="list_<?php echo $row->id;?>"src="<?php echo SITEURL . '/' . Gallery::galpath . Registry::get("Gallery")->folder . '/' . $row->thumb;?>" alt="" class="tubi image">
      <?php endforeach;?>
    </div>
    <?php endif;?>
  </div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $("#sortable").sortable({
        helper: 'clone',
		items: 'img',
        opacity: .6,
        update: function (event, ui) {
            serialized = $("#sortable").sortable('serialize');
            $.ajax({
                type: "POST",
                url: "modules/gallery/controller.php?sortImages",
                data: serialized,
                success: function (msg) {}
            });
        }
    });
});
// ]]>
</script>
<?php break;?>
<?php case"images": ?>
<?php if(!Filter::$id): redirect_to("index.php?do=modules&action=config&modname=gallery"); endif;?>
<?php $galdata = Registry::get("Gallery")->getGalleryImages();?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="gallery_upload"><i class="icon help"></i></a><i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_GA_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=gallery" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_GA_TITLE3;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_GA_INFO3;?></div>
  <div class="tubi form segment">
    <div class="tubi buttons push-right"><a onclick="$('#extra').slideToggle();" class="tubi positive button"><i class="icon disk upload"></i><?php echo Lang::$word->_MOD_GA_ADD_IMG;?></a><a href="<?php echo Core::url("modules", "sort", Filter::$id);?>" class="tubi info button"><i class="sort attributes icon"></i><?php echo Lang::$word->_MOD_GA_SORT;?></a></div>
    <div class="tubi header"><?php echo Lang::$word->_MOD_GA_SUBTITLE3 . Registry::get("Gallery")->title;?></div>
    <div class="tubi fitted divider"></div>
    <div id="extra" style="display:none">
      <div id="uploader">
        <form id="upload" method="post" action="modules/gallery/controller.php" enctype="multipart/form-data">
          <div id="drop" class="fade well"> <?php echo Lang::$word->_FM_DROPHERE;?> <a id="upl"><?php echo Lang::$word->_BROWSE;?></a>
            <input type="file" name="mainfile" multiple>
            <input name="fdirectory" type="hidden" value="<?php echo Registry::get('Gallery')->folder;?>">
            <input name="doFiles" type="hidden" value="1">
            <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
          </div>
          <ul>
          </ul>
        </form>
      </div>
      <div class="tubi double fitted divider"></div>
    </div>
    <?php if(!$galdata):?>
    <?php Filter::msgInfo(Lang::$word->_MOD_GA_NOIMG);?>
    <?php endif;?>
    <div id="gallery" class="tubi grid fitted">
      <?php if($galdata):?>
      <?php foreach($galdata as $row):?>
      <div class="item" id="list_<?php echo $row->id;?>"><a data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>" class="imgdelete tubi top right negative corner label"><i class="icon remove sign"></i></a> <a href="<?php echo SITEURL . '/' . Gallery::galpath . Registry::get("Gallery")->folder . '/' . $row->thumb;?>" class="lightbox" title="<?php echo $row->{'title' . Lang::$lang};?>"><img src="<?php echo SITEURL . '/' . Gallery::galpath . Registry::get("Gallery")->folder . '/' . $row->thumb;?>" alt="" class="tubi image"></a>
        <div class="tubi-content">
          <div contenteditable="true" data-path="false" data-edit-type="gallery" data-id="<?php echo $row->id;?>" data-key="title" class="tubi editable"><?php echo $row->{'title' . Lang::$lang};?></div>
          <div class="tubi small divider"></div>
          <div contenteditable="true" data-path="false" data-edit-type="gallery" data-id="<?php echo $row->id;?>" data-key="desc" class="tubi editable"><?php echo $row->{'description' . Lang::$lang};?></div>
        </div>
      </div>
      <?php endforeach;?>
      <?php endif;?>
    </div>
  </div>
</div>
<script src="modules/gallery/gallery.js"></script> 
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $('#gallery').TubiGrid({
		inner: 14,
		outer: 0,
        curDir: '<?php echo Registry::get('Gallery')->folder;?>'
    });
});
// ]]>
</script>
<?php break;?>
<?php default: ?>
<?php $galdata = Registry::get("Gallery")->getGalleries();?>
<div class="tubi icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_GA_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getModuleName(Filter::$modname);?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_GA_INFO4;?></div>
  <div class="tubi segment"> <a class="tubi icon warning button push-right" href="<?php echo Core::url("modules", "add");?>"><i class="icon add"></i> <?php echo Lang::$word->_MOD_GA_ADDNEW;?></a>
    <div class="tubi header"><?php echo Lang::$word->_MOD_GA_SUBTITLE4;?></div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_GA_NAME;?></th>
          <th data-sort="int"><?php echo Lang::$word->_MOD_GA_TOTAL_IMG;?></th>
          <th data-sort="int"><?php echo Lang::$word->_CREATED;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$galdata):?>
        <tr>
          <td colspan="5"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_GA_NOMOD_GAL);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($galdata as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->{'title'.Lang::$lang};?></td>
          <td><?php echo $row->totalpics;?></td>
          <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("short_date", $row->created);?></td>
          <td><a href="<?php echo Core::url("modules", "edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a href="<?php echo Core::url("modules", "images", $row->id);?>"><i class="rounded inverted info icon laptop link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_GALLERY;?>" data-option="deleteGallery" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
</div>
<?php break;?>
<?php endswitch;?>
