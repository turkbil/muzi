<!-- Banner Area Start -->
         <section class="artist-banner">
            <img src="<?php echo THEMEURL; ?>/assets/media/bg/artist-bg-1.jpg" alt="" class="bg-img">
            <div class="content">
                <div>
                    <h1>Türler</h1>
                    <p class="mb-24 disc">Lorem ipsum dolor sit amet consectetur. Ultrices tellus adipiscing et risus. Eget platea euismod dictumst amet. Integer velit lorem gravida faucibus nec massa in. Quis vivamus molestie id proin eros sed bibendum pellentesque ut. Lorem ipsum dolor sit amet consectetur. Ultrices tellus adipiscing et risus. Eget platea euismod dictumst amet. Integer velit lorem gravida faucibus nec massa in. Quis vivamus molestie id proin eros sed bibendum pellentesque ut.</p>
                    
                </div>
            </div>
         </section>
        <!-- Banner Area End -->

        <!-- Artist Area Start -->
        <section class="py-24">
            <div class="row align-items-center row-gap-4 mb-24">
                <div class="col-lg-6">
                    <h4>Sevdiğiniz Müzk Türlerine Gözatın</h4>
                    <p class="fs-13">Sevebileceğiniz Popüler Müzik Türleri</p>
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
                <?php $genres = Registry::get('Muzibu')->getGenres();?>
                <?php foreach($genres as $genre):?>
                <div class="col-lg-3 col-sm-4 col-6">
                    <a href="<?php echo Url::Muzibu("genre-detail",$genre->slug);?>" class="artist-card" data-pjax>
                        <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $genre->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" alt="">
                        <h5><?php echo $genre->title_tr;?></h5>
                    </a>
                </div>
                <?php endforeach;?>
                
            </div>
            
            
            
        </section>
        <!-- Artist Area End -->