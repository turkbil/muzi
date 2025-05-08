<?php
/**
 * Muzibu Admin - Album Section
 *
 * @package Muzibu Module
 * @author Nurullah Okatan
 * @copyright 2024
 */
if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

if (!$user->getAcl("muzibu")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;

switch(Filter::$maction): 
case "album_edit": 
    $row = Core::getRowById(Muzibu::albumTable, Filter::$id);
    $artists = Registry::get("Muzibu")->getArtists();
?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> <i class="album icon"></i>
  <div class="content">
    <div class="header">Albümler</div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section">Admin Paneli</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section">Modüller</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section">Albüm Düzenle</div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?>Yıldız (<i class="icon asterisk"></i>) işaretli alanların doldurulması zorunludur.</div>
  <div class="tubi form segment">
    <div class="tubi header">Albüm Bilgilerini Düzenle</div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post" enctype="multipart/form-data">
      <div class="two fields">
        <div class="field">
          <label>Albüm Adı</label>
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
      <div class="field">
        <label>Yayın Tarihi</label>
        <label class="input">
          <input type="date" value="<?php echo substr($row->created, 0, 10);?>" name="created">
        </label>
      </div>
      <div class="field">
        <label>Sanatçı</label>
        <select name="artist_id" required>
          <option value="">Sanatçı Seçin</option>
          <?php if($artists):?>
          <?php foreach($artists as $artist):?>
          <?php $sel = ($artist->id == $row->artist_id) ? ' selected="selected"' : '';?>
          <option value="<?php echo $artist->id;?>"<?php echo $sel;?>><?php echo $artist->{'title'.LANG::$lang};?></option>
          <?php endforeach;?>
          <?php unset($artist);?>
          <?php endif;?>
        </select>
      </div>
      <div class="two fields">
        <div class="field">
          <label>Albüm Kapağı</label>
          <label class="input">
            <input type="file" name="thumb" class="filefield">
          </label>
        </div>
        <div class="field">
          <?php if($row->thumb):?>
          <label>Mevcut Kapak</label>
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
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button">Albüm Güncelle</button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=albums" class="tubi basic button">İptal</a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processAlbum" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php 
    break;

case "album_add": 
    $artists = Registry::get("Muzibu")->getArtists();
?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> <i class="album icon"></i>
  <div class="content">
    <div class="header">Albümler</div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section">Admin Paneli</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section">Modüller</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section">Yeni Albüm Ekle</div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?>Yıldız (<i class="icon asterisk"></i>) işaretli alanların doldurulması zorunludur.</div>
  <div class="tubi form segment">
    <div class="tubi header">Albüm Bilgileri</div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post" enctype="multipart/form-data">
      <div class="two fields">
        <div class="field">
          <label>Albüm Adı</label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="Albüm Adı" name="title<?php echo Lang::$lang;?>">
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
        <label>Yayın Tarihi</label>
        <label class="input">
          <input type="date" value="<?php echo date('Y-m-d');?>" name="created">
        </label>
      </div>
      <div class="field">
        <label>Sanatçı</label>
        <select name="artist_id" required>
          <option value="">Sanatçı Seçin</option>
          <?php if($artists):?>
          <?php foreach($artists as $artist):?>
          <option value="<?php echo $artist->id;?>"><?php echo $artist->{'title'.LANG::$lang};?></option>
          <?php endforeach;?>
          <?php unset($artist);?>
          <?php endif;?>
        </select>
      </div>
      <div class="field">
        <label>Albüm Kapağı</label>
        <label class="input">
          <input type="file" name="thumb" class="filefield">
        </label>
      </div>
      <div class="field">
        <label>Açıklama</label>
        <textarea id="plugpost2" placeholder="Albüm açıklaması" class="plugpost" name="description<?php echo LANG::$lang;?>"></textarea>
      </div>
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
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button">Albüm Ekle</button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=albums" class="tubi basic button">İptal</a>
      <input name="processAlbum" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php
    break;

case "albums": 
    $albums = Registry::get("Muzibu")->getAlbums();
?>
<div class="tubi icon heading message blue"> 
  <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> 
  <i class="album icon"></i>
  <div class="content">
    <div class="header">Albüm Yönetimi</div>
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
  <div class="tubi message"><?php echo Core::langIcon();?>Albüm listesi ve yönetimi.</div>
  <div class="tubi segment">
    <div class="push-right">
      <div class="tubi right pointing dropdown icon info button"> 
        <i class="settings icon"></i>
        <div class="menu">
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="item">Şarkı Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=artist-list" class="item">Sanatçı Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genres" class="item">Tür Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=sectors" class="item">Sektör Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlists" class="item">Çalma Listesi Yönetimi</a>
        </div>
      </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=album_add" class="tubi icon positive button"><i class="icon add"></i>Yeni Albüm Ekle</a>
    </div>
    <div class="tubi header">Albüm Listesi</div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th style="width: 30px;" class="disabled">ID</th>
          <th style="width: 80px;" class="disabled"></th>
          <th data-sort="string">Albüm Adı</th>
          <th data-sort="string">Sanatçı</th>
          <th style="width: 100px;" data-sort="int">Şarkı Sayısı</th>
          <th style="width: 100px;" data-sort="int">Aktif</th>
          <th style="width: 90px;" class="disabled">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$albums):?>
        <tr>
          <td colspan="7"><?php echo Filter::msgInfo("<span>Henüz albüm eklenmemiş.</span>", false);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($albums as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="int"><?php echo $row->id; ?></td>
          <td>
            <?php if($row->thumb):?>
            <a class="lightbox" href="<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>" title="<?php echo $row->{'title'.LANG::$lang};?>"> 
              <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>&amp;w=40&amp;h=40" alt="" class="tubi image">
            </a>
            <?php else:?>
              <i class="icon music"></i>
            <?php endif;?>
          </td>
          <td>
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=album_songs&amp;id=<?php echo $row->id;?>">
              <?php echo $row->{'title'.Lang::$lang};?>
            </a>
          </td>
          <td>
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=artist_songs&amp;id=<?php echo $row->artist_id;?>">
              <?php echo $row->artist_name;?>
            </a>
          </td>
          <td><?php echo $row->song_count; ?></td>
          <td><?php echo ($row->active) ? '<i class="positive icon check"></i>' : '<i class="negative icon cancel"></i>';?></td>
          <td>
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=album_edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> 
            <a class="delete" data-title="<?php echo Lang::$word->_DELETE;?> Albüm" data-option="deleteAlbum" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title'.Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a>
          </td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
  <?php if($pager->display_pages()):?>
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
    break;
endswitch;
?>