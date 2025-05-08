<?php
/**
 * Muzibu - AJAX Çalma Listesi İşlemleri
 *
 * @package Muzibu Module
 * @author geliştiren
 * @copyright 2025
 */
 
define("_VALID_PHP", true);
require_once("../../init.php");

// JSON başlığı
header('Content-Type: application/json');

// Kullanıcı giriş yapmış mı kontrol et
if (!$user->logged_in) {
    echo json_encode(['status' => 'error', 'message' => 'Bu işlem için giriş yapmanız gerekiyor']);
    exit;
}

// Veritabanı bağlantısı
$db = Registry::get("Database");

// Muzibu sınıfını dahil et
require_once(BASEPATH . "admin/modules/muzibu/admin_class.php");
$muzibu = new Muzibu();

// İşlem tipini al
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

switch ($action) {
    case 'get_user_playlists':
        // Kullanıcının çalma listelerini getir
        $playlists = $muzibu->playlist->getPlaylistsByUser($user->uid);
        
        // Şarkı ID'si varsa, bu şarkının hangi çalma listelerinde olduğunu da getir
        $song_playlists = [];
        if (isset($_GET['song_id']) && !empty($_GET['song_id'])) {
            $song_id = intval($_GET['song_id']);
            $song_playlists = $muzibu->playlist->getUserPlaylistIDsBySong($user->uid, $song_id);
        }
        
        echo json_encode([
            'status' => 'success',
            'playlists' => $playlists,
            'song_playlists' => $song_playlists
        ]);
        break;
        
    case 'add_song_to_playlist':
        // Gerekli parametreleri kontrol et
        if (!isset($_POST['playlist_id']) || !isset($_POST['song_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Eksik parametreler']);
            exit;
        }
        
        $playlist_id = intval($_POST['playlist_id']);
        $song_id = intval($_POST['song_id']);
        
        // Çalma listesinin kullanıcıya ait olup olmadığını kontrol et
        $playlist = $muzibu->playlist->getPlaylistById($playlist_id);
        if (!$playlist || $playlist->user_id != $user->uid) {
            echo json_encode(['status' => 'error', 'message' => 'Bu çalma listesi size ait değil']);
            exit;
        }
        
        // Şarkının var olup olmadığını kontrol et
        $song = $db->first("SELECT id FROM muzibu_songs WHERE id = " . $song_id);
        if (!$song) {
            echo json_encode(['status' => 'error', 'message' => 'Şarkı bulunamadı']);
            exit;
        }
        
        // Şarkının çalma listesinde zaten olup olmadığını kontrol et
        $exists = $db->first("SELECT * FROM muzibu_playlist_song 
                              WHERE playlist_id = " . $playlist_id . " 
                              AND song_id = " . $song_id);
                              
        if ($exists) {
            echo json_encode(['status' => 'error', 'message' => 'Bu şarkı zaten çalma listenizde mevcut']);
            exit;
        }
        
        // Son pozisyonu bul
        $lastPosition = $db->first("SELECT MAX(position) as max_pos FROM muzibu_playlist_song 
                                    WHERE playlist_id = " . $playlist_id);
        $position = ($lastPosition && isset($lastPosition->max_pos)) ? $lastPosition->max_pos + 1 : 0;
        
        // Şarkıyı çalma listesine ekle
        $data = [
            'playlist_id' => $playlist_id,
            'song_id' => $song_id,
            'position' => $position,
            'created' => 'NOW()'
        ];
        
        $result = $db->insert("muzibu_playlist_song", $data);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Şarkı çalma listesine eklendi']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Şarkı eklenirken bir hata oluştu']);
        }
        break;
        
    case 'remove_song_from_playlist':
        // Gerekli parametreleri kontrol et
        if (!isset($_POST['playlist_id']) || !isset($_POST['song_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Eksik parametreler']);
            exit;
        }
        
        $playlist_id = intval($_POST['playlist_id']);
        $song_id = intval($_POST['song_id']);
        
        // Çalma listesinin kullanıcıya ait olup olmadığını kontrol et
        $playlist = $muzibu->playlist->getPlaylistById($playlist_id);
        if (!$playlist || $playlist->user_id != $user->uid) {
            echo json_encode(['status' => 'error', 'message' => 'Bu çalma listesi size ait değil']);
            exit;
        }
        
        // Şarkıyı çalma listesinden çıkar
        $result = $db->delete("muzibu_playlist_song", "playlist_id = " . $playlist_id . " AND song_id = " . $song_id);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Şarkı çalma listesinden çıkarıldı']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Şarkı çıkarılırken bir hata oluştu']);
        }
        break;
        
    case 'create_playlist':
        // Gerekli parametreleri kontrol et
        if (!isset($_POST['title']) || empty($_POST['title'])) {
            echo json_encode(['status' => 'error', 'message' => 'Lütfen bir liste adı girin']);
            exit;
        }
        
        $title = sanitize($_POST['title']);
        $slug = doSeo($title);
        
        // Benzer slug'a sahip playlist var mı kontrol et
        $existingPlaylist = $db->first("SELECT id FROM muzibu_playlists WHERE slug = '" . $db->escape($slug) . "'");
        if ($existingPlaylist) {
            // Slug'a rastgele bir ek ekle
            $slug = $slug . '-' . substr(md5(time()), 0, 5);
        }
        
        // Yeni çalma listesi oluştur
        $data = array(
            'title_tr' => $title,
            'slug' => $slug,
            'user_id' => $user->uid,
            'system' => 0,
            'is_public' => 1,
            'created' => 'NOW()',
            'active' => 1
        );
        
        $result = $db->insert("muzibu_playlists", $data);
        
        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Çalma listesi başarıyla oluşturuldu',
                'playlist_id' => $result
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Çalma listesi oluşturulurken bir hata oluştu']);
        }
        break;
        
    case 'delete_playlist':
        // Gerekli parametreleri kontrol et
        if (!isset($_POST['playlist_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Eksik parametreler']);
            exit;
        }
        
        $playlist_id = intval($_POST['playlist_id']);
        
        // Çalma listesinin kullanıcıya ait olup olmadığını kontrol et
        $playlist = $muzibu->playlist->getPlaylistById($playlist_id);
        if (!$playlist || $playlist->user_id != $user->uid) {
            echo json_encode(['status' => 'error', 'message' => 'Bu çalma listesi size ait değil']);
            exit;
        }
        
        // Çalma listesindeki şarkıları sil
        $db->delete("muzibu_playlist_song", "playlist_id = " . $playlist_id);
        
        // Çalma listesini sil
        $result = $db->delete("muzibu_playlists", "id = " . $playlist_id);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Çalma listesi başarıyla silindi']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Çalma listesi silinirken bir hata oluştu']);
        }
        break;
        
    case 'update_playlist':
        // Gerekli parametreleri kontrol et
        if (!isset($_POST['playlist_id']) || !isset($_POST['title']) || empty($_POST['title'])) {
            echo json_encode(['status' => 'error', 'message' => 'Eksik parametreler']);
            exit;
        }
        
        $playlist_id = intval($_POST['playlist_id']);
        $title = sanitize($_POST['title']);
        
        // Çalma listesinin kullanıcıya ait olup olmadığını kontrol et
        $playlist = $muzibu->playlist->getPlaylistById($playlist_id);
        if (!$playlist || $playlist->user_id != $user->uid) {
            echo json_encode(['status' => 'error', 'message' => 'Bu çalma listesi size ait değil']);
            exit;
        }
        
        // Çalma listesini güncelle
        $data = array(
            'title_tr' => $title
        );
        
        $result = $db->update("muzibu_playlists", $data, "id = " . $playlist_id);
        
        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Çalma listesi başarıyla güncellendi']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Çalma listesi güncellenirken bir hata oluştu']);
        }
        break;
        
    default:
        echo json_encode(['status' => 'error', 'message' => 'Geçersiz işlem']);
        break;
}

exit;
?>