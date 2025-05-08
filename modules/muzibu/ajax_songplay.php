<?php
/**
 * Muzibu - AJAX Şarkı Dinleme Kaydı
 *
 * @package Muzibu Module
 * @author Muzibu
 * @copyright 2025
 */
 
define("_VALID_PHP", true);
require_once("../../init.php");

// JSON başlığı
header('Content-Type: application/json');

if (!isset($_POST['action']) || $_POST['action'] != 'log_play' || !isset($_POST['song_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Geçersiz istek']);
    exit;
}

// Veritabanı bağlantısı
$db = Registry::get("Database");

// Şarkı ID'si
$song_id = intval($_POST['song_id']);

// Kullanıcı ID'si (giriş yapmışsa)
$user_id = $user->logged_in ? $user->uid : null;

// IP adresi
$ip_address = $_SERVER['REMOTE_ADDR'];

try {
    // Şarkı dinleme sayısını artır
    $db->query("UPDATE muzibu_songs SET play_count = play_count + 1 WHERE id = " . $song_id);
    
    // Şarkı dinleme kaydı ekle
    $data = [
        'user_id' => $user_id,
        'song_id' => $song_id,
        'ip_address' => $ip_address,
        'created' => 'NOW()'
    ];
    
    $db->insert("muzibu_song_plays", $data);
    
    echo json_encode(['status' => 'success', 'message' => 'Şarkı dinleme kaydedildi']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
exit;