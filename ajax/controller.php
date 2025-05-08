<?php
  /**
   * Controller
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: controller.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  require_once("../init.php");
  
  require_once (MODPATH . "muzibu/admin_class.php");
  $classname = 'Muzibu';
  try {
      if (!class_exists($classname)) {
          throw new exception('Missing muzibu/admin_class.php');
      }
      Registry::set('Muzibu', new Muzibu(false));
  }
  catch (exception $e) {
      echo $e->getMessage();
  }
?>
<?php
  if ($_POST['process'] == "add_favorite" && $user->logged_in):
      if($_POST['status'] == 'true'):
          $data = array();
          $data['user_id'] = $user->uid;
          $data['song_id'] = intval($_POST['song_id']);
          $data['created'] = date("Y-m-d H:i:s");
         $db->insert("muzibu_favorites", $data);  
         
         $json['message'] = "Favorilere Eklendi";
         $json['status'] = true;
		 echo json_encode($json);
		 exit;
      else:
         $user_id = $user->uid;
         $song_id = intval($_POST['song_id']);
         $db->delete("muzibu_favorites", 'song_id = '.$song_id . " AND user_id = ".$user_id);  
         
         $json['message'] = "Favorilere Silindi";
         $json['status'] = false;
		 echo json_encode($json);
      endif;
      
  endif;
  
  if ($_POST['process'] == "get_user_playlists" && $user->logged_in):
        $user_id =  $user->uid;
        $song_id = intval($_POST['song_id']);
        
        $playlists = Registry::get('Muzibu')->playlist->getPlaylistsByUser($user_id);
        $song_playlists = Registry::get('Muzibu')->playlist->getUserPlaylistIDsBySong($user_id,$song_id);
        
        $json['playlists'] = $playlists;
        $json['song_playlists'] = $song_playlists;
        $json['status'] = true;
		echo json_encode($json);
  endif;
  
  if ($_POST['process'] == "load_more_playlist"):
        $ipp = 8;
        $count = Registry::get('Muzibu')->playlist->getPlaylistCount();
        $next_page = intval($_POST['next_page']);
        
        $_playlists = Registry::get('Muzibu')->playlist->getPlaylists($next_page,$ipp);
        $playlists = array();
        if($_playlists){
            foreach($_playlists as $playlist){
                $playlist->url = Url::Muzibu("playlist-detail",$playlist->slug);
                $playlist->thumb = SITEURL."/thumbmaker.php?src=".SITEURL."/modules/muzibu/dataimages/".($playlist->thumb != "" ? $playlist->thumb : $playlist->album_thumb)."&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80";
                $playlist->title = $playlist->title_tr;
                $playlists[] = $playlist;
            }
        }
        if($count>$ipp*$next_page){
            $json['more'] = 1;
        }
        else{
            $json['more'] = 0;
        }
        $json['playlists'] = $playlists;
        $json['status'] = true;
		echo json_encode($json);
  endif;
  
  if ($_POST['process'] == "load_more_songs"):
        $ipp = 20;
        $count = Registry::get('Muzibu')->getSongsCount();
        $next_page = intval($_POST['next_page']);
        
        $_songs = Registry::get('Muzibu')->getAllSongs($next_page,$ipp);
        if($user->logged_in):
            $favorites = Registry::get('Muzibu')->getUserFavoritesBySongs($user->uid,$_songs);
        else:
            $favorites = array();
        endif;
        
        
        $songs = array();
        if($_songs){
            $i=1;
            foreach($_songs as $song){
                $song->file_path = $song->file_path ? SITEURL . '/modules/muzibu/datafiles/songs/' . $song->file_path : THEMEURL . '/assets/media/tracks/about-love.mp3';
                $song->thumb = SITEURL."/thumbmaker.php?src=".SITEURL."/modules/muzibu/dataimages/".$song->thumb."&amp;h=410&amp;w=410&amp;s=1&amp;a=c&amp;q=80";
                $song->title = $song->title_tr;
                $song->duration = formatMP3Duration($song->duration);
                $song->song_id = $song->id;
                $song->favorite_status = in_array($song->id,$favorites) ? "true" : "false";
                $song->i = (($next_page-1) * 20) + $i;
                $songs[] = $song;
                $i++;
            }
        }
        if($count>$ipp*$next_page){
            $json['more'] = 1;
        }
        else{
            $json['more'] = 0;
        }
        $json['songs'] = $songs;
        $json['status'] = true;
		echo json_encode($json);
  endif;
  
  if ($_POST['process'] == "add_to_playlist" && $user->logged_in):
        $user_id =  $user->uid;
        $playlist_id = intval($_POST['playlist_id']);
        $playlist_name = $_POST['playlist_name'];
        $song_id = intval($_POST['song_id']);
        $status = $_POST['status'];
        if($status=="true"){
            $sdata = array(
                'playlist_id' => $playlist_id,
                'song_id' => intval($song_id),
                'position' => 0,
                'created' => "NOW()"
            );
            $db->insert("muzibu_playlist_song", $sdata);
            $json['message'] = $playlist_name. " Listesine Eklendi";
            $json['status'] = true;
        }
        else{
            $db->delete("muzibu_playlist_song", "playlist_id = " . $playlist_id." AND song_id = ".$song_id);
            $json['message'] = $playlist_name. " Listesinden Kaldırıldı";
            $json['status'] = true;
        }
	    echo json_encode($json);
  endif;
  
  if ($_POST['process'] == "create_playlist" && $user->logged_in):
        $user_id =  $user->uid;
        $playlist_name = $_POST['playlist_name'];
        $song_id = intval($_POST['song_id']);
        
        $data = array(
            'title_tr' => $playlist_name,
            'slug' => generateUniqueID(),
            'user_id' => $user_id,
            'system' => 0,
            'is_public' => 0,
            'created' => "NOW()",
            'active' => 1
        );
        
        $lastid = $db->insert("muzibu_playlists", $data);
        
         $sdata = array(
            'playlist_id' => $lastid,
            'song_id' => intval($song_id),
            'position' => 0,
            'created' => "NOW()"
        );
        $db->insert("muzibu_playlist_song", $sdata);
        
        $json['playlist_id'] = $lastid;
        $json['message'] = $playlist_name. " Listesine Eklendi";
        $json['status'] = true;
		echo json_encode($json);
  endif;
  
  if (isset($_POST['addtocart'])):
  
      $row = Core::getRowById(Membership::mTable, Filter::$id);
      if ($row):
          $gaterows = Registry::get("Membership")->getGateways(true);

          if ($row->trial && $user->trialUsed()) :
              $json['message'] = Filter::msgSingleAlert(Lang::$word->_MS_TRIAL_USED, false);
              print json_encode($json);
              exit;
          endif;
          if ($row->price == 0) :
              $data = array(
                  'membership_id' => $row->id,
                  'mem_expire' => $user->calculateDays($row->id),
                  'trial_used' => ($row->trial == 1) ? 1 : 0
				  );

              $db->update(Users::uTable, $data, "id=" . $user->uid);
              $json['message'] = Filter::msgSingleOk(Lang::$word->_MS_MEM_ACTIVE_OK . ' ' . $row->{'title' . Lang::$lang}, false);
              Security::writeLog(Lang::$word->_MEMBERSHIP . ' ' . $row->{'title' . Lang::$lang} . Lang::$word->_LG_MEM_ACTIVATED . $user->username, "user", "no", "content");
              print json_encode($json);

          else :
              if ($gaterows):
                  $content = '<div class="content-center">';
				  //$content .= '<div class="tubi buttons">';
                  foreach ($gaterows as $grows) :
                      $form_url = BASEPATH . "gateways/" . $grows->dir . "/form.tpl.php";
                      if ($row->price <> 0 && file_exists($form_url)) :
                          ob_start();
                          include ($form_url);
                          $content .= ob_get_contents();
                          ob_end_clean();
                      endif;
                  endforeach;
                  //$content .= '</div>';
				  $content .= '</div>';
                  $json['message'] = $content;
                  print json_encode($json);
              endif;
          endif;
		  
      else :
		  $json['message'] = Filter::msgSingleError(Lang::$word->_SYSERROR, false);
		  print json_encode($json);
		  exit;
      endif;

  endif;
  
  

 /* == Proccess User == */
  if (isset($_POST['doProfile'])):
      $user->updateProfile();
  endif;
?>