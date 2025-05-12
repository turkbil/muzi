<?php
/**
 * Muzibu Class
 *
 * @yazilim CMS PRO
 * @web adresi turkbilisim.com.tr
 * @copyright 2024
 * @version $Id: admin_class.php, v1.00 2024-03-01 16:00:00 
 */

if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

// Alt sınıfları dahil et
require_once(dirname(__FILE__) . "/admin_class_album.php");
require_once(dirname(__FILE__) . "/admin_class_artist.php");
require_once(dirname(__FILE__) . "/admin_class_genre.php");
require_once(dirname(__FILE__) . "/admin_class_playlist.php");
require_once(dirname(__FILE__) . "/admin_class_sector.php");
require_once(dirname(__FILE__) . "/admin_class_homepage.php");

class Muzibu
{
    // Tablo isimleri
    const mTable = "muzibu_songs";
    const artistTable = "muzibu_artists";
    const albumTable = "muzibu_albums"; 
    const genreTable = "muzibu_genres";
    const playlistTable = "muzibu_playlists";
    const sectorTable = "muzibu_sectors";
    const playlistSongTable = "muzibu_playlist_song";
    const favoriteTable = "muzibu_favorites";
    const playTable = "muzibu_song_plays";

    // Dosya yolları
    const imagepath = "modules/muzibu/dataimages/";
    const filepath = "modules/muzibu/datafiles/";

    private static $db;
    
    // Alt modül sınıfları için property'ler
    public $album;
    public $artist;
    public $genre;
    public $playlist;
    public $sector;
    public $homepage;

    // Varsayılan ayarlar
    public $ipp = 10; // Sayfa başına öğe
    public $fpp = 20; // Sayfa başına öne çıkan

    /**
     * Muzibu::__construct()
     * 
     * @return
     */
    function __construct($song = false, $album = false, $genre=false)
    {
        self::$db = Registry::get("Database");
        ($song) ? $this->renderSingleSong() : null;
        ($album) ? $this->renderSingleAlbum() : null;
        ($genre) ? $this->renderSingleGenre() : null;

        // Alt sınıfları başlat
        $this->album = new MuzibuAlbum();
        $this->artist = new MuzibuArtist();
        $this->genre = new MuzibuGenre();
        $this->playlist = new MuzibuPlaylist();
        $this->sector = new MuzibuSector();
        $this->homepage = new MuzibuHomepage();
    }

    /**
     * Muzibu::getSongs()
     * 
     * @return
     */
    public function getSongs()
    {
        // Sayfalama için gerekli ayarlar
        $pager = Paginator::instance();
        $pager->items_total = countEntries(self::mTable);
        $pager->default_ipp = Registry::get("Core")->perpage;
        $pager->paginate();

        $sql = "SELECT s.*, a.id as artist_id, a.title" . Lang::$lang . " as artist_title, 
                l.title" . Lang::$lang . " as album_title, 
                g.title" . Lang::$lang . " as genre_title" 
        . "\n FROM " . self::mTable . " as s" 
        . "\n LEFT JOIN " . self::albumTable . " as l ON l.id = s.album_id" 
        . "\n LEFT JOIN " . self::artistTable . " as a ON a.id = l.artist_id" 
        . "\n LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id" 
        . "\n LEFT JOIN " . self::playTable . " as p ON p.song_id = s.id" 
        . "\n GROUP BY s.id" 
        . "\n ORDER BY s.id DESC" . $pager->limit;

        $row = self::$db->fetch_all($sql);
        return ($row) ? $row : 0;
    }

    /**
     * Muzibu::getSongsByArtist()
     * 
     * @param int $artist_id
     * @return
     */
    public function getSongsByArtist($artist_id)
    {
        $artist_id = intval($artist_id);
        
        $sql = "SELECT s.*, a.id as artist_id, a.title" . Lang::$lang . " as artist_title, 
                l.id as album_id, l.title" . Lang::$lang . " as album_title, 
                g.id as genre_id, g.title" . Lang::$lang . " as genre_title" 
        . "\n FROM " . self::mTable . " as s" 
        . "\n LEFT JOIN " . self::albumTable . " as l ON l.id = s.album_id" 
        . "\n LEFT JOIN " . self::artistTable . " as a ON a.id = l.artist_id" 
        . "\n LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id" 
        . "\n LEFT JOIN " . self::playTable . " as p ON p.song_id = s.id" 
        . "\n WHERE a.id = " . $artist_id
        . "\n GROUP BY s.id" 
        . "\n ORDER BY l.title" . Lang::$lang . ", s.title" . Lang::$lang;
        
        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }
	
