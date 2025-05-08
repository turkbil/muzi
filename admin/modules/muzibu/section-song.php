<?php
/**
 * Muzibu Admin - Song Section
 *
 * @package Muzibu Module
 * @author Nurullah Okatan
 * @copyright 2024
 */
if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

if (!$user->getAcl("muzibu")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;

switch(Filter::$maction): 
case "song_edit": 
    // Şarkı düzenleme kodları
    $row = Core::getRowById(Muzibu::mTable, Filter::$id);
    $albums = Registry::get("Muzibu")->getAlbums();
    $genres = Registry::get("Muzibu")->getGenres();
?>
<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> <i class="music icon"></i>
  <div class="content">
    <div class="header">Şarkılar</div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section">Admin Paneli</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section">Modüller</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section">Şarkı Düzenle</div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?>Yıldız (<i class="icon asterisk"></i>) işaretli alanların doldurulması zorunludur.</div>
  <div class="tubi form segment">
    <div class="tubi header">Şarkı Bilgilerini Düzenle</div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post" enctype="multipart/form-data">
      <div class="two fields">
        <div class="field">
          <label>Şarkı Adı</label>
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
          <label>Albüm</label>
          <select name="album_id">
            <option value="">Albüm Seçin</option>
            <?php if($albums):?>
            <?php foreach($albums as $album):?>
            <?php $sel = ($album->id == $row->album_id) ? ' selected="selected"' : '';?>
            <option value="<?php echo $album->id;?>"<?php echo $sel;?>><?php echo $album->{'title'.LANG::$lang};?> - <?php echo $album->artist_name;?></option>
            <?php endforeach;?>
            <?php unset($album);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <label>Müzik Türü</label>
          <select name="genre_id" required>
            <option value="">Tür Seçin</option>
            <?php if($genres):?>
            <?php foreach($genres as $genre):?>
            <?php $sel = ($genre->id == $row->genre_id) ? ' selected="selected"' : '';?>
            <option value="<?php echo $genre->id;?>"<?php echo $sel;?>><?php echo $genre->{'title'.LANG::$lang};?></option>
            <?php endforeach;?>
            <?php unset($genre);?>
            <?php endif;?>
          </select>
        </div>
      </div>
      <div class="field">
        <label>Şarkı Dosyası</label>
        <?php if($row->file_path):?>
        <div class="tubi small label">Mevcut dosya: <?php echo $row->file_path;?></div>
        <?php endif;?>
        <label class="input">
          <input type="file" name="song_file" class="filefield">
        </label>
      </div>
      <div class="two fields">
        <div class="field">
          <label>Süre (saniye)</label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="number" value="<?php echo $row->duration;?>" name="duration" min="1">
          </label>
        </div>
        <div class="field">
          <label>Öne Çıkarılan</label>
          <div class="inline-group">
            <label class="radio">
              <input type="radio" name="is_featured" value="1" <?php echo ($row->is_featured == 1) ? 'checked="checked"' : '';?>>
              <i></i>Evet</label>
            <label class="radio">
              <input type="radio" name="is_featured" value="0" <?php echo ($row->is_featured == 0) ? 'checked="checked"' : '';?>>
              <i></i>Hayır</label>
          </div>
        </div>
      </div>
      <div class="field">
        <label>Şarkı Sözleri</label>
        <textarea name="lyrics<?php echo LANG::$lang;?>"><?php echo isset($row->{'lyrics'.Lang::$lang}) ? Filter::out_url($row->{'lyrics'.Lang::$lang}) : ''; ?></textarea>
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
      <button type="button" name="dosubmit" class="tubi positive button">Şarkı Güncelle</button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="tubi basic button">İptal</a>
      <input name="id" type="hidden" value="<?php echo Filter::$id;?>">
      <input name="processSong" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>

<?php
    break;

case "song_add": 
    $albums = Registry::get("Muzibu")->getAlbums();
    $genres = Registry::get("Muzibu")->getGenres();
?>

<div class="tubi icon heading message blue"> <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> <i class="music icon"></i>
  <div class="content">
    <div class="header">Şarkılar</div>
    <div class="tubi breadcrumb"><i class="icon home"></i> <a href="index.php" class="section">Admin Paneli</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section">Modüller</a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section">Yeni Şarkı Ekle</div>
    </div>
  </div>
</div>
<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?>Yıldız (<i class="icon asterisk"></i>) işaretli alanların doldurulması zorunludur.</div>
  <div class="tubi form segment">
    <div class="tubi header">Şarkı Bilgileri</div>
    <div class="tubi double fitted divider"></div>
    <form id="tubi_form" name="tubi_form" method="post" enctype="multipart/form-data">
      <div class="two fields">
        <div class="field">
          <label>Şarkı Adı</label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="text" placeholder="Şarkı Adı" name="title<?php echo Lang::$lang;?>">
          </label>
        </div>
        <div class="field">
          <label>SEO URL</label>
          <label class="input">
            <input type="text" placeholder="SEO URL" name="slug">
          </label>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label>Albüm</label>
          <select name="album_id">
            <option value="">Albüm Seçin</option>
            <?php if($albums):?>
            <?php foreach($albums as $album):?>
            <option value="<?php echo $album->id;?>"><?php echo $album->{'title'.LANG::$lang};?> - <?php echo $album->artist_name;?></option>
            <?php endforeach;?>
            <?php unset($album);?>
            <?php endif;?>
          </select>
        </div>
        <div class="field">
          <label>Müzik Türü</label>
          <select name="genre_id" required>
            <option value="">Tür Seçin</option>
            <?php if($genres):?>
            <?php foreach($genres as $genre):?>
            <option value="<?php echo $genre->id;?>"><?php echo $genre->{'title'.LANG::$lang};?></option>
            <?php endforeach;?>
            <?php unset($genre);?>
            <?php endif;?>
          </select>
        </div>
      </div>
      <div class="field">
        <label>Şarkı Dosyası</label>
        <label class="input">
          <input type="file" name="song_file" class="filefield">
        </label>
      </div>
      <div class="two fields">
        <div class="field">
          <label>Süre (saniye)</label>
          <label class="input"><i class="icon-append icon asterisk"></i>
            <input type="number" placeholder="Süre (saniye olarak)" name="duration" min="1">
          </label>
        </div>
        <div class="field">
          <label>Öne Çıkarılan</label>
          <div class="inline-group">
            <label class="radio">
              <input type="radio" name="is_featured" value="1">
              <i></i>Evet</label>
            <label class="radio">
              <input type="radio" name="is_featured" value="0" checked="checked">
              <i></i>Hayır</label>
          </div>
        </div>
      </div>
      <div class="field">
        <label>Şarkı Sözleri</label>
        <textarea placeholder="Şarkı Sözleri" name="lyrics<?php echo LANG::$lang;?>"></textarea>
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
      <button type="button" name="dosubmit" class="tubi positive button">Şarkı Ekle</button>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="tubi basic button">İptal</a>
      <input name="processSong" type="hidden" value="1">
    </form>
  </div>
  <div id="msgholder"></div>
</div>

<?php
    break;

// Sanatçı filtreleme
case "artist_songs":
    $artist_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if(!$artist_id) redirect_to("index.php?do=modules&action=config&modname=muzibu");
    
    $artist = Registry::get("Muzibu")->artist->getArtistById($artist_id);
    if(!$artist) redirect_to("index.php?do=modules&action=config&modname=muzibu");
    
    // Önce sanatçının albümlerini getir
    $albums = Registry::get("Muzibu")->album->getAlbumsByArtist($artist_id);
    
    // Tüm ilişkili şarkıları getir (SQL sorgusu için admin_class_song.php'de getSongsByArtist methodu eklenmeli)
    $songs = Registry::get("Muzibu")->getSongsByArtist($artist_id);
?>

<div class="tubi icon heading message blue"> 
<a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> 
<i class="user icon"></i>
  <div class="content">
    <div class="header">Sanatçı Şarkıları: <?php echo $artist->{'title' . Lang::$lang}; ?></div>
    <div class="tubi breadcrumb">
      <i class="icon home"></i> 
      <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH; ?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS; ?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname); ?></a>
      <div class="divider"> / </div>
      <div class="active section">Sanatçı Şarkıları</div>
    </div>
  </div>
