<?php
  /**
   * Muzibu Admin
   *
   * @package Muzibu Module
   * @author Nurullah Okatan
   * @copyright 2024
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  if (!$user->getAcl("muzibu")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;
  
  require_once("admin_class.php");
  Registry::set('Muzibu', new Muzibu());
?>

<?php switch(Filter::$maction): 
case "artist-list":
case "artist-add":
case "artist-edit":
    include_once("section-artist.php");
    break;

case "albums":
case "album_add":
case "album_edit":
    include_once("section-album.php");
    break;

case "genres":
case "genre_add":
case "genre_edit":
    include_once("section-genre.php");
    break;

case "sectors":
case "sector_add":
case "sector_edit":
    include_once("section-sector.php");
    break;

case "playlists":
case "playlist_add":
case "playlist_edit":
    include_once("section-playlist.php");
    break;

case "playlist_songs": 
    include("section-playlist-songs.php");
    break;

case "song_edit":
case "song_add":
    include_once("section-song.php");
    break;

case "config":
    include_once("section-config.php");
    break;

default:
    include_once("section-song.php");
    break;
    
endswitch; ?>