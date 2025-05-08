<?php
/**
 * Muzibu Admin - Sector Section
 *
 * @package Muzibu Module
 * @author Nurullah Okatan
 * @copyright 2024
 */
if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

if (!$user->getAcl("muzibu")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;

switch(Filter::$maction): 
case "sector_edit": 
    $row = Core::getRowById(Muzibu::sectorTable, Filter::$id);
?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> <i class="building icon"></i>
  <div class="content">
    <div class="header">Sektörler</div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section">Admin Paneli</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section">Modüller</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section">Sektör Düzenle</div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?>Yıldız (<i class="icon asterisk"></i>) işaretli alanların doldurulması zorunludur.</div>
  <div class="tubi form segment">
    <div class="tubi header">Sektör Bilgilerini Düzenle</div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post" enctype="multipart/form-data">
      <div class="two fields">
        <div class="field">
          <label>Sektör Adı</label>
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
          <label>Sektör Görseli</label>
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
        <label>Çalma Listeleri</label>
        <select name="playlists[]" class="tubi fluid search dropdown" multiple>
          <?php
          $muzibu = Registry::get("Muzibu");
          $playlists = $muzibu->playlist->getAllPlaylists();
          $selectedPlaylists = $muzibu->sector->getPlaylistsBySector($row->id);
          $selectedIds = [];
          if($selectedPlaylists) {
            foreach($selectedPlaylists as $sp) {
              $selectedIds[] = $sp->id;
            }
          }
          if($playlists):
            foreach($playlists as $playlist):
          ?>
          <option value="<?php echo $playlist->id;?>" <?php echo (in_array($playlist->id, $selectedIds)) ? 'selected' : '';?>><?php echo $playlist->{'title'.Lang::$lang};?></option>
          <?php
            endforeach;
          endif;
          ?>
        </select>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button">Sektör Güncelle</button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=sectors" class="tubi basic button">İptal</a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processSector" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php 
    break;

case "sector_add": 
?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> <i class="building icon"></i>
  <div class="content">
    <div class="header">Sektörler</div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section">Admin Paneli</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section">Modüller</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section">Yeni Sektör Ekle</div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?>Yıldız (<i class="icon asterisk"></i>) işaretli alanların doldurulması zorunludur.</div>
  <div class="tubi form segment">
    <div class="tubi header">Sektör Bilgileri</div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post" enctype="multipart/form-data">
      <div class="two fields">
        <div class="field">
          <label>Sektör Adı</label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="Sektör Adı" name="title<?php echo Lang::$lang;?>">
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
        <label>Sektör Görseli</label>
        <label class="input">
          <input type="file" name="thumb" class="filefield">
        </label>
      </div>
      <div class="field">
        <label>Çalma Listeleri</label>
        <select name="playlists[]" class="tubi fluid search dropdown" multiple>
          <?php
          $playlists = Registry::get("Muzibu")->getAllPlaylists();
          if($playlists):
            foreach($playlists as $playlist):
          ?>
          <option value="<?php echo $playlist->id;?>"><?php echo $playlist->{'title'.Lang::$lang};?></option>
          <?php
            endforeach;
          endif;
          ?>
        </select>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button">Sektör Ekle</button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=sectors" class="tubi basic button">İptal</a>
      <input name="processSector" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php
    break;

case "sectors": 
    $sectors = Registry::get("Muzibu")->getSectors();
?>
<div class="tubi icon heading message blue"> 
  <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> 
  <i class="building icon"></i>
  <div class="content">
    <div class="header">Sektör Yönetimi</div>
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
  <div class="tubi message"><?php echo Core::langIcon();?>Sektörler listesi ve yönetimi.</div>
  <div class="tubi segment">
    <div class="push-right">
      <div class="tubi right pointing dropdown icon info button"> 
        <i class="settings icon"></i>
        <div class="menu">
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="item">Şarkı Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=albums" class="item">Albüm Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=artist-list" class="item">Sanatçı Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genres" class="item">Tür Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlists" class="item">Çalma Listesi Yönetimi</a>
        </div>
      </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=sector_add" class="tubi icon positive button"><i class="icon add"></i>Yeni Sektör Ekle</a>
    </div>
    <div class="tubi header">Sektör Listesi</div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th style="width: 30px;" class="disabled"></th>
          <th style="width: 80px;" class="disabled">ID</th>
          <th data-sort="string">Sektör Adı</th>
          <th style="width: 100px;" data-sort="int">Çalma Listesi Sayısı</th>
          <th style="width: 90px;" class="disabled">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$sectors):?>
        <tr>
          <td colspan="5"><?php echo Filter::msgInfo("<span>Henüz sektör eklenmemiş.</span>", false);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($sectors as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="int"><?php echo $row->id; ?></td>
          <td>
            <?php if($row->thumb):?>
            <a class="lightbox" href="<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>" title="<?php echo $row->{'title'.LANG::$lang};?>"> 
              <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>&amp;w=40&amp;h=40" alt="" class="tubi image">
            </a>
            <?php else:?>
              <i class="icon building"></i>
            <?php endif;?>
          </td>
          <td>
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=sector_playlists&amp;id=<?php echo $row->id;?>">
              <?php echo $row->{'title'.Lang::$lang};?>
            </a>
          </td>
          <td><?php echo $row->playlist_count; ?></td>
          <td>
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=sector_edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> 
            <a class="delete" data-title="<?php echo Lang::$word->_DELETE;?> Sektör" data-option="deleteSector" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title'.Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a>
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
    // Varsayılan olarak sektör listesini göster
    header("Location: index.php?do=modules&action=config&modname=muzibu&maction=sectors");
    break;
endswitch;
?>