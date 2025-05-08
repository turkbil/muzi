<?php
  /**
   * Mainmenu
   *
   * @yazilim TUBI Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: mainmenu.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan 
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<div class="tubi styled pushed sidebar active" id="sidemenu">
  <div class="logo"><a href="index.php"><?php echo ($core->logo) ? '<img src="'.SITEURL.'/uploads/'.$core->logo.'" alt="'.$core->company.'" style="max-height: 60px; padding: 0 10px;" />': $core->company;?></a></div>
  <nav>
    <ul>
      <!-- li><a href="index.php" class="red active"><i class="icon dashboard"></i><span><?php echo Lang::$word->_N_DASH;?></span></a></li -->
      <?php if($user->getAcl("Menus")):?>
      <li><a href="index.php?do=menus" class="sky active"><i class="icon reorder"></i><span><?php echo Lang::$word->_N_MENUS;?></span></a></li>
      <?php endif;?>
      <?php if($user->getAcl("Pages")):?>
      <li><a href="index.php?do=pages" class="green active"><i class="icon file"></i><span><?php echo Lang::$word->_N_PAGES;?></span></a></li>
      <?php endif;?>


      <?php if($user->getAcl("Muzibu")):?>
      <li><a class="purple active <?php echo (Filter::$modname == 'muzibu') ? "expanded" : "collapsed";?>"><i class="icon music"></i><span>Muzibu<b>...</b></span></a>
        <ul class="subnav">
          <li><a href="index.php?do=modules&action=config&modname=muzibu" class="purple<?php if (Filter::$modname == 'muzibu' && !Filter::$maction) echo " active";?>">
            <?php if (Filter::$modname == 'muzibu' && !Filter::$maction) echo "<i class=\"small right icon\"></i>";?>
            <span>Şarkılar</span></a></li>
          <li><a href="index.php?do=modules&action=config&modname=muzibu&maction=albums" class="purple<?php if (Filter::$maction == 'albums' || Filter::$maction == 'album_add' || Filter::$maction == 'album_edit') echo " active";?>">
            <?php if (Filter::$maction == 'albums' || Filter::$maction == 'album_add' || Filter::$maction == 'album_edit') echo "<i class=\"small right icon\"></i>";?>
            <span>Albümler</span></a></li>
          <li><a href="index.php?do=modules&action=config&modname=muzibu&maction=artist-list" class="purple<?php if (Filter::$maction == 'artist-list' || Filter::$maction == 'artist-add' || Filter::$maction == 'artist-edit') echo " active";?>">
            <?php if (Filter::$maction == 'artist-list' || Filter::$maction == 'artist-add' || Filter::$maction == 'artist-edit') echo "<i class=\"small right icon\"></i>";?>
            <span>Sanatçılar</span></a></li>
          <li><a href="index.php?do=modules&action=config&modname=muzibu&maction=playlists" class="purple<?php if (Filter::$maction == 'playlists' || Filter::$maction == 'playlist_add' || Filter::$maction == 'playlist_edit' || Filter::$maction == 'playlist_songs') echo " active";?>">
            <?php if (Filter::$maction == 'playlists' || Filter::$maction == 'playlist_add' || Filter::$maction == 'playlist_edit' || Filter::$maction == 'playlist_songs') echo "<i class=\"small right icon\"></i>";?>
            <span>Çalma Listeleri</span></a></li>
          <li><a href="index.php?do=modules&action=config&modname=muzibu&maction=genres" class="purple<?php if (Filter::$maction == 'genres' || Filter::$maction == 'genre_add' || Filter::$maction == 'genre_edit') echo " active";?>">
            <?php if (Filter::$maction == 'genres' || Filter::$maction == 'genre_add' || Filter::$maction == 'genre_edit') echo "<i class=\"small right icon\"></i>";?>
            <span>Müzik Türleri</span></a></li>
          <li><a href="index.php?do=modules&action=config&modname=muzibu&maction=sectors" class="purple<?php if (Filter::$maction == 'sectors' || Filter::$maction == 'sector_add' || Filter::$maction == 'sector_edit') echo " active";?>">
            <?php if (Filter::$maction == 'sectors' || Filter::$maction == 'sector_add' || Filter::$maction == 'sector_edit') echo "<i class=\"small right icon\"></i>";?>
            <span>Sektörler</span></a></li>
        </ul>
      </li>
      <?php endif;?>

      <?php if($user->getAcl("Modules")):?>
      <li><a class="blue active <?php echo (Filter::$do == 'modules' && Filter::$modname != 'muzibu') ? "expanded" : "collapsed";?>"><i class="icon setting"></i><span><?php echo Lang::$word->_N_MODS;?><b>...</b></span></a>
        <ul class="subnav">
          <?php $modules2 = $content->getPageModules();?>
          <?php if(!$modules2):?>
          <?php else:?>
          <?php foreach ($modules2 as $row2):?>
          <?php if($user->getAcl($row2->modalias) && $row2->modalias != 'muzibu'):?>
          <?php if($row2->hasconfig):?>
          <li><a href="index.php?do=modules&amp;action=config&amp;modname=<?php echo $row2->modalias;?>" class="coral<?php if (Filter::$modname == "$row2->modalias") echo " active";?>">
            <?php if (Filter::$modname == "$row2->modalias") echo "<i class=\"small right icon\"></i>";?>
            <span><?php echo $row2->{'title'.Lang::$lang};?></span></a></li>
          <?php endif;?>
          <?php endif;?>
          <?php endforeach;?>
          <?php unset($row2);?>
          <?php endif;?>
        </ul>
      </li>
      <?php endif;?>


      <?php if($user->getAcl("Plugins")):?>
      <li><a href="index.php?do=plugins" class="orange active"><i class="icon umbrella"></i><span><?php echo Lang::$word->_N_PLUGS;?></span></a></li>
      <?php endif;?>
      <!-- <?php if($user->getAcl("Memberships") or $user->getAcl("Gateways") or $user->getAcl("Transactions")):?>
      <li><a class="coral <?php echo (Filter::$do == 'memberships' or Filter::$do == 'gateways' or Filter::$do == 'transactions') ? "expanded" : "collapsed";?>"><i class="icon bookmark"></i><span><?php echo Lang::$word->_N_MEMBS;?><b>...</b></span></a>
        <ul>
          <?php if($user->getAcl("Memberships")):?>
          <li><a href="index.php?do=memberships" class="coral<?php if (Filter::$do == 'memberships') echo  " active";?>"><i class="icon setting"></i><span><?php echo Lang::$word->_N_MEMBSET;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("Gateways")):?>
          <li><a href="index.php?do=gateways" class="coral<?php if (Filter::$do == 'gateways') echo " active";?>"><i class="icon share"></i><span><?php echo Lang::$word->_N_GATES;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("Transactions")):?>
          <li><a href="index.php?do=transactions" class="coral<?php if (Filter::$do == 'transactions') echo " active";?>"><i class="icon payment"></i><span><?php echo Lang::$word->_N_TRANS;?></span></a></li>
          <?php endif;?>
        </ul>
      </li>
      <?php endif;?> -->
      <?php if($user->getAcl("Layout")):?>
      <li><a href="index.php?do=layout" class="teal active"><i class="icon block layout"></i><span><?php echo Lang::$word->_N_LAYS;?></span></a></li>
      <?php endif;?>
      <?php if($user->getAcl("Users")):?>
      <li><a href="index.php?do=users" class="dust active"><i class="icon user"></i><span><?php echo Lang::$word->_N_USERS;?></span></a></li>
      <?php endif;?>
      <?php if($user->getAcl("Configuration") or $user->getAcl("Templates") or $user->getAcl("Newsletter") or $user->getAcl("Language") or $user->getAcl("Maintenance") or $user->getAcl("Logs") or $user->getAcl("Backup") or $user->getAcl("FM") or $user->getAcl("Fields") or $user->getAcl("System")):?>
      <li><a class="mortar active <?php echo (Filter::$do == 'config' or Filter::$do == 'templates' or Filter::$do == 'newsletter' or Filter::$do == 'language' or Filter::$do == 'maintenance' or Filter::$do == 'logs' or Filter::$do == 'fields' or Filter::$do == 'backup' or Filter::$do == 'filemanager' or Filter::$do == 'system') ? "expanded" : "collapsed";?>"><i class="icon setting"></i><span><?php echo Lang::$word->_N_CONF;?><b>...</b></span></a>
        <ul class="subnav">
          <?php if($user->getAcl("Configuration")):?>
          <li><a href="index.php?do=config" class="mortar<?php if (Filter::$do == 'config') echo " active";?>"><i class="smalls"></i><span><?php echo Lang::$word->_CG_TITLE1;?></span></a></li>
          <?php endif;?>
          <!-- <?php if($user->getAcl("Templates")):?>
          <li><a href="index.php?do=templates" class="mortar<?php if (Filter::$do == 'templates') echo " active";?>"><i class="icon mail"></i><span><?php echo Lang::$word->_N_EMAILS;?></span></a></li> -->
          <?php endif;?>
          <?php if($user->getAcl("Newsletter")):?>
          <!-- <li><a href="index.php?do=newsletter" class="mortar<?php if (Filter::$do == 'newsletter') echo " active";?>"><i class="icon mail reply"></i><span><?php echo Lang::$word->_N_NEWSL;?></span></a></li> -->
          <?php endif;?>
          <?php if($user->getAcl("Fields")):?>
          <!-- <li><a href="index.php?do=fields" class="mortar<?php if (Filter::$do == 'fields') echo " active";?>"><i class="icon tasks"></i><span><?php echo Lang::$word->_N_FIELDS;?></span></a></li> -->
          <?php endif;?>
          <?php if($user->getAcl("Language")):?>
          <!-- <li><a href="index.php?do=language" class="mortar<?php if (Filter::$do == 'language') echo " active";?>"><i class="icon chat"></i><span><?php echo Lang::$word->_N_LANGS;?></span></a></li> -->
          <?php endif;?>
          <?php if($user->getAcl("Maintenance")):?>
          <!-- <li><a href="index.php?do=maintenance" class="mortar<?php if (Filter::$do == 'maintenance') echo " active";?>"><i class="icon wrench"></i><span><?php echo Lang::$word->_N_SMTCN;?></span></a></li> -->
          <?php endif;?>
          <?php if($user->getAcl("Backup")):?>
          <li><a href="index.php?do=backup" class="mortar<?php if (Filter::$do == 'backup') echo " active";?>"><i class="small"></i><span><?php echo Lang::$word->_N_BACK;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("FM")):?>
          <li><a href="index.php?do=filemanager" class="mortar<?php if (Filter::$do == 'filemanager') echo " active";?>"><i class="small"></i><span><?php echo Lang::$word->_N_FM;?></span></a></li>
          <?php endif;?>
          <?php if($user->getAcl("System")):?>
          <!-- <li><a href="index.php?do=system" class="mortar<?php if (Filter::$do == 'system') echo " active";?>"><i class="icon laptop"></i><span><?php echo Lang::$word->_N_SYSTEM;?></span></a></li> -->
          <?php endif;?>
          <?php if($user->getAcl("Logs")):?>
          <li><a href="index.php?do=logs" class="mortar<?php if (Filter::$do == 'logs') echo " active";?>"><i class="small"></i><span><?php echo Lang::$word->_N_LOGS;?></span></a></li>
          <?php endif;?>
        </ul>
      </li>
      <?php endif;?>
    </ul>
  </nav>
  <div class="sublist"></div>
</div>