	public function getUserFavoriteSongs($user_id)
    {
        $user_id = intval($user_id);
        
        $sql = "SELECT s.*, a.id as artist_id, a.title" . Lang::$lang . " as artist_name, 
                l.id as album_id, l.title" . Lang::$lang . " as album_title,l.thumb as thumb,
                g.id as genre_id, g.title" . Lang::$lang . " as genre_title" 
        . "\n FROM " . self::mTable . " as s" 
        . "\n LEFT JOIN " . self::albumTable . " as l ON l.id = s.album_id" 
        . "\n LEFT JOIN " . self::artistTable . " as a ON a.id = l.artist_id" 
        . "\n LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id" 
        . "\n LEFT JOIN " . self::playTable . " as p ON p.song_id = s.id" 
        . "\n LEFT JOIN " . self::favoriteTable . " as f ON s.id = f.song_id" 
        . "\n WHERE f.user_id = " . $user_id
        . "\n GROUP BY s.id" 
        . "\n ORDER BY l.title" . Lang::$lang . ", s.title" . Lang::$lang;
        
        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }
    
    public function getUserFavoritesBySongs($user_id,$songs)
    {
        $user_id = intval($user_id);
        
        $song_ids = array();
        
        foreach($songs as $song){
            $song_ids[] = $song->id;
        }
        
        $sql = "SELECT f.song_id" 
        . "\n FROM " . self::favoriteTable . " as f" 
        . "\n WHERE f.user_id = " . $user_id
        . "\n AND f.song_id IN(".implode(",",$song_ids).") ";
        
        $row = self::$db->fetch_all($sql);
        
        $ids = array();
        foreach($row as $song){
            $ids[] = $song->song_id;
        }
        return $ids;
    }

    /**
     * Muzibu::getSongsByGenre()
     * 
     * @param int $genre_id
     * @return
     */
    public function getSongsByGenre($genre_id)
    {
        $genre_id = intval($genre_id);
        
        $sql = "SELECT s.*, a.id as artist_id, a.title" . Lang::$lang . " as artist_title, 
                l.id as album_id, l.title" . Lang::$lang . " as album_title, l.thumb, 
                g.id as genre_id, g.title" . Lang::$lang . " as genre_title" 
        . "\n FROM " . self::mTable . " as s" 
        . "\n LEFT JOIN " . self::albumTable . " as l ON l.id = s.album_id" 
        . "\n LEFT JOIN " . self::artistTable . " as a ON a.id = l.artist_id" 
        . "\n LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id" 
        . "\n LEFT JOIN " . self::playTable . " as p ON p.song_id = s.id" 
        . "\n WHERE s.genre_id = " . $genre_id
        . "\n GROUP BY s.id" 
        . "\n ORDER BY s.title" . Lang::$lang;
        
        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }
    
    /**
     * Muzibu::getSongsByAlbum()
     * 
     * @param int $album_id
     * @return
     */
    public function getSongsByAlbum($album_id)
    {
        $album_id = intval($album_id);
        
        $sql = "SELECT s.*, a.id as artist_id, a.title" . Lang::$lang . " as artist_name, 
                l.id as album_id, l.title" . Lang::$lang . " as album_title, l.thumb, 
                g.id as genre_id, g.title" . Lang::$lang . " as genre_title" 
        . "\n FROM " . self::mTable . " as s" 
        . "\n LEFT JOIN " . self::albumTable . " as l ON l.id = s.album_id" 
        . "\n LEFT JOIN " . self::artistTable . " as a ON a.id = l.artist_id" 
        . "\n LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id" 
        . "\n LEFT JOIN " . self::playTable . " as p ON p.song_id = s.id" 
        . "\n WHERE s.album_id = " . $album_id
        . "\n GROUP BY s.id" 
        . "\n ORDER BY s.title" . Lang::$lang;
        
        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }
	
