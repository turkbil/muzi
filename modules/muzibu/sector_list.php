<!-- Banner Area Start -->
         <Section class="artist-banner">
            <img src="<?php echo THEMEURL; ?>/assets/media/bg/artist-bg-1.jpg" alt="" class="bg-img">
            <div class="content">
                <div>
                    <h1>Sektörler</h1>
                    <p class="mb-24 disc">Her işletme ve mekan tipine özel olarak hazırlanmış müzik koleksiyonlarını keşfedin. Restoran, cafe, mağaza ve daha pek çok sektör için özel seçilmiş çalma listeleri.</p>
                    
                </div>
            </div>
         </Section>
        <!-- Banner Area End -->

        <!-- Artist Area Start -->
        <section class="py-24">
            <div class="row align-items-center row-gap-4 mb-24">
                <div class="col-lg-6">
                    <h4>İşletme Tipinize Göre Öneriler</h4>
                    <p class="fs-13">İşletme tipinize özel hazırlanmış müzik koleksiyonları</p>
                </div>
                <div class="col-lg-6">
                    <form action="#" class="w-100">
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
                <?php $sectors = Registry::get('Muzibu')->getSectors();?>
                <?php foreach($sectors as $sector):?>
                <div class="col-lg-3 col-sm-4 col-6">
                    <a href="<?php echo Url::Muzibu("sector-detail",$sector->slug);?>" class="artist-card" data-pjax>
                        <img src="<?php echo SITEURL;?>/thumbmaker.php?src=<?php echo SITEURL;?>/modules/muzibu/dataimages/<?php echo $sector->thumb;?>&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80" alt="">
                        <h5><?php echo $sector->title_tr;?></h5>
                    </a>
                </div>
                <?php endforeach;?>
                
            </div>
            
        </section>
        <!-- Artist Area End -->