<?php
if (!defined("_VALID_PHP"))
    die('Direct access to this location is not allowed.');

// Muzibu sınıfını doğru şekilde yükleme
require_once(BASEPATH . 'admin/modules/muzibu/admin_class.php');

// Muzibu modülünü başlat
$muzibu = new Muzibu();

// Anasayfa içerikleri için gerekli verileri çekelim
$latestArticle = geti2("*","mod_blog","WHERE cid= '1' ORDER BY created DESC");
$latestRelease = $muzibu->homepage->getLatestNewRelease();
$newReleases = $muzibu->homepage->getNewReleases(5);
$latestPlaylists = $muzibu->playlist->getSystemPlaylistsHome(10);
$popularWeek = $muzibu->homepage->getPopularThisWeek(5);
$topRecommendations = $muzibu->homepage->getTopRecommendations(5);
$popularGenres = $muzibu->homepage->getPopularGenres(7);
$interestingAlbums = $muzibu->homepage->getInterestingAlbums(7);
$upcomingRelease = $muzibu->homepage->getUpcomingReleases();


?>

<section class="pt-24 pb-48">
    <div class="row row-gap-4">
        <div class="col-xl-6">
            <div class="d-flex align-items-center gap-sm-4 gap-2 mb-24">
                <form action="#" class="w-100">
                    <div class="search-field">
                        <button type="submit" class="search-btn"><i class="fa-regular fa-magnifying-glass"></i></button>
                        <div class="form-group">
                            <input type="search" class="cus-form-control" id="searchInput" name="search" autocomplete="off" placeholder="Ara">
                        </div>
                    </div>
                </form>
                
            </div>
            <div class="new-release-block">
                <?php if ($latestArticle): ?>
                <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/blog/dataimages/<?php echo $latestArticle->thumb;?>&amp;h=410&amp;w=800&amp;s=1&amp;a=c&amp;q=80" alt="<?php echo $latestArticle->title_tr; ?>">
                <div class="content">
                    <div>
                        <p class="fs-13">Yeni Çıkan</p>
                        <h2><?php echo $latestArticle->title_tr; ?></h2>
                        <p class="fs-13"><?php echo $latestArticle->artist_title; ?></p>
                    </div>
                    <a href="<?php echo  Url::Blog("item", $latestArticle->slug);?>" data-pjax class="cus2-btn"> Oku <i class="fa-solid fa-play"></i></a>
                </div>
                
                <?php endif; ?>
            </div>
        </div>
        <div class="col-xl-6">
            <h4 class="mb-24">Yeni Çıkanlar</h4>
            <div class="songs-list">
                <?php if ($newReleases): 
                    $counter = 1;
                    if($user->logged_in):
                        $favorites = $muzibu->getUserFavoritesBySongs($user->uid,$newReleases);
                    else:
                        $favorites = array();
                    endif;
                    foreach ($newReleases as $song): 
                    $thumbPath = $song->album_thumb ? SITEURL . '/thumbmaker.php?src=' . SITEURL . '/modules/muzibu/dataimages/' . $song->album_thumb . '&amp;h=80&amp;w=80&amp;s=1&amp;a=c&amp;q=80' : THEMEURL . '/assets/media/songs/s-img-sm-01.png';
                    $trackPath = $song->file_path ? SITEURL . '/modules/muzibu/datafiles/songs/' . $song->file_path : THEMEURL . '/assets/media/tracks/about-love.mp3';
                ?>
                <div class="song-card">
                    <div class="left-block">
                        <div class="play">
                            <a href="javascript:;" class="play track-list" 
                               data-track="<?php echo $trackPath; ?>" 
                               data-poster="<?php echo $thumbPath; ?>" 
                               data-title="<?php echo $song->title_tr; ?>" 
                               data-singer="<?php echo $song->artist_title; ?>">
                                <i class="fas fa-play"></i>
                            </a>
                            <span><?php echo str_pad($counter, 2, '0', STR_PAD_LEFT); ?></span>
                        </div>
                        <img src="<?php echo $thumbPath; ?>" alt="<?php echo $song->title_tr; ?>">
                        <div>
                            <h6><?php echo $song->title_tr; ?></h6>
                            <a href=""><?php echo $song->artist_title; ?></a>
                        </div>
                    </div>
                    <div class="right-block">
                        <a href="javascript:;" class="add-to-favorite" data-id="<?php echo $song->id;?>"  data-status="<?php echo in_array($song->id,$favorites) ? "true" : "false";?>"><span class="tooltip-pop">Favorilere Ekle</span><i class="fa-regular fa-heart"></i></a>
                        <a href="javascript:;" class="add-to-playlist" data-id="<?php echo $song->id;?>">
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
                    $counter++;
                    endforeach; 
                endif; 
                ?>
            </div>
        </div>
    </div>
