<?php
  /**
   * Controller
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: controller.php, v2.00 2011-09-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  
  require_once("../../init.php");
  
  if (!$user->is_Admin())
      redirect_to("../../login.php");

  require_once ("admin_class.php");
  Registry::set('Blog', new Blog());
?>
<?php
  /* == Proccess Configuration == */
  if (isset($_POST['processConfig'])):
      Registry::get("Blog")->processConfig();
  endif;

  /* == Proccess Article == */
  if (isset($_POST['processArticle'])):
      Registry::get("Blog")->processArticle();
  endif;

  /* == Delete Article == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteArticle"):
      $title = sanitize($_POST['title']);
      if ($thumb = getValueById("thumb", Blog::mTable, Filter::$id)):
          unlink(BASEPATH . Blog::imagepath . $thumb);
      endif;
      if ($file = getValueById("filename", Blog::mTable, Filter::$id)):
		  unlink(BASEPATH . Blog::filepath . $file);
      endif;
	  $db->delete(Blog::cmTable, "artid=" . Filter::$id);
	  $db->delete(Blog::tTable, "aid=" . Filter::$id);
      $result = $db->delete(Blog::mTable, "id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_AM_ARTICLE . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_MOD_AM_ARTICLE . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;

  /* == Load Category List == */
  if (isset($_POST['getcats'])):
      Registry::get("Blog")->getSortCatList();
  endif;

  /* == Sort Categories == */
  if (isset($_POST['doCatSort'])):
      $i = 0;
      foreach ($_POST['list'] as $k => $v):
          $i++;
          $data['parent_id'] = intval($v);
          $data['position'] = intval($i);
          $res = $db->update(Blog::ctTable, $data, "id='" . (int)$k . "'");
      endforeach;
      print ($res) ? Filter::msgOk(Lang::$word->_MOD_AM_SUPDATED) : Filter::msgOk(Lang::$word->_SYSTEM_PROCCESS);
  endif;

  /* == Delete Category == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteCategory"):
      $title = sanitize($_POST['title']);

      $result = $db->delete(Blog::ctTable, "id=" . Filter::$id);
	  $db->delete(Blog::ctTable, "parent_id=" . Filter::$id);
	  $db->delete(Blog::rTable, "cid=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_AM_CATEGORY . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_MOD_AM_CATEGORY . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;

  /* == Proccess Category == */
  if (isset($_POST['processCategory'])): 
	  Registry::get("Blog")->processCategory();
  endif;
?>
<?php
  /* == Load Comment == */
  if (isset($_POST['loadComment'])):
      $row = Core::getRowById(Blog::cmTable, Filter::$id);
      if ($row):
          $html =  '<div class="tubi small form" style="width:400px">';
          $html .= '<div class="field"><textarea name="body" class="altpost" id="bodyid">' . $row->body . '</textarea></div>';
          $html .= '<p class="tubi info">' . $row->www . '</p>';
          $html .= '<p class="tubi info">IP: ' . $row->ip . '</p>';
          $html .= '</div>';
          print $html;
      endif;
  endif;
  
  /* == Update Comment == */
  if (isset($_POST['processComment'])):
      $data['body'] = cleanOut($_POST['content']);
      $result = $db->update(Blog::cmTable, $data, "id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_AM_COMUPDATED;
          Security::writeLog(Lang::$word->_MOD_AM_COMUPDATED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;

  /* == Comments Actions == */
  if (isset($_POST['comproccess'])):
      $action = '';
      if (empty($_POST['comid'])):
          $json['type'] = 'warning';
          $json['message'] = Filter::msgAlert(Lang::$word->_MOD_AM_NA, false);
      endif;

      if (!empty($_POST['comid'])):
          foreach ($_POST['comid'] as $val):
              $id = intval($val);

              if (isset($_POST['action']) && $_POST['action'] == "disapprove"):
                  $data['active'] = 0;
                  $action = Lang::$word->_MOD_AM_DISAPPROVED;
              elseif (isset($_POST['action']) && $_POST['action'] == "approve"):
                  $data['active'] = 1;
                  $action = Lang::$word->_MOD_AM_APPROVED;
              endif;

              if (isset($_POST['action']) && $_POST['action'] == "delete"):
                  $db->delete(Blog::cmTable, "id=" . $id);
                  $action = Lang::$word->_MOD_AM_DELETED;
              else:
                  $db->update(Blog::cmTable, $data, "id=" . $id);
              endif;
          endforeach;

		  if ($db->affected()):
			  $json['type'] = 'success';
			  $json['message'] = Filter::msgOk($action, false);
			  Security::writeLog($action, "", "no", "module");
		  else:
			  $json['type'] = 'warning';
			  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
		  endif;

      endif;
	  print json_encode($json);
  endif;
?> 