<?php
  /**
   * Controller
   *
   * @yazilim CMS PRO
   * @web adresi turkbilisim.com.tr
   * @copyright 2024
   * @version $Id: controller.php, v1.00 2024-03-01 17:00:00
   */
  define("_VALID_PHP", true);
  
  require_once("../../init.php");
  if (!$user->is_Admin())
      redirect_to("../../login.php");
  
  require_once("admin_class.php");
  Registry::set('Muzibu', new Muzibu());
?>
<?php
  /* == Update Configuration == */
  if (isset($_POST['processConfig'])):
      Registry::get("Muzibu")->processConfig();
  endif;

  /* == Process Song == */
  if (isset($_POST['processSong'])):
      Registry::get("Muzibu")->processSong();
  endif;

  /* == Delete Song == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteSong"):
      $title = sanitize($_POST['title']);
      if ($file_path = getValueById("file_path", Muzibu::mTable, Filter::$id)):
          $filepath = BASEPATH . Muzibu::filepath . 'songs/' . $file_path;
          if (file_exists($filepath)) {
              @unlink($filepath);
          }
      endif;
      $result = $db->delete(Muzibu::mTable, "id=" . Filter::$id);
      
      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = 'Şarkı' . ' /' . $title . '/ ' . Lang::$word->_DELETED;
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;

  /* == Process Album == */
  if (isset($_POST['processAlbum'])):
      Registry::get("Muzibu")->processAlbum();
  endif;

  /* == Delete Album == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteAlbum"):
      $title = sanitize($_POST['title']);
      if ($thumb = getValueById("thumb", Muzibu::albumTable, Filter::$id)):
          $imagepath = BASEPATH . Muzibu::imagepath . $thumb;
          if (file_exists($imagepath)) {
              @unlink($imagepath);
          }
      endif;
      
      // Albüme ait şarkıların album_id'sini sıfırlama
      $data = array('album_id' => 0);
      $db->update(Muzibu::mTable, $data, "album_id = " . Filter::$id);
      
      // Albümü silme
      $result = $db->delete(Muzibu::albumTable, "id=" . Filter::$id);
      
      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = 'Albüm' . ' /' . $title . '/ ' . Lang::$word->_DELETED;
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;

  /* == Process Artist == */
  if (isset($_POST['processArtist'])):
      Registry::get("Muzibu")->processArtist();
  endif;

  /* == Delete Artist == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteArtist"):
      $title = sanitize($_POST['title']);
      if ($thumb = getValueById("thumb", Muzibu::artistTable, Filter::$id)):
          $imagepath = BASEPATH . Muzibu::imagepath . $thumb;
          if (file_exists($imagepath)) {
              @unlink($imagepath);
          }
      endif;
      
      // Sanatçıya ait albümlerin artist_id'sini sıfırlama
      $data = array('artist_id' => 0);
      $db->update(Muzibu::albumTable, $data, "artist_id = " . Filter::$id);
      
      // Sanatçıyı silme
      $result = $db->delete(Muzibu::artistTable, "id=" . Filter::$id);
      
      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = 'Sanatçı' . ' /' . $title . '/ ' . Lang::$word->_DELETED;
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;

  /* == Process Genre == */
  if (isset($_POST['processGenre'])):
      Registry::get("Muzibu")->processGenre();
  endif;

  /* == Delete Genre == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteGenre"):
      $title = sanitize($_POST['title']);
      if ($thumb = getValueById("thumb", Muzibu::genreTable, Filter::$id)):
          $imagepath = BASEPATH . Muzibu::imagepath . $thumb;
          if (file_exists($imagepath)) {
              @unlink($imagepath);
          }
      endif;
      
      // Tür ID'si ile ilişkili şarkı var mı kontrol et
      $songCount = countEntries(Muzibu::mTable, "genre_id = " . Filter::$id);
      
      if ($songCount > 0):
          $json['type'] = 'error';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = 'Bu türe ait şarkılar bulunduğu için silinemez!';
      else:
          $result = $db->delete(Muzibu::genreTable, "id=" . Filter::$id);
          
          if ($result):
              $json['type'] = 'success';
              $json['title'] = Lang::$word->_SUCCESS;
              $json['message'] = 'Müzik Türü' . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          else:
              $json['type'] = 'warning';
              $json['title'] = Lang::$word->_ALERT;
              $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
          endif;
      endif;
      print json_encode($json);
  endif;

  /* == Process Sector == */
  if (isset($_POST['processSector'])):
      Registry::get("Muzibu")->processSector();
  endif;

  /* == Delete Sector == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteSector"):
      $title = sanitize($_POST['title']);
      if ($thumb = getValueById("thumb", "muzibu_sectors", Filter::$id)):
          $imagepath = BASEPATH . Muzibu::imagepath . $thumb;
          if (file_exists($imagepath)) {
              @unlink($imagepath);
          }
      endif;
      
      // İlişkili playlist-sector kayıtlarını sil
      $db->delete("muzibu_playlist_sector", "sector_id = " . Filter::$id);
      
      // Sektörü sil
      $result = $db->delete("muzibu_sectors", "id=" . Filter::$id);
      
      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = 'Sektör' . ' /' . $title . '/ ' . Lang::$word->_DELETED;
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;

  /* == Process Playlist == */
  if (isset($_POST['processPlaylist'])):
      Registry::get("Muzibu")->processPlaylist();
  endif;

  /* == Process Playlist Songs == */
  if (isset($_POST['processPlaylistSongs'])):
      Registry::get("Muzibu")->playlist->processPlaylistSongs();
  endif;

  /* == Delete Playlist == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deletePlaylist"):
      $title = sanitize($_POST['title']);
      if ($thumb = getValueById("thumb", Muzibu::playlistTable, Filter::$id)):
          $imagepath = BASEPATH . Muzibu::imagepath . $thumb;
          if (file_exists($imagepath)) {
              @unlink($imagepath);
          }
      endif;
      
      // İlişkili playlist-sector kayıtlarını sil
      $db->delete(Muzibu::playlistSectorTable, "playlist_id = " . Filter::$id);
      
      // İlişkili playlist-song kayıtlarını sil
      $db->delete(Muzibu::playlistSongTable, "playlist_id = " . Filter::$id);
      
      // Playlist'i sil
      $result = $db->delete(Muzibu::playlistTable, "id=" . Filter::$id);
      
      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = 'Playlist' . ' /' . $title . '/ ' . Lang::$word->_DELETED;
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;

  /* == Update Album Order == */
  if (isset($_GET['sortalbums'])):
      Muzibu::updateOrder();
  endif;

  /* == Update Song Order == */
  if (isset($_GET['sortsongs'])):
      Muzibu::updateSong();
  endif;

  /* == Update Artist Order == */
  if (isset($_GET['sortartists'])):
      Muzibu::updateArtistOrder();
  endif;

  /* == Update Genre Order == */
  if (isset($_GET['sortgenres'])):
      Muzibu::updateGenreOrder();
  endif;

  /* == Update Sector Order == */
  if (isset($_GET['sortsectors'])):
      Muzibu::updateSectorOrder();
  endif;

  /* == Update Playlist Song Order == */
  if (isset($_GET['sortplaylistsongs'])):
      Muzibu::updatePlaylistSongOrder();
  endif;
?>