	public function searchSong($keywords)
    {
        
        $sql = "SELECT s.*, a.id as artist_id, a.title" . Lang::$lang . " as artist_name, 
                l.id as album_id, l.title" . Lang::$lang . " as album_title, l.thumb, 
                g.id as genre_id, g.title" . Lang::$lang . " as genre_title" 
        . "\n FROM " . self::mTable . " as s" 
        . "\n LEFT JOIN " . self::albumTable . " as l ON l.id = s.album_id" 
        . "\n LEFT JOIN " . self::artistTable . " as a ON a.id = l.artist_id" 
        . "\n LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id" 
        . "\n LEFT JOIN " . self::playTable . " as p ON p.song_id = s.id" 
        . "\n WHERE s.title_tr LIKE '%" . $keywords . "%' OR a.title_tr LIKE '%".$keywords."%' OR l.title_tr LIKE '%".$keywords."%' OR g.title_tr LIKE '%".$keywords."%'"
        . "\n GROUP BY s.id" 
        . "\n ORDER BY s.title" . Lang::$lang;
        
        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * Muzibu::renderSongs()
     * 
     * @return
     */
    public function renderSongs()
    {
        $pager = Paginator::instance();
        $pager->items_total = getSongsCount();
        $pager->default_ipp = $this->fpp;
        $pager->path = SITEURL . '/muzibu/?';
        $pager->paginate();

        $sql = "SELECT s.*, ar.title" . Lang::$lang . " as artist_name, al.thumb FROM " . self::mTable ." as s
                LEFT JOIN " . self::albumTable . " as al ON al.id = s.album_id
                LEFT JOIN " . self::artistTable . " as ar ON ar.id = al.artist_id
                ORDER BY album_id, title" . Lang::$lang . $pager->limit;
        
        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }
    
    public function getAllSongs($page=1,$ipp=20)
    {
        $offset = ($page-1)*$ipp;
        
        
        $sql = "SELECT s.*, ar.title" . Lang::$lang . " as artist_name, al.thumb FROM " . self::mTable ." as s
                LEFT JOIN " . self::albumTable . " as al ON al.id = s.album_id
                LEFT JOIN " . self::artistTable . " as ar ON ar.id = al.artist_id
                ORDER BY album_id, title" . Lang::$lang .
                " LIMIT ".$offset.",".$ipp;
                
        $row = self::$db->fetch_all($sql);
        return ($row) ? $row : 0;
    }
    
    public function getSongsCount(){
        $sql = "SELECT s.id FROM " . self::mTable ." as s";
                
        $rows = self::$db->fetch_all($sql);
        
        return count($rows);
    }

    /**
     * Muzibu::renderAlbum()
     * 
     * @return
     */
    public function renderAlbum($album_id)
    {
        $q = "SELECT COUNT(id) FROM " . self::mTable . " WHERE album_id = " . intval($album_id);
        $record = self::$db->query($q);
        $total = self::$db->fetchrow($record);
        $counter = $total[0];

        $pager = Paginator::instance();
        $pager->items_total = $counter;
        $pager->default_ipp = $this->ipp;
        // Hata veren kısmı düzeltelim - Url::Muzibu() yerine direkt URL verelim
        $pager->path = SITEURL . "/admin/index.php?do=modules&action=config&modname=muzibu&maction=album_songs&id=" . $album_id . "&";
        $pager->paginate();

        $sql = "SELECT s.*, a.id as artist_id, a.title" . Lang::$lang . " as artist_name, 
                l.title" . Lang::$lang . " as album_name, 
                g.title" . Lang::$lang . " as genre_name" 
        . "\n FROM " . self::mTable . " as s" 
        . "\n LEFT JOIN " . self::albumTable . " as l ON l.id = s.album_id" 
        . "\n LEFT JOIN " . self::artistTable . " as a ON a.id = l.artist_id" 
        . "\n LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id" 
        . "\n LEFT JOIN " . self::playTable . " as p ON p.song_id = s.id" 
        . "\n WHERE album_id = " . intval($album_id) 
        . "\n GROUP BY s.id"
        . "\n ORDER BY s.title" . Lang::$lang . $pager->limit;
        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

/**
     * Muzibu::renderSingleAlbum()
     * 
     * @return
     */
    private function renderSingleAlbum()
    {
        $sql = "SELECT * FROM " . self::albumTable . " WHERE slug = '" . Registry::get("Content")->_url[2] . "'";
        $row = self::$db->first($sql);

        return ($row) ? Registry::get("Content")->moduledata->mod = $row : 0;
    }
    
    private function renderSingleGenre()
    {
        $sql = "SELECT * FROM " . self::genreTable . " WHERE slug = '" . Registry::get("Content")->_url[2] . "'";
        $row = self::$db->first($sql);

        return ($row) ? Registry::get("Content")->moduledata->mod = $row : 0;
    }

    /**
     * Muzibu::renderSingleSong()
     * 
     * @return
     */
    private function renderSingleSong()
    {
        $sql = "SELECT * FROM " . self::mTable . " WHERE slug = '" . Registry::get("Content")->_url[1] . "'";
        $row = self::$db->first($sql);

        return ($row) ? Registry::get("Content")->moduledata->mod = $row : 0;
    }

    /**
     * Muzibu::processSong()
     * 
     * @return
     */
    public function processSong()
    {
        Filter::checkPost('title' . Lang::$lang, 'Şarkı Adı');
        Filter::checkPost('genre_id', 'Müzik Türü');

        if (!empty($_FILES['song_file']['name'])) {
            $allowed = array('mp3', 'wav', 'ogg', 'aac', 'm4a', 'flac', 'wma');
            $ext = pathinfo($_FILES['song_file']['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($ext), $allowed)) {
                Filter::$msgs['song_file'] = 'Geçersiz dosya formatı. Sadece mp3, wav ve ogg dosyaları yükleyebilirsiniz.';
            }
        }

        if (empty(Filter::$msgs)) {
            $data = array(
                'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
                'slug' => (empty($_POST['slug'])) ? doSeo($_POST['title' . Lang::$lang]) : doSeo($_POST['slug']),
                'genre_id' => intval($_POST['genre_id']),
                'duration' => intval($_POST['duration']),
                'lyrics' . Lang::$lang => Filter::in_url($_POST['lyrics' . Lang::$lang]),
                'is_featured' => intval($_POST['is_featured']),
                'active' => intval($_POST['active']),
            );
            
            // Albüm seçilmişse, albümün sanatçısını da şarkıya ata
            if (isset($_POST['album_id']) && !empty($_POST['album_id'])) {
                $album_id = intval($_POST['album_id']);
                $data['album_id'] = $album_id;
            }

            if (!Filter::$id) {
                $data['created'] = "NOW()";
            }

            // Process Song File
            if (!empty($_FILES['song_file']['name'])) {
                $filedir = BASEPATH . self::filepath . 'songs/';
                
                // Dizin kontrolü ve oluşturma
                if (!file_exists($filedir)) {
                    mkdir($filedir, 0755, true);
                }
                
                $newName = "SONG_" . randName();
                $ext = pathinfo($_FILES['song_file']['name'], PATHINFO_EXTENSION);
                $fullname = $filedir . $newName . "." . strtolower($ext);

                if (Filter::$id && $file = getValueById("file_path", self::mTable, Filter::$id)) {
                    $oldFile = $filedir . $file;
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }

                if (!move_uploaded_file($_FILES['song_file']['tmp_name'], $fullname)) {
                    die(Filter::msgError("Dosya geçici klasörden hedef klasöre taşınamadı. Dizin yolu: " . $filedir, false));
                }
                $data['file_path'] = $newName . "." . strtolower($ext);
                if($data['duration']=="" || $data['duration']==0){
                    $data['duration'] = getMP3Duration($data['file_path']);
                }
            }

            (Filter::$id) ? self::$db->update(self::mTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::mTable, $data);
            $message = (Filter::$id) ? 'Şarkı başarıyla güncellendi' : 'Şarkı başarıyla eklendi';

            if (self::$db->affected()) {
                $json['type'] = 'success';
                $json['message'] = Filter::msgOk($message, false);
            } else {
                $json['type'] = 'success';
                $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
            }
            print json_encode($json);

        } else {
            $json['type'] = 'error';
            $json['message'] = Filter::msgStatus();
            print json_encode($json);
        }
    }

    /**
     * Muzibu::getAlbums()
     * 
     * @return
     */
    public function getAlbums()
    {
        return $this->album->getAllAlbums();
    }

    /**
     * Muzibu::getArtists()
     * 
     * @return
     */
    public function getArtists()
    {
        return $this->artist->getAllArtists();
    }

    /**
     * Muzibu::getGenres()
     * 
     * @return
     */
    public function getGenres()
    {
        return $this->genre->getAllGenres();
    }

    /**
     * Muzibu::getSectors()
     * 
     * @return
     */
    public function getSectors()
    {
        return $this->sector->getAllSectors();
    }

    /**
     * Muzibu::getAllPlaylists()
     * 
     * @return
     */
    public function getAllPlaylists()
    {
        return $this->playlist->getAllPlaylists();
    }

    /**
     * Muzibu::getPlaylists()
     * 
     * @return
     */
    public function getPlaylists()
    {
        return $this->playlist->getAllPlaylists();
    }

    /**
     * Muzibu::getPlaylistSectors()
     * 
     * @param int $playlist_id
     * @return
     */
    public function getPlaylistSectors($playlist_id)
    {
        return $this->playlist->getPlaylistSectors($playlist_id);
    }

    /**
     * Muzibu::getPlaylistById()
     * 
     * @param int $id
     * @return
     */
    public function getPlaylistById($id)
    {
        return $this->playlist->getPlaylistById($id);
    }

    /**
     * Muzibu::getPlaylistSongs()
     * 
     * @param int $playlist_id
     * @return
     */
    public function getPlaylistSongs($playlist_id)
    {
        return $this->playlist->getPlaylistSongs($playlist_id);
    }

    /**
     * Muzibu::processAlbum()
     * 
     * @return
     */
    public function processAlbum()
    {
        return $this->album->processAlbum();
    }

    /**
     * Muzibu::processArtist()
     * 
     * @return
     */
    public function processArtist()
    {
        return $this->artist->processArtist();
    }

    /**
     * Muzibu::processGenre()
     * 
     * @return
     */
    public function processGenre()
    {
        return $this->genre->processGenre();
    }

    /**
     * Muzibu::processSector()
     * 
     * @return
     */
    public function processSector()
    {
        return $this->sector->processSector();
    }

    /**
     * Muzibu::processPlaylist()
     * 
     * @return
     */
    public function processPlaylist()
    {
        return $this->playlist->processPlaylist();
    }

    /**
     * Muzibu::updateOrder()
     * 
     * @return
     */
    public static function updateOrder()
    {
        MuzibuAlbum::updateOrder();
    }
    
    /**
     * Muzibu::updateSong()
     * 
     * @return
     */
    public static function updateSong()
    {
        foreach ($_POST['node'] as $k => $v) {
            $p = $k + 1;
            $data['sorting'] = intval($p);
            self::$db->update(self::mTable, $data, "id=" . (int)$v);
        }
    }
    
    /**
     * Muzibu::updateArtistOrder()
     * 
     * @return
     */
    public static function updateArtistOrder()
    {
        MuzibuArtist::updateOrder();
    }
    
    /**
     * Muzibu::updateGenreOrder()
     * 
     * @return
     */
    public static function updateGenreOrder()
    {
        MuzibuGenre::updateOrder();
    }
    
    /**
     * Muzibu::updateSectorOrder()
     * 
     * @return
     */
    public static function updateSectorOrder()
    {
        MuzibuSector::updateOrder();
    }
    
    /**
     * Muzibu::updatePlaylistSongOrder()
     * 
     * @return
     */
    public static function updatePlaylistSongOrder()
    {
        MuzibuPlaylist::updateSongOrder();
    }
}