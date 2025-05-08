<?php
/**
 * Muzibu URL Test
 */
define("_VALID_PHP", true);
require_once "../../init.php";

// URL Test
echo "<h1>Muzibu URL Test</h1>";
echo "<pre>";

// URL segmentlerini görelim
echo "Current URL: " . $_SERVER['REQUEST_URI'] . "\n\n";

// Content sınıfını ve URL değerlerini görelim
echo "Content URL segmentleri:\n";
print_r($content->_url);
echo "\n\n";

// URL sınıfında tanımlı modülleri görelim
echo "URL modülleri:\n";
print_r(Url::$data['module']);
echo "\n\n";

// Test linkleri
echo "</pre>";
echo "<h2>Test Linkleri</h2>";
echo "<ul>";
echo "<li><a href='" . SITEURL . "/muzibu/'>Ana Sayfa</a></li>";
echo "<li><a href='" . SITEURL . "/muzibu/song/'>Song List</a></li>";
echo "<li><a href='" . SITEURL . "/muzibu/album/'>Album List</a></li>";
echo "<li><a href='" . SITEURL . "/muzibu/artist/'>Artist List</a></li>";
echo "<li><a href='" . SITEURL . "/muzibu/genre/'>Genre List</a></li>";
echo "<li><a href='" . SITEURL . "/muzibu/playlist/'>Playlist List</a></li>";
echo "<li><a href='" . SITEURL . "/muzibu/sector/'>Sector List</a></li>";
echo "<li><a href='" . SITEURL . "/muzibu/favorites/'>Favorites</a></li>";

// Detay sayfaları
echo "<li><a href='" . SITEURL . "/muzibu/song/dudu/'>Song Detail (dudu)</a></li>";
echo "<li><a href='" . SITEURL . "/muzibu/album/dudu/'>Album Detail (dudu)</a></li>";
echo "<li><a href='" . SITEURL . "/muzibu/artist/tarkan/'>Artist Detail (tarkan)</a></li>";
echo "<li><a href='" . SITEURL . "/muzibu/genre/pop/'>Genre Detail (pop)</a></li>";
echo "<li><a href='" . SITEURL . "/muzibu/playlist/otel/'>Playlist Detail (otel)</a></li>";
echo "<li><a href='" . SITEURL . "/muzibu/sector/istanbul/'>Sector Detail (istanbul)</a></li>";
echo "</ul>";

// Dosya yollarını kontrol edelim
echo "<h2>Dosya Yolları</h2>";
echo "<pre>";
$modPath = MODPATH . "muzibu/";
$files = [
    "main.php", 
    "muzibu_main.php", 
    "song_list.php", 
    "song_detail.php",
    "album_list.php", 
    "album_detail.php",
    "artist_list.php", 
    "artist_detail.php",
    "genre_list.php", 
    "genre_detail.php",
    "playlist_list.php", 
    "playlist_detail.php",
    "sector_list.php", 
    "sector_detail.php",
    "favorites.php"
];

foreach ($files as $file) {
    $fullPath = $modPath . $file;
    echo "$file: " . (file_exists($fullPath) ? "Mevcut ✅" : "Bulunamadı ❌") . "\n";
}
echo "</pre>";

// URL komponentlerinin analizi
echo "<h2>URL Router Test</h2>";
echo "<pre>";
$testURLs = [
    "/muzibu/song/",
    "/muzibu/album/",
    "/muzibu/artist/",
    "/muzibu/genre/",
    "/muzibu/playlist/",
    "/muzibu/sector/",
    "/muzibu/favorites/"
];

echo "URL Router Test:\n";
foreach ($testURLs as $testURL) {
    $fakeURL = explode("/", trim($testURL, "/"));
    echo "$testURL: ";
    
    if (count($fakeURL) >= 2) {
        $section = $fakeURL[1];
        switch ($section) {
            case 'song':
                echo "Song List ✅";
                break;
            case 'album':
                echo "Album List ✅";
                break;
            case 'artist':
                echo "Artist List ✅";
                break;
            case 'genre':
                echo "Genre List ✅";
                break;
            case 'playlist':
                echo "Playlist List ✅";
                break;
            case 'sector':
                echo "Sector List ✅";
                break;
            case 'favorites':
                echo "Favorites ✅";
                break;
            default:
                echo "Bilinmeyen ❌";
                break;
        }
    } else {
        echo "Geçersiz URL ❌";
    }
    echo "\n";
}
echo "</pre>";
?>