<!-- Banner Area Start -->
         <Section class="artist-banner">
            <img src="<?php echo THEMEURL; ?>/assets/media/bg/artist-bg-1.jpg" alt="" class="bg-img">
            <div class="content">
                <img src="<?php echo THEMEURL; ?>/assets/media/artist/artist-1.jpg" alt="" class="artist-img">
                <div>
                    <h1>Oynatma Listeleri </h1>
                    <p class="mb-24 disc">Lorem ipsum dolor sit amet consectetur. Ultrices tellus adipiscing et risus. Eget platea euismod dictumst amet. Integer velit lorem gravida faucibus nec massa in. Quis vivamus molestie id proin eros sed bibendum pellentesque ut. Lorem ipsum dolor sit amet consectetur. Ultrices tellus adipiscing et risus. Eget platea euismod dictumst amet. Integer velit lorem gravida faucibus nec massa in. Quis vivamus molestie id proin eros sed bibendum pellentesque ut.</p>
                    <div class="bottom-block">
                        <div></div>
                        <form action="#" class="w-50">
                        <div class="search-field">
                            <button type="submit" class="search-btn"><i class="fa-regular fa-magnifying-glass"></i></button>
                            <div class="form-group">
                                <input type="search" class="cus-form-control" id="searchInput" name="search" autocomplete="off" placeholder="Arama">
                            </div>
                        </div>
                    </form>
                        
                    </div>
                </div>
            </div>
         </Section>
        <!-- Banner Area End -->

        <!-- Artist Area Start -->
        <section class="py-24">
            <div class="row align-items-center row-gap-4 mb-24">
                <div class="col-12">
                    <h4>Kişisel Listeleriniz</h4>
                    <p class="fs-13">Sizin oluşturduğunuz oynatma listeleri</p>
                </div>
                
            </div>
            
                <?php if ($user->logged_in):?>
                    <?php $playlists = Registry::get('Muzibu')->playlist->getPlaylistsByUser(2);?>
                    <?php if($playlists):?>
                    <div class="row row-gap-4">
                    <?php foreach($playlists as $playlist):?>
                    
                    <div class="col-lg-3 col-sm-4 col-6">
                        <a href="<?php echo Url::Muzibu("playlist-detail",$playlist->slug);?>" class="music-card" tabindex="-1" data-pjax>
                            <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $playlist->thumb != "" ? $playlist->thumb : $playlist->album_thumb ;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" alt="">
                            <div class="content">
                                <h6><?php echo $playlist->title_tr;?></h6>
                                <p class="fs-13 color-white"><?php echo $playlist->song_count;?> Şarkı </p>
                            </div>
                        </a>
                    </div>
                    
                    <?php endforeach;?>
                    </div>
                    <?php else:?>
                    <div class="row row-gap-4 playlists-list"><div class="col-12">Henüz bir oynatma listesi oluşturmadınız.</div></div>
                    <?php endif;?>
                <?php else:?>
                    <div class="row row-gap-4">
                    <div class="col-12">
                        <p>Sizde kendi listelerinizi hazırlamak için şimdi iletişime geçin.</p>
                    </div>
                    </div>
                <?php endif;?>
                
            
            
        </section>
        <!-- Artist Area End -->
        
        <!-- Artist Area Start -->
        <section class="py-24 mt-64 playlists-section">
            <div class="row align-items-center row-gap-4 mb-24">
                <div class="col-12">
                    <h4>Muzibu Oynatma Listeleri</h4>
                    <p class="fs-13">Sistem tarafından hazırlanmış oynatma listeleri</p>
                </div>
                
            </div>
            <?php 
            // Sistem tarafından oluşturulan çalma listelerini getir - active=1, is_public=1, system=1
            $playlists = Registry::get('Muzibu')->playlist->getSystemPlaylists();
            ?>
            <?php if($playlists):?>
            <div class="row row-gap-4 playlists-list">
                <?php foreach($playlists as $playlist):?>
                <div class="col-lg-3 col-sm-4 col-6">
                    <a href="<?php echo Url::Muzibu("playlist-detail",$playlist->slug);?>" class="music-card" tabindex="-1" data-pjax>
                        <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $playlist->thumb != "" ? $playlist->thumb : $playlist->album_thumb ;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=60" alt="">
                        <div class="content">
                            <h6><?php echo $playlist->title_tr;?></h6>
                            <p class="fs-13 color-white"><?php echo $playlist->song_count;?> Şarkı </p>
                        </div>
                    </a>
                </div>
                <?php endforeach;?>
                
                
            </div>
            <div class="more">
                <a href="#" class="accordion-button collapsed mt-24 mb-0 action-btn" data-bs-toggle="collapse" 
                    data-bs-target="#more-artists" aria-expanded="false" data-page="1"> DAHA FAZLA YÜKLE <i class="ms-2 fa fa-chevron-down"></i>
                </a>
            </div>
            <?php else:?>
            <div class="row row-gap-4 playlists-list"><div class="col-12">Sisteme eklenmiş bir oynatma listesi bulunmamaktadır.</div></div>
            <?php endif;?>
        </section>
        
        <script type="text/template" id="playlist-template">
            <div class="col-lg-3 col-sm-4 col-6">
                <a href="{{slug}}" class="music-card" tabindex="-1">
                    <img src="{{thumb}}" alt="">
                    <div class="content">
                        <h6>{{title}}</h6>
                        <p class="fs-13 color-white">{{count}} Şarkı </p>
                    </div>
                </a>
            </div>
        </script>
        <!-- Artist Area End -->