<?php
/**
 * Muzibu Homepage Class
 *
 * @yazilim CMS PRO
 * @web adresi turkbilisim.com.tr
 * @copyright 2024
 * @version $Id: admin_class_homepage.php, v1.00 2024-03-04 09:00:00 
 */

if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

class MuzibuHomepage
{
    const songTable = "muzibu_songs";
    const albumTable = "muzibu_albums";
    const artistTable = "muzibu_artists";
    const genreTable = "muzibu_genres";
    const playlistTable = "muzibu_playlists";
    const playlistSongTable = "muzibu_playlist_song";
    const favoriteTable = "muzibu_favorites";
    const playTable = "muzibu_song_plays";
    const imagepath = "modules/muzibu/dataimages/";
    const filepath = "modules/muzibu/datafiles/";

    private static $db;

    /**
     * MuzibuHomepage::__construct()
     * 
     * @return
     */
    function __construct()
    {
        self::$db = Registry::get("Database");
    }

    /**
     * MuzibuHomepage::getNewReleases()
     * 
     * @param int $limit
     * @return
     */
    public function getNewReleases($limit = 5)
    {
        $sql = "SELECT s.*, a.title" . Lang::$lang . " as artist_title, 
                l.title" . Lang::$lang . " as album_title, 
                g.title" . Lang::$lang . " as genre_title,
                l.thumb as album_thumb" 
        . "\n FROM " . self::songTable . " as s" 
        . "\n LEFT JOIN " . self::albumTable . " as l ON l.id = s.album_id" 
        . "\n LEFT JOIN " . self::artistTable . " as a ON a.id = l.artist_id" 
        . "\n LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id" 
        . "\n WHERE s.active = 1"
        . "\n ORDER BY s.created DESC"
        . "\n LIMIT " . intval($limit);
        
        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuHomepage::getLatestNewRelease()
     * 
     * @return
     */
    public function getLatestNewRelease()
    {
        $sql = "SELECT s.*, a.title" . Lang::$lang . " as artist_title, 
                l.title" . Lang::$lang . " as album_title, 
                g.title" . Lang::$lang . " as genre_title,
                l.thumb as album_thumb" 
        . "\n FROM " . self::songTable . " as s" 
        . "\n LEFT JOIN " . self::albumTable . " as l ON l.id = s.album_id" 
        . "\n LEFT JOIN " . self::artistTable . " as a ON a.id = l.artist_id" 
        . "\n LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id" 
        . "\n WHERE s.active = 1 AND s.is_featured = 1"
        . "\n ORDER BY s.created DESC"
        . "\n LIMIT 1";
        
        $row = self::$db->first($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuHomepage::getTrendingMusic()
     * 
     * @param int $limit
     * @return
     */
    public function getTrendingMusic($limit = 7)
    {
        $sql = "SELECT s.*, a.title" . Lang::$lang . " as artist_title, 
                l.title" . Lang::$lang . " as album_title, 
                g.title" . Lang::$lang . " as genre_title,
                l.thumb as album_thumb,
                COUNT(p.id) as play_count" 
        . "\n FROM " . self::songTable . " as s" 
        . "\n LEFT JOIN " . self::albumTable . " as l ON l.id = s.album_id" 
        . "\n LEFT JOIN " . self::artistTable . " as a ON a.id = l.artist_id" 
        . "\n LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id" 
        . "\n LEFT JOIN " . self::playTable . " as p ON p.song_id = s.id" 
        . "\n WHERE s.active = 1"
        . "\n GROUP BY s.id"
        . "\n ORDER BY play_count DESC, s.created DESC"
        . "\n LIMIT " . intval($limit);
        
        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuHomepage::getPopularThisWeek()
     * 
     * @param int $limit
     * @return
     */
    public function getPopularThisWeek($limit = 5)
    {
        $lastWeek = date('Y-m-d H:i:s', strtotime('-7 days'));
        
        $sql = "SELECT s.*, a.title" . Lang::$lang . " as artist_title, 
                l.title" . Lang::$lang . " as album_title, 
                g.title" . Lang::$lang . " as genre_title,
                l.thumb as album_thumb,
                COUNT(p.id) as play_count" 
        . "\n FROM " . self::songTable . " as s" 
        . "\n LEFT JOIN " . self::albumTable . " as l ON l.id = s.album_id" 
        . "\n LEFT JOIN " . self::artistTable . " as a ON a.id = l.artist_id" 
        . "\n LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id" 
        . "\n LEFT JOIN " . self::playTable . " as p ON p.song_id = s.id AND p.created >= '" . $lastWeek . "'"
        . "\n WHERE s.active = 1"
        . "\n GROUP BY s.id"
        . "\n ORDER BY play_count DESC, s.created DESC"
        . "\n LIMIT " . intval($limit);
        
        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuHomepage::getTopRecommendations()
     * 
     * @param int $limit
     * @return
     */
    public function getTopRecommendations($limit = 5)
    {
        // Bu fonksiyon kullanıcının dinleme geçmişine göre özelleştirilmiş öneriler sunabilir
        // Şimdilik en çok dinlenen ve öne çıkan şarkıları getiriyoruz
        $sql = "SELECT s.*, a.title" . Lang::$lang . " as artist_title, 
                l.title" . Lang::$lang . " as album_title, 
                g.title" . Lang::$lang . " as genre_title,
                l.thumb as album_thumb" 
        . "\n FROM " . self::songTable . " as s" 
        . "\n LEFT JOIN " . self::albumTable . " as l ON l.id = s.album_id" 
        . "\n LEFT JOIN " . self::artistTable . " as a ON a.id = l.artist_id" 
        . "\n LEFT JOIN " . self::genreTable . " as g ON g.id = s.genre_id" 
        . "\n WHERE s.active = 1 AND s.is_featured = 1"
        . "\n ORDER BY s.play_count DESC, s.created DESC"
        . "\n LIMIT " . intval($limit);
        
        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuHomepage::getPopularArtists()
     * 
     * @param int $limit
     * @return
     */
    public function getPopularArtists($limit = 7)
    {
        $sql = "SELECT a.*, COUNT(s.id) as song_count 
                FROM " . self::artistTable . " as a
                LEFT JOIN " . self::albumTable . " as al ON al.artist_id = a.id
                LEFT JOIN " . self::songTable . " as s ON s.album_id = al.id
                WHERE a.active = 1
                GROUP BY a.id
                ORDER BY song_count DESC, a.title" . Lang::$lang . "
                LIMIT " . intval($limit);

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }
    
    public function getPopularGenres($limit = 7)
    {
        $sql = "SELECT g.*, COUNT(s.id) as song_count 
                FROM " . self::genreTable . " as g
                LEFT JOIN " . self::songTable . " as s ON s.genre_id = g.id
                GROUP BY g.id
                ORDER BY song_count DESC
                LIMIT " . intval($limit);

        $row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
    }

    /**
     * MuzibuHomepage::getInterestingAlbums()
     * 
     * @param int $limit
     * @return
     */
    public function getInterestingAlbums($limit = 7)
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
     * MuzibuHomepage::getUpcomingReleases()
     * 
     * @return
     */
    public function getUpcomingReleases()
    {
        // Bu fonksiyon gelecek müzik yayınlarını getirebilir
        // Şimdilik örnek bir veri dönüyoruz
        $releases = new stdClass();
        $releases->title = "Yeni Şarkımızı Dinlemek İçin Hazır Olun";
        $releases->days = 10;    // Örnek: 10 gün sonra yayınlanacak
        $releases->hours = 5;    // Örnek: 5 saat sonra yayınlanacak
        $releases->minutes = 30; // Örnek: 30 dakika sonra yayınlanacak
        $releases->seconds = 0;  // Örnek: 0 saniye sonra yayınlanacak
        
        return $releases;
    }
}