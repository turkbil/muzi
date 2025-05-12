<?php
/**
 * Muzibu Album Class
 *
 * @yazilim CMS PRO
 * @web adresi turkbilisim.com.tr
 * @copyright 2024
 * @version $Id: admin_class_album.php, v1.00 2024-03-01 10:00:00 
 */

if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

class MuzibuAlbum
{
    const albumTable = "muzibu_albums";
    const artistTable = "muzibu_artists";
    const songTable = "muzibu_songs";
    const imagepath = "modules/muzibu/dataimages/";

    private static $db;

    /**
     * MuzibuAlbum::__construct()
     * 
     * @return
     */
    function __construct()
    {
        self::$db = Registry::get("Database");
    }

    /**
     * MuzibuAlbum::getAllAlbums()
     * 
     * @return
     */
    public function getAllAlbums()
    {
        // Sayfalama için gerekli ayarlar
        $pager = Paginator::instance();
        $pager->items_total = countEntries(self::albumTable);
        $pager->default_ipp = Registry::get("Core")->perpage;
        $pager->paginate();

        $sql = "SELECT a.*, ar.title" . Lang::$lang . " as artist_name, 
                COUNT(s.id) as song_count"
        . "\n FROM " . self::albumTable . " as a"
        . "\n LEFT JOIN " . self::artistTable . " as ar ON ar.id = a.artist_id"
        . "\n LEFT JOIN " . self::songTable . " as s ON s.album_id = a.id"
        . "\n GROUP BY a.id"
        . "\n ORDER BY a.created DESC" . $pager->limit;

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }
	
