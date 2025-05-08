<?php
  /**
   * Controller
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: controller.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  
  require_once("init.php");
  if (!$user->is_Admin())
    redirect_to("login.php");
	
  $delete = (isset($_POST['delete']))  ? $_POST['delete'] : null;
?>
<?php
  switch ($delete):
  /* == Delete Page == */
  case "deletePage":
      $title = sanitize($_POST['title']);
	  $result = $db->delete(Content::pTable, "id=" . Filter::$id);
	  $db->delete(Content::lTable, "page_id=" . Filter::$id);
	  if($result) :
		  $json['type'] = 'success';
		  $json['title'] = Lang::$word->_SUCCESS;
		  $json['message'] =  Lang::$word->_PAGE . ' /' . $title . '/ ' . Lang::$word->_DELETED;
		  Security::writeLog(Lang::$word->_PAGE . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "content");
	  else :
		  $json['type'] = 'warning';
		  $json['title'] = Lang::$word->_ALERT;
		  $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
	  endif;
	  print json_encode($json);
   break;

  /* == Delete User == */
  case "deleteUser":
	if (Filter::$id == 1):
		$json['type'] = 'error';
		$json['title'] = Lang::$word->_ERROR;
		$json['message'] = Lang::$word->_UR_ADMIN_E;
	else:
		if($avatar = getValueById("avatar", Users::uTable, Filter::$id)):
			unlink(UPLOADS . 'avatars/' . $avatar);
		endif;
		$db->delete(Users::uTable, "id='" . Filter::$id . "'");
		
		$title = sanitize($_POST['title']);
		if($db->affected()) :
			$json['type'] = 'success';
			$json['title'] = Lang::$word->_SUCCESS;
			$json['message'] =  Lang::$word->_USER . ' /' . $title . '/ ' . Lang::$word->_DELETED;
			Security::writeLog(Lang::$word->_USER . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "content");
			else :
			$json['type'] = 'warning';
			$json['title'] = Lang::$word->_ALERT;
			$json['message'] = Lang::$word->_SYSTEM_PROCCESS;
		endif;
	endif;
		print json_encode($json);
  break;

  /* == Delete Plugin == */
  case "deletePlugin":
      $title = sanitize($_POST['title']);
	  $result = $db->delete(Content::plTable, "id=" . Filter::$id);
	  if($result) :
		  $json['type'] = 'success';
		  $json['title'] = Lang::$word->_SUCCESS;
		  $json['message'] =  Lang::$word->_PLUGIN . ' /' . $title . '/ ' . Lang::$word->_DELETED;
		  Security::writeLog(Lang::$word->_PLUGIN . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "plugin");
	  else :
		  $json['type'] = 'warning';
		  $json['title'] = Lang::$word->_ALERT;
		  $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
	  endif;
	  print json_encode($json);
   break;

  /* == Delete Module == */
  case "deleteModule":
      $title = sanitize($_POST['title']);
	  $result = $db->delete(Content::plTable, "id=" . Filter::$id);
	  $data['module_id'] = 0;
	  $data['module_data'] = 0;
	  $db->update(Content::pTable ,$data, "module_id=" . Filter::$id);
	  if($result) :
		  $json['type'] = 'success';
		  $json['title'] = Lang::$word->_SUCCESS;
		  $json['message'] =  Lang::$word->_MODULE . ' /' . $title . '/ ' . Lang::$word->_DELETED;
		  Security::writeLog(Lang::$word->_MODULE . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
	  else :
		  $json['type'] = 'warning';
		  $json['title'] = Lang::$word->_ALERT;
		  $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
	  endif;
	  print json_encode($json);
   break;

  /* == Delete Menu == */
  case "deleteMenu":
      $title = sanitize($_POST['title']);
	  $result = $db->delete(Content::mTable, "id=" . Filter::$id);
	  $db->delete(Content::mTable, "parent_id=" . Filter::$id);
	  if($result) :
		  $json['type'] = 'success';
		  $json['title'] = Lang::$word->_SUCCESS;
		  $json['message'] =  Lang::$word->_MENU . ' /' . $title . '/ ' . Lang::$word->_DELETED;
		  Security::writeLog(Lang::$word->_MENU . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "content");
	  else :
		  $json['type'] = 'warning';
		  $json['title'] = Lang::$word->_ALERT;
		  $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
	  endif;
	  print json_encode($json);
   break;

  /* == Delete Membership == */
  case "deleteMembership":
      $title = sanitize($_POST['title']);
	  $result = $db->delete(Membership::mTable, "id=" . Filter::$id);
	  if($result) :
		  $json['type'] = 'success';
		  $json['title'] = Lang::$word->_SUCCESS;
		  $json['message'] =  Lang::$word->_MEMBERSHIP . ' /' . $title . '/ ' . Lang::$word->_DELETED;
		  Security::writeLog(Lang::$word->_MEMBERSHIP . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "content");
	  else :
		  $json['type'] = 'warning';
		  $json['title'] = Lang::$word->_ALERT;
		  $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
	  endif;
	  print json_encode($json);
   break;

  /* == Delete Transaction == */
  case "deleteTransaction":
      $title = sanitize($_POST['title']);
	  $result = $db->delete(Membership::pTable, "id=" . Filter::$id);
	  if($result) :
		  $json['type'] = 'success';
		  $json['title'] = Lang::$word->_SUCCESS;
		  $json['message'] =  Lang::$word->_TRANSACTION . ' /' . $title . '/ ' . Lang::$word->_DELETED;
		  Security::writeLog(Lang::$word->_TRANSACTION . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "content");
	  else :
		  $json['type'] = 'warning';
		  $json['title'] = Lang::$word->_ALERT;
		  $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
	  endif;
	  print json_encode($json);
   break;

  /* == Delete Logs == */
  case "deleteLogs":
	  $result = $db->query("TRUNCATE TABLE " . Security::lTable);
	  if($result) :
		  $json['type'] = 'success';
		  $json['title'] = Lang::$word->_SUCCESS;
		  $json['message'] =  Lang::$word->_LG_STATS_EMPTY;
		  Security::writeLog(Lang::$word->_LG_STATS_EMPTY, "", "no", "content");
	  else :
		  $json['type'] = 'warning';
		  $json['title'] = Lang::$word->_ALERT;
		  $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
	  endif;
	  print json_encode($json);
   break;

  /* == Delete Backup == */
  case "deleteBackup":
      $title = sanitize($_POST['title']);
	  $action = false;

	  if(file_exists(BASEPATH . 'admin/backups/'.sanitize($_POST['file']))) :
		$action = unlink(BASEPATH . 'admin/backups/'.sanitize($_POST['file']));
	  endif;
				  
	  if($action) :
		  $json['type'] = 'success';
		  $json['title'] = Lang::$word->_SUCCESS;
		  $json['message'] = str_replace("[DBNAME]", $title, Lang::$word->_BK_DELETE_OK);
		  Security::writeLog($json['message'], "", "no", "content");
	  else :
		  $json['type'] = 'warning';
		  $json['title'] = Lang::$word->_ALERT;
		  $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
	  endif;
	  print json_encode($json);
   break;

  /* == Delete language == */
  case "deleteLanguage":
      $title = sanitize($_POST['title']);
	  Content::deleteLanguage();
	  $result = $db->delete(Content::lgTable, "id=" . Filter::$id);
	  
	  if($result) :
		  $json['type'] = 'success';
		  $json['title'] = Lang::$word->_SUCCESS;
		  $json['message'] =  Lang::$word->_LANGUAGE . ' /' . $title . '/ ' . Lang::$word->_DELETED;
		  Security::writeLog(Lang::$word->_LANGUAGE . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "content");
	  else :
		  $json['type'] = 'warning';
		  $json['title'] = Lang::$word->_ALERT;
		  $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
	  endif;
	  print json_encode($json);
   break;

  /* == Delete Custom Field == */
  case "deleteField":
      $title = sanitize($_POST['title']);
	  $result = $db->delete(Content::cfTable, "id=" . Filter::$id);
	  
	  if($result) :
		  $json['type'] = 'success';
		  $json['title'] = Lang::$word->_SUCCESS;
		  $json['message'] =  Lang::$word->_CFL_FIELD . ' /' . $title . '/ ' . Lang::$word->_DELETED;
		  Security::writeLog(Lang::$word->_CFL_FIELD . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "content");
	  else :
		  $json['type'] = 'warning';
		  $json['title'] = Lang::$word->_ALERT;
		  $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
	  endif;
	  print json_encode($json);
   break;
   
  endswitch;
?>
<?php
  if (isset($_GET['contenttype'])):
      $type = sanitize($_GET['contenttype']);
      $html = "";
      switch ($type):
          case "page":
              $pageresult = $db->fetch_all("SELECT id, title" . Lang::$lang . " FROM " . Content::pTable . " WHERE active = 1 ORDER BY title" . Lang::$lang . " ASC");
              if ($pageresult):
                  foreach ($pageresult as $row):
                      $html .= "<option value=\"" . $row->id . "\">" . $row->{'title' . Lang::$lang} . "</option>\n";
                  endforeach;
				  $json['type'] = 'page';
              endif;
              break;

          case "module":
              $artresult = $db->fetch_all("SELECT id, title" . Lang::$lang . " FROM " . Content::mdTable . " WHERE active = 1 AND system = 1 ORDER BY title" . Lang::$lang . " ASC");
              if ($artresult):
                  foreach ($artresult as $row):
                      $html .= "<option value=\"" . $row->id . "\">" . $row->{'title' . Lang::$lang}  . "</option>\n";
                  endforeach;
				  $json['type'] = 'module';
              endif;
              break;
			  
          default:
              $html .= "<input name=\"page_id\" type=\"hidden\" value=\"0\" />";
              $json['type'] = 'web';
              
      endswitch;
	  $json['message'] = $html;
      print json_encode($json);
  endif;
?>
<?php
  /* Proccess Menu */
  if (isset($_POST['processMenu'])) :
  $content->processMenu();
  endif;
  
  /* == Load Menu List == */
  if (isset($_POST['getmenus'])): 
      $content->getSortMenuList();
  endif;
  
  /* == Sort Menu == */
  if (isset($_POST['doMenuSort'])):
      $i = 0;
      foreach ($_POST['list'] as $k => $v):
          $i++;
          $data['parent_id'] = intval($v);
          $data['position'] = intval($i);
          $res = $db->update(Content::mTable, $data, "id=" . (int)$k);
      endforeach;
      print ($res) ? Filter::msgOk(Lang::$word->_MU_SORTED) : Filter::msgOk(Lang::$word->_SYSTEM_PROCCESS);
  endif;
?>
<?php
  /* == Proccess Page == */
  if (isset($_POST['processPage'])):
      $content->processPage();
  endif;

  /* == Proccess Module == */
  if (isset($_POST['processModule'])):
      $content->processModule();
  endif;

  /* == Proccess Plugin == */
  if (isset($_POST['processPlugin'])):
      $content->processPlugin();
  endif;

  /* == Proccess Membership == */
  if (isset($_POST['processMembership'])):
      $member->processMembership();
  endif;

  /* == Proccess Field == */
  if (isset($_POST['processField'])):
	  $content->processField();
  endif;

  /* == Reorder Fields == */
  if (isset($_GET['sortfields'])):
      foreach ($_POST['node'] as $k => $v):
          $p = $k + 1;
          $data['sorting'] = intval($p);
          $db->update(Content::cfTable, $data, "id=" . (int)$v);
      endforeach;
  endif;
  
  /* == Proccess User == */
  if (isset($_POST['processUser'])):
      $user->processUser();
  endif;

  /* == User Search == */
  if (isset($_POST['userSearch'])):
      $string = sanitize($_POST['userSearch'], 15);
      if (strlen($string) > 3):
          $sql = "SELECT id, username, email, created, avatar, CONCAT(fname,' ',lname) as name" 
		  . "\n FROM " . Users::uTable 
		  . "\n WHERE MATCH (username) AGAINST ('" . $db->escape($string) . "*' IN BOOLEAN MODE)" 
		  . "\n ORDER BY username LIMIT 10";

          $html = '';
          if ($result = $db->fetch_all($sql)):
              $html .= '<div id="search-results" class="tubi segment celled list">';
              foreach ($result as $row):
                  $thumb = ($row->avatar) ? '<img src="' . UPLOADURL . 'avatars/' . $row->avatar . '" alt="" class="tubi image avatar"/>' : '<img src="' . UPLOADURL . 'avatars/blank.png" alt="" class="tubi image avatar"/>';
                  $link = 'index.php?do=users&amp;action=edit&amp;id=' . $row->id;
                  $html .= '<div class="item">' . $thumb;
                  $html .= '<div class="items">';
                  $html .= '<div class="header"><a href="' . $link . '">' . $row->name . '</a> <small>(' . $row->username . ')</small></div>';
                  $html .= '<p>' . Filter::dodate('short_date', $row->created) . '</p>';
                  $html .= '<p><a href="index.php?do=newsletter&amp;emailid=' . urlencode($row->email) . '">' . $row->email . '</a></p>';
                  $html .= '</div>';
                  $html .= '</div>';
              endforeach;
              $html .= '</div>';
              print $html;
          endif;
      endif;
  endif;


  /* == Proccess Configuration == */
  if (isset($_POST['processConfig'])):
      $core->processConfig();
  endif;

  /* == Proccess Email Template == */
  if (isset($_POST['processTemplate'])):
      $member->processEmailTemplate();
  endif;

  /* == Load Email Template == */
  if (isset($_POST['loadEmailTemplate'])):
      if ($row = Core::getRowById(Content::eTable, Filter::$id)):
          $json['type'] = 'success';
          $json['id'] = $row->id;
          $json['subject'] = $row->{'subject' . Lang::$lang};
          $json['content'] = cleanOut($row->{'body' . Lang::$lang});
          print json_encode($json);
      endif;
  endif;

  /* == Proccess Newsletter == */
  if (isset($_POST['processNewsletter'])):
      $member->emailUsers();
  endif;

  /* == Proccess Gateway == */
  if (isset($_POST['processGateway'])):
      $member->processGateway();
  endif;

  /* == Add New Language== */
  if (isset($_POST['addLanguage'])):
      $content->addLanguage();
  endif;

  /* == Update Language== */
  if (isset($_POST['updateLanguage'])):
      Content::updateLanguage();
  endif;

  /* == Update Phrase== */
  if (isset($_POST['quickedit'])):
      if ($_POST['type'] == "language"):
          if (empty($_POST['title'])):
              print '--- EMPTY STRING ---';
              exit;
          endif;

          if (file_exists(BASEPATH . Lang::langdir . Core::$language . "/" . $_POST['path'] . ".xml")):
		      $xmlel = simplexml_load_file(BASEPATH . Lang::langdir . Core::$language . "/" . $_POST['path'] . ".xml");
              $node = $xmlel->xpath("/language/phrase[@data = '" . $_POST['key'] . "']");
			  $title = cleanOut($_POST['title']);
			  $title = strip_tags($title);
              $node[0][0] = $title;
              $xmlel->asXML(BASEPATH . Lang::langdir . Core::$language . "/" . $_POST['path'] . ".xml");
          endif;
      endif;
	  
	  print $title;
  endif;
		  
		  
  /* == Load Language File== */
  if (isset($_POST['loadLanguage'])):
      if (file_exists(BASEPATH . Lang::langdir . Core::$language . "/" . $_POST['filename'] . ".xml")):
          $xmlel = simplexml_load_file(BASEPATH . Lang::langdir . Core::$language . "/" . $_POST['filename'] . ".xml");
          $data = new stdClass();
          $i = 1;
          $html = '';
          foreach ($xmlel as $pkey):
              $html .= '<div class="row">';
              $html .= '<div contenteditable="true" data-path="' . $_POST['filename'] . '" data-edit-type="language" data-id="' . $i++ . '" data-key="' . $pkey['data'] . '" class="tubi phrase">' . $pkey . '</div>';
              $html .= '</div>';
          endforeach;
          $json['status'] = 'success';
          $json['message'] = $html;
      else:
          $json['status'] = 'error';
		  $json['title'] = Lang::$word->_ERROR;
          $json['message'] = Lang::$word->_LA_LOADERR;
      endif;
          print json_encode($json);
  endif;
  
  /* == Load Internal Links == */
  if (isset($_GET['linktype']) && $_GET['linktype'] == "internal"):
      $list = array();
      $sql = $db->query("SELECT title" . Lang::$lang . ", slug FROM " . Content::pTable . " ORDER BY title" . Lang::$lang . " ASC");
      while ($row = $db->fetch($sql)):
		  $item = array(
			  'name' => truncate($row->{'title' . Lang::$lang},50), 
			  'url' => Url::Page($row->slug)
		  );
	     $list[] = $item;
      endwhile; 
      echo json_encode($list);
  endif;

  if (isset($_GET['linktype']) && $_GET['linktype'] == "editor"):
      $list = array();
      $sql = $db->query("SELECT title" . Lang::$lang . ", slug FROM " . Content::pTable . " ORDER BY title" . Lang::$lang . " ASC");
      while ($row = $db->fetch($sql)):
		  $item = array(
			  'title' => truncate($row->{'title' . Lang::$lang},50), 
			  'value' => Url::Page($row->slug)
		  );
	     $list[] = $item;
      endwhile; 
      echo json_encode($list);
  endif;
  
  /* == Proccess Theme Switch == */
  if (isset($_POST['themeoption'])):
      print $core->getThemeOptions(sanitize($_POST['themeoption']));
  endif;

  /* == Update Plugin Layout == */
  if (isset($_GET['layout'])):
      $sort = sanitize($_GET['layout']);
      $idata = (isset($_GET['modslug'])) ? 'mod_id' : 'page_id';
      $idata = sanitize($idata);

      @$sorted = str_replace("list-", "", $_POST[$sort]);
      if ($sorted):
          foreach ($sorted as $plug_id):
              list($order, $plug_id) = explode("|", $plug_id);
              $stylename = explode("-", $sort);
              $page_id = $stylename[1];
              //if ($stylename[0] == "default")
              //continue;
              //$db->delete("layout", "plug_id='" . (int)$plug_id . "' AND $idata = '" . (int)$page_id . "'");

              $data = array(
                  'plug_id' => $plug_id,
                  'page_id' => (isset($_GET['pageslug'])) ? $page_id : 0,
                  'mod_id' => (isset($_GET['modslug'])) ? $page_id : 0,
                  'page_slug' => (isset($_GET['pageslug'])) ? sanitize($_GET['pageslug']) : "NULL",
                  'modalias' => (isset($_GET['modslug'])) ? sanitize($_GET['modslug']) : "NULL",
                  'place' => $stylename[0],
                  'position' => $order);

              //if ($stylename[0] != "default") :
              $db->delete(Content::lTable, "plug_id=" . (int)$plug_id . " AND $idata = " . (int)$page_id);
              $db->insert(Content::lTable, $data);
              //endif;
          endforeach;
      endif;
  endif;

  /* == Plugin Spaces == */
  if (isset($_POST['setPluginCols'])):
      $plug_id = Filter::$id;
      $cols = intval($_POST['cols']);
      $type = (sanitize($_POST['type']) == "page_id") ? "page_id" : "mod_id";
      $type_id = intval($_POST['type_id']);
	  
      $data['space'] = $cols;
      $db->update(Content::lTable, $data, "plug_id = $plug_id AND $type = $type_id");
      print $cols;
  endif;

  /* == Remove Plugins == */
  if (isset($_POST['removeLayoutPlugin'])):
      $plug_id = Filter::$id;
      $type = (sanitize($_POST['type']) == "page_id") ? "page_id" : "mod_id";
      $type_id = intval($_POST['type_id']);
	  
      $db->delete(Content::lTable, "plug_id = $plug_id AND $type = $type_id");
  endif;
  
  /* == Load Plugins == */
  if (isset($_POST['loadAvailPlugs'])):
      $pageid = intval($_POST['page_id']);
      $modid = intval($_POST['mod_id']);
	  $pos = sanitize($_POST['position']);
      $pluginrow = $content->getAvailablePlugins($pageid, $modid);
      if (!$pluginrow):
          print Filter::msgSingleInfo(Lang::$word->_LY_NOMODS);
      else:
	      print '<div id="plavailable" style="max-width:600px">';
          print '<div class="tubi-grid">';
          print '<div class="three columns small-horizontal-gutters tubi sortable list">';
          foreach ($pluginrow as $mrow):
              print '<div class="row"><a data-id="' . $mrow->id . '" data-position="' . $pos . '" class="list">' . $mrow->{'title' . Lang::$lang} . '</a></div>';
          endforeach;
          print '<div>';
          print '<div>';
		  print '<div>';
      endif;
  endif;
?>
<?php
  /* == Latest Sales Stats == */
  if (isset($_GET['getTransactionStats'])):
	
  $range = (isset($_GET['timerange'])) ? sanitize($_GET['timerange']) : 'year';	  
  $data = array();
  $data['order'] = array();
  $data['xaxis'] = array();
  $data['sum']['label'] = Lang::$word->_TR_TOTREV;
  $data['order']['label'] = Lang::$word->_TR_TOTSALES;
  
  switch ($range) {
	  case 'day':
	  $date = date('Y-m-d');
		  for ($i = 0; $i < 24; $i++) {
			  $query = $db->first("SELECT COUNT(*) AS total, SUM(rate_amount) as sum FROM " . Membership::pTable
			  . "\n WHERE DATE(created) = '" . $db->escape($date) . "'" 
			  . "\n AND HOUR(created) = '" . (int)$i . "'" 
			  . "\n AND status = 1"
			  . "\n GROUP BY HOUR(created) ORDER BY date ASC");
  
			  ($query) ? $data['order']['data'][] = array($i, $query->total) : $data['order']['data'][] = array($i, 0);
			  ($query) ? $data['sum']['data'][] = array($i, (int)$query->sum) : $data['sum']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('H', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
		  }
		  break;
	  case 'week':
		  $date_start = strtotime('-' . date('w') . ' days');
  
		  for ($i = 0; $i < 7; $i++) {
			  $date = date('Y-m-d', $date_start + ($i * 86400));
			  $query = $db->first("SELECT COUNT(*) AS total, SUM(rate_amount) as sum FROM " . Membership::pTable
			  . "\n WHERE DATE(created) = '" . $db->escape($date) . "'"
			  . "\n AND status = 1"
			  . "\n GROUP BY DATE(created)");
  
			  ($query) ? $data['order']['data'][] = array($i, $query->total) : $data['order']['data'][] = array($i, 0);
			  ($query) ? $data['sum']['data'][] = array($i, (int)$query->sum) : $data['sum']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('D', strtotime($date)));
		  }
  
		  break;
	  default:
	  case 'month':
		  for ($i = 1; $i <= date('t'); $i++) {
			  $date = date('Y') . '-' . date('m') . '-' . $i;
			  $query = $db->first("SELECT COUNT(*) AS total, SUM(rate_amount) as sum FROM " . Membership::pTable
			  . "\n WHERE (DATE(created) = '" . $db->escape($date) . "')"
			  . "\n AND status = 1"
			  . "\n GROUP BY DAY(created)");
  
			  ($query) ? $data['order']['data'][] = array($i, $query->total) : $data['order']['data'][] = array($i, 0);
			  ($query) ? $data['sum']['data'][] = array($i, (int)$query->sum) : $data['sum']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('j', strtotime($date)));
		  }
		  break;
	  case 'year':
		  for ($i = 1; $i <= 12; $i++) {
			  $query = $db->first("SELECT COUNT(*) AS total, SUM(rate_amount) as sum FROM " . Membership::pTable
			  . "\n WHERE YEAR(created) = '" . date('Y') . "'"
			  . "\n AND MONTH(created) = '" . $i . "'"
			  . "\n AND status = 1"
			  . "\n GROUP BY MONTH(created)");
  
			  ($query) ? $data['order']['data'][] = array($i, $query->total) : $data['order']['data'][] = array($i, 0);
			  ($query) ? $data['sum']['data'][] = array($i, (int)$query->sum) : $data['sum']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
		  }
		  break;
  }

   print json_encode($data);
   exit();
  endif;
  
  
  /* Export Transactions */
  if (isset($_GET['exportTransactions'])) {
	  $sql = "SELECT p.*, p.id as id, u.username, m.title" . Lang::$lang . " as title,"
	  . "\n DATE_FORMAT(p.created, '%d %b %Y') as cdate"
	  . "\n FROM payments as p"
	  . "\n LEFT JOIN users as u ON u.id = p.user_id" 
	  . "\n LEFT JOIN memberships as m ON m.id = p.membership_id";
      $result = $db->fetch_all($sql);
      
      $type = "vnd.ms-excel";
	  $date = date('m-d-Y H:i');
	  $title = "Exported from the " . $core->site_name . " on $date";

      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
	  header("Content-Type: application/$type");
      header("Content-Disposition: attachment;filename=temp_" . time() . ".xls");
      header("Content-Transfer-Encoding: binary ");
      
	  print '
	  <table width="100%" cellpadding="1" cellspacing="2" border="1">
	  <caption>' . $title . '</caption>
		<tr>
		  <td>TXN_ID</td>
		  <td>' .Lang::$word-> _TR_MEMNAME . '</td>
		  <td>' . Lang::$word->_TR_USERNAME . '</td>
		  <td>' . Lang::$word->_TR_AMOUNT . '</td>
		  <td>' . Lang::$word->_TR_PAYDATE . '</td>
		  <td>' . Lang::$word->_TR_PROCESSOR . '</td>
		  <td>IP</td>
		</tr>';
		foreach ($result as $v) {
			print '<tr>
			  <td>'.$v->txn_id.'</td>
			  <td>'.$v->title.'</td>
			  <td>'.$v->username.'</td>
			  <td>'.$v->rate_amount.'</td>
			  <td>'.$v->cdate.'</td>
			  <td>'.$v->pp.'</td>
			  <td>'.$v->ip.'</td>
			</tr>';
		}				

	  print '</table>';
	  exit();
  }
  
  /* Transaction Search */
  if (isset($_POST['transSearch']))
      : $string = sanitize($_POST['transSearch'],15);
  
  if (strlen($string) > 3):
       $sql = "SELECT p.*, p.id as id, p.created as transdate, u.username, u.avatar, u.id as uid, m.id as mid, m.title" . lang::$lang . " as title" 
	  . "\n FROM " . Membership::pTable . " as p" 
	  . "\n LEFT JOIN " . Users::uTable . " as u ON u.id = p.user_id" 
	  . "\n LEFT JOIN " . Membership::mTable . " as m ON m.id = p.membership_id" 
	  . "\n WHERE MATCH (username, m.title" . lang::$lang . ", txn_id) AGAINST ('" . $db->escape($string) . "*' IN BOOLEAN MODE)"
	  . "\n ORDER BY p.created DESC LIMIT 10";
		  
          $html = '';
          if ($result = $db->fetch_all($sql)):
              $html .= '<div id="search-results" class="tubi segment celled list">';
              foreach ($result as $row):
                  $thumb = ($row->avatar) ? '<img src="' . UPLOADURL . 'avatars/' . $row->avatar . '" alt="" class="tubi image avatar"/>' : '<img src="' . UPLOADURL . 'avatars/blank.png" alt="" class="tubi image avatar"/>';
                  $link = 'index.php?do=users&amp;action=edit&amp;id=' . $row->uid;
				  $html .= '<div class="item">' . $thumb;
				  $html .= '<div class="items">';
				  $html .= '<div class="header"><a href="' . $link . '">' . $row->username . '</a> <small>(' . $row->txn_id . ')</small></div>';
				  $html .= '<p>' . Filter::dodate('short_date', $row->transdate) . '</p>';
				  $html .= '<p>' . $row->title . '</p>';
				  $html .= '</div>';
				  $html .= '</div>';
              endforeach;
              $html .= '</div>';
              print $html;
          endif;
      endif;
  endif;
