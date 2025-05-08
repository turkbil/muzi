<?php
  /**
   * Gallery Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: class_admin.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Gallery
  {
	  
	  const mTable = "mod_gallery_images";
	  const cTable = "mod_gallery_config";
	  const galpath = "modules/gallery/galleries/";
	  const maxFile = 6291456;
	  private static $fileTypes = array("jpg","jpeg","png");
	  
	  private static $db;


      /**
       * Gallery::__construct()
       * 
       * @param bool $galid
       * @return
       */
      function __construct($galid = false)
      {
		  self::$db = Registry::get("Database");
		  $this->getConfig($galid);
      }

	  
	  /**
	   * Gallery::getConfig()
	   * 
	   * @param bool $galid
	   * @return
	   */
	  private function getConfig($galid = false)
	  {
		  $id = ($galid) ? $galid : Filter::$id;
		  $sql = "SELECT * FROM " . self::cTable . " WHERE id = '" . $id . "'";
          $row = Registry::get("Database")->first($sql);
          
		  if($row) {
			  $this->title = $row->{'title'.Lang::$lang};
			  $this->folder = $row->folder;
			  $this->cols = $row->cols;
			  $this->watermark = $row->watermark;
			  $this->like = $row->like;
			  $this->created = $row->created;
		  } else {
			  return false;
		  }
	  }

	  /**
	   * Gallery::getGalleries()
	   * 
	   * @return
	   */
	  public function getGalleries()
	  {
		  
		  $sql = "SELECT *, "
		  . "\n (SELECT COUNT(" . self::mTable . ".gallery_id) FROM " . self::mTable . " WHERE " . self::mTable . ".gallery_id = " . self::cTable . ".id) as totalpics"
		  . "\n FROM " . self::cTable
		  . "\n ORDER BY title".Lang::$lang;
          $row = Registry::get("Database")->fetch_all($sql);
          
		  return ($row) ? $row : 0;
	  }	

	  /**
	   * Gallery::getGalleryList()
	   * 
	   * @return
	   */
	  public function getGalleryList()
	  {
		  
		  $sql = "SELECT *"
		  . "\n FROM " . self::cTable
		  . "\n ORDER BY title".Lang::$lang;
          $row = Registry::get("Database")->fetch_all($sql);
          
		  return ($row) ? $row : 0;
	  }	
	  
	  /**
	   * Gallery::processGallery()
	   * 
	   * @return
	   */
	  public function processGallery()
	  {
	
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_MOD_GA_NAME);
		  Filter::checkPost('cols', Lang::$word->_MOD_GA_COLS);
	
		  if (empty(Filter::$msgs)) {
			  $data = array(
				  'title' . Lang::$lang => sanitize($_POST['title' . Lang::$lang]),
				  'cols' => intval($_POST['cols']),
				  'like' => intval($_POST['like']),
				  'watermark' => intval($_POST['watermark'])
				  );
			  
			  if (!Filter::$id) {
				  $data['folder'] = doSeo($_POST['title' . Lang::$lang]).'-'.rand(0,999);
				  $data['created'] = "NOW()";
			  }
	
			  (Filter::$id) ? self::$db->update(self::cTable, $data, "id='" . Filter::$id . "'") : self::$db->insert(self::cTable, $data);
			  $message = (Filter::$id) ? Lang::$word->_MOD_GA_UPDATED : Lang::$word->_MOD_GA_ADDED;
		
			  if (self::$db->affected()) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk($message, false);
				  Security::writeLog($message, "", "no", "content");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
			  }
			  print json_encode($json);
			  
			  if (!Filter::$id) {
				  if (!is_dir(BASEPATH . self::galpath . $data['folder']))
					  mkdir(BASEPATH . self::galpath . $data['folder']);
			  }	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }

	  /**
	   * Gallery::getGalleryImages()
	   * 
	   * @param bool $galid
	   * @return
	   */
	  public function getGalleryImages($galid = false)
	  {		  
		  $id = ($galid) ? $galid : Filter::$id;
		  
		  $sql = "SELECT * FROM " . self::mTable
		  . "\n WHERE gallery_id = '".(int)$id."'"
		  . "\n ORDER BY sorting";
          $row = Registry::get("Database")->fetch_all($sql);
          
		  return ($row) ? $row : 0;
	  }	

      /**
       * Gallery::doUpload()
       * 
       * @param mixed $filename
       * @return
       */
	  public static function doUpload($filename)
	  {
		  $path = BASEPATH . self::galpath . $_REQUEST['fdirectory'] . '/';
	
		  if (isset($_FILES[$filename]) && $_FILES[$filename]['error'] == 0) {
	
			  $extension = pathinfo($_FILES[$filename]['name'], PATHINFO_EXTENSION);
			  if (!in_array(strtolower($extension), self::$fileTypes)) {
				  $json['status'] = "error";
				  $json['msg'] = str_replace("[EXT]", $extension, Lang::$word->_FM_FILE_ERR5);
				  print json_encode($json);
				  exit;
			  }
	
			  if (file_exists($path . $_FILES[$filename]['name'])) {
				  $json['status'] = "error";
				  $json['msg'] = Lang::$word->_FM_FILE_ERR1;
				  print json_encode($json);
				  exit;
			  }
	
			  if (!is_writeable($path)) {
				  $json['status'] = "error";
				  $json['msg'] = Lang::$word->_FM_FILE_ERR2;
				  print json_encode($json);
				  exit;
			  }
	
			  if (!is_dir($path)) {
				  $json['status'] = "error";
				  $json['msg'] = Lang::$word->_FM_FILE_ERR4;
				  print json_encode($json);
				  exit;
			  }
	
			  if (self::maxFile != null && self::maxFile < $_FILES[$filename]['size']) {
				  $json['status'] = "error";
				  $json['msg'] = str_replace("[LIMIT]", getSize(self::maxFile), Lang::$word->_FM_FILE_ERR3);
				  print json_encode($json);
				  exit;
			  }
	
			  $newName = "IMG_" . randName();
			  $ext = substr($_FILES[$filename]['name'], strrpos($_FILES[$filename]['name'], '.') + 1);
			  $fullname = $path . $newName . "." . strtolower($ext);
	
	
			  if (move_uploaded_file($_FILES[$filename]['tmp_name'], $fullname)) {
	
				  $data = array(
					  'gallery_id' => Filter::$id,
					  'thumb' => $newName . "." . strtolower($ext),
					  'title' . Lang::$lang => "-/-",
					  'description' . Lang::$lang => "-/-"
					  );
	
				  $last_id = self::$db->insert(self::mTable, $data);
				  $url = SITEURL . '/' . Gallery::galpath . $_REQUEST["fdirectory"] . '/' . $data['thumb'];
	
				  $html = '
					  <div class="item"><a data-id="' . $last_id . '" data-name="-/-" class="imgdelete tubi top right negative corner label"><i class="icon remove sign"></i></a>
						<a href="' . $url . '" class="lightbox" title="-/-"> <img src="' . $url . '" alt="" class="tubi image"></a>
						<div class="tubi-content">
						  <div contenteditable="true" placeholder="' . Lang::$word->_MOD_GA_IMG_TITLE . '" data-path="false" data-edit-type="gallery" data-id="' . $last_id . '" data-key="title" class="tubi editable"></div>
						  <div class="tubi small divider"></div>
						  <div contenteditable="true" placeholder="' . Lang::$word->_MOD_GA_IMG_DESC . '" data-path="false" data-edit-type="gallery" data-id="' . $last_id . '" data-key="desc" class="tubi editable"></div>
						</div>
					  </div>';
	
				  $json['status'] = "success";
				  $json['msg'] = $html;
				  print json_encode($json);
				  exit;
			  }
		  }
	
		  $json['status'] = "error";
		  exit;
	  }
  }
?>