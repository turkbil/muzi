<?php
  /**
   * Language Class
   *
   * @yazilim Tubi Portal m2
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: class_language.php, v1.00 2012-03-05 10:12:05 Nurullah Okatan
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  final class Lang
  {
      const langdir = "lang/";
	  public static $language;
	  public static $word = array();
	  public static $lang;


      /**
       * Lang::__construct()
       * 
       * @return
       */
      public function __construct()
      {
		  self::get();
      }
	  
      /**
       * Lang::get()
       * 
       * @return
       */
	  private static function get()
	  {
		  if (isset($_COOKIE['LANG_TUBI'])) {
			  $sel_lang = sanitize($_COOKIE['LANG_TUBI'], 2);
			  $vlang = self::fetchLanguage($sel_lang);
			  if(in_array($sel_lang, $vlang)) {
				  Core::$language = $sel_lang;
			  } else {
				  Core::$language = Registry::get("Core")->lang;
			  }
			  if (file_exists(BASEPATH . self::langdir . Core::$language . "/lang.xml")) {
				  self::$word = self::set(BASEPATH . self::langdir . Core::$language . "/lang.xml", Core::$language);
			  } else {
				  self::$word = self::set(BASEPATH . self::langdir . Registry::get("Core")->lang . "/lang.xml", Registry::get("Core")->lang);
			  }
		  } else {
			  Core::$language = Registry::get("Core")->lang;
			  self::$word = self::set(BASEPATH . self::langdir . Registry::get("Core")->lang. "/lang.xml", Registry::get("Core")->lang);
			  
		  }
		  self::$lang = "_" . Core::$language;
		  return self::$word;
	  }

      /**
       * Lang::set()
       * 
       * @return
       */
	  public static function set($lang, $abbr)
	  {
		  $xmlel = simplexml_load_file($lang);
		  $countplugs = glob("" . BASEPATH . self::langdir . "$abbr/plugins/" . "*.lang.plugin.xml");
		  $totalplugs = count($countplugs);
		  $countmods = glob("" . BASEPATH . self::langdir . "$abbr/modules/" . "*.lang.module.xml");
		  $totalmods = count($countmods);
		  $data = new stdClass();
		  foreach ($xmlel as $pkey) {
			  $key = (string )$pkey['data'];
			  $data->$key = (string )str_replace(array('\'', '"'), array("&apos;", "&quot;"), $pkey);
		  }
		  if ($totalplugs) {
			  foreach ($countplugs as $val) {
				  $pxml = simplexml_load_file($val);
				  foreach ($pxml as $pkey) {
					  $key = (string )$pkey['data'];
					  $data->$key = (string )str_replace(array('\'', '"'), array("&apos;", "&quot;"), $pkey);
				  }
			  }
		  }

		  if ($totalmods) {
			  foreach ($countmods as $val1) {
				  $pxml = simplexml_load_file($val1);
				  foreach ($pxml as $pkey) {
					  $key = (string )$pkey['data'];
					  $data->$key = (string )str_replace(array('\'', '"'), array("&apos;", "&quot;"), $pkey);
				  }
			  }
		  }
		  
		  return $data;
	  }

      /**
       * Lang::langSwitch()
       * 
       * @return
       */
	  public static function langSwitch()
	  {
		  $plugins = Registry::get("Database")->fetch_all("SELECT plugalias, title" . self::$lang . " FROM " . Content::plTable . " WHERE system = 1 AND hasconfig = 1");
		  $modules = Registry::get("Database")->fetch_all("SELECT modalias, title" . self::$lang . " FROM " . Content::mdTable . " WHERE hasconfig = 1");
		  
		  $html = '';
		  $html .= '<select id="langchange" name="langswitch">';
		  
		  $html .= "<optgroup label=\"" . Lang::$word->_LA_MAIN . "\">\n";
		  $html .= "<option data-type=\"lang\" value=\"main\">-- " . Lang::$word->_LA_MAIN1 . "</option>\n";
		  
		  $html .= "<optgroup label=\"" . Lang::$word->_N_MODS . "\">\n";
		  if($modules) {
			  foreach ($modules as $mval) {
				  $html .= "<option data-type=\"modules/" . $mval->modalias . ".lang.module\" value=\"" . $mval->{'title' . self::$lang} . "\">-- " . $mval->{'title' . self::$lang} . "</option>\n";
			  }
		  }
		  $html .= "</optgroup>\n";
		  
		  $html .= "<optgroup label=\"" . Lang::$word->_N_PLUGS . "\">\n";
		  if($plugins) {
			  foreach ($plugins as $pval) {
				  $html .= "<option data-type=\"plugins/" . $pval->plugalias . ".lang.plugin\" value=\"" . $pval->{'title' . self::$lang} . "\">-- " . $pval->{'title' . self::$lang} . "</option>\n";
			  }
		  }
		  $html .= "</optgroup>\n";
		  
		  $html .= '</select>';
		  
		  return $html;
	  }
	  
	  	  
      /**
       * Lang::fetchLanguage()
       * 
       * @return
       */
	  public static function fetchLanguage()
	  {
		  $lang_array = '';
		  $directory = BASEPATH . Lang::langdir;
		  if (!is_dir($directory)) {
			  return false;
		  } else {
			  $lang_array = glob($directory . "*", GLOB_ONLYDIR);
			  $lang_array = str_replace($directory, "", $lang_array);
	
		  }
	
		  return $lang_array;
	  }
  }
?>