</div>

<div class="tubi-large-content">

<div class="tubi-grid">
<?php if ($albums): ?>
<div class="tubi segment">
  <div class="header">
    <h4><i class="music icon"></i> <?php echo $artist->{'title' . Lang::$lang}; ?> Albümleri</h4>
  </div>
  <div class="tubi fitted divider"></div>
  
  <div class="columns gutters">
    <?php foreach ($albums as $album): ?>
    <div class="screen-25 tablet-33 mobile-50 phone-100">
      <div class="tubi segment">
        <div class="tubi relative">
          <?php if ($album->thumb): ?>
          <img class="tubi rounded fluid image" src="<?php echo SITEURL . '/' . Muzibu::imagepath . $album->thumb; ?>" alt="<?php echo $album->{'title' . Lang::$lang}; ?>">
          <?php
        else: ?>
          <img class="tubi rounded fluid image" src="<?php echo SITEURL; ?>/modules/muzibu/assets/images/album-placeholder.jpg" alt="<?php echo $album->{'title' . Lang::$lang}; ?>">
          <?php
        endif; ?>
          <span class="tubi info circular label" style="position:absolute; top:10px; right:10px;"><?php echo $album->song_count; ?></span>
        </div>
        
        <h5 class="tubi header" style="margin-top: 10px;"><?php echo $album->{'title' . Lang::$lang}; ?></h5>
        <?php if (isset($album->{'description' . Lang::$lang}) && !empty($album->{'description' . Lang::$lang})): ?>
        <p class="tubi small text"><?php echo substr(strip_tags($album->{'description' . Lang::$lang}), 0, 100) . '...'; ?></p>
        <?php
        endif; ?>
        
        <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=album_songs&amp;id=<?php echo $album->id; ?>" class="tubi fluid info button" style="margin-top: 10px;">
          <i class="list icon"></i> Albüm Şarkılarını Gör
        </a>
      </div>
    </div>
    <?php
    endforeach; ?>
  </div>