	public function searchAlbums($keywords)
    {
        $sql = "SELECT a.*, ar.title" . Lang::$lang . " as artist_name, 
                COUNT(s.id) as song_count"
        . "\n FROM " . self::albumTable . " as a"
        . "\n LEFT JOIN " . self::artistTable . " as ar ON ar.id = a.artist_id"
        . "\n LEFT JOIN " . self::songTable . " as s ON s.album_id = a.id"
		. "\n WHERE a.title_tr LIKE '%".$keywords."%'"
        . "\n GROUP BY a.id"
        . "\n ORDER BY a.created DESC";

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuAlbum::getFeaturedAlbums()
     * 
     * @param int $limit
     * @return
     */
    public function getFeaturedAlbums($limit = 6)
    {
        $sql = "SELECT a.*, ar.title" . Lang::$lang . " as artist_name, COUNT(s.id) as song_count"
        . "\n FROM " . self::albumTable . " as a"
        . "\n LEFT JOIN " . self::artistTable . " as ar ON ar.id = a.artist_id"
        . "\n LEFT JOIN " . self::songTable . " as s ON s.album_id = a.id"
        . "\n WHERE a.active = 1"
        . "\n GROUP BY a.id"
        . "\n ORDER BY a.created DESC"
        . "\n LIMIT " . intval($limit);

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuAlbum::getAlbumById()
     * 
     * @param int $id
     * @return
     */
    public function getAlbumById($id)
    {
        $sql = "SELECT a.*, ar.title" . Lang::$lang . " as artist_name, 
                ar.slug as artist_slug, ar.thumb as artist_thumb"
        . "\n FROM " . self::albumTable . " as a"
        . "\n LEFT JOIN " . self::artistTable . " as ar ON ar.id = a.artist_id"
        . "\n WHERE a.id = " . intval($id);

        $row = self::$db->first($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuAlbum::getAlbumBySlug()
     * 
     * @param string $slug
     * @return
     */
    public function getAlbumBySlug($slug)
    {
        $sql = "SELECT a.*, ar.title" . Lang::$lang . " as artist_name, 
                ar.slug as artist_slug, ar.thumb as artist_thumb"
        . "\n FROM " . self::albumTable . " as a"
        . "\n LEFT JOIN " . self::artistTable . " as ar ON ar.id = a.artist_id"
        . "\n WHERE a.slug = '" . self::$db->escape($slug) . "'";

        $row = self::$db->first($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuAlbum::getAlbumsByArtist()
     * 
     * @param int $artist_id
     * @param bool $paginate Sayfalama aktif mi?
     * @return
     */
    public function getAlbumsByArtist($artist_id, $paginate = false)
    {
        $artist_id = intval($artist_id);
        
        // Sayfalama için sayım sorgusu
        if ($paginate) {
            $q = "SELECT COUNT(a.id) FROM " . self::albumTable . " as a 
                WHERE a.artist_id = " . $artist_id . " AND a.active = 1";
            $record = self::$db->query($q);
            $total = self::$db->fetchrow($record);
            
            $pager = Paginator::instance();
            $pager->items_total = $total[0];
            $pager->default_ipp = 8; // Sayfa başına gösterilecek albüm sayısı
            $pager->path = SITEURL . "/admin/index.php?do=modules&action=config&modname=muzibu&maction=artist_songs&id=" . $artist_id . "&";
            $pager->paginate();
            
            $limit = $pager->limit;
        } else {
            $limit = "";
        }
        
        $sql = "SELECT a.*, COUNT(s.id) as song_count"
        . "\n FROM " . self::albumTable . " as a"
        . "\n LEFT JOIN " . self::songTable . " as s ON s.album_id = a.id"
        . "\n WHERE a.artist_id = " . $artist_id . " AND a.active = 1"
        . "\n GROUP BY a.id"
        . "\n ORDER BY a.created DESC" . $limit;

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuAlbum::getRecentAlbums()
     * 
     * @param int $limit
     * @return
     */
    public function getRecentAlbums($limit = 10)
    {
        $sql = "SELECT a.*, ar.title" . Lang::$lang . " as artist_name, 
                COUNT(s.id) as song_count"
        . "\n FROM " . self::albumTable . " as a"
        . "\n LEFT JOIN " . self::artistTable . " as ar ON ar.id = a.artist_id"
        . "\n LEFT JOIN " . self::songTable . " as s ON s.album_id = a.id"
        . "\n WHERE a.active = 1"
        . "\n GROUP BY a.id"
        . "\n ORDER BY a.created DESC"
        . "\n LIMIT " . intval($limit);

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuAlbum::processAlbum()
     * 
     * @return
     */
    public function processAlbum()
    {
        Filter::checkPost('title' . Lang::$lang, 'Albüm Adı');

        if (!empty($_FILES['thumb']['name'])) {
            if (!preg_match("/(\.jpg|\.png|\.jpeg)$/i", $_FILES['thumb']['name'])) {
                Filter::$msgs['thumb'] = Lang::$word->_CG_LOGO_R;
            }
            $file_info = getimagesize($_FILES['thumb']['tmp_name']);
            if (empty($file_info))
                Filter::$msgs['thumb'] = Lang::$word->_CG_LOGO_R;
        }

        if (empty(Filter::$msgs)) {
            $data = array(
                'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
                'slug' => (empty($_POST['slug'])) ? doSeo($_POST['title' . Lang::$lang]) : doSeo($_POST['slug']),
                'description' . Lang::$lang => Filter::in_url($_POST['description' . Lang::$lang]),
                'artist_id' => intval($_POST['artist_id']),
                'created' => (!empty($_POST['created']) && strtotime($_POST['created'])) ? sanitize($_POST['created']) : date('Y-m-d'),
                'active' => intval($_POST['active']),
            );

            if (!Filter::$id) {
                $data['created'] = "NOW()";
            }

            // Process Image
            if (!empty($_FILES['thumb']['name'])) {
                $filedir = BASEPATH . self::imagepath;
                
                // Dizin kontrolü ve oluşturma
                if (!file_exists($filedir)) {
                    mkdir($filedir, 0755, true);
                }
                
                $newName = "ALBUM_" . randName();
                $ext = substr($_FILES['thumb']['name'], strrpos($_FILES['thumb']['name'], '.') + 1);
                $fullname = $filedir . $newName . "." . strtolower($ext);

                if (Filter::$id && $file = getValueById("thumb", self::albumTable, Filter::$id)) {
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

            (Filter::$id) ? self::$db->update(self::albumTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::albumTable, $data);
            $message = (Filter::$id) ? 'Albüm başarıyla güncellendi' : 'Albüm başarıyla eklendi';

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
     * MuzibuAlbum::deleteAlbum()
     * 
     * @param int $id
     * @return
     */
    public static function deleteAlbum($id)
    {
        $id = intval($id);
        
        // İlk önce albüm resmi siliniyor
        $album = self::$db->first("SELECT thumb FROM " . self::albumTable . " WHERE id = " . $id);
        if ($album && $album->thumb) {
            $filedir = BASEPATH . self::imagepath;
            $filepath = $filedir . $album->thumb;
            if (file_exists($filepath)) {
                @unlink($filepath);
            }
        }
        
        // Albüme ait şarkıların albüm_id'si sıfırlanıyor (şarkılar silinmiyor)
        $data = array('album_id' => 0);
        self::$db->update(self::songTable, $data, "album_id = " . $id);
        
        // Albüm siliniyor
        self::$db->delete(self::albumTable, "id = " . $id);
        
        return self::$db->affected();
    }

    /**
     * MuzibuAlbum::updateOrder()
     * 
     * @return
     */
    public static function updateOrder()
    {
        foreach ($_POST['node'] as $k => $v) {
            $p = $k + 1;
            $data['position'] = intval($p);
            self::$db->update(self::albumTable, $data, "id=" . (int)$v);
        }
    }
}