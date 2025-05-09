<?php
/**
 * Footer
 *
 * @yazilim Tubi Portal
 * @web adresi turkbilisim.com.tr
 * @copyright 2014
 * @version $Id: footer.php, v4.00 4011-04-20 10:12:05 Nurullah Okatan
 */

if ( !defined( "_VALID_PHP" ) )
  die( 'Direct access to this location is not allowed.' );
?>

    <!-- Footer Area Start -->
    <footer class="py-40">
        <div class="footer-main">
            <div class="row align-items-center row-gap-4">
                
                <div class="col-lg-6 col-md-7">
                    <div class="row">
                        <div class="col-4">
                            <div class="footer-widget">
                                <h6 class="mb-32">Hızlı Erişim</h6>
                                <ul class="unstyled">
                                    <li><a href="<?php echo Url::Muzibu('playlist');?>">Oynatma Listeleri</a></li>
                                    <li><a href="<?php echo Url::Muzibu('song');?>">Şarkılar</a></li>
                                    <li><a href="<?php echo Url::Muzibu('album');?>">Albümler</a></li>
                                    <li><a href="<?php echo Url::Muzibu('genre');?>">Türler</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="footer-widget">
                                <h6 class="mb-32">Hesap</h6>
                                <ul class="unstyled">
                                    <?php if (!$user->logged_in):?>
                                    <li><a href="<?php echo Url::Page('login');?>">Giriş Yap</a></li>
                                    <li><a href="#">Kayıt Ol</a></li>
                                    <?php else:?>
                                    <li><a href="<?php echo Url::Page('kullanici');?>">Profil</a></li>
                                    <li><a href="<?php echo Url::Page('uyelik');?>">Üyelik Bilgileri</a></li>
                                    <li><a href="<?php echo Url::Page('planlar');?>">Abonelik</a></li>
                                    <?php endif;?>

                                </ul>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="footer-widget">
                                <h6 class="mb-32">Sosyal Medya</h6>
                                <ul class="unstyled">
                                    <li><a href="#">LinkedIn</a></li>
                                    <li><a href="#">Instagram</a></li>
                                    <li><a href="#">Facebook</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>Muzibu 2025. Tüm Hakları Saklıdır.</p>
        </div>
    </footer>
    <!-- Footer Area End -->
      
</main> 
<!-- Mobile Menu Start -->
<div class="sidebar-nav__wrapper">
    <div class="sidebar-nav__overlay sidebar-nav__toggler"></div>
    <div class="sidebar-nav__content">
        <div class="logo-box">
            <a href="<?php echo SITEURL;?>/" aria-label="logo image"><?php echo ($core->logo) ? '<img src="'.SITEURL.'/uploads/'.$core->logo.'" alt="'.$core->company.'" />': $core->company;?></a>
        </div>
        <div class="sidebar-nav__container">
        </div>
    </div>
</div>
<!-- Mobile Menu End -->
</div>
<!-- Audio Bar -->
<!-- Audio Bar -->
<div class="audio-bar">
    <!-- Audio Player -->
    <audio id="audio-player" preload="none" class="mejs__player" controls data-mejsoptions='{"defaultAudioHeight": "50", "alwaysShowControls": "true"}' style="max-width:100%;">
        <source src="<?php echo THEMEURL; ?>/assets/media/tracks/maq-amor.mp3" type="audio/mp3">
    </audio>
    
    <?php 
    // Veritabanından rastgele bir şarkı çek
    $db = Registry::get("Database");
    $sql = "SELECT s.*, a.title" . Lang::$lang . " as artist_title, 
            l.title" . Lang::$lang . " as album_title, l.thumb
            FROM muzibu_songs as s 
            LEFT JOIN muzibu_albums as l ON l.id = s.album_id 
            LEFT JOIN muzibu_artists as a ON a.id = l.artist_id 
            WHERE s.active = 1 AND s.file_path IS NOT NULL
            ORDER BY RAND() 
            LIMIT 1";
    
    $randomSong = $db->first($sql);
    
    if ($randomSong) {
        $trackPath = SITEURL . '/modules/muzibu/datafiles/songs/' . $randomSong->file_path;
        $posterPath = $randomSong->thumb ? SITEURL . '/modules/muzibu/dataimages/' . $randomSong->thumb : THEMEURL . '/assets/media/tracks/poster-images/track-01.jpg';
        $title = $randomSong->title_tr;
        $artist = $randomSong->artist_title;
    } else {
        // Yedek olarak varsayılan bir şarkı
        $trackPath = THEMEURL . '/assets/media/tracks/maq-amor.mp3';
        $posterPath = THEMEURL . '/assets/media/tracks/poster-images/track-01.jpg';
        $title = 'Demo Şarkı';
        $artist = 'Demo Sanatçı';
    }
    ?>
    
    <!-- Default Track - onLoad -->
    <div id="track-onload" 
         data-track="<?php echo $trackPath; ?>" 
         data-poster="<?php echo $posterPath; ?>" 
         data-title="<?php echo $title; ?>" 
         data-singer="<?php echo $artist; ?>"
         data-id="<?php echo $randomSong ? $randomSong->id : ''; ?>"
         data-genre-id="<?php echo $randomSong ? $randomSong->genre_id : ''; ?>"
         data-artist-id="<?php echo $randomSong ? $randomSong->artist_id : ''; ?>"
         data-user-logged="<?php echo $user->logged_in ? 'true' : 'false'; ?>">
    </div>
