<?php
/**
 * Muzibu Admin - Playlist Section
 *
 * @package Muzibu Module
 * @author geliştiren
 * @copyright 2024
 */
if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

if (!$user->getAcl("muzibu")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;

switch(Filter::$maction): 
case "playlist_edit": 
    $row = Core::getRowById(Muzibu::playlistTable, Filter::$id);
    $sectors = Registry::get("Muzibu")->getSectors();
    $playlist_sectors = Registry::get("Muzibu")->getPlaylistSectors(Filter::$id);
    $playlist_sectors_ids = array();
    
    if ($playlist_sectors) {
        foreach ($playlist_sectors as $ps) {
            $playlist_sectors_ids[] = $ps->id;
        }
    }
?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> <i class="list icon"></i>
  <div class="content">
    <div class="header">Çalma Listeleri</div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section">Admin Paneli</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section">Modüller</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section">Çalma Listesi Düzenle</div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?>Yıldız (<i class="icon asterisk"></i>) işaretli alanların doldurulması zorunludur.</div>
  <div class="tubi form segment">
    <div class="tubi header">Çalma Listesi Bilgilerini Düzenle</div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post" enctype="multipart/form-data">
      <div class="two fields">
        <div class="field">
          <label>Çalma Listesi Adı</label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" value="<?php echo $row->{'title'.Lang::$lang};?>" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label>SEO URL</label>
          <label class="input">
            <input type="text" value="<?php echo $row->slug;?>" name="slug">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label>Çalma Listesi Görseli</label>
          <label class="input">
            <input type="file" name="thumb" class="filefield">
          </label>
        </div>
        <div class="field">
          <?php if($row->thumb):?>
          <label>Mevcut Görsel</label>
          <div class="tubi small image"> 
            <a class="lightbox" href="<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>">
              <img src="<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>" alt="<?php echo $row->{'title'.Lang::$lang};?>">
            </a> 
          </div>
          <?php endif;?>
        </div>
      </div>
      <div class="field">
        <label>Açıklama</label>
        <textarea id="plugpost2" class="plugpost" name="description<?php echo LANG::$lang;?>"><?php echo Filter::out_url($row->{'description'.Lang::$lang});?></textarea>
      </div>
      <div class="field">
        <label>Sektörler</label>
        <select name="sectors[]" class="tubi dropdown" multiple>
          <?php if($sectors):?>
          <?php foreach($sectors as $sector):?>
          <?php $sel = (in_array($sector->id, $playlist_sectors_ids)) ? ' selected="selected"' : '';?>
          <option value="<?php echo $sector->id;?>"<?php echo $sel;?>><?php echo $sector->{'title'.LANG::$lang};?></option>
          <?php endforeach;?>
          <?php unset($sector);?>
          <?php endif;?>
        </select>
      </div>
      <div class="three fields">
        <div class="field">
          <label>Aktif</label>
          <div class="inline-group">
            <label class="radio">
              <input type="radio" name="active" value="1" <?php echo ($row->active == 1) ? 'checked="checked"' : '';?>>
              <i></i>Evet</label>
            <label class="radio">
              <input type="radio" name="active" value="0" <?php echo ($row->active == 0) ? 'checked="checked"' : '';?>>
              <i></i>Hayır</label>
          </div>
        </div>
        <div class="field">
          <label>Sistem Listesi</label>
          <div class="inline-group">
            <label class="radio">
              <input type="radio" name="system" value="1" <?php echo ($row->system == 1) ? 'checked="checked"' : '';?>>
              <i></i>Evet</label>
            <label class="radio">
              <input type="radio" name="system" value="0" <?php echo ($row->system == 0) ? 'checked="checked"' : '';?>>
              <i></i>Hayır</label>
          </div>
        </div>
        <div class="field">
          <label>Herkese Açık</label>
          <div class="inline-group">
            <label class="radio">
              <input type="radio" name="is_public" value="1" <?php echo ($row->is_public == 1) ? 'checked="checked"' : '';?>>
              <i></i>Evet</label>
            <label class="radio">
              <input type="radio" name="is_public" value="0" <?php echo ($row->is_public == 0) ? 'checked="checked"' : '';?>>
              <i></i>Hayır</label>
          </div>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button">Çalma Listesi Güncelle</button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlists" class="tubi basic button">İptal</a>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlist_songs&amp;playlist_id=<?php echo Filter::$id;?>" class="tubi blue button">Şarkıları Düzenle</a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processPlaylist" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php 
    break;

case "playlist_add": 
    $sectors = Registry::get("Muzibu")->getSectors();
?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> <i class="list icon"></i>
  <div class="content">
    <div class="header">Çalma Listeleri</div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section">Admin Paneli</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section">Modüller</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section">Yeni Çalma Listesi Ekle</div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?>Yıldız (<i class="icon asterisk"></i>) işaretli alanların doldurulması zorunludur.</div>
  <div class="tubi form segment">
    <div class="tubi header">Çalma Listesi Bilgileri</div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post" enctype="multipart/form-data">
      <div class="two fields">
        <div class="field">
          <label>Çalma Listesi Adı</label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="Çalma Listesi Adı" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label>SEO URL</label>
          <label class="input">
            <input type="text" placeholder="SEO URL" name="slug">
          </label>
        </div>
      </div>
      <div class="field">
        <label>Çalma Listesi Görseli</label>
        <label class="input">
          <input type="file" name="thumb" class="filefield">
        </label>
      </div>
      <div class="field">
        <label>Açıklama</label>
        <textarea id="plugpost2" placeholder="Çalma listesi açıklaması" class="plugpost" name="description<?php echo LANG::$lang;?>"></textarea>
      </div>
      <div class="field">
        <label>Sektörler</label>
        <select name="sectors[]" class="tubi dropdown" multiple>
          <?php if($sectors):?>
          <?php foreach($sectors as $sector):?>
          <option value="<?php echo $sector->id;?>"><?php echo $sector->{'title'.LANG::$lang};?></option>
          <?php endforeach;?>
          <?php unset($sector);?>
          <?php endif;?>
        </select>
      </div>
      <div class="three fields">
        <div class="field">
          <label>Aktif</label>
          <div class="inline-group">
            <label class="radio">
              <input type="radio" name="active" value="1" checked="checked">
              <i></i>Evet</label>
            <label class="radio">
              <input type="radio" name="active" value="0">
              <i></i>Hayır</label>
          </div>
        </div>
        <div class="field">
          <label>Sistem Listesi</label>
          <div class="inline-group">
            <label class="radio">
              <input type="radio" name="system" value="1">
              <i></i>Evet</label>
            <label class="radio">
              <input type="radio" name="system" value="0" checked="checked">
              <i></i>Hayır</label>
          </div>
        </div>
        <div class="field">
          <label>Herkese Açık</label>
          <div class="inline-group">
            <label class="radio">
              <input type="radio" name="is_public" value="1" checked="checked">
              <i></i>Evet</label>
            <label class="radio">
              <input type="radio" name="is_public" value="0">
              <i></i>Hayır</label>
          </div>
        </div>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button">Çalma Listesi Ekle</button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlists" class="tubi basic button">İptal</a>
      <input name="processPlaylist" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php
break;

case "playlists": 
    $playlists = Registry::get("Muzibu")->getAllPlaylists();
?>
<div class="tubi icon heading message blue"> 
  <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> 
  <i class="list icon"></i>
  <div class="content">
    <div class="header">Çalma Listesi Yönetimi</div>
    <div class="tubi breadcrumb">
      <i class="icon home"></i> 
      <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <div class="active section"><?php echo $content->getModuleName(Filter::$modname);?></div>
    </div>
  </div>
</div>

<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?>Çalma listeleri yönetimi.</div>
  <div class="tubi segment">
    <div class="push-right">
      <div class="tubi right pointing dropdown icon info button"> 
        <i class="settings icon"></i>
        <div class="menu">
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="item">Şarkı Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=albums" class="item">Albüm Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=artist-list" class="item">Sanatçı Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genres" class="item">Tür Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=sectors" class="item">Sektör Yönetimi</a>
        </div>
      </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlist_add" class="tubi icon positive button"><i class="icon add"></i>Yeni Çalma Listesi Ekle</a>
    </div>
    <div class="tubi header">Çalma Listeleri</div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th style="width: 30px;" class="disabled"></th>
          <th style="width: 80px;" class="disabled">ID</th>
          <th data-sort="string">Liste Adı</th>
          <th data-sort="string">Oluşturan</th>
          <th style="width: 100px;" data-sort="int">Şarkı Sayısı</th>
          <th style="width: 100px;" data-sort="int">Sistem</th>
          <th style="width: 100px;" data-sort="int">Herkese Açık</th>
          <th style="width: 100px;" data-sort="int">Aktif</th>
          <th style="width: 130px;" class="disabled">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$playlists):?>
        <tr>
          <td colspan="9"><?php echo Filter::msgInfo("<span>Henüz çalma listesi eklenmemiş.</span>", false);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($playlists as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="int"><?php echo $row->id; ?></td>
          <td>
            <?php if($row->thumb):?>
            <a class="lightbox" href="<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>" title="<?php echo $row->{'title'.LANG::$lang};?>"> 
              <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>&amp;w=40&amp;h=40" alt="" class="tubi image">
            </a>
            <?php else:?>
              <i class="icon list"></i>
            <?php endif;?>
          </td>
          <td>
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlist_songs&amp;playlist_id=<?php echo $row->id;?>">
              <?php echo $row->{'title'.Lang::$lang};?>
            </a>
          </td>
          <td>
            <?php if($row->user_id):?>
              <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=user_playlists&amp;id=<?php echo $row->user_id;?>">
              <?php 
                if(!empty($row->username)) {
                  echo $row->username;
                } elseif(!empty($row->fname) || !empty($row->lname)) {
                  echo $row->fname . ' ' . $row->lname;
                } else {
                  echo 'Kullanıcı #' . $row->user_id;
                }
              ?>
              </a>
            <?php else:?>
              Sistem
            <?php endif;?>
          </td>
          <td><?php echo (isset($row->song_count)) ? $row->song_count : 0; ?></td>
          <td><?php echo ($row->system) ? '<i class="positive icon check"></i>' : '<i class="negative icon cancel"></i>';?></td>
          <td><?php echo ($row->is_public) ? '<i class="positive icon check"></i>' : '<i class="negative icon cancel"></i>';?></td>
          <td><?php echo ($row->active) ? '<i class="positive icon check"></i>' : '<i class="negative icon cancel"></i>';?></td>
          <td>
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlist_edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> 
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlist_songs&amp;playlist_id=<?php echo $row->id;?>"><i class="rounded inverted success icon list link"></i></a>
            <a class="delete" data-title="<?php echo Lang::$word->_DELETE;?> Çalma Listesi" data-option="deletePlaylist" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title'.Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a>
          </td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
  <?php if(isset($pager) && $pager->display_pages()):?>
  <div class="tubi-grid">
    <div class="two columns horizontal-gutters">
      <div class="row"> <span class="tubi label"><?php echo Lang::$word->_PAG_TOTAL.': '.$pager->items_total;?> / <?php echo Lang::$word->_PAG_CURPAGE.': '.$pager->current_page.' '.Lang::$word->_PAG_OF.' '.$pager->num_pages;?></span> </div>
      <div class="row">
        <div id="pagination"><?php echo $pager->display_pages();?></div>
      </div>
    </div>
  </div>
  <?php endif;?>
</div>
<?php
    break;

default: 
    // Varsayılan olarak çalma listeleri listesini göster
    header("Location: index.php?do=modules&action=config&modname=muzibu&maction=playlists");
    break;
endswitch;
?>