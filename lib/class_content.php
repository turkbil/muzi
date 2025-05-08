<?php
  /**
   * Content Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: class_content.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Content
  {
      
	  public $page_id = null;
	  public $module_id = null;
	  public $modalias = null;
	  public $module_name = null;
	  public $module_data = array();
	  
	  public $homeid = null;
	  public $theme = null;
	  public $is_homemod = null;
	  private $menutree = array();
	  private $menulist = array();
	  private $pluginassets = array();
	  
      public $slug = null;
      public $homeslug = null;
	  public $_url;
	  private static $db;
	  
	  const mTable = "menus";
	  const pTable = "pages";
	  const lTable = "layout";
	  const lgTable = "language";
	  const plTable = "plugins";
	  const mdTable = "modules";
	  const cfTable = "custom_fields";
	  const eTable = "email_templates";

      /**
       * Content::__construct()
       * 
       * @param bool $extra
       * @return
       */
	  public function __construct($extra = true)
	  {
		  $this->_getUrl();
		  self::$db = Registry::get("Database");
	
		  if ($extra) {
			  $this->menutree = $this->getMenuTree();
		  } else {
			  $this->getModAlias();
			  ($this->modalias) ? $this->moduledata = $this->getModuleMetaData() : null;
			  $this->menutree = null;
		  }
	
	  }

      /**
       * Content::_getUrl()
       *
       * @return
       */
	  protected function _getUrl()
	  {
		  $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : null;
		  $url = sanitize($url);
		  $this->_url = explode('/', $url);
	  }

	  /**
	   * Content::getModAlias()
	   * 
	   * @return
	   */
	  private function getModAlias()
	  {
		  if (isset($this->_url[0]) and array_key_exists($this->_url[0], Url::$data['moddir'])) {
			  $this->modalias = Url::$data['moddir'][$this->_url[0]];
			  return self::$db->escape($this->modalias);
		  }
	  }


      /**
       * Content::renderPage()
       * 
       * @return
       */
	  public function renderPage($home = false)
	  {
		  $where = ($home) ? "WHERE home_page = 1" : "WHERE slug ='" . $this->_url[1] . "'";
	
		  $row = self::$db->first("SELECT * FROM " . self::pTable . " $where");
		  if ($row) {
			  $this->title = $row->{'title' . Lang::$lang};
			  $this->caption = $row->{'caption' . Lang::$lang};
			  $this->slug = $row->slug;
			  $this->contact_form = $row->contact_form;
			  $this->membership_id = $row->membership_id;
			  $this->module_id = $row->module_id;
			  $this->module_data = $row->module_data;
			  $this->module_name = $row->module_name;
			  $this->access = $row->access;
			  $this->theme = $row->theme;
			  $this->custom_bg = $row->custom_bg;
			  $this->body = $row->{'body' . Lang::$lang};
			  $this->jscode = $row->jscode;
			  $this->keywords = $row->{'keywords' . Lang::$lang};
			  $this->description = $row->{'description' . Lang::$lang};
			  $this->created = $row->created;
			  $this->active = $row->active;
			  $this->page_id = $row->id;
			  ($home) ? $this->homeid = $row->id : null;
			  
			  $this->pluginassets = $this->getContentPluginAssets($row->{'body' . Lang::$lang});
	
			  return $row;
		  } else {
			  return 0;
		  }
	  }

	  /**
	   * Content::displayModule()
	   * 
	   * @return
	   */
	  public function displayModule()
	  {
		  
		   if (file_exists(MODDIR . $this->moduledata['modalias'].'/main.php')) {
			   require(MODDIR . $this->moduledata['modalias'].'/main.php');  
		  } else {
			  redirect_to(SITEURL);
		  }
	  }

      /**
       * Content::getContentPluginAssets()
       * 
	   * @param mixed $string
       * @return
       */
      private function getContentPluginAssets($string)
      {
		  $pattern = "/%%(.*?)%%/";
		  preg_match_all($pattern, $string, $matches);
		  
          return ($matches[1]) ? $matches[1] : 0;
      }
	  
      /**
       * Content::getContentPlugins()
       * 
	   * @param mixed $body
       * @return
       */
	  public static function getContentPlugins($body)
	  {
		  $string = $body;
		  $pattern = "/%%(.*?)%%/";
		  preg_match_all($pattern, $string, $matches);
	
		  if ($matches[1]) {
			  foreach ($matches[1] as $k => $prow) {
				  if (file_exists(PLUGPATHF . $prow . "/" . CTHEME . "/main.php")) {
					  ob_start();
					  include (PLUGPATHF . $prow . "/" . CTHEME . "/main.php");
					  $contents = ob_get_contents();
					  ob_end_clean();
					  $string = str_replace($matches[0][$k], $contents, $string);
				  } else {
					  if (file_exists(PLUGPATHF . $prow . "/main.php")) {
						  ob_start();
						  include (PLUGPATHF . $prow . "/main.php");
						  $contents = ob_get_contents();
						  ob_end_clean();
						  $string = str_replace($matches[0][$k], $contents, $string);
					  }
				  }
			  }
		  }
	
		  return cleanOut($string);
	  }

      /**
       * Content::getEditorPlugins()
       * 
       * @return
       */
	  public static function getEditorPlugins()
	  {
	
		  $sql = "SELECT * FROM plugins WHERE cplugin = 1 ORDER BY title" . Lang::$lang . " ASC";
		  $plugdata = self::$db->fetch_all($sql);
	
		  if ($plugdata) {
			  if (Registry::get("Core")->editor == 1) {
				  $val = '';
				  foreach ($plugdata as $row) {
					  if (strlen($val) > 0) {
						  $val .= ",";
					  }
					  $val .= '"' . $row->{'title' . Lang::$lang} . '":["<div>%%' . $row->plugalias . '%%</div>","' . cleanOut($row->{'title' . Lang::$lang}) . '"]' . "\n";
				  }
				  return $val;
			  } else {
				  $val = '';
				  foreach ($plugdata as $row) {
					  if (strlen($val) > 0) {
						  $val .= ",";
					  }
					  $val .= "{text: \"" . cleanOut($row->{'title' . Lang::$lang}) . "\", value: \"<div>%%" . $row->plugalias . "%%</div>\"}" . "\n";
				  }
				  return $val;
			  }
		  } else
			  return '"-/-":["--- :: --- :: ---","&nbsp;"]';
	  }
	  
	  /**
	   * Content::getBreadcrumbs()
	   * 
	   * @return
	   */
	  public function getBreadcrumbs()
	  {
          
		  $crumbs = BASEPATH . 'admin/modules/'.$this->modalias.'/crumbs.php';
		  if (file_exists($crumbs) and $this->moduledata->system) {
			 include($crumbs);  
		  }
			 
		  $pageid = ($this->slug) ? $this->title : "";
		  $data = ($this->modalias and $this->moduledata->system) ? $nav : $pageid;

		  return $data;
	  }

	  /**
	   * Content::getAccess()
	   * 
	   * @return
	   */
	  public function getAccess($showMsg = true)
	  {
		  $m_arr = explode(",", $this->membership_id);
		  reset($m_arr);
	
		  switch ($this->access) {
			  case "Registered":
				  if (!Registry::get("Users")->logged_in) {
					  $showMsg ? Filter::msgSingleError(Lang::$word->_UA_ACC_ERR1) : null;
					  return false;
				  } else
					  return true;
				  break;
	
			  case "Membership":
				  if (Registry::get("Users")->logged_in and Registry::get("Users")->validateMembership() and in_array(Registry::get("Users")->membership_id, $m_arr)) {
					  return true;
				  } else {
					  if (Registry::get("Users")->logged_in and Registry::get("Users")->memused) {
						  $showMsg ? Filter::msgSingleError(Lang::$word->_UA_ACC_ERR3 . $this->listMemberships($this->membership_id)) : null;
					  } else {
						  $showMsg ? Filter::msgSingleError(Lang::$word->_UA_ACC_ERR2 . $this->listMemberships($this->membership_id)) : null;
					  }
	
					  return false;
				  }
				  break;
	
			  case "Public":
				  return true;
				  break;
	
			  default:
				  return true;
				  break;
		  }
	  }

      /**
       * Content::listMemberships()
       * 
       * @param mixed $memid
       * @return
       */
	  private function listMemberships($memid)
	  {
	
		  $data = self::$db->fetch_all("SELECT title" . Lang::$lang . " as mtitle FROM " . Membership::mTable . " WHERE id IN(" . $memid . ")");
		  if ($data) {
			  $display = Lang::$word->_UA_ACC_MEMBREQ;
			  $display .= '<ul class="error">';
			  foreach ($data as $row) {
				  $display .= '<li>' . $row->mtitle . '</li>';
			  }
			  $display .= '</ul>';
			  return $display;
		  }
	
	  }
	  
	  /**
	   * Content::getPages()
	   * 
	   * @return
	   */
	  public function getPages($paginate = false)
	  {

		  $counter = countEntries(self::pTable);
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
		  
		  $limit = ($paginate) ? $pager->limit : null;
		  $where = (Registry::get("Users")->userlevel == 8) ? "AND is_admin = 1" : null;
		  
		  $sql = "SELECT * FROM " . self::pTable
		  . "\n WHERE main = 0 $where ORDER BY title" . Lang::$lang . $limit;
          $row = self::$db->fetch_all($sql);
          
		  return ($row) ? $row : 0;
	  }
		  

	  /**
	   * Content::getPagesMain()
	   * 
	   * @return
	   */
	  public function getPagesMain($paginate = false)
	  {

		  $counter = countEntries(self::pTable);
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
		  
		  $limit = ($paginate) ? $pager->limit : null;
		  $where = (Registry::get("Users")->userlevel == 8) ? "AND is_admin = 1" : null;
		  
		  $sql = "SELECT * FROM " . self::pTable
		  . "\n WHERE main = 1 $where  ORDER BY title" . Lang::$lang . $limit;
          $row = self::$db->fetch_all($sql);
          
		  return ($row) ? $row : 0;
	  }
		  
      /**
       * Content::getModuleList()
       * 
       * @param bool $sel
       * @return
       */
      public function getModuleList($sel = false)
	  {
		  
		  $sql = "SELECT id, modalias, title" . Lang::$lang . " FROM " . self::mdTable
		  . "\n WHERE active = 1 AND hasconfig = 1 AND `system` = 0 ORDER BY title" . Lang::$lang;
		  $sqldata = self::$db->fetch_all($sql);
		  
		  $data = '';
		  $data .= "<option value=\"0\">" . Lang::$word->_PG_SEL_MODULE1 . "</option>\n";
		  foreach ($sqldata as $val) {
              if ($val->id == $sel) {
                  $data .= "<option selected=\"selected\" value=\"" . $val->id . "\">" . $val->{'title' . Lang::$lang} . "</option>\n";
              } else
                  $data .= "<option value=\"" . $val->id . "\">" . $val->{'title' . Lang::$lang} . "</option>\n";
          }
          unset($val);
		  $data .= "</select>";
          return $data;
      }

	  /**
	   * Content::displayMenuModule()
	   * 
	   * @return
	   */
	  public static function displayMenuModule()
	  {
	
		  $sql = "SELECT id, title" . Lang::$lang . " FROM " . self::mdTable
		  . "\n WHERE active = 1 AND `system` = 1 ORDER BY title" . Lang::$lang;
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }


	  /**
	   * Content::getSitemap()
	   * 
	   * @return
	   */
	  public function getSitemap()
	  {

		  $sql = "SELECT title" . Lang::$lang . " as pgtitle, slug" 
		  . "\n FROM " . self::pTable
		  . "\n WHERE active = 1" 
		  . "\n AND home_page = 0" 
		  . "\n AND login = 0" 
		  . "\n AND activate = 0" 
		  . "\n AND account = 0" 
		  . "\n AND register = 0" 
		  . "\n AND search = 0" 
		  . "\n AND sitemap = 0" 
		  . "\n ORDER BY title" . Lang::$lang;
		  
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;

	  }

	  /**
	   * Content::getArticleSitemap()
	   * 
	   * @return
	   */
	  public function getArticleSitemap()
	  {
		  
		  $sql = "SELECT title" . Lang::$lang . " as atitle, slug FROM mod_blog WHERE active = 1 ORDER BY title" . Lang::$lang;
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;

	  }
	  
	  /**
	   * Content::getDigishopSitemap()
	   * 
	   * @return
	   */
	  public function getDigishopSitemap()
	  {
		  
		  $sql = "SELECT title" . Lang::$lang . " as dtitle, slug FROM mod_digishop WHERE active = 1 ORDER BY title" . Lang::$lang;
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;

	  }

	  /**
	   * Content::getDergiSitemap()
	   * 
	   * @return
	   */
	  public function getDergiSitemap()
	  {
		  
		  $sql = "SELECT title" . Lang::$lang . " as ptitle, slug FROM mod_dergi ORDER BY title" . Lang::$lang;
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;

	  }

	  /**
	   * Content::getPsDriveSitemap()
	   * 
	   * @return
	   */
	  public function getPsDriveSitemap()
	  {
		  
		  $sql = "SELECT title" . Lang::$lang . " as ptitle, slug FROM mod_psdrive ORDER BY title" . Lang::$lang;
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;

	  }
	  
	  /**
	   * Content::processPage()
	   * 
	   * @return
	   */
	  public function processPage()
	  {
			  Filter::checkPost('title'.Lang::$lang, Lang::$word->_PG_TITLE);

		  if ($_POST['access'] == "Membership" && !isset($_POST['membership_id']))
			  Filter::$msgs['access'] = Lang::$word->_PG_MEMBERSHIP;
			  
		  if (empty(Filter::$msgs)) {
			  $module_name = getValueById("modalias",self::mdTable,intval($_POST['module_id']));
			  $data = array(
				  'title'.Lang::$lang => sanitize($_POST['title'.Lang::$lang]), 
				  'caption'.Lang::$lang => sanitize($_POST['caption'.Lang::$lang]), 
				  'slug' => (empty($_POST['slug'])) ? doSeo($_POST['title'.Lang::$lang]) : doSeo($_POST['slug']),
				  'module_id' => intval($_POST['module_id']),
				  'module_data' => (isset($_POST['module_data'])) ? intval($_POST['module_data']) : 0,
				  'module_name' => ($module_name) ? $module_name : "NULL",
				  'is_admin' => (isset($_POST['is_admin'])) ? intval($_POST['is_admin']) : 1,
				  'contact_form' => intval($_POST['contact_form']),
				  'home_page' => intval($_POST['home_page']),
				  'login' => intval($_POST['login']),
				  'activate' => intval($_POST['activate']),
				  'account' => intval($_POST['account']),
				  'register' => intval($_POST['register']),
				  'search' => intval($_POST['search']),
				  'sitemap' => intval($_POST['sitemap']),
				  'profile' => (isset($_POST['profile'])) ? intval($_POST['profile']) : 0,
				  'body' . Lang::$lang => Filter::in_url($_POST['body' . Lang::$lang]),
				  'jscode' => (empty($_POST['jscode'])) ? "NULL" : $_POST['jscode'],
				  'access' => sanitize($_POST['access']),
				  'keywords'.Lang::$lang => sanitize($_POST['keywords'.Lang::$lang]), 
				  'description'.Lang::$lang => sanitize($_POST['description'.Lang::$lang]), 
				  'custom_bg' => (empty($_POST['filename']) or isset($_POST['delimg'])) ? "NULL" : sanitize($_POST['filename']),
				  'theme' => (empty($_POST['theme'])) ? "NULL" : sanitize($_POST['theme']),
			  );

			  if (empty($_POST['keywords'.Lang::$lang]) or empty($_POST['description'.Lang::$lang])) {
				  include (BASEPATH . 'lib/class_meta.php');
				  parseMeta::instance($_POST['body' . Lang::$lang]);
				  if (empty($_POST['keywords'.Lang::$lang])) {
					  $data['keywords'.Lang::$lang] = parseMeta::get_keywords();
				  }
				  if (empty($_POST['description'.Lang::$lang])) {
					  $data['description'.Lang::$lang] = parseMeta::metaText($_POST['body' . Lang::$lang]);
				  }
			  }

			  
			  if (isset($_POST['membership_id'])) {
				  $data['membership_id'] = Core::_implodeFields($_POST['membership_id']);
			  } else
				  $data['membership_id'] = 0;
				  
			  if ($data['contact_form'] == 1) {
					self::$db->query("UPDATE " . self::pTable . " SET contact_form = 0 WHERE id != " . (Filter::$id ? Filter::$id : 0));
				}
				
			  if ($data['home_page'] == 1) {
				self::$db->query("UPDATE " . self::pTable . " SET home_page = 0 WHERE id != " . (Filter::$id ? Filter::$id : 0));
				}
			
			  if ($data['login'] == 1) {
				  $login['login'] = "DEFAULT(login)";
				  self::$db->update(self::pTable, $login);
				  self::$db->update(Core::sTable, array("login_page" => $data['slug']));
			  }
			  
			  if ($data['activate'] == 1) {
				  $activate['activate'] = "DEFAULT(activate)";
				  self::$db->update(self::pTable, $activate);
				  self::$db->update(Core::sTable, array("activate_page" => $data['slug']));
			  }
			  
			  if ($data['account'] == 1) {
				  $account['account'] = "DEFAULT(account)";
				  self::$db->update(self::pTable, $account);
				  self::$db->update(Core::sTable, array("account_page" => $data['slug']));
			  }
			  
			  if ($data['register'] == 1) {
				  $register['register'] = "DEFAULT(register)";
				  self::$db->update(self::pTable, $register);
				  self::$db->update(Core::sTable, array("register_page" => $data['slug']));
			  }
			  
			  if ($data['search'] == 1) {
				  $search['search'] = "DEFAULT(search)";
				  self::$db->update(self::pTable, $search);
				  self::$db->update(Core::sTable, array("search_page" => $data['slug']));
			  }
			  
			  if ($data['sitemap'] == 1) {
				  $sitemap['sitemap'] = "DEFAULT(sitemap)";
				  self::$db->update(self::pTable, $sitemap);
				  self::$db->update(Core::sTable, array("sitemap_page" => $data['slug']));
			  }

			  if ($data['profile'] == 1) {
				  $sitemap['profile'] = "DEFAULT(profile)";
				  self::$db->update(self::pTable, $sitemap);
				  self::$db->update(Core::sTable, array("profile_page" => $data['slug']));
			  }
			  
			  if (!Filter::$id) {
				  $data['created'] = "NOW()";
			  }
			  
			  if (Filter::$id) {
				  $sdata['page_slug'] = $data['slug'];
				  self::$db->update(self::lTable, $sdata, "page_id=" . Filter::$id);
				  self::$db->update(self::mTable, $sdata, "page_id=" . Filter::$id);
			  }
			  (Filter::$id) ? self::$db->update(self::pTable, $data, "id='" . Filter::$id . "'") : self::$db->insert(self::pTable, $data);
			  
			  $message = (Filter::$id) ? Lang::$word->_PG_UPDATED : Lang::$word->_PG_ADDED;
			  
			  if(self::$db->affected()) {
				  Security::writeLog($message, "", "no", "content");
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
			  } else {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json); 
			  
          } else {
              $json['message'] = Filter::msgStatus();
              print json_encode($json);
          }
      }

	  /**
	   * Content::getPagePlugins()
	   * 
	   * @return
	   */
	  public function getPagePlugins()
	  {
	
		  $counter = countEntries(self::plTable);
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
	
		  $sql = "SELECT * FROM " . self::plTable 
		  . "\n WHERE main = 0 ORDER BY hasconfig DESC, title" . Lang::$lang . $pager->limit;
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  } 


	  /**
	   * Content::getPagePluginsMain()
	   * 
	   * @return
	   */
	  public function getPagePluginsMain()
	  {
	
		  $counter = countEntries(self::plTable);
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
	
		  $sql = "SELECT * FROM " . self::plTable 
		  . "\n WHERE main = 1 ORDER BY hasconfig DESC, title" . Lang::$lang . $pager->limit;
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  } 
	  
	  
	  /**
	   * Content::processPlugin()
	   * 
	   * @return
	   */
	  public function processPlugin()
	  {
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_PL_TITLE);
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
				  'show_title' => intval($_POST['show_title']),
				  'alt_class' => sanitize($_POST['alt_class']),
				  'body' . Lang::$lang => Filter::in_url($_POST['body' . Lang::$lang]),
				  'info' . Lang::$lang => sanitize($_POST['info' . Lang::$lang]),
				  'jscode' => isset($_POST['jscode']) ? $_POST['jscode'] : "NULL",
				  'system' => intval($_POST['system']),
				  'hasconfig' => intval($_POST['hasconfig']),
				  'main' => intval($_POST['main']),
				  'plugalias' => sanitize($_POST['plugalias']),
				  'active' => intval($_POST['active']));
	
			  if (!Filter::$id) {
				  $data['created'] = "NOW()";
			  }
	
			  (Filter::$id) ? self::$db->update(self::plTable, $data, "id='" . Filter::$id . "'") : self::$db->insert(self::plTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_PL_UPDATED : Lang::$word->_PL_ADDED;
	
			  if (self::$db->affected()) {
				  Security::writeLog($message, "", "no", "plugin");
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
			  } else {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
	  
	  /**
	   * Content::getPageModules()
	   * 
	   * @return
	   */
	  public function getPageModules()
	  {
	
		  $counter = countEntries(self::mdTable);
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
	
	
		  $sql = "SELECT * FROM " . self::mdTable 
		  . "\n ORDER BY title" . Lang::$lang . $pager->limit;
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  } 	  

	  /**
	   * Content::processModule()
	   * 
	   * @return
	   */
	  public function processModule()
	  {
	
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_MO_TITLE);
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
				  'info' . Lang::$lang => sanitize($_POST['info' . Lang::$lang]),
				  'theme' => (isset($_POST['theme']) and !empty($_POST['theme'])) ? sanitize($_POST['theme']) : 'NULL',
				  'metakey' . Lang::$lang => sanitize($_POST['metakey' . Lang::$lang]),
				  'metadesc' . Lang::$lang => sanitize($_POST['metadesc' . Lang::$lang]));
	
			  self::$db->update(self::mdTable, $data, "id='" . Filter::$id . "'");
			  $message = (Filter::$id) ? Lang::$word->_PL_UPDATED : Lang::$word->_PL_ADDED;
	
			  if (self::$db->affected()) {
				  Security::writeLog(Lang::$word->_MO_UPDATED, "", "no", "module");
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_MO_UPDATED, false);
			  } else {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

      /**
       * Content::getAvailablePlugins()
	   *
	   * @param mixed $pageid
	   * @param bool $modid
       * @return
       */
	  public function getAvailablePlugins($pageid, $modid = false)
	  {
		  $data = ($modid) ? "mod_id=" . $modid : "page_id=" . $pageid;
	
		  $sql = "SELECT * FROM " . self::plTable 
		  . "\n WHERE id NOT IN (SELECT plug_id FROM " . self::lTable 
		  . "\n WHERE $data)" 
		  . "\n AND active = 1";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

      /**
       * Content::getPluginName()
       * 
       * @param mixed $name
       * @return
       */
      public function getPluginName($name)
	  {
		  $name = sanitize($name);
          $sql = "SELECT title".Lang::$lang." FROM plugins" 
		  . "\n WHERE plugalias = '" . self::$db->escape($name) . "'";
          $row = self::$db->first($sql);
          
		  return ($row) ? $row->{'title'.Lang::$lang} : "NA";
      }

      /**
       * Content::getModuleName()
       * 
       * @param mixed $name
       * @return
       */
      public function getModuleName($name)
	  {
		  $name = sanitize($name);
          $sql = "SELECT title".Lang::$lang." FROM " . self::mdTable 
		  . "\n WHERE modalias = '" . self::$db->escape($name) . "'";
          $row = self::$db->first($sql);
          
		  return ($row) ? $row->{'title'.Lang::$lang} : "NA";
      }

      /**
       * Content::getModuleMetaData()
       * 
       * @return
       */
      public function getModuleMetaData()
	  {
		  
          $sql = "SELECT * FROM " . self::mdTable
		  . "\n WHERE modalias = '" . $this->modalias . "'"
		  . "\n AND active = 1 AND `system` = 1";
          $row = self::$db->first($sql);
          
		  return $this->moduledata = $row;
      }

	  /**
	   * Content::getLayoutOptions()
	   * 
	   * @param mixed $pageid
	   * @param bool $modid
	   * @return
	   */
	  public function getLayoutOptions($pageid, $modid = false)
	  {
	
		  $data = ($modid) ? "l.mod_id=" . $modid : "l.page_id=" . $pageid;
	
		  $sql = "SELECT l.*, p.`system`, p.plugalias, p.hasconfig, p.id as plid, p.title" . Lang::$lang 
		  . "\n FROM " . self::lTable . " AS l" 
		  . "\n INNER JOIN " . self::plTable . " AS p ON p.id = l.plug_id" 
		  . "\n WHERE $data" 
		  . "\n AND is_content = 0" 
		  . "\n ORDER BY l.position ASC, p.title" . Lang::$lang . " ASC";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

      /**
       * Content::getPluginLayoutFront()
       * 
       * @return
       */
	  public function getPluginLayoutFront()
	  {
	
		  $data = ($this->slug) ? "l.page_slug = '" . $this->slug . "'" : "l.modalias = '" . $this->modalias . "'";
	
		  $sql = "SELECT l.*, p.id as plid, p.title" . Lang::$lang . ", p.body" . Lang::$lang . ", p.plugalias, p.hasconfig, p.`system`, p.show_title, p.alt_class, p.jscode" 
		  . "\n FROM layout AS l" 
		  . "\n LEFT JOIN " . self::plTable . " AS p ON p.id = l.plug_id" 
		  . "\n WHERE {$data}" 
		  . "\n AND p.active = 1" 
		  . "\n ORDER BY l.position ASC";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	
	  }
	  
      /**
       * Content::countPlace()
       * 
       * @param array $array
	   * @param str $position
	   * @param bool $is_content
       * @return
       */
	  public static function countPlace($array, $position, $is_content = true)
	  {
		  if ($array) {
			  $result = array();
			  foreach ($array as $val) {
				  if ($is_content == true) {
					  if ($val->place == $position and $val->is_content == 0) {
						  $result[] = $val;
					  }
				  } else {
					  if ($val->system == 1) {
						  $result[] = $val;
					  }
				  }
	
			  }
			  return $result;
		  }
	  }
  
      /**
       * Content::getPluginAssets()
       * 
       * @return
       */
	  public function getPluginAssets($result)
	  {
		  $theme = ($this->theme) ? $this->theme : Registry::get("Core")->theme;
		  if ($result) {
			  foreach ($result as $row) {
				  $tcssfile = PLUGPATHF . $row->plugalias . "/theme/" . $theme . "/style.css";
				  $tjsfile = PLUGPATHF . $row->plugalias . "/theme/" . $theme . "/script.js";
	
				  $cssfile = PLUGPATHF . $row->plugalias . "/style.css";
				  $jsfile = PLUGPATHF . $row->plugalias . "/script.js";
	
				  if (is_file($tcssfile)) {
					  print "<link href=\"" . PLUGURL . $row->plugalias . "/theme/" . $theme . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
				  } elseif (is_file($cssfile)) {
					  print "<link href=\"" . PLUGURL . $row->plugalias . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
	
				  }
	
				  if (is_file($tjsfile)) {
					  print "<script type=\"text/javascript\" src=\"" . PLUGURL . $row->plugalias . "/theme/" . $theme . "/script.js\"></script>\n";
				  } elseif (is_file($jsfile)) {
					  print "<script type=\"text/javascript\" src=\"" . PLUGURL . $row->plugalias . "/script.js\"></script>\n";
				  }
	
			  }
		  }
	
		  if ($this->pluginassets) {
			  foreach ($this->pluginassets as $prow) {
				  $tcssfilep = PLUGPATHF . $prow . "/theme/" . $theme . "/style.css";
				  $tjsfilep = PLUGPATHF . $prow . "/theme/" . $theme . "/script.js";
	
				  $cssfilep = PLUGPATHF . $prow . "/style.css";
				  $jsfilep = PLUGPATHF . $prow . "/script.js";
	
				  if (is_file($tcssfilep)) {
					  print "<link href=\"" . PLUGURL . $prow . "/theme/" . $theme . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
				  } elseif (is_file($cssfilep)) {
					  print "<link href=\"" . PLUGURL . $prow . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
	
				  }
	
				  if (is_file($tjsfilep)) {
					  print "<script type=\"text/javascript\" src=\"" . PLUGURL . $prow . "/theme/" . $theme . "/script.js\"></script>\n";
				  } elseif (is_file($jsfilep)) {
					  print "<script type=\"text/javascript\" src=\"" . PLUGURL . $prow . "/script.js\"></script>\n";
				  }
			  }
		  }
	  }

	  /**
	   * Content::getModuleAssets()
	   * 
	   * @return
	   */
	  public function getModuleAssets()
	  {
	
		  $theme = ($this->theme) ? $this->theme : Registry::get("Core")->theme;
	
		  if ($this->modalias) {
			  $mcssfile = MODPATHF . $this->modalias . "/theme/" . $this->moduledata->theme. "/style.css";
			  $tcssfile = MODPATHF . $this->modalias . "/theme/" . $theme . "/style.css";
			  $tjsfile = MODPATHF . $this->modalias . "/theme/" . $theme . "/script.js";
			  $mtjsfile = MODPATHF . $this->modalias . "/theme/" . $this->moduledata->theme. "/script.js";
			  
			  $cssfile = MODPATHF . $this->modalias . "/style.css";
			  $jsfile = MODPATHF . $this->modalias . "/script.js";

			  if (is_file($mcssfile)) {
				  print "<link href=\"" . MODURL . $this->modalias . "/theme/" . $this->moduledata->theme . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
			  } elseif (is_file($tcssfile)) {
				  print "<link href=\"" . MODURL . $this->modalias . "/theme/" . $theme . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
			  } elseif (is_file($cssfile)) {
				  print "<link href=\"" . MODURL . $this->modalias . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
			  } else {}

			  if (is_file($mtjsfile)) {
				  print "<script type=\"text/javascript\" src=\"" . MODURL . $this->modalias . "/theme/" . $this->moduledata->theme . "/script.js\"></script>\n";
			  } elseif (is_file($tjsfile)) {
				  print "<script type=\"text/javascript\" src=\"" . MODURL . $this->modalias . "/theme/" . $theme . "/script.js\"></script>\n";
			  } elseif (is_file($jsfile)) {
				  print "<script type=\"text/javascript\" src=\"" . MODURL . $this->modalias . "/script.js\"></script>\n";
			  } else {}
				  
		  } elseif ($this->module_name != '' or $this->module_id <> 0) {
			  $tcssfile = MODPATHF . $this->module_name . "/theme/" . Registry::get("Core")->theme . "/style.css";
			  $tjsfile = MODPATHF . $this->module_name . "/theme/" . Registry::get("Core")->theme . "/script.js";
	
			  $cssfile = MODPATHF . $this->module_name . "/style.css";
			  $jsfile = MODPATHF . $this->module_name . "/script.js";
	
			  if (is_file($tcssfile)) {
				  print "<link href=\"" . MODURL . $this->module_name . "/theme/" . $theme . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
			  } else {
				  print "<link href=\"" . MODURL . $this->module_name . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
	
			  }
	
			  if (is_file($tjsfile)) {
				  print "<script type=\"text/javascript\" src=\"" . MODURL . $this->module_name . "/theme/" . $theme . "/script.js\"></script>\n";
			  } elseif (is_file($jsfile)) {
				  print "<script type=\"text/javascript\" src=\"" . MODURL . $this->module_name . "/script.js\"></script>\n";
			  }
		  }
	  }

	  /**
	   * Content:::getStyle()
	   * 
	   * @return
	   */
	  public static function getThemeStyle()
	  {
	
		  $themevar = THEMEDIR . "/skins/" . Registry::get("Core")->theme_var . ".css";
		  if (Registry::get("Core")->lang_dir == "rtl") {
			  $css = THEMEDIR . "/css/style_rtl.css";
			  if (is_file($css)) {
				  print "<link href=\"" . THEMEURL . "/css/style_rtl.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
			  } else {
				  print "<link href=\"" . THEMEURL . "/css/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
			  }
		  } else {
			  print "<link href=\"" . THEMEURL . "/css/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
		  }
	
		  if (Registry::get("Core")->theme_var and is_file($themevar)) {
			  print "<link href=\"" . THEMEURL . "/skins/" . Registry::get("Core")->theme_var . ".css\" rel=\"stylesheet\" type=\"text/css\" />\n";
		  }
	
	  }

	  /**
	   * Content:::getPluginTheme()
	   * 
	   * @return
	   */
	  public static function getPluginTheme($plugname)
	  {
	
		  $themefile = PLUGPATHF . $plugname . "/" . CTHEME . "/main.php";
		  $widgetfile = PLUGPATHF . $plugname . "/main.php";
	
		  return (file_exists($themefile)) ? $themefile : $widgetfile;
	
	  }

	  /**
	   * Content:::getModuleTheme()
	   * 
	   * @return
	   */
	  public static function getModuleTheme($modname)
	  {
	
		  $themefile = MODPATHF . $modname . "/" . CTHEME . "/main.php";
		  $modfilefile = MODPATHF . $modname . "/main.php";
	
		  return (file_exists($themefile)) ? $themefile : $modfilefile;
	
	  }
	  
      /**
       * Content::getMenuTree()
       * 
       * @return
       */
      protected function getMenuTree()
	  {
		  $query = self::$db->query("SELECT * FROM " . self::mTable . " ORDER BY parent_id, position");
		  
		  while ($row = self::$db->fetch($query)) {
			  $this->menutree[$row->id] = array(
			        'id' => $row->id,
					'name'.Lang::$lang => $row->{'name'.Lang::$lang}, 
					'caption'.Lang::$lang => $row->{'caption'.Lang::$lang}, 
					'parent_id' => $row->parent_id
			  );
		  }
		  return $this->menutree;
	  }

      /**
       * Content::getMenuList()
       * 
       * @return
       */
      public function getMenuList()
	  {
		  $query = self::$db->query("SELECT *"
		  . "\n FROM " . self::mTable
		  . "\n WHERE active = 1"
		  . "\n ORDER BY parent_id, position");
          
		  $res = self::$db->numrows($query);
		  while ($row = self::$db->fetch($query)) {
			  $menulist[$row->id] = array(
			        'id' => $row->id,
					'name'.Lang::$lang => $row->{'name'.Lang::$lang}, 
					'caption'.Lang::$lang => $row->{'caption'.Lang::$lang}, 
					'parent_id' => $row->parent_id,
					'page_id' => $row->page_id,
					'mod_id' => $row->mod_id,
					'content_type' => $row->content_type,
					'link' => $row->link,
					'home_page' => $row->home_page,
					'active' => $row->active,
					'target' => $row->target,
					'icon' => $row->icon,
					'cols' => $row->cols,
					'pslug' => $row->page_slug,
			  );
			  
		  }
		  return ($res) ? $menulist : 0;
	  }

      /**
       * Content::getSortMenuList()
       * 
       * @param integer $parent_id
       * @return
       */
	  public function getSortMenuList($parent_id = 0)
	  {
		  $submenu = false;
		  $class = ($parent_id == 0) ? "parent" : "child";
	
		  foreach ($this->menutree as $key => $row) {
			  if ($row['parent_id'] == $parent_id) {
				  if ($submenu === false) {
					  $submenu = true;
					  print "<ul class=\"sortMenu\">\n";
				  }
	
				  print '<li class="dd-item" id="list_' . $row['id'] . '">' 
				  . '<div class="dd-handle"><a data-id="' . $row['id'] . '" data-name="' . $row['name' . Lang::$lang] . '"'
				  . ' data-title="' . Lang::$word->_DELETE . '" data-option="deleteMenu" class="delete">' 
				  . '<i class="icon red remove sign"></i></a><i class="icon reorder"></i>' 
				  . '<a href="index.php?do=menus&amp;action=edit&amp;id=' . $row['id'] . '" class="' . $class . '">' . $row['name' . Lang::$lang] . '</a></div>';
				  $this->getSortMenuList($key);
				  print "</li>\n";
			  }
		  }
		  unset($row);
	
		  if ($submenu === true)
			  print "</ul>\n";
	  }
 

	  /**
	   * Content::getMenu()
	   * 
	   * @param mixed $array
	   * @param integer $parent_id
	   * @return
	   */
	  public function getMenu($array, $parent_id = 0, $menuid = 'main-menu', $class = 'top-menu')
	  {
		  
		  if(is_array($array) && count($array) > 0) {
				  
			  $submenu = false;
			  $attr = (!$parent_id) ? ' class="' . $class . '" id="' . $menuid . '"' : ' class=""';
			  $attr2 = (!$parent_id) ? ' class="dropdown"' : ' class=""';
			  
			  foreach ($array as $key => $row) {
				  if ($row['parent_id'] == $parent_id) {
					  
					  if ($submenu === false) {
						  $submenu = true;	
						  if($parent_id):
						  print "<div class=\"sub-menu-wrap \"><ul" . $attr . ">\n";
						  else:
						  print "<ul" . $attr . ">\n";
						  endif;						  
					  }
					  
					  $url = Url::Page($row['pslug']);
					  
					  $active = ($row['pslug'] == $this->slug) ? "current" : "normal";
					  $mactive = ($row['pslug'] == $this->modalias) ? "current" : "normal";
					  
					  $name = ($parent_id == 0)  ? '' . $row['name' . Lang::$lang] . '' : $row['name' . Lang::$lang];
					  
					  $homeactive = (preg_match('/index.php/', $_SERVER['PHP_SELF'])) ? "current" : "normal";
					  $home = ($row['home_page']) ? " homepage" : "";
					  $icon = ($row['icon']) ? '<i class="' . $row['icon'] . '"></i>' : "";
					  $caption = ($row['caption' . Lang::$lang]) ? '<small>' . $row['caption' . Lang::$lang] . '</small>' : null;
					  $cols = ($row['cols'] > 1) ? ' data-cols="' . numberToWords($row['cols']) . ' cols"' : null;
					  
					  switch ($row['content_type']) {
						  case 'module':
							  $murl = SITEURL . '/' . $row['pslug'] . '/';
							  $murl2 = $row['home_page'] ? SITEURL.'/' : $murl;
							  $link = '<a href="' . $murl2 . '" class="' . $mactive . '">' . $icon . $name . $caption . '</a>';
							  break;
							  
						  case 'page':
							  if ($row['home_page']) {
								  $link = '<a href="' . SITEURL . '/" class="' . $homeactive . $home . '">' . $icon . $name . $caption . '</a>';
							  } else {
								  $link = '<a href="' . $url . '" class="' . $active . $home . '">' . $icon . $name. $caption . '</a>';
							  }
							  break;
							  
						  case 'web':
							  $wlink = ($row['link'] == "#") ? '#' : $row['link'];
							  $wtarget = ($row['link'] == "#") ? null : ' target="' . $row['target'] . '"';
							  $link = '<a href="' . $wlink . '"' . $wtarget . '>' . $icon . $name . $caption . '</a>';
							  break;
					  }
					  
					  print '<li' . $attr2 . $cols .'>';
					  print $link;
					  $this->getMenu($array, $key);
					  print "</li>\n";
				  }
			  }
			  unset($row);
			  
			  if ($submenu === true)
				 if($parent_id):
				  print "</ul></div>\n";
				 else:
				  print "</ul>\n";
				 endif;						  

		  }	  
	  }

	  /**
	   * Content::getMenuDropList()
	   * 
	   * @param mixed $parent_id
	   * @param integer $level
	   * @param mixed $spacer
	   * @param bool $selected
	   * @return
	   */
	  public function getMenuDropList($parent_id, $level = 0, $spacer, $selected = false)
	  {
		  if ($this->menutree) {
			  foreach ($this->menutree as $key => $row) {
				  $sel = ($row['id'] == $selected) ? " selected=\"selected\"" : "";
				  if ($parent_id == $row['parent_id']) {
					  print "<option value=\"" . $row['id'] . "\"" . $sel . ">";
	
					  for ($i = 0; $i < $level; $i++)
						  print $spacer;
	
					  print $row['name' . Lang::$lang] . "</option>\n";
					  $level++;
					  $this->getMenuDropList($key, $level, $spacer, $selected);
					  $level--;
				  }
			  }
			  unset($row);
		  }
	  }

	  /**
	   * Content::processMenu()
	   * 
	   * @return
	   */
	  public function processMenu()
	  {
		  Filter::checkPost('name' . Lang::$lang, Lang::$word->_MU_NAME);
		  Filter::checkPost('content_type', Lang::$word->_MU_TYPE);
	
		  if (empty(Filter::$msgs)) {
			  if (isset($_POST['page_id'])) {
				  $slug = getValueById("slug", self::pTable, intval($_POST['page_id']));
			  } elseif (isset($_POST['mod_id'])) {
				  $mslug = getValueById("modalias", self::mdTable, intval($_POST['mod_id']));
				  $slug = Url::$data['module'][$mslug];
			  } else {
				  $slug = "NULL";
			  }
			  $data = array(
				  'name' . Lang::$lang => sanitize($_POST['name' . Lang::$lang]),
				  'caption' . Lang::$lang => sanitize($_POST['caption' . Lang::$lang]),
				  'parent_id' => intval($_POST['parent_id']),
				  'page_id' => (isset($_POST['page_id'])) ? intval($_POST['page_id']) : "DEFAULT(page_id)",
				  'page_slug' => $slug,
				  'mod_id' => (isset($_POST['mod_id'])) ? intval($_POST['mod_id']) : "DEFAULT(mod_id)",
				  'slug' => doSeo($_POST['name' . Lang::$lang]),
				  'content_type' => sanitize($_POST['content_type']),
				  'link' => (isset($_POST['web'])) ? sanitize($_POST['web']) : "NULL",
				  'target' => (isset($_POST['target'])) ? sanitize("_" . $_POST['target']) : "DEFAULT(target)",
				  'icon' => (isset($_POST['icon'])) ? sanitize($_POST['icon']) : "NULL",
				  'cols' => (isset($_POST['cols'])) ? intval($_POST['cols']) : "DEFAULT(cols)",
				  'home_page' => intval($_POST['home_page']),
				  'active' => intval($_POST['active']));
	
			  if ($data['home_page'] == 1) {
				  $home['home_page'] = "DEFAULT(home_page)";
				  self::$db->update(self::mTable, $home);
			  }
			  if (isset($_POST['mod_id']) and $_POST['home_page']) {
				  $pdata['module_id'] = intval($_POST['mod_id']);
				  $pdata['module_name'] = $slug;
				  self::$db->update(self::pTable, $pdata, "home_page=1");
			  } else {
				  $pdata['module_id'] = 0;
				  $pdata['module_name'] = "NULL";
				  self::$db->update(self::pTable, $pdata, "home_page=1");
			  }
	
			  (Filter::$id) ? self::$db->update(self::mTable, $data, "id=" . Filter::$id) : self::$db->insert(self::mTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_MU_UPDATED : Lang::$word->_MU_ADDED;
	
			  if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
				  Security::writeLog($message, "", "no", "content");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

	  /**
	   * Content::getMenuIcons()
	   * 
	   * @return
	   */
	  function getMenuIcons($selected = false)
	  {
		  $path = UPLOADS . 'menuicons/';
		  checkDir($path);
		  $res = '';
		  $handle = opendir($path);
		  $class = 'odd';
		  while (false !== ($file = readdir($handle))) {
			  $class = ($class == 'even' ? 'odd' : 'even');
			  if ($file != "." && $file != ".." && $file != "_notes" && $file != "index.php" && $file != "blank.png") {
				  $sel =  ($selected == $file) ? ' sel' : '';
				  $res .= "<div class=\"".$class.$sel."\">";
				  if ($selected == $file) {
					  $res .= "<input type=\"radio\" name=\"icon\" value=\"" . $file . "\" checked=\"checked\" />" 
					          . " <img src=\"".UPLOADURL . "/menuicons/" . $file."\" alt=\"\"/> ".$file;
				  } else {
					  $res .= "<input type=\"radio\" name=\"icon\" value=\"" . $file . "\" />" 
					           . " <img src=\"".UPLOADURL . "/menuicons/" . $file."\" alt=\"\"/> ".$file;
				  }
				  $res .= "</div>\n";
			  }
		  }
		  closedir($handle);
		  return $res;
	  }

	  /**
	   * Content::updateLanguage()
	   * 
	   * @return
	   */
	  public static function updateLanguage()
	  {
		  
		  Filter::checkPost('name', Lang::$word->_LA_TTITLE);
		  
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'name' => sanitize($_POST['name']),
				  'langdir' => sanitize($_POST['langdir']),  
				  'author' => sanitize($_POST['author'])
			  );
			  $ldata['langdir'] = $data['langdir'];
			  
			  self::$db->update(Core::sTable, $ldata);
			  $res = self::$db->update(self::lgTable, $data, "id='" . Filter::$id . "'");
	
			  if ($res) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_LA_UPDATED, false);
				  Security::writeLog(Lang::$word->_LA_UPDATED, "", "no", "content");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
			  
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

	  /**
	   * Content::addLanguage()
	   *
       * @return
       */
	  public function addLanguage()
	  {
	
		  Filter::checkPost('name', Lang::$word->_LA_TTITLE);
		  Filter::checkPost('flag', Lang::$word->_LA_COUNTRY_ABB);
	
		  if (Registry::get("Core")->validLang($_POST['flag']))
			  Filter::$msgs['flag'] = Lang::$word->_LA_COUNTRY_ABB_ERR;
	
		  if (empty(Filter::$msgs)) {
			  $flag_id = sanitize($_POST['flag'], 2);
			  self::$db->query("LOCK TABLES " . self::eTable . " WRITE");
			  self::$db->query("ALTER TABLE " . self::eTable . " ADD COLUMN name_$flag_id VARCHAR(200) NOT NULL AFTER name_tr");
			  self::$db->query("ALTER TABLE " . self::eTable . " ADD COLUMN subject_$flag_id VARCHAR(255) NOT NULL AFTER subject_tr");
			  self::$db->query("ALTER TABLE " . self::eTable . " ADD COLUMN help_$flag_id TEXT AFTER help_tr");
			  self::$db->query("ALTER TABLE " . self::eTable . " ADD COLUMN body_$flag_id TEXT AFTER body_tr");
			  self::$db->query("UNLOCK TABLES");
	
			  if ($email_templates = self::$db->fetch_all("SELECT * FROM " . self::eTable)) {
				  foreach ($email_templates as $row) {
					  $data = array(
						  'name_' . $flag_id => $row->name_en,
						  'subject_' . $flag_id => $row->subject_en,
						  'help_' . $flag_id => $row->help_en,
						  'body_' . $flag_id => $row->body_en);
	
					  self::$db->update(self::eTable, $data, "id = {$row->id}");
				  }
				  unset($data, $row);
			  }
	
			  self::$db->query("LOCK TABLES " . Membership::mTable . " WRITE");
			  self::$db->query("ALTER TABLE " . Membership::mTable . " ADD COLUMN title_$flag_id VARCHAR(255) NOT NULL AFTER title_tr");
			  self::$db->query("ALTER TABLE " . Membership::mTable . " ADD COLUMN description_$flag_id TEXT AFTER description_tr");
			  self::$db->query("UNLOCK TABLES");
	
			  if ($memberships = self::$db->fetch_all("SELECT * FROM " . Membership::mTable)) {
				  foreach ($memberships as $row) {
					  $data = array('title_' . $flag_id => $row->title_en, 'description_' . $flag_id => $row->description_en);
	
					  self::$db->update(Membership::mTable, $data, "id = {$row->id}");
				  }
				  unset($data, $row);
			  }
	
			  self::$db->query("LOCK TABLES " . self::mTable . " WRITE");
			  self::$db->query("ALTER TABLE " . self::mTable . " ADD COLUMN name_$flag_id VARCHAR(100) NOT NULL AFTER name_tr");
			  self::$db->query("ALTER TABLE " . self::mTable . " ADD COLUMN caption_$flag_id VARCHAR(100) NOT NULL AFTER caption_tr");
			  self::$db->query("UNLOCK TABLES");
	
			  if ($menus = self::$db->fetch_all("SELECT * FROM " . self::mTable)) {
				  foreach ($menus as $row) {
					  $data = array('name_' . $flag_id => $row->name_en, 'caption_' . $flag_id => $row->caption_en);
					  self::$db->update(self::mTable, $data, "id = {$row->id}");
				  }
				  unset($data, $row);
			  }
	
			  self::$db->query("LOCK TABLES " . self::mdTable . " WRITE");
			  self::$db->query("ALTER TABLE " . self::mdTable . " ADD COLUMN title_$flag_id VARCHAR(120) NOT NULL AFTER title_tr");
			  self::$db->query("ALTER TABLE " . self::mdTable . " ADD COLUMN info_$flag_id TEXT AFTER info_tr");
			  self::$db->query("ALTER TABLE " . self::mdTable . " ADD COLUMN metakey_$flag_id VARCHAR(200) NOT NULL AFTER metakey_tr");
			  self::$db->query("ALTER TABLE " . self::mdTable . " ADD COLUMN metadesc_$flag_id TEXT AFTER metadesc_tr");
			  self::$db->query("UNLOCK TABLES");
	
			  if ($modules = self::$db->fetch_all("SELECT * FROM " . self::mdTable)) {
				  foreach ($modules as $row) {
					  $data = array(
						  'title_' . $flag_id => $row->title_en,
						  'info_' . $flag_id => $row->info_en,
						  'metakey_' . $flag_id => $row->metakey_en,
						  'metadesc_' . $flag_id => $row->metadesc_en);
	
					  self::$db->update(self::mdTable, $data, "id = {$row->id}");
				  }
				  unset($data, $row);
			  }
	
			  self::$db->query("LOCK TABLES " . self::plTable . " WRITE");
			  self::$db->query("ALTER TABLE " . self::plTable . " ADD COLUMN title_$flag_id VARCHAR(120) NOT NULL AFTER title_tr");
			  self::$db->query("ALTER TABLE " . self::plTable . " ADD COLUMN body_$flag_id TEXT AFTER body_tr");
			  self::$db->query("ALTER TABLE " . self::plTable . " ADD COLUMN info_$flag_id TEXT AFTER info_tr");
			  self::$db->query("UNLOCK TABLES");
	
			  if ($plugins = self::$db->fetch_all("SELECT * FROM " . self::plTable)) {
				  foreach ($plugins as $row) {
					  $data = array(
						  'title_' . $flag_id => $row->title_en,
						  'body_' . $flag_id => $row->body_en,
						  'info_' . $flag_id => $row->info_en);
	
					  self::$db->update(self::plTable, $data, "id = {$row->id}");
				  }
				  unset($data, $row);
			  }
	
			  self::$db->query("LOCK TABLES " . self::pTable . " WRITE");
			  self::$db->query("ALTER TABLE " . self::pTable . " ADD COLUMN title_$flag_id VARCHAR(200) NOT NULL AFTER title_tr");
			  self::$db->query("ALTER TABLE " . self::pTable . " ADD COLUMN caption_$flag_id VARCHAR(200) NOT NULL AFTER caption_tr");
			  self::$db->query("ALTER TABLE " . self::pTable . " ADD COLUMN keywords_$flag_id TEXT AFTER keywords_tr");
			  self::$db->query("ALTER TABLE " . self::pTable . " ADD COLUMN body_$flag_id TEXT AFTER body_tr");
			  self::$db->query("ALTER TABLE " . self::pTable . " ADD COLUMN description_$flag_id TEXT AFTER description_tr");
			  self::$db->query("UNLOCK TABLES");
	
			  if ($pages = self::$db->fetch_all("SELECT * FROM " . self::pTable)) {
				  foreach ($pages as $row) {
					  $data = array(
						  'title_' . $flag_id => $row->title_en,
						  'body_' . $flag_id => $row->body_en,
						  'keywords_' . $flag_id => $row->keywords_en,
						  'description_' . $flag_id => $row->description_en);
	
					  self::$db->update(self::pTable, $data, "id = {$row->id}");
				  }
				  unset($data, $row);
			  }
		
			  self::$db->query("LOCK TABLES " . self::cfTable . " WRITE");
			  self::$db->query("ALTER TABLE " . self::cfTable . " ADD COLUMN title_$flag_id VARCHAR(100) NOT NULL AFTER title_tr");
			  self::$db->query("ALTER TABLE " . self::cfTable . " ADD COLUMN tooltip_$flag_id VARCHAR(100) NOT NULL AFTER tooltip_tr");
			  self::$db->query("UNLOCK TABLES");
	
			  if ($custom_fields = self::$db->fetch_all("SELECT * FROM " . self::cfTable)) {
				  foreach ($custom_fields as $row) {
					  $data = array('title_' . $flag_id => $row->title_en, 'tooltip_' . $flag_id => $row->tooltip_en);
	
					  self::$db->update(self::cfTable, $data, "id = {$row->id}");
				  }
				  unset($data, $row);
			  }

			  
			  $getplugindata = self::$db->fetch_all("SELECT plugalias FROM " . self::plTable . " WHERE `system` = 1");
			  if ($getplugindata) {
				  foreach ($getplugindata as $pdata) {
					  $plangdata = BASEPATH . 'admin/plugins/' . $pdata->plugalias. '/lang-add.php';
					  if (is_file($plangdata)) {
						  include_once ($plangdata);
					  }
				  }
				  unset($pdata);
			  }
	
			  $getmoduledata = self::$db->fetch_all("SELECT modalias FROM " . self::mdTable);
			  if ($getmoduledata) {
				  foreach ($getmoduledata as $mdata) {
					  $mlangdata = BASEPATH . 'admin/modules/' . $mdata->modalias . '/lang-add.php';
					  if (is_file($mlangdata)) {
						  include_once ($mlangdata);
					  }
				  }
				  unset($mdata);
			  }

			  $ldata = array(
				  'name' => sanitize($_POST['name']),
				  'flag' => sanitize(strtolower($_POST['flag'])),
				  'langdir' => sanitize($_POST['langdir']),
				  'author' => sanitize($_POST['author'])
				  );
				  
			  self::$db->insert(self::lgTable, $ldata);
	
			  $json['type'] = 'success';
			  $json['message'] = Filter::msgOk(Lang::$word->_LA_LANG_ADDOK, false);
			  Security::writeLog(Lang::$word->_LA_LANG_ADDOK, "", "no", "content");
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

	  /**
	   * Content::deleteLanguage()
	   *
       * @return
       */
	  public static function deleteLanguage()
	  {
	
		  $flag_id = getValueById("flag", self::lgTable, Filter::$id);
	
		  self::$db->query("LOCK TABLES " . self::eTable . " WRITE");
		  self::$db->query("ALTER TABLE " . self::eTable . " DROP COLUMN name_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::eTable . " DROP COLUMN subject_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::eTable . " DROP COLUMN help_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::eTable . " DROP COLUMN body_" . $flag_id);
		  self::$db->query("UNLOCK TABLES");
	
		  self::$db->query("LOCK TABLES " . Membership::mTable . " WRITE");
		  self::$db->query("ALTER TABLE " . Membership::mTable . " DROP COLUMN title_" . $flag_id);
		  self::$db->query("ALTER TABLE " . Membership::mTable . " DROP COLUMN description_" . $flag_id);
		  self::$db->query("UNLOCK TABLES");
	
		  self::$db->query("LOCK TABLES " . self::mTable . " WRITE");
		  self::$db->query("ALTER TABLE " . self::mTable . " DROP COLUMN name_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::mTable . " DROP COLUMN caption_" . $flag_id);
		  self::$db->query("UNLOCK TABLES");
	
		  self::$db->query("LOCK TABLES " . self::mdTable . " WRITE");
		  self::$db->query("ALTER TABLE " . self::mdTable . " DROP COLUMN title_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::mdTable . " DROP COLUMN info_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::mdTable . " DROP COLUMN metakey_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::mdTable . " DROP COLUMN metadesc_" . $flag_id);
		  self::$db->query("UNLOCK TABLES");
	
		  self::$db->query("LOCK TABLES " . self::plTable . " WRITE");
		  self::$db->query("ALTER TABLE " . self::plTable . " DROP COLUMN title_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::plTable . " DROP COLUMN body_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::plTable . " DROP COLUMN info_" . $flag_id);
		  self::$db->query("UNLOCK TABLES");
	
		  self::$db->query("LOCK TABLES " . self::pTable . " WRITE");
		  self::$db->query("ALTER TABLE " . self::pTable . " DROP COLUMN title_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::pTable . " DROP COLUMN caption_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::pTable . " DROP COLUMN body_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::pTable . " DROP COLUMN keywords_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::pTable . " DROP COLUMN description_" . $flag_id);
		  self::$db->query("UNLOCK TABLES");
	
		  self::$db->query("LOCK TABLES " . self::cfTable . " WRITE");
		  self::$db->query("ALTER TABLE " . self::cfTable . " DROP COLUMN title_" . $flag_id);
		  self::$db->query("ALTER TABLE " . self::cfTable . " DROP COLUMN tooltip_" . $flag_id);
		  self::$db->query("UNLOCK TABLES");
		  
		  $getplugindata = self::$db->fetch_all("SELECT plugalias FROM " . self::plTable . " WHERE `system` = 1");
		  if ($getplugindata) {
			  foreach ($getplugindata as $pdata) {
				  $plangdata = BASEPATH . 'admin/plugins/' . $pdata->plugalias . '/lang-delete.php';
				  if (is_file($plangdata)) {
					  include_once ($plangdata);
				  }
			  }
			  unset($pdata);
		  }
	
		  $getmoduledata = self::$db->fetch_all("SELECT modalias FROM modules");
		  if ($getmoduledata) {
			  foreach ($getmoduledata as $mdata) {
				  $mlangdata = BASEPATH . 'admin/modules/' . $mdata->modalias . '/lang-delete.php';
				  if (is_file($mlangdata)) {
					  include_once ($mlangdata);
				  }
			  }
			  unset($mdata);
		  }

	  }

	  /**
	   * Content::getPageList()
	   * 
	   * @return
	   */
	  public static function getPageList($id, $selected = false)
	  {
	
		  $sql = "SELECT id, slug, title" . Lang::$lang . " FROM " . self::pTable;
		  $result = self::$db->fetch_all($sql);
	
		  $display = '';
		  if ($result) {
			  $display .= "<select name=\"page_id\">";
			  foreach ($result as $row) {
				  $sel = ($row->$id == $selected) ? ' selected="selected"' : null;
				  $display .= "<option value=\"" . $row->$id . "\"" . $sel . ">" . $row->{'title' . Lang::$lang} . "</option>\n";
			  }
	
			  $display .= "</select>\n";
		  }
		  return $display;
	
	  }  

	  /**
	   * Content::createSiteMap()
	   * 
	   * @return
	   */
	  private function createSiteMap()
	  {
  
          $pages = self::$db->query("SELECT slug FROM " . self::pTable
		  . "\n WHERE active = 1" 
		  . "\n AND home_page = 0" 
		  . "\n AND login = 0" 
		  . "\n AND activate = 0" 
		  . "\n AND account = 0" 
		  . "\n AND register = 0" 
		  . "\n AND search = 0" 
		  . "\n AND sitemap = 0"
		  . "\n ORDER BY created DESC");
		  
		  $smap = "";
		  
		  $smap .= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
		  $smap .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\r\n";
		  $smap .= "<url>\r\n";
		  $smap .= "<loc>" . SITEURL . "/index.php</loc>\r\n";
		  $smap .= "<lastmod>" . date('Y-m-d') . "</lastmod>\r\n";
		  $smap .= "</url>\r\n";

		  while ($row = self::$db->fetch($pages)) {
			 $url = Url::Page($row->slug);
			  
			  $smap .= "<url>\r\n";
			  $smap .= "<loc>" . $url . "</loc>\r\n";
			  $smap .= "<lastmod>" . date('Y-m-d') . "</lastmod>\r\n";
			  $smap .= "<changefreq>weekly</changefreq>\r\n";
			  $smap .= "</url>\r\n";
		  }
          unset($row);
		  if(isset($_POST['am'])) {
		  $articles = self::$db->query("SELECT slug FROM mod_blog WHERE active = 1 ORDER BY created DESC");
			  
			while ($row = self::$db->fetch($articles)) {
				$url = Url::Blog("item", $row->slug);
				
				$smap .= "<url>\r\n";
				$smap .= "<loc>" . $url . "</loc>\r\n";
				$smap .= "<lastmod>" . date('Y-m-d') . "</lastmod>\r\n";
				$smap .= "<changefreq>weekly</changefreq>\r\n";
				$smap .= "</url>\r\n";
			}
			unset($row);
		  }
		  if(isset($_POST['ds'])) {
		  $digishop = self::$db->query("SELECT slug FROM mod_digishop WHERE active = 1 ORDER BY created DESC");
			  
			while ($row = self::$db->fetch($digishop)) {
				$url = Url::Digishop("item", $row->slug);
				
				$smap .= "<url>\r\n";
				$smap .= "<loc>" . $url . "</loc>\r\n";
				$smap .= "<lastmod>" . date('Y-m-d') . "</lastmod>\r\n";
				$smap .= "<changefreq>weekly</changefreq>\r\n";
				$smap .= "</url>\r\n";
			}
			unset($row);
		  }
		  if(isset($_POST['pf'])) {
		  $dergi = self::$db->query("SELECT slug FROM mod_dergi ORDER BY created DESC");
			  
			while ($row = self::$db->fetch($dergi)) {
				$url = Url::Dergi("item", $row->slug);
				
				$smap .= "<url>\r\n";
				$smap .= "<loc>" . $url . "</loc>\r\n";
				$smap .= "<lastmod>" . date('Y-m-d') . "</lastmod>\r\n";
				$smap .= "<changefreq>weekly</changefreq>\r\n";
				$smap .= "</url>\r\n";
			}
			unset($row);
		  }
		  if(isset($_POST['pd'])) {
		  $psdrive = self::$db->query("SELECT slug FROM mod_psdrive WHERE active = 1 ORDER BY created DESC");
			  
			while ($row = self::$db->fetch($psdrive)) {
				$url = Url::Psdrive("item", $row->slug);
				
				$smap .= "<url>\r\n";
				$smap .= "<loc>" . $url . "</loc>\r\n";
				$smap .= "<lastmod>" . date('Y-m-d') . "</lastmod>\r\n";
				$smap .= "<changefreq>weekly</changefreq>\r\n";
				$smap .= "</url>\r\n";
			}
			unset($row);
		  }
		  $smap .= "</urlset>";
		  
		  return $smap;
	  }
	  
      /**
       * Content::writeSiteMap()
       * 
       * @return
       */
	  public function writeSiteMap()
	  {
		  
		  $filename = BASEPATH . 'sitemap.xml';
		  if (is_writable($filename)) {
			  file_put_contents($filename, $this->createSiteMap());
			  $json['type'] = 'success';
			  $json['message'] = Filter::msgOk(Lang::$word->_SM_SMAPOK, false);
		  } else {
			  $json['type'] = 'error';
			  $json['message'] = Filter::msgAlert(str_replace("[FILENAME]", $filename, Lang::$word->_SM_SMERROR), false);
		  }
		  
		  print json_encode($json);
	  }
	  
      /**
       * Content::getContentType()
       * 
       * @param bool $selected
       * @return
       */
      public static function getContentType($selected = false)
	  {
		  $modlist = self::displayMenuModule();
          if($modlist) {
			  $arr = array(
					'page' => Lang::$word->_CON_PAGE,
					'module' => Lang::$word->_MODULE,
					'web' => Lang::$word->_EXT_LINK
			  );
		  } else {
			  $arr = array(
					'page' => Lang::$word->_CON_PAGE,
					'web' => Lang::$word->_EXT_LINK
			  );  
		  }
		  
		  $contenttype = '';
		  foreach ($arr as $key => $val) {
              if ($key == $selected) {
                  $contenttype .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $contenttype .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $contenttype;
      }

	  /**
	   * Content::getCustomFields()
	   * 
	   * @return
	   */
	  public function getCustomFields()
	  {
	
		  $sql = "SELECT * FROM " . self::cfTable . " ORDER BY sorting, type";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

      /**
       * Content::fieldSection()
       * 
	   * @param mixed $section
       * @return
       */
      public static function fieldSection($section)
      {
          switch($section) {
			  case "profile":
			  return Lang::$word->_CFL_SECTION_P;
			  break;

			  case "register":
			  return Lang::$word->_CFL_SECTION_R;
			  break;

		  }
      }
	  
      /**
       * Content::getFieldSection()
       * 
       * @param bool $section
       * @return
       */
      public static function getFieldSection($section = false)
      {
		  
          $arr = array(
				 'profile' => Lang::$word->_CFL_SECTION_P,
				 'register' => Lang::$word->_CFL_SECTION_R
		  );

          $html = '';
          foreach ($arr as $key => $val) {
              if ($key == $section) {
                  $html .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $html .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $html;
      }

      /**
       * Content::processField()
       * 
       * @return
       */
	  public function processField()
	  {
	
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_CFL_NAME);
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
				  'tooltip' . Lang::$lang => sanitize($_POST['tooltip' . Lang::$lang]),
				  'req' => intval($_POST['req']),
				  'active' => intval($_POST['active']),
				  'type' => sanitize($_POST['type'])
				  );
			  if (!Filter::$id) {
				  $data['name'] = sanitize($_POST['type']) . randName(2);
			  }
	
			  (Filter::$id) ? self::$db->update(self::cfTable, $data, "id=" . Filter::$id) : self::$db->insert(self::cfTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_CFL_UPDATED : Lang::$word->_CFL_ADDED;
	
			  if (self::$db->affected()) {
				  Security::writeLog($message, "", "no", "content");
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
			  } else {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

	  /**
	   * Content::getAccesPages()
	   * 
	   * @return
	   */
	  public static function getAccesPages($row)
	  {
		  $page = false;
	
		  if ($row->contact_form)
			  $page = "contact_form.tpl.php";
	
		  if ($row->login)
			  $page = "login.tpl.php";
	
		  if ($row->activate)
			  $page = "activate.tpl.php";
	
		  if ($row->account)
			  $page = "account.tpl.php";
	
		  if ($row->register)
			  $page = "register.tpl.php";
	
		  if ($row->search)
			  $page = "search.tpl.php";
	
		  if ($row->sitemap)
			  $page = "sitemap.tpl.php";
			  
		  if ($row->profile)
			  $page = "profile.tpl.php";
	
		  return $page;
	  }
	  
	  /**
	   * Content::rendertCustomFields()
	   * 
	   * @param mixed $type
	   * @param mixed $data
	   * @param str $wrap
	   * @return
	   */
	  public function rendertCustomFields($type, $data, $wrap = "two")
	  {
	
		  $html = '';
		  if ($fdata = self::$db->fetch_all("SELECT *, title" . Lang::$lang . " as dbtitle, tooltip" . Lang::$lang . " as dbtip"
		  . "\n FROM " . self::cfTable
		  . "\n WHERE type = '" . $type . "'"
		  . "\n AND active = 1"
		  . "\n ORDER BY sorting")) {
			  $value = ($data) ? explode("::", $data) : null;
			  $group_nr = 1;
			  $last_row = count($fdata) - 1;
			  $wrapper = wordsToNumber($wrap);
			  foreach ($fdata as $id => $cfrow) {
				  if ($id % $wrapper == 0) {
					  $html .= '<div class="' . $wrap . ' fields">';
					  $i = 0;
					  $group_nr++;
				  }
				  
	              $tip = ($cfrow->dbtip) ? $cfrow->dbtip : $cfrow->dbtitle;
				  $html .= '<div class="field">';
				  $html .= '<label>' . $cfrow->dbtitle . '</label>';
					  
				  $html .= '<label class="input">';
				  if ($cfrow->req) {
					  $html .= '<i class="icon-append icon asterisk"></i>';
				  }
				  $html .= '<input name="custom_' . $cfrow->name . '" type="text" placeholder="' . $tip . '" value="' . $value[$id] . '">';
				  $html .= '</label>';
				  $html .= '</div>';
	
				  $i++;
				  if ($i == $wrapper || $id == $last_row)
					  $html .= '</div>';
			  }
			  unset($cfrow);
		  }
	
		  return $html;
	  }

	  /**
	   * Content::getSubheaderBg()
	   * 
	   * @return
	   */
	  public static function getSubheaderBg()
	  {
		  $html = '';
		  $base =  UPLOADS . 'images/subheaders/' . Registry::get("Core")->theme . '/' . Registry::get("Content")->slug . '.jpg';
		  $image =  UPLOADURL . 'images/subheaders/' . Registry::get("Core")->theme  . '/' . Registry::get("Content")->slug . '.jpg';
		  if (file_exists($base)) {
			  $html = ' style="background-image: url(' . $image . ')"';
		  } 
		  return $html;
	  }
	  
      /**
       * Content::getCountryList()
       * 
       * @param bool $parent_id
       * @return
       */
      public function getCountryList($parent_id = false)
	  {	
          ($parent_id) ? $parent_id : 0;
		  
          $sql = "SELECT *"
		  ."\n FROM countries"
		  ."\n WHERE parent_id = '" . (int)$parent_id . "'"
		  ."\n ORDER BY name ASC";
         
		 $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  /**
	   * Content::getPageMeta()
	   * 
	   * @return
	   */
	  private function getPageMeta()
	  {

		  $sep = " | ";
		  $meta = "";

		  if ($this->slug or $this->_url[0] == Url::$data['pagedata']['page']) {
			  $meta .= "<title>";
			  $meta .= $this->title . $sep . Registry::get("Core")->site_name;
			  $meta .= "</title>\n";
			  $meta .= "<meta name=\"keywords\" content=\"";
			  if ($this->keywords) {
				  $meta .= $this->keywords;
			  } else {
				  $meta .= Registry::get("Core")->metakeys;
			  }
			  $meta .= "\" />\n";
			  $meta .= "<meta name=\"description\" content=\"";
			  if ($this->description) {
				  $meta .= $this->description;
			  } else {
				  $meta .= Registry::get("Core")->metadesc;
			  }
			  $meta .= "\" />\n";
		  } elseif(preg_match('/sitemap.php/', $_SERVER['PHP_SELF'])) {
			  $meta .= "<title>" . Registry::get("Core")->site_name;
			  $meta .= $sep . Lang::$word->_SM_SITE_MAP;
			  $meta .= "</title>\n";
		  } else {
			  $meta .= "<title>" . Registry::get("Core")->site_name . "</title>\n";
		  }

		return $meta;
	  }

	  /**
	   * Content::getModuleMeta()
	   * 
	   * @return
	   */
	  private function getModuleMeta()
	  {
		  $modmeta = BASEPATH . 'admin/modules/' . $this->modalias . '/meta.php';
		  if (file_exists($modmeta)) {
	
			  ob_start();
			  include ($modmeta);
			  $contents = ob_get_contents();
			  ob_end_clean();
	
			  return $contents;
		  }
	  }

	  /**
	   * Content::getMeta()
	   * 
	   * @return
	   */
	  public function getMeta()
	  {
		  $meta = '';
		  $meta .= "<meta charset=\"utf-8\">\n";
		  if ($this->modalias) {
			  $meta .= $this->getModuleMeta();
		  } else {
			  $meta .= $this->getPageMeta();
		  }
		  if($this->homeid) {
		     $meta .= "<link rel=\"canonical\" href=\"" .SITEURL ."/\">\n";
		  }
		  $meta .= "<meta name=\"dcterms.rights\" content=\"" . Registry::get("Core")->site_name . " &copy; All Rights Reserved\" >\n";
		  $meta .= "<meta name=\"robots\" content=\"index\" />\n";
		  $meta .= "<meta name=\"robots\" content=\"follow\" />\n";
		  $meta .= "<meta name=\"revisit-after\" content=\"1 day\" />\n";
		  $meta .= "<meta name=\"generator\" content=\"www.turkbilisim.com.tr\" />\n";
		  $meta .= "<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\" />\n";
		  $meta .= "<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"" .SITEURL ."/assets/favicon.ico\" />\n";
		  return $meta;
	  }
  }
?>