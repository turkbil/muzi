<?php
/**
 * Portfolio
 *
 * @yazilim Tubi Portal
 * @web adresi turkbilisim.com.tr
 * @copyright 2014
 * @version $Id: admin.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
 */
if ( !defined( "_VALID_PHP" ) )
  die( 'Direct access to this location is not allowed.' );

if ( !$user->getAcl( "portfolio" ) ): print $core->msgAlert( _CG_ONLYADMIN, false );
return;
endif;

Registry::set( 'Portfolio', new Portfolio() );
?>
<?php switch(Filter::$maction): case "edit": ?>
<?php $row = Core::getRowById(Portfolio::mTable, Filter::$id);?>
<?php $catrow = Registry::get("Portfolio")->getCategories();?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="portfolio"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_PF_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_PF_SUBTITLE1 . $row->{'title'.Lang::$lang};?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_SLUG;?></label>
          <label class="input">
            <input type="text" value="<?php echo $row->slug;?>" name="slug">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_CATEGORY;?></label>
          <select name="cid">
            <option value=""><?php echo Lang::$word->_MOD_PF_CATEGORY_SEL;?></option>
            <?php if($catrow):?>
            <?php foreach($catrow as $crow):?>
            <?php $sel = ($crow->id == $row->cid) ? ' selected="selected"' : '' ;?>
            <option value="<?php echo $crow->id;?>"<?php echo $sel;?>><?php echo $crow->{'title'.LANG::$lang};?></option>
            <?php endforeach;?>
            <?php unset($crow);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <?php $module_data = $row->gallery;?>
          <?php include(BASEPATH . "admin/modules/gallery/config.php");?>
        </div>
      </div>
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_PIMAGE;?></label>
          <label class="input">
            <input type="file" name="thumb" class="filefield">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_PIMAGEPP;?></label>
          <div class="tubi small image"> <a class="lightbox" href="<?php echo SITEURL . '/' . Portfolio::imagepath . $row->thumb;?>"><img src="<?php echo SITEURL . '/' . Portfolio::imagepath . $row->thumb;?>" alt="<?php echo $row->thumb;?>"></a> </div>
        </div>
        <div class="field">
          <label>Fontawesome</label>
          <label class="input">
            <input type="text" value="<?php echo $row->icon;?>" name="icon">
          </label>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_PF_PAPPROACH;?></label>
        <textarea id="plugpost2" class="plugpost" name="body<?php echo LANG::$lang;?>"><?php echo Filter::out_url($row->{'body'.Lang::$lang});?></textarea>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_METAKEYS;?></label>
          <textarea name="metakey<?php echo Lang::$lang;?>"><?php echo $row->{'metakey'.Lang::$lang};?></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_METADESC;?></label>
          <textarea name="metadesc<?php echo Lang::$lang;?>"><?php echo $row->{'metadesc'.Lang::$lang};?></textarea>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_PF_UPDATE;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processFolio" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<?php $catrow = Registry::get("Portfolio")->getCategories();?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="portfolio"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_PF_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_PF_SUBTITLE2;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_PF_NAME;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_SLUG;?></label>
          <label class="input">
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_PF_SLUG;?>" name="slug">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_CATEGORY;?></label>
          <select name="cid">
            <option value=""><?php echo Lang::$word->_MOD_PF_CATEGORY_SEL;?></option>
            <?php if($catrow):?>
            <?php foreach($catrow as $crow):?>
            <option value="<?php echo $crow->id;?>"><?php echo $crow->{'title'.LANG::$lang};?></option>
            <?php endforeach;?>
            <?php unset($crow);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <?php $module_data = 0;?>
          <?php include(BASEPATH . "admin/modules/gallery/config.php");?>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_PIMAGE;?></label>
          <label class="input">
            <input type="file" name="thumb" class="filefield">
          </label>
        </div>
        <div class="field">
          <label>Fontawesome</label>
          <label class="input">
            <input type="text" placeholder="Fontawesome" name="icon">
          </label>
        </div>
      </div>
      <div class="field">
        <label>Açıklama</label>
        <textarea id="plugpost2" placeholder="<?php echo Lang::$word->_MOD_PF_PAPPROACH;?>" class="plugpost" name="body<?php echo LANG::$lang;?>"></textarea>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_METAKEYS;?></label>
          <textarea placeholder="<?php echo Lang::$word->_METAKEYS;?>" name="metakey<?php echo Lang::$lang;?>"></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_METADESC;?></label>
          <textarea placeholder="<?php echo Lang::$word->_METADESC;?>" name="metadesc<?php echo Lang::$lang;?>"></textarea>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_PF_ADD;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processFolio" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"config": ?>
