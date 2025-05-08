<?php
  /**
   * Plugins
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: plugins.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  if(!$user->getAcl("Plugins")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById(Content::plTable, Filter::$id);?>

<div class="tubi icon heading message orange"><a class="helper tubi top right info corner label" data-help="plugin"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PL_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PL_TITLE1;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PL_INFO1. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_PL_SUBTITLE1 . $row->{'title'.Lang::$lang};?></div>
    <ul class="idTabs" id="tabs">
      <li><a data-tab="#ana"><?php echo Lang::$word->_TEMEL;?></a></li>
      <li><a data-tab="#ek"><?php echo Lang::$word->_YARD;?></a></li>
    </ul>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div id="ana" class="tab_content">
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_PL_TITLE;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
            </label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PL_BODY;?></label>
          <textarea id="plugpost" class="plugpost" name="body<?php echo Lang::$lang;?>"><?php echo Filter::out_url($row->{'body'.Lang::$lang});?></textarea>
        </div>
        <div class="field">
          <?php if(!$row->system):?>
          <label><?php echo Lang::$word->_PG_JSCODE;?></label>
          <textarea name="jscode"><?php echo cleanOut($row->jscode);?></textarea>
          <?php endif;?>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="two fields"> </div>
      </div>
      <div id="ek" class="tab_content">
        <div class="four fields">
          <div class="field">
            <label>Dikkat! Eklenti Klasörü (Sadece Yazılımcınız Kullansın)</label>
            <label class="input">
              <!-- input type="text" value="" name="Eklenti Klasörü" -->
              <select name="plugalias">
              <option value="<?php echo $row->{'plugalias'};?>"><?php if(!$row->{'plugalias'}):?> Seçilmedi <?php else: echo $row->{'plugalias'}; endif; ?></option>
                <?php
				function list_files($dir)
				{
					if(is_dir($dir))
					{
						if($handle = opendir($dir))
						{
							while(($file = readdir($handle)) !== false)
							{
								if($file != "." && $file != ".." && $file != "Thumbs.db"/*Bazı sinir bozucu windows dosyaları.*/)
								if($file != "." && $file != ".." && $file != "index.php"/*Bazı sinir bozucu windows dosyaları.*/)
								{
									echo '<option value="'.$file.'">'.$file.'</option>'."\n";
								}
							}
							closedir($handle);
						}
					}
				}
				list_files("../plugins/"); // 
				?>
              </select>            </label>
          </div>
          <div class="field">
            <label>Sistem Eklentisi (Sadece Yazılımcınız Kullansın)</label>
            <div class="inline-group">
              <label class="radio">
                <input name="system" type="radio" value="1" <?php echo getChecked($row->system, 1);?>>
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="system" type="radio" value="0" <?php echo getChecked($row->system, 0);?>>
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label>Ana Eklenti</label>
            <div class="inline-group">
              <label class="radio">
                <input name="main" type="radio" value="1" <?php echo getChecked($row->main, 1);?>>
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="main" type="radio" value="0" <?php echo getChecked($row->main, 0);?>>
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label>Düzenlenebilir Sistem (Sadece Yazılımcınız Kullansın)</label>
            <div class="inline-group">
              <label class="radio">
                <input name="hasconfig" type="radio" value="1" <?php echo getChecked($row->hasconfig, 1);?>>
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="hasconfig" type="radio" value="0" <?php echo getChecked($row->hasconfig, 0);?>>
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="four fields">
          <div class="field">
            <label><?php echo Lang::$word->_PL_DESC;?></label>
            <textarea name="info<?php echo Lang::$lang;?>"><?php echo $row->{'info'.Lang::$lang};?></textarea>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_PL_ALT_CLASS;?></label>
            <label class="input">
              <input type="text" value="<?php echo $row->alt_class;?>" name="alt_class">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_PL_SHOW_TITLE;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_title" type="radio" value="1" <?php echo getChecked($row->show_title, 1);?>>
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_title" type="radio" value="0" <?php echo getChecked($row->show_title, 0);?>>
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_PL_PUB;?></label>
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
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_PL_UPDATE;?></button>
      <a href="index.php?do=plugins" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processPlugin" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"add": ?>
