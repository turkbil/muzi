<?php
/**
 * Muzibu Sector Class
 *
 * @yazilim CMS PRO
 * @web adresi turkbilisim.com.tr
 * @copyright 2024
 * @version $Id: admin_class_sector.php, v1.00 2024-03-01 15:00:00 
 */

if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

class MuzibuSector
{
    const sectorTable = "muzibu_sectors";
    const playlistSectorTable = "muzibu_playlist_sector";
    const imagepath = "modules/muzibu/dataimages/";

    private static $db;

    /**
     * MuzibuSector::__construct()
     * 
     * @return
     */
    function __construct()
    {
        self::$db = Registry::get("Database");
    }

    /**
     * MuzibuSector::getAllSectors()
     * 
     * @return
     */
    public function getAllSectors()
    {
        // Sayfalama için gerekli ayarlar
        $pager = Paginator::instance();
        $pager->items_total = countEntries(self::sectorTable);
        $pager->default_ipp = Registry::get("Core")->perpage;
        $pager->paginate();

        $sql = "SELECT s.*, COUNT(ps.playlist_id) as playlist_count 
                FROM " . self::sectorTable . " as s
                LEFT JOIN " . self::playlistSectorTable . " as ps ON ps.sector_id = s.id
                GROUP BY s.id
                ORDER BY s.title" . Lang::$lang . $pager->limit;

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuSector::getSectorById()
     * 
     * @param int $id
     * @return
     */
    public function getSectorById($id)
    {
        $sql = "SELECT * 
                FROM " . self::sectorTable . " 
                WHERE id = " . intval($id);

        $row = self::$db->first($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuSector::getSectorBySlug()
     * 
     * @param string $slug
     * @return
     */
    public function getSectorBySlug($slug)
    {
        $sql = "SELECT * 
                FROM " . self::sectorTable . " 
                WHERE slug = '" . self::$db->escape($slug) . "'";

        $row = self::$db->first($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuSector::getPlaylistsBySector()
     * 
     * @param int $sector_id
     * @return
     */
    public function getPlaylistsBySector($sector_id)
    {
        $sql = "SELECT p.* 
                FROM " . self::playlistSectorTable . " as ps
                JOIN muzibu_playlists as p ON p.id = ps.playlist_id
                WHERE ps.sector_id = " . intval($sector_id) . "
                AND p.active = 1 AND p.is_public = 1
                ORDER BY p.title" . Lang::$lang;

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuSector::processSector()
     * 
     * @return
     */
    public function processSector()
    {
        Filter::checkPost('title_tr', 'Sektör Adı');

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
                'title_tr' => sanitize($_POST['title_tr']), 
                'slug' => (empty($_POST['slug'])) ? doSeo($_POST['title_tr']) : doSeo($_POST['slug'])
            );

            if (!Filter::$id) {
                $data['created'] = "NOW()";
            }

            // Process Sector Thumbnail
            if (!empty($_FILES['thumb']['name'])) {
                $thumbdir = BASEPATH . self::imagepath;
                
                // Dizin kontrolü ve oluşturma
                if (!file_exists($thumbdir)) {
                    mkdir($thumbdir, 0755, true);
                }
                
                $tName = 'SECTOR_' . randomString(6, true);
                $text = substr($_FILES['thumb']['name'], strrpos($_FILES['thumb']['name'], '.') + 1);
                $thumbName = $tName . "-" . randomString(6, true) . "-" . randomString(6, true) . "-" . randomString(6, true) . "-" . randomString(6, true) . "-" . randomString(6, true);
                $thumbName = $thumbName . "." . strtolower($text);
                $thumbPath = $thumbdir . $thumbName;
                
                if (Filter::$id && $file = getValueById("thumb", self::sectorTable, Filter::$id)) {
                    $oldFile = $thumbdir . $file;
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }
                
                if ($this->moveFile($_FILES['thumb']['tmp_name'], $thumbPath)) {
                    $data['thumb'] = $thumbName;
                }
            }

            if (!Filter::$id) {
                $sector_id = self::$db->insert(self::sectorTable, $data);
                $message = 'Sektör başarıyla eklendi';
            } else {
                self::$db->update(self::sectorTable, $data, "id=" . Filter::$id);
                $sector_id = Filter::$id;
                $message = 'Sektör başarıyla güncellendi';
            }

            // Önce mevcut playlist ilişkilerini temizle
            if (Filter::$id) {
                self::$db->delete(self::playlistSectorTable, "sector_id=" . Filter::$id);
            }

            // Yeni playlist ilişkilerini ekle
            if (isset($_POST['playlists']) && is_array($_POST['playlists'])) {
                foreach ($_POST['playlists'] as $playlist_id) {
                    $playlist_data = array(
                        'sector_id' => $sector_id,
                        'playlist_id' => intval($playlist_id)
                    );
                    self::$db->insert(self::playlistSectorTable, $playlist_data);
                }
            }

            $json['type'] = 'success';
            $json['message'] = Filter::msgOk($message, false);
            print json_encode($json);

        } else {
            $json['type'] = 'error';
            $json['message'] = Filter::msgStatus();
            print json_encode($json);
        }
    }

    /**
     * MuzibuSector::deleteSector()
     * 
     * @param int $id
     * @return
     */
    public static function deleteSector($id)
    {
        $id = intval($id);
        
        // İlk önce sektör resmi siliniyor
        $sector = self::$db->first("SELECT thumb FROM " . self::sectorTable . " WHERE id = " . $id);
        if ($sector && $sector->thumb) {
            $filedir = BASEPATH . self::imagepath;
            $filepath = $filedir . $sector->thumb;
            if (file_exists($filepath)) {
                @unlink($filepath);
            }
        }
        
        // İlişkili playlist-sector kayıtlarını sil
        self::$db->delete(self::playlistSectorTable, "sector_id = " . $id);
        
        // Sektörü sil
        self::$db->delete(self::sectorTable, "id = " . $id);
        
        return self::$db->affected();
    }

    /**
     * MuzibuSector::updateOrder()
     * 
     * @return
     */
    public static function updateOrder()
    {
        foreach ($_POST['node'] as $k => $v) {
            $p = $k + 1;
            $data['position'] = intval($p);
            self::$db->update(self::sectorTable, $data, "id=" . (int)$v);
        }
    }
    
    public function moveFile($tmpPath, $destinationPath) {
        // Geçici dosya mevcut mu?
        if (!is_uploaded_file($tmpPath)) {
            return false;
        }
    
        // Hedef dizin varsa oluştur
        $destinationDir = dirname($destinationPath);
        if (!is_dir($destinationDir)) {
            if (!mkdir($destinationDir, 0755, true)) {
                return false;
            }
        }
    
        // Dosyayı taşı
        if (move_uploaded_file($tmpPath, $destinationPath)) {
            return true;
        }
    
        return false;
    }
}