</div>
<?php
else: ?>
<div class="tubi segment">
  <div class="tubi negative message">
    <i class="attention icon"></i>
    <div class="content">
      <div class="header">Albüm Bulunamadı</div>
      <p>Bu sanatçıya ait albüm bulunamamıştır.</p>
    </div>
  </div>
</div>
<?php
endif; ?>

<div class="tubi segment">
  <div class="tubi header"> <?php echo $artist->{'title' . Lang::$lang}; ?>  Tüm Şarkıları</div>
  <div class="tubi fitted divider"></div>
  <table class="tubi sortable table">
    <thead>
      <tr>
        <th data-sort="int">ID</th>
        <th data-sort="string">Şarkı Adı</th>
        <th data-sort="string">Albüm</th>
        <th data-sort="string">Tür</th>
        <th data-sort="int">Dinlenme</th>
        <th class="disabled">&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!$songs): ?>
      <tr>
        <td colspan="6"><?php echo Filter::msgInfo("<span>Bu sanatçıya ait şarkı bulunamadı.</span>", false); ?></td>
      </tr>
      <?php
else: ?>
      <?php foreach ($songs as $row): ?>
      <tr>
        <td style="width: 30px"><?php echo $row->id; ?></td>
        <td><?php echo $row->title_tr; ?></td>
        <td>
          <?php if ($row->album_id): ?>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=album_songs&amp;id=<?php echo $row->album_id; ?>">
            <?php echo $row->album_title; ?>
          </a>
          <?php
        else: ?>
            -
          <?php
        endif; ?>
        </td>
        <td>
          <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genre_songs&amp;id=<?php echo $row->genre_id; ?>">
            <?php echo $row->genre_title; ?>
          </a>
        </td>
        <td><?php echo $row->play_count; ?></td>
        <td style="width: 90px"><a href="<?php echo Core::url("modules", "song_edit", $row->id); ?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE . ' ' . Lang::$word->_MOD_PF_PROJECT; ?>" data-option="deleteSong" data-id="<?php echo $row->id; ?>" data-name="<?php echo $row->{'title' . Lang::$lang}; ?>"><i class="rounded danger inverted remove icon link"></i></a></td>
      </tr>
      <?php
    endforeach; ?>
      <?php unset($row); ?>
      <?php