<div class="tubi icon heading message orange"><a class="helper tubi top right info corner label" data-help="plugin"><i class="icon help"></i></a> <i class="umbrella icon"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PL_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=plugins" class="section"><?php echo Lang::$word->_N_PLUGS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_PL_TITLE2;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PL_INFO2. Lang::$word->_REQ1 . '<i class="icon asterisk"></i>' . Lang::$word->_REQ2;?></div>
  <div class="tubi form segment">
    <div class="tubi header"><?php echo Lang::$word->_PL_SUBTITLE2;?></div>
    <ul class="idTabs" id="tabs">
      <li><a data-tab="#ana"><?php echo Lang::$word->_TEMEL;?></a></li>
      <li><a data-tab="#ek"><?php echo Lang::$word->_YARD;?></a></li>
    </ul>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post">
      <div id="ana" class="tab_content">
        <div class="two fields">
          <div class="field">
            <label><?php echo Lang::$word->_PL_TITLE;?></label>
            <label class="input"><i class="icon-append icon asterisk"></i>
              <input type="text" placeholder="<?php echo Lang::$word->_PL_TITLE;?>" name="title<?php echo Lang::$lang;?>">
            </label>
          </div>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PL_BODY;?></label>
          <textarea id="plugpost" class="plugpost" name="body<?php echo Lang::$lang;?>"></textarea>
        </div>
        <div class="field">
          <label><?php echo Lang::$word->_PG_JSCODE;?></label>
          <textarea name="jscode"></textarea>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="two fields"> </div>
      </div>
      <div id="ek" class="tab_content">
        <div class="four fields">
          <div class="field">
            <label>Eklenti Klasörü (Sadece Yazılımcınız Kullansın)</label>
            <label class="input"> 
              <!-- input type="text" placeholder="Eklenti Klasörü" name="plugalias" -->
              <select name="plugalias">
              <option value="">Seçilmedi</option>
                <?php
				function list_files($dir)
				{
					if(is_dir($dir))
					{
						if($handle = opendir($dir))
						{
							while(($file = readdir($handle)) !== false)
							{
								if($file != "." && $file != ".." && $file != "Thumbs.db"/*Bazı sinir bozucu windows dosyaları.*/)
								if($file != "." && $file != ".." && $file != "index.php"/*Bazı sinir bozucu windows dosyaları.*/)
								{
									echo '<option value="'.$file.'">'.$file.'</option>'."\n";
								}
							}
							closedir($handle);
						}
					}
				}
				list_files("../plugins/"); // 
				?>
              </select>
            </label>
          </div>
          <div class="field">
            <label>Sistem Eklentisi (Sadece Yazılımcınız Kullansın)</label>
            <div class="inline-group">
              <label class="radio">
                <input name="system" type="radio" value="1">
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="system" type="radio" value="0" checked="checked">
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label>Ana Eklenti</label>
            <div class="inline-group">
              <label class="radio">
                <input name="main" type="radio" value="1">
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="main" type="radio" value="0" checked="checked">
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label>Düzenlenebilir Sistem (Sadece Yazılımcınız Kullansın)</label>
            <div class="inline-group">
              <label class="radio">
                <input name="hasconfig" type="radio" value="1">
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="hasconfig" type="radio" value="0" checked="checked">
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
        </div>
        <div class="tubi fitted divider"></div>
        <div class="four fields">
          <div class="field">
            <label><?php echo Lang::$word->_PL_DESC;?></label>
            <textarea name="info<?php echo Lang::$lang;?>"></textarea>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_PL_ALT_CLASS;?></label>
            <label class="input">
              <input type="text" placeholder="<?php echo Lang::$word->_PL_ALT_CLASS;?>" name="alt_class">
            </label>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_PL_SHOW_TITLE;?></label>
            <div class="inline-group">
              <label class="radio">
                <input name="show_title" type="radio" value="1">
                <i></i><?php echo Lang::$word->_YES;?></label>
              <label class="radio">
                <input name="show_title" type="radio" value="0" checked="checked">
                <i></i><?php echo Lang::$word->_NO;?></label>
            </div>
          </div>
          <div class="field">
            <label><?php echo Lang::$word->_PL_PUB;?></label>
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
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button"><?php echo Lang::$word->_PL_ADD;?></button>
      <a href="index.php?do=plugins" class="tubi basic button"><?php echo Lang::$word->_CANCEL;?></a>
      <input name="processPlugin" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php break;?>
<?php case"config": ?>
<?php $admfile = PLUGPATH . Filter::$plugname . "/admin.php";?>
<?php $clsfile = PLUGPATH . Filter::$plugname . "/admin_class.php";?>
<?php
  if (file_exists($admfile)):
      if (file_exists($clsfile)):
          include_once ($clsfile);
      endif;
      include_once ($admfile);
  else:
      redirect_to("index.php?do=plugins");
  endif;
