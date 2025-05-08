<?php
  /**
   * Slider
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: class_admin.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Slider
  {
      
	  const mTable = "plug_slider";
	  const imgPath = "plugins/slider/imgdata/";
	  private static $db;


      /**
       * Slider::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  self::$db = Registry::get("Database");
		  $this->getconfig();
      }

	  /**
	   * Slider::getconfig()
	   * 
	   * @return
	   */
	  private function getconfig()
	  {
		  
		  $row = INI::read(PLUGPATH . 'slider/config.ini');
		  
		  $this->sliderHeight = $row->sl_config->sliderHeight;
		  $this->sliderHeightAdaptable = $row->sl_config->sliderHeightAdaptable;
		  $this->sliderAutoPlay = $row->sl_config->sliderAutoPlay;
		  $this->waitForLoad = $row->sl_config->waitForLoad;
		  $this->slideTransition = $row->sl_config->slideTransition;
		  $this->slideTransitionDirection = $row->sl_config->slideTransitionDirection;
		  $this->slideTransitionSpeed = $row->sl_config->slideTransitionSpeed;
		  $this->slideTransitionDelay = $row->sl_config->slideTransitionDelay;
		  $this->slideTransitionEasing = $row->sl_config->slideTransitionEasing;
		  $this->slideImageScaleMode = $row->sl_config->slideImageScaleMode;
		  $this->slideShuffle = $row->sl_config->slideShuffle;
		  $this->slideReverse = $row->sl_config->slideReverse;
		  $this->showFilmstrip = $row->sl_config->showFilmstrip;
		  $this->showCaptions = $row->sl_config->showCaptions;
		  $this->simultaneousCaptions = $row->sl_config->simultaneousCaptions;
		  $this->showTimer = $row->sl_config->showTimer;
		  $this->showPause = $row->sl_config->showPause;
		  $this->showArrows = $row->sl_config->showArrows;
		  $this->showDots = $row->sl_config->showDots;
	
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Slider::getSliderImages()
	   * 
	   * @return
	   */
	  public function getSlides()
	  {
		  
		  $sql = "SELECT * FROM " . self::mTable . " ORDER BY position";
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
	  }
	  
	  /**
	   * Slider::processSlide()
	   * 
	   * @return
	   */
	  public function processSlide()
	  {
	
		  Filter::checkPost('title' . Lang::$lang, Lang::$word->_PLG_SL_CAPTION);

	
		  if (!empty($_FILES['thumb']['name'])) {
			  if (!preg_match("/(\.jpg|\.png)$/i", $_FILES['thumb']['name'])) {
				  Filter::$msgs['thumb'] = Lang::$word->_CG_LOGO_R;
			  }
			  $file_info = getimagesize($_FILES['thumb']['tmp_name']);
			  if (empty($file_info))
				  Filter::$msgs['thumb'] = Lang::$word->_CG_LOGO_R;
		  }
	
		  if (empty(Filter::$msgs)) {
			  $data['title' . Lang::$lang] = sanitize($_POST['title' . Lang::$lang]);
			  $data['body' . Lang::$lang] = sanitize($_POST['body' . Lang::$lang]);
			  $data['html'] = sanitize($_POST['html']);
	
			  if (isset($_POST['urltype']) && $_POST['urltype'] == "int" && isset($_POST['page_id'])) {
				  $slug = getValueByID("slug", Content::pTable, (int)$_POST['page_id']);
				  $data['url'] = $slug;
				  $data['urltype'] = "int";
				  $data['page_id'] = intval($_POST['page_id']);
			  } elseif (isset($_POST['urltype']) && $_POST['urltype'] == "ext" && isset($_POST['url'])) {
				  $data['url'] = sanitize($_POST['url']);
				  $data['urltype'] = "ext";
				  $data['page_id'] = "DEFAULT(page_id)";
			  } else {
				  $data['url'] = "#";
				  $data['urltype'] = "nourl";
				  $data['page_id'] = "DEFAULT(page_id)";
			  }
	
			  // Procces Image
			  if (!empty($_FILES['thumb']['name'])) {
				  $filedir = BASEPATH . self::imgPath;
				  $newName = "FILE_" . randName();
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
			  $message = (Filter::$id) ? Lang::$word->_PLG_SL_UPDATED : Lang::$word->_PLG_SL_ADDED;
	
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
	   * Slider::processConfig()
	   * 
	   * @return
	   */
	  public function processConfig()
	  {
		  
		  Filter::checkPost('slideTransition', Lang::$word->_PLG_SL_TRANS);
		  
		  if (empty(Filter::$msgs)) {
			  $data = array('sl_config' => array(
					  'sliderHeight' => intval($_POST['sliderHeight']),
					  'sliderHeightAdaptable' => intval($_POST['sliderHeightAdaptable']),
					  'sliderAutoPlay' => intval($_POST['sliderAutoPlay']),
					  'waitForLoad' => intval($_POST['waitForLoad']),
					  'slideTransition' => sanitize($_POST['slideTransition']),
					  'slideTransitionDirection' => sanitize($_POST['slideTransitionDirection']),
					  'slideTransitionSpeed' => intval($_POST['slideTransitionSpeed']),
					  'slideTransitionDelay' => intval($_POST['slideTransitionDelay']),
					  'slideTransitionEasing' => sanitize($_POST['slideTransitionEasing']),
					  'slideImageScaleMode' => sanitize($_POST['slideImageScaleMode']),
					  'slideShuffle' => intval($_POST['slideShuffle']),
					  'slideReverse' => intval($_POST['slideReverse']),
					  'showFilmstrip' => intval($_POST['showFilmstrip']),
					  'showCaptions' => intval($_POST['showCaptions']),
					  'simultaneousCaptions' => intval($_POST['simultaneousCaptions']),
					  'showTimer' => intval($_POST['showTimer']),
					  'showPause' => intval($_POST['showPause']),
					  'showArrows' => intval($_POST['showArrows']),
					  'showDots' => intval($_POST['showDots']),
					  ));
					  
			  if (INI::write(PLUGPATH . 'slider/config.ini', $data)) {
				  $json['type'] = 'success';
				  $json['message'] = Filter::msgOk(Lang::$word->_PLG_SL_CONF_UPDATED, false);
				  Security::writeLog(Lang::$word->_PLG_SL_CONF_UPDATED, "", "no", "plugin");
			  } else {
				  $json['type'] = 'info';
				  $json['message'] = Filter::msgAlert(Lang::$word->_PROCCESS_C_ERR . '{admin/plugins/slider/config.ini}', false);
			  }
			  print json_encode($json);
	
		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
	  }
 
	  /**
	   * Slider::updateOrder()
	   * 
	   * @return
	   */
	  public static function updateOrder()
	  {
		  	  
		  foreach ($_POST['node'] as $k => $v) {
			  $p = $k + 1;
			  $data['position'] = intval($p);
			  self::$db->update(self::mTable, $data, "id=" . (int)$v);
		  }
		  
	  }
  }
?>