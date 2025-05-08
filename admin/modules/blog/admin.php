<?php
  /**
   * Article Manager
   *
   * @yazilim TUBI Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: admin.php, v4.00 2014-03-23 10:12:05 Nurullah Okatan 
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  if(!$user->getAcl("blog")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  Registry::set('Blog', new Blog());
?>
<?php switch(Filter::$maction): case "edit": ?>
<?php $row = Core::getRowById(Blog::mTable, Filter::$id);?>
<?php $cidrow = Registry::get("Blog")->fetchArticleCategories(Filter::$id);?>

<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="blog"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_AM_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=blog" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_AM_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_AM_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_AM_SUBTITLE1 . $row->{'title'.Lang::$lang};?></div>
    <ul class="idTabs" id="tabs">
      <li><a data-tab="#ana"><?php echo Lang::$word->_TEMEL;?></a></li>
      <li><a data-tab="#ek"><?php echo Lang::$word->_YARD;?></a></li>
    </ul>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div id="ana" class="tab_content">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_NAME;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
            </label>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_CATEGORY;?></label>
            <div class="scrollbox padded">
              <?php Registry::get("Blog")->getCatCheckList(0, 0,"|&nbsp;&nbsp;&nbsp;&nbsp;", $cidrow);?>
            </div>
          </div>
          <div class="field">
            <div class="two fields">
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_IMAGE;?></label>
                <label class="input">
                  <input type="file" id="thumb" name="thumb" class="filefield">
                </label>
              </div>
              <div class="field">
                <div class="small-top-space">
                  <div class="tubi normal image"> <a class="lightbox" href="<?php echo SITEURL . '/' . Blog::imagepath . $row->thumb;?>"><img src="<?php echo SITEURL . '/' . Blog::imagepath . $row->thumb;?>" alt="<?php echo $row->thumb;?>"></a> </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_MOD_AM_SHORTDESC;?></label>
              <label class="textarea"><i class="icon-append icon asterisk"></i>
                <textarea name="short_desc<?php echo Lang::$lang;?>"><?php echo $row->{'short_desc'.Lang::$lang};?></textarea>
              </label>
            </div>
          </div>
        </div>
        <div class="two fields"> </div>
        <div class="tubi fitted divider"></div>
        <div class="two fields"> </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_FULLDESC;?></label>
          <textarea id="plugpost" class="plugpost" name="body<?php echo LANG::$lang;?>"><?php echo Filter::out_url($row->{'body'.Lang::$lang});?></textarea>
        </div>
        <div class="two fields">
          <div class="field">
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
          </div>
          <div class="field">
            <div class="field">
              <label><?php echo Lang::$word->_MOD_AM_TAGS;?></label>
              <label class="input"><i class="icon-append icon asterisk"></i> <i class="icon-prepend icon tags"></i>
                <input name="tags" type="text" value="<?php echo Registry::get("Blog")->getArticleTags($row->{'tags' . Lang::$lang});?>">
              </label>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_MOD_AM_LAYOUT;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="layout" type="radio" value="1" <?php echo getChecked($row->layout, 1);?>>
                  <i></i><img src="modules/blog/images/layout-left.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT1;?>"></label>
                <label class="radio">
                  <input name="layout" type="radio" value="2" <?php echo getChecked($row->layout, 2);?>>
                  <i></i><img src="modules/blog/images/layout-right.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT2;?>"></label>
                <label class="radio">
                  <input name="layout" type="radio" value="3" <?php echo getChecked($row->layout, 3);?>>
                  <i></i><img src="modules/blog/images/layout-full-top.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT3;?>"></label>
                <label class="radio">
                  <input name="layout" type="radio" value="4" <?php echo getChecked($row->layout, 4);?>>
                  <i></i><img src="modules/blog/images/layout-full-bottom.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT4;?>"></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="ek" class="tab_content">
        <div class="three fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SLUG;?></label>
            <label class="input">
              <input type="text" value="<?php echo $row->slug;?>" name="slug">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_MODIFIED;?></label>
            <input name="modified" type="text" disabled="disabled" value="<?php echo $row->modified;?>">
            <div class="small-top-space">
              <div class="field">
                <?php if($row->is_user):?>
                <div class="field error">
                  <label><?php echo Lang::$word->_MOD_AM_APPROVE;?></label>
                  <div class="inline-group">
                    <label class="radio">
                      <input name="is_user" type="radio" value="1" <?php echo getChecked($row->is_user, 1);?>>
                      <i></i><?php echo Lang::$word->_YES;?></label>
                    <label class="radio">
                      <input name="is_user" type="radio" value="0" <?php echo getChecked($row->is_user, 0);?>>
                      <i></i><?php echo Lang::$word->_NO;?></label>
                  </div>
                </div>
                <?php endif;?>
              </div>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_PUBLISHED;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="active" type="radio" value="1" <?php echo getChecked($row->active, 1);?>>
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="active" type="radio" value="0" <?php echo getChecked($row->active, 0);?>>
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_MEMBERSHIP;?></label>
            <?php echo $member->getMembershipList($row->membership_id);?> </div>
          <div class="field">
            <?php $module_data = $row->gallery;?>
            <?php include(BASEPATH . "admin/modules/gallery/config.php");?>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_IMAGE_C;?></label>
            <label class="input">
              <input type="text" value="<?php echo $row->{'caption'.Lang::$lang};?>" name="caption<?php echo Lang::$lang;?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_FILE_ATT;?></label>
            <label class="input">
              <input type="file" id="file" name="filename" class="filefield">
            </label>
          </div>
          <div class="field">
            <?php if($row->filename):?>
            <label><?php echo Lang::$word->_MOD_AM_FILE_ATTR;?></label>
            <div class="inline-group">
              <label class="checkbox">
                <input name="remfile" type="checkbox" value="1">
                <i></i><?php echo Lang::$word->_YES;?></label>
              <i class="icon download disk"></i> <a href="<?php echo SITEURL . '/' . Blog::filepath . $row->filename;?>"><?php echo Lang::$word->_MOD_AM_FILE_ATTD;?></a></div>
            <?php endif;?>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="four fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_START;?></label>
            <?php $created = explode(" ",$row->created);?>
            <label class="input"><i class="icon-append icon calendar"></i>
              <input data-datepicker="true" data-value="<?php echo $row->created;?>" name="created" type="text" value="<?php echo $created[0];?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_STARTT;?></label>
            <label class="input"><i class="icon-append icon time"></i>
              <input data-timepicker="true" name="timeStart" type="text" value="<?php echo $created[1];?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_END;?></label>
            <?php $expire = explode(" ",$row->expire);?>
            <label class="input"><i class="icon-append icon calendar"></i>
              <input data-datepicker="true" data-value="<?php echo $row->expire == 0 ? null : $row->expire;?>" name="expire" type="text" value="<?php echo $expire[0];?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_ENDT;?></label>
            <label class="input"><i class="icon-append icon time"></i>
              <input data-timepicker="true" name="timeEnd" type="text" value="<?php echo $expire[1];?>">
            </label>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="three fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SHOW_D;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_created" type="radio" value="1" <?php echo getChecked($row->show_created, 1);?>>
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_created" type="radio" value="0" <?php echo getChecked($row->show_created, 0);?>>
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SHOW_A;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_author" type="radio" value="1" <?php echo getChecked($row->show_author, 1);?>>
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_author" type="radio" value="0" <?php echo getChecked($row->show_author, 0);?>>
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SHOW_R;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_ratings" type="radio" value="1" <?php echo getChecked($row->show_ratings, 1);?>>
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_ratings" type="radio" value="0" <?php echo getChecked($row->show_ratings, 0);?>>
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
        <div class="three fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SHOW_C;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_comments" type="radio" value="1" <?php echo getChecked($row->show_comments, 1);?>>
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_comments" type="radio" value="0" <?php echo getChecked($row->show_comments, 0);?>>
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SHOW_L;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_like" type="radio" value="1" <?php echo getChecked($row->show_like, 1);?>>
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_like" type="radio" value="0" <?php echo getChecked($row->show_like, 0);?>>
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SHOW_S;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_sharing" type="radio" value="1" <?php echo getChecked($row->show_sharing, 1);?>>
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_sharing" type="radio" value="0" <?php echo getChecked($row->show_sharing, 0);?>>
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_AM_UPDATE;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=blog" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processArticle" type="hidden" value="1">
      <input name="uid" type="hidden" value="<?php echo $row->uid;?>">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="blog"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_AM_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=blog" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_AM_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_AM_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_AM_SUBTITLE2;?></div>
    <ul class="idTabs" id="tabs">
      <li><a data-tab="#ana"><?php echo Lang::$word->_TEMEL;?></a></li>
      <li><a data-tab="#ek"><?php echo Lang::$word->_YARD;?></a></li>
    </ul>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div id="ana" class="tab_content">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_NAME;?></label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="<?php echo Lang::$word->_MOD_AM_NAME;?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_CATEGORY;?></label>
            <div class="scrollbox padded">
              <?php Registry::get("Blog")->getCatCheckList(0, 0,"|&nbsp;&nbsp;&nbsp;&nbsp;");?>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_IMAGE;?></label>
            <label class="input">
              <input type="file" id="thumb" name="thumb" class="filefield">
            </label>
            <div class="field">
              <label><?php echo Lang::$word->_MOD_AM_SHORTDESC;?></label>
              <label class="textarea"><i class="icon-append icon asterisk"></i>
                <textarea placeholder="<?php echo Lang::$word->_MOD_AM_SHORTDESC;?>" name="short_desc<?php echo Lang::$lang;?>"></textarea>
              </label>
            </div>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="two fields"> </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_FULLDESC;?></label>
          <textarea id="plugpost" class="plugpost" placeholder="<?php echo Lang::$word->_MOD_AM_FULLDESC;?>" name="body<?php echo LANG::$lang;?>"></textarea>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="two fields">
          <div class="field">
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
          </div>
          <div class="field">
            <div class="field">
              <label><?php echo Lang::$word->_MOD_AM_TAGS;?></label>
              <label class="input"><i class="icon-append icon asterisk"></i> <i class="icon-prepend icon tags"></i>
                <input name="tags" type="text" placeholder="<?php echo Lang::$word->_MOD_AM_TAGS;?>">
              </label>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_MOD_AM_LAYOUT;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="layout" type="radio" value="1" checked="checked">
                  <i></i><img src="modules/blog/images/layout-left.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT1;?>"></label>
                <label class="radio">
                  <input name="layout" type="radio" value="2">
                  <i></i><img src="modules/blog/images/layout-right.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT2;?>"></label>
                <label class="radio">
                  <input name="layout" type="radio" value="3">
                  <i></i><img src="modules/blog/images/layout-full-top.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT3;?>"></label>
                <label class="radio">
                  <input name="layout" type="radio" value="4">
                  <i></i><img src="modules/blog/images/layout-full-bottom.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT4;?>"></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="ek" class="tab_content">
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SLUG;?></label>
            <label class="input">
              <input type="text" placeholder="<?php echo Lang::$word->_MOD_AM_SLUG;?>" name="slug">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_PUBLISHED;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="active" type="radio" value="1" checked="checked">
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="active" type="radio" value="0">
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_MEMBERSHIP;?></label>
            <?php echo $member->getMembershipList();?> </div>
          <div class="field">
            <?php $module_data = 0;?>
            <?php include(BASEPATH . "admin/modules/gallery/config.php");?>
          </div>
        </div>
        <div class="two fields">
          <div class="field small-top-space">
            <label><?php echo Lang::$word->_MOD_AM_IMAGE_C;?></label>
            <label class="input">
              <input type="text" placeholder="<?php echo Lang::$word->_MOD_AM_IMAGE_C;?>" name="caption<?php echo Lang::$lang;?>">
            </label>
          </div>
          <div class="field small-top-space">
            <label><?php echo Lang::$word->_MOD_AM_FILE_ATT;?></label>
            <label class="input">
              <input type="file" id="file" name="filename" class="filefield">
            </label>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="four fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_START;?></label>
            <label class="input"><i class="icon-append icon calendar"></i>
              <input data-datepicker="true" data-value="<?php echo date('Y-m-d');?>" name="created" type="text" value="<?php echo date('Y-m-d');?>">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_STARTT;?></label>
            <label class="input"><i class="icon-append icon time"></i>
              <input data-value="<?php echo date('H:i:s');?>" data-timepicker="true" name="timeStart" type="text">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_END;?></label>
            <label class="input"><i class="icon-append icon calendar"></i>
              <input data-datepicker="true" name="expire" value="0000-00-00" type="text">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_ENDT;?></label>
            <label class="input"><i class="icon-append icon time"></i>
              <input data-timepicker="true" name="timeEnd" value="00:00:00" type="text">
            </label>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="three fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SHOW_D;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_created" type="radio" value="1" checked="checked">
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_created" type="radio" value="0">
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SHOW_A;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_author" type="radio" value="1" checked="checked">
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_author" type="radio" value="0">
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SHOW_R;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_ratings" type="radio" value="1" checked="checked">
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_ratings" type="radio" value="0">
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
        <div class="three fields">
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SHOW_C;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_comments" type="radio" value="1" checked="checked">
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_comments" type="radio" value="0">
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SHOW_L;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_like" type="radio" value="1" checked="checked">
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_like" type="radio" value="0">
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_MOD_AM_SHOW_S;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_sharing" type="radio" value="1" checked="checked">
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_sharing" type="radio" value="0">
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_AM_ADD;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=blog" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processArticle" type="hidden" value="1">
      <input name="uid" type="hidden" value="<?php echo $user->uid;?>">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"config": ?>
<?php $row = Registry::get("Blog");?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="amconfig"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_AM_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=blog" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_AM_TITLE3;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_AM_INFO3. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_AM_SUBTITLE9;?></div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_LATEST;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->fperpage;?>" name="fperpage">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_BOX_LATPP;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->latestperpage;?>" name="latestperpage">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_BOX_POPPP;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->popperpage;?>" name="popperpage">
          </label>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_BOX_COMPP;?></label>
          <label class="input">
            <input type="text" class="slrange" value="<?php echo $row->comperpage;?>" name="comperpage">
          </label>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_COUNTER;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="show_counter" type="radio" value="1" <?php echo getChecked($row->show_counter, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="show_counter" type="radio" value="0" <?php echo getChecked($row->show_counter, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_UNAME_R;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="username_req" type="radio" value="1" <?php echo getChecked($row->username_req, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="username_req" type="radio" value="0" <?php echo getChecked($row->username_req, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_CAPTCHA;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="show_captcha" type="radio" value="1" <?php echo getChecked($row->show_captcha, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="show_captcha" type="radio" value="0" <?php echo getChecked($row->show_captcha, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_WWW;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="show_www" type="radio" value="1" <?php echo getChecked($row->show_www, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="show_www" type="radio" value="0" <?php echo getChecked($row->show_www, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="four fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_UNAME_S;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="show_username" type="radio" value="1" <?php echo getChecked($row->show_username, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="show_username" type="radio" value="0" <?php echo getChecked($row->show_username, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_UPOST;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="upost" type="radio" value="1" <?php echo getChecked($row->upost, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="upost" type="radio" value="0" <?php echo getChecked($row->upost, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_REG_ONLY;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="public_access" type="radio" value="1" <?php echo getChecked($row->public_access, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="public_access" type="radio" value="0" <?php echo getChecked($row->public_access, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_EMAIL_R;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="email_req" type="radio" value="1" <?php echo getChecked($row->email_req, 1);?>>
              <i></i><?php echo Lang::$word->_YES;?></label>
            <label class="radio">
              <input name="email_req" type="radio" value="0" <?php echo getChecked($row->email_req, 0);?>>
              <i></i><?php echo Lang::$word->_NO;?></label>
          </div>
        </div>
      </div>
      <div class="tubi fitted divider"></div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_LAYOUTF;?></label>
          <div class="inline-group">
            <label class="radio">
              <input name="flayout" type="radio" value="1" <?php echo getChecked($row->flayout, 1);?>>
              <i></i><img src="modules/blog/images/layout-left.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT1;?>"></label>
            <label class="radio">
              <input name="flayout" type="radio" value="2" <?php echo getChecked($row->flayout, 2);?>>
              <i></i><img src="modules/blog/images/layout-right.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT2;?>"></label>
            <label class="radio">
              <input name="flayout" type="radio" value="3" <?php echo getChecked($row->flayout, 3);?>>
              <i></i><img src="modules/blog/images/layout-full-top.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT3;?>"></label>
            <label class="radio">
              <input name="flayout" type="radio" value="4" <?php echo getChecked($row->flayout, 4);?>>
              <i></i><img src="modules/blog/images/layout-two-col.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT5;?>"></label>
          </div>
        </div>
        <div class="field">
          <div class="two fields">
            <div class="field">
              <label><?php echo Lang::$word->_MOD_AM_NOTIFY;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="notify_new" type="radio" value="1" <?php echo getChecked($row->notify_new, 1);?>>
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="notify_new" type="radio" value="0" <?php echo getChecked($row->notify_new, 0);?>>
                  <i></i><?php echo Lang::$word->_NO;?></label>
              </div>
            </div>
            <div class="field">
              <label><?php echo Lang::$word->_MOD_AM_AA;?></label>
              <div class="inline-group">
                <label class="radio">
                  <input name="auto_approve" type="radio" value="1" <?php echo getChecked($row->auto_approve, 1);?>>
                  <i></i><?php echo Lang::$word->_YES;?></label>
                <label class="radio">
                  <input name="auto_approve" type="radio" value="0" <?php echo getChecked($row->auto_approve, 0);?>>
                  <i></i><?php echo Lang::$word->_NO;?></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_SORTING;?></label>
          <select name="sorting">
            <option value="DESC"<?php if($row->sorting == "DESC") echo ' selected="selected"';?>><?php echo Lang::$word->_MOD_AM_SORTING_T;?></option>
            <option value="ASC"<?php if($row->sorting == "ASC") echo ' selected="selected"';?>><?php echo Lang::$word->_MOD_AM_SORTING_B;?></option>
          </select>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_DATE;?></label>
          <select name="cdateformat">
            <?php echo Blog::getDateFormat($row->cdateformat);?>
          </select>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_CHAR;?></label>
          <input class="slrange" name="char_limit" type="text" value="<?php echo $row->char_limit;?>">
          <div class="small-top-space">
            <label><?php echo Lang::$word->_MOD_AM_PERPAGE;?></label>
            <input class="slrange" name="cperpage" type="text" value="<?php echo $row->cperpage;?>">
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_MOD_AM_WORDS;?></label>
          <textarea name="blacklist_words"><?php echo $row->blacklist_words;?></textarea>
        </div>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_AM_TPL_ADM;?></label>
        <textarea id="plugpost" class="plugpost" name="notify_admin_template"><?php echo $row->notify_admin_template;?></textarea>
      </div>
      <div class="field">
        <label><?php echo Lang::$word->_MOD_AM_TPL_USR;?></label>
        <textarea id="plugpost2" class="plugpost" name="notify_user_template"><?php echo $row->notify_user_template;?></textarea>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_MOD_AM_UPDATEC;?></button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=blog" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processConfig" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $("input[name=comperpage],input[name=popperpage],input[name=fperpage], input[name=latestperpage], input[name=latestperpage], input[name=cperpage]").ionRangeSlider({
		min: 5,
		max: 20,
        step: 1,
		postfix: " itm",
        type: 'single',
        hasGrid: true
    });
    $("input[name=char_limit]").ionRangeSlider({
		min: 10,
		max: 500,
        step: 20,
		postfix: " chr",
        type: 'single',
        hasGrid: true
    });
});
// ]]>
</script>
<?php break;?>
<?php case"category": ?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="amcats"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_AM_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=blog" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_AM_TITLE5;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_AM_INFO5;?></div>
  <div id="msgalt"></div>
  <div class="tubi-grid">
    <div class="columns small-gutters">
      <div class="screen-60 tablet-50 phone-100">
        <div class="tubi segment">
          <div class="tubi header"><?php echo Lang::$word->_MOD_AM_SUBTITLE5;?></div>
          <div class="tubi fitted divider"></div>
          <div class="tubi form">
            <form id="tubi_form" name="tubi_form" method="post">
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_CATNAME;?></label>
                <label class="input"> <i class="icon-append icon asterisk"></i>
                  <input type="text" name="name<?php echo Lang::$lang;?>" placeholder="<?php echo Lang::$word->_MOD_AM_CATNAME;?>">
                </label>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_CATSLUG;?></label>
                <label class="input">
                  <input type="text" name="slug" placeholder="<?php echo Lang::$word->_MOD_AM_CATSLUG;?>">
                </label>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_PARENT;?></label>
                <select name="parent_id">
                  <option value="0"><?php echo Lang::$word->_MOD_AM_ROOT;?></option>
                  <?php Registry::get("Blog")->getCatDropList(0, 0,"&#166;&nbsp;&nbsp;&nbsp;&nbsp;");?>
                </select>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_CICON;?></label>
                <div class="scrollbox">
                  <div id="scroll-icons"> <?php print Core::iconList();?> </div>
                  <input name="icon" type="hidden" value="">
                </div>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_CLAYOUT;?></label>
                <div class="inline-group">
                  <label class="radio">
                    <input name="layout" type="radio" value="1" checked="checked">
                    <i></i><img src="modules/blog/images/layout-left.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT1;?>"></label>
                  <label class="radio">
                    <input name="layout" type="radio" value="2">
                    <i></i><img src="modules/blog/images/layout-right.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT2;?>"></label>
                  <label class="radio">
                    <input name="layout" type="radio" value="3">
                    <i></i><img src="modules/blog/images/layout-full-top.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT3;?>"></label>
                  <label class="radio">
                    <input name="layout" type="radio" value="4">
                    <i></i><img src="modules/blog/images/layout-two-col.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT5;?>"></label>
                </div>
              </div>
              <div class="tubi fitted divider"></div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_CIPP;?></label>
                <input class="slrange" name="perpage" type="text">
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_DESC;?></label>
                <textarea placeholder="<?php echo Lang::$word->_MOD_AM_DESC;?>" name="description<?php echo Lang::$lang;?>"></textarea>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_METAKEYS;?></label>
                <textarea placeholder="<?php echo Lang::$word->_METAKEYS;?>" name="metakey<?php echo Lang::$lang;?>"></textarea>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_METADESC;?></label>
                <textarea placeholder="<?php echo Lang::$word->_METADESC;?>" name="metadesc<?php echo Lang::$lang;?>"></textarea>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_CATSTATUS;?></label>
                <div class="inline-group">
                  <label class="radio">
                    <input name="active" type="radio" value="1" checked="checked">
                    <i></i><?php echo Lang::$word->_YES;?></label>
                  <label class="radio">
                    <input name="active" type="radio" value="0">
                    <i></i><?php echo Lang::$word->_NO;?></label>
                </div>
              </div>
              <div class="tubi double fitted divider"></div>
              <button name="docategory" type="button" class="tubi positive button"><?php echo Lang::$word->_MOD_AM_CADD;?></button>
              <a href="index.php?do=modules&amp;action=config&amp;modname=blog" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
              <input name="processCategory" type="hidden" value="1">
            </form>
          </div>
        </div>
        <div id="msgholder"></div>
      </div>
      <div class="screen-40 tablet-50 phone-100">
        <div class="tubi block header">
          <h4><?php echo Lang::$word->_MOD_AM_CATEGORIES;?></h4>
        </div>
        <div id="menusort"> <?php echo Registry::get("Blog")->getSortCatList();?></div>
        <div class="sholder push-right"><a id="serialize" class="tubi positive right labeled icon button"><i class="icon ok sign"></i><?php echo Lang::$word->_MOD_AM_POS_SAVE;?></a></div>
      </div>
    </div>
  </div>
</div>
<script src="assets/js/jquery.tree.js"></script> 
<script src="modules/blog/blog.js"></script> 
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $("input[name=perpage]").ionRangeSlider({
		min: 5,
		max: 20,
        step: 1,
		postfix: " ipp",
        type: 'single',
        hasGrid: true
    });
});
// ]]>
</script>
<?php break;?>
<?php case"catedit": ?>
<?php $row = Core::getRowById(Blog::ctTable, Filter::$id);?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="amcats"><i class="icon help"></i></a> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_AM_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=blog" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <a href="<?php echo Core::url("modules", "category");?>" class="section"><?php echo Lang::$word->_MOD_AM_CATEGORIES;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_AM_TITLE6;?></div>
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
          <div class="tubi header"><?php echo Lang::$word->_MOD_AM_SUBTITLE6 . $row->{'name'.Lang::$lang};?></div>
          <div class="tubi fitted divider"></div>
          <div class="tubi form">
            <form id="tubi_form" name="tubi_form" method="post">
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_CATNAME;?></label>
                <label class="input"> <i class="icon-append icon asterisk"></i>
                  <input type="text" name="name<?php echo Lang::$lang;?>" value="<?php echo $row->{'name'.Lang::$lang};?>">
                </label>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_CATSLUG;?></label>
                <label class="input">
                  <input type="text" name="slug" value="<?php echo $row->slug;?>">
                </label>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_PARENT;?></label>
                <select name="parent_id">
                  <option value="0"><?php echo Lang::$word->_MOD_AM_ROOT;?></option>
                  <?php Registry::get("Blog")->getCatDropList(0, 0,"&#166;&nbsp;&nbsp;&nbsp;&nbsp;", $row->parent_id);?>
                </select>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_CICON;?></label>
                <div class="scrollbox">
                  <div id="scroll-icons"> <?php print Core::iconList($row->icon);?> </div>
                  <input name="icon" type="hidden" value="<?php echo $row->icon;?>">
                </div>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_CLAYOUT;?></label>
                <div class="inline-group">
                  <label class="radio">
                    <input name="layout" type="radio" value="1" <?php getChecked($row->layout, 1); ?>>
                    <i></i><img src="modules/blog/images/layout-left.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT1;?>"></label>
                  <label class="radio">
                    <input name="layout" type="radio" value="2" <?php getChecked($row->layout, 2); ?>>
                    <i></i><img src="modules/blog/images/layout-right.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT2;?>"></label>
                  <label class="radio">
                    <input name="layout" type="radio" value="3" <?php getChecked($row->layout, 3); ?>>
                    <i></i><img src="modules/blog/images/layout-full-top.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT3;?>"></label>
                  <label class="radio">
                    <input name="layout" type="radio" value="4" <?php getChecked($row->layout, 4); ?>>
                    <i></i><img src="modules/blog/images/layout-two-col.png" alt="" data-content="<?php echo Lang::$word->_MOD_AM_LAYOUT5;?>"></label>
                </div>
              </div>
              <div class="tubi fitted divider"></div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_CIPP;?></label>
                <input class="slrange" name="perpage" value="<?php echo $row->perpage;?>" type="text">
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_DESC;?></label>
                <textarea name="description<?php echo Lang::$lang;?>"><?php echo $row->{'description'.Lang::$lang};?></textarea>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_METAKEYS;?></label>
                <textarea name="metakey<?php echo Lang::$lang;?>"><?php echo $row->{'metakey'.Lang::$lang};?></textarea>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_METADESC;?></label>
                <textarea name="metadesc<?php echo Lang::$lang;?>"><?php echo $row->{'metadesc'.Lang::$lang};?></textarea>
              </div>
              <div class="field">
                <label><?php echo Lang::$word->_MOD_AM_CATSTATUS;?></label>
                <div class="inline-group">
                  <label class="radio">
                    <input name="active" type="radio" value="1" <?php getChecked($row->active, 1); ?>>
                    <i></i><?php echo Lang::$word->_YES;?></label>
                  <label class="radio">
                    <input name="active" type="radio" value="0" <?php getChecked($row->active, 0); ?>>
                    <i></i><?php echo Lang::$word->_NO;?></label>
                </div>
              </div>
              <div class="tubi double fitted divider"></div>
              <button name="docategory" type="button" class="tubi positive button"><?php echo Lang::$word->_MOD_AM_CAUPDATE;?></button>
              <a href="<?php echo Core::url("modules", "category");?>" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
              <input name="processCategory" type="hidden" value="1">
              <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
            </form>
          </div>
        </div>
        <div id="msgholder"></div>
      </div>
      <div class="screen-40 tablet-50 phone-100">
        <div class="tubi block header">
          <h4><?php echo Lang::$word->_MOD_AM_CATEGORIES;?></h4>
        </div>
        <div id="menusort"> <?php echo Registry::get("Blog")->getSortCatList();?></div>
        <div class="sholder push-right"><a id="serialize" class="tubi positive right labeled icon button"><i class="icon ok sign"></i><?php echo Lang::$word->_MOD_AM_POS_SAVE;?></a></div>
      </div>
    </div>
  </div>
</div>
<script src="assets/js/jquery.tree.js"></script> 
<script src="modules/blog/blog.js"></script> 
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $("input[name=perpage]").ionRangeSlider({
		min: 5,
		max: 20,
        step: 1,
		postfix: " ipp",
        type: 'single',
        hasGrid: true
    });
});
// ]]>
</script>
<?php break;?>
<?php case"comments": ?>
<?php $commentrow = Registry::get("Blog")->getComments();?>
<div class="tubi icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_AM_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=blog" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_MOD_AM_TITLE8;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_AM_INFO8;?></div>
  <div class="tubi segment">
    <div class="tubi header"><?php echo Lang::$word->_MOD_AM_SUBTITLE8;?></div>
    <div class="tubi fitted divider"></div>
    <div class="tubi small form basic segment">
      <form method="post" id="tubi_form" name="tubi_form">
        <div class="four fields">
          <div class="field">
            <div class="tubi input"> <i class="icon-prepend icon calendar"></i>
              <input name="fromdate" type="text" data-datepicker="true" placeholder="<?php echo Lang::$word->_UR_SHOW_FROM;?>" id="fromdate" />
            </div>
          </div>
          <div class="field">
            <div class="tubi action input"> <i class="icon-prepend icon calendar"></i>
              <input name="enddate" type="text" data-datepicker="true" placeholder="<?php echo Lang::$word->_UR_SHOW_TO;?>" id="enddate" />
              <a id="doDates" class="tubi icon button"><?php echo Lang::$word->_GO;?></a> </div>
          </div>
          <div class="field"> <?php echo $pager->items_per_page();?> </div>
          <div class="field"> <?php echo $pager->jump_menu();?> </div>
        </div>
      </form>
      <div class="tubi fitted divider"></div>
    </div>
    <form method="post" id="admin_form" name="admin_form">
      <table class="tubi sortable table">
        <thead>
          <tr>
            <th class="disabled"> <label class="checkbox">
                <input type="checkbox" name="masterCheckbox" id="masterCheckbox">
                <i></i></label>
            </th>
            <th data-sort="string"><?php echo Lang::$word->_MOD_AM_UNAME;?></th>
            <th data-sort="string"><?php echo Lang::$word->_MOD_AM_EMAIL;?></th>
            <th data-sort="int"><?php echo Lang::$word->_CREATED;?></th>
            <th data-sort="string"><?php echo Lang::$word->_MOD_AM_PNAME;?></th>
            <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
          </tr>
        </thead>
        <?php if($commentrow):?>
        <tfoot>
          <tr>
            <td colspan="6"><div class="tubi small buttons">
                <button type="submit" name="approve" class="tubi positive button"><i class="add icon"></i> <?php echo Lang::$word->_MOD_AM_APPROVE;?></button>
                <button type="submit" name="disapprove" class="tubi warning button"><i class="minus icon"></i> <?php echo Lang::$word->_MOD_AM_DISAPPROVE;?></button>
                <button type="submit" name="delete" class="tubi negative button"><i class="remove icon"></i><?php echo Lang::$word->_DELETE;?></button>
              </div></td>
          </tr>
        </tfoot>
        <?php endif;?>
        <tbody>
          <?php if(!$commentrow):?>
          <tr>
            <td colspan="6"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_AM_NONCOMMENTS);?></td>
          </tr>
          <?php else:?>
          <?php foreach ($commentrow as $row):?>
          <tr>
            <td class="hide-tablet"><label class="checkbox">
                <input name="comid[<?php echo $row->cid;?>]" type="checkbox" value="<?php echo $row->cid;?>">
                <i></i></label></td>
            <td><?php echo $row->username;?></td>
            <td><?php echo $row->email;?></td>
            <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("long_date", $row->created);?></td>
            <td><a href="<?php echo Core::url("modules", "edit", $row->artid);?>"><?php echo $row->title;?></a></td>
            <td><?php echo isActive($row->active);?> <a data-username="<?php echo $row->username;?>" class="viewcomment" data-id="<?php echo $row->cid;?>"><i class="rounded success inverted laptop icon link"></i></a></td>
          </tr>
          <?php endforeach;?>
          <?php unset($row);?>
          <?php endif;?>
        </tbody>
      </table>
    </form>
  </div>
  <div id="msgholder"></div>
  <div class="tubi-grid">
    <div class="two columns horizontal-gutters">
      <div class="row"> <span class="tubi label"><?php echo Lang::$word->_PAG_TOTAL.': '.$pager->items_total;?> / <?php echo Lang::$word->_PAG_CURPAGE.': '.$pager->current_page.' '.Lang::$word->_PAG_OF.' '.$pager->num_pages;?></span> </div>
      <div class="row">
        <div id="pagination"><?php echo $pager->display_pages();?></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $("button[type=submit]").on("click", function () {
        var action = $(this).prop("name");
        var str = $("#admin_form").serialize();
        str += '&comproccess=1';
        str += '&action=' + action;
        $.ajax({
            type: "post",
            url: 'modules/blog/controller.php',
			dataType: 'json',
            data: str,
            success: function (json) {
                $(".tubi.sortable.table tbody tr").each(function () {
                    if ($(this).find("input:checked").length) {
                        if (action == "delete") {
                            $(this).fadeOut(400, function () {
                                $(this).remove();
                            });
                        } else {
                            $(this).addClass('warning');
                        }
                    }
                });
                $("#msgholder").html(json.message);
            }
        });
        return false;
    });
	
    $('a.viewcomment').on('click', function () {
        var id = $(this).data('id')
        var title = $(this).data('username');
		var $parent = $(this).closest('tr')

        Messi.load('modules/blog/controller.php', {
            loadComment: 1,
            id: id,
        }, {
            title: '<?php echo Lang::$word->_MOD_AM_VIEW_P;?> / ' + title,
            buttons: [{
                id: 0,
                'label': '<?php echo Lang::$word->_SUBMIT;?>',
                'class': 'positive',
                'val': 'Y'
            }],
            callback: function (val) {
                $.ajax({
                    type: 'post',
                    url: 'modules/blog/controller.php',
                    dataType: 'json',
                    data: {
                        processComment: 1,
                        id: id,
                        content: $("#bodyid").val()
                    },
                    beforeSend: function () {},
                    success: function (json) {
						$($parent).addClass('warning');
						console.log($parent)
                        $.sticky(decodeURIComponent(json.message), {
                            type: json.type,
                            title: json.title
                        });
                    }
                });
            }
        });
    });

    $('#masterCheckbox').click(function (e) {
        var $checkBoxes = $("input[type=checkbox]");
        $($checkBoxes).prop("checked", $(this).prop("checked"))
    });
});
// ]]>
</script>
<?php break;?>
<?php default: ?>
<?php $artrow = Registry::get("Blog")->getArticles();?>
<div class="tubi icon heading message blue"> <i class="puzzle piece icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MOD_AM_TITLE4;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getModuleName(Filter::$modname);?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_MOD_AM_INFO4;?></div>
  <div class="tubi segment">
    <div class="push-right">
      <div class="tubi right pointing dropdown icon info button"> <i class="settings icon"></i>
        <div class="menu"> <a class="item" href="<?php echo Core::url("modules", "add");?>"><i class="icon add"></i><?php echo Lang::$word->_MOD_AM_SUBTITLE4;?></a> <a class="item" href="<?php echo Core::url("modules", "category");?>"><i class="icon add"></i><?php echo Lang::$word->_MOD_AM_CATEGORIES;?></a> <a class="item" href="<?php echo Core::url("modules", "comments");?>"><i class="icon chat"></i><?php echo Lang::$word->_MOD_AMC_COMMENTS;?></a> <a class="item" href="<?php echo Core::url("modules", "config");?>"><i class="icon setting"></i><?php echo Lang::$word->_MOD_AM_CONFIGURE;?></a> </div>
      </div>
    </div>
    <div class="tubi header"><?php echo Lang::$word->_MOD_AM_SUBTITLE3;?></div>
    <div class="tubi fitted divider"></div>
    <div class="tubi small form basic segment">
      <form method="post" id="tubi_form" name="tubi_form">
        <div class="four fields">
          <div class="field">
            <div class="tubi input"> <i class="icon-prepend icon calendar"></i>
              <input name="fromdate" type="text" data-datepicker="true" placeholder="<?php echo Lang::$word->_UR_SHOW_FROM;?>" id="fromdate" />
            </div>
          </div>
          <div class="field">
            <div class="tubi action input"> <i class="icon-prepend icon calendar"></i>
              <input name="enddate" type="text" data-datepicker="true" placeholder="<?php echo Lang::$word->_UR_SHOW_TO;?>" id="enddate" />
              <a id="doDates" class="tubi icon button"><?php echo Lang::$word->_SR_SEARCH_GO;?></a> </div>
          </div>
          <div class="field">
            <div class="tubi icon input">
              <select name="cid"  onchange="if(this.value!='NA') window.location='index.php?do=modules&amp;action=config&amp;modname=blog&amp;id='+this[this.selectedIndex].value; else window.location='index.php?do=modules&amp;action=config&amp;modname=blog';" id="cat_id">
                <option value="NA"><?php echo Lang::$word->_MOD_AM_FILTER_RESET;?></option>
                <?php Registry::get("Blog")->getCatDropList(0, 0,"&#166;&nbsp;&nbsp;&nbsp;&nbsp;", Filter::$id);?>
              </select>
            </div>
          </div>
          <div class="field">
            <div class="two fields">
              <div class="field"> <?php echo $pager->items_per_page();?> </div>
              <div class="field"> <?php echo $pager->jump_menu();?> </div>
            </div>
          </div>
        </div>
      </form>
      <div class="tubi divider"></div>
      <div id="abc"> <?php echo alphaBits('index.php?do=modules&amp;action=config&amp;modname=blog', "letter");?> </div>
      <div class="tubi fitted divider"></div>
    </div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th class="disabled"><i class="icon photo"></i></th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_AM_NAME;?></th>
          <th data-sort="string"><?php echo Lang::$word->_MOD_AM_CATEGORY;?></th>
          <th data-sort="int"><?php echo Lang::$word->_CREATED;?></th>
          <th data-sort="int"><?php echo Lang::$word->_MOD_AM_HITSRATE;?></th>
          <th data-sort="int"><?php echo Lang::$word->_MOD_AMC_COMMENTS;?></th>
          <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$artrow):?>
        <tr>
          <td colspan="7"><?php echo Filter::msgSingleAlert(Lang::$word->_MOD_AM_NOARTICLES);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($artrow as $row):?>
        <tr<?php if($row->is_user):?> class="warning"<?php endif;?>>
          <td><a class="lightbox" href="<?php echo SITEURL . '/' . Blog::imagepath . $row->thumb;?>" title="<?php echo $row->{'title'.Lang::$lang};?>"> <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/' . Blog::imagepath . $row->thumb;?>&amp;w=120&amp;h=60" alt="" class="tubi image"></a></td>
          <td><?php echo $row->{'title' . Lang::$lang};?></td>
          <td><a href="<?php echo Core::url("modules", "catedit", $row->cid);?>"><?php echo $row->catname;?></a></td>
          <td data-sort-value="<?php echo strtotime($row->created);?>"><?php echo Filter::dodate("short_date", $row->created);?></td>
          <td data-sort-value="<?php echo $row->hits;?>"><?php echo $row->hits.' / '.Blog::getRatingInfo($row->rating,$row->rate_number);?></td>
          <td><span class="tubi black label"><?php echo $row->totalcomments;?></span></td>
          <td><a href="<?php echo Core::url("modules", "edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_AM_ARTICLE;?>" data-option="deleteArticle" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
  <div class="tubi-grid">
    <div class="two columns horizontal-gutters">
      <div class="row"> <span class="tubi label"><?php echo Lang::$word->_PAG_TOTAL.': '.$pager->items_total;?> / <?php echo Lang::$word->_PAG_CURPAGE.': '.$pager->current_page.' '.Lang::$word->_PAG_OF.' '.$pager->num_pages;?></span> </div>
      <div class="row">
        <div id="pagination"><?php echo $pager->display_pages();?></div>
      </div>
    </div>
  </div>
</div>
<?php break;?>
<?php endswitch;?>