?>
<?php break;?>
<?php default: ?>
<?php $plugin = $content->getPagePlugins();?>
<?php $pluginMain = $content->getPagePluginsMain();?>
<div class="tubi icon heading message orange"> <i class="icon umbrella"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_PL_TITLE3;?> </div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo Lang::$word->_N_PLUGS;?></div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?><?php echo Lang::$word->_PL_INFO3;?></div>
  <div class="tubi segment"> <a class="tubi icon positive button push-right" href="index.php?do=plugins&amp;action=add"><i class="icon add"></i> <?php echo Lang::$word->_PL_ADD;?></a>
    <div class="tubi header"><?php echo Lang::$word->_PL_SUBTITLE3;?></div>
    <div class="tubi fitted divider"></div>
    <div class="tubi small basic form segment">
      <div class="four fields">
        <div class="two fields">
          <ul class="idTabs" id="tabs">
            <li><a data-tab="#ana"><?php echo Lang::$word->_TEMEL;?></a></li>
            <li><a data-tab="#ek"><?php echo Lang::$word->_YARD;?></a></li>
          </ul>
        </div>
        <div class="field"> <?php echo $pager->items_per_page();?> </div>
        <div class="field"> <?php echo $pager->jump_menu();?> </div>
      </div>
    </div>
    <div id="ana" class="tab_content">
      <table class="tubi sortable table">
        <thead>
          <tr>
            <th data-sort="int">#</th>
            <th data-sort="string"><?php echo Lang::$word->_PL_TITLE;?></th>
            <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
          </tr>
        </thead>
        <tbody>
          <?php if(!$plugin):?>
          <tr>
            <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_PL_NOPLUG);?></td>
          </tr>
          <?php else:?>
          <?php foreach ($plugin as $row):?>
          <?php if($user->getAcl($row->plugalias)):?>
          <tr>
            <td><?php echo $row->id;?>.</td>
            <td><?php echo $row->{'title'.Lang::$lang};?></td>
            <td><?php echo isActive($row->active);?> <a href="index.php?do=plugins&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a>
              <?php if($row->hasconfig == 1):?>
              <a href="index.php?do=plugins&amp;action=config&amp;plugname=<?php echo $row->plugalias;?>" data-content="<?php echo Lang::$word->_PL_CONFIG.': '.$row->{'title'.Lang::$lang};?>"><i class="rounded inverted info icon setting link"></i></a>
              <?php endif;?>
              <?php if(!$row->system):?>
              <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_PLUGIN;?>" data-option="deletePlugin" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a>
              <?php else:?>
              <i class="rounded warning inverted ban circle icon"></i>
              <?php endif;?></td>
          </tr>
          <?php endif;?>
          <?php endforeach;?>
          <?php unset($row);?>
          <?php endif;?>
        </tbody>
      </table>
    </div>
    <div id="ek" class="tab_content">
      <table class="tubi sortable table">
        <thead>
          <tr>
            <th data-sort="int">#</th>
            <th data-sort="string"><?php echo Lang::$word->_PL_TITLE;?></th>
            <th class="disabled"><?php echo Lang::$word->_ACTIONS;?></th>
          </tr>
        </thead>
        <tbody>
          <?php if(!$pluginMain):?>
          <tr>
            <td colspan="4"><?php echo Filter::msgSingleAlert(Lang::$word->_PL_NOPLUG);?></td>
          </tr>
          <?php else:?>
          <?php foreach ($pluginMain as $row):?>
          <?php if($user->getAcl($row->plugalias)):?>
          <tr>
            <td><?php echo $row->id;?>.</td>
            <td><?php echo $row->{'title'.Lang::$lang};?></td>
            <td><?php echo isActive($row->active);?> <a href="index.php?do=plugins&amp;action=edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a>
              <?php if($row->hasconfig == 1):?>
              <a href="index.php?do=plugins&amp;action=config&amp;plugname=<?php echo $row->plugalias;?>" data-content="<?php echo Lang::$word->_PL_CONFIG.': '.$row->{'title'.Lang::$lang};?>"><i class="rounded inverted info icon setting link"></i></a>
              <?php endif;?>
              <?php if(!$row->system):?>
              <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_PLUGIN;?>" data-option="deletePlugin" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a>
              <?php else:?>
              <i class="rounded warning inverted ban circle icon"></i>
              <?php endif;?></td>
          </tr>
          <?php endif;?>
          <?php endforeach;?>
          <?php unset($row);?>
          <?php endif;?>
        </tbody>
      </table>
    </div>
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