</section>
<!-- Hero Area End -->

<!-- Trending Music Start -->
<section class="pb-40">
    <h4>Son Eklenen Oynatma Listeleri</h4>
    <div class="music-slider row" data-slick='{"autoplay": true, "infinite": true}'>
        <?php if ($latestPlaylists): 
            foreach ($latestPlaylists as $playlist): 
        ?>
        <!-- slide item  -->
        <div class="col-12 slide-item">
            <a href="<?php echo Url::Muzibu("playlist-detail",$playlist->slug);?>" class="music-card">
                <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $playlist->thumb != "" ? $playlist->thumb : $playlist->album_thumb ;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80; ?>" alt="<?php echo $trend->title_tr; ?>">
                <div class="content">
                    <h6><?php echo $playlist->title_tr; ?></h6>
                </div>
            </a>
        </div>
        <?php 
            endforeach; 
        
        endif; 
        ?>
    </div>
</section>
<!-- Trending Music End -->


<!-- Releases Area Start -->
<section class="py-40">
    <div class="row row-gap-4">
        <div class="col-xl-6">
            <h4 class="mb-24">Bu Hafta Popüler</h4>
            <div class="songs-list">
                <?php if ($popularWeek): 
                    $counter = 1;
                    if($user->logged_in):
                        $favorites = $muzibu->getUserFavoritesBySongs($user->uid,$popularWeek);
                    else:
                        $favorites = array();
                    endif;
                    foreach ($popularWeek as $popular): 
                    $thumbPath = $popular->album_thumb ? SITEURL . '/thumbmaker.php?src=' . SITEURL . '/modules/muzibu/dataimages/' . $popular->album_thumb . '&amp;h=80&amp;w=80&amp;s=1&amp;a=c&amp;q=80' : THEMEURL . '/assets/media/songs/s-img-sm-0' . (($counter % 5) + 6) . '.png';
                    $trackPath = $popular->file_path ? SITEURL . '/modules/muzibu/datafiles/songs/' . $popular->file_path : THEMEURL . '/assets/media/tracks/lost-european.mp3';
                ?>
                <div class="song-card">
                    <div class="left-block">
                        <div class="play">
                            <a href="javascript:;" class="play track-list" 
                               data-track="<?php echo $trackPath; ?>" 
                               data-poster="<?php echo $popular->album_thumb ? SITEURL . '/thumbmaker.php?src=' . SITEURL . '/modules/muzibu/dataimages/' . $popular->album_thumb . '&amp;h=300&amp;w=300&amp;s=1&amp;a=c&amp;q=80' : THEMEURL . '/assets/media/tracks/poster-images/track-0' . ($counter % 5 + 1) . '.jpg'; ?>" 
                               data-title="<?php echo $popular->title_tr; ?>" 
                               data-singer="<?php echo $popular->artist_title; ?>">
                                <i class="fas fa-play"></i>
                            </a>
                            <span><?php echo str_pad($counter, 2, '0', STR_PAD_LEFT); ?></span>
                        </div>
                        <img src="<?php echo $thumbPath; ?>" alt="<?php echo $popular->title_tr; ?>">
                        <div>
                            <h6><?php echo $popular->title_tr; ?></h6>
                            <a href=""><?php echo $popular->artist_title; ?></a>
                        </div>
                    </div>
                    <div class="right-block">
                        <a href="javascript:;" class="add-to-favorite" data-id="<?php echo $popular->id;?>"  data-status="<?php echo in_array($popular->id,$favorites) ? "true" : "false";?>"><span class="tooltip-pop">Favorilere Ekle</span><i class="fa-regular fa-heart"></i></a>
                        <a href="javascript:;" class="add-to-playlist" data-id="<?php echo $popular->id;?>">
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
                    $counter++;
                    endforeach;
                endif;
                ?>
                
                
            </div>
        </div>
        <div class="col-xl-6">
            <h4 class="mb-24">En İyi Öneriler</h4>
            <div class="songs-list">
                <?php if ($topRecommendations): 
                    $counter = 1;
                    if($user->logged_in):
                        $favorites = $muzibu->getUserFavoritesBySongs($user->uid,$topRecommendations);
                    else:
                        $favorites = array();
                    endif;
                    foreach ($topRecommendations as $recommend): 
                    $thumbPath = $recommend->album_thumb ? SITEURL . '/thumbmaker.php?src=' . SITEURL . '/modules/muzibu/dataimages/' . $recommend->album_thumb . '&amp;h=80&amp;w=80&amp;s=1&amp;a=c&amp;q=80' : THEMEURL . '/assets/media/songs/s-img-sm-0' . (($counter % 5) + 1) . '.png';
                    $trackPath = $recommend->file_path ? SITEURL . '/modules/muzibu/datafiles/songs/' . $recommend->file_path : THEMEURL . '/assets/media/tracks/about-love.mp3';
                ?>
                <div class="song-card">
                    <div class="left-block">
                        <div class="play">
                            <a href="javascript:;" class="play track-list" 
                               data-track="<?php echo $trackPath; ?>" 
                               data-poster="<?php echo $recommend->album_thumb ? SITEURL . '/thumbmaker.php?src=' . SITEURL . '/modules/muzibu/dataimages/' . $recommend->album_thumb . '&amp;h=300&amp;w=300&amp;s=1&amp;a=c&amp;q=80' : THEMEURL . '/assets/media/tracks/poster-images/track-0' . ($counter % 5 + 1) . '.jpg'; ?>" 
                               data-title="<?php echo $recommend->title_tr; ?>" 
                               data-singer="<?php echo $recommend->artist_title; ?>">
                                <i class="fas fa-play"></i>
                            </a>
                            <span><?php echo str_pad($counter, 2, '0', STR_PAD_LEFT); ?></span>
                        </div>
                        <img src="<?php echo $thumbPath; ?>" alt="<?php echo $recommend->title_tr; ?>">
                        <div>
                            <h6><?php echo $recommend->title_tr; ?></h6>
                            <a href=""><?php echo $recommend->artist_title; ?></a>
                        </div>
                    </div>
                    <div class="right-block">
                        <a href="javascript:;" class="add-to-favorite" data-id="<?php echo $recommend->id;?>"  data-status="<?php echo in_array($recommend->id,$favorites) ? "true" : "false";?>"><span class="tooltip-pop">Favorilere Ekle</span><i class="fa-regular fa-heart"></i></a>
                        <a href="javascript:;" class="add-to-playlist" data-id="<?php echo $recommend->id;?>">
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
                    $counter++;
                    endforeach; 
                endif;
                ?>
                
            </div>
        </div>
    </div>
