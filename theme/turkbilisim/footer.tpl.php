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
<div class="audio-bar">
    <!-- Audio Player -->
    <audio id="audio-player" preload="none" class="mejs__player" controls data-mejsoptions='{"defaultAudioHeight": "50", "alwaysShowControls": "true"}' style="max-width:100%;">
        <source src="<?php echo THEMEURL; ?>/assets/media/tracks/maq-amor.mp3" type="audio/mp3">
    </audio>
    <!-- Default Track - onLoad -->
    <div id="track-onload" data-track="<?php echo THEMEURL; ?>/assets/media/tracks/clean-clean.mp3" data-poster="<?php echo THEMEURL; ?>/assets/media/tracks/poster-images/the-end-of-the-beginning.jpg" data-title="Clean Clean" data-singer="R Costello"></div>
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

function audioInit(){
	 var audio = $("#audio-player"),
     playerId = audio.closest('.mejs__container').attr('id'),
     playerObject = mejs.players[playerId];
	 
		// Shuffle butonunu oluÅŸtur
		const shuffleBtn = document.createElement('div');
		shuffleBtn.className = 'mejs__button mejs__shuffle-button shuffle-off';
		shuffleBtn.innerHTML = '<button id="shuffle-toggle"><i class="fas fa-shuffle"></i></button>';
		
		shuffleBtn.addEventListener("click", function () {
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
			playPrevTrack();
			console.log("Loop modu: " + (isLoop ? "Açik" : "Kapali"));
		});
		
		// Next butonunu olustur
		const nextTrackBtn = document.createElement('div');
		nextTrackBtn.className = 'mejs__button mejs__next-button';
		nextTrackBtn.innerHTML = '<button id="next-btn"><i class="fa-solid fa-forward"></i></button>';
	
		nextTrackBtn.addEventListener("click", function () {
			playNextTrack(false);
			console.log("Loop modu: " + (isLoop ? "Açik" : "Kapali"));
		});
		
		// Süre göstergesini bul ve shuffle butonunu yanina ekle
		const controls = jQuery(`#${playerId} .mejs__controls`);
		const timeDisplay = controls.find('.mejs__duration-container'); // Süre göstergesi (geçen süre / toplam süre)
			
		if (timeDisplay.length) {
			timeDisplay.after(shuffleBtn); // Süre güstergesinin yanina ekle
        	timeDisplay.after(loopBtn);    // Loop butonunu ekle
        	timeDisplay.after(nextTrackBtn);    // Loop butonunu ekle
        	timeDisplay.after(prevTrackBtn);    // Loop butonunu ekle
		}
		
		playerObject.media.addEventListener("ended", function() {
			
        	playNextTrack();
    	})
}

function playNextTrack(shuffle=true) {
    if (trackList.length === 0) return;
    
    let nextIndex;
    if (isShuffle && shuffle) {
        do {
            nextIndex = Math.floor(Math.random() * trackList.length);
			
        } while (nextIndex === currentTrackIndex);
    } else {
        nextIndex = (currentTrackIndex + 1) % trackList.length;
    }

    currentTrackIndex = nextIndex;
    const nextTrack = trackList[currentTrackIndex];
		console.log(nextTrack);

    changeAudio(nextTrack.element, nextTrack.track, nextTrack.poster, nextTrack.title, nextTrack.singer);
}

function playPrevTrack() {
    if (trackList.length === 0) return;
    
    let prevIndex;
    prevIndex = (currentTrackIndex - 1) % trackList.length;

    currentTrackIndex = prevIndex;
    const prevTrack = trackList[currentTrackIndex];
		console.log(prevTrack);

    changeAudio(prevTrack.element, prevTrack.track, prevTrack.poster, prevTrack.title, prevTrack.singer);
}

function changeAudio(clickEl,sourceUrl, posterUrl, trackTitle, trackSinger, playAudio = true ) {
    var audio = $("#audio-player"),
        playerId = audio.closest('.mejs__container').attr('id'),
        playerObject = mejs.players[playerId];
		
		console.log(audio,playerId,playerObject);
		
    if(clickEl == checkelement){
        
            if (playerObject.node.paused) {
                playerObject.play();
                jQuery(clickEl).find('i').removeClass('fas fa-play').addClass('far fa-pause');
            } else {
                playerObject.pause();
                jQuery(clickEl).find('i').removeClass('far fa-pause').addClass('fas fa-play');
            }
        
        return true;
    }else{
        checkelement = clickEl;

        jQuery('.track-list').find('i').removeClass('far fa-pause').addClass('fas fa-play');
    }

    trackPlaying = sourceUrl;

    audio.attr( 'poster', posterUrl );
    audio.attr( 'title', trackTitle );

    jQuery('.mejs__layers').html('').html('<div class="mejs-track-artwork"><img src="'+ posterUrl +'" alt="Track Poster" /></div><div class="mejs-track-details"><h3>'+ trackTitle +'<br><span>'+ trackSinger +'</span></h3></div>');

    if( sourceUrl != '' ) {
        playerObject.setSrc( sourceUrl );
    }
    playerObject.pause();
    playerObject.load();

    if( playAudio == true ) {
        playerObject.play();
        jQuery(clickEl).find('i').removeClass('fas fa-play').addClass('far fa-pause');
    }
}

jQuery('#pjax-container').on('click','.track-list' ,function () {
    var _this = this,
        audioTrack = jQuery(this).attr('data-track'),
        posterUrl = jQuery(this).attr('data-poster'),
        trackTitle = jQuery(this).attr('data-title');
    	trackSinger = jQuery(this).attr('data-singer');
        
    var parentList = jQuery(this).closest('.songs-list');
	var trackItems = parentList.find('.track-list');

    trackList = [];
    trackItems.each(function (index) {
        trackList.push({
            element: this,
            track: jQuery(this).attr('data-track'),
            poster: jQuery(this).attr('data-poster'),
            title: jQuery(this).attr('data-title'),
            singer: jQuery(this).attr('data-singer')
        });
        if (this === _this) {
            currentTrackIndex = index;
        }
    });
    console.log(trackList);
    const clickedTrack = trackList[currentTrackIndex];
    changeAudio(clickedTrack.element, clickedTrack.track, clickedTrack.poster, clickedTrack.title, clickedTrack.singer);
    return false;
});

jQuery(window).on( 'load', function(){
    var trackOnload = jQuery('#track-onload');

    if( trackOnload.length > 0 ) {
        var audioTrack = trackOnload.attr('data-track'), // Track url
            posterUrl = trackOnload.attr('data-poster'), // Track Poster Image
            trackTitle = trackOnload.attr('data-title'); // Track Title
            trackSinger = trackOnload.attr('data-singer'); // Track Singer Name
		
        setTimeout( function(){
            changeAudio(trackOnload,audioTrack, posterUrl, trackTitle, trackSinger, false );
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