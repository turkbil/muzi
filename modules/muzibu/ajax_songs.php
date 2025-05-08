<?php
/**
 * Muzibu - AJAX Song Handler
 *
 * @package Muzibu Module
 * @author geliştiren
 * @copyright 2024
 */
 
define("_VALID_PHP", true);
require_once("../../init.php");

// JSON başlığı
header('Content-Type: application/json');

// Veritabanı bağlantısı
$db = Registry::get("Database");

// Müzik sınıfını dahil et
require_once("admin_class.php");

try {
    // Parametreleri al
    $action = isset($_GET['action']) ? $_GET['action'] : '';
    $playlist_id = isset($_GET['playlist_id']) ? intval($_GET['playlist_id']) : 0;
    $genre_id = isset($_GET['genre_id']) ? intval($_GET['genre_id']) : 0;
    $artist_id = isset($_GET['artist_id']) ? intval($_GET['artist_id']) : 0;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    $offset = ($page - 1) * $limit;
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
    
    // Türkçe karakter normalizasyonu için fonksiyon
    function normalizeSearchTerm($text) {
        $search = array('İ', 'I', 'Ş', 'ş', 'Ğ', 'ğ', 'Ü', 'ü', 'Ö', 'ö', 'Ç', 'ç', 'ı');
        $replace = array('i', 'i', 's', 's', 'g', 'g', 'u', 'u', 'o', 'o', 'c', 'c', 'i');
        return str_replace($search, $replace, mb_strtolower($text, 'UTF-8'));
    }
    
    // Arama kelimesini normalize et
    $normalizedKeyword = normalizeSearchTerm($keyword);
    
    // Aksiyon tipi
    switch ($action) {
        case 'search':
            // Şarkı arama (sanatçı adı, şarkı adı, albüm adı veya şarkı sözlerinde)
            try {
                // Arama terimi güvenli hale getir
                $searchTerm = "%" . $db->escape($keyword) . "%";
                $normalizedSearchTerm = "%" . $db->escape($normalizedKeyword) . "%";
                
                // Normalize edilmiş arama terimi için REGEXP ifadeleri
                $regexI = '(i|ı|İ|I)';
                $regexS = '(s|ş|S|Ş)';
                $regexG = '(g|ğ|G|Ğ)';
                $regexU = '(u|ü|U|Ü)';
                $regexO = '(o|ö|O|Ö)';
                $regexC = '(c|ç|C|Ç)';
                
                // Normalize edilmiş regex oluştur
                $regexPattern = '';
                for ($i = 0; $i < mb_strlen($normalizedKeyword, 'UTF-8'); $i++) {
                    $char = mb_substr($normalizedKeyword, $i, 1, 'UTF-8');
                    switch ($char) {
                        case 'i':
                            $regexPattern .= $regexI;
                            break;
                        case 's':
                            $regexPattern .= $regexS;
                            break;
                        case 'g':
                            $regexPattern .= $regexG;
                            break;
                        case 'u':
                            $regexPattern .= $regexU;
                            break;
                        case 'o':
                            $regexPattern .= $regexO;
                            break;
                        case 'c':
                            $regexPattern .= $regexC;
                            break;
                        default:
                            $regexPattern .= $char;
                    }
                }
                
                // TÜM VERİTABANINDAN ARAMA YAP (görünen veriler yerine)
                $sql = "SELECT s.*, a.id as artist_id, a.title" . Lang::$lang . " as artist_title, 
                    l.title" . Lang::$lang . " as album_title, l.thumb, 
                    g.title" . Lang::$lang . " as genre_title 
                    FROM " . Muzibu::mTable . " as s 
                    LEFT JOIN " . Muzibu::albumTable . " as l ON l.id = s.album_id 
                    LEFT JOIN " . Muzibu::artistTable . " as a ON a.id = l.artist_id 
                    LEFT JOIN " . Muzibu::genreTable . " as g ON g.id = s.genre_id 
                    WHERE 
                    (s.title" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR

                    LOWER(s.title" . Lang::$lang . ") REGEXP '" . $regexPattern . "' OR
                    a.title" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR
                    LOWER(a.title" . Lang::$lang . ") REGEXP '" . $regexPattern . "' OR
                    l.title" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR
                    LOWER(l.title" . Lang::$lang . ") REGEXP '" . $regexPattern . "' OR
                    g.title" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR
                    LOWER(g.title" . Lang::$lang . ") REGEXP '" . $regexPattern . "' OR
                    s.lyrics" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR
                    LOWER(s.lyrics" . Lang::$lang . ") REGEXP '" . $regexPattern . "')
                    ORDER BY 
                    CASE WHEN s.title" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR LOWER(s.title" . Lang::$lang . ") REGEXP '" . $regexPattern . "' THEN 1
                         WHEN a.title" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR LOWER(a.title" . Lang::$lang . ") REGEXP '" . $regexPattern . "' THEN 2
                         WHEN l.title" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR LOWER(l.title" . Lang::$lang . ") REGEXP '" . $regexPattern . "' THEN 3
                         WHEN g.title" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR LOWER(g.title" . Lang::$lang . ") REGEXP '" . $regexPattern . "' THEN 4
                         WHEN s.lyrics" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR LOWER(s.lyrics" . Lang::$lang . ") REGEXP '" . $regexPattern . "' THEN 5
                         ELSE 6 END ASC, 
                    s.title" . Lang::$lang . " ASC 
                    LIMIT " . $offset . ", " . $limit;
                
                $songs = $db->fetch_all($sql);
                
                // Gerçek şarkı sayısını (toplam) al - sayfalama için
                $countSql = "SELECT COUNT(*) as total 
                    FROM " . Muzibu::mTable . " as s 
                    LEFT JOIN " . Muzibu::albumTable . " as l ON l.id = s.album_id 
                    LEFT JOIN " . Muzibu::artistTable . " as a ON a.id = l.artist_id 
                    LEFT JOIN " . Muzibu::genreTable . " as g ON g.id = s.genre_id 
                    WHERE 
                    (s.title" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR
                    LOWER(s.title" . Lang::$lang . ") REGEXP '" . $regexPattern . "' OR
                    a.title" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR
                    LOWER(a.title" . Lang::$lang . ") REGEXP '" . $regexPattern . "' OR
                    l.title" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR
                    LOWER(l.title" . Lang::$lang . ") REGEXP '" . $regexPattern . "' OR
                    g.title" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR
                    LOWER(g.title" . Lang::$lang . ") REGEXP '" . $regexPattern . "' OR
                    s.lyrics" . Lang::$lang . " LIKE '" . $searchTerm . "' COLLATE utf8_general_ci OR
                    LOWER(s.lyrics" . Lang::$lang . ") REGEXP '" . $regexPattern . "')";
                
                $totalCount = $db->first($countSql);
                $hasMore = ($offset + $limit) < $totalCount->total;
                
                // Sonuç ve meta bilgileri döndür
                echo json_encode([
                    'songs' => $songs ? $songs : [],
                    'meta' => [
                        'page' => $page,
                        'total' => $totalCount->total,
                        'hasMore' => $hasMore
                    ]
                ]);
            } catch (Exception $ex) {
                echo json_encode([
                    'songs' => [],
                    'meta' => [
                        'page' => $page,
                        'total' => 0,
                        'hasMore' => false,
                        'error' => $ex->getMessage()
                    ]
                ]);
            }
            break;
            
        case 'load':
        default:
            // Şarkıları yükle (alfabetik sıralı veya filtrelenmiş)
            try {
                $whereClause = "";
                if ($genre_id > 0) {
                    $whereClause = "WHERE s.genre_id = " . $genre_id . " AND s.active = 1";
                } elseif ($artist_id > 0) {
                    $whereClause = "WHERE a.id = " . $artist_id . " AND s.active = 1";
                } else {
                    $whereClause = "WHERE s.active = 1";
                }
                
                $sql = "SELECT s.*, a.id as artist_id, a.title" . Lang::$lang . " as artist_title, 
                    l.title" . Lang::$lang . " as album_title, l.thumb, 
                    g.id as genre_id, g.title" . Lang::$lang . " as genre_title 
                    FROM " . Muzibu::mTable . " as s 
                    LEFT JOIN " . Muzibu::albumTable . " as l ON l.id = s.album_id 
                    LEFT JOIN " . Muzibu::artistTable . " as a ON a.id = l.artist_id 
                    LEFT JOIN " . Muzibu::genreTable . " as g ON g.id = s.genre_id 
                    " . $whereClause . "
                    ORDER BY RAND() 
                    LIMIT " . $offset . ", " . $limit;
                
                $songs = $db->fetch_all($sql);
                
                // Gerçek şarkı sayısını (toplam) al - sayfalama için
                $countSql = "SELECT COUNT(*) as total FROM " . Muzibu::mTable . " as s 
                LEFT JOIN " . Muzibu::albumTable . " as l ON l.id = s.album_id 
                LEFT JOIN " . Muzibu::artistTable . " as a ON a.id = l.artist_id 
                " . $whereClause;
                
                $totalCount = $db->first($countSql);
                $hasMore = ($offset + $limit) < $totalCount->total;
                
                // Sonuç ve meta bilgileri döndür
                echo json_encode([
                    'songs' => $songs ? $songs : [],
                    'meta' => [
                        'page' => $page,
                        'total' => $totalCount ? $totalCount->total : 0,
                        'hasMore' => $hasMore
                    ]
                ]);
            } catch (Exception $ex) {
                echo json_encode([
                    'songs' => [],
                    'meta' => [
                        'page' => $page,
                        'total' => 0,
                        'hasMore' => false,
                        'error' => $ex->getMessage()
                    ]
                ]);
            }
            break;
    }
    
} catch (Exception $e) {
    echo json_encode([
        'songs' => [],
        'meta' => [
            'page' => 1,
            'total' => 0,
            'hasMore' => false,
            'error' => $e->getMessage()
        ]
    ]);
}
exit;