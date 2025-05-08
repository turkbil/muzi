<?php
  /**
   * Main Dashboard
   *
   * @yazilim CMS PRO
   * @web adresi turkbilisim.com.tr
   * @copyright 2024
   * @version $Id: main.php, v1.00 2024-03-02 12:00:00 
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  // Veritabanı bağlantısı
  $db = Registry::get("Database");
  
  // Toplam sayıları al
  $totalSongs = countEntries("muzibu_songs");
  $totalArtists = countEntries("muzibu_artists");
  $totalAlbums = countEntries("muzibu_albums");
  $totalGenres = countEntries("muzibu_genres");
  $totalSectors = countEntries("muzibu_sectors");
  $totalPlaylists = countEntries("muzibu_playlists");
  
  // Gelişmiş istatistikler
  // Toplam şarkı süresi (saniye cinsinden)
  $totalDurationQuery = "SELECT SUM(duration) as total_duration FROM muzibu_songs";
  $totalDurationResult = $db->first($totalDurationQuery);
  $totalDuration = $totalDurationResult ? $totalDurationResult->total_duration : 0;
  
  // Saat:dakika:saniye formatına dönüştür
  $hours = floor($totalDuration / 3600);
  $minutes = floor(($totalDuration % 3600) / 60);
  $seconds = $totalDuration % 60;
  $formattedDuration = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
  
  // Toplam çalınma sayısı
  $totalPlaysQuery = "SELECT SUM(play_count) as total_plays FROM muzibu_songs";
  $totalPlaysResult = $db->first($totalPlaysQuery);
  $totalPlays = $totalPlaysResult ? $totalPlaysResult->total_plays : 0;
  
  // Son hafta istatistikleri
  $lastWeekDate = date('Y-m-d H:i:s', strtotime('-1 week'));
  
  // Bu hafta eklenen şarkı sayısı
  $songsThisWeekQuery = "SELECT COUNT(*) as count FROM muzibu_songs WHERE created >= '$lastWeekDate'";
  $songsThisWeekResult = $db->first($songsThisWeekQuery);
  $songsThisWeek = $songsThisWeekResult ? $songsThisWeekResult->count : 0;
  
  // Bu hafta dinlenen şarkı sayısı
  $playsThisWeekQuery = "SELECT COUNT(*) as count FROM muzibu_song_plays WHERE created >= '$lastWeekDate'";
  $playsThisWeekResult = $db->first($playsThisWeekQuery);
  $playsThisWeek = $playsThisWeekResult ? $playsThisWeekResult->count : 0;
  
  // Bu hafta aktif olan kullanıcı sayısı
  $activeUsersThisWeekQuery = "SELECT COUNT(DISTINCT user_id) as count FROM muzibu_song_plays WHERE created >= '$lastWeekDate' AND user_id IS NOT NULL";
  $activeUsersThisWeekResult = $db->first($activeUsersThisWeekQuery);
  $activeUsersThisWeek = $activeUsersThisWeekResult ? $activeUsersThisWeekResult->count : 0;
  
  // En son dinlenen 5 şarkı
  $lastPlayedSongsQuery = "SELECT sp.*, s.title" . Lang::$lang . " as song_title, a.title" . Lang::$lang . " as artist_name, al.title" . Lang::$lang . " as album_title, al.thumb as album_thumb
                         FROM muzibu_song_plays as sp 
                         LEFT JOIN muzibu_songs as s ON s.id = sp.song_id 
                         LEFT JOIN muzibu_albums as al ON al.id = s.album_id 
                         LEFT JOIN muzibu_artists as a ON a.id = al.artist_id 
                         ORDER BY sp.created DESC LIMIT 5";
  $lastPlayedSongs = $db->fetch_all($lastPlayedSongsQuery);
  
  // En çok favorilenen 5 şarkı
  $topFavoritedSongsQuery = "SELECT s.id, s.title" . Lang::$lang . " as song_title, a.title" . Lang::$lang . " as artist_name, al.title" . Lang::$lang . " as album_title, al.thumb as album_thumb, COUNT(f.id) as favorite_count 
                           FROM muzibu_songs as s 
                           LEFT JOIN muzibu_favorites as f ON f.song_id = s.id 
                           LEFT JOIN muzibu_albums as al ON al.id = s.album_id 
                           LEFT JOIN muzibu_artists as a ON a.id = al.artist_id 
                           GROUP BY s.id 
                           ORDER BY favorite_count DESC LIMIT 5";
  $topFavoritedSongs = $db->fetch_all($topFavoritedSongsQuery);
  
  // En popüler şarkı
  $mostPlayedSongQuery = "SELECT s.*, al.thumb as album_thumb, al.title" . Lang::$lang . " as album_title, a.title" . Lang::$lang . " as artist_name 
                        FROM muzibu_songs as s 
                        LEFT JOIN muzibu_albums as al ON al.id = s.album_id 
                        LEFT JOIN muzibu_artists as a ON a.id = al.artist_id 
                        ORDER BY s.play_count DESC LIMIT 1";
  $mostPlayedSong = $db->first($mostPlayedSongQuery);
  
  // En yeni eklenen şarkı
  $newestSongQuery = "SELECT s.*, a.title" . Lang::$lang . " as artist_name, al.thumb as album_thumb, al.title" . Lang::$lang . " as album_title
                    FROM muzibu_songs as s 
                    LEFT JOIN muzibu_albums as al ON al.id = s.album_id 
                    LEFT JOIN muzibu_artists as a ON a.id = al.artist_id 
                    ORDER BY s.created DESC LIMIT 1";
  $newestSong = $db->first($newestSongQuery);
  
  // En çok favorilenen şarkı
  $mostFavoritedQuery = "SELECT s.*, COUNT(f.id) as favorite_count, a.title" . Lang::$lang . " as artist_name, al.thumb as album_thumb, al.title" . Lang::$lang . " as album_title
                        FROM muzibu_songs as s 
                        LEFT JOIN muzibu_favorites as f ON f.song_id = s.id 
                        LEFT JOIN muzibu_albums as al ON al.id = s.album_id 
                        LEFT JOIN muzibu_artists as a ON a.id = al.artist_id 
                        GROUP BY s.id 
                        ORDER BY favorite_count DESC LIMIT 1";
  $mostFavorited = $db->first($mostFavoritedQuery);
  
  // En çok şarkıya sahip playlist
  $biggestPlaylistQuery = "SELECT p.*, COUNT(ps.song_id) as song_count 
                          FROM muzibu_playlists as p 
                          LEFT JOIN muzibu_playlist_song as ps ON ps.playlist_id = p.id 
                          GROUP BY p.id 
                          ORDER BY song_count DESC LIMIT 1";
  $biggestPlaylist = $db->first($biggestPlaylistQuery);
?>

<div class="tubi icon heading message red"> 
  <i class="fa fa-home"></i>
  <div class="content">
    <div class="header"> <?php echo Lang::$word->_MN_TITLE;?> </div>
  </div>
</div>

<div class="tubi-large-content">
  <!-- Müzik Yönetim Kartları -->
  <div style="max-width: 1200px; margin: 0 auto;">
    <div class="tubi-grid">
      <div class="two columns small-horizontal-gutters">
        <!-- Sol Kolon - 3 Ana Kart -->
        <div class="row">
          <!-- Muzibu Yönetimi Kartı -->
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 15px; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; margin-bottom: 10px;">
              <div style="width: 70px; text-align: center; margin-right: 15px;">
                <i class="music icon" style="font-size: 32px;"></i>
              </div>
              <div>
                <h3 style="margin: 0; font-size: 18px; color: #333;">Muzibu Yönetimi</h3>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;"><?php echo $totalSongs; ?> kayıtlı şarkı</p>
              </div>
            </div>
            <div style="display: flex; gap: 5px;">
              <a href="index.php?do=modules&action=config&modname=muzibu" style="flex: 1; background-color: #3498DB; color: #fff; text-align: center; padding: 10px 0; border-radius: 3px; text-decoration: none; font-size: 14px;">Şarkı Listesi</a>
              <a href="index.php?do=modules&action=config&modname=muzibu&maction=song_add" style="flex: 1; background-color: #3498DB; color: #fff; text-align: center; padding: 10px 0; border-radius: 3px; text-decoration: none; font-size: 14px;">Yeni Şarkı Ekle</a>
            </div>
          </div>

          <!-- Sanatçı Yönetimi Kartı -->
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 15px; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; margin-bottom: 10px;">
              <div style="width: 70px; text-align: center; margin-right: 15px;">
                <i class="user icon" style="font-size: 32px;"></i>
              </div>
              <div>
                <h3 style="margin: 0; font-size: 18px; color: #333;">Sanatçı Yönetimi</h3>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;"><?php echo $totalArtists; ?> kayıtlı sanatçı</p>
              </div>
            </div>
            <div style="display: flex; gap: 5px;">
              <a href="index.php?do=modules&action=config&modname=muzibu&maction=artist-list" style="flex: 1; background-color: #3498DB; color: #fff; text-align: center; padding: 10px 0; border-radius: 3px; text-decoration: none; font-size: 14px;">Sanatçı Listesi</a>
              <a href="index.php?do=modules&action=config&modname=muzibu&maction=artist-add" style="flex: 1; background-color: #3498DB; color: #fff; text-align: center; padding: 10px 0; border-radius: 3px; text-decoration: none; font-size: 14px;">Yeni Sanatçı Ekle</a>
            </div>
          </div>

          <!-- Albüm Yönetimi Kartı -->
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 15px; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; margin-bottom: 10px;">
              <div style="width: 70px; text-align: center; margin-right: 15px;">
                <i class="disk icon" style="font-size: 32px;"></i>
              </div>
              <div>
                <h3 style="margin: 0; font-size: 18px; color: #333;">Albüm Yönetimi</h3>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;"><?php echo $totalAlbums; ?> kayıtlı albüm</p>
              </div>
            </div>
            <div style="display: flex; gap: 5px;">
              <a href="index.php?do=modules&action=config&modname=muzibu&maction=albums" style="flex: 1; background-color: #3498DB; color: #fff; text-align: center; padding: 10px 0; border-radius: 3px; text-decoration: none; font-size: 14px;">Albüm Listesi</a>
              <a href="index.php?do=modules&action=config&modname=muzibu&maction=album_add" style="flex: 1; background-color: #3498DB; color: #fff; text-align: center; padding: 10px 0; border-radius: 3px; text-decoration: none; font-size: 14px;">Yeni Albüm Ekle</a>
            </div>
          </div>
        </div>

        <!-- Sağ Kolon - 3 Diğer Kart -->
        <div class="row">
          <!-- Müzik Türleri Kartı -->
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 15px; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; margin-bottom: 10px;">
              <div style="width: 70px; text-align: center; margin-right: 15px;">
                <i class="tag icon" style="font-size: 32px;"></i>
              </div>
              <div>
                <h3 style="margin: 0; font-size: 18px; color: #333;">Müzik Türleri</h3>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;"><?php echo $totalGenres; ?> türde müzik</p>
              </div>
            </div>
            <div style="display: flex; gap: 5px;">
              <a href="index.php?do=modules&action=config&modname=muzibu&maction=genres" style="flex: 1; background-color: #3498DB; color: #fff; text-align: center; padding: 10px 0; border-radius: 3px; text-decoration: none; font-size: 14px;">Tür Listesi</a>
              <a href="index.php?do=modules&action=config&modname=muzibu&maction=genre_add" style="flex: 1; background-color: #3498DB; color: #fff; text-align: center; padding: 10px 0; border-radius: 3px; text-decoration: none; font-size: 14px;">Yeni Tür Ekle</a>
            </div>
          </div>

          <!-- Sektör Yönetimi Kartı -->
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 15px; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; margin-bottom: 10px;">
              <div style="width: 70px; text-align: center; margin-right: 15px;">
                <i class="industry icon" style="font-size: 32px;"></i>
              </div>
              <div>
                <h3 style="margin: 0; font-size: 18px; color: #333;">Sektör Yönetimi</h3>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;"><?php echo $totalSectors; ?> sektör tanımlı</p>
              </div>
            </div>
            <div style="display: flex; gap: 5px;">
              <a href="index.php?do=modules&action=config&modname=muzibu&maction=sectors" style="flex: 1; background-color: #3498DB; color: #fff; text-align: center; padding: 10px 0; border-radius: 3px; text-decoration: none; font-size: 14px;">Sektör Listesi</a>
              <a href="index.php?do=modules&action=config&modname=muzibu&maction=sector_add" style="flex: 1; background-color: #3498DB; color: #fff; text-align: center; padding: 10px 0; border-radius: 3px; text-decoration: none; font-size: 14px;">Yeni Sektör Ekle</a>
            </div>
          </div>

          <!-- Çalma Listeleri Kartı -->
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 15px; margin-bottom: 15px;">
            <div style="display: flex; align-items: center; margin-bottom: 10px;">
              <div style="width: 70px; text-align: center; margin-right: 15px;">
                <i class="list icon" style="font-size: 32px;"></i>
              </div>
              <div>
                <h3 style="margin: 0; font-size: 18px; color: #333;">Çalma Listeleri</h3>
                <p style="margin: 5px 0 0 0; color: #666; font-size: 13px;"><?php echo $totalPlaylists; ?> çalma listesi</p>
              </div>
            </div>
            <div style="display: flex; gap: 5px;">
              <a href="index.php?do=modules&action=config&modname=muzibu&maction=playlists" style="flex: 1; background-color: #3498DB; color: #fff; text-align: center; padding: 10px 0; border-radius: 3px; text-decoration: none; font-size: 14px;">Liste Yönetimi</a>
              <a href="index.php?do=modules&action=config&modname=muzibu&maction=playlist_add" style="flex: 1; background-color: #3498DB; color: #fff; text-align: center; padding: 10px 0; border-radius: 3px; text-decoration: none; font-size: 14px;">Yeni Liste Ekle</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Genel İstatistikler -->
    <div style="margin-top: 5px; margin-bottom: 20px;">
      <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 15px;">
        <h3 style="margin: 0 0 15px 0; font-size: 16px; color: #333; border-bottom: 1px solid #E0E0E0; padding-bottom: 8px;">
          <i class="chart line icon" style="font-size: 24px;"></i> Genel İstatistikler
        </h3>
        
        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
          <!-- Toplam Şarkı Süresi -->
          <div style="flex: 1; min-width: 170px; background-color: #FFFFFF; padding: 10px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center;">
              <div style="width: 60px; text-align: center; margin-right: 10px;">
                <i class="time icon" style="font-size: 32px;"></i>
              </div>
              <div>
                <div style="font-size: 22px; font-weight: 600; color: #333;"><?php echo $formattedDuration; ?></div>
                <div style="font-size: 12px; color: #666;">Toplam Şarkı Süresi</div>
              </div>
            </div>
          </div>
          
          <!-- Toplam Çalınma -->
          <div style="flex: 1; min-width: 170px; background-color: #FFFFFF; padding: 10px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center;">
              <div style="width: 60px; text-align: center; margin-right: 10px;">
                <i class="play circle icon" style="font-size: 32px;"></i>
              </div>
              <div>
                <div style="font-size: 22px; font-weight: 600; color: #333;"><?php echo number_format($totalPlays); ?></div>
                <div style="font-size: 12px; color: #666;">Toplam Dinlenme Sayısı</div>
              </div>
            </div>
          </div>
          
          <!-- Bu Hafta Eklenen Şarkı Sayısı -->
          <div style="flex: 1; min-width: 170px; background-color: #FFFFFF; padding: 10px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center;">
              <div style="width: 60px; text-align: center; margin-right: 10px;">
                <i class="add icon" style="font-size: 32px;"></i>
              </div>
              <div>
                <div style="font-size: 22px; font-weight: 600; color: #333;"><?php echo number_format($songsThisWeek); ?></div>
                <div style="font-size: 12px; color: #666;">Eklenen Şarkılar</div>
              </div>
            </div>
          </div>
          
          <!-- Bu Hafta Dinlenen Şarkı Sayısı -->
          <div style="flex: 1; min-width: 170px; background-color: #FFFFFF; padding: 10px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center;">
              <div style="width: 60px; text-align: center; margin-right: 10px;">
                <i class="headphones icon" style="font-size: 32px;"></i>
              </div>
              <div>
                <div style="font-size: 22px; font-weight: 600; color: #333;"><?php echo number_format($playsThisWeek); ?></div>
                <div style="font-size: 12px; color: #666;">Dinlenen Şarkılar</div>
              </div>
            </div>
          </div>
          
          <!-- Bu Hafta Aktif Olan Kullanıcı Sayısı -->
          <div style="flex: 1; min-width: 170px; background-color: #FFFFFF; padding: 10px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center;">
              <div style="width: 60px; text-align: center; margin-right: 10px;">
                <i class="users icon" style="font-size: 32px;"></i>
              </div>
              <div>
                <div style="font-size: 22px; font-weight: 600; color: #333;"><?php echo number_format($activeUsersThisWeek); ?></div>
                <div style="font-size: 12px; color: #666;">Aktif Kullanıcılar</div>
              </div>
            </div>
          </div>
        </div>

        
        <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 15px; margin-bottom: 1px;">
          <!-- En Çok Dinlenen Şarkı -->
          <?php if($mostPlayedSong): ?>
          <div style="flex: 1; min-width: 250px; background-color: #FFFFFF; padding: 15px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center;">
              <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/modules/muzibu/dataimages/' . $mostPlayedSong->album_thumb;?>&amp;w=30&amp;h=30" style="border-radius: 3px; margin-right: 15px;" onerror="this.src='<?php echo SITEURL; ?>/assets/images/default_album.jpg'">
              <div>
                <div style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;"><?php echo $mostPlayedSong->{'title'.Lang::$lang}; ?></div>
                <div style="font-size: 13px; color: #666; margin-bottom: 3px;"><?php echo $mostPlayedSong->artist_name; ?></div>
                <div style="font-size: 12px; color: #888;"><i class="play circle icon"></i> En Çok Dinlenen Şarkı (<?php echo number_format($mostPlayedSong->play_count); ?> kez)</div>
              </div>
            </div>
          </div>
          <?php endif; ?>
          
          <!-- En Çok Favorilenen Şarkı -->
          <?php if($mostFavorited): ?>
          <div style="flex: 1; min-width: 250px; background-color: #FFFFFF; padding: 15px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center;">
              <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/modules/muzibu/dataimages/' . $mostFavorited->album_thumb;?>&amp;w=30&amp;h=30" style="border-radius: 3px; margin-right: 15px;" onerror="this.src='<?php echo SITEURL; ?>/assets/images/default_album.jpg'">
              <div>
                <div style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;"><?php echo $mostFavorited->{'title'.Lang::$lang}; ?></div>
                <div style="font-size: 13px; color: #666; margin-bottom: 3px;"><?php echo $mostFavorited->artist_name; ?></div>
                <div style="font-size: 12px; color: #888;"><i class="heart icon"></i> En Çok Favorilenen Şarkı (<?php echo number_format($mostFavorited->favorite_count); ?> kez)</div>
              </div>
            </div>
          </div>
          <?php endif; ?>
          
          <!-- En Büyük Playlist -->
          <?php if($biggestPlaylist): ?>
          <div style="flex: 1; min-width: 250px; background-color: #FFFFFF; padding: 15px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center;">
              <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/modules/muzibu/dataimages/' . ($biggestPlaylist->thumb ?? $newestSong->album_thumb);?>&amp;w=30&amp;h=30" style="border-radius: 3px; margin-right: 15px;" onerror="this.src='<?php echo SITEURL; ?>/assets/images/default_album.jpg'">
              <div>
                <div style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 200px;"><?php echo $biggestPlaylist->{'title'.Lang::$lang}; ?></div>
                <div style="font-size: 13px; color: #666; margin-bottom: 3px;"><?php echo $biggestPlaylist->song_count; ?> şarkı</div>
                <div style="font-size: 12px; color: #888;"><i class="list icon"></i> En Büyük Playlist</div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    
    <!-- Müzik İstatistikleri -->
    <div class="tubi-grid">
      <div class="two columns small-horizontal-gutters">
        <!-- En Son Dinlenen Şarkılar -->
        <div class="row">
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 10px; margin-bottom: 15px;">
            <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #333; display: flex; align-items: center; border-bottom: 1px solid #E0E0E0; padding-bottom: 8px;">
              <i class="list ordered icon" style="font-size: 24px;"></i> En Son Dinlenen Şarkılar
            </h3>
            <div>
              <?php
              if($lastPlayedSongs):
                foreach($lastPlayedSongs as $song):
              ?>
              <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 5px; border-bottom: 1px solid #EAEAEA;">
                <div style="display: flex; align-items: center;">
                  <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/modules/muzibu/dataimages/' . $song->album_thumb;?>&amp;w=30&amp;h=30" style="border-radius: 3px; margin-right: 8px;" onerror="this.src='<?php echo SITEURL; ?>/assets/images/default_album.jpg'">
                  <div>
                    <div style="font-weight: 500; color: #333;"><?php echo $song->song_title; ?></div>
                    <div style="font-size: 12px; color: #666;">
                      <?php echo (!empty($song->artist_name)) ? $song->artist_name : 'Bilinmeyen Sanatçı'; ?>
                    </div>
                  </div>
                </div>
                <div>
                  <span style="color: #666; font-size: 11px;"><?php echo date('d.m.Y H:i', strtotime($song->created)); ?></span>
                </div>
              </div>
              <?php
                endforeach;
              else:
              ?>
              <div style="padding: 10px; text-align: center; color: #666;">Henüz dinlenen şarkı yok.</div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        
        <!-- En Çok Favorilenen Şarkılar -->
        <div class="row">
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 10px; margin-bottom: 15px;">
            <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #333; display: flex; align-items: center; border-bottom: 1px solid #E0E0E0; padding-bottom: 8px;">
              <i class="heart icon" style="font-size: 24px;"></i> En Çok Favorilenen Şarkılar
            </h3>
            <div>
              <?php
              if($topFavoritedSongs):
                foreach($topFavoritedSongs as $song):
              ?>
              <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 5px; border-bottom: 1px solid #EAEAEA;">
                <div style="display: flex; align-items: center;">
                  <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/modules/muzibu/dataimages/' . $song->album_thumb;?>&amp;w=30&amp;h=30" style="border-radius: 3px; margin-right: 8px;" onerror="this.src='<?php echo SITEURL; ?>/assets/images/default_album.jpg'">
                  <div>
                    <div style="font-weight: 500; color: #333;"><?php echo $song->song_title; ?></div>
                    <div style="font-size: 12px; color: #666;">
                      <?php echo (!empty($song->artist_name)) ? $song->artist_name : 'Bilinmeyen Sanatçı'; ?>
                    </div>
                  </div>
                </div>
                <div>
                  <span style="background-color: #E74C3C; color: #fff; padding: 2px 6px; border-radius: 2px; font-size: 11px;">
                    <i class="heart icon"></i> <?php echo number_format($song->favorite_count); ?>
                  </span>
                </div>
              </div>
              <?php
                endforeach;
              else:
              ?>
              <div style="padding: 10px; text-align: center; color: #666;">Henüz favorilenen şarkı yok.</div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- İçerik Listeleri -->
    <div class="tubi-grid">
      <div class="two columns small-horizontal-gutters">
        <!-- Sol Kolon - Son Eklenen Şarkılar ve Sanatçılar -->
        <div class="row">
          <!-- Son Eklenen Şarkılar -->
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 10px; margin-bottom: 15px;">
            <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #333; display: flex; align-items: center; border-bottom: 1px solid #E0E0E0; padding-bottom: 8px;">
              <i class="music icon" style="font-size: 24px;"></i> Son Eklenen Şarkılar
            </h3>
            <div>
              <?php
              $query = "SELECT s.*, a.title" . Lang::$lang . " as artist_name, al.thumb as album_thumb, al.title" . Lang::$lang . " as album_title
                      FROM muzibu_songs as s 
                      LEFT JOIN muzibu_albums as al ON al.id = s.album_id 
                      LEFT JOIN muzibu_artists as a ON a.id = al.artist_id 
                      ORDER BY s.created DESC LIMIT 5";
              $songs = $db->fetch_all($query);
              
              if($songs):
                foreach($songs as $song):
              ?>
              <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 5px; border-bottom: 1px solid #EAEAEA;">
                <div style="display: flex; align-items: center;">
                  <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/modules/muzibu/dataimages/' . $song->album_thumb;?>&amp;w=30&amp;h=30" style="border-radius: 3px; margin-right: 8px;" onerror="this.src='<?php echo SITEURL; ?>/assets/images/default_album.jpg'">
                  <div>
                    <div style="font-weight: 500; color: #333;"><?php echo $song->{'title'.Lang::$lang}; ?></div>
                    <div style="font-size: 12px; color: #666;"><?php echo (!empty($song->artist_name)) ? $song->artist_name : 'Bilinmeyen Sanatçı'; ?></div>
                  </div>
                </div>
                <div>
                  <span style="color: #666; font-size: 11px;"><?php echo date('d.m.Y H:i', strtotime($song->created)); ?></span>
                </div>
              </div>
              <?php
                endforeach;
              else:
              ?>
              <div style="padding: 10px; text-align: center; color: #666;">Henüz şarkı eklenmemiş.</div>
              <?php endif; ?>
            </div>
          </div>
          
          <!-- Son Eklenen Sanatçılar -->
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 10px; margin-bottom: 15px;">
            <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #333; display: flex; align-items: center; border-bottom: 1px solid #E0E0E0; padding-bottom: 8px;">
              <i class="user icon" style="font-size: 24px;"></i> Son Eklenen Sanatçılar
            </h3>
            <div>
              <?php
              $query = "SELECT a.* FROM muzibu_artists as a ORDER BY a.created DESC LIMIT 5";
              $artists = $db->fetch_all($query);
              
              if($artists):
                foreach($artists as $artist):
                  // Albüm sayısını hesapla
                  $album_count = $db->first("SELECT COUNT(*) AS total FROM muzibu_albums WHERE artist_id = " . $artist->id);
              ?>
              <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 5px; border-bottom: 1px solid #EAEAEA;">
                <div style="display: flex; align-items: center;">
                  <?php if($artist->thumb): ?>
                  <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/modules/muzibu/dataimages/' . $artist->thumb;?>&amp;w=30&amp;h=30" alt="" style="border-radius: 3px; margin-right: 8px;">
                  <?php else: ?>
                  <img src="<?php echo SITEURL;?>/assets/images/default_artist.jpg" style="width: 30px; height: 30px; border-radius: 3px; margin-right: 8px;">
                  <?php endif; ?>
                  <div>
                    <div style="font-weight: 500; color: #333;"><?php echo $artist->{'title'.Lang::$lang}; ?></div>
                    <div style="font-size: 12px; color: #666;"><?php echo $album_count->total; ?> albüm</div>
                  </div>
                </div>
                <div>
                  <?php if($artist->active): ?>
                  <span style="background-color: #27AE60; color: #fff; padding: 2px 6px; border-radius: 2px; font-size: 11px;">Aktif</span>
                  <?php else: ?>
                  <span style="background-color: #E74C3C; color: #fff; padding: 2px 6px; border-radius: 2px; font-size: 11px;">Pasif</span>
                  <?php endif; ?>
                </div>
              </div>
              <?php
                endforeach;
              else:
              ?>
              <div style="padding: 10px; text-align: center; color: #666;">Henüz sanatçı eklenmemiş.</div>
              <?php endif; ?>
            </div>
          </div>
        </div>
        
        <!-- Sağ Kolon - Albümler ve Çalma Listeleri -->
        <div class="row">
          <!-- Son Eklenen Albümler -->
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 10px; margin-bottom: 15px;">
            <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #333; display: flex; align-items: center; border-bottom: 1px solid #E0E0E0; padding-bottom: 8px;">
              <i class="disk icon" style="font-size: 24px;"></i> Son Eklenen Albümler
            </h3>
            <div>
              <?php
              $query = "SELECT a.*, ar.title" . Lang::$lang . " as artist_name 
                      FROM muzibu_albums as a 
                      LEFT JOIN muzibu_artists as ar ON ar.id = a.artist_id 
                      ORDER BY a.created DESC LIMIT 5";
              $albums = $db->fetch_all($query);
              
              if($albums):
                foreach($albums as $album):
              ?>
              <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 5px; border-bottom: 1px solid #EAEAEA;">
                <div style="display: flex; align-items: center;">
                  <?php if($album->thumb): ?>
                  <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/modules/muzibu/dataimages/' . $album->thumb;?>&amp;w=30&amp;h=30" alt="" style="border-radius: 3px; margin-right: 8px;">
                  <?php else: ?>
                  <img src="<?php echo SITEURL;?>/assets/images/default_album.jpg" style="width: 30px; height: 30px; border-radius: 3px; margin-right: 8px;">
                  <?php endif; ?>
                  <div>
                    <div style="font-weight: 500; color: #333;"><?php echo $album->{'title'.Lang::$lang}; ?></div>
                    <div style="font-size: 12px; color: #666;"><?php echo (!empty($album->artist_name)) ? $album->artist_name : 'Bilinmeyen Sanatçı'; ?></div>
                  </div>
                </div>
                <div>
                  <?php if($album->active): ?>
                  <span style="background-color: #27AE60; color: #fff; padding: 2px 6px; border-radius: 2px; font-size: 11px;">Aktif</span>
                  <?php else: ?>
                  <span style="background-color: #E74C3C; color: #fff; padding: 2px 6px; border-radius: 2px; font-size: 11px;">Pasif</span>
                  <?php endif; ?>
                </div>
              </div>
              <?php
                endforeach;
              else:
              ?>
              <div style="padding: 10px; text-align: center; color: #666;">Henüz albüm eklenmemiş.</div>
              <?php endif; ?>
            </div>
          </div>
          
          <!-- Son Eklenen Çalma Listeleri -->
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 10px; margin-bottom: 15px;">
            <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #333; display: flex; align-items: center; border-bottom: 1px solid #E0E0E0; padding-bottom: 8px;">
              <i class="list icon" style="font-size: 24px;"></i> Son Eklenen Çalma Listeleri
            </h3>
            <div>
              <?php
              $query = "SELECT p.*, u.username 
                      FROM muzibu_playlists as p 
                      LEFT JOIN users as u ON u.id = p.user_id 
                      ORDER BY p.created DESC LIMIT 5";
              $playlists = $db->fetch_all($query);
              
              if($playlists):
                foreach($playlists as $playlist):
                  // Şarkı sayısını hesapla
                  $song_count = $db->first("SELECT COUNT(*) AS total FROM muzibu_playlist_song WHERE playlist_id = " . $playlist->id);
              ?>
              <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 5px; border-bottom: 1px solid #EAEAEA;">
                <div style="display: flex; align-items: center;">
                  <?php if($playlist->thumb): ?>
                  <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL . '/modules/muzibu/dataimages/' . $playlist->thumb;?>&amp;w=30&amp;h=30" alt="" style="border-radius: 3px; margin-right: 8px;">
                  <?php else: ?>
                  <img src="<?php echo SITEURL;?>/assets/images/default_playlist.jpg" style="width: 30px; height: 30px; border-radius: 3px; margin-right: 8px;">
                  <?php endif; ?>
                  <div>
                    <div style="font-weight: 500; color: #333;"><?php echo $playlist->{'title'.Lang::$lang}; ?></div>
                    <div style="font-size: 12px; color: #666;">
                      <?php 
                      if ($playlist->system == 1) {
                          echo 'Sistem - ';
                      } else {
                          echo (!empty($playlist->username)) ? $playlist->username . ' - ' : 'Kullanıcı #' . $playlist->user_id . ' - ';
                      }
                      echo $song_count->total . ' şarkı';
                      ?>
                    </div>
                  </div>
                </div>
                <div>
                  <?php if($playlist->active): ?>
                  <span style="background-color: #27AE60; color: #fff; padding: 2px 6px; border-radius: 2px; font-size: 11px;">Aktif</span>
                  <?php else: ?>
                  <span style="background-color: #E74C3C; color: #fff; padding: 2px 6px; border-radius: 2px; font-size: 11px;">Pasif</span>
                  <?php endif; ?>
                </div>
              </div>
              <?php
                endforeach;
              else:
              ?>
              <div style="padding: 10px; text-align: center; color: #666;">Henüz çalma listesi eklenmemiş.</div>
              <?php endif; ?>
            </div>
          </div>
          
          <!-- Müzik Türleri Listesi -->
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 10px; margin-bottom: 15px;">
            <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #333; display: flex; align-items: center; border-bottom: 1px solid #E0E0E0; padding-bottom: 8px;">
              <i class="tag icon" style="font-size: 24px;"></i> Müzik Türleri
            </h3>
            <div>
              <?php
              $query = "SELECT g.*, COUNT(s.id) as song_count 
                      FROM muzibu_genres as g 
                      LEFT JOIN muzibu_songs as s ON s.genre_id = g.id 
                      GROUP BY g.id 
                      ORDER BY song_count DESC LIMIT 10";
              $genres = $db->fetch_all($query);
              
              if($genres):
              ?>
              <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                <?php foreach($genres as $genre): ?>
                <a href="index.php?do=modules&action=config&modname=muzibu&maction=genre_edit&id=<?php echo $genre->id;?>" style="text-decoration: none; display: inline-block; padding: 5px 10px; background-color: #EEE; color: #333; border-radius: 3px; font-size: 12px;">
                  <i class="music icon"></i> <?php echo $genre->{'title'.Lang::$lang}; ?> 
                  <span style="color: #666; font-size: 11px;">(<?php echo $genre->song_count; ?>)</span>
                </a>
                <?php endforeach; ?>
              </div>
              <?php else: ?>
                <div style="padding: 10px; text-align: center; color: #666;">Henüz tür eklenmemiş.</div>
              <?php endif; ?>
            </div>
          </div>
          
          <!-- Sektör Listesi -->
          <div style="background-color: #F5F5F5; border: 1px solid #E0E0E0; border-radius: 5px; padding: 10px; margin-bottom: 15px;">
            <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #333; display: flex; align-items: center; border-bottom: 1px solid #E0E0E0; padding-bottom: 8px;">
              <i class="industry icon" style="font-size: 24px;"></i> Sektörler
            </h3>
            <div>
              <?php
              $query = "SELECT s.*, COUNT(ps.playlist_id) as playlist_count 
                      FROM muzibu_sectors as s 
                      LEFT JOIN muzibu_playlist_sector as ps ON ps.sector_id = s.id 
                      GROUP BY s.id 
                      ORDER BY playlist_count DESC LIMIT 10";
              $sectors = $db->fetch_all($query);
              
              if($sectors):
              ?>
              <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                <?php foreach($sectors as $sector): ?>
                <a href="index.php?do=modules&action=config&modname=muzibu&maction=sector_edit&id=<?php echo $sector->id;?>" style="text-decoration: none; display: inline-block; padding: 5px 10px; background-color: #EEE; color: #333; border-radius: 3px; font-size: 12px;">
                  <i class="industry icon"></i> <?php echo $sector->{'title'.Lang::$lang}; ?> 
                  <span style="color: #666; font-size: 11px;">(<?php echo $sector->playlist_count; ?>)</span>
                </a>
                <?php endforeach; ?>
              </div>
              <?php else: ?>
                <div style="padding: 10px; text-align: center; color: #666;">Henüz sektör eklenmemiş.</div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>