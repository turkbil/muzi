<!-- Banner Area Start -->
         <Section class="artist-banner">
            <img src="<?php echo THEMEURL; ?>/assets/media/bg/artist-bg-1.jpg" alt="" class="bg-img">
            <div class="content">
                <div>
                    <h1>Sanatçılar</h1>
                    <p class="mb-24 disc">İşletmenizin müzik atmosferini zenginleştiren özel seçilmiş sanatçılar. Her biri farklı müzik türleri ve stilleriyle mekanınıza özgün bir hava katıyor. Keşfedin ve mekanınıza en uygun sanatçıyı bulun.</p>
                    
                </div>
            </div>
         </Section>
        <!-- Banner Area End -->

        <!-- Artist Area Start -->
        <section class="py-24">
            <div class="row align-items-center row-gap-4 mb-24">
                <div class="col-lg-6">
                    <h4>Sevdiğiniz Sanatçılara Gözatın</h4>
                    <p class="fs-13">En çok tercih edilen sanatçılar</p>
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
                <?php $artists = Registry::get('Muzibu')->getArtists();?>
                <?php foreach($artists as $artist):?>
                <div class="col-lg-3 col-sm-4 col-6">
                    <a href="<?php echo Url::Muzibu("artist-detail",$artist->slug);?>" class="artist-card" data-pjax>
                        <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $artist->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" alt="">
                        <h5><?php echo $artist->title_tr;?></h5>
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