<?php $row = Registry::get("Portfolio");?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="pfconfig"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_PF_TITLE3;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO3. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_PF_SUBTITLE8;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="three fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_COLS;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->cols;?>" name="cols">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_ITEMPP;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->ipp;?>" name="ipp">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_ITEMPPF;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->fpp;?>" name="fpp">
          </label>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_PF_UPDATEC;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processConfig" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $("input[name=cols]").ionRangeSlider({
		min: 2,
		max: 6,
        step: 1,
		postfix: " col",
        type: 'single',
        hasGrid: true
    });
	
    $("input[name=ipp], input[name=fpp]").ionRangeSlider({
		min: 5,
		max: 20,
        step: 1,
		postfix: " itm",
        type: 'single',
        hasGrid: true
    });
});
// ]]>
</script>
<?php break;?>
<?php case"category": ?>
<?php $catrow = Registry::get("Portfolio")->getCategories();?>
<div class="tubi icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_PF_TITLE5;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO5;?></div>
  <div class="tubi segment"> <a class="tubi icon warning button push-right" href="<?php echo Core::url("modules", "catadd");?>"><i class="icon add"></i> <?php echo Lang::$word->_MOD_PF_CADD;?></a>
    <div class="tubi header"><?php echo Lang::$word->_MOD_PF_SUBTITLE5;?></div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th class="disabled"></th>
          <th class="left"><?php echo Lang::$word->_MOD_PF_CATNAME;?></th>
          <th><?php echo Lang::$word->_MOD_PF_POS;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$catrow):?>
        <tr>
          <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_PF_NOCATS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($catrow as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="id-handle"><i class="icon reorder"></i></td>
          <td data-sort="string"><?php echo $row->{'title'.Lang::$lang};?></td>
          <td data-sort="int"><span class="tubi black label"><?php echo $row->position;?></span></td>
          <td><a href="<?php echo Core::url("modules", "catedit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_PF_CATEGORY;?>" data-option="deleteCategory" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title'.Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
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
                url: "modules/portfolio/controller.php?sortcats",
                data: serialized,
                success: function (msg) {}
            });
        }
    });
});
// ]]>
</script>
<?php break;?>
<?php case"catedit": ?>
<?php $row = Core::getRowById(Portfolio::cTable, Filter::$id);?>
<div class="tubi icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <a href="<?php echo Core::url("modules", "category");?>" class="section"><?php echo Lang::$word->_MOD_PF_TITLE5;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_PF_TITLE6;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO6. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_PF_SUBTITLE6 . $row->{'title'.Lang::$lang};?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_CATNAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_CATSLUG;?></label>
          <input type="text" value="<?php echo $row->slug;?>" name="slug">
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_METAKEYS;?></label>
          <textarea name="metakey<?php echo Lang::$lang;?>"><?php echo $row->{'metakey'.Lang::$lang};?></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_METADESC;?></label>
          <textarea name="metadesc<?php echo Lang::$lang;?>"><?php echo $row->{'metadesc'.Lang::$lang};?></textarea>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_PF_CAUPDATE;?></button>
      <a href="<?php echo Core::url("modules", "category");?>" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processCategory" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"catadd": ?>
<div class="tubi icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=portfolio" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <a href="<?php echo Core::url("modules", "category");?>" class="section"><?php echo Lang::$word->_MOD_PF_TITLE5;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_PF_TITLE7;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO7. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_PF_SUBTITLE7;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_CATNAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_PF_CATNAME;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_PF_CATSLUG;?></label>
          <input type="text" placeholder="<?php echo Lang::$word->_MOD_PF_CATSLUG;?>" name="slug">
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_METAKEYS;?></label>
          <textarea placeholder="<?php echo Lang::$word->_METAKEYS;?>" name="metakey<?php echo Lang::$lang;?>"></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_METADESC;?></label>
          <textarea placeholder="<?php echo Lang::$word->_METADESC;?>" name="metadesc<?php echo Lang::$lang;?>"></textarea>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_PF_CADD;?></button>
      <a href="<?php echo Core::url("modules", "category");?>" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processCategory" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php default: ?>
<?php $portrow = Registry::get("Portfolio")->getPortfolio();?>
<?php $catrow = Registry::get("Portfolio")->getCategories();?>
<div class="tubi icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_PF_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getModuleName(Filter::$modname);?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_PF_INFO4;?></div>
  <div class="tubi segment">
    <div class="push-right">
      <div class="tubi right pointing dropdown icon info button"> <i class="settings icon"></i>
        <div class="menu"> <a class="item" href="<?php echo Core::url("modules", "add");?>"><i class="icon add"></i><?php echo Lang::$word->_MOD_PF_SUBTITLE4;?></a> <a class="item" href="<?php echo Core::url("modules", "category");?>"><i class="icon add"></i><?php echo Lang::$word->_MOD_PF_CATEGORIES;?></a> <a class="item" href="<?php echo Core::url("modules", "config");?>"><i class="icon setting"></i><?php echo Lang::$word->_MOD_PF_CONFIGURE;?></a> </div>
      </div>
    </div>
    <div class="tubi header"><?php echo Lang::$word->_MOD_PF_SUBTITLE3;?></div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th class="disabled"></th>
          <th class="disabled"><i class="icon photo"></i></th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_PF_NAME;?></th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_PF_CATEGORY;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$portrow):?>
        <tr>
          <td colspan="6"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_PF_NOPROJECTS);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($portrow as $row):?>
        <tr>
        <tr id="node-<?php echo $row->id;?>">
          <td class="id-handle"><i class="icon reorder"></i></td>
          <td><a class="lightbox" href="<?php echo SITEURL . '/' . Portfolio::imagepath . $row->thumb;?>" title="<?php echo $row->{'title'.LANG::$lang};?>"> <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/' . Portfolio::imagepath . $row->thumb;?>&amp;w=120&amp;h=60" alt="" class="tubi image"></a></td>
          <td><?php echo $row->{'title'.LANG::$lang};?></td>
          <td><a class="item" href="<?php echo Core::url("modules", "catedit", $row->cid);?>"><?php echo $row->catname;?></a></td>
          <td><a href="<?php echo Core::url("modules", "edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_PF_PROJECT;?>" data-option="deleteProject" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
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
                url: "modules/portfolio/controller.php?sortproducts",
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