endif; ?>
    </tbody>
  </table>
</div>
</div>

<?php
    break;

// Albüm filtreleme
case "album_songs":
    $album_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if(!$album_id) redirect_to("index.php?do=modules&action=config&modname=muzibu");
    
    $album = Registry::get("Muzibu")->album->getAlbumById($album_id);
    if(!$album) redirect_to("index.php?do=modules&action=config&modname=muzibu");
    
    // Albüm şarkılarını getir
    $songs = Registry::get("Muzibu")->renderAlbum($album_id);
?>
<div class="tubi icon heading message blue"> 
  <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> 
  <i class="album icon"></i>
  <div class="content">
    <div class="header">Albüm Şarkıları: <?php echo $album->{'title'.Lang::$lang}; ?></div>
    <div class="tubi breadcrumb">
      <i class="icon home"></i> 
      <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section">Albüm Şarkıları</div>
    </div>
  </div>
</div>

<div class="tubi-large-content">
  <div class="tubi raised segment">
    <div class="tubi grid">
      <div class="tubi two columns grid">
        <div class="column" style="width: 200px;">
          <?php if($album->thumb): ?>
          <figure class="tubi rounded image">
            <img src="<?php echo SITEURL . '/' . Muzibu::imagepath . $album->thumb; ?>" alt="<?php echo $album->{'title'.Lang::$lang}; ?>">
          </figure>
          <?php else: ?>
          <figure class="tubi rounded image">
            <img src="<?php echo SITEURL; ?>/modules/muzibu/assets/images/album-placeholder.jpg" alt="<?php echo $album->{'title'.Lang::$lang}; ?>">
          </figure>
          <?php endif; ?>
        </div>
        <div class="column" style="margin-top: 12px;">
          <h2 class="tubi header"><?php echo $album->{'title'.Lang::$lang}; ?>
            <div class="tubi positive horizontal label">
              <?php 
                $songCount = 0;
                if(isset($songs) && is_array($songs)) {
                  $songCount = count($songs);
                }
              ?>
              <?php echo $songCount; ?> Şarkı
            </div></h2>
          <div class="tubi divider"></div>
          <div class="tubi meta">
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=artist_songs&amp;id=<?php echo $album->artist_id; ?>" class="tubi labeled icon button">
              <i class="user icon"></i> <?php echo $album->artist_name; ?>
            </a>
          </div>
          <div class="tubi basic divider"></div>
          <div class="tubi description">
            <?php echo isset($album->{'description'.Lang::$lang}) ? $album->{'description'.Lang::$lang} : ''; ?>
          </div>
          <div class="tubi basic divider"></div>
          <div class="tubi buttons">
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=album_edit&amp;id=<?php echo $album->id; ?>" class="tubi positive button">
              <i class="pencil icon"></i> Albümü Düzenle
            </a>
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=song_add" class="tubi info button">
              <i class="plus icon"></i> Yeni Şarkı Ekle
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="tubi segment">
    <div class="tubi header"><?php echo $album->{'title'.Lang::$lang}; ?> Albümündeki Şarkılar</div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th data-sort="int" style="width: 30px;">ID</th>
          <th data-sort="string">Şarkı Adı</th>
          <th data-sort="string"style="width: 200px;">Tür</th>
          <th data-sort="int" style="width: 120px;">Süre</th>
          <th data-sort="int" style="width: 120px;">Dinlenme</th>
          <th class="disabled" style="width: 90px;">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$songs):?>
        <tr>
          <td colspan="6"><?php echo Filter::msgInfo("<span>Bu albümde henüz şarkı eklenmemiş.</span>", false);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($songs as $row):?>
        <tr>
          <td style="width: 30px"><?php echo $row->id;?></td>
          <td><?php echo $row->title_tr;?></td>
          <td>
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genre_songs&amp;id=<?php echo $row->genre_id; ?>">
              <?php echo $row->genre_name;?>
            </a>
          </td>
          <td><?php echo gmdate("i:s", $row->duration);?></td>
          <td><?php echo $row->play_count;?></td>
          <td style="width: 90px"><a href="<?php echo Core::url("modules", "song_edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_PF_PROJECT;?>" data-option="deleteSong" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
