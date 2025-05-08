<!-- Banner Area Start -->
         <Section class="artist-banner">
            <img src="<?php echo THEMEURL; ?>/assets/media/bg/artist-bg-1.jpg" alt="" class="bg-img">
            <div class="content">
                <div>
                    <h1>Albümler</h1>
                    <p class="mb-24 disc">İşletmenizin kimliğini ve atmosferini yansıtan, özenle hazırlanmış albümler. Her biri farklı ruh halleri, sektörler ve müşteri profilleri için tasarlandı. Müzik seçmekle vakit kaybetmeden, mekanınızın karakterine en uygun koleksiyonları hemen keşfedin.</p>
                    
                </div>
            </div>
         </Section>
        <!-- Banner Area End -->

        <!-- Artist Area Start -->
        <section class="py-24">
            <div class="row align-items-center row-gap-4 mb-24">
                <div class="col-lg-6">
                    <h4>Albümler</h4>
                </div>
                <div class="col-lg-6">
                    <form action="releases.html" class="w-100">
                        <div class="search-field">
                            <button type="submit" class="search-btn"><i class="fa-regular fa-magnifying-glass"></i></button>
                            <div class="form-group">
                                <input type="search" class="cus-form-control" id="searchInput" name="search" autocomplete="off" placeholder="Arama">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row row-gap-4">
                <?php $albums = Registry::get('Muzibu')->getAlbums();?>
                <?php foreach($albums as $album):?>
                <div class="col-lg-3 col-sm-4 col-6">
                   <a href="<?php echo Url::Muzibu("album-detail",$album->slug);?>" class="music-card" tabindex="-1" data-pjax>
                        <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $album->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=60" alt="">
                        <div class="content">
                            <h6><?php echo $album->title_tr;?></h6>
                            <p class="fs-13 color-white"><?php echo $album->artist_name;?></p>
                        </div>
                    </a>
                </div>
                <?php endforeach;?>
                
            </div>
            
            <div class="more">
                <a href="#" class="accordion-button collapsed mt-24 mb-0 action-btn" data-bs-toggle="collapse" 
                    data-bs-target="#more-artists" aria-expanded="false" > DAHA FAZLA YÜKLE <i class="ms-2 fa fa-chevron-down"></i>
                </a>
            </div>
            
        </section>
        <!-- Artist Area End -->