</div>

<?php if ($user->logged_in):?>
<div class="modal fade" id="addPlaylist" tabindex="-1" aria-labelledby="addPlaylist" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addPlaylist">Oynatma Listeleri</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         
      </div>
      <div class="modal-footer">
        <div class="playlist-response"><div class="response"></div></div>
        <a href="javascript:void();" id="addNewPlaylistBtn" class="cus2-btn "><i class="fa-solid fa-plus"></i> Yeni Oynatma Listesi Ekle</a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="addNewPlaylist" tabindex="-1" aria-labelledby="addNewPlaylist" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addPlaylist">Yeni Liste Ekle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
                 <input type="text" id="newPlaylistName" class="form-control" placeholder="Oynatma listesi adı girin">
      </div>
      <div class="modal-footer">
        <a href="javascript:void();" type="button" class="cus2-btn sec" id="cancelNewPlaylist">İptal</a>
        <a href="javascript:void();" type="button" class="cus2-btn " id="createNewPlaylist">Oluştur</a>
      </div>
    </div>
  </div>
</div>
<?php endif;?>

<!-- back-to-top-start -->
<a href="#" class="scroll-top">
    <svg class="scroll-top__circle" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</a>
<!-- back-to-top-end -->

<!-- Jquery Js -->
<script src="<?php echo THEMEURL; ?>/assets/js/vendor/jquery-3.6.3.min.js"></script>
<script src="<?php echo THEMEURL; ?>/assets/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo THEMEURL; ?>/assets/js/vendor/jquery-appear.js"></script>
<script src="<?php echo THEMEURL; ?>/assets/js/vendor/slick.min.js"></script>
<script src="<?php echo THEMEURL; ?>/assets/js/vendor/jquery.countdown.min.js"></script>
<script src="<?php echo THEMEURL; ?>/assets/js/vendor/mediaelement-and-player.js"></script>
<script src="<?php echo THEMEURL; ?>/assets/js/vendor/jquery.pjax.js"></script>

<script>
    var SITEURL = "<?php echo SITEURL;?>";
</script>
<script src="<?php echo THEMEURL; ?>/assets/js/app.js"></script>

<!-- Audio player Script  -->
<script>
var trackPlaying = '',
    audioPlayer = document.getElementById('audio-player');
var checkelement = '';

var trackList = [];
var currentTrackIndex = 0;
var isShuffle = false;
var isLoop = false;
var isUserLoggedIn = false;
var currentGenreId = null;
var currentArtistId = null;

// Dinleme istatistikleri için değişkenler
var songPlayTimer = 0;
var songPlayTimerInterval = null;
var currentSongId = null;
var songPlayed = false;

// Daha fazla şarkı yükleniyor mu
var isLoadingMoreSongs = false;
// Yeni şarkıları saklama
var loadedSongIds = [];