</div>
<?php
    break;

// Tür filtreleme
case "genre_songs":
    $genre_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if(!$genre_id) redirect_to("index.php?do=modules&action=config&modname=muzibu");
    
    $genre = Registry::get("Muzibu")->genre->getGenreById($genre_id);
    if(!$genre) redirect_to("index.php?do=modules&action=config&modname=muzibu");
    
    // Tür şarkılarını getir (admin_class.php'de getSongsByGenre methodu eklenmeli)
    $songs = Registry::get("Muzibu")->getSongsByGenre($genre_id);
?>
<div class="tubi icon heading message blue"> 
  <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> 
  <i class="tag icon"></i>
  <div class="content">
    <div class="header">Tür Şarkıları: <?php echo $genre->{'title'.Lang::$lang}; ?></div>
    <div class="tubi breadcrumb">
      <i class="icon home"></i> 
      <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <div class="active section">Tür Şarkıları</div>
    </div>
  </div>
</div>

<div class="tubi-large-content">
  <div class="tubi segment">
    <div class="push-right">
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genre_edit&amp;id=<?php echo $genre->id; ?>" class="tubi icon positive button">
          <i class="pencil icon"></i> Türü Düzenle
        </a>
    </div>
    <div class="tubi header"><?php echo $genre->{'title'.Lang::$lang}; ?> Türündeki Şarkılar</div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th data-sort="int">ID</th>
          <th data-sort="string">Şarkı Adı</th>
          <th data-sort="string">Sanatçı</th>
          <th data-sort="string">Albüm</th>
          <th data-sort="int">Dinlenme</th>
          <th class="disabled">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$songs):?>
        <tr>
          <td colspan="6"><?php echo Filter::msgInfo("<span>Bu türde henüz şarkı eklenmemiş.</span>", false);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($songs as $row):?>
        <tr>
          <td style="width: 30px"><?php echo $row->id;?></td>
          <td><?php echo $row->title_tr;?></td>
          <td>
            <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=artist_songs&amp;id=<?php echo $row->artist_id; ?>">
              <?php echo $row->artist_title;?>
            </a>
            </td>
         <td>
           <?php if($row->album_id): ?>
           <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=album_songs&amp;id=<?php echo $row->album_id; ?>">
             <?php echo $row->album_title;?>
           </a>
           <?php else: ?>
             -
           <?php endif; ?>
         </td>
         <td><?php echo $row->play_count;?></td>
         <td style="width: 90px"><a href="<?php echo Core::url("modules", "song_edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_PF_PROJECT;?>" data-option="deleteSong" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
       </tr>
       <?php endforeach;?>
       <?php unset($row);?>
       <?php endif;?>
     </tbody>
   </table>
 </div>
</div>
<?php
   break;

// Kullanıcı filtreleme (playlistler)
case "user_playlists":
  $user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
  if(!$user_id) redirect_to("index.php?do=modules&action=config&modname=muzibu&maction=playlists");
  
  $user = Core::getRowById("users", $user_id);
  if(!$user) redirect_to("index.php?do=modules&action=config&modname=muzibu&maction=playlists");
  
  // Kullanıcı playlistlerini getir
  $playlists = Registry::get("Muzibu")->playlist->getPlaylistsByUser($user_id);
?>
<div class="tubi icon heading message blue"> 
  <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> 
  <i class="user icon"></i>
  <div class="content">
    <div class="header">Kullanıcı Çalma Listeleri: <?php echo isset($user->username) && !empty($user->username) ? $user->username : (isset($user->fname) && !empty($user->fname) ? $user->fname.' '.$user->lname : 'Kullanıcı: '.$user_id); ?></div>
    <div class="tubi breadcrumb">
      <i class="icon home"></i> 
      <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlists" class="section">Çalma Listeleri</a>
      <div class="divider"> / </div>
      <div class="active section">Kullanıcı Çalma Listeleri</div>
    </div>
  </div>
</div>

