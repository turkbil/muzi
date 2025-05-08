<?php
  /**
   * Image Slider
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: admin.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  if(!$user->getAcl("slider")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  Registry::set('Slider', new Slider());
?>
<?php switch(Filter::$paction): case "edit": ?>
<?php $row = Core::getRowById(Slider::mTable, Filter::$id);?>

<div class="tubi icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_SL_TITLE;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=slider" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_SL_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_SL_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_PLG_SL_SUBTITLE2 . $row->{'title'.Lang::$lang};?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label>Başlık</label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
          <div class="small-top-space">
            <label><?php echo Lang::$word->_PLG_SL_IMG_SEL;?></label>
            <label class="input">
              <input type="file" name="thumb" class="filefield">
            </label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_DESC;?></label>
          <textarea name="body<?php echo Lang::$lang;?>"><?php echo Filter::out_url($row->{'body'.Lang::$lang});?></textarea>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_URL_T;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="urltype" type="radio" onclick="$('#urlchange').show();$('#urlchange2').hide()" value="ext" <?php getChecked($row->urltype, "ext"); ?>>
              <i></i><?php echo Lang::$word->_PLG_SL_EXTLINK;?></label>
            <label class="radio">
              <input name="urltype" type="radio" onclick="$('#urlchange2').show();$('#urlchange').hide()" value="int" <?php getChecked($row->urltype, "int"); ?>>
              <i></i><?php echo Lang::$word->_PLG_SL_INTLINK;?></label>
            <label class="radio">
              <input name="urltype" type="radio" value="nourl" <?php getChecked($row->urltype, "nourl"); ?>>
              <i></i><?php echo Lang::$word->_PLG_SL_NOLINK;?></label>
          </div>
        </div>
        <div class="field">
          <div id="urlchange"<?php echo ($row->urltype == "ext") ? "" : " style=\"display:none\""; ?>>
            <label> <?php echo Lang::$word->_PLG_SL_EXTLINK;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input type="text" value="<?php echo $row->url;?>" name="url">
            </label>
          </div>
          <div id="urlchange2"<?php echo ($row->urltype == "int") ? "" : " style=\"display:none\""; ?>>
            <label> <?php echo Lang::$word->_PLG_SL_INTPAGE;?></label>
            <?php echo Content::getPageList("id", $row->page_id);?> </div>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <div class="field">
        <label>HTML</label>
        <textarea name="html" style="height: 400px;"><?php echo Filter::out_url($row->{'html'});?></textarea>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_PLG_SL_UPDATE;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=slider" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processSlide" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="tubi icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_SL_TITLE;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=slider" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_SL_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_SL_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_PLG_SL_SUBTITLE1;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label>Başlık</label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_PLG_SL_CAPTION;?>" name="title<?php echo Lang::$lang;?>">
          </label>
          <div class="small-top-space">
            <label><?php echo Lang::$word->_PLG_SL_IMG_SEL;?></label>
            <label class="input">
              <input type="file" name="thumb" class="filefield">
            </label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_DESC;?></label>
          <textarea placeholder="<?php echo Lang::$word->_PLG_SL_DESC;?>" name="body<?php echo Lang::$lang;?>"></textarea>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_URL_T;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="urltype" type="radio" onclick="$('#urlchange').show();$('#urlchange2').hide()" value="ext">
              <i></i><?php echo Lang::$word->_PLG_SL_EXTLINK;?></label>
            <label class="radio">
              <input name="urltype" type="radio" onclick="$('#urlchange2').show();$('#urlchange').hide()" value="int">
              <i></i><?php echo Lang::$word->_PLG_SL_INTLINK;?></label>
            <label class="radio">
              <input name="urltype" type="radio" value="nourl" checked="checked">
              <i></i><?php echo Lang::$word->_PLG_SL_NOLINK;?></label>
          </div>
        </div>
        <div class="field">
          <div id="urlchange" style="display:none">
            <label> <?php echo Lang::$word->_PLG_SL_EXTLINK;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input placeholder="<?php echo Lang::$word->_PLG_SL_EXTLINK;?>" type="text" name="url">
            </label>
          </div>
          <div id="urlchange2" style="display:none">
            <label> <?php echo Lang::$word->_PLG_SL_INTPAGE;?></label>
            <?php echo Content::getPageList("id");?> </div>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <div class="field">
        <label>HTML</label>
        <textarea name="html" style="height: 400px;"></textarea>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_PLG_SL_TITLE1;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=slider" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processSlide" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"config": ?>
<?php $row = Registry::get("Slider");?>
<div class="tubi icon heading message orange"> <a class="helper tubi top right info corner label" data-help="slider"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_SL_TITLE;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=slider" class="section"><?php echo $content->getPluginName(Filter::$plugname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PLG_SL_CONF;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_SL_INFO4. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_PLG_SL_SUBTITLE4;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_HEIGHT;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->sliderHeight;?>" name="sliderHeight">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_TRSPEED;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->slideTransitionSpeed;?>" name="slideTransitionSpeed">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_TRDELAY;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->slideTransitionDelay;?>" name="slideTransitionDelay">
          </label>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_TRANS;?></label>
          <select name="slideTransition">
            <option value="slide"<?php if($row->slideTransition == 'slide') echo ' selected="selected"';?>>Slide Effect</option>
            <option value="fade"<?php if($row->slideTransition == 'fade') echo ' selected="selected"';?>>Fade Effect</option>
          </select>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_TRANS_EAS;?></label>
          <select name="slideTransitionEasing">
            <option value="swing"<?php if($row->slideTransitionDirection == 'swing') echo ' selected="selected"';?>>swing</option>
            <option value="easeInQuad"<?php if($row->slideTransitionDirection == 'easeInQuad') echo ' selected="selected"';?>>easeInQuad</option>
            <option value="easeOutQuad"<?php if($row->slideTransitionDirection == 'easeOutQuad') echo ' selected="selected"';?>>easeOutQuad</option>
            <option value="easeInOutQuad"<?php if($row->slideTransitionDirection == 'easeInOutQuad') echo ' selected="selected"';?>>easeInOutQuad</option>
            <option value="easeOutExpo"<?php if($row->slideTransitionDirection == 'easeOutExpo') echo ' selected="selected"';?>>easeOutExpo</option>
            <option value="easeInOutExpo"<?php if($row->slideTransitionDirection == 'easeInOutExpo') echo ' selected="selected"';?>>easeInOutExpo</option>
            <option value="easeInBack"<?php if($row->slideTransitionDirection == 'easeInBack') echo ' selected="selected"';?>>easeInBack</option>
            <option value="easeOutBack"<?php if($row->slideTransitionDirection == 'easeOutBack') echo ' selected="selected"';?>>easeOutBack</option>
            <option value="easeOutBounce"<?php if($row->slideTransitionDirection == 'easeOutBounce') echo ' selected="selected"';?>>easeOutBounce</option>
            <option value="easeInOutBounce"<?php if($row->slideTransitionDirection == 'easeInOutBounce') echo ' selected="selected"';?>>easeInOutBounce</option>
          </select>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_TRANS_DIR;?></label>
          <select name="slideTransitionDirection">
            <option value="up"<?php if($row->slideTransitionDirection == 'up') echo ' selected="selected"';?>>Up</option>
            <option value="right"<?php if($row->slideTransitionDirection == 'right') echo ' selected="selected"';?>>Right</option>
            <option value="down"<?php if($row->slideTransitionDirection == 'down') echo ' selected="selected"';?>>Down</option>
            <option value="left"<?php if($row->slideTransitionDirection == 'left') echo ' selected="selected"';?>>Left</option>
          </select>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_SCALE;?></label>
          <select name="slideImageScaleMode">
            <option value="fit"<?php if($row->slideImageScaleMode == 'fit') echo ' selected="selected"';?>>Fit</option>
            <option value="fill"<?php if($row->slideImageScaleMode == 'fill') echo ' selected="selected"';?>>Fill</option>
            <option value="stretch"<?php if($row->slideImageScaleMode == 'stretch') echo ' selected="selected"';?>>Stretch</option>
            <option value="center"<?php if($row->slideImageScaleMode == 'center') echo ' selected="selected"';?>>Center</option>
            <option value="none"<?php if($row->slideImageScaleMode == 'none') echo ' selected="selected"';?>>None</option>
          </select>
        </div>
      </div>
      <div class="tubi fitted divider"></div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_ADPHEIGHT;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="sliderHeightAdaptable" type="radio" value="1" <?php getChecked($row->sliderHeightAdaptable, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="sliderHeightAdaptable" type="radio" value="0" <?php getChecked($row->sliderHeightAdaptable, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_APLAY;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="sliderAutoPlay" type="radio" value="1" <?php getChecked($row->sliderAutoPlay, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="sliderAutoPlay" type="radio" value="0" <?php getChecked($row->sliderAutoPlay, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_SHUFLLE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="slideShuffle" type="radio" value="1" <?php getChecked($row->slideShuffle, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="slideShuffle" type="radio" value="0" <?php getChecked($row->slideShuffle, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_WLOAD;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="waitForLoad" type="radio" value="1" <?php getChecked($row->sliderAutoPlay, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="waitForLoad" type="radio" value="0" <?php getChecked($row->sliderAutoPlay, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_REVERSE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="slideReverse" type="radio" value="1" <?php getChecked($row->slideReverse, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="slideReverse" type="radio" value="0" <?php getChecked($row->slideReverse, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_STRIP;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="showFilmstrip" type="radio" value="1" <?php getChecked($row->showFilmstrip, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="showFilmstrip" type="radio" value="0" <?php getChecked($row->showFilmstrip, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_CAPTIONS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="showCaptions" type="radio" value="1" <?php getChecked($row->showCaptions, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="showCaptions" type="radio" value="0" <?php getChecked($row->showCaptions, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_CAPTIONS_S;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="simultaneousCaptions" type="radio" value="1" <?php getChecked($row->simultaneousCaptions, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="simultaneousCaptions" type="radio" value="0" <?php getChecked($row->simultaneousCaptions, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_TIMER;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="showTimer" type="radio" value="1" <?php getChecked($row->showTimer, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="showTimer" type="radio" value="0" <?php getChecked($row->showTimer, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_PAUSE;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="showPause" type="radio" value="1" <?php getChecked($row->showPause, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="showPause" type="radio" value="0" <?php getChecked($row->showPause, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_ARROWS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="showArrows" type="radio" value="1" <?php getChecked($row->showArrows, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="showArrows" type="radio" value="0" <?php getChecked($row->showArrows, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PLG_SL_DOTS;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="showDots" type="radio" value="1" <?php getChecked($row->showDots, 1); ?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="showDots" type="radio" value="0" <?php getChecked($row->showDots, 0); ?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_PLG_SL_BUT_CONF_U;?></button>
      <a href="index.php?do=plugins&amp;action=config&amp;plugname=slider" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processConfig" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $("input[name=sliderHeight]").ionRangeSlider({
		min: 200,
		max: 1000,
        step: 50,
		postfix: " px",
        type: 'single',
        hasGrid: true
    });
	
    $("input[name=slideTransitionSpeed]").ionRangeSlider({
		min: 500,
		max: 5000,
        step: 500,
		postfix: " ms",
        type: 'single',
        hasGrid: true
    });

    $("input[name=slideTransitionDelay]").ionRangeSlider({
		min: 2500,
		max: 10000,
        step: 500,
		postfix: " ms",
        type: 'single',
        hasGrid: true
    });
});
// ]]>
</script>
<?php break;?>
<?php default: ?>
<?php $sliderows = Registry::get("Slider")->getSlides();?>
<div class="tubi icon heading message orange"> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PLG_SL_TITLE;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getPluginName(Filter::$plugname);?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PLG_SL_INFO3;?></div>
  <div class="tubi segment">
    <div class="tubi buttons push-right"><a href="index.php?do=plugins&amp;action=config&amp;plugname=slider&amp;paction=add" class="tubi info button"><i class="icon add"></i><?php echo Lang::$word->_PLG_SL_ADDSLIDE;?></a> <a href="index.php?do=plugins&amp;action=config&amp;plugname=slider&amp;paction=config" class="tubi warning button"><i class="icon setting"></i><?php echo Lang::$word->_PLG_SL_CONF;?></a></div>
    <div class="tubi header"><?php echo Lang::$word->_PLG_SL_SUBTITLE3;?></div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th class="disabled"></th>
          <th data-sort="string"><?php echo Lang::$word->_PLG_SL_CAPTION;?></th>
          <th data-sort="int"><?php echo Lang::$word->_PLG_SL_POS;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$sliderows):?>
        <tr>
          <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_PLG_SL_NOIMG);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($sliderows as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="id-handle"><i class="icon reorder"></i></td>
          <td><?php echo $row->{'title'.Lang::$lang};?></td>
          <td><span class="tubi black label"><?php echo $row->position;?></span></td>
          <td><a href="index.php?do=plugins&amp;action=config&amp;plugname=slider&amp;paction=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_PLG_SL_SLIDE;?>" data-option="deleteSlide" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title'.Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($slrow);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $(".tubi.table tbody").sortable({
        helper: 'clone',
        handle: '.id-handle',
        placeholder: 'placeholder',
        opacity: .6,
        update: function (event, ui) {
            serialized = $(".tubi.table tbody").sortable('serialize');
            $.ajax({
                type: "POST",
                url: "plugins/slider/controller.php?sortslides",
                data: serialized,
                success: function (msg) {}
            });
        }
    });
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>
