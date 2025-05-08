<!-- Banner Area Start -->
        <section class="banner" style="background-image: url('<?php echo THEMEURL; ?>/assets/media/bg/banner-bg.jpg');">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-10">
                        <div class="banner-content">
                            <h1 class="banner-title">Müziğin <span>Gücünü Keşfedin</span></h1>
                            <p class="fs-14 mb-0">İşletmenizin kimliğini ve atmosferini yansıtan, özenle hazırlanmış müzik koleksiyonları. Her biri farklı ruh halleri, sektörler ve müşteri profilleri için tasarlandı.</p>
                            <div class="banner-btn-wrap">
                                <a href="<?php echo Url::Muzibu('playlist');?>" class="banner-btn">Çalma Listeleri</a>
                                <a href="<?php echo Url::Muzibu('song');?>" class="banner-btn outline">Şarkılar</a>
                            </div>
                            <div class="banner-wave">
                                <img src="<?php echo THEMEURL; ?>/assets/media/bg/wave-1.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 banner-right d-none d-lg-block">
                        <div class="image-group-1">
                            <img src="<?php echo THEMEURL; ?>/assets/media/banner/headphones.png" alt="" class="headphones">
                            <img src="<?php echo THEMEURL; ?>/assets/media/banner/headphones-curve.png" alt="" class="headphones-curve">
                            <div class="vinyl-record">
                                <div class="vinyl-image img-1">
                                    <img src="<?php echo THEMEURL; ?>/assets/media/banner/vinyl-1.png" alt="">
                                    <div class="like">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                </div>
                                <div class="vinyl-image img-2">
                                    <img src="<?php echo THEMEURL; ?>/assets/media/banner/vinyl-2.png" alt="">
                                    <div class="like">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                </div>
                                <div class="vinyl-image img-3">
                                    <img src="<?php echo THEMEURL; ?>/assets/media/banner/vinyl-3.png" alt="">
                                    <div class="like">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="image-group-2">
                            <div class="music-note one"></div>
                            <div class="music-note two"></div>
                            <div class="music-note three"></div>
                            <div class="music-note four"></div>
                            <img src="<?php echo THEMEURL; ?>/assets/media/banner/equalizer.png" alt="" class="equalizer">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Banner Area End -->

        <!-- Recently Played Area Start -->
        <section class="py-64">
            <div class="row align-items-center row-gap-4 mb-14">
                <div class="col-lg-6">
                    <h2>Öne Çıkan Listeler</h2>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <a href="<?php echo Url::Muzibu('playlist');?>" class="view-all-btn">Hepsini Görüntüle</a>
                </div>
            </div>
            <div class="music-card-wrap">
                <?php 
                    // Sistem tarafından oluşturulan çalma listelerini getir - active=1, is_public=1, system=1
                    $playlists = Registry::get('Muzibu')->playlist->getSystemPlaylistsHome();
                    if($playlists):
                        foreach($playlists as $playlist):
                ?>
                <div class="card-item">
                    <a href="<?php echo Url::Muzibu("playlist-detail",$playlist->slug);?>" class="music-card" tabindex="-1" data-pjax>
                        <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $playlist->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" alt="">
                        <div class="content">
                            <h6><?php echo $playlist->title_tr;?></h6>
                            <p class="fs-13 color-white">Sistem</p>
                        </div>
                    </a>
                </div>
                <?php 
                        endforeach;
                    endif;
                ?>
            </div>
        </section>
        <!-- Recently Played Area End -->

        <!-- New Releases Area Start -->
        <section class="py-64">
            <div class="row align-items-center row-gap-4 mb-14">
                <div class="col-lg-6">
                    <h2>Yeni Şarkılar</h2>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <a href="<?php echo Url::Muzibu('song');?>" class="view-all-btn">Hepsini Görüntüle</a>
                </div>
            </div>
            <div class="music-card-wrap">
                <?php 
                    $newReleases = Registry::get('Muzibu')->homepage->getNewReleases();
                    if($newReleases):
                        foreach($newReleases as $song):
                ?>
                <div class="card-item">
                    <div class="music-card" tabindex="-1">
                        <div class="card-img">
                            <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $song->album_thumb;?>&amp;h=200&amp;w=200&amp;s=1&amp;a=c&amp;q=80" alt="">
                            <div class="play">
                                <a href="javascript:;" class="track-list" 
                                   data-track="<?php echo SITEURL;?>/modules/muzibu/datafiles/songs/<?php echo $song->file_path;?>" 
                                   data-poster="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $song->album_thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" 
                                   data-title="<?php echo $song->title_tr;?>" 
                                   data-singer="<?php echo $song->artist_title;?>"
                                   data-id="<?php echo $song->id;?>">
                                    <i class="fa-solid fa-play"></i>
                                </a>
                            </div>
                        </div>
                        <div class="content">
                            <h6><?php echo $song->title_tr;?></h6>
                            <p class="fs-13"><?php echo $song->artist_title;?></p>
                        </div>
                    </div>
                </div>
                <?php 
                        endforeach;
                    endif;
                ?>
            </div>
        </section>
        <!-- New Releases Area End -->

        <!-- Popular music artists start -->
        <section class="py-64">
            <div class="row align-items-center row-gap-4 mb-14">
                <div class="col-lg-6">
                    <h2>Popüler Sanatçılar</h2>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <a href="<?php echo Url::Muzibu('artist');?>" class="view-all-btn">Hepsini Görüntüle</a>
                </div>
            </div>
            <div class="artist-card-wrap">
                <?php 
                    $artists = Registry::get('Muzibu')->homepage->getPopularArtists();
                    if($artists):
                        foreach($artists as $artist):
                ?>
                <div class="card-item">
                    <a href="<?php echo Url::Muzibu("artist-detail",$artist->slug);?>" class="artist-card" data-pjax>
                        <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $artist->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" alt="">
                        <h5><?php echo $artist->title_tr;?></h5>
                    </a>
                </div>
                <?php 
                        endforeach;
                    endif;
                ?>
            </div>
        </section>
        <!-- Popular music artists End -->

        <!-- Trending music start -->
        <section class="py-64">
            <div class="row align-items-center row-gap-4 mb-50">
                <div class="col-lg-6">
                    <h2>Müzik Türleri</h2>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <a href="<?php echo Url::Muzibu('genre');?>" class="view-all-btn">Hepsini Görüntüle</a>
                </div>
            </div>
            <div class="music-card-wrap">
                <?php 
                    $genres = Registry::get('Muzibu')->homepage->getPopularGenres();
                    if($genres):
                        foreach($genres as $genre):
                ?>
                <div class="card-item">
                    <a href="<?php echo Url::Muzibu("genre-detail",$genre->slug);?>" class="music-card" tabindex="-1" data-pjax>
                        <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $genre->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" alt="">
                        <div class="content">
                            <h6><?php echo $genre->title_tr;?></h6>
                            <p class="fs-13 color-white"><?php echo $genre->song_count;?> Şarkı</p>
                        </div>
                    </a>
                </div>
                <?php 
                        endforeach;
                    endif;
                ?>
            </div>
        </section>
        <!-- Trending music End -->