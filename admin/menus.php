<?php
  /**
   * Menus
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: menus.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Menus")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::mTable, Filter::$id);?>
<div class="tubi icon heading message sky"><a class="helper tubi top right info corner label" data-help="menu"><i class="icon help"></i></a> <i class="reorder icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MU_TITLE2;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=menus" class="section"><?php echo Lang::$word->_N_MENUS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MU_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MU_INFO1;?></div>
  <div id="msgalt"></div>
  <div class="tubi-grid">
    <div class="columns small-gutters">
      <div class="screen-60 tablet-50 phone-100">
        <div class="tubi segment">
          <div class="tubi header"><?php echo Lang::$word->_MU_SUBTITLE1 . $row->{'name'.Lang::$lang};?></div>
          <div class="tubi fitted divider"></div>
          <div class="tubi form">
            <form id="tubi_form" name="tubi_form" method="post">
              <div class="field">
                <label><?php echo Lang::$word->_MU_NAME;?></label>
                <label class="input"> <i class="icon-append icon asterisk"></i>
                  <input type="text" name="name<?php echo Lang::$lang;?>" value="<?php echo $row->{'name'.Lang::$lang};?>">
                </label>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MU_CAPTION;?></label>
                <label class="input">
                  <input type="text" name="caption<?php echo Lang::$lang;?>" value="<?php echo $row->{'caption'.Lang::$lang};?>">
                </label>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MU_PARENT;?></label>
                <select name="parent_id">
                  <option value="0"><?php echo Lang::$word->_MU_TOP;?></option>
                  <?php $content->getMenuDropList(0, 0,"&#166;&nbsp;&nbsp;&nbsp;&nbsp;", $row->parent_id);?>
                </select>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MU_TYPE;?></label>
                <select name="content_type" id="contenttype">
                  <option value=""><?php echo Lang::$word->_MU_TYPE_SEL;?></option>
                  <?php echo Content::getContentType($row->content_type);?>
                </select>
              </div>
              <div class="field" id="contentid" style="display:<?php echo ($row->content_type != "web") ? 'block' : 'none';?>">
                <label><?php echo Lang::$word->_MU_LINK;?></label>
                <select name="<?php echo ($row->content_type == "page") ? "page_id" : "mod_id";?>" id="page_id">
                  <?php if($row->content_type == "module"):?>
                  <?php $modlist = $content->displayMenuModule();?>
                  <?php if($modlist):?>
                  <?php foreach($modlist as $mrow):?>
                  <?php $sel = ($mrow->id == $row->mod_id) ? " selected=\"selected\"" : "" ?>
                  <option value="<?php echo $mrow->id;?>"<?php echo $sel;?>><?php echo $mrow->{'title'.Lang::$lang};?></option>
                  <?php endforeach;?>
                  <?php unset($mrow);?>
                  <?php endif;?>
                  <?php endif;?>
                  <?php if($row->content_type == "page"):?>
                  <?php $clist = $content->getPages();?>
                  <?php foreach($clist as $crow):?>
                  <?php $sel = ($crow->id == $row->page_id) ? " selected=\"selected\"" : "" ?>
                  <option value="<?php echo $crow->id;?>"<?php echo $sel;?>><?php echo $crow->{'title'.Lang::$lang};?></option>
                  <?php endforeach;?>
                  <?php endif;?>
                </select>
              </div>
              <div id="webid" style="display:<?php echo ($row->content_type == "web") ? 'block' : 'none';?>">
                <div class="field">
                  <label><?php echo Lang::$word->_MU_LINK;?></label>
                  <label class="input">
                    <input type="text" name="web" value="<?php echo $row->link;?>" placeholder="<?php echo Lang::$word->_MU_LINK;?>">
                  </label>
                </div>
                <div class="field">
                  <label><?php echo Lang::$word->_MU_TARGET_L;?></label>
                  <select name="target" class="selectbox">
                    <option value=""><?php echo Lang::$word->_MU_TARGET;?></option>
                    <option value="blank"<?php if ($row->target == "_blank") echo ' selected="selected"';?>><?php echo Lang::$word->_MU_TARGET_B;?></option>
                    <option value="self"<?php if ($row->target == "_self") echo ' selected="selected"';?>><?php echo Lang::$word->_MU_TARGET_S;?></option>
                  </select>
                </div>
              </div>
              <?php if($row->parent_id == 0):?>
              <div class="field">
                <label><?php echo Lang::$word->_MU_COLS;?></label>
                <input class="slrange" type="text" name="cols" value="<?php echo $row->cols;?>">
              </div>
              <?php endif;?>
              <div class="field">
                <label><?php echo Lang::$word->_MU_ICON;?></label>
                <div class="scrollbox">
                  <div id="scroll-icons"> <?php print Core::iconList($row->icon);?> </div>
                  <input name="icon" type="hidden" value="<?php echo $row->icon;?>">
                </div>
              </div>
              <div class="tubi fitted divider"></div>
              <div class="two fields">
                <div class="field">
                  <label><?php echo Lang::$word->_MU_HOME;?></label>
                  <div class="inline-group">
                    <label class="radio">
                      <input name="home_page" type="radio" value="1" <?php getChecked($row->home_page, 1); ?>>
                      <i></i><?php echo Lang::$word->_YES;?></label>
                    <label class="radio">
                      <input name="home_page" type="radio" value="0" <?php getChecked($row->home_page, 0); ?>>
                      <i></i> <?php echo Lang::$word->_NO;?> </label>
                  </div>
                </div>
                <div class="field">
                  <div class="inline-group">
                    <label><?php echo Lang::$word->_MU_PUB;?></label>
                    <label class="radio">
                      <input name="active" type="radio" value="1" <?php getChecked($row->active, 1); ?>>
                      <i></i><?php echo Lang::$word->_YES;?></label>
                    <label class="radio">
                      <input name="active" type="radio"  value="0" <?php getChecked($row->active, 0); ?>>
                      <i></i> <?php echo Lang::$word->_NO;?> </label>
                  </div>
                </div>
              </div>
              <div class="tubi double fitted divider"></div>
              <button name="domenu" type="button" class="tubi positive button"><?php echo Lang::$word->_MU_UPDATE;?></button>
              <a href="index.php?do=menus" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
              <input name="processMenu" type="hidden" value="1">
              <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
            </form>
          </div>
        </div>
        <div id="msgholder"></div>
      </div>
      <div class="screen-40 tablet-50 phone-100">
        <div class="tubi block header">
          <h4><?php echo Lang::$word->_MU_MENUS;?></h4>
        </div>
        <div id="menusort"> <?php echo $content->getSortMenuList();?></div>
        <div class="sholder push-right"><a id="serialize" class="tubi positive right labeled icon button"><i class="icon ok sign"></i><?php echo Lang::$word->_MU_SAVE;?></a></div>
      </div>
    </div>
  </div>
</div>
<?php break;?>
<?php default: ?>
<div class="tubi icon heading message sky"><a class="helper tubi top right info corner label" data-help="menu"><i class="icon help"></i></a> <i class="icon reorder"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MU_TITLE2;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_MENUS;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MU_INFO2;?></div>
  <div id="msgalt"></div>
  <div class="tubi-grid">
    <div class="columns small-gutters">
      <div class="screen-60 tablet-50 phone-100">
        <div class="tubi segment">
          <div class="tubi header"><?php echo Lang::$word->_MU_SUBTITLE2;?></div>
          <div class="tubi fitted divider"></div>
          <div class="tubi form">
            <form id="tubi_form" name="tubi_form" method="post">
              <div class="field">
                <label><?php echo Lang::$word->_MU_NAME;?></label>
                <label class="input"> <i class="icon-append icon asterisk"></i>
                  <input type="text" name="name<?php echo Lang::$lang;?>" placeholder="<?php echo Lang::$word->_MU_NAME;?>">
                </label>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MU_CAPTION;?></label>
                <label class="input">
                  <input type="text" name="caption<?php echo Lang::$lang;?>" placeholder="<?php echo Lang::$word->_MU_CAPTION;?>">
                </label>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MU_PARENT;?></label>
                <select name="parent_id">
                  <option value="0"><?php echo Lang::$word->_MU_TOP;?></option>
                  <?php $content->getMenuDropList(0, 0,"&#166;&nbsp;&nbsp;&nbsp;&nbsp;");?>
                </select>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MU_TYPE;?></label>
                <select name="content_type" id="contenttype">
                  <option value=""><?php echo Lang::$word->_MU_TYPE_SEL;?></option>
                  <?php echo Content::getContentType();?>
                </select>
              </div>
              <div class="field" id="contentid">
                <label><?php echo Lang::$word->_MU_LINK;?></label>
                <select name="page_id" id="page_id">
                  <option value="0"><?php echo Lang::$word->_MU_NONE;?></option>
                </select>
              </div>
              <div id="webid" style="display:none">
                <div class="field">
                  <label><?php echo Lang::$word->_MU_LINK;?></label>
                  <label class="input">
                    <input type="text" name="web" placeholder="<?php echo Lang::$word->_MU_LINK;?>">
                  </label>
                </div>
                <div class="field">
                  <label><?php echo Lang::$word->_MU_TARGET_L;?></label>
                  <select name="target" class="selectbox">
                    <option value=""><?php echo Lang::$word->_MU_TARGET;?></option>
                    <option value="_blank"><?php echo Lang::$word->_MU_TARGET_B;?></option>
                    <option value="_self"><?php echo Lang::$word->_MU_TARGET_S;?></option>
                  </select>
                </div>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MU_ICON;?></label>
                <div class="scrollbox">
                  <div id="scroll-icons"> <?php print Core::iconList();?> </div>
                  <input name="icon" type="hidden" value="">
                </div>
              </div>
              <div class="tubi fitted divider"></div>
              <div class="two fields">
                <div class="field">
                  <label><?php echo Lang::$word->_MU_HOME;?></label>
                  <div class="inline-group">
                    <label class="radio">
                      <input name="home_page" type="radio" value="1">
                      <i></i><?php echo Lang::$word->_YES;?></label>
                    <label class="radio">
                      <input name="home_page" type="radio" value="0" checked="checked">
                      <i></i> <?php echo Lang::$word->_NO;?> </label>
                  </div>
                </div>
                <div class="field">
                  <div class="inline-group">
                    <label><?php echo Lang::$word->_MU_PUB;?></label>
                    <label class="radio">
                      <input name="active" type="radio" value="1" checked="checked">
                      <i></i><?php echo Lang::$word->_YES;?></label>
                    <label class="radio">
                      <input name="active" type="radio"  value="0">
                      <i></i> <?php echo Lang::$word->_NO;?> </label>
                  </div>
                </div>
              </div>
              <div class="tubi double fitted divider"></div>
              <button name="domenu" type="button" class="tubi positive button"><?php echo Lang::$word->_MU_ADD;?></button>
              <input name="processMenu" type="hidden" value="1">
            </form>
          </div>
        </div>
        <div id="msgholder"></div>
      </div>
      <div class="screen-40 tablet-50 phone-100">
        <div class="tubi block header">
          <h4><?php echo Lang::$word->_MU_MENUS;?></h4>
        </div>
        <div id="menusort"> <?php echo $content->getSortMenuList();?></div>
        <div class="sholder push-right"><a id="serialize" class="tubi positive right labeled icon button"><i class="icon ok sign"></i><?php echo Lang::$word->_MU_SAVE;?></a></div>
      </div>
    </div>
  </div>
</div>
<?php break;?>
<?php endswitch;?>
<script src="assets/js/jquery.tree.js"></script> 