?>
<?php
  /* == Site Maintenance == */
  if (isset($_POST['processMaintenance'])):
	switch ($_POST['do']):
		case "inactive":
				$now = date('Y-m-d H:i:s');
				$diff = intval($_POST['days']);
				$expire = date("Y-m-d H:i:s", strtotime($now . -$diff . " days"));
				$db->delete(Users::uTable, "lastlogin < '" . $expire . "' AND active = 'y' AND userlevel !=9");
				if ($db->affected()):
					$json['type'] = 'success';
					$json['message'] = Filter::msgOk(str_replace("[NUMBER]", $db->affected(), Lang::$word->_SM_INACTIVEOK), false);
				else:
					$json['type'] = 'success';
					$json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
				endif;
			print json_encode($json);	
		 break;
	
	  case "pending":
		$db->delete(Users::uTable, "active = 't'");
		if ($db->affected()):
			$json['type'] = 'success';
			$json['message'] = Filter::msgOk(str_replace("[NUMBER]", $db->affected(), Lang::$word->_SM_PENDINGOK), false);
		else:
			$json['type'] = 'success';
			$json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
		endif;
		print json_encode($json);
	   break;
	
	  case "banned":
		$db->delete(Users::uTable, "active = 'b'");
		if ($db->affected()):
			$json['type'] = 'success';
			$json['message'] = Filter::msgOk(str_replace("[NUMBER]", $db->affected(), Lang::$word->_SM_BANNEDOK), false);
		else:
			$json['type'] = 'success';
			$json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
		endif;
		print json_encode($json);
	   break;
	   
	  case "sitemap":
		$content->writeSiteMap();
	   break;
  
	endswitch;

  endif;