</section>
<!-- Releases Area End -->

<!-- Artist Area Start -->
<section class="py-40">
    <h4>Sevebileceğiniz Popüler Müzik Türleri</h4>
    <div class="music-slider row" data-slick='{"autoplay": true, "infinite": true}'>
        <?php if ($popularGenres): 
            foreach ($popularGenres as $genre): 
            $thumbPath = SITEURL . '/thumbmaker.php?src=' . SITEURL . '/modules/muzibu/dataimages/' . $genre->thumb . '&amp;h=200&amp;w=200&amp;s=1&amp;a=c&amp;q=80';
        ?>
        <!-- slide item  -->
        <div class="col-12 slide-item">
            <a href="<?php echo Url::Muzibu('genre-detail',$genre->slug);?>" class="music-card">
                <img src="<?php echo $thumbPath; ?>" alt="<?php echo $genre->title_tr; ?>">
                <div class="content">
                    <h6><?php echo $genre->title_tr; ?></h6>
                </div>
            </a>
        </div>
        <?php 
            endforeach; 
        endif; 
        ?>
    </div>
</section>
<!-- Artist Area End -->

<!-- Albums Area Start -->
<section class="py-40">
    <h4>İlginizi Çekebilecek Albümler</h4>
    <div class="music-slider row" data-slick='{"autoplay": true, "infinite": true}'>
        <?php if ($interestingAlbums): 
            foreach ($interestingAlbums as $album): 
            $thumbPath = $album->thumb ? SITEURL . '/thumbmaker.php?src=' . SITEURL . '/modules/muzibu/dataimages/' . $album->thumb . '&amp;h=200&amp;w=200&amp;s=1&amp;a=c&amp;q=80' : THEMEURL . '/assets/media/songs/album-01.jpg';
        ?>
        <!-- slide item  -->
        <div class="col-12 slide-item">
            <a href="<?php echo Url::Muzibu('album-detail',$album->slug);?>" class="music-card">
                <img src="<?php echo $thumbPath; ?>" alt="<?php echo $album->title_tr; ?>">
                <div class="content">
                    <h6><?php echo $album->title_tr; ?></h6>
                </div>
            </a>
        </div>
        <?php 
            endforeach; 
       
        endif; 
        ?>
    </div>
</section>
<!-- Albums Area End -->

