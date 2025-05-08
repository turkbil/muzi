<!-- Banner Area Start -->
        <Section class="artist-banner">
        <img src="<?php echo THEMEURL; ?>/assets/media/bg/artist-bg-2.jpg" alt="" class="bg-img">
        <div class="content">
            <?php 
                $song = $content->moduledata->mod;
                $album = Registry::get('Muzibu')->album->getAlbumById($song->album_id);
                $artist = Registry::get('Muzibu')->artist->getArtistById($album->artist_id);
                $trackPath = $song->file_path ? SITEURL . '/modules/muzibu/datafiles/songs/' . $song->file_path : THEMEURL . '/assets/media/tracks/about-love.mp3';
            ?>
            <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $album->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" alt="" class="artist-img">
            <div>
                <h1><?php echo $song->title_tr;?></h1>
                <h3><?php echo $artist->title_tr;?> - <?php echo $album->title_tr;?></h3>
                <div class="bottom-block">
                    <div class="btn-block">
                        <a href="javascript:;" class="cus2-btn play track-list" 
                           data-track="<?php echo $trackPath; ?>" 
                           data-poster="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $album->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" 
                           data-title="<?php echo $song->title_tr; ?>" 
                           data-singer="<?php echo $artist->title_tr; ?>"
                           data-id="<?php echo $song->id; ?>">Şimdi Çal</a>
                    </div>
                    
                </div>
            </div>
        </div>
        </Section>
        <!-- Banner Area End -->

         <!-- Lyrics Section Start -->
        <section class="py-24">
            <h4 class="mb-24">Şarkı Sözleri</h4>
            <div class="lyrics-container">
                <?php if(!empty($song->lyrics_tr)): ?>
                    <div class="lyrics">
                        <?php echo nl2br($song->lyrics_tr); ?>
                    </div>
                <?php else: ?>
                    <p>Bu şarkı için henüz söz bulunmamaktadır.</p>
                <?php endif; ?>
            </div>
        </section>    
        
        <!-- Album Songs Section Start -->
        <section class="py-24">
            <h4 class="mb-24">Albümdeki Diğer Şarkılar</h4>
            <div class="songs-list">
                
                <?php 
                    $songs = Registry::get('Muzibu')->getSongsByAlbum($song->album_id);
                    if($user->logged_in):
                        $favorites = Registry::get('Muzibu')->getUserFavoritesBySongs($user->uid,$songs);
                    else:
                        $favorites = array();
                    endif;
                ?>
                <?php 
                $i=0;
                foreach($songs as $otherSong):
                    if($otherSong->id != $song->id): // Mevcut şarkıyı listeleme
                    $i++;
                    $otherTrackPath = $otherSong->file_path ? SITEURL . '/modules/muzibu/datafiles/songs/' . $otherSong->file_path : THEMEURL . '/assets/media/tracks/about-love.mp3';
                ?>
                <div class="song-card">
                    <div class="left-block">
                        <div class="play">
                            <a href="javascript:;" class="play track-list" 
                               data-track="<?php echo $otherTrackPath; ?>" 
                               data-poster="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $album->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" 
                               data-title="<?php echo $otherSong->title_tr; ?>" 
                               data-singer="<?php echo $artist->title_tr; ?>"
                               data-id="<?php echo $otherSong->id; ?>">
                               <i class="fas fa-play"></i>
                            </a>
                            <span><?php echo str_pad($i,2,"0",STR_PAD_LEFT);?></span>
                        </div>
                        <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $album->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" alt="">
                        <div>
                            <h6><?php echo $otherSong->title_tr;?></h6>
                            <a href="<?php echo Url::Muzibu("artist-detail",$artist->slug);?>"><?php echo $artist->title_tr;?></a>
                        </div>
                    </div>
                    <span class="duration"><?php echo formatMP3Duration($otherSong->duration).' sn';?></span>
                    <div class="right-block">
                        <a href="javascript:;" class="add-to-favorite" data-id="<?php echo $otherSong->id;?>" data-status="<?php echo in_array($otherSong->id,$favorites) ? "true" : "false";?>"><span class="tooltip-pop">Favorilere Ekle</span><i class="fa-regular fa-heart"></i></a>
                        <a href="javascript:;" class="add-to-playlist" data-id="<?php echo $otherSong->id;?>">
                            <span class="tooltip-pop">Çalma Listesine Ekle</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                                <path d="M0.5 4.58991C0.5 4.02195 0.960426 3.56152 1.52839 3.56152H15.9178C16.4857 3.56152 16.9462 4.02195 16.9462 4.58991C16.9462 5.15788 16.4857 5.6183 15.9178 5.6183H1.52839C0.960426 5.6183 0.5 5.15788 0.5 4.58991Z"/>
                                <path d="M0.5 10.2761C0.5 9.70817 0.960426 9.24775 1.52839 9.24775H15.9178C16.4857 9.24775 16.9462 9.70817 16.9462 10.2761C16.9462 10.8441 16.4857 11.3045 15.9178 11.3045H1.52839C0.960426 11.3045 0.5 10.8441 0.5 10.2761Z"/>
                                <path d="M0.5 15.9626C0.5 15.3947 0.960426 14.9342 1.52839 14.9342H12.1221C12.6901 14.9342 13.1505 15.3947 13.1505 15.9626C13.1505 16.5306 12.6901 16.991 12.1221 16.991H1.52839C0.960426 16.991 0.5 16.5306 0.5 15.9626Z"/>
                                <path d="M15.6373 15.8896C15.6373 15.3873 16.0445 14.98 16.5469 14.98H23.5904C24.0928 14.98 24.5 15.3873 24.5 15.8896C24.5 16.392 24.0928 16.7992 23.5904 16.7992H16.5469C16.0445 16.7992 15.6373 16.392 15.6373 15.8896Z"/>
                                <path d="M20.0686 20.4377C19.5792 20.4377 19.1824 20.0409 19.1824 19.5514V12.2279C19.1824 11.7384 19.5792 11.3416 20.0686 11.3416C20.5581 11.3416 20.9549 11.7384 20.9549 12.2279V19.5514C20.9549 20.0409 20.5581 20.4377 20.0686 20.4377Z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <?php 
                    endif;
                endforeach;
                ?>
            </div>
        </section>