?>
<?php
  /* == Restore SQL Backup == */
  if (isset($_POST['restoreBackup'])):
	  require_once(BASEPATH . "lib/class_dbtools.php");
	  Registry::set('dbTools',new dbTools());
	  $tools = Registry::get("dbTools");
	  
	  if($tools->doRestore($_POST['restoreBackup'])) :
		  $json['type'] = 'success';
		  $json['title'] = Lang::$word->_SUCCESS;
		  $json['message'] = str_replace("[DBFILE]", $_POST['restoreBackup'], Lang::$word->_BK_RESTORE_OK);
		  Security::writeLog($json['message'], "", "no", "content");
		  else :
		  $json['type'] = 'warning';
		  $json['title'] = Lang::$word->_ALERT;
		  $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
	  endif;
	  print json_encode($json);
  endif;
?>
<?php
  /* == Main File Manager == */
  if (isset($_POST['doFM']) and isset($_POST['fmact'])):
	require_once(BASEPATH . "lib/class_fm.php");
	Registry::set('FileManager',new FileManager());
	
	switch($_POST['fmact']): case "deleteFile": 
	   FileManager::deleteFile();
	break;

	case "deleteDir": 
       FileManager::deleteDir();
	break;

	case "newFile": 
       FileManager::makeFile($_POST['filename']);
	break;

	case "newDir": 
       FileManager::makeDirectory($_POST['dirname']);
	break;
	
	case "doUpload": 
       FileManager::doUpload('mainfile');
	break;
	
	endswitch;
  endif;

  /* == Modal File Manager == */
  if (isset($_POST['doFiles']) and isset($_POST['mfmact'])):
	require_once(BASEPATH . "lib/class_fm.php");
	Registry::set('FileManager',new FileManager());
	
	switch($_POST['mfmact']): case "listFolders": 
	   FileManager::getDirectories();
	break;
	
	case "getFiles": 
	  FileManager::getFiles();
	break;

	case "doUpload": 
       FileManager::doUpload('mainfile');
	break;
	
	endswitch;
  endif;
  
  /* == File Picker == */
  if (isset($_POST['pickFile'])):
      require_once (BASEPATH . "lib/class_fm.php");
      Registry::set('FileManager', new FileManager());
      if ($_POST['ext'] == "images"):
          $ext = array("jpg","png","gif");
      elseif ($_POST['ext'] == "audio"):
          $ext = array("mp3");
      elseif ($_POST['ext'] == "archive"):
          $ext = array("zip","rar");
      else:
          $ext = false;
      endif;
      print FileManager::getPickerFiles(UPLOADS, $ext);
  endif;

  /* == Get Membership List == */
  if (isset($_POST['membershiplist'])) :
      if($_POST['membershiplist'] == "Membership"):
	  if(isset($_POST['mid']) and $_POST['mid'] < 0):
	  $memid = false;
	  else:
	  $memid = getValueById("membership_id", Content::pTable, intval($_POST['mid']));
	  endif;
	  print $member->getMembershipList($memid);
	  endif; 
  endif;

  /* == Get Module List == */
  if (isset($_POST['modulelist'])):
      $alias = getValueById('modalias', 'modules', intval($_POST['modulelist']));
      $module_data = intval($_POST['module_data']);
      if (file_exists(MODPATH . $alias . '/config.php'))
          include (MODPATH . $alias . '/config.php');
  endif;

  /* == Add New Note == */
  if (isset($_POST['newNote'])):
      if (!empty($_POST['note'])):

          $data = array(
              'username' => $user->username,
              'body_en' => sanitize($_POST['note']),
              'color' => sanitize($_POST['color']),
              'created' => "NOW()",
              );
          $lastid = $db->insert(Core::nTable, $data);

          if ($lastid):
              $html = '
			  <div class="tubi note ' . sanitize($_POST['color']) . '">
				<div class="aside">' . strtolower(Lang::$word->_CREATED) . '<br>
				  ' . timesince(time()) . '</div>
				<a data-id="' . $lastid . '" class="note-close"><i class="close icon"></i></a>
				<div class="header">' . sanitize($_POST['note']) . '</div>
				-<small>' . Lang::$word->_MN_NOTES_CREATED . ' ' . $user->username . '</small></div>';
				
              $json['type'] = 'success';
              $json['title'] = Lang::$word->_SUCCESS;
              $json['message'] = Lang::$word->_MN_NOTES_ADDED;
              $json['html'] = $html;
              print json_encode($json);
          endif;

      endif;
  endif;

  /* == Delete Note == */
  if (isset($_POST['deleteNote']) and Filter::$id):
      $db->delete(Core::nTable, "id=" . Filter::$id);
  endif;

  /* == Empty Stats == */
  if (isset($_POST['deleteStats'])):
      $db->query("TRUNCATE TABLE " . Core::stTable);
  endif;
  
  /* == Latest Visitor Stats == */
  if (isset($_GET['getVisitsStats'])):
      if (intval($_GET['getVisitsStats']) == 0 || empty($_GET['getVisitsStats'])):
          die();
      endif;

      $range = (isset($_GET['timerange'])) ? sanitize($_GET['timerange']) : 'year';
      $data = array();
      $data['hits'] = array();
      $data['xaxis'] = array();
      $data['hits']['label'] = Lang::$word->_MN_TOTAL_H;
      $data['visits']['label'] = Lang::$word->_MN_UNIQUE_V;

      switch ($range)
      {
          case 'day':
		      $date = date('Y-m-d');
			  
              for ($i = 0; $i < 24; $i++)
              {
                  $row = $db->first("SELECT SUM(pageviews) AS total,"
				  . "\n SUM(uniquevisitors) as visits"
				  . "\n FROM " . Core::stTable
				  . "\n WHERE DATE(day)='" . $db->escape($date) . "'" 
				  . "\n AND HOUR(day) = '" . (int)$i . "'" 
				  . "\n GROUP BY HOUR(day) ORDER BY day ASC");

                  $data['hits']['data'][] = ($row) ? array($i, (int)$row->total) : array($i, 0);
                  $data['visits']['data'][] = ($row) ? array($i, (int)$row->visits) : array($i, 0);
                  $data['xaxis'][] = array($i, date('H', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
              }
              break;
          case 'week':
              $date_start = strtotime('-' . date('w') . ' days');

              for ($i = 0; $i < 7; $i++)
              {
                  $date = date('Y-m-d', $date_start + ($i * 86400));
                  $row = $db->first("SELECT SUM(pageviews) AS total," 
				  . "\n SUM(uniquevisitors) as visits"
				  . "\n FROM " . Core::stTable
				  . "\n WHERE DATE(day) = '" . $db->escape($date) . "'" 
				  . "\n GROUP BY DATE(day)");

                  $data['hits']['data'][] = ($row) ? array($i, (int)$row->total) : array($i, 0);
                  $data['visits']['data'][] = ($row) ? array($i, (int)$row->visits) : array($i, 0);
                  $data['xaxis'][] = array($i, date('D', strtotime($date)));
              }

              break;
          default:
          case 'month':
              for ($i = 1; $i <= date('t'); $i++)
              {
                  $date = date('Y') . '-' . date('m') . '-' . $i;
                  $row = $db->first("SELECT SUM(pageviews) AS total,"
				  . "\n SUM(uniquevisitors) as visits"
				  . "\n FROM " . Core::stTable
				  . "\n WHERE (DATE(day) = '" . $db->escape($date) . "')" 
				  . "\n GROUP BY DAY(day)");

                  $data['hits']['data'][] = ($row) ? array($i, (int)$row->total) : array($i, 0);
                  $data['visits']['data'][] = ($row) ? array($i, (int)$row->visits) : array($i, 0);
                  $data['xaxis'][] = array($i, date('j', strtotime($date)));
              }
              break;
          case 'year':
              for ($i = 1; $i <= 12; $i++)
              {
                  $row = $db->first("SELECT SUM(pageviews) AS total,"
				  . "\n SUM(uniquevisitors) as visits"
				  . "\n FROM " . Core::stTable
				  . "\n WHERE YEAR(day) = '" . date('Y') . "'" 
				  . "\n AND MONTH(day) = '" . $i . "'" 
				  . "\n GROUP BY MONTH(day)");

                  $data['hits']['data'][] = ($row) ? array($i, (int)$row->total) : array($i, 0);
                  $data['visits']['data'][] = ($row) ? array($i, (int)$row->visits) : array($i, 0);
                  $data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
              }
              break;
      }

      print json_encode($data);
  endif;