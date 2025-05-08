<?php
  /**
   * Slider Manager
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: class_admin.php, v4.00 2014-05-24 12:12:12 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("slidecms")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('slideCMS', new slideCMS());
?>
<?php switch(Filter::$maction): case "edit": ?>
<?php $row = Core::getRowById(slideCMS::mTable, Filter::$id);?>
<div class="tubi icon heading message orange"> <a class="helper tubi top right info corner label" data-help="slidecms"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_SLC_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=slidecms" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_SLC_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_SLC_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_SLC_SUBTITLE1 . $row->title;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->title;?>" name="title">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_HEIGHT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->height;?>" name="height">
          </label>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAVTYPE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="navtype" type="radio" value="thumbs" <?php echo getChecked($row->navtype, "thumbs");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVTYPE_1;?></label>
            <label class="radio">
              <input name="navtype" type="radio" value="dots" <?php echo getChecked($row->navtype, "dots");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVTYPE_2;?></label>
            <label class="radio">
              <input name="navtype" type="radio" value="false" <?php echo getChecked($row->navtype, "false");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVTYPE_3;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAVPOS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="navpos" type="radio" value="top" <?php echo getChecked($row->navpos, "top");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVPOS_1;?></label>
            <label class="radio">
              <input name="navpos" type="radio" value="bottom" <?php echo getChecked($row->navpos, "bottom");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVPOS_2;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAVPLACE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="navplace" type="radio" value="innernav" <?php echo getChecked($row->navplace, "innernav");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVPLACE_1;?></label>
            <label class="radio">
              <input name="navplace" type="radio" value="outer" <?php echo getChecked($row->navplace, "outer");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVPLACE_2;?></label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_ARROWS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="navarrows" type="radio" value="1" <?php echo getChecked($row->navarrows, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="navarrows" type="radio" value="0" <?php echo getChecked($row->navarrows, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_RESMETHOD;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="fit" type="radio" value="contain" <?php echo getChecked($row->fit, "contain");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_RESMETHOD_1;?></label>
            <label class="radio">
              <input name="fit" type="radio" value="cover" <?php echo getChecked($row->fit, "cover");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_RESMETHOD_2;?></label>
            <label class="radio">
              <input name="fit" type="radio" value="scaledown" <?php echo getChecked($row->fit, "scaledown");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_RESMETHOD_3;?></label>
            <label class="radio">
              <input name="fit" type="radio" value="none" <?php echo getChecked($row->fit, "none");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_RESMETHOD_4;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_FULLSCREEN;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="fullscreen" type="radio" value="1" <?php echo getChecked($row->fullscreen, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="fullscreen" type="radio" value="0" <?php echo getChecked($row->fullscreen, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="tubi divider"></div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_TRANSITION;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="transition" type="radio" value="slide" <?php echo getChecked($row->transition, "slide");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_TRANSITION_1;?></label>
            <label class="radio">
              <input name="transition" type="radio" value="crossfade" <?php echo getChecked($row->transition, "crossfade");?>>
              <i></i><?php echo Lang::$word->_MOD_SLC_TRANSITION_2;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_CAPTION;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="captions" type="radio" value="1" <?php echo getChecked($row->captions, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="captions" type="radio" value="0" <?php echo getChecked($row->captions, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_AUTOPLAY;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="autoplay" type="radio" value="1" <?php echo getChecked($row->autoplay, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="autoplay" type="radio" value="0" <?php echo getChecked($row->autoplay, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_LOOP;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="loop" type="radio" value="1" <?php echo getChecked($row->loop, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="loop" type="radio" value="0" <?php echo getChecked($row->loop, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_SHUFFLE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="shuffle" type="radio" value="1" <?php echo getChecked($row->shuffle, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="shuffle" type="radio" value="0" <?php echo getChecked($row->shuffle, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_TRANSDURRATION;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->durration;?>" name="durration">
          </label>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_SLC_EDIT;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=slidecms" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="editSlider" type="hidden" value="1">
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="tubi icon heading message orange"> <a class="helper tubi top right info corner label" data-help="slidecms"><i class="icon help"></i></a><i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_SLC_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=slidecms" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_SLC_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_SLC_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_SLC_SUBTITLE2?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_SLC_NAME;?>" name="title">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_HEIGHT;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_SLC_HEIGHT;?>" name="height">
          </label>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAVTYPE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="navtype" type="radio" value="thumbs">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVTYPE_1;?></label>
            <label class="radio">
              <input name="navtype" type="radio" value="dots" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVTYPE_2;?></label>
            <label class="radio">
              <input name="navtype" type="radio" value="false">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVTYPE_3;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAVPOS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="navpos" type="radio" value="top">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVPOS_1;?></label>
            <label class="radio">
              <input name="navpos" type="radio" value="bottom" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVPOS_2;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_NAVPLACE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="navplace" type="radio" value="innernav">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVPLACE_1;?></label>
            <label class="radio">
              <input name="navplace" type="radio" value="outer" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_SLC_NAVPLACE_2;?></label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_ARROWS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="navarrows" type="radio" value="1" checked="checked">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="navarrows" type="radio" value="0">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_RESMETHOD;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="fit" type="radio" value="contain" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_SLC_RESMETHOD_1;?></label>
            <label class="radio">
              <input name="fit" type="radio" value="cover">
              <i></i><?php echo Lang::$word->_MOD_SLC_RESMETHOD_2;?></label>
            <label class="radio">
              <input name="fit" type="radio" value="scaledown">
              <i></i><?php echo Lang::$word->_MOD_SLC_RESMETHOD_3;?></label>
            <label class="radio">
              <input name="fit" type="radio" value="none">
              <i></i><?php echo Lang::$word->_MOD_SLC_RESMETHOD_4;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_FULLSCREEN;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="fullscreen" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="fullscreen" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="tubi divider"></div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_TRANSITION;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="transition" type="radio" value="slide">
              <i></i><?php echo Lang::$word->_MOD_SLC_TRANSITION_1;?></label>
            <label class="radio">
              <input name="transition" type="radio" value="crossfade" checked="checked">
              <i></i><?php echo Lang::$word->_MOD_SLC_TRANSITION_2;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_CAPTION;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="captions" type="radio" value="1" checked="checked">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="captions" type="radio" value="0">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_AUTOPLAY;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="autoplay" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="autoplay" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_LOOP;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="loop" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="loop" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_SHUFFLE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="shuffle" type="radio" value="1">
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="shuffle" type="radio" value="0" checked="checked">
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_SLC_TRANSDURRATION;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_SLC_TRANSDURRATION;?>" name="durration">
          </label>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_SLC_ADD;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=slidecms" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="addSlider" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"images": ?>
<?php $single = Core::getRowById(slideCMS::mTable, Filter::$id);?>
<?php $sliderdata = Registry::get("slideCMS")->getSliderData();?>
<div class="tubi icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_SLC_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=slidecms" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_SLC_TITLE3;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_SLC_INFO3;?></div>
  <div class="tubi segment">
    <div id="sactions" class="tubi buttons push-right"><a data-option="vids" class="tubi icon positive button"><i class="icon video"></i> <?php echo Lang::$word->_MOD_SLC_ADD_V;?></a><a data-option="pics" class="tubi icon info button"><i class="icon photo"></i> <?php echo Lang::$word->_MOD_SLC_ADD_I;?></a></div>
    <div class="tubi header"><?php echo Lang::$word->_MOD_SLC_SUBTITLE3 . $single->title;?></div>
    <div class="tubi fitted divider"></div>
    <div class="tubi form">
      <form id="tubi_form" name="tubi_form" method="post">
        <div id="vids" class="maction" style="display:none">
          <div class="two fields">
            <div class="field">
              <label><?php echo Lang::$word->_MOD_SLC_VIDURL;?></label>
              <label class="input"><i class="icon-append icon asterisk"></i>
                <input type="text" placeholder="<?php echo Lang::$word->_MOD_SLC_VIDURL;?>" name="vidurl">
              </label>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_MOD_SLC_VIDTITLE;?></label>
              <label class="input"><i class="icon-append icon asterisk"></i>
                <input type="text" placeholder="<?php echo Lang::$word->_MOD_SLC_VIDTITLE;?>" name="vidcaption">
              </label>
            </div>
          </div>
          <p class="tubi success message"><?php echo Lang::$word->_MOD_SLC_VID_T;?></p>
          <div class="tubi divider"></div>
          <button type="button" name="doVideos" class="tubi positive button"><?php echo Lang::$word->_MOD_SLC_ADD2;?></button>
          <input name="doVids" type="hidden" value="1">
          <input name="curfolder" type="hidden" value="<?php echo $single->plug_name;?>">
          <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
        </div>
      </form>
    </div>
    <div id="pics" class="maction" style="display:none">
      <div id="uploader">
        <form id="upload" method="post" action="modules/slidecms/controller.php" enctype="multipart/form-data">
          <div id="drop" class="fade well"> <?php echo Lang::$word->_FM_DROPHERE;?> <a id="upl"><?php echo Lang::$word->_BROWSE;?></a>
            <input type="file" name="mainfile" multiple />
            <input name="id" type="hidden" value="<?php echo $single->id;?>" />
            <input name="doFiles" type="hidden" value="1" />
            <input name="sfolder" type="hidden" value="<?php echo $single->plug_name;?>">
          </div>
          <ul>
          </ul>
        </form>
      </div>
    </div>
  </div>
  <div id="msgholder"></div>
  <?php if(!$sliderdata):?>
  <?php Filter::msgInfo(Lang::$word->_MOD_SLC_NOSLIDES);?>
  <?php endif;?>
  <div id="slidedata" class="tubi grid fitted">
    <?php if($sliderdata):?>
    <?php foreach($sliderdata as $row):?>
    <div class="item">
      <?php if($row->data_type == "vid"):?>
      <img src="<?php echo SITEURL;?>/plugins/slidecms/images/video.png" alt="" class="tubi image">
      <?php else:?>
      <a href="<?php echo SITEURL . '/plugins/' . $single->plug_name . '/slides/' . $row->data;?>" class="lightbox" title="<?php echo $row->{'caption' . Lang::$lang};?>"><img src="<?php echo SITEURL . '/plugins/' . $single->plug_name . '/slides/' . $row->data;?>" alt="" class="tubi image"></a>
      <?php endif;?>
      <a data-id="<?php echo $row->id;?>" data-type="<?php echo $row->data_type;?>" data-name="<?php echo $row->{'caption' . Lang::$lang};?>" class="imgdelete tubi top right negative corner label"><i class="icon remove sign"></i></a>
      <div class="tubi-content">
        <div contenteditable="true" data-path="false" data-edit-type="cslidecms" data-id="<?php echo $row->id;?>" data-key="title" class="tubi editable"><?php echo $row->{'caption' . Lang::$lang};?></div>
      </div>
    </div>
    <?php endforeach;?>
    <?php endif;?>
  </div>
</div>
<script src="modules/slidecms/slidecms.js"></script> 
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
	$('body').on('click', 'button[name=doVideos]', function () {
		function showResponse(json) {
			$(".tubi.form").removeClass("loading");
			$container = $('#slidedata');
			if(json.type == "success") {
				$container.html(json.html);
				$container.waitForImages(function () {
				   $container.elasticColumns('refresh');
				   $container.Grid('displayItems')
				});
				
			}
			$("#msgholder").html(json.message);
		}

		function showLoader() {
			$(".tubi.form").addClass("loading");
		}
		var options = {
			target: "#msgholder",
			beforeSubmit: showLoader,
			success: showResponse,
			type: "post",
			url: "modules/slidecms/controller.php",
			dataType: 'json'
		};

		$('#tubi_form').ajaxForm(options).submit();
	});
	
    $('#sactions a').click(function () {
        action = $("#" + $(this).data("option"));
        $(".maction:not(#" + action.attr("id") + ")").slideUp(500,function(){
             action.slideDown(500);
        });
    }); 
	
	$('#slidedata').waitForImages(function () {
		$('#slidedata').TubiGrid({
			inner: 14,
			outer: 0,
			curDir: '<?php echo $single->plug_name;?>'
		});
	});
});
// ]]>
</script>
<?php break;?>
<?php default: ?>
<?php $sliderow = Registry::get("slideCMS")->getSliders();?>
<div class="tubi icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_SLC_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getModuleName(Filter::$modname);?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_SLC_INFO4;?></div>
  <div class="tubi segment"> <a class="tubi icon info button push-right" href="<?php echo Core::url("modules", "add");?>"><i class="icon add"></i> <?php echo Lang::$word->_MOD_SLC_ADD;?></a>
    <div class="tubi header"><?php echo Lang::$word->_MOD_SLC_SUBTITLE4;?></div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th data-sort="int">#</th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_SLC_NAME;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$sliderow):?>
        <tr>
          <td colspan="3"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_SLC_NOSLIDERS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($sliderow as $row):?>
        <tr>
          <td><?php echo $row->id;?>.</td>
          <td><?php echo $row->title;?></td>
          <td><a href="<?php echo Core::url("modules", "edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a href="<?php echo Core::url("modules", "images", $row->id);?>"><i class="rounded inverted info icon laptop link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_SLC_SLIDER;?>" data-option="deleteSlider" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->title;?>"><i class="rounded danger inverted remove icon link"></i></a></td>
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
