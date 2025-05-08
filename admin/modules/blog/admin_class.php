<?php
  /**
   * Blog Class
   *
   * @yazilim TUBI Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 20114
   * @version $Id: class_admin.php, v4.00 2014-03-20 16:10:25 Nurullah Okatan 
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Blog
  {
	  
	  const mTable = "mod_blog";
	  const ctTable = "mod_blog_categories";
	  const rTable = "mod_blog_related_categories";
	  const cmTable = "mod_blog_comments";
	  const tTable = "mod_blog_tags";
	  const tagTable = "plug_blog_tags";

	  private $cattree = array();
	  private $catlist = array();
	  
	  const imagepath = "modules/blog/dataimages/";
	  const filepath = "modules/blog/datafiles/";
	  
	  private static $db;

	  


      /**
       * Blog::__construct()
       * 
       * @return
       */
      function __construct($ctree = true, $item = false, $cat = false)
      {
		  self::$db = Registry::get("Database");
		  $this->getConfig();
		  $this->cattree = ($ctree) ? $this->getCatTree() : null;
		  
          ($item) ? $this->renderSingleArticle() : null;
          ($cat) ? $this->renderSingleCategory() : null;
      }



		  
	  /**
	   * Blog::getConfig()
	   * 
	   * @return
	   */
	  private function getConfig()
	  {
          $row = INI::read(MODPATH . 'blog/config.ini');

          $this->show_counter = $row->am_config->show_counter;
          $this->fperpage = $row->am_config->fperpage;
          $this->flayout = $row->am_config->flayout;
		  $this->popperpage = $row->am_config->popperpage;
		  $this->latestperpage = $row->am_config->latestperpage;
		  $this->comperpage = $row->am_config->comperpage;
		  $this->username_req = $row->am_config->username_req;
		  $this->email_req = $row->am_config->email_req;
		  $this->show_captcha = $row->am_config->show_captcha;
		  $this->show_www = $row->am_config->show_www;
		  $this->show_username = $row->am_config->show_username;
		  $this->auto_approve = $row->am_config->auto_approve;
		  $this->public_access = $row->am_config->public_access;
		  $this->notify_new = $row->am_config->notify_new;
		  $this->sorting = $row->am_config->sorting;
		  $this->blacklist_words = $row->am_config->blacklist_words;
		  $this->char_limit = $row->am_config->char_limit;
		  $this->cperpage = $row->am_config->cperpage;
		  $this->cdateformat = $row->am_config->cdateformat;
		  $this->upost = $row->am_config->upost;
		  $this->notify_admin_template = base64_decode($row->am_config->notify_admin_template);
		  $this->notify_user_template = base64_decode($row->am_config->notify_user_template);

          return ($row) ? $row : 0;
	  }



      /**
       * Blog::getCatTree()
       * 
       * @return
       */
      protected function getCatTree()
	  {
		  $query = self::$db->query("SELECT * FROM " . self::ctTable . " ORDER BY parent_id, position");
		  
		  while ($row = self::$db->fetch($query)) {
			  $this->cattree[$row->id] = array(
			        'id' => $row->id,
					'name'.Lang::$lang => $row->{'name'.Lang::$lang}, 
					'parent_id' => $row->parent_id
			  );
		  }
		  return $this->cattree;
	  }

      /**
       * Blog::getCatList()
       * 
       * @return
       */
      public function getCatList()
	  {

		  $query = self::$db->query("SELECT *, (SELECT COUNT(a.id) FROM " . self::mTable . " a"
		  . "\n INNER JOIN " . self::rTable . " rc on a.id = rc.aid"
		  . "\n WHERE rc.cid = " . self::ctTable . ".id AND a.active = 1) as totalarticles" 
		  . "\n FROM " . self::ctTable 
		  . "\n ORDER BY parent_id, position");
		  
		  $res = self::$db->numrows($query);
		  while ($row = self::$db->fetch($query)) {
			  $catlist[$row->id] = array(
			        'id' => $row->id,
					'slug' => $row->slug, 
					'name'.Lang::$lang => $row->{'name'.Lang::$lang},
					'parent_id' => $row->parent_id,
					'icon' => $row->icon,
					'description'.Lang::$lang => $row->{'description'.Lang::$lang},
					'totalarticles'=> $row->totalarticles
			  );
		  }
		  return ($res) ? $catlist : null;
	  }

      /**
       * Blog::getCatCheckList()
       * 
	   * @param mixed $parent_id
	   * @param integer $level
	   * @param mixed $spacer
	   * @param bool $selected
       * @return
       */
	  public function getCatCheckList($parent_id, $level = 0, $spacer, $selected = false)
	  {
		  
		  if($this->cattree) {
			  $class = 'odd';

			  if($selected) {
				$arr = explode(",",$selected);
				reset($arr);
			  }

			  foreach ($this->cattree as $key => $row) {
				  if($selected) {
					$sel =  (in_array($row['id'], $arr))  ? " checked=\"checked\"" : "";
					$hsel = (in_array($row['id'], $arr)) ? " sel" : "";
				  } else {
					  $sel = '';
					  $hsel = '';
				  }
				  $class = ($class == 'even' ? 'odd' : 'even');
				  
				  if ($parent_id == $row['parent_id']) {
					  print "<div class=\"" . $class . $hsel . "\"> <label class=\"checkbox\"><input type=\"checkbox\" name=\"cid[]\" class=\"checkbox\" value=\"" . $row['id'] . "\"".$sel." />";
					  for ($i = 0; $i < $level; $i++)
						  print $spacer;
						  
					  print "<i></i>".$row['name'.Lang::$lang] . "</label></div>\n";
					  $level++;
					  $this->getCatCheckList($key, $level, $spacer, $selected);
					  $level--;
				  }
			  }
			  unset($row);
		  }
	  }

	  /**
	   * Blog::fetchArticleCategories()
	   * 
	   * @return
	   */
	  public function fetchArticleCategories()
	  {

		  if ($result = self::$db->fetch_all("SELECT cid FROM " . self::rTable . " WHERE aid = ".Filter::$id)) {
			  $cids = array();
			  foreach ($result as $row) {
				  $cids[] = $row->cid;
			  }
			  unset($row);
			  $cids = implode(",", $cids);
		  } else {
			  $cids = "";
		  }
		  return $cids;

	  }
	  
      /**
       * Blog::getSortCatList()
       * 
	   * @param integer $parent_id
       * @return
       */
      public function getSortCatList($parent_id = 0)
	  {
		  
		  $submenu = false;
		  $class = ($parent_id == 0) ? "parent" : "child";

		  foreach ($this->cattree as $key => $row) {
			  if ($row['parent_id'] == $parent_id) {
				  if ($submenu === false) {
					  $submenu = true;
					  
					  print "<ul class=\"sortMenu\">\n";
				  }

				  print '<li class="dd-item" id="list_' . $row['id'] . '">' 
				  . '<div class="dd-handle"><a data-id="' . $row['id'] . '" data-name="' . $row['name' . Lang::$lang] . '"'
				  . ' data-title="' . Lang::$word->_DELETE . '" data-option="deleteCategory" class="delete">' 
				  . '<i class="icon red remove sign"></i></a><i class="icon reorder"></i>' 
				  . '<a href="index.php?do=modules&action=config&amp;modname=blog&amp;maction=catedit&amp;id=' . $row['id'] . '" class="' . $class . '">' . $row['name' . Lang::$lang] . '</a></div>';
				  $this->getSortCatList($key);
				  print "</li>\n";

			  }
		  }
		  unset($row);
		  
		  if ($submenu === true)
			  print "</ul>\n";
	  }

	  /**
	   * Blog::getCategories()
	   * 
	   * @return
	   */
	  public function getCategories($array, $parent_id = 0, $menuid = 'blogcats', $class = 'blog-menu')
	  {
		  
		  if(is_array($array) && count($array) > 0) {
			  $submenu = false;
			  $attr = (!$parent_id) ? ' class="' . $class . '" id="' . $menuid . '"' : ' class="menu-submenu"';
			  $attr2 = (!$parent_id) ? ' class="nav-item"' : ' class="nav-submenu-item"';
	
			  foreach ($array as $key => $row) {
				  
				  if ($row['parent_id'] == $parent_id) {
					  if ($submenu === false) {
						  $submenu = true;
						  
						  print "<ul" . $attr . ">\n";
					  }
	
					  $url = Url::Blog("blog-cat", $row['slug']);
					  $icon = ($row['icon']) ? '<i class="' . $row['icon'] . '"></i>' : null; 
	
					  $counter = ($this->show_counter) ? '<small>('.$row['totalarticles'].')</small> ' : null;
					  $active = (isset(Registry::get("Content")->_url[2]) and Registry::get("Content")->_url[2] == $row['slug']) ? " active" : "normal";
					  $link = '<a href="'.$url.'" class="' . $active . '" title="' . $row['name'.Lang::$lang] . '">' . $icon . $row['name'.Lang::$lang] . $counter.'</a>';
		
					  
					  print '<li>';
					  print $link;
					  $this->getCategories($array, $key);
					  print "</li>\n";
				  }
			  }
			  unset($row);
			  
			  if ($submenu === true)
				  print "</ul>\n";
		  }
	  }

	  /**
	   * Blog::getCatDropList()
	   * 
	   * @return
	   */
	  public function getCatDropList($parent_id, $level = 0, $spacer, $selected = false)
	  {
		  
		  foreach ($this->cattree as $key => $row) {
			  $sel = ($row['id'] == $selected) ? " selected=\"selected\"" : "" ;
			  if ($parent_id == $row['parent_id']) {
				  print "<option value=\"" . $row['id'] . "\"".$sel.">";
				  
				  for ($i = 0; $i < $level; $i++)
					  print $spacer;
				  
				  print $row['name'.Lang::$lang] . "</option>\n";
				  $level++;
				  $this->getCatDropList($key, $level, $spacer, $selected);
				  $level--;
			  }
		  }
		  unset($row);
	  }

	  /**
	   * Blog::processCategory()
	   * 
	   * @return
	   */
	  public function processCategory()
	  {
	
		  Filter::checkPost('name' . Lang::$lang, Lang::$word->_MOD_AM_CATNAME);
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'name' . Lang::$lang => sanitize($_POST['name' . Lang::$lang]),
				  'slug' => (empty($_POST['slug'])) ? doSeo($_POST['name' . Lang::$lang]) : doSeo($_POST['slug']),
				  'parent_id' => intval($_POST['parent_id']),
				  'description' . Lang::$lang => sanitize($_POST['description' . Lang::$lang]),
				  'metakey' . Lang::$lang => sanitize($_POST['metakey' . Lang::$lang]),
				  'metadesc' . Lang::$lang => sanitize($_POST['metadesc' . Lang::$lang]),
				  'icon' => (!empty($_POST['icon'])) ? sanitize($_POST['icon']) : "NULL",
				  'perpage' => intval($_POST['perpage']),
				  'layout' => intval($_POST['layout']),
				  'active' => intval($_POST['active']),
				  );
	
			  if (empty($_POST['metakey' . Lang::$lang]) or empty($_POST['metadesc' . Lang::$lang])) {
				  include (BASEPATH . 'lib/class_meta.php');
				  parseMeta::instance($_POST['description' . Lang::$lang]);
				  if (empty($_POST['metakey' . Lang::$lang])) {
					  $data['metakey' . Lang::$lang] = parseMeta::get_keywords();
				  }
				  if (empty($_POST['metadesc'])) {
					  $data['metadesc' . Lang::$lang] = parseMeta::metaText($_POST['description' . Lang::$lang]);
				  }
			  }
	
			  (Filter::$id) ? self::$db->update(self::ctTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::ctTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_MOD_AM_CAUPDATED : Lang::$word->_MOD_AM_CAADDED;
	
			  if (self::$db->affected()) {
				  Security::writeLog($message, "", "no", "module");
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
       * Blog::renderCategory()
       * 
       * @return
       */
	  public function renderCategory($cid, $perpage, $slug)
	  {
	
		  $q = "SELECT COUNT(a.id) FROM " . self::mTable . " a" 
		  . "\n INNER JOIN " . self::rTable . " rc on a.id = rc.aid" 
		  . "\n WHERE rc.cid = " . (int)$cid . " AND a.active = 1 AND a.created <= NOW() AND (a.expire = '0000-00-00 00:00:00' OR a.expire >= NOW()) LIMIT 1";
		  $record = self::$db->query($q);
		  $total = self::$db->fetchrow($record);
		  $counter = $total[0];
	
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = $perpage;
		  $pager->path = Url::Blog("blog-cat", $slug, "?");
		  $pager->paginate();
	
		  $sql = "SELECT a.*, c.id as cid, c.name" . Lang::$lang . " as catname, a.title" . Lang::$lang . " as atitle, a.slug, a.thumb, a.show_author," 
		  . "\n a.show_created, a.short_desc" . Lang::$lang . ", a.caption" . Lang::$lang . ", c.slug as catslug, u.username, a.created, a.modified," 
		  . "\n (SELECT COUNT(artid) FROM " . self::cmTable . " WHERE artid = a.id) as totalcomments, YEAR(a.created) as year,"
		  . "\n MONTH(a.created) as month, DATE_FORMAT(a.created, '%d') as day" 
		  . "\n FROM " . self::mTable . " as a" 
		  . "\n INNER JOIN " . self::rTable . " rc ON a.id = rc.aid" 
		  . "\n LEFT JOIN " . self::ctTable . " as c ON c.id = rc.cid" 
		  . "\n LEFT JOIN " . Users::uTable . " as u ON u.id = a.uid" 
		  . "\n WHERE rc.cid = " . (int)$cid
		  . "\n AND c.active = 1" 
		  . "\n AND a.created <= NOW()" 
		  . "\n AND (a.expire = '0000-00-00 00:00:00' OR a.expire >= NOW())" 
		  . "\n AND a.active = 1" 
		  . "\n ORDER BY a.created DESC" . $pager->limit;
	
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

	  	  	  	  	  	  	  	  	  	
	  /**
	   * Blog::processConfig()
	   * 
	   * @return
	   */
	  public function processConfig()
	  {
		  
		  Filter::checkPost('fperpage', Lang::$word->_MOD_AM_LATEST);

		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'am_config' => array(
					  'show_counter' => intval($_POST['show_counter']),
					  'fperpage' => intval($_POST['fperpage']),
					  'popperpage' => intval($_POST['popperpage']),
					  'latestperpage' => intval($_POST['latestperpage']),
					  'comperpage' => intval($_POST['comperpage']),
					  'flayout' => intval($_POST['flayout']),
					  'username_req' => intval($_POST['username_req']),
					  'email_req' => intval($_POST['email_req']),
					  'upost' => intval($_POST['upost']),
					  'show_captcha' => intval($_POST['show_captcha']),
					  'show_www' => intval($_POST['show_www']),
					  'show_username' => intval($_POST['show_username']),
					  'auto_approve' => intval($_POST['auto_approve']),
					  'notify_new' => intval($_POST['notify_new']),
					  'public_access' => intval($_POST['public_access']),
					  'sorting' => sanitize($_POST['sorting']),
					  'blacklist_words' => '"' .sanitize($_POST['blacklist_words']) . '"',
					  'char_limit' => intval($_POST['char_limit']),
					  'cperpage' => intval($_POST['cperpage']),
					  'cdateformat' => sanitize($_POST['cdateformat']),
					  'notify_admin_template' => '"' . base64_encode($_POST['notify_admin_template']) . '"',
					  'notify_user_template' => '"' . base64_encode($_POST['notify_user_template']) . '"'
				  ));

			  if (INI::write(MODPATH . 'blog/config.ini', $data)) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_MOD_AM_CUPDATED, false);
				  Security::writeLog(Lang::$word->_MOD_AM_CUPDATED, "", "no", "module");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_PROCCESS_C_ERR . '{admin/modules/blog/config.ini}', false);
			  }
			  print json_encode($json);
			   
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
	  
	  /**
	   * Blog::getArticles()
	   * 
	   * @return
	   */
	  public function getArticles($from = false)
	  {
	
		  if (isset($_GET['letter']) and (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '')) {
			  $enddate = date("Y-m-d");
			  $letter = sanitize($_GET['letter'], 2);
			  $fromdate = (empty($from)) ? $_POST['fromdate_submit'] : $from;
			  if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
				  $enddate = $_POST['enddate_submit'];
			  }
			  if (Filter::$id) {
				  $where = " WHERE a.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'"
				  . "\n AND title" . Lang::$lang . " REGEXP '^" . self::$db->escape($letter) . "' AND a.cid = " . Filter::$id;
				  $q = "SELECT COUNT(*) FROM " . self::mTable . " WHERE created BETWEEN '" . trim($fromdate) . "'"
				  . "\n AND '" . trim($enddate) . " 23:59:59'" 
				  . "\n AND title" . Lang::$lang . " REGEXP '^" . self::$db->escape($letter) . "' AND cid = " . Filter::$id;
			  } else {
				  $q = "SELECT COUNT(*) FROM " . self::mTable . " WHERE created BETWEEN '" . trim($fromdate) . "'"
				  . "\n AND '" . trim($enddate) . " 23:59:59'" 
				  . "\n AND title" . Lang::$lang . " REGEXP '^" . self::$db->escape($letter) . "'";
				  $where = " WHERE a.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'"
				  . "\n AND title" . Lang::$lang . " REGEXP '^" . self::$db->escape($letter) . "'";
			  }
	
		  } elseif (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '') {
			  $enddate = date("Y-m-d");
			  $fromdate = (empty($from)) ? $_POST['fromdate_submit'] : $from;
			  if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
				  $enddate = $_POST['enddate_submit'];
			  }
			  if (Filter::$id) {
				  $q = "SELECT COUNT(*) FROM " . self::mTable . " WHERE created BETWEEN '" . trim($fromdate) . "'"
				  . "\n AND '" . trim($enddate) . " 23:59:59' AND a.cid = " . Filter::$id;
				  $where = " WHERE a.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' AND cid = " . Filter::$id;
			  } else {
				  $q = "SELECT COUNT(*) FROM " . self::mTable . " WHERE created BETWEEN '" . trim($fromdate) . "'"
				  . "\n AND '" . trim($enddate) . " 23:59:59'";
				  $where = " WHERE a.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
			  }
	
		  } elseif (isset($_GET['letter'])) {
			  $letter = sanitize($_GET['letter'], 2);
			  if (Filter::$id) {
				  $where = "WHERE title" . Lang::$lang . " REGEXP '^" . self::$db->escape($letter) . "'"
				  . "\n AND a.cid = " . Filter::$id;
				  $q = "SELECT COUNT(*) FROM " . self::mTable . " WHERE title" . Lang::$lang . " REGEXP '^" . self::$db->escape($letter) . "'"
				  . "\n AND cid = " . Filter::$id . " LIMIT 1";
			  } else {
				  $where = "WHERE title" . Lang::$lang . " REGEXP '^" . self::$db->escape($letter) . "'";
				  $q = "SELECT COUNT(*) FROM " . self::mTable . " WHERE title" . Lang::$lang . " REGEXP '^" . self::$db->escape($letter) . "' LIMIT 1";
			  }
	
		  } else {
			  if (Filter::$id) {
				  $q = "SELECT COUNT(*) FROM " . self::mTable . " WHERE cid = " . Filter::$id . " LIMIT 1";
				  $where = "WHERE a.cid = " . Filter::$id;
			  } else {
				  $q = "SELECT COUNT(*) FROM " . self::mTable . " LIMIT 1";
				  $where = null;
			  }
		  }
	
		  $record = self::$db->query($q);
		  $total = self::$db->fetchrow($record);
		  $counter = $total[0];
	
		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();
	
		  $sql = "SELECT a.*, c.id as cid, c.name" . Lang::$lang . " as catname," 
		  . "\n (SELECT COUNT(artid) FROM " . self::cmTable . " WHERE artid = a.id) as totalcomments" 
		  . "\n FROM " . self::mTable . " as a" 
		  . "\n LEFT JOIN " . self::ctTable . " as c ON c.id = a.cid" 
		  . "\n $where" 
		  . "\n ORDER BY a.created DESC " . $pager->limit;
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

      /**
       * Blog::getUserArticles()
       * 
       * @return
       */
	  public function getUserArticles()
	  {

		  $sql = "SELECT a.*, c.id as cid, c.name" . Lang::$lang . " as catname, c.slug as catslug" 
		  . "\n FROM " . self::mTable . " as a" 
		  . "\n LEFT JOIN " . self::ctTable . " as c ON c.id = a.cid" 
		  . "\n WHERE a.uid = " .  Registry::get("Users")->uid
		  . "\n AND a.active = 0"
		  . "\n ORDER BY a.created DESC";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }
	  
      /**
       * Blog::getPopularList()
       * 
       * @return
       */
	  public function getPopularList()
	  {
	
		  $sql = "SELECT id, slug, title" . Lang::$lang . " as atitle, created, thumb, caption" . Lang::$lang . " as imgcap" 
		  . "\n FROM " . self::mTable 
		  . "\n WHERE created <= NOW()" 
		  . "\n AND (expire = '0000-00-00 00:00:00' OR expire >= NOW())" 
		  . "\n AND active = 1" 
		  . "\n ORDER BY hits DESC LIMIT {$this->popperpage}";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

      /**
       * Blog::getCommentsList()
       * 
       * @return
       */
	  public function getCommentsList()
	  {
	
		  $sql = "SELECT c.username, c.body, a.title" . Lang::$lang . " as atitle, a.slug,c.created" 
		  . "\n FROM " . self::cmTable . " as c" 
		  . "\n LEFT JOIN " . self::mTable . " AS a ON a.id = c.artid" 
		  . "\n WHERE c.active = 1 and a.active = 1" 
		  . "\n ORDER BY c.created DESC LIMIT {$this->comperpage}";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

      /**
       * Blog::getLatestArticles()
       * 
       * @return
       */
      public function getLatestArticles()
      {
		  
		  $pager = Paginator::instance();
		  $pager->items_total = countEntries(self::mTable);
		  $pager->default_ipp = $this->fperpage;
		  $pager->path = Url::Blog("blog", false, "?");
		  $pager->paginate();
		  
		  $sql = "SELECT a.*, c.id as cid, c.name".Lang::$lang." as catname, a.title".Lang::$lang." as atitle, c.slug as catslug, u.username, CONCAT(u.fname,' ',u.lname) as fullname,"
		  . "\n (SELECT COUNT(artid) FROM ".self::cmTable." WHERE artid = a.id) as totalcomments, YEAR(a.created) as year, MONTH(a.created) as month, DATE_FORMAT(a.created, '%d') as day"
		  . "\n FROM " . self::mTable . " as a" 
		  . "\n LEFT JOIN " . self::ctTable . " as c ON c.id = a.cid" 
		  . "\n LEFT JOIN " . Users::uTable . " as u ON u.id = a.uid" 
		  . "\n WHERE a.created <= NOW()"
		  . "\n AND (a.expire = '0000-00-00 00:00:00' OR a.expire >= NOW())"
		  . "\n AND a.active = 1"
		  . "\n ORDER BY a.created DESC" . $pager->limit;
          $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
      }	

      /**
       * Blog::getLatestPluginArticles()
       * 
       * @return
       */
	  public function getLatestPluginArticles()
	  {
	
		  $sql = "SELECT a.*, c.id as cid, c.name" . Lang::$lang . " as catname, a.title" . Lang::$lang . " as atitle, c.slug as catslug, u.username, CONCAT(u.fname,' ',u.lname) as fullname," 
		  . "\n (SELECT COUNT(artid) FROM " . self::cmTable . " WHERE artid = a.id) as totalcomments,"
		  . "\n YEAR(a.created) as year, MONTH(a.created) as month, DATE_FORMAT(a.created, '%d') as day" 
		  . "\n FROM " . self::mTable . " as a" 
		  . "\n LEFT JOIN " . self::ctTable . " as c ON c.id = a.cid" 
		  . "\n LEFT JOIN " . Users::uTable . " as u ON u.id = a.uid" 
		  . "\n WHERE a.created <= NOW()" 
		  . "\n AND (a.expire = '0000-00-00 00:00:00' OR a.expire >= NOW())" 
		  . "\n AND a.active = 1" 
		  . "\n ORDER BY a.created DESC LIMIT " . $this->latestperpage;
		  
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }	
	  
      /**
       * Blog::getRelatedArticles()
       * 
       * @return
       */
	  public function getRelatedArticles($id, $title)
	  {
	
		  $sql = "SELECT id, title" . Lang::$lang . " as atitle, slug" 
		  . "\n FROM " . self::mTable 
		  . "\n WHERE created <= NOW()" 
		  . "\n AND (expire = '0000-00-00 00:00:00' OR expire >= NOW())" 
		  . "\n AND active = 1" 
		  . "\n AND id != " . $id 
		  . "\n AND (1=0";
		  $related = explode(' ', $title);
		  foreach ($related as $word) {
			  $word = str_replace(',', '', $word);
			  $word = sanitize($word);
			  if (strlen($word) > 3) {
				  $sql .= " OR title" . Lang::$lang . " LIKE '%" . self::$db->escape($word) . "%'";
			  }
		  }
		  $sql .= ")" 
		  . "\n ORDER BY created DESC LIMIT 10";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

	  
      /**
       * Blog::searchArticle()
       * 
       * @return
       */
	  public function searchArticle($keyword)
	  {
		  $keyword = sanitize($keyword, 15);
	
		  $sql = "SELECT a.*, c.id as cid, c.name" . Lang::$lang . " as catname, a.title" . Lang::$lang . " as atitle, c.slug as catslug, u.username," 
		  . "\n (SELECT COUNT(artid) FROM " . self::cmTable . " WHERE artid = a.id) as totalcomments, YEAR(a.created) as year, MONTH(a.created) as month, DATE_FORMAT(a.created, '%d') as day" 
		  . "\n FROM " . self::mTable . " as a" 
		  . "\n LEFT JOIN " . self::ctTable . " as c ON c.id = a.cid" 
		  . "\n LEFT JOIN users as u ON u.id = a.uid" 
		  . "\n WHERE MATCH (title" . Lang::$lang . ", body" . Lang::$lang . ") AGAINST ('" . self::$db->escape($keyword) . "*' IN BOOLEAN MODE)" 
		  . "\n AND a.created <= NOW()" 
		  . "\n AND (a.expire = '0000-00-00 00:00:00' OR a.expire >= NOW())" 
		  . "\n AND a.active = 1" 
		  . "\n ORDER BY a.created DESC LIMIT 20";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

      /**
       * Blog::renderArchiveList()
       * 
       * @return
       */
	  public function renderArchiveList()
	  {
		  $data = explode("-", Registry::get("Content")->_url[2]);
		  if (count($data) == 2) {
			  $month = sanitize($data[1], 2);
			  $year = sanitize($data[0], 4);
		  } else {
			  $month = 0;
			  $year = 0;
		  }
	
		  $sql = "SELECT a.*, c.id as cid, c.name" . Lang::$lang . " as catname, a.title" . Lang::$lang . " as atitle, c.slug as catslug, u.username," 
		  . "\n (SELECT COUNT(artid) FROM " . self::cmTable . " WHERE artid = a.id) as totalcomments" 
		  . "\n FROM " . self::mTable . " as a" 
		  . "\n LEFT JOIN " . self::ctTable . " as c ON c.id = a.cid" 
		  . "\n LEFT JOIN " . Users::uTable . " as u ON u.id = a.uid" 
		  . " \n WHERE YEAR(a.created) = '" . (int)$year . "' AND MONTH(a.created) = '" . (int)$month . "'" 
		  . "\n AND a.active = 1" 
		  . "\n ORDER BY a.created";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }


      /**
       * Blog::renderTagList()
       * 
       * @return
       */
	  public function renderTagList()
	  {
		  $tagname = sanitize(Registry::get("Content")->_url[2]);
	
		  $sql = "SELECT a.*, c.id as cid, c.name" . Lang::$lang . " as catname, a.title" . Lang::$lang . " as atitle, c.slug as catslug, u.username," 
		  . "\n (SELECT COUNT(artid) FROM " . self::cmTable . " WHERE artid = a.id) as totalcomments,"
		  . "\n YEAR(a.created) as year, MONTH(a.created) as month, DATE_FORMAT(a.created, '%d') as day" 
		  . "\n FROM " . self::tagTable . " as t" 
		  . "\n JOIN " . self::tTable . " as pt ON pt.tid = t.id" 
		  . "\n JOIN " . self::mTable . " as a ON a.id = pt.aid" 
		  . "\n JOIN " . Users::uTable . " as u on u.id = a.uid" 
		  . "\n JOIN " . self::ctTable . " as c ON c.id = a.cid" 
		  . "\n WHERE t.tagname" . Lang::$lang . " = '" . self::$db->escape($tagname) . "'" 
		  . "\n AND a.created <= NOW()" 
		  . "\n AND (a.expire = '0000-00-00 00:00:00' OR a.expire >= NOW())" 
		  . "\n AND a.active = 1" 
		  . "\n ORDER BY a.created";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }

      /**
       * Blog::renderSingleCategory()
       * 
       * @return
       */
      private function renderSingleCategory()
      {

          $sql = "SELECT * FROM " . self::ctTable . " WHERE slug = '" . Registry::get("Content")->_url[2] . "' AND active = 1";
          $row = self::$db->first($sql);

          return ($row) ? Registry::get("Content")->moduledata->mod = $row : 0;

      }
	  
      /**
       * Blog::renderSingleArticle()
       * 
       * @return
       */
	  public function renderSingleArticle()
	  {
	
		  $sql = "SELECT a.*, c.id as cid, c.name" . Lang::$lang . " as catname, a.title" . Lang::$lang . " as atitle,"
		  . "\n c.slug as catslug, u.username, CONCAT(u.fname,' ',u.lname) as fullname," 
		  . "\n (SELECT COUNT(artid) FROM " . self::cmTable . " WHERE artid = a.id) as totalcomments," 
		  . "\n (SELECT GROUP_CONCAT(DISTINCT tagname" . Lang::$lang . ") FROM " . self::tagTable . " WHERE FIND_IN_SET(id,a.tags" . Lang::$lang . ") > 0)as tags" 
		  . "\n FROM " . self::mTable . " as a" 
		  . "\n LEFT JOIN " . self::ctTable . " as c ON c.id = a.cid" 
		  . "\n LEFT JOIN " . Users::uTable . " as u ON u.id = a.uid" 
		  . "\n WHERE a.slug = '" . Registry::get("Content")->_url[1] . "'" 
		  . "\n AND a.created <= NOW()" 
		  . "\n AND (a.expire = '0000-00-00 00:00:00' OR a.expire >= NOW())" 
		  . "\n AND a.active = 1";
	
		  $row = self::$db->first($sql);
	
		  return ($row) ? Registry::get("Content")->moduledata->mod = $row : 0;
	  }

      /**
       * Blog::renderAuthorArticles()
       * 
       * @return
       */
      public function renderAuthorArticles()
      {
		  $author = sanitize(Registry::get("Content")->_url[2]);
		  
		  $pager = Paginator::instance();
		  $pager->items_total = countEntries(self::mTable);
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->path = Url::Blog("blog-author", $author, "?");
		  $pager->paginate();
		  
		  $sql = "SELECT a.*, c.id as cid, c.name".Lang::$lang." as catname, a.title".Lang::$lang." as atitle, c.slug as catslug, u.username, CONCAT(u.fname,' ',u.lname) as fullname,"
		  . "\n (SELECT COUNT(artid) FROM ".self::cmTable." WHERE artid = a.id) as totalcomments, YEAR(a.created) as year, MONTH(a.created) as month, DAY(a.created) as day"
		  . "\n FROM " . self::mTable . " as a" 
		  . "\n LEFT JOIN " . self::ctTable . " as c ON c.id = a.cid" 
		  . "\n LEFT JOIN " . Users::uTable . " as u ON u.id = a.uid" 
		  . "\n WHERE u.username = '" . self::$db->escape($author) . "'"
		  . "\n AND a.created <= NOW()"
		  . "\n AND (a.expire = '0000-00-00 00:00:00' OR a.expire >= NOW())"
		  . "\n AND a.active = 1"
		  . "\n ORDER BY a.created DESC" . $pager->limit;
          $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
      }
	  
	  /**
	   * Blog::renderRating()
	   *
	   * @param int $id
	   * @param int $ratingt
	   * @param int $ratingc
	   * @param int $class
	   * @return
	   */
	  public static function renderRating($id, $ratingt, $ratingc, $class = false)
	  {
		  if (isset($_COOKIE['RATE_BLG_TUBI_'])) {
			  if($_COOKIE['RATE_BLG_TUBI_'] == $id) {
				  self::getArticleRatingRead($ratingt, $ratingc, $class);
			  } else {
				  self::getArticleRating($id, $ratingt, $ratingc, $class);
			  }
		  } else {
			  if(Registry::get("Users")->logged_in) {
				  self::getArticleRating($id, $ratingt, $ratingc, $class);
			  } else {
				  self::getArticleRatingRead($ratingt, $ratingc, $class = true);
			  }
		  }
	
	  }

	  /**
	   * Blog::getProductRatingRead()
	   *
	   * @param int $ratingt
	   * @param int $ratingc
	   * @return
	   */
	  public static function getArticleRatingRead($ratingt, $ratingc)
	  {
		  $data = "<span class=\"tubi rating-read\">";
          $rating = ($ratingc == 0) ? 0 :  $ratingt/$ratingc;
		  $count = 5;
		  for ($i = 0; $i < 5; $i++) {
			  $j = $i + 1;
			  if ($i < floor($rating))
				  $cls = "rated";
			  else
				  $cls = "norate";
			  $data .= '<b class="' . $cls . '"></b>';
		  }
		  $data .= '<i>' . number_format($rating,1) . '</i>';
		  $data .= "</span>";
	
		  print $data;
	
	  }
	  
	  /**
	   * Blog::getArticleRating()
	   * 
	   * @param int $ratingt
	   * @param int $ratingc
	   * @param int $class
	   * @return
	   */
	  public static function getArticleRating($id, $ratingt, $ratingc, $class)
	  {
			$data = "<span class=\"tubi rating-vote $class\">";
			$rating = ($ratingc == 0) ? 0 :  $ratingt/$ratingc;
			$count = 5;
			for ($i = 0; $i < 5; $i++) {
				$j = $i + 1;
				if ($i < floor($rating))
					$cls = "rated";
				else
					$cls = "norate";
				$data .= '<b data-item="' . $id . '" data-rate="' . $j . '" class="' . $cls . '"></b>';
			}
			$data .= '<i>' . number_format($rating,1) . '</i>';
			$data .= "</span>";
	  
			print $data;
	  }
	  	  
	  /**
	   * Blog::doHits()
	   * 
	   * @return
	   */
	  public static function doHits($id)
	  {
		  
		  $data['hits'] = "INC(1)";
		  self::$db->update(self::mTable, $data, "id = ".(int)$id);
	  }
	  	  	  	  	  	  	  	  	  
	  /**
	   * Blog::processArticle()
	   * 
	   * @return
	   */
	  public function processArticle()
	  {
	
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_MOD_AM_NAME);
		  Filter::checkPost('cid', Lang::$word->_MOD_AM_CATEGORY);
		  Filter::checkPost('body' . Lang::$lang, Lang::$word->_MOD_AM_FULLDESC);

		  if (!Filter::$id) {
			  if (self::titleExists(sanitize($_POST['title' . Lang::$lang]))) {
				  Filter::$msgs['title' . Lang::$lang] = Lang::$word->_MOD_AM_NAME_R;
			  }
		  }
			  
		  if (!empty($_FILES['filename']['name'])) {
			  if (!preg_match("/(\.doc|\.pdf|\.zip|\.rar)$/i", $_FILES['filename']['name']))
				  Filter::$msgs['filename'] = Lang::$word->_MOD_AM_FILE_ATT_R;
		  }
	
		  if (!empty($_FILES['thumb']['name'])) {
			  if (!preg_match("/(\.jpg|\.png|\.gif|\.jpeg)$/i", $_FILES['thumb']['name']))
				  Filter::$msgs['thumb'] = Lang::$word->_MOD_AM_IMAGE_R;
		  }
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
				  'slug' => (empty($_POST['slug'])) ? doSeo($_POST['title' . Lang::$lang]) : doSeo($_POST['slug']),
				  'cid' => intval($_POST['cid'][0]),
				  'uid' => intval($_POST['uid']),
				  'created' => sanitize($_POST['created_submit']) . ' ' . sanitize($_POST['timeStart_submit']),
				  'expire' => sanitize($_POST['expire_submit']) . ' ' . sanitize($_POST['timeEnd_submit']),
				  'caption' . Lang::$lang => sanitize($_POST['caption' . Lang::$lang]),
				  'show_created' => intval($_POST['show_created']),
				  'show_sharing' => intval($_POST['show_sharing']),
				  'show_comments' => intval($_POST['show_comments']),
				  'show_ratings' => intval($_POST['show_ratings']),
				  'show_author' => intval($_POST['show_author']),
				  'show_like' => intval($_POST['show_like']),
				  'layout' => intval($_POST['layout']),
				  'active' => intval($_POST['active']),
				  'gallery' => intval($_POST['module_data']),
				  'short_desc' . Lang::$lang => sanitize($_POST['short_desc' . Lang::$lang]),
				  'body' . Lang::$lang => Filter::in_url($_POST['body' . Lang::$lang]),
				  'metakey' . Lang::$lang => sanitize($_POST['metakey' . Lang::$lang]),
				  'metadesc' . Lang::$lang => sanitize($_POST['metadesc' . Lang::$lang])
				  );
	
			  if (empty($_POST['metakey' . Lang::$lang]) or empty($_POST['metadesc' . Lang::$lang])) {
				  include (BASEPATH . 'lib/class_meta.php');
				  parseMeta::instance($_POST['body' . Lang::$lang]);
				  if (empty($_POST['metakey' . Lang::$lang])) {
					  $data['metakey' . Lang::$lang] = parseMeta::get_keywords();
				  }
				  if (empty($_POST['metadesc'])) {
					  $data['metadesc' . Lang::$lang] = parseMeta::metaText($_POST['body' . Lang::$lang]);
				  }
			  }
	
			  if (Filter::$id) {
				  $data['modified'] = "NOW()";
			  }
	
			  if (isset($_POST['membership_id'])) {
				  $data['membership_id'] = Core::_implodeFields($_POST['membership_id']);
			  } else
				  $data['membership_id'] = 0;
	
			  // Procces Image
			  if (!empty($_FILES['thumb']['name'])) {
				  $imgdir = BASEPATH . self::imagepath;
				  $newName = "IMG_" . randName();
				  $ext = substr($_FILES['thumb']['name'], strrpos($_FILES['thumb']['name'], '.') + 1);
				  $fullname = $imgdir . $newName . "." . strtolower($ext);
	
				  if (Filter::$id and $file = getValueById("thumb", self::mTable, Filter::$id)) {
					  @unlink($imgdir . $file);
				  }
	
				  if (!move_uploaded_file($_FILES['thumb']['tmp_name'], $fullname)) {
					  die(Filter::msgError(Lang::$word->_FILE_ERR, false));
				  }
				  $data['thumb'] = $newName . "." . strtolower($ext);
			  }
	
			  // Procces File
			  if (!empty($_FILES['filename']['name'])) {
				  $filedir = BASEPATH . self::filepath;
				  $newName = "FILE_" . randName();
				  $ext = substr($_FILES['filename']['name'], strrpos($_FILES['filename']['name'], '.') + 1);
				  $fullname = $filedir . $newName . "." . strtolower($ext);
	
				  if (Filter::$id and $file = getValueById("filename", self::mTable, Filter::$id)) {
					  @unlink($filedir . $file);
				  }
	
				  if (!move_uploaded_file($_FILES['filename']['tmp_name'], $fullname)) {
					  die(Filter::msgError(Lang::$word->_FILE_ERR, false));
				  }
				  $data['filename'] = $newName . "." . strtolower($ext);
			  }
	
	          if(isset($_POST['remfile']) and $_POST['remfile'] == 1) {
				  $data['filename'] = "NULL";
			  }
			  
			  (Filter::$id) ? self::$db->update(self::mTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::mTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_MOD_AM_AUPDATED : Lang::$word->_MOD_AM_AADDED;
	
	
			  if (self::$db->affected()) {
				  Security::writeLog($message, "", "no", "module");
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
			  } else {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
	
			  if (!empty($_FILES['filename']['name'])) {
			  if (Filter::$id) {
				  // Process Tags
				  $str_tags = trim(Filter::getPost('tags'), ',');
				  $arr = explode(',', $str_tags);
				  self::addTagsToBlog(Filter::$id, $arr);
	
				  // Process Categories
				  if (isset($_POST['cid'])) {
					  self::$db->delete(self::rTable, "aid = '" . Filter::$id . "'");
					  foreach ($_POST['cid'] as $cid) {
						  $cdata['aid'] = Filter::$id;
						  $cdata['cid'] = intval($cid);
						  self::$db->insert(self::rTable, $cdata);
					  }
				  }
			  } else {
				  // Process Tags
				  $str_tags = trim(Filter::getPost('tags'), ',');
				  $arr = explode(',', $str_tags);
				  self::addTagsToBlog($lastid, $arr);
	
				  // Process Categories
				  if (isset($_POST['cid'])) {
					  foreach ($_POST['cid'] as $cid) {
						  $cdata['aid'] = $lastid;
						  $cdata['cid'] = intval($cid);
						  self::$db->insert(self::rTable, $cdata);
					  }
				  }
			  }
			  }
			  
			  if (isset($_POST['is_user'])) {
				  $xdata['is_user'] = 0;
				  self::$db->update(self::mTable, $xdata, "id=" . Filter::$id);
				  
				  require_once (BASEPATH . "lib/class_mailer.php");
				  $usr = getValues("username, email", Users::uTable, "id = " . $data['uid']);

				  $body = str_replace(array(
					  '[USER]',
					  '[STATUS]',
					  '[URL]',
					  '[SITE_NAME]'), array(
					  $usr->username,
					  ($_POST['is_user'] == 1) ? Lang::$word->_MOD_AM_APPROVED1 : Lang::$word->_MOD_AM_REJECTED ,
					  SITEURL,
					  Registry::get("Core")->site_name), $this->notify_user_template);
	
				  $newbody = cleanOut($body);
				  
				  $mailer = Mailer::sendMail();
				  $message = Swift_Message::newInstance()
							->setSubject(Lang::$word->_MOD_AM_ADMSUBU)
							->setTo(array($usr->email => $usr->username))
							->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->site_name))
							->setBody($newbody, 'text/html');
	
				  $mailer->send($message);
			  }

		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

	  /**
	   * Blog::processUserArticle()
	   * 
	   * @return
	   */
	  public function processUserArticle()
	  {
		  
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_MOD_AM_NAME);
		  Filter::checkPost('cid', Lang::$word->_MOD_AM_CATEGORY);
		  Filter::checkPost('body' . Lang::$lang, Lang::$word->_MOD_AM_FULLDESC);

		  if (self::titleExists(sanitize($_POST['title' . Lang::$lang]))) {
			  Filter::$msgs['title' . Lang::$lang] = Lang::$word->_MOD_AM_NAME_R;
		  }
		  
		  if (!empty($_FILES['filename']['name'])) {
			  if (!preg_match("/(\.doc|\.pdf|\.zip|\.rar)$/i", $_FILES['filename']['name'])) {
				  Filter::$msgs['filename'] = Lang::$word->_MOD_AM_FILE_ATT_R;
			  }
			  if ($_FILES["filename"]["size"] > 3145728) {
				  Filter::$msgs['filename'] = Lang::$word->_MOD_AM_FILE_ATT_R2;
			  }
				  
		  }

		  if (!empty($_FILES['thumb']['name'])) {
			  if (!preg_match("/(\.jpg|\.png|\.gif|\.jpeg)$/i", $_FILES['thumb']['name'])) {
				  Filter::$msgs['thumb'] = Lang::$word->_MOD_AM_IMAGE_R;
			  }
			  if ($_FILES["thumb"]["size"] > 1048576) {
				  Filter::$msgs['thumb'] = Lang::$word->_MOD_AM_IMAGE_R1;
			  }
			  $file_info = getimagesize($_FILES['thumb']['tmp_name']);
			  if(empty($file_info))
				  Filter::$msgs['thumb'] = Lang::$word->_MOD_AM_IMAGE_R;
		  }

		  if (empty(Filter::$msgs)) {
			  $short = cleanOut($_POST['body' . Lang::$lang]);
			  $short = sanitize($short, 300);
			  $data = array(
				  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
				  'slug' => (empty($_POST['slug'])) ? doSeo($_POST['title' . Lang::$lang]) : doSeo($_POST['slug']),
				  'cid' => intval($_POST['cid'][0]),
				  'uid' => Registry::get("Users")->uid,
				  'created' => "NOW()",
				  'expire' => "DEFAULT(expire)",
				  'caption' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
				  'layout' => intval($_POST['layout']),
				  'active' => 0,
				  'gallery' => 0,
				  'is_user' => 1,
				  'short_desc' . Lang::$lang => $short,
				  'body' . Lang::$lang => $_POST['body' . Lang::$lang],
				  'metakey' . Lang::$lang => sanitize($_POST['metakey' . Lang::$lang]),
				  'metadesc' . Lang::$lang => sanitize($_POST['metadesc' . Lang::$lang])
				  );
				  
			  if (empty($_POST['metakey' . Lang::$lang]) or empty($_POST['metadesc' . Lang::$lang])) {
				  include (BASEPATH . 'lib/class_meta.php');
				  parseMeta::instance($_POST['body' . Lang::$lang]);
				  if (empty($_POST['metakey' . Lang::$lang])) {
					  $data['metakey' . Lang::$lang] = parseMeta::get_keywords();
				  }
				  if (empty($_POST['metadesc'])) {
					  $data['metadesc' . Lang::$lang] = parseMeta::metaText($_POST['body' . Lang::$lang]);
				  }
			  }

			  // Procces Image
			  if (!empty($_FILES['thumb']['name'])) {
				  $imgdir = BASEPATH . self::imagepath;
				  $newName = "IMG_" . randName();
				  $ext = substr($_FILES['thumb']['name'], strrpos($_FILES['thumb']['name'], '.') + 1);
				  $fullname = $imgdir . $newName . "." . strtolower($ext);
	
				  if (Filter::$id and $file = getValueById("thumb", self::mTable, Filter::$id)) {
					  @unlink($imgdir . $file);
				  }
	
				  if (!move_uploaded_file($_FILES['thumb']['tmp_name'], $fullname)) {
					  die(Filter::msgError(Lang::$word->_FILE_ERR, false));
				  }
				  $data['thumb'] = $newName . "." . strtolower($ext);
			  }

			  // Procces File
			  if (!empty($_FILES['filename']['name'])) {
				  $filedir = BASEPATH . self::filepath;
				  $newName = "FILE_" . randName();
				  $ext = substr($_FILES['filename']['name'], strrpos($_FILES['filename']['name'], '.') + 1);
				  $fullname = $filedir . $newName . "." . strtolower($ext);
	
				  if (Filter::$id and $file = getValueById("filename", self::mTable, Filter::$id)) {
					  @unlink($filedir . $file);
				  }
	
				  if (!move_uploaded_file($_FILES['filename']['tmp_name'], $fullname)) {
					  die(Filter::msgError(Lang::$word->_FILE_ERR, false));
				  }
				  $data['filename'] = $newName . "." . strtolower($ext);
			  }


              $lastid = self::$db->insert(self::mTable, $data);
			  
			  if (self::$db->affected()) {
				  Security::writeLog(Lang::$word->_MOD_AM_AADDED2, "", "no", "module");
				  $json['status'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_MOD_AM_AADDED2, false);
			  } else {
				  $json['status'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json); 

			  $adata = array(
				  'uid' => Registry::get("Users")->uid,
				  'url' => "blog/" . $data['slug'] . "/",
				  'icon' => "pencil",
				  'type' => "article",
				  'title' => $data['title' . Lang::$lang],
				  'subject' => Lang::$word->_PPF_ART_P,
				  'message' => $short,
				  'created' => "NOW()"
				  );
				  
			  $db->insert(Users::uaTable, $adata);
		  
			  // Process Tags
			  $str_tags = sanitize(Filter::getPost('tags'));
			  $str_tags = trim(Filter::getPost('tags'), ',');
			  $arr = explode(',', $str_tags);
			  self::addTagsToBlog($lastid, $arr);

			  // Process Categories
			  if (isset($_POST['cid'])) {
				  foreach ($_POST['cid'] as $cid) {
					  $cdata['aid'] = $lastid;
					  $cdata['cid'] = intval($cid);
					  self::$db->insert(self::rTable, $cdata);
				  }
			  }
			  
			  require_once (BASEPATH . "lib/class_mailer.php");

			  $newbody = cleanOut($this->notify_admin_template);

			  $mailer = Mailer::sendMail();
			  $message = Swift_Message::newInstance()
						->setSubject(Lang::$word->_MOD_AM_ADMSUB)
						->setTo(array(Registry::get("Core")->site_email =>Registry::get("Core")->site_name))
						->setFrom(array(Registry::get("Core")->site_email =>Registry::get("Core")->site_name))
						->setBody($newbody, 'text/html');

			  $mailer->send($message);
				  
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
	  
      /**
       * Blog::getMembershipAccess()
       * 
       * @param mixed $memid
       * @return
       */
	  public static function getMembershipAccess($memid)
	  {
	
		  $m_arr = explode(",", $memid);
		  reset($m_arr);
		  if ($memid > 0) {
			  if (Registry::get("Users")->logged_in and Registry::get("Users")->validateMembership() and in_array(Registry::get("Users")->membership_id, $m_arr)) {
				  return true;
			  } else
				  return false;
		  } else
			  return true;
	  }

      /**
       * Blog::listMemberships()
       * 
       * @param mixed $memid
       * @return
       */
	  public static function listMemberships($memid)
	  {
	
		  $data = self::$db->fetch_all("SELECT title" . Lang::$lang . " as mtitle FROM " . Membership::mTable . " WHERE id IN(" . $memid . ")");
		  if ($data) {
			  $display = ' ' . Lang::$word->_MOD_AM_MEMBREQ;
			  $display .= '<ul class="tubi numbered list">';
			  foreach ($data as $row) {
				  $display .= '<li>' . $row->mtitle . '</li>';
			  }
			  $display .= '</ul>';
			  return $display;
		  }
	
	  }
	  
	  /**
	   * Blog::getRatingInfo()
	   * 
	   * @return
	   */
	  public static function getRatingInfo($raterow, $totalrow)
	  {
		  return($raterow == 0 or $totalrow == 0) ? '0.0' : number_format($raterow / $totalrow, 1);
	  } 	

	  /**
	   * Blog::getArticleTags()
	   * 
	   * @param bool $pid
	   * @return
	   */
	  public function getArticleTags($tid)
	  {
		  $aid = ($tid) ? $tid :0;
		  
		  $sql = "SELECT GROUP_CONCAT(DISTINCT tagname" . Lang::$lang . ") as tags FROM " . self::tagTable . " WHERE id IN (" . $aid . ") ORDER BY tagname" . Lang::$lang;
		  $result = self::$db->first($sql);
		
		  return ($result) ? $result->tags: null;
	  }

	  /**
	   * Blog::getComments()
	   * 
	   * @return
	   */
	  public function getComments($from = false)
	  {

		  if (isset($_POST['fromdate_submit']) && $_POST['fromdate_submit'] <> "" || isset($from) && $from != '') {
			  $enddate = date("Y-m-d");
			  $fromdate = (empty($from)) ? $_POST['fromdate_submit'] : $from;
			  if (isset($_POST['enddate_submit']) && $_POST['enddate_submit'] <> "") {
				  $enddate = $_POST['enddate_submit'];
			  }
			  $where = " WHERE c.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
	
			  $q = "SELECT COUNT(*) FROM " . self::cmTable . " WHERE created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59' LIMIT 1";
			  $record = Registry::get("Database")->query($q);
			  $total = Registry::get("Database")->fetchrow($record);
			  $counter = $total[0];
		  } else {
			  $where = null;
			  $counter = countEntries(self::cmTable);
		  }
	  

		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();

          $sql = "SELECT c.*, c.id as cid, a.id as artid, a.title".Lang::$lang." as title"
		  . "\n FROM " . self::cmTable . " as c" 
		  . "\n LEFT JOIN " . self::mTable . " AS a ON a.id = c.artid"
		  . "\n " . $where . "" 
		  . "\n ORDER BY c.created " . $pager->limit;
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Blog::renderArchive()
	   * 
	   * @return
	   */
	  public function renderArchive()
	  {
	
		  $sql = "SELECT *, YEAR(created) AS year, DATE_FORMAT(created,'%m') AS month, COUNT(id) AS total" 
		  . "\n FROM " . self::mTable 
		  . "\n WHERE active = 1 OR (expire != '0000-00-00 00:00:00' OR expire >= NOW())" 
		  . "\n GROUP BY year DESC, month DESC";
		  $row = self::$db->fetch_all($sql);
	
		  return ($row) ? $row : 0;
	  }
	  
	  /**
	   * Blog::getShortMonths()
	   * @param mixed $month
	   * @return
	   */
	  public static function getShortMonths($month)
	  {
		  switch ($month) {
			  case 1:
				  $data = Lang::$word->_JA_;
				  break;
			  case 2:
				  $data = Lang::$word->_FE_;
				  break;
			  case 3:
				  $data = Lang::$word->_MA_;
				  break;
			  case 4:
				  $data = Lang::$word->_AP_;
				  break;
			  case 5:
				  $data = Lang::$word->_MY_;
				  break;
			  case 6:
				  $data = Lang::$word->_JU_;
				  break;
			  case 7:
				  $data = Lang::$word->_JL_;
				  break;
			  case 8:
				  $data = Lang::$word->_AU_;
				  break;
			  case 9:
				  $data = Lang::$word->_SE_;
				  break;
			  case 10:
				  $data = Lang::$word->_OC_;
				  break;
			  case 11:
				  $data = Lang::$word->_NO_;
				  break;
			  case 12:
				 $data = Lang::$word->_DE_;
				  break;
		  }
		  return @$data;
	  }
	  	  	  
      /**
       * Blog::getDateFormat()
       * 
       * @return
       */ 
	  public static function getDateFormat($selected = false)
	  {
		  $format = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') ? "%#d" : "%e";
		  $arr = array(
			  '%m-%d-%Y' => strftime('%m-%d-%Y') . ' (MM-DD-YYYY)',
			  $format . '-%m-%Y' => strftime($format . '-%m-%Y') . ' (D-MM-YYYY)',
			  '%m-' . $format . '-%y' => strftime('%m-' . $format . '-%y') . ' (MM-D-YY)',
			  $format . '-%m-%y' => strftime($format . '-%m-%y') . ' (D-MMM-YY)',
			  '%d %b %Y' => strftime('%d %b %Y'),
			  '%B %d, %Y %I:%M %p' => strftime('%B %d, %Y %I:%M %p'),
			  '%d %B %Y %I:%M %p' => strftime('%d %B %Y %I:%M %p'),
			  '%B %d, %Y' => strftime('%B %d, %Y'),
			  '%d %B, %Y' => strftime('%d %B, %Y'),
			  '%A %d %B %Y' => strftime('%A %d %B %Y'),
			  '%A %d %B %Y %H:%M' => strftime('%A %d %B %Y %H:%M'),
			  '%a %d, %B' => strftime('%a %d, %B'));
	
		  $html = '';
		  foreach ($arr as $key => $val) {
			  if ($key == $selected) {
				  $html .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
			  } else
				  $html .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $html;
	  }
	      	  	
      public static function addTagsToBlog($item_id, $data)
      {

          $data = array_filter(array_map('trim', $data));
          $item_id = intval($item_id);

          $all_tags = self::$db->fetch_all("SELECT tagname" . Lang::$lang . " FROM " . self::tagTable, true);
          $all_tag_names = Filter::multi_array_to_single_uniq($all_tags);
          $diff = array_diff($data, $all_tag_names);

          if ($diff) {
              $query = 'INSERT INTO ' . self::tagTable . ' (tagname' . Lang::$lang . ') 
					VALUES (\'' . implode('\'), (\'', $diff) . '\')';
              self::$db->query($query);
          }

          $query = 'SELECT id FROM ' . self::tagTable . ' WHERE tagname' . Lang::$lang . ' IN (\'' . implode('\',\'', $data) . '\')';
          $tags = self::$db->fetch_all($query, true);
          $values = Filter::multi_array_to_single_uniq($tags);

          $tdata['tags' . Lang::$lang] = Core::_implodeFields($values) ? Core::_implodeFields($values) : 0;

          self::$db->update(self::mTable, $tdata, "id = $item_id");
          self::$db->delete(self::tTable, "aid = $item_id");

		  $query2 = 'INSERT INTO ' . self::tTable . ' (aid, tid) VALUES (\'';
		  $vals = array();
  
          foreach($values as $val) {
			  $vals[] = (int)$item_id .'\', \''. (int)$val;
          }
  
		  $query2 .= implode('\'), (\'', $vals) .'\')';
		  self::$db->query($query2);
      }
	  
	  /**
	   * Blog::titleExists()
	   * 
	   * @param mixed $title
	   * @return
	   */
	  private static function titleExists($title)
	  {
		  
		  $sql = self::$db->query("SELECT title" . Lang::$lang
		  . "\n FROM " .self::mTable
		  . "\n WHERE title" . Lang::$lang . " = '" . sanitize($title) . "'" 
		  . "\n LIMIT 1");
		  
		  if (self::$db->numrows($sql) == 1) {
			  return true;
		  } else
			  return false;
	  }
	  
	  /**
	   * Blog::censored()
	   *
	   * @param mixed $string
	   * @return
	   */
	  public function censored($string)
	  {
		  $array = explode(",", $this->blacklist_words);
		  reset($array);
	
		  foreach ($array as $row) {
			  $string = preg_replace("`$row`", "***", $string);
		  }
		  unset($row);
		  return $string;
	  }
	  	  
	  /**
	   * Blog::keepTags()
	   *
	   * @param mixed $str
	   * @param mixed $tags
	   * @return
	   */
	  public static function keepTags($string, $allowtags = null, $allowattributes = null)
	  {
		  $string = strip_tags($string, $allowtags);
		  if (!is_null($allowattributes)) {
			  if (!is_array($allowattributes))
				  $allowattributes = explode(",", $allowattributes);
			  if (is_array($allowattributes))
				  $allowattributes = implode(")(?<!", $allowattributes);
			  if (strlen($allowattributes) > 0)
				  $allowattributes = "(?<!" . $allowattributes . ")";
			  $string = preg_replace_callback("/<[^>]*>/i", create_function('$matches', 'return preg_replace("/ [^ =]*' . $allowattributes . '=(\"[^\"]*\"|\'[^\']*\')/i", "", $matches[0]);'), $string);
		  }
		  return $string;
	  }  	
  }
?>