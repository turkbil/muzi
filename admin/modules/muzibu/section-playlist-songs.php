<?php
/**
 * Muzibu Admin - Playlist Songs Section
 *
 * @package Muzibu Module
 * @author geliştiren
 * @copyright 2024
 */
if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

if (!$user->getAcl("muzibu")): print Filter::msgAlert(Lang::$word->_CG_ONLYADMIN); return; endif;

// Playlist ID kontrolü
$playlist_id = isset($_GET['playlist_id']) ? intval($_GET['playlist_id']) : 0;
if (!$playlist_id) {
    redirect_to("index.php?do=modules&action=config&modname=muzibu&maction=playlists");
}

// Playlist bilgilerini al
$playlist = Registry::get("Muzibu")->getPlaylistById($playlist_id);
if (!$playlist) {
    redirect_to("index.php?do=modules&action=config&modname=muzibu&maction=playlists");
}

// Playlist'e ait şarkıları al
$playlistSongs = Registry::get("Muzibu")->getPlaylistSongs($playlist_id);
?>

<div class="tubi icon heading message blue"> 
  <a class="helper tubi top right info corner label" data-help="muzibu"><i class="icon help"></i></a> 
  <i class="list icon"></i>
  <div class="content">
    <div class="header">Playlist Şarkıları: <?php echo $playlist->{'title'.Lang::$lang}; ?></div>
    <div class="tubi breadcrumb">
      <i class="icon home"></i> 
      <a href="index.php" class="section"><?php echo Lang::$word->_N_DASH;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules" class="section"><?php echo Lang::$word->_N_MODS;?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu" class="section"><?php echo $content->getModuleName(Filter::$modname);?></a>
      <div class="divider"> / </div>
      <a href="index.php?do=modules&amp;action=config&amp;modname=muzibu&amp;maction=playlists" class="section">Playlist Yönetimi</a>
      <div class="divider"> / </div>
      <div class="active section">Playlist Şarkıları</div>
    </div>
  </div>
</div>

<div class="tubi-large-content">
  <div class="tubi message"><?php echo Core::langIcon();?>Playlist içerisindeki şarkıları düzenleyebilirsiniz. Sürükle-bırak ile şarkıların sıralamasını değiştirebilirsiniz.</div>
  
  <div class="tubi segment">
    <div class="tubi-grid">
      <div class="two columns small-horizontal-gutters">
        <div class="row">
          <!-- SOL KOLON: Playlist Şarkıları -->
          <div class="tubi form segment">
            <div class="tubi header">Playlist Şarkıları</div>
            <div class="tubi double fitted divider"></div>
            <form id="playlist_form" method="post">
              <div class="field">
                <div id="playlistSongList">
                  <?php if(!$playlistSongs): ?>
                    <div class="tubi message info">Bu playlist'e henüz şarkı eklenmemiş.</div>
                  <?php else: ?>
                    <div class="tubi relaxed divided list sortable">
                      <?php foreach($playlistSongs as $song): ?>
                        <div class="item playlist-song" data-id="<?php echo $song->id; ?>" id="node-<?php echo $song->id; ?>">
                          <div class="tubi right floated content">
                            <button type="button" class="tubi mini icon button remove-song" data-id="<?php echo $song->id; ?>">
                              <i class="close icon"></i>
                            </button>
                          </div>
                          <i class="music icon"></i>
                          <div class="content">
                            <div class="header"><?php echo $song->{'title'.Lang::$lang}; ?></div>
                            <div class="description">
                              <?php echo !empty($song->artist_name) ? $song->artist_name : ''; ?>
                              <?php echo !empty($song->album_name) ? ' - ' . $song->album_name : ''; ?>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row">
          <!-- SAĞ KOLON: Tüm Şarkılar -->
          <div class="tubi form segment">
            <div class="tubi header">Şarkı Arama</div>
            <div class="tubi double fitted divider"></div>
            <div class="field">
              <label>Şarkı Ara</label>
              <div class="tubi input">
                <input type="text" id="songSearchInput" placeholder="Şarkı, sanatçı veya albüm adı ara...">
              </div>
              <div class="tubi message small">Alfabetik sıralı şarkılar listeleniyor. Şarkı, şarkı sözü, şarkıcı, albüm ve şarkı türü ilke arama yapabilirsiniz.</div>
            </div>
            <div class="field">
              <div id="allSongsList">
                <div class="tubi message info">Şarkılar yükleniyor...</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div id="msgholder"></div>
</div>

