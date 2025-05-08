<?php
/**
 * Muzibu Admin - Genre Section
 *
 * @package Muzibu Module
 * @author Nurullah Okatan
 * @copyright 2024
 */
if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

if (!$user->getAcl("muzibu")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;

switch(Filter::$maction): 
case "genre_edit": 
    $row = Core::getRowById(Muzibu::genreTable, Filter::$id);
?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> <i class="tag icon"></i>
  <div class="content">
    <div class="header">Müzik Türleri</div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section">Admin Paneli</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section">Modüller</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section">Müzik Türü Düzenle</div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?>Yıldız (<i class="icon asterisk"></i>) işaretli alanların doldurulması zorunludur.</div>
  <div class="tubi form segment">
    <div class="tubi header">Müzik Türü Bilgilerini Düzenle</div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post" enctype="multipart/form-data">
      <div class="two fields">
        <div class="field">
          <label>Tür Adı</label>
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
          <label>Tür Görseli</label>
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
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button">Müzik Türü Güncelle</button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genres" class="tubi basic button">İptal</a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processGenre" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php 
    break;

case "genre_add": 
?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> <i class="tag icon"></i>
  <div class="content">
    <div class="header">Müzik Türleri</div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section">Admin Paneli</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section">Modüller</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section">Yeni Müzik Türü Ekle</div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?>Yıldız (<i class="icon asterisk"></i>) işaretli alanların doldurulması zorunludur.</div>
  <div class="tubi form segment">
    <div class="tubi header">Müzik Türü Bilgileri</div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post" enctype="multipart/form-data">
      <div class="two fields">
        <div class="field">
          <label>Tür Adı</label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="Müzik Türü Adı" name="title<?php echo Lang::$lang;?>">
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
        <label>Tür Görseli</label>
        <label class="input">
          <input type="file" name="thumb" class="filefield">
        </label>
      </div>
      <div class="tubi double fitted divider"></div>
      <button type="button" name="dosubmit" class="tubi positive button">Müzik Türü Ekle</button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genres" class="tubi basic button">İptal</a>
      <input name="processGenre" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>
<?php
    break;

case "genres": 
    $genres = Registry::get("Muzibu")->getGenres();
?>
<div class="tubi icon heading message blue"> 
  <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> 
  <i class="tag icon"></i>
  <div class="content">
    <div class="header">Müzik Türü Yönetimi</div>
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
  <div class="tubi message"><?php echo Core::langIcon();?>Müzik türleri listesi ve yönetimi.</div>
  <div class="tubi segment">
    <div class="push-right">
      <div class="tubi right pointing dropdown icon info button"> 
        <i class="settings icon"></i>
        <div class="menu">
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="item">Şarkı Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=albums" class="item">Albüm Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=artist-list" class="item">Sanatçı Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=sectors" class="item">Sektör Yönetimi</a>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlists" class="item">Çalma Listesi Yönetimi</a>
        </div>
      </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genre_add" class="tubi icon positive button"><i class="icon add"></i>Yeni Müzik Türü Ekle</a>
    </div>
    <div class="tubi header">Müzik Türleri Listesi</div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th style="width: 30px;" class="disabled"></th>
          <th style="width: 80px;" class="disabled">ID</th>
          <th data-sort="string">Tür Adı</th>
          <th style="width: 100px;" data-sort="int">Şarkı Sayısı</th>
          <th style="width: 90px;" class="disabled">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$genres):?>
        <tr>
          <td colspan="5"><?php echo Filter::msgInfo("<span>Henüz müzik türü eklenmemiş.</span>", false);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($genres as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="int"><?php echo $row->id; ?></td>
          <td>
            <?php if($row->thumb):?>
            <a class="lightbox" href="<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>" title="<?php echo $row->{'title'.LANG::$lang};?>"> 
              <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>&amp;w=40&amp;h=40" alt="" class="tubi image">
            </a>
            <?php else:?>
              <i class="icon tag"></i>
            <?php endif;?>
          </td>
          <td>
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genre_songs&amp;id=<?php echo $row->id;?>">
              <?php echo $row->{'title'.Lang::$lang};?>
            </a>
          </td>
          <td><?php echo $row->song_count; ?></td>
          <td>
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genre_edit&amp;id=<?php echo $row->id;?>"><i class="rounded inverted success icon pencil link"></i></a> 
            <a class="delete" data-title="<?php echo Lang::$word->_DELETE;?> Müzik Türü" data-option="deleteGenre" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title'.Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a>
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
    // Varsayılan olarak müzik türleri listesini göster
    header("Location: index.php?do=modules&action=config&modname=muzibu&maction=genres");
    break;
endswitch;
?>