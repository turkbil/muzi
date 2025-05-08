<?php
  /**
   * Muzibu Main - Fixed URL Router
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  // Modül sınıfını yükle
  require_once (MODPATH . "muzibu/admin_class.php");
  $classname = 'Muzibu';
  try {
      if (!class_exists($classname)) {
          throw new exception('Missing muzibu/admin_class.php');
      }
      Registry::set('Muzibu', new Muzibu(false));
  }
  catch (exception $e) {
      echo $e->getMessage();
  }
  
  // URL segmentlerini kontrol et
  $segment1 = isset($content->_url[0]) ? $content->_url[0] : '';
  $segment2 = isset($content->_url[1]) ? $content->_url[1] : '';
  $segment3 = isset($content->_url[2]) ? $content->_url[2] : '';
  
  // Muzibu modülündeyiz (segment1 = "muzibu")
  if ($segment1 == Url::$data['moddir']['muzibu']) {
      
      // Ana sayfa kontrolü
      if (empty($segment2)) {
          include_once("muzibu_main.php");
      } 
      // İkinci segment kontrolü
      elseif ($segment2 == 'song') {
          if (empty($segment3)) {
              include_once("song_list.php");
          } else {
              include_once("song_detail.php");
          }
      }
      elseif ($segment2 == 'album') {
          if (empty($segment3)) {
              include_once("album_list.php");
          } else {
              include_once("album_detail.php");
          }
      }
      elseif ($segment2 == 'artist') {
          if (empty($segment3)) {
              include_once("artist_list.php");
          } else {
              include_once("artist_detail.php");
          }
      }
      elseif ($segment2 == 'genre') {
          if (empty($segment3)) {
              include_once("genre_list.php");
          } else {
              include_once("genre_detail.php");
          }
      }
      elseif ($segment2 == 'playlist') {
          if (empty($segment3)) {
              include_once("playlist_list.php");
          } else {
              include_once("playlist_detail.php");
          }
      }
      elseif ($segment2 == 'sector') {
          if (empty($segment3)) {
              include_once("sector_list.php");
          } else {
              include_once("sector_detail.php");
          }
      }
      elseif ($segment2 == 'favorites') {
          include_once("favorites.php");
      }
      else {
          include_once("muzibu_main.php");
      }
  } else {
      include_once("muzibu_main.php");
  }
?>