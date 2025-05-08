<?php
/**
 * Muzibu Playlist Class
 *
 * @yazilim CMS PRO
 * @web adresi turkbilisim.com.tr
 * @copyright 2024
 * @version $Id: admin_class_playlist.php, v1.00 2024-03-01 14:00:00 
 */

if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

class MuzibuPlaylist
{
    const playlistTable = "muzibu_playlists";
    const songTable = "muzibu_songs";
    const playlistSongTable = "muzibu_playlist_song";
    const playlistSectorTable = "muzibu_playlist_sector";
    const sectorTable = "muzibu_sectors";
    const albumTable = "muzibu_albums";
    const artistTable = "muzibu_artists";
    const genreTable = "muzibu_genres";
    const imagepath = "modules/muzibu/dataimages/";
    const usersTable = "users"; // Kullanıcılar tablosu tanımı

    private static $db;

    /**
     * MuzibuPlaylist::__construct()
     * 
     * @return
     
     
     */
    function __construct()
    {
        self::$db = Registry::get("Database");
    }
    
    /**
     * MuzibuPlaylist::getPlaylistBySlug()
     * 
     * @param string $slug
     * @return
     */
    public function renderSinglePlaylist()
    {
        $sql = "SELECT p.*, u.fname, u.lname, u.username ,COUNT(ps.song_id) as song_count, a.title_tr AS album_name,a.thumb AS album_thumb 
                FROM " . self::playlistTable . " as p
                LEFT JOIN " . self::usersTable . " as u ON u.id = p.user_id
                LEFT JOIN " . self::playlistSongTable . " as ps ON ps.playlist_id = p.id
                LEFT JOIN " . self::songTable . " AS s ON s.id = ps.song_id
                LEFT JOIN " . self::albumTable . " AS a ON a.id = s.album_id
                WHERE p.slug = '" . Registry::get("Content")->_url[2] . "'
                GROUP BY p.id";

        $row = self::$db->first($sql);

       return ($row) ? Registry::get("Content")->moduledata->mod = $row : 0;
    }
    
    

