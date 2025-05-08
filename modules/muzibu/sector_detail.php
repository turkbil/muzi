<!-- Banner Area Start -->
        <Section class="artist-banner">
        <img src="<?php echo THEMEURL; ?>/assets/media/bg/artist-bg-2.jpg" alt="" class="bg-img">
        <div class="content">
            <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $content->moduledata->mod->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" alt="" class="artist-img">
            <div>
                <h1><?php echo $content->moduledata->mod->title_tr;?></h1>
                <p class="mb-24 disc">Bu sektör için özel olarak seçilmiş müzik koleksiyonları. İşletmenizin atmosferine uygun, müşterilerinizi etkileyecek çalma listeleri.</p>
                
            </div>
        </div>
        </Section>
        <!-- Banner Area End -->

         <!-- Popular Music Start -->
        <section class="py-24">
            <h4 class="mb-24">Çalma Listeleri</h4>
            <div class="row row-gap-4">
                <?php 
                $playlists = Registry::get('Muzibu')->playlist->getSectorPlaylists($content->moduledata->mod->id);
                if($playlists):
                    foreach($playlists as $playlist):
                ?>
                <div class="col-lg-3 col-sm-4 col-6">
                    <a href="<?php echo Url::Muzibu("playlist-detail",$playlist->slug);?>" class="music-card" tabindex="-1" data-pjax>
                        <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $playlist->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" alt="">
                        <div class="content">
                            <h6><?php echo $playlist->title_tr;?></h6>
                            <p class="fs-13 color-white"><?php echo $playlist->fname . ' ' . $playlist->lname;?></p>
                        </div>
                    </a>
                </div>
                <?php 
                    endforeach;
                else:
                ?>
                <div class="col-12">
                    <p>Bu sektöre ait henüz bir çalma listesi bulunmamaktadır.</p>
                </div>
                <?php endif; ?>
            </div>
        </section>