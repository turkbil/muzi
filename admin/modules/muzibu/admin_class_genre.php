<?php
/**
 * Muzibu Genre Class
 *
 * @yazilim CMS PRO
 * @web adresi turkbilisim.com.tr
 * @copyright 2024
 * @version $Id: admin_class_genre.php, v1.00 2024-03-01 13:00:00 
 */

if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

class MuzibuGenre
{
    const genreTable = "muzibu_genres";
    const songTable = "muzibu_songs";
    const imagepath = "modules/muzibu/dataimages/";

    private static $db;

    /**
     * MuzibuGenre::__construct()
     * 
     * @return
     */
    function __construct()
    {
        self::$db = Registry::get("Database");
    }

    /**
     * MuzibuGenre::getAllGenres()
     * 
     * @return
     */
    public function getAllGenres()
    {
        $sql = "SELECT g.*, COUNT(s.id) as song_count 
                FROM " . self::genreTable . " as g
                LEFT JOIN " . self::songTable . " as s ON s.genre_id = g.id
                GROUP BY g.id
                ORDER BY g.title" . Lang::$lang;

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuGenre::getPopularGenres()
     * 
     * @param int $limit
     * @return
     */
    public function getPopularGenres($limit = 6)
    {
        $sql = "SELECT g.*, COUNT(s.id) as song_count 
                FROM " . self::genreTable . " as g
                LEFT JOIN " . self::songTable . " as s ON s.genre_id = g.id
                GROUP BY g.id
                ORDER BY song_count DESC, g.title" . Lang::$lang . "
                LIMIT " . intval($limit);

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuGenre::getGenreById()
     * 
     * @param int $id
     * @return
     */
    public function getGenreById($id)
    {
        $sql = "SELECT * 
                FROM " . self::genreTable . " 
                WHERE id = " . intval($id);

        $row = self::$db->first($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuGenre::getGenreBySlug()
     * 
     * @param string $slug
     * @return
     */
    public function getGenreBySlug($slug)
    {
        $sql = "SELECT * 
                FROM " . self::genreTable . " 
                WHERE slug = '" . self::$db->escape($slug) . "'";

        $row = self::$db->first($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuGenre::processGenre()
     * 
     * @return
     */
    public function processGenre()
    {
        Filter::checkPost('title' . Lang::$lang, 'Müzik Türü');

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
            );

            if (!Filter::$id) {
                $data['created'] = "NOW()";
            }

            // Process Genre Thumbnail
            if (!empty($_FILES['thumb']['name'])) {
                $filedir = BASEPATH . self::imagepath;
                
                // Dizin kontrolü ve oluşturma
                if (!file_exists($filedir)) {
                    mkdir($filedir, 0755, true);
                }
                
                $newName = "GENRE_" . randName();
                $ext = substr($_FILES['thumb']['name'], strrpos($_FILES['thumb']['name'], '.') + 1);
                $fullname = $filedir . $newName . "." . strtolower($ext);

                if (Filter::$id && $file = getValueById("thumb", self::genreTable, Filter::$id)) {
                    @unlink($filedir . $file);
                }

                if (!move_uploaded_file($_FILES['thumb']['tmp_name'], $fullname)) {
                    die(Filter::msgError("Dosya geçici klasörden hedef klasöre taşınamadı. Dizin yolu: " . $filedir, false));
                }
                $data['thumb'] = $newName . "." . strtolower($ext);
            }

            (Filter::$id) ? self::$db->update(self::genreTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::genreTable, $data);
            $message = (Filter::$id) ? 'Müzik türü başarıyla güncellendi' : 'Müzik türü başarıyla eklendi';

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
     * MuzibuGenre::deleteGenre()
     * 
     * @param int $id
     * @return
     */
    public static function deleteGenre($id)
    {
        $id = intval($id);
        
        // İlk önce tür resmi siliniyor
        $genre = self::$db->first("SELECT thumb FROM " . self::genreTable . " WHERE id = " . $id);
        if ($genre && $genre->thumb) {
            $filedir = BASEPATH . self::imagepath;
            @unlink($filedir . $genre->thumb);
        }
        
        // Türe ait şarkıların genre_id'si varsayılan bir değere atanabilir, ancak SQL yapısından bu zorunlu bir alan
        // Bu nedenle varsayılan bir tür ID belirleyip ona atama yapmak gerekebilir
        // Ya da silme işlemi öncesi kontrol yapıp şarkı varsa silmeyi engellemek gerekebilir
        
        // Tür siliniyor
        self::$db->delete(self::genreTable, "id = " . $id);
        
        return self::$db->affected();
    }

    /**
     * MuzibuGenre::updateOrder()
     * 
     * @return
     */
    public static function updateOrder()
    {
        foreach ($_POST['node'] as $k => $v) {
            $p = $k + 1;
            $data['position'] = intval($p);
            self::$db->update(self::genreTable, $data, "id=" . (int)$v);
        }
    }
}