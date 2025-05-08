<?php
/**
 * Muzibu Artist Class
 *
 * @yazilim CMS PRO
 * @web adresi turkbilisim.com.tr
 * @copyright 2024
 * @version $Id: admin_class_artist.php, v1.00 2024-03-01 12:00:00 
 */

if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

class MuzibuArtist
{
    const artistTable = "muzibu_artists";
    const albumTable = "muzibu_albums";
    const songTable = "muzibu_songs";
    const imagepath = "modules/muzibu/dataimages/";

    private static $db;

    /**
     * MuzibuArtist::__construct()
     * 
     * @return
     */
    function __construct()
    {
        self::$db = Registry::get("Database");
    }

    /**
     * MuzibuArtist::getAllArtists()
     * 
     * @return
     */
    public function getAllArtists()
    {
        $sql = "SELECT a.*, COUNT(al.id) as album_count 
                FROM " . self::artistTable . " as a
                LEFT JOIN " . self::albumTable . " as al ON al.artist_id = a.id
                GROUP BY a.id
                ORDER BY a.title" . Lang::$lang;

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuArtist::getFeaturedArtists()
     * 
     * @param int $limit
     * @return
     */
    public function getFeaturedArtists($limit = 6)
    {
        $sql = "SELECT a.*, COUNT(al.id) as album_count 
                FROM " . self::artistTable . " as a
                LEFT JOIN " . self::albumTable . " as al ON al.artist_id = a.id
                WHERE a.active = 1
                GROUP BY a.id
                ORDER BY album_count DESC, a.title" . Lang::$lang . "
                LIMIT " . intval($limit);

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuArtist::getArtistById()
     * 
     * @param int $id
     * @return
     */
    public function getArtistById($id)
    {
        $sql = "SELECT * 
                FROM " . self::artistTable . " 
                WHERE id = " . intval($id);

        $row = self::$db->first($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuArtist::getArtistBySlug()
     * 
     * @param string $slug
     * @return
     */
    public function getArtistBySlug($slug)
    {
        $sql = "SELECT * 
                FROM " . self::artistTable . " 
                WHERE slug = '" . self::$db->escape($slug) . "'";

        $row = self::$db->first($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuArtist::processArtist()
     * 
     * @return
     */
    public function processArtist()
    {
        Filter::checkPost('title' . Lang::$lang, 'Sanatçı Adı');

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
                'bio' . Lang::$lang => Filter::in_url($_POST['bio' . Lang::$lang]),
                'active' => intval($_POST['active']),
            );

            if (!Filter::$id) {
                $data['created'] = "NOW()";
            }

            // Process Artist thumb
            if (!empty($_FILES['thumb']['name'])) {
                $filedir = BASEPATH . self::imagepath;
                
                // Dizin kontrolü ve oluşturma
                if (!file_exists($filedir)) {
                    mkdir($filedir, 0755, true);
                }
                
                $newName = "ARTIST_" . randName();
                $ext = substr($_FILES['thumb']['name'], strrpos($_FILES['thumb']['name'], '.') + 1);
                $fullname = $filedir . $newName . "." . strtolower($ext);

                if (Filter::$id && $file = getValueById("thumb", self::artistTable, Filter::$id)) {
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

            (Filter::$id) ? self::$db->update(self::artistTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::artistTable, $data);
            $message = (Filter::$id) ? 'Sanatçı başarıyla güncellendi' : 'Sanatçı başarıyla eklendi';

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
     * MuzibuArtist::deleteArtist()
     * 
     * @param int $id
     * @return
     */
    public static function deleteArtist($id)
    {
        $id = intval($id);
        
        // İlk önce sanatçı resmi siliniyor
        $artist = self::$db->first("SELECT thumb FROM " . self::artistTable . " WHERE id = " . $id);
        if ($artist && $artist->thumb) {
            $filedir = BASEPATH . self::imagepath;
            $filepath = $filedir . $artist->thumb;
            if (file_exists($filepath)) {
                @unlink($filepath);
            }
        }
        
        // Sanatçıya ait albümlerin artist_id'si sıfırlanıyor (albümler silinmiyor)
        $data = array('artist_id' => 0);
        self::$db->update(self::albumTable, $data, "artist_id = " . $id);
        
        // Sanatçı siliniyor
        self::$db->delete(self::artistTable, "id = " . $id);
        
        return self::$db->affected();
    }

    /**
     * MuzibuArtist::updateOrder()
     * 
     * @return
     */
    public static function updateOrder()
    {
        foreach ($_POST['node'] as $k => $v) {
            $p = $k + 1;
            $data['position'] = intval($p);
            self::$db->update(self::artistTable, $data, "id=" . (int)$v);
        }
    }
}