function audioInit(){
    var audio = $("#audio-player"),
    playerId = audio.closest('.mejs__container').attr('id'),
    playerObject = mejs.players[playerId];
    
    // Kullanıcı durumunu kontrol et
    isUserLoggedIn = $('#track-onload').attr('data-user-logged') === 'true';
    
    // Üyelik uyarısını oluştur
    if (!isUserLoggedIn) {
        if (!document.querySelector('.membership-warning')) {
            const membershipWarning = document.createElement('div');
            membershipWarning.className = 'membership-warning';
            membershipWarning.innerHTML = `
                <div class="warning-overlay">
                    <div class="warning-box">
                        <h3>Üye Olmayan Kullanıcı</h3>
                        <p>Şarkıları tam olarak dinlemek ve daha fazla içeriğe erişmek için üye olun!</p>
                        <div class="warning-buttons">
                            <a href="${SITEURL}/sayfa/login/" class="membership-btn">Giriş Yap</a>
                            <a href="${SITEURL}/sayfa/kayit/" class="membership-btn primary">Üye Ol</a>
                            <a href="javascript:void(0);" class="membership-btn close-warning">Kapat</a>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(membershipWarning);
            
            // Kapat butonuna tıklandığında
            membershipWarning.querySelector('.close-warning').addEventListener('click', function() {
                membershipWarning.style.display = 'none';
            });
        }
        
        // 30 saniye sınırlaması için doğrudan event listener ekle
        playerObject.media.addEventListener('timeupdate', function() {
            if (playerObject.media.currentTime >= 30 && !isUserLoggedIn) {
                playerObject.pause();
                document.querySelector('.membership-warning').style.display = 'block';
            }
        });
        
        // Kullanıcının 30 saniyeden sonra kaydırmasını engelle
        playerObject.media.addEventListener('seeking', function() {
            if (playerObject.media.currentTime > 30 && !isUserLoggedIn) {
                playerObject.media.currentTime = 30;
                playerObject.pause();
                document.querySelector('.membership-warning').style.display = 'block';
            }
        });
    }
    
    // Şarkı dinlenme takibi
    playerObject.media.addEventListener('play', function() {
        if (currentSongId) {
            songPlayTimer = 0;
            songPlayed = false;
            
            // Dinleme sayacını başlat
            clearInterval(songPlayTimerInterval);
            songPlayTimerInterval = setInterval(function() {
                songPlayTimer++;
                
                // 30 saniyeden fazla dinlendiyse ve henüz kaydedilmediyse
                if (songPlayTimer >= 30 && !songPlayed) {
                    songPlayed = true;
                    logSongPlay(currentSongId);
                }
            }, 1000);
        }
    });
    
    playerObject.media.addEventListener('pause', function() {
        clearInterval(songPlayTimerInterval);
    });
    
    playerObject.media.addEventListener('ended', function() {
        clearInterval(songPlayTimerInterval);
        
        // Şarkı bittiğinde
        if (!isUserLoggedIn) {
            document.querySelector('.membership-warning').style.display = 'block';
        } else {
            playNextTrack();
        }
    });
    
    // Shuffle butonunu oluştur
    const shuffleBtn = document.createElement('div');
    shuffleBtn.className = 'mejs__button mejs__shuffle-button shuffle-off';
    shuffleBtn.innerHTML = '<button id="shuffle-toggle"><i class="fas fa-shuffle"></i></button>';
    
    shuffleBtn.addEventListener("click", function () {
        if (!isUserLoggedIn) {
            document.querySelector('.membership-warning').style.display = 'block';
            return;
        }
        isShuffle = !isShuffle;
        shuffleBtn.classList.toggle("shuffle-on", isShuffle);
        shuffleBtn.classList.toggle("shuffle-off", !isShuffle);
        console.log("Shuffle modu: " + (isShuffle ? "Açik" : "Kapali"));
    });
    
    // Loop butonunu olustur
    const loopBtn = document.createElement('div');
    loopBtn.className = 'mejs__button mejs__loop-button loop-off';
    loopBtn.innerHTML = '<button id="loop-toggle"><i class="fas fa-redo"></i></button>';

    loopBtn.addEventListener("click", function () {
        if (!isUserLoggedIn) {
            document.querySelector('.membership-warning').style.display = 'block';
            return;
        }
        isLoop = !isLoop;
        loopBtn.classList.toggle("loop-on", isLoop);
        loopBtn.classList.toggle("loop-off", !isLoop);
        console.log("Loop modu: " + (isLoop ? "Açik" : "Kapali"));
        playerObject.media.loop = isLoop;
    });
    
    // Prev butonunu olustur
    const prevTrackBtn = document.createElement('div');
    prevTrackBtn.className = 'mejs__button mejs__prev-button';
    prevTrackBtn.innerHTML = '<button id="prev-btn"><i class="fa-solid fa-backward"></i></button>';

    prevTrackBtn.addEventListener("click", function () {
        if (!isUserLoggedIn) {
            document.querySelector('.membership-warning').style.display = 'block';
            return;
        }
        playPrevTrack();
    });
    
    // Next butonunu olustur
    const nextTrackBtn = document.createElement('div');
    nextTrackBtn.className = 'mejs__button mejs__next-button';
    nextTrackBtn.innerHTML = '<button id="next-btn"><i class="fa-solid fa-forward"></i></button>';

    nextTrackBtn.addEventListener("click", function () {
        if (!isUserLoggedIn) {
            document.querySelector('.membership-warning').style.display = 'block';
            return;
        }
        playNextTrack(false);
    });
    
    // Süre göstergesini bul ve shuffle butonunu yanina ekle
    const controls = jQuery(`#${playerId} .mejs__controls`);
    const timeDisplay = controls.find('.mejs__duration-container'); // Süre göstergesi (geçen süre / toplam süre)
        
    if (timeDisplay.length) {
        timeDisplay.after(shuffleBtn); 
        timeDisplay.after(loopBtn);   
        timeDisplay.after(nextTrackBtn);  
        timeDisplay.after(prevTrackBtn);  
    }
}

// Şarkı dinlemeyi kaydet
function logSongPlay(songId) {
    if (!songId) return;
    
    // AJAX ile veritabanına kaydet
    $.ajax({
        url: SITEURL + '/modules/muzibu/ajax_songplay.php',
        type: 'POST',
        data: {
            song_id: songId,
            action: 'log_play'
        },
        success: function(response) {
            console.log('Şarkı dinleme kaydedildi');
        },
        error: function(xhr, status, error) {
            console.error('Şarkı dinleme kaydedilemedi');
        }
    });
}

// Aynı tür/genre'deki şarkıları getir
function loadMoreSongsByGenre(genreId, callback) {
    if (!genreId || isLoadingMoreSongs) return;
    
    isLoadingMoreSongs = true;
    console.log('Yeni şarkılar yükleniyor... Genre ID:', genreId);
    
    // Çalınan şarkıları listele (tekrar çalmayı önlemek için)
    var playedSongIds = [];
    trackList.forEach(function(track) {
        if (track.song_id) playedSongIds.push(parseInt(track.song_id));
    });
    
    // AJAX ile şarkıları çek
    $.ajax({
        url: SITEURL + '/modules/muzibu/ajax_songs.php',
        type: 'GET',
        data: {
            action: 'load',
            genre_id: genreId,
            limit: 20,
            page: 1
        },
        success: function(response) {
            isLoadingMoreSongs = false;
            
            if (response.songs && response.songs.length > 0) {
                // Zaten çalınan şarkıları filtrele
                var newSongs = response.songs.filter(function(song) {
                    return !playedSongIds.includes(parseInt(song.id));
                });
                
                if (newSongs.length > 0) {
                    console.log('Yeni şarkılar bulundu:', newSongs.length);
                    callback(newSongs);
                } else {
                    console.log('Yeni şarkı bulunamadı, farklı bir türe geçiliyor...');
                    // Farklı bir türden şarkı bul
                    loadRandomSongs(callback);
                }
            } else {
                console.log('Yanıtta hiç şarkı yok, farklı bir türe geçiliyor...');
                loadRandomSongs(callback);
            }
        },
        error: function(xhr, status, error) {
            isLoadingMoreSongs = false;
            console.error('Şarkı yüklenirken hata:', error);
            loadRandomSongs(callback);
        }
    });
}

// Sanatçıya ait şarkıları getir
function loadMoreSongsByArtist(artistId, callback) {
    if (!artistId || isLoadingMoreSongs) return;
    
    isLoadingMoreSongs = true;
    console.log('Sanatçının diğer şarkıları yükleniyor... Artist ID:', artistId);
    
    // Çalınan şarkıları listele
    var playedSongIds = [];
    trackList.forEach(function(track) {
        if (track.song_id) playedSongIds.push(parseInt(track.song_id));
    });
    
    // AJAX ile şarkıları çek
    $.ajax({
        url: SITEURL + '/modules/muzibu/ajax_songs.php',
        type: 'GET',
        data: {
            action: 'load',
            artist_id: artistId,
            limit: 15,
            page: 1
        },
        success: function(response) {
            isLoadingMoreSongs = false;
            
            if (response.songs && response.songs.length > 0) {
                // Zaten çalınan şarkıları filtrele
                var newSongs = response.songs.filter(function(song) {
                    return !playedSongIds.includes(parseInt(song.id));
                });
                
                if (newSongs.length > 0) {
                    console.log('Sanatçının diğer şarkıları bulundu:', newSongs.length);
                    callback(newSongs);
                } else {
                    console.log('Sanatçının başka şarkısı bulunamadı, aynı türe geçiliyor...');
                    // Aynı türden başka şarkılar bul
                    if (currentGenreId) {
                        loadMoreSongsByGenre(currentGenreId, callback);
                    } else {
                        loadRandomSongs(callback);
                    }
                }
            } else {
                console.log('Sanatçının şarkısı bulunamadı, aynı türe geçiliyor...');
                if (currentGenreId) {
                    loadMoreSongsByGenre(currentGenreId, callback);
                } else {
                    loadRandomSongs(callback);
                }
            }
        },
        error: function(xhr, status, error) {
            isLoadingMoreSongs = false;
            console.error('Şarkı yüklenirken hata:', error);
            if (currentGenreId) {
                loadMoreSongsByGenre(currentGenreId, callback);
            } else {
                loadRandomSongs(callback);
            }
        }
    });
}

// Rastgele şarkılar getir
function loadRandomSongs(callback) {
    if (isLoadingMoreSongs) return;
    
    isLoadingMoreSongs = true;
    console.log('Rastgele şarkılar yükleniyor...');
    
    // Çalınan şarkıları listele
    var playedSongIds = [];
    trackList.forEach(function(track) {
        if (track.song_id) playedSongIds.push(parseInt(track.song_id));
    });
    
    // AJAX ile rastgele şarkıları çek
    $.ajax({
        url: SITEURL + '/modules/muzibu/ajax_songs.php',
        type: 'GET',
        data: {
            action: 'load',
            limit: 15,
            page: 1
        },
        success: function(response) {
            isLoadingMoreSongs = false;
            
            if (response.songs && response.songs.length > 0) {
                // Zaten çalınan şarkıları filtrele
                var newSongs = response.songs.filter(function(song) {
                    return !playedSongIds.includes(parseInt(song.id));
                });
                
                if (newSongs.length > 0) {
                    console.log('Rastgele şarkılar bulundu:', newSongs.length);
                    callback(newSongs);
                } else {
                    console.log('Yeni şarkı bulunamadı, liste başa dönüyor...');
                    // Hiç şarkı bulunamadıysa, var olan listeyi temizleyip yeniden başla
                    loadedSongIds = [];
                    callback([]);
                }
            } else {
                console.log('Hiç şarkı bulunamadı, liste başa dönüyor...');
                callback([]);
            }
        },
        error: function(xhr, status, error) {
            isLoadingMoreSongs = false;
            console.error('Şarkı yüklenirken hata:', error);
            callback([]);
        }
    });
}

// Şarkıları oynatma listesine ekle
function addSongsToPlaylist(songs) {
    if (!songs || songs.length === 0) return;
    
    // Şarkıları oynatma listesine ekle
    songs.forEach(function(song) {
        var trackPath = song.file_path ? SITEURL + '/modules/muzibu/datafiles/songs/' + song.file_path : THEMEURL + '/assets/media/tracks/about-love.mp3';
        var posterPath = song.thumb ? SITEURL + '/thumbmaker.php?src=' + SITEURL + '/modules/muzibu/dataimages/' + song.thumb + '&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80' : THEMEURL + '/assets/media/tracks/poster-images/track-01.jpg';
        
        // Şarkı ID'sini kontrol et (tekrar eklememek için)
        if (loadedSongIds.includes(parseInt(song.id))) {
            return;
        }
        
        loadedSongIds.push(parseInt(song.id));
        
        trackList.push({
            element: null,
            track: trackPath,
            poster: posterPath,
            title: song.title_tr,
            singer: song.artist_name || song.artist_title,
            song_id: song.id,
            genre_id: song.genre_id,
            artist_id: song.artist_id
        });
    });
    
    console.log('Şarkılar eklendi, yeni oynatma listesi uzunluğu:', trackList.length);
}

function playNextTrack(shuffle=true) {
    if (trackList.length === 0) {
        // Liste boşsa sayfadaki şarkıları topla
        var allPageTracks = document.querySelectorAll('.track-list');
        if (allPageTracks.length > 0) {
            trackList = [];
            loadedSongIds = [];
            
            allPageTracks.forEach(function(elem, index) {
                var songId = elem.getAttribute('data-id');
                if (songId) loadedSongIds.push(parseInt(songId));
                
                trackList.push({
                    element: elem,
                    track: elem.getAttribute('data-track'),
                    poster: elem.getAttribute('data-poster'),
                    title: elem.getAttribute('data-title'),
                    singer: elem.getAttribute('data-singer'),
                    song_id: songId,
                    genre_id: elem.getAttribute('data-genre-id'), 
                    artist_id: elem.getAttribute('data-artist-id')
                });
            });
            currentTrackIndex = 0;
        } else {
            return; // Hiç şarkı bulunamadı
        }
    }
    
    // Dinleme sayacını temizle
    clearInterval(songPlayTimerInterval);
    
    // Kullanıcı giriş yapmamışsa, şarkı değiştirmeye izin vermeyelim
    if (!isUserLoggedIn) {
        document.querySelector('.membership-warning').style.display = 'block';
        return;
    }
    
    let nextIndex;
    
    if (isShuffle && shuffle) {
        // Rastgele bir şarkı seç
        do {
            nextIndex = Math.floor(Math.random() * trackList.length);
        } while (nextIndex === currentTrackIndex && trackList.length > 1);
    } else {
        // Sırayla çal
        if (currentTrackIndex >= trackList.length - 1) {
            // Liste sonuna geldik, yeni şarkı yükle
            console.log('Liste sonuna ulaşıldı. Yeni şarkılar yükleniyor...');
            
            // Son dinlenen şarkının tür ve sanatçı bilgilerini al
            var lastTrack = trackList[currentTrackIndex];
            var genreId = lastTrack.genre_id;
            var artistId = lastTrack.artist_id;
            
            // Dönüşümlü olarak sanatçının diğer şarkılarını ve türün diğer şarkılarını yükle
            if (Math.random() > 0.5 && artistId) {
                loadMoreSongsByArtist(artistId, function(newSongs) {
                    addSongsToPlaylist(newSongs);
                    
                    // Liste boş değilse devam et
                    if (trackList.length > 0) {
                        nextIndex = currentTrackIndex + 1;
                        if (nextIndex >= trackList.length) {
                            nextIndex = 0; // Sanatçının başka şarkısı yoksa başa dön
                        }
                        
                        // Şarkıyı çal
                        currentTrackIndex = nextIndex;
                        const nextTrack = trackList[currentTrackIndex];
                        
                        // Genre ve Artist bilgilerini güncelle
                        if (nextTrack.genre_id) currentGenreId = nextTrack.genre_id;
                        if (nextTrack.artist_id) currentArtistId = nextTrack.artist_id;
                        
                        changeAudio(nextTrack.element, nextTrack.track, nextTrack.poster, nextTrack.title, nextTrack.singer, nextTrack.song_id);
                    }
                });
                return;
            } else if (genreId) {
                loadMoreSongsByGenre(genreId, function(newSongs) {
                    addSongsToPlaylist(newSongs);
                    
                    // Liste boş değilse devam et
                    if (trackList.length > 0) {
                        nextIndex = currentTrackIndex + 1;
                        if (nextIndex >= trackList.length) {
                            nextIndex = 0; // Tür içinde başka şarkı yoksa başa dön
                        }
                        
                        // Şarkıyı çal
                        currentTrackIndex = nextIndex;
                        const nextTrack = trackList[currentTrackIndex];
                        
                        // Genre ve Artist bilgilerini güncelle
                        if (nextTrack.genre_id) currentGenreId = nextTrack.genre_id;
                        if (nextTrack.artist_id) currentArtistId = nextTrack.artist_id;
                        
                        changeAudio(nextTrack.element, nextTrack.track, nextTrack.poster, nextTrack.title, nextTrack.singer, nextTrack.song_id);
                    }
                });
                return;
            } else {
                // Hem tür hem de sanatçı bilgisi yoksa rastgele şarkı yükle
                loadRandomSongs(function(newSongs) {
                    addSongsToPlaylist(newSongs);
                    
                    // Liste boş değilse devam et
                    if (trackList.length > 0) {
                        nextIndex = currentTrackIndex + 1;
                        if (nextIndex >= trackList.length) {
                            nextIndex = 0; // Şarkı yoksa başa dön
                        }
                        
                        // Şarkıyı çal
                        currentTrackIndex = nextIndex;
                        const nextTrack = trackList[currentTrackIndex];
                        
                        // Genre ve Artist bilgilerini güncelle
                        if (nextTrack.genre_id) currentGenreId = nextTrack.genre_id;
                        if (nextTrack.artist_id) currentArtistId = nextTrack.artist_id;
                        
                        changeAudio(nextTrack.element, nextTrack.track, nextTrack.poster, nextTrack.title, nextTrack.singer, nextTrack.song_id);
                    }
                });
                return;
            }
        } else {
            nextIndex = currentTrackIndex + 1;
        }
    }

    // Şarkıyı çal
    currentTrackIndex = nextIndex;
    const nextTrack = trackList[currentTrackIndex];
    
    // Genre ve Artist bilgilerini güncelle
    if (nextTrack.genre_id) currentGenreId = nextTrack.genre_id;
    if (nextTrack.artist_id) currentArtistId = nextTrack.artist_id;
    
    changeAudio(nextTrack.element, nextTrack.track, nextTrack.poster, nextTrack.title, nextTrack.singer, nextTrack.song_id);
}

function playPrevTrack() {
    if (trackList.length === 0) return;
    
    // Dinleme sayacını temizle
    clearInterval(songPlayTimerInterval);
    
    // Kullanıcı giriş yapmamışsa, şarkı değiştirmeye izin vermeyelim
    if (!isUserLoggedIn) {
        document.querySelector('.membership-warning').style.display = 'block';
        return;
    }
    
    let prevIndex;
    if (currentTrackIndex === 0) {
        prevIndex = trackList.length - 1;
    } else {
        prevIndex = currentTrackIndex - 1;
    }

    currentTrackIndex = prevIndex;
    const prevTrack = trackList[currentTrackIndex];
    
    // Genre ve Artist bilgilerini güncelle
    if (prevTrack.genre_id) currentGenreId = prevTrack.genre_id;
    if (prevTrack.artist_id) currentArtistId = prevTrack.artist_id;

    changeAudio(prevTrack.element, prevTrack.track, prevTrack.poster, prevTrack.title, prevTrack.singer, prevTrack.song_id);
}

function changeAudio(clickEl, sourceUrl, posterUrl, trackTitle, trackSinger, songId, playAudio = true) {
    var audio = $("#audio-player"),
        playerId = audio.closest('.mejs__container').attr('id'),
        playerObject = mejs.players[playerId];
    
    // Mevcut şarkı ID'sini kaydet
    currentSongId = songId;
    
    // Dinleme sayacını temizle
    clearInterval(songPlayTimerInterval);
    songPlayTimer = 0;
    songPlayed = false;
    
    if(clickEl == checkelement){
        if (playerObject.node.paused) {
            playerObject.play();
            jQuery(clickEl).find('i').removeClass('fas fa-play').addClass('far fa-pause');
            
            // Oynatma başladığında sayacı başlat
            songPlayTimerInterval = setInterval(function() {
                songPlayTimer++;
                if (songPlayTimer >= 30 && !songPlayed) {
                    songPlayed = true;
                    logSongPlay(currentSongId);
                }
            }, 1000);
        } else {
            playerObject.pause();
            jQuery(clickEl).find('i').removeClass('far fa-pause').addClass('fas fa-play');
            clearInterval(songPlayTimerInterval);
        }
        
        return true;
    } else {
        checkelement = clickEl;
        jQuery('.track-list').find('i').removeClass('far fa-pause').addClass('fas fa-play');
    }

    trackPlaying = sourceUrl;

    audio.attr('poster', posterUrl);
    audio.attr('title', trackTitle);

    jQuery('.mejs__layers').html('').html('<div class="mejs-track-artwork"><img src="'+ posterUrl +'" alt="Track Poster" /></div><div class="mejs-track-details"><h3>'+ trackTitle +'<br><span>'+ trackSinger +'</span></h3></div>');

    if(sourceUrl != '') {
        playerObject.setSrc(sourceUrl);
    }
    playerObject.pause();
    playerObject.load();

    if(playAudio == true) {
        playerObject.play();
        if(clickEl) {
            jQuery(clickEl).find('i').removeClass('fas fa-play').addClass('far fa-pause');
        }
        
        // Dinleme sayacını başlat
        songPlayTimerInterval = setInterval(function() {
            songPlayTimer++;
            if (songPlayTimer >= 30 && !songPlayed) {
                songPlayed = true;
                logSongPlay(currentSongId);
            }
        }, 1000);
    }
}

jQuery('#pjax-container').on('click', '.track-list', function() {
    var _this = this,
        audioTrack = jQuery(this).attr('data-track'),
        posterUrl = jQuery(this).attr('data-poster'),
        trackTitle = jQuery(this).attr('data-title'),
        trackSinger = jQuery(this).attr('data-singer'),
        songId = jQuery(this).attr('data-id'),
        genreId = jQuery(this).attr('data-genre-id'),
        artistId = jQuery(this).attr('data-artist-id');
        
    // Genre ve artist bilgilerini güncelle
    if (genreId) currentGenreId = genreId;
    if (artistId) currentArtistId = artistId;
        
    var parentList = jQuery(this).closest('.songs-list');
    var trackItems = parentList.find('.track-list');

    trackList = [];
    loadedSongIds = [];
    
    trackItems.each(function(index) {
        var songId = jQuery(this).attr('data-id');
        if (songId) loadedSongIds.push(parseInt(songId));
        
        trackList.push({
            element: this,
            track: jQuery(this).attr('data-track'),
            poster: jQuery(this).attr('data-poster'),
            title: jQuery(this).attr('data-title'),
            singer: jQuery(this).attr('data-singer'),
            song_id: songId,
            genre_id: jQuery(this).attr('data-genre-id'),
            artist_id: jQuery(this).attr('data-artist-id')
        });
        if (this === _this) {
            currentTrackIndex = index;
        }
    });
    
    const clickedTrack = trackList[currentTrackIndex];
    changeAudio(clickedTrack.element, clickedTrack.track, clickedTrack.poster, clickedTrack.title, clickedTrack.singer, clickedTrack.song_id);
    return false;
});

jQuery(window).on('load', function(){
    var trackOnload = jQuery('#track-onload');

    if(trackOnload.length > 0) {
        var audioTrack = trackOnload.attr('data-track'),
            posterUrl = trackOnload.attr('data-poster'),
            trackTitle = trackOnload.attr('data-title'), 
            trackSinger = trackOnload.attr('data-singer'),
            songId = trackOnload.attr('data-id'),
            genreId = trackOnload.attr('data-genre-id'),
            artistId = trackOnload.attr('data-artist-id');
            
        isUserLoggedIn = trackOnload.attr('data-user-logged') === 'true';
        
        // Genre ve artist bilgilerini güncelle
        if (genreId) currentGenreId = genreId;
        if (artistId) currentArtistId = artistId;
        
        // Sayfadaki tüm şarkıları bir kez bulalım - liste başlangıcı için
        var allPageTracks = document.querySelectorAll('.track-list');
        if (allPageTracks.length > 0) {
            trackList = [];
            loadedSongIds = [];
            
            allPageTracks.forEach(function(elem, index) {
                var songId = elem.getAttribute('data-id');
                if (songId) loadedSongIds.push(parseInt(songId));
                
                trackList.push({
                    element: elem,
                    track: elem.getAttribute('data-track'),
                    poster: elem.getAttribute('data-poster'),
                    title: elem.getAttribute('data-title'),
                    singer: elem.getAttribute('data-singer'),
                    song_id: songId,
                    genre_id: elem.getAttribute('data-genre-id'),
                    artist_id: elem.getAttribute('data-artist-id')
                });
            });
        }
        
        setTimeout(function(){
            changeAudio(trackOnload, audioTrack, posterUrl, trackTitle, trackSinger, songId, false);
        }, 500);
    }
    
    audioInit();
});
</script>


<?php $content->getPluginAssets($assets);?>
<?php $content->getModuleAssets();?>
<?php if($core->analytics):?>
<!-- Google Analytics --> 
<?php echo cleanOut($core->analytics);?> 
<!-- Google Analytics /-->
<?php endif;?>
</body></html>