<script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
    // Değişkenler
    var isLoading = false;
    var currentPage = 1;
    var isSearchMode = false;
    var currentSearchTerm = '';
    var hasMoreData = true;
    var activeRequest = null; // Aktif AJAX isteği
    var playlistId = <?php echo $playlist_id; ?>; // PHP'den playlist ID
    
    // Hata durumunda yakalamak için
    window.onerror = function(message, source, lineno, colno, error) {
        console.log("JavaScript hatası:", message);
        return true; // Hata işlendi
    };
    
    // İlk sayfa yüklemesi
    loadSongs(1);
    
    // Scroll olayını dinle
    $("#allSongsList").scroll(function() {
        if (isLoading || !hasMoreData) return;
        
        var scrollHeight = $(this)[0].scrollHeight;
        var scrollPosition = $(this).height() + $(this).scrollTop();
        
        // Kullanıcı sayfanın sonuna yaklaştığında yeni şarkılar yükle
        if (scrollPosition >= scrollHeight - 200) {
            currentPage++;
            
            // Arama moduna göre doğru fonksiyonu çağır
            if (isSearchMode && currentSearchTerm.length > 0) {
                searchSongs(currentSearchTerm, currentPage);
            } else {
                loadSongs(currentPage);
            }
        }
    });
    
    // Arama işlevi - anlık arama (keyup ile)
    var searchTimer;
    $("#songSearchInput").on("keyup", function() {
        var searchValue = $(this).val().trim();
        
        // Zamanlayıcıyı temizle
        clearTimeout(searchTimer);
        
        // Arama durumu değişkenlerini yeniden ayarla
        currentPage = 1;
        hasMoreData = true;
        
        // Önceki isteği iptal et
        if (activeRequest && activeRequest.readyState !== 4) {
            activeRequest.abort();
        }
        
        // Eğer arama alanı boşsa, normal şarkı listesini göster (alfabetik sıralı)
        if (searchValue.length === 0) {
            isSearchMode = false;
            currentSearchTerm = '';
            
            // Listeyi sıfırla ve ilk sayfayı yükle
            $("#allSongsList").html('<div class="tubi message info">Şarkılar yükleniyor...</div>');
            loadSongs(1);
            return;
        }
        
        // Tek karakter yazıldığında bile aramaya başla
        if (searchValue.length >= 1) {
            // Arama durumunu göster - Loading ikonu
            $("#songSearchInput").addClass("loading");
            isSearchMode = true;
            currentSearchTerm = searchValue;
            
            // 300ms gecikmeyle ajax isteği gönder
            searchTimer = setTimeout(function() {
                $("#allSongsList").html('<div class="tubi message info"><div class="tubi active centered inline loader"></div> Aranıyor...</div>'); // Mevcut listeyi temizle
                searchSongs(searchValue, 1);
            }, 300);
        }
    });
    
    // Normal şarkı yükleme (alfabetik sıralı, sayfalı)
    function loadSongs(page) {
        if (isLoading || !hasMoreData) return;
        isLoading = true;
        
        // Yükleme göstergesini ekle (ilk sayfa değilse)
        if (page > 1) {
            if ($("#allSongsList .tubi.relaxed.divided.list").length) {
                $("#allSongsList .tubi.relaxed.divided.list").append('<div id="loading-indicator" class="item"><div class="content"><div class="tubi active centered inline loader"></div> Daha fazla şarkı yükleniyor...</div></div>');
            }
        } else {
            // Arama alanında loading ikonu
            $("#songSearchInput").addClass("loading");
        }
        
        try {
            // AJAX isteği yap
            activeRequest = $.ajax({
                type: "GET",
                url: "modules/muzibu/ajax_songs.php",
                dataType: "json",
                data: {
                    action: "load",
                    page: page,
                    limit: 10, // Her sayfada 10 şarkı yükle
                    playlist_id: playlistId
                },
                success: function(response) {
                    // Yükleme göstergesini kaldır
                    $("#loading-indicator").remove();
                    $("#songSearchInput").removeClass("loading");
                    
                    // Meta bilgilerini kontrol et
                    if (response.meta) {
                        hasMoreData = response.meta.hasMore === true;
                    } else {
                        hasMoreData = false;
                    }
                    
                    // Şarkı verilerini al
                    var songs = response.songs || [];
                    
                    // Response kontrolü
                    if (!songs || songs.length === 0) {
                        if (page === 1) {
                            $("#allSongsList").html('<div class="tubi message info">Şarkı bulunamadı.</div>');
                        } else if (hasMoreData === false) {
                            // Listenin sonuna "liste sonu" mesajı ekle
                            $("#allSongsList .tubi.relaxed.divided.list").append('<div class="item"><div class="content"><div class="description italic">Liste sonu</div></div></div>');
                        }
                        isLoading = false;
                        return;
                    }
                    
                    // Şarkıları görüntüle
                    if (page === 1) {
                        displaySongs(songs); // Listeyi sıfırlayarak göster
                    } else {
                        appendSongs(songs); // Mevcut listeye ekle
                    }
                    
                    // Eğer başka sayfa yoksa liste sonu mesajı göster
                    if (hasMoreData === false) {
                        $("#allSongsList .tubi.relaxed.divided.list").append('<div class="item"><div class="content"><div class="description italic">Liste sonu</div></div></div>');
                    }
                    
                    isLoading = false;
                },
                error: function(xhr, status, error) {
                    // İstek iptal edildiyse hata gösterme
                    if (status === 'abort') {
                        isLoading = false;
                        return;
                    }
                    
                    // Hata durumunda yükleme göstergesini kaldır
                    $("#loading-indicator").remove();
                    $("#songSearchInput").removeClass("loading");
                    console.error("AJAX Hatası:", error);
                    
                    // Hata mesajı göster
                    if (page === 1) {
                        $("#allSongsList").html('<div class="tubi message error">Şarkılar yüklenirken bir hata oluştu.</div>');
                    }
                    
                    isLoading = false;
                    hasMoreData = false;
                }
            });
        } catch (e) {
            console.error("Yükleme hatası:", e);
            $("#loading-indicator").remove();
            $("#songSearchInput").removeClass("loading");
            isLoading = false;
        }
    }
    
    // Şarkı arama fonksiyonu (sonsuz kaydırma için sayfalı)
    function searchSongs(keyword, page) {
        if (isLoading || !hasMoreData) return;
        isLoading = true;
        
        // Yükleme göstergesini ekle (ilk sayfa değilse)
        if (page > 1) {
            if ($("#allSongsList .tubi.relaxed.divided.list").length) {
                $("#allSongsList .tubi.relaxed.divided.list").append('<div id="loading-indicator" class="item"><div class="content"><div class="tubi active centered inline loader"></div> Daha fazla sonuç yükleniyor...</div></div>');
            }
        } else {
            // Arama alanında loading ikonu
            $("#songSearchInput").addClass("loading");
        }
        
        try {
            // AJAX isteği yap
            activeRequest = $.ajax({
                type: "GET",
                url: "modules/muzibu/ajax_songs.php",
                dataType: "json",
                data: {
                    action: "search",
                    keyword: keyword,
                    page: page,
                    limit: 10, // Her sayfada 10 şarkı yükle
                    playlist_id: playlistId
                },
                success: function(response) {
                    // Yükleme göstergesini kaldır
                    $("#loading-indicator").remove();
                    $("#songSearchInput").removeClass("loading");
                    
                    // Meta bilgilerini kontrol et
                    if (response.meta) {
                        hasMoreData = response.meta.hasMore === true;
                    } else {
                        hasMoreData = false;
                    }
                    
                    // Şarkı verilerini al
                    var songs = response.songs || [];
                    
                    // Response kontrolü
                    if (!songs || songs.length === 0) {
                        if (page === 1) {
                            $("#allSongsList").html('<div class="tubi message info">Arama sonucu bulunamadı.</div>');
                        } else if (hasMoreData === false) {
                            // Listenin sonuna "arama sonuçları sonu" mesajı ekle
                            $("#allSongsList .tubi.relaxed.divided.list").append('<div class="item"><div class="content"><div class="description italic">Arama sonuçları sonu</div></div></div>');
                        }
                        isLoading = false;
                        return;
                    }
                    
                    // Şarkıları görüntüle
                    if (page === 1) {
                        displaySongs(songs); // Listeyi sıfırlayarak göster
                    } else {
                        appendSongs(songs); // Mevcut listeye ekle
                    }
                    
                    // Eğer başka sayfa yoksa liste sonu mesajı göster
                    if (hasMoreData === false) {
                        $("#allSongsList .tubi.relaxed.divided.list").append('<div class="item"><div class="content"><div class="description italic">Arama sonuçları sonu</div></div></div>');
                    }
                    
                    isLoading = false;
                },
                error: function(xhr, status, error) {
                    // İstek iptal edildiyse hata gösterme
                    if (status === 'abort') {
                        isLoading = false;
                        return;
                    }
                    
                    // Hata durumunda yükleme göstergesini kaldır
                    $("#loading-indicator").remove();
                    $("#songSearchInput").removeClass("loading");
                    console.error("AJAX Hatası:", error);
                    
                    // Hata mesajı göster
                    if (page === 1) {
                        $("#allSongsList").html('<div class="tubi message error">Arama sırasında bir hata oluştu.</div>');
                    }
                    
                    isLoading = false;
                    hasMoreData = false;
                }
            });
        } catch (e) {
            console.error("Arama hatası:", e);
            $("#loading-indicator").remove();
            $("#songSearchInput").removeClass("loading");
            isLoading = false;
        }
    }
    
    // Şarkıları görüntüleme fonksiyonu (liste sıfırlanarak)
    function displaySongs(songs) {
        if (!songs || songs.length === 0) {
            $("#allSongsList").html('<div class="tubi message info">Sonuç bulunamadı.</div>');
            return;
        }
        
        var html = '<div class="tubi relaxed divided list">';
        
        // Playlist'teki şarkıların ID'lerini bir diziye al
        var playlistSongIds = [];
        $("#playlistSongList .sortable .item").each(function() {
            playlistSongIds.push(parseInt($(this).data("id")));
        });
        
        // Şarkıları listele
        $.each(songs, function(index, song) {
            var inPlaylist = $.inArray(parseInt(song.id), playlistSongIds) !== -1;
            var songTitle = song.title || song.title_tr || "İsimsiz Şarkı";
            
            html += '<div class="item all-song" data-id="' + song.id + '" data-title="' + songTitle.toLowerCase() + '">';
            html += '<div class="tubi right floated content">';
            html += '<button type="button" class="tubi mini icon button ' + (inPlaylist ? 'positive disabled' : 'add-song') + '" data-id="' + song.id + '">';
            html += '<i class="' + (inPlaylist ? 'check' : 'plus') + ' icon"></i>';
            html += '</button>';
            html += '</div>';
            html += '<i class="music icon"></i>';
            html += '<div class="content">';
            html += '<div class="header">' + songTitle + '</div>';
            html += '<div class="description">';
            html += (song.artist_title ? song.artist_title : '');
            html += (song.album_title ? ' - ' + song.album_title : '');
            html += '</div>';
            html += '</div>';
            html += '</div>';
        });
        
        html += '</div>';
        
        $("#allSongsList").html(html);
    }
    
    // Şarkıları mevcut listeye ekleme fonksiyonu (sonsuz kaydırma için)
    function appendSongs(songs) {
        if (!songs || songs.length === 0) return;
        
        // Playlist'teki şarkıların ID'lerini bir diziye al
        var playlistSongIds = [];
        $("#playlistSongList .sortable .item").each(function() {
            playlistSongIds.push(parseInt($(this).data("id")));
        });
        
        // Eğer liste henüz oluşturulmadıysa oluştur
        if (!$("#allSongsList .tubi.relaxed.divided.list").length) {
            $("#allSongsList").html('<div class="tubi relaxed divided list"></div>');
        }
        
        // Şarkıları listeye ekle
        var html = '';
        $.each(songs, function(index, song) {
            var inPlaylist = $.inArray(parseInt(song.id), playlistSongIds) !== -1;
            var songTitle = song.title || song.title_tr || "İsimsiz Şarkı";
            
            html += '<div class="item all-song" data-id="' + song.id + '" data-title="' + songTitle.toLowerCase() + '">';
            html += '<div class="tubi right floated content">';
            html += '<button type="button" class="tubi mini icon button ' + (inPlaylist ? 'positive disabled' : 'add-song') + '" data-id="' + song.id + '">';
            html += '<i class="' + (inPlaylist ? 'check' : 'plus') + ' icon"></i>';
            html += '</button>';
            html += '</div>';
            html += '<i class="music icon"></i>';
            html += '<div class="content">';
            html += '<div class="header">' + songTitle + '</div>';
            html += '<div class="description">';
            html += (song.artist_title ? song.artist_title : '');
            html += (song.album_title ? ' - ' + song.album_title : '');
            html += '</div>';
            html += '</div>';
            html += '</div>';
        });
        
        $("#allSongsList .tubi.relaxed.divided.list").append(html);
    }
    
    // Sıralama özelliği
    if ($("#playlistSongList .sortable").length) {
        $("#playlistSongList .sortable").sortable({
            opacity: 0.6,
            cursor: 'move',
            cancel: '.remove-song', // Silme butonunu sürüklemeden hariç tut
            update: function(event, ui) {
                // Sıralama değiştiğinde otomatik kaydet
                savePlaylistChanges();
            }
        }).disableSelection();
    }
    
    // Şarkı ekleme
    $(document).on("click", ".add-song", function() {
        var songId = $(this).data("id");
        var songItem = $(this).closest(".item");
        
        // Ekle düğmesini devre dışı bırak
        $(this).removeClass("add-song").addClass("positive disabled");
        $(this).html('<i class="check icon"></i>');
        
        // Şarkıyı playlist listesine ekle
        var clonedItem = songItem.clone();
        clonedItem.addClass("playlist-song").removeClass("all-song");
        clonedItem.attr("id", "node-" + songId);
        
        // Buton değişimi - ekleme butonunu silme butonuna dönüştür
        clonedItem.find(".button").removeClass("add-song positive disabled").addClass("remove-song");
        clonedItem.find(".button i").removeClass("plus check").addClass("close");
        
        if ($("#playlistSongList .sortable").length) {
            $("#playlistSongList .sortable").append(clonedItem);
        } else {
            // Eğer liste boşsa yeni liste oluştur
            $("#playlistSongList").html('<div class="tubi relaxed divided list sortable">' + clonedItem.prop('outerHTML') + '</div>');
            
            // Sıralama özelliğini etkinleştir
            $("#playlistSongList .sortable").sortable({
                opacity: 0.6,
                cursor: 'move',
                cancel: '.remove-song', // Silme butonunu sürüklemeden hariç tut
                update: function(event, ui) {
                    // Sıralama değiştiğinde otomatik kaydet
                    savePlaylistChanges();
                }
            }).disableSelection();
        }
        
        // Şarkı ekledikten sonra otomatik kaydet
        savePlaylistChanges();
    });
    
    // Şarkı kaldırma
    $(document).on("click", ".remove-song", function() {
        var songId = $(this).data("id");
        
        // Playlist'ten şarkıyı kaldır
        $(this).closest(".item").remove();
        
        // Tüm şarkılar listesindeki ilgili şarkının düğmesini güncelle
        $("#allSongsList .all-song[data-id='" + songId + "'] .button")
            .removeClass("positive disabled")
            .addClass("add-song")
            .html('<i class="plus icon"></i>');
        
        // Eğer playlist listesi boş kaldıysa mesaj göster
        if ($("#playlistSongList .sortable").length && $("#playlistSongList .sortable").children().length === 0) {
            $("#playlistSongList").html('<div class="tubi message info">Bu playlist\'e henüz şarkı eklenmemiş.</div>');
        }
        
        // Şarkı kaldırdıktan sonra otomatik kaydet
        savePlaylistChanges();
    });
    
    // Otomatik kaydetme fonksiyonu
    function savePlaylistChanges() {
        var songs = [];
        
        if ($("#playlistSongList .sortable").length) {
            // Sıralı tüm şarkıları al
            $("#playlistSongList .sortable .item").each(function() {
                songs.push($(this).data("id"));
            });
        }
        
        // AJAX ile kaydet
        $.ajax({
            type: "POST",
            url: "modules/muzibu/controller.php",
            dataType: "json",
            data: {
                processPlaylistSongs: 1,
                playlist_id: playlistId,
                songs: songs
            },
            success: function(json) {
                // Başarılı ise bir şey yapmayız (sessiz kayıt)
            },
            error: function(xhr, status, error) {
                console.error("AJAX Hatası:", error);
                $("#msgholder").html('<div class="tubi error message">İşlem sırasında bir hata oluştu.</div>');
            }
        });
    }
});
// ]]>
</script>

<!-- Özel CSS Stili -->
<style type="text/css">
#playlistSongList {
    max-height: 635px;
    overflow-y: auto;
}
#allSongsList {
    max-height: 500px;
    overflow-y: auto;
    position: relative;
}
.tubi.relaxed.divided.list .item {
    padding: 10px !important;
}
.tubi.relaxed.divided.list .item:hover {
    background-color: #f9f9f9;
}
.playlist-song {
    cursor: move;
}
.remove-song {
    cursor: pointer;
}
#searchStatus {
    display: inline-block;
    margin-left: 10px;
    vertical-align: middle;
}
.tubi.input.loading::after {
    content: '';
    position: absolute;
    right: 10px;
    top: 50%;
    margin-top: -0.5em;
    width: 1em;
    height: 1em;
    border: 2px solid rgba(0, 0, 0, 0.1);
    border-top-color: #767676;
    border-radius: 500rem;
    animation: spin 0.5s linear infinite;
}
.description.italic {
    font-style: italic;
    color: #888;
    text-align: center;
}
@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>