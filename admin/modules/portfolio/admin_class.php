<?php
  /**
   * Portfolio Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: class_admin.php, v4.00 2014-09-04 16:10:25 Nurullah Okatan
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Portfolio
  {

      const mTable = "mod_portfolio";
      const cTable = "mod_portfolio_category";
      const imagepath = "modules/portfolio/dataimages/";

      private static $db;


      /**
       * Portfolio::__construct()
       * 
       * @return
       */
      function __construct($item = false, $cat = false)
      {
          self::$db = Registry::get("Database");
          $this->getConfig();
          ($item) ? $this->renderSingleProduct() : null;
          ($cat) ? $this->renderSingleCategory() : null;

      }

      /**
       * Portfolio::getConfig()
       * 
       * @return
       */
      private function getConfig()
      {
          $row = INI::read(MODPATH . 'portfolio/config.ini');

          $this->cols = $row->pf_config->cols;
          $this->ipp = $row->pf_config->ipp;
          $this->fpp = $row->pf_config->fpp;

          return ($row) ? $row : 0;
      }

      /**
       * Portfolio::processConfig()
       * 
       * @return
       */
      public function processConfig()
      {
          Filter::checkPost('cols', Lang::$word->_MOD_PF_COLS);

          if (empty(Filter::$msgs)) {
              $data = array('pf_config' => array(
                      'cols' => intval($_POST['cols']),
                      'ipp' => intval($_POST['ipp']),
                      'fpp' => intval($_POST['fpp'])));

              if (INI::write(MODPATH . 'portfolio/config.ini', $data)) {
                  $json['type'] = 'success';
                  $json['message'] = Filter::msgOk(Lang::$word->_MOD_PF_CUPDATED, false);
                  Security::writeLog(Lang::$word->_MOD_PF_CUPDATED, "", "no", "module");
              } else {
                  $json['type'] = 'info';
                  $json['message'] = Filter::msgAlert(Lang::$word->_PROCCESS_C_ERR . '{admin/modules/portfolio/config.ini}', false);
              }
              print json_encode($json);

          } else {
              $json['message'] = Filter::msgStatus();
              print json_encode($json);
          }
      }

      /**
       * Portfolio::getPortfolio()
       * 
       * @return
       */
      public function getPortfolio()
      {

          if (isset($_GET['cid'])) {
              $where = "WHERE p.cid = '" . intval($_GET['cid']) . "'";
          } else {
              $where = null;
          }

          $sql = "SELECT p.*, c.id as cid, c.title" . Lang::$lang . " as catname" 
		  . "\n FROM " . self::mTable . " as p" 
		  . "\n LEFT JOIN " . self::cTable . " as c ON c.id = p.cid" 
		  . "\n $where" . "\n ORDER BY p.sorting";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Portfolio::renderPortfolio()
       * 
       * @return
       */
      public function renderPortfolio()
      {

          $pager = Paginator::instance();
          $pager->items_total = countEntries(self::mTable);
          $pager->default_ipp = $this->fpp;
          $pager->path = SITEURL . '/portfolio/?';
          $pager->paginate();

          $sql = "SELECT * FROM " . self::mTable 
          . "\n ORDER BY cid, title" . Lang::$lang . $pager->limit;
		  
          $row = self::$db->fetch_all($sql);
		  

          return ($row) ? $row : 0;
      }

      /**
       * Portfolio::renderCategory()
       * 
       * @return
       */

      public function renderCategory($cid)
      {

          $q = "SELECT COUNT(id) FROM " . self::mTable . " WHERE cid = " . intval($cid);
          $record = self::$db->query($q);
          $total = self::$db->fetchrow($record);
          $counter = $total[0];

          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = $this->ipp;
          $pager->path = Url::Portfolio("portfolio-cat", Registry::get("Content")->_url[2], "?");
          $pager->paginate();

          $sql = "SELECT p.*, c.id as cid, c.title" . Lang::$lang . " as catname" 
		  . "\n FROM " . self::mTable . " as p" 
		  . "\n LEFT JOIN " . self::cTable . " as c ON c.id = p.cid" 
		  . "\n WHERE cid = " . intval($cid) 
		  . "\n ORDER BY p.cid, p.title" . Lang::$lang . $pager->limit;
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Portfolio::renderSingleCategory()
       * 
       * @return
       */
      private function renderSingleCategory()
      {

          $sql = "SELECT * FROM " . self::cTable . " WHERE slug = '" . Registry::get("Content")->_url[2] . "'";
          $row = self::$db->first($sql);

          return ($row) ? Registry::get("Content")->moduledata->mod = $row : 0;

      }

      /**
       * Portfolio::renderSingleProduct()
       * 
       * @return
       */
      private function renderSingleProduct()
      {

          $sql = "SELECT * FROM " . self::mTable . " WHERE slug = '" . Registry::get("Content")->_url[1] . "'";
          $row = self::$db->first($sql);

          return ($row) ? Registry::get("Content")->moduledata->mod = $row : 0;

      }


      /**
       * Portfolio::processFolio()
       * 
       * @return
       */
      public function processFolio()
      {

          Filter::checkPost('title' . Lang::$lang, Lang::$word->_MOD_PF_NAME);
          Filter::checkPost('cid', Lang::$word->_MOD_PF_CATEGORY);

          if (!empty($_FILES['thumb']['name'])) {
              if (!preg_match("/(\.jpg|\.png|\.jpeg)$/i", $_FILES['thumb']['name'])) {
                  Filter::$msgs['thumb'] = Lang::$word->_CG_LOGO_R;
              }
              $file_info = getimagesize($_FILES['thumb']['tmp_name']);
              if (empty($file_info))
                  Filter::$msgs['thumb'] = Lang::$word->_CG_LOGO_R;
          }

          if (empty(Filter::$msgs)) {
              $data = array(
                  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
                  'slug' => (empty($_POST['slug'])) ? doSeo($_POST['title' . Lang::$lang]) : doSeo($_POST['slug']),
                  'cid' => intval($_POST['cid']),
                  'body' . Lang::$lang => Filter::in_url($_POST['body' . Lang::$lang]),
				  'metakey'.Lang::$lang => sanitize($_POST['metakey'.Lang::$lang]), 
				  'metadesc'.Lang::$lang => sanitize($_POST['metadesc'.Lang::$lang]), 
                  'created' => sanitize($_POST['created_submit']),
                  'gallery' => intval($_POST['module_data']),
                  'icon' => sanitize($_POST['icon']),
				  );

              if (!Filter::$id) {
                  $data['created'] = "NOW()";
              }

              if (empty($_POST['metakey' . Lang::$lang]) or empty($_POST['metadesc' . Lang::$lang])) {
                  include (BASEPATH . 'lib/class_meta.php');
                  parseMeta::instance($_POST['short_desc' . Lang::$lang]);
                  if (empty($_POST['metakey' . Lang::$lang])) {
                      $data['metakey' . Lang::$lang] = parseMeta::get_keywords();
                  }
                  if (empty($_POST['metadesc'])) {
                      $data['metadesc' . Lang::$lang] = parseMeta::metaText($_POST['short_desc' . Lang::$lang]);
                  }
              }

              // Procces Image
              if (!empty($_FILES['thumb']['name'])) {
                  $filedir = BASEPATH . self::imagepath;
                  $newName = "IMG_" . randName();
                  $ext = substr($_FILES['thumb']['name'], strrpos($_FILES['thumb']['name'], '.') + 1);
                  $fullname = $filedir . $newName . "." . strtolower($ext);

                  if (Filter::$id and $file = getValueById("thumb", self::mTable, Filter::$id)) {
                      @unlink($filedir . $file);
                  }

                  if (!move_uploaded_file($_FILES['thumb']['tmp_name'], $fullname)) {
                      die(Filter::msgError(Lang::$word->_FILE_ERR, false));
                  }
                  $data['thumb'] = $newName . "." . strtolower($ext);
              }

              (Filter::$id) ? self::$db->update(self::mTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::mTable, $data);
              $message = (Filter::$id) ? Lang::$word->_MOD_PF_PUPDATED : Lang::$word->_MOD_PF_PADDED;

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
       * Portfolio::getCategories()
       * 
       * @return
       */
      public function getCategories()
      {

          $sql = "SELECT * FROM " . self::cTable . "\n ORDER BY position";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Portfolio::processCategory()
       * 
       * @return
       */
      public function processCategory()
      {

          Filter::checkPost('title' . Lang::$lang, Lang::$word->_MOD_PF_CATNAME);

          if (empty(Filter::$msgs)) {
              $data = array(
                  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
                  'slug' => (empty($_POST['slug'])) ? doSeo($_POST['title' . Lang::$lang]) : doSeo($_POST['slug']),
                  'metakey' . Lang::$lang => sanitize($_POST['metakey' . Lang::$lang]),
                  'metadesc' . Lang::$lang => sanitize($_POST['metadesc' . Lang::$lang]),
                  );

              (Filter::$id) ? self::$db->update(self::cTable, $data, "id=" . Filter::$id) : $lastid = self::$db->insert(self::cTable, $data);
              $message = (Filter::$id) ? Lang::$word->_MOD_PF_CAUPDATED : Lang::$word->_MOD_PF_CAADDED;

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
       * Portfolio::updateOrder()
       * 
       * @return
       */
      public static function updateOrder()
      {
          foreach ($_POST['node'] as $k => $v) {
              $p = $k + 1;
              $data['position'] = intval($p);
              self::$db->update(self::cTable, $data, "id=" . (int)$v);
          }

      }
	  
      /**
       * Portfolio::updateProduct()
       * 
       * @return
       */
      public static function updateProduct()
      {
          foreach ($_POST['node'] as $k => $v) {
              $p = $k + 1;
              $data['sorting'] = intval($p);
              self::$db->update(self::mTable, $data, "id=" . (int)$v);
          }

      }

  
  }
?>