    /**
     * MuzibuPlaylist::getAllPlaylists()
     * 
     * @return
     */
    public function getAllPlaylists()
    {
        $sql = "SELECT p.*, u.fname, u.lname, u.username, COUNT(ps.song_id) as song_count 
                FROM " . self::playlistTable . " as p
                LEFT JOIN " . self::usersTable . " as u ON u.id = p.user_id
                LEFT JOIN " . self::playlistSongTable . " as ps ON ps.playlist_id = p.id
                GROUP BY p.id
                ORDER BY p.created DESC";

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuPlaylist::getSystemPlaylistsHome()
     * 
     * @param int $limit
     * @return
     */
    public function getSystemPlaylistsHome($limit = 10)
    {
        $sql = "SELECT p.* 
                FROM " . self::playlistTable . " as p
                WHERE p.system = 1 AND p.active = 1 AND p.is_public = 1
                ORDER BY p.created DESC
                LIMIT " . intval($limit);

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }


    /**
     * MuzibuPlaylist::getSystemPlaylists()
     * 
     * @return
     */
    public function getSystemPlaylists()
    {
        $sql = "SELECT p.*, u.fname, u.lname, u.username, COUNT(ps.song_id) as song_count 
                FROM " . self::playlistTable . " as p
                LEFT JOIN " . self::usersTable . " as u ON u.id = p.user_id
                LEFT JOIN " . self::playlistSongTable . " as ps ON ps.playlist_id = p.id
                WHERE p.system = 1 AND p.active = 1 AND p.is_public = 1
                GROUP BY p.id
                ORDER BY p.title" . Lang::$lang;

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuPlaylist::getPlaylistById()
     * 
     * @param int $id
     * @return
     */
    public function getPlaylistById($id)
    {
        $sql = "SELECT p.*, u.fname, u.lname, u.username 
                FROM " . self::playlistTable . " as p
                LEFT JOIN " . self::usersTable . " as u ON u.id = p.user_id
                WHERE p.id = " . intval($id);

        $row = self::$db->first($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuPlaylist::getPlaylistBySlug()
     * 
     * @param string $slug
     * @return
     */
    public function getPlaylistBySlug($slug)
    {
        $sql = "SELECT p.*, u.fname, u.lname, u.username 
                FROM " . self::playlistTable . " as p
                LEFT JOIN " . self::usersTable . " as u ON u.id = p.user_id
                WHERE p.slug = '" . self::$db->escape($slug) . "'";

        $row = self::$db->first($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuPlaylist::getPlaylistSongs()
     * 
     * @param int $playlist_id
     * @return
     */
    public function getPlaylistSongs($playlist_id)
    {
        $sql = "SELECT s.*, ps.position, 
                al.artist_id,
                ar.title" . Lang::$lang . " as artist_name, 
                al.title" . Lang::$lang . " as album_name, al.thumb,
                g.title" . Lang::$lang . " as genre_name 
                FROM " . self::playlistSongTable . " as ps
                JOIN " . self::songTable . " as s ON s.id = ps.song_id
                LEFT JOIN " . self::albumTable . " as al ON al.id = s.album_id
                LEFT JOIN " . self::artistTable . " as ar ON ar.id = al.artist_id
                LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id
                WHERE ps.playlist_id = " . intval($playlist_id) . "
                ORDER BY ps.position ASC";

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuPlaylist::getPlaylistSectors()
     * 
     * @param int $playlist_id
     * @return
     */
    public function getPlaylistSectors($playlist_id)
    {
        $sql = "SELECT s.* 
                FROM " . self::playlistSectorTable . " as ps
                JOIN " . self::sectorTable . " as s ON s.id = ps.sector_id
                WHERE ps.playlist_id = " . intval($playlist_id);

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuPlaylist::getSectorPlaylists()
     * 
     * @param int $sector_id
     * @return
     */
    public function getSectorPlaylists($sector_id)
    {
        $sql = "SELECT p.*, u.fname, u.lname, u.username 
                FROM " . self::playlistSectorTable . " as ps
                JOIN " . self::playlistTable . " as p ON p.id = ps.playlist_id
                LEFT JOIN " . self::usersTable . " as u ON u.id = p.user_id
                WHERE ps.sector_id = " . intval($sector_id) . "
                AND p.active = 1 AND p.is_public = 1
                ORDER BY p.title" . Lang::$lang;

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuPlaylist::processPlaylist()
     * 
     * @return
     */
    public function processPlaylist()
    {
        Filter::checkPost('title' . Lang::$lang, 'Playlist Adı');

        if (!empty($_FILES['thumb']['name'])) {
            if (!preg_match("/(\.jpg|\.png|\.jpeg)$/i", $_FILES['thumb']['name'])) {
                Filter::$msgs['thumb'] = Lang::$word->_CG_LOGO_R;
            }
            $file_info = getimagesize($_FILES['thumb']['tmp_name']);
            if (empty($file_info))
                Filter::$msgs['thumb'] = Lang::$word->_CG_LOGO_R;
        }

        if (empty(Filter::$msgs)) {
            $user = Registry::get("Users");
            
            $data = array(
                'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
                'slug' => (empty($_POST['slug'])) ? doSeo($_POST['title' . Lang::$lang]) : doSeo($_POST['slug']),
                'description' . Lang::$lang => Filter::in_url($_POST['description' . Lang::$lang]),
                'user_id' => isset($_POST['user_id']) ? intval($_POST['user_id']) : $user->uid,
                'system' => isset($_POST['system']) ? intval($_POST['system']) : 0,
                'is_public' => isset($_POST['is_public']) ? intval($_POST['is_public']) : 1,
                'active' => isset($_POST['active']) ? intval($_POST['active']) : 1,
            );

            if (!Filter::$id) {
                $data['created'] = "NOW()";
            }

            // Process Playlist Thumbnail
            if (!empty($_FILES['thumb']['name'])) {
                $filedir = BASEPATH . self::imagepath;
                
                // Dizin kontrolü ve oluşturma
                if (!file_exists($filedir)) {
                    mkdir($filedir, 0755, true);
                }
                
                $newName = "PLAYLIST_" . randName();
                $ext = substr($_FILES['thumb']['name'], strrpos($_FILES['thumb']['name'], '.') + 1);
                $fullname = $filedir . $newName . "." . strtolower($ext);

                if (Filter::$id && $file = getValueById("thumb", self::playlistTable, Filter::$id)) {
                    $oldFile = $filedir . $file;
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }

                if (!move_uploaded_file($_FILES['thumb']['tmp_name'], $fullname)) {
                    die(Filter::msgError("Dosya geçici klasörden hedef klasöre taşınamadı. Dizin yolu: " . $filedir, false));
                }
                $data['thumb'] = $newName . "." . strtolower($ext);
            }

            if (Filter::$id) {
                self::$db->update(self::playlistTable, $data, "id=" . Filter::$id);
                $playlist_id = Filter::$id;
                $message = 'Playlist başarıyla güncellendi';
            } else {
                $lastid = self::$db->insert(self::playlistTable, $data);
                $playlist_id = $lastid;
                $message = 'Playlist başarıyla eklendi';
            }

            // Process Sectors if provided
            if (isset($_POST['sectors']) && is_array($_POST['sectors'])) {
                // First delete existing relations
                self::$db->delete(self::playlistSectorTable, "playlist_id=" . $playlist_id);
                
                // Then insert new ones
                foreach ($_POST['sectors'] as $sector_id) {
                    $sdata = array(
                        'playlist_id' => $playlist_id,
                        'sector_id' => intval($sector_id)
                    );
                    self::$db->insert(self::playlistSectorTable, $sdata);
                }
            }

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
     * MuzibuPlaylist::processPlaylistSongs()
     * 
     * @return
     */
    public function processPlaylistSongs()
    {
        if (!isset($_POST['playlist_id']) || !isset($_POST['songs']) || !is_array($_POST['songs'])) {
            $json['type'] = 'error';
            $json['message'] = 'Geçersiz veri girişi';
            print json_encode($json);
            return;
        }

        $playlist_id = intval($_POST['playlist_id']);
        
        // Önce mevcut şarkıları temizle
        self::$db->delete(self::playlistSongTable, "playlist_id=" . $playlist_id);
        
        // Sonra yeni şarkıları ekle
        $position = 0;
        foreach ($_POST['songs'] as $song_id) {
            $sdata = array(
                'playlist_id' => $playlist_id,
                'song_id' => intval($song_id),
                'position' => $position++,
                'created' => "NOW()"
            );
            self::$db->insert(self::playlistSongTable, $sdata);
        }

        if (self::$db->affected()) {
            $json['type'] = 'success';
            $json['message'] = Filter::msgOk('Playlist şarkıları başarıyla güncellendi', false);
        } else {
            $json['type'] = 'success';
            $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
        }
        print json_encode($json);
    }

    /**
     * MuzibuPlaylist::deletePlaylist()
     * 
     * @param int $id
     * @return
     */
    public static function deletePlaylist($id)
    {
        $id = intval($id);
        
        // İlk önce playlist resmi siliniyor
        $playlist = self::$db->first("SELECT thumb FROM " . self::playlistTable . " WHERE id = " . $id);
        if ($playlist && $playlist->thumb) {
            $filedir = BASEPATH . self::imagepath;
            $filepath = $filedir . $playlist->thumb;
            if (file_exists($filepath)) {
                @unlink($filepath);
            }
        }
        
        // İlişkili playlist-sector kayıtlarını sil
        self::$db->delete(self::playlistSectorTable, "playlist_id = " . $id);
        
        // İlişkili playlist-song kayıtlarını sil
        self::$db->delete(self::playlistSongTable, "playlist_id = " . $id);
        
        // Playlist'i sil
        self::$db->delete(self::playlistTable, "id = " . $id);
        
        return self::$db->affected();
    }


    /**
     * MuzibuPlaylist::getPlaylistsByUser()
     * 
     * @param int $user_id
     * @return
     */
    public function getPlaylistsByUser($user_id)
    {
        $user_id = intval($user_id);
        
        $sql = "SELECT p.*, u.fname, u.lname, u.username, COUNT(ps.song_id) as song_count, a.title_tr AS album_name,a.thumb AS album_thumb 
                FROM " . self::playlistTable . " as p
                LEFT JOIN " . self::usersTable . " as u ON u.id = p.user_id
                LEFT JOIN " . self::playlistSongTable . " as ps ON ps.playlist_id = p.id
                LEFT JOIN " . self::songTable . " AS s ON s.id = ps.song_id
                LEFT JOIN " . self::albumTable . " AS a ON a.id = s.album_id
                WHERE p.user_id = " . $user_id . "
                GROUP BY p.id
                ORDER BY p.created DESC";

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }
    
    public function getPlaylists($page=1,$ipp=8)
    {
        $offset = ($page-1)*$ipp;
        
        
        $sql = "SELECT p.*, u.fname, u.lname, u.username, COUNT(ps.song_id) as song_count, a.title_tr AS album_name,a.thumb AS album_thumb 
                FROM " . self::playlistTable . " as p
                LEFT JOIN " . self::usersTable . " as u ON u.id = p.user_id
                LEFT JOIN " . self::playlistSongTable . " as ps ON ps.playlist_id = p.id
                LEFT JOIN " . self::songTable . " AS s ON s.id = ps.song_id
                LEFT JOIN " . self::albumTable . " AS a ON a.id = s.album_id
                WHERE p.user_id = 1
                GROUP BY p.id
                ORDER BY p.created DESC
                LIMIT ".$offset.",".$ipp;
                
        $row = self::$db->fetch_all($sql);
        return ($row) ? $row : 0;
    }
    
    public function getPlaylistCount()
    {

        $sql = "SELECT p.*, u.fname, u.lname, u.username, COUNT(ps.song_id) as song_count, a.title_tr AS album_name,a.thumb AS album_thumb 
                FROM " . self::playlistTable . " as p
                LEFT JOIN " . self::usersTable . " as u ON u.id = p.user_id
                LEFT JOIN " . self::playlistSongTable . " as ps ON ps.playlist_id = p.id
                LEFT JOIN " . self::songTable . " AS s ON s.id = ps.song_id
                LEFT JOIN " . self::albumTable . " AS a ON a.id = s.album_id
                WHERE p.user_id = 1
                GROUP BY p.id
                ORDER BY p.created DESC";
                
        $count = count(self::$db->fetch_all($sql));
        
        return $count;
    }
    
    public function getUserPlaylistIDsBySong($user_id,$song_id)
    {
        $user_id = intval($user_id);
        $song_id = intval($song_id);
        $sql = "SELECT p.id
                FROM " . self::playlistTable . " as p
                LEFT JOIN " . self::playlistSongTable . " as ps ON ps.playlist_id = p.id
                WHERE p.user_id = " . $user_id . "
                AND ps.song_id = " . $song_id . "
                ORDER BY p.created DESC";

        $rows = self::$db->fetch_all($sql);
        
        $ids = array();
        foreach($rows as $row){
            $ids[]=$row->id;
        }
        
        return $ids;
    }

    /**
     * MuzibuPlaylist::updateSongOrder()
     * 
     * @return
     */
    public static function updateSongOrder()
    {
        if (!isset($_POST['playlist_id']) || !isset($_POST['node'])) {
            return false;
        }
        
        $playlist_id = intval($_POST['playlist_id']);
        
        foreach ($_POST['node'] as $k => $v) {
            $p = $k + 1;
            $data = array('position' => intval($p));
            self::$db->update(self::playlistSongTable, $data, "playlist_id=" . $playlist_id . " AND song_id=" . (int)$v);
        }
        
        return true;
    }
}