<div class="tubi-large-content">
  <div class="tubi segment">
    <div class="push-right">
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlist_add" class="tubi icon positive button"><i class="icon add"></i>Yeni Çalma Listesi Ekle</a>
    </div>
    <div class="tubi header"><?php echo isset($user->username) && !empty($user->username) ? $user->username : (isset($user->fname) && !empty($user->fname) ? $user->fname.' '.$user->lname : 'Kullanıcı: '.$user_id); ?> Kullanıcısının Çalma Listeleri</div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th style="width: 30px;" class="disabled"></th>
          <th style="width: 80px;" class="disabled">ID</th>
          <th data-sort="string">Liste Adı</th>
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
          <td colspan="8"><?php echo Filter::msgInfo("<span>Bu kullanıcıya ait çalma listesi bulunamadı.</span>", false);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($playlists as $row):?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="int"><?php echo $row->id; ?></td>
          <td>
            <?php if(isset($row->thumb) && $row->thumb):?>
            <a class="lightbox" href="<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>" title="<?php echo $row->{'title'.LANG::$lang};?>"> 
              <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>&amp;w=40&amp;h=40" alt="" class="tubi image">
            </a>
            <?php else:?>
              <i class="icon list"></i>
            <?php endif;?>
          </td>
          <td><?php echo $row->{'title'.Lang::$lang};?></td>
          <td><?php echo isset($row->song_count) ? $row->song_count : '0'; ?></td>
          <td><?php echo (isset($row->system) && $row->system) ? '<i class="positive icon check"></i>' : '<i class="negative icon cancel"></i>';?></td>
          <td><?php echo (isset($row->is_public) && $row->is_public) ? '<i class="positive icon check"></i>' : '<i class="negative icon cancel"></i>';?></td>
          <td><?php echo (isset($row->active) && $row->active) ? '<i class="positive icon check"></i>' : '<i class="negative icon cancel"></i>';?></td>
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
</div>
<?php
   break;
   case "sector_playlists":
    $sector_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if(!$sector_id) redirect_to("index.php?do=modules&action=config&modname=muzibu&maction=sectors");
    
    $sector = Registry::get("Muzibu")->sector->getSectorById($sector_id);
    if(!$sector) redirect_to("index.php?do=modules&action=config&modname=muzibu&maction=sectors");
    
    // Sektör playlistlerini getir
    $playlists = Registry::get("Muzibu")->sector->getPlaylistsBySector($sector_id);
 ?>
 <div class="tubi icon heading message blue"> 
  <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> 
  <i class="building icon"></i>
  <div class="content">
    <div class="header">Sektör Çalma Listeleri: <?php echo $sector->{'title'.Lang::$lang}; ?></div>
    <div class="tubi breadcrumb">
      <i class="icon home"></i> 
      <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=sectors" class="section">Sektörler</a>
      <div class="divider"> / </div>
      <div class="active section">Sektör Çalma Listeleri</div>
    </div>
  </div>
 </div>
 
 <div class="tubi-large-content">
  <div class="tubi segment">
    <div class="push-right">
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=sector_edit&amp;id=<?php echo $sector_id; ?>" class="tubi positive button">
        <i class="edit icon"></i> Sektörü Düzenle
      </a>
    </div>
    <div class="tubi header">Sektörün Çalma Listeleri</div>
    <div class="tubi fitted divider"></div>
    <table class="tubi sortable table">
      <thead>
        <tr>
          <th style="width: 30px;" class="disabled">ID</th>
          <th style="width: 80px;" class="disabled"></th>
          <th data-sort="string">Liste Adı</th>
          <th data-sort="string" style="width: 220px;">Oluşturan</th>
          <th style="width: 100px;" data-sort="int">Şarkı Sayısı</th>
          <th style="width: 100px;" data-sort="int">Aktif</th>
          <th style="width: 130px;" class="disabled">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$playlists):?>
        <tr>
          <td colspan="7"><?php echo Filter::msgInfo("<span>Bu sektöre ait çalma listesi bulunamadı.</span>", false);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($playlists as $row):?>
        <?php 
          // Her playlist için şarkı sayısını özel olarak hesapla
          $playlistSongCount = 0;
          $countQuery = "SELECT COUNT(*) as total FROM " . Muzibu::playlistSongTable . " WHERE playlist_id = " . $row->id;
          $countResult = Registry::get("Database")->first($countQuery);
          if ($countResult && isset($countResult->total)) {
              $playlistSongCount = $countResult->total;
          }
        ?>
        <tr id="node-<?php echo $row->id;?>">
          <td class="int"><?php echo $row->id; ?></td>
          <td>
            <?php if(isset($row->thumb) && $row->thumb):?>
            <a class="lightbox" href="<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>" title="<?php echo $row->{'title'.LANG::$lang};?>"> 
              <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/' . Muzibu::imagepath . $row->thumb;?>&amp;w=40&amp;h=40" alt="" class="tubi image">
            </a>
            <?php else:?>
              <i class="icon list"></i>
            <?php endif;?>
          </td>
          <td><?php echo $row->{'title'.Lang::$lang};?> (Playlist)</td>
          <td>admin</td>
          <td><?php echo $playlistSongCount; ?></td>
          <td><?php echo (isset($row->active) && $row->active) ? '<i class="positive icon check"></i>' : '<i class="negative icon cancel"></i>';?></td>
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
 </div>
 <?php
    break;

