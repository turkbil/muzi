<?php
  /**
   * Controller
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: controller.php, v4.00 2014-05-24 12:12:12 Nurullah Okatan
   */
  define("_VALID_PHP", true);

  require_once ("../../init.php");
  if (!$user->is_Admin())
      redirect_to("../../login.php");

  require_once ("admin_class.php");
  Registry::set('slideCMS', new slideCMS());
?>
<?php
  /* == Edit Slider == */
  if (isset($_POST['editSlider'])):
       Registry::get("slideCMS")->editSlider();
  endif;

  /* == Add Slider == */
  if (isset($_POST['addSlider'])):
       Registry::get("slideCMS")->addSlider();
  endif;
  
  /* == Rename Media == */
  if (isset($_POST['quickedit'])):
      if ($_POST['type'] == "cslidecms"):
          if (empty($_POST['title'])):
              print '--- EMPTY STRING ---';
              exit;
          endif;

		  $title = cleanOut($_POST['title']);
		  $title = strip_tags($title);
          $data['caption' . Lang::$lang] = sanitize($title);
		  $db->update(slideCMS::dTable, $data, "id=" . Filter::$id);
      endif;
	  
	  print $title;
  endif;

  /* == Delete Images == */
  if (isset($_POST['deleteImage'])):
      $title = sanitize($_POST['title']);
	  if($_POST['dtype'] == "img"):
		  if ($image = getValueById("data", slideCMS::dTable, Filter::$id)):
			  $path = BASEPATH . 'plugins/' .sanitize($_POST['curDir']) . '/slides/' . $image;
			  unlink($path);
		  endif;
	  endif;

      $result = $db->delete(slideCMS::dTable, "id=" . Filter::$id);
      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_IMAGE . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_IMAGE . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
   print json_encode($json);
  endif;
  

  /* == Process Video == */
  if (isset($_POST['doVids'])):
      Registry::get("slideCMS")->processVideo();
  endif;

  /* == Upload Images == */
  if (isset($_POST['doFiles'])):
      slideCMS::doUpload('mainfile');
  endif;
  
  /* == Delete Master Slider == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteSlider"):
      $title = sanitize($_POST['title']);
	  
      if ($row = Core::getRowById(slideCMS::mTable, Filter::$id)):
          $pluginid = getValue("id", "plugins", "plugalias='" . $row->plug_name . "'");
		  $dirname = BASEPATH . 'plugins/' . $row->plug_name;
		  
		  delete_directory($dirname);
          $db->delete(Content::plTable, "id=" . $pluginid);
          $db->delete(Content::lTable, "plug_id=" . $pluginid);
      endif;
	  
      $db->delete(slideCMS::dTable, "slider_id=" . Filter::$id);
	  $result = $db->delete(slideCMS::mTable, "id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_SLC_SLIDER . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_MOD_SLC_SLIDER . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;
?>