default: 
   // Şarkı listesi sayfası
   $songs = Registry::get("Muzibu")->getSongs();
   $pager = Paginator::instance();
?>
<div class="tubi icon heading message blue"> 
 <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> 
 <i class="music icon"></i>
 <div class="content">
   <div class="header">Şarkı Yönetimi</div>
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
 <div class="tubi segment">
   <div class="push-right">
     <div class="tubi right pointing dropdown icon info button"> 
       <i class="settings icon"></i>
       <div class="menu">
         <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=artist-list" class="item">Sanatçı Yönetimi</a>
         <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=albums" class="item">Albüm Yönetimi</a>
         <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genres" class="item">Tür Yönetimi</a>
         <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=sectors" class="item">Sektör Yönetimi</a>
         <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlists" class="item">Çalma Listesi Yönetimi</a>
       </div>
     </div>
     <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=song_add" class="tubi icon positive button"><i class="icon add"></i>Yeni Şarkı Ekle</a>
   </div>
   <div class="tubi header">Şarkı Listesi</div>
   <div class="tubi fitted divider"></div>
   <table class="tubi sortable table">
     <thead>
       <tr>
         <th data-sort="int">ID</th>
         <th data-sort="string">Şarkı Adı</th>
         <th data-sort="string">Sanatçı</th>
         <th data-sort="string">Albüm</th>
         <th data-sort="string">Tür</th>
         <th data-sort="int">Dinlenme</th>
         <th class="disabled">&nbsp;</th>
       </tr>
     </thead>
     <tbody>
       <?php if(!$songs):?>
       <tr>
         <td colspan="8"><?php echo Filter::msgInfo("<span>Henüz şarkı eklenmemiş.</span>", false);?></td>
       </tr>
       <?php else:?>
       <?php foreach ($songs as $row):?>
       <tr>
         <td style="width: 30px"><?php echo $row->id;?></td>
         <td><?php echo $row->title_tr;?></td>
         <td>
           <?php if(isset($row->artist_id) && $row->artist_id): ?>
           <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=artist_songs&amp;id=<?php echo $row->artist_id; ?>">
             <?php echo $row->artist_title;?>
           </a>
           <?php else: ?>
             -
           <?php endif; ?>
         </td>
         <td>
           <?php if($row->album_id): ?>
           <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=album_songs&amp;id=<?php echo $row->album_id; ?>">
             <?php echo $row->album_title;?>
           </a>
           <?php else: ?>
             -
           <?php endif; ?>
         </td>
         <td>
           <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=genre_songs&amp;id=<?php echo $row->genre_id; ?>">
             <?php echo $row->genre_title;?>
           </a>
         </td>
         <td><?php echo $row->play_count;?></td>
         <td style="width: 90px"><a href="<?php echo Core::url("modules", "song_edit", $row->id);?>"><i class="rounded inverted success icon pencil link"></i></a> <a class="delete" data-title="<?php echo Lang::$word->_DELETE.' '.Lang::$word->_MOD_PF_PROJECT;?>" data-option="deleteSong" data-id="<?php echo $row->id;?>" data-name="<?php echo $row->{'title' . Lang::$lang};?>"><i class="rounded danger inverted remove icon link"></i></a></td>
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
endswitch;
?>