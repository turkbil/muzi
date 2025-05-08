<?php
  /**
   * Core Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: core_class.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Core
  {
      
	  const sTable = "settings";
	  const stTable = "stats";
	  const nTable = "notes";
	  
      public $year = null;
      public $month = null;
      public $day = null;
	  
      public static $language;
	  public $langlist;
	  
	  
      /**
       * Core::__construct()
       * 
       * @return
       */
      public function __construct()
      {
          $this->getSettings();
		  //$this->getLanguage();
		  
		  ($this->dtz) ? date_default_timezone_set($this->dtz) : date_default_timezone_set('GMT');
		  
          $this->year = (get('year')) ? get('year') : strftime('%Y');
          $this->month = (get('month')) ? get('month') : strftime('%m');
          $this->day = (get('day')) ? get('day') : strftime('%d');
          
          return mktime(0, 0, 0, $this->month, $this->day, $this->year);
      }
	
      /**
       * Core::getSettings()
       *
       * @return
       */
      private function getSettings()
      {
          $sql = "SELECT * FROM " . self::sTable;
          $row = Registry::get("Database")->first($sql);
          
          $this->site_name = cleanOut($row->site_name);
		  $this->company = cleanOut($row->company);
          $this->site_url = $row->site_url;
		  $this->site_dir = $row->site_dir;
		  $this->site_email = $row->site_email;
		  $this->telefon = $row->telefon;
		  $this->facebook = $row->facebook;
		  $this->twitter = $row->twitter;
		  $this->instagram = $row->instagram;
		  $this->linkedin = $row->linkedin;
		  $this->googleplus = $row->googleplus;
		  $this->foursquare = $row->foursquare;
		  $this->youtube = $row->youtube;
		  $this->pinterest = $row->pinterest;
		  $this->theme = $row->theme;
		  $this->theme_var = $row->theme_var;
		  $this->perpage = $row->perpage;
		  $this->backup = $row->backup;
		  $this->thumb_w = $row->thumb_w;
		  $this->thumb_h = $row->thumb_h;
		  $this->img_w = $row->img_w;
		  $this->img_h = $row->img_h;
		  $this->avatar_w = $row->avatar_w;
		  $this->avatar_h = $row->avatar_h;
		  $this->short_date = $row->short_date;
		  $this->long_date = $row->long_date;
		  $this->time_format = $row->time_format;
		  $this->dtz = $row->dtz;
		  $this->locale = $row->locale;
		  $this->weekstart = $row->weekstart;
		  $this->lang = $row->lang;
		  $this->show_lang = $row->show_lang;
		  $this->lang_dir = $row->langdir;
		  $this->eucookie = $row->eucookie;
		  $this->logo = $row->logo;
		  $this->showlogin = $row->showlogin;
		  $this->showsearch = $row->showsearch;
		  $this->showcrumbs = $row->showcrumbs;
		  $this->bgimg = $row->bgimg;
		  $this->repbg = $row->repbg;
		  $this->bgalign = $row->bgalign;
		  $this->bgfixed = $row->bgfixed;
		  $this->bgcolor = $row->bgcolor;
		  $this->currency = $row->currency;
		  $this->cur_symbol = $row->cur_symbol;
		  $this->tsep = $row->tsep;
		  $this->dsep = $row->dsep;
		  $this->offline = $row->offline;
		  $this->offline_msg = $row->offline_msg;
		  $this->offline_d = $row->offline_d;
		  $this->offline_t = $row->offline_t;
		  $this->reg_verify = $row->reg_verify;
		  $this->notify_admin = $row->notify_admin;
		  $this->auto_verify = $row->auto_verify;
		  $this->reg_allowed = $row->reg_allowed;
		  $this->user_limit = $row->user_limit;
		  $this->flood = $row->flood;
		  $this->attempt = $row->attempt;
		  $this->logging = $row->logging;
		  $this->editor = $row->editor;
		  $this->analytics = $row->analytics;
		  $this->login_page = $row->login_page;
		  $this->register_page = $row->register_page;
		  $this->sitemap_page = $row->sitemap_page;
		  $this->search_page = $row->search_page;
		  $this->activate_page = $row->activate_page;
		  $this->account_page = $row->account_page;
		  $this->profile_page = $row->profile_page;
          $this->metakeys = $row->metakeys;
          $this->metadesc = $row->metadesc;
		  $this->mailer = $row->mailer;
		  $this->smtp_host = $row->smtp_host;
		  $this->smtp_user = $row->smtp_user;
		  $this->smtp_pass = $row->smtp_pass;
		  $this->smtp_port = $row->smtp_port;
		  $this->is_ssl = $row->is_ssl;
		  $this->sendmail = $row->sendmail;
		  
		  $this->version = $row->version;

      }

	/**
	 * Core::processConfig()
	 * 
	 * @return
	 */
	public function processConfig()
	{
		Filter::checkPost('site_name', Lang::$word->_CG_SITENAME);
		Filter::checkPost('company', Lang::$word->_CG_COMPANY);
		Filter::checkPost('site_url', Lang::$word->_CG_WEBURL);
		Filter::checkPost('site_email', Lang::$word->_CG_WEBEMAIL);
		Filter::checkPost('thumb_w', Lang::$word->_CG_THUMB_WH);
		Filter::checkPost('thumb_h', Lang::$word->_CG_THUMB_WH);
		Filter::checkPost('img_w', Lang::$word->_CG_IMG_WH);
		Filter::checkPost('img_h', Lang::$word->_CG_IMG_WH);
		Filter::checkPost('avatar_w', Lang::$word->_CG_AVATAR_WH);
		Filter::checkPost('img_w', Lang::$word->_CG_AVATAR_WH);
		Filter::checkPost('currency', Lang::$word->_CG_CURRENCY);
		Filter::checkPost('theme', Lang::$word->_CG_THEME);
		
		switch($_POST['mailer']) {
			case "SMTP" :
				Filter::checkPost('smtp_host', Lang::$word->_CG_SMTP_HOST);
				Filter::checkPost('smtp_user', Lang::$word->_CG_SMTP_USER);
				Filter::checkPost('currency', Lang::$word->_CG_SMTP_PASS);
				Filter::checkPost('smtp_port', Lang::$word->_CG_SMTP_PORT);
				break;
			
			case "SMAIL" :
				Filter::checkPost('sendmail', Lang::$word->_CG_SMAILPATH);
			break;
		}
		
		if (empty(Filter::$msgs)) {
			$data = array(
					'site_name' => sanitize($_POST['site_name']), 
					'company' => sanitize($_POST['company']),
					'site_url' => sanitize($_POST['site_url']),
					'site_dir' => sanitize($_POST['site_dir']),
					'site_email' => sanitize($_POST['site_email']),
					'telefon' => sanitize($_POST['telefon']),
					'facebook' => sanitize($_POST['facebook']),
					'twitter' => sanitize($_POST['twitter']),
					'instagram' => sanitize($_POST['instagram']),
					'linkedin' => sanitize($_POST['linkedin']),
					'googleplus' => sanitize($_POST['googleplus']),
					'foursquare' => sanitize($_POST['foursquare']),
					'youtube' => sanitize($_POST['youtube']),
					'pinterest' => sanitize($_POST['pinterest']),
					'theme' => sanitize($_POST['theme']), 
					'theme_var' => isset($_POST['theme_var']) ? sanitize($_POST['theme_var']) : "NULL",
					'perpage' => intval($_POST['perpage']),
					'thumb_w' => intval($_POST['thumb_w']),
					'thumb_h' => intval($_POST['thumb_h']),
					'img_w' => intval($_POST['img_w']),
					'img_h' => intval($_POST['img_h']),
					'showlogin' => intval($_POST['showlogin']),
					'showsearch' => intval($_POST['showsearch']),
					'showcrumbs' => intval($_POST['showcrumbs']),
					'repbg' => intval($_POST['repbg']),
					'bgalign' => sanitize($_POST['bgalign']),
					'bgfixed' => intval($_POST['bgfixed']),
					//'bgcolor' => sanitize($_POST['bgcolor']),
					'avatar_w' => intval($_POST['avatar_w']),
					'avatar_h' => intval($_POST['avatar_h']),
					'short_date' => sanitize($_POST['short_date']),
					'long_date' => sanitize($_POST['long_date']),
					'time_format' => sanitize($_POST['time_format']),
					'dtz' => sanitize($_POST['dtz']),
					'locale' => sanitize($_POST['locale']),
					'weekstart' => intval($_POST['weekstart']),
					'lang' => sanitize($_POST['lang']),
					'show_lang' => intval($_POST['show_lang']),
					'langdir' => getValue("langdir", "language", "flag = '" . sanitize($_POST['lang']) . "'"),
					'eucookie' => intval($_POST['eucookie']),
					'currency' => sanitize($_POST['currency']),
					'cur_symbol' => sanitize($_POST['cur_symbol']),
					'dsep' => sanitize($_POST['dsep']),
					'tsep' => sanitize($_POST['tsep']),
					'offline' => intval($_POST['offline']),
					'offline_msg' => $_POST['offline_msg'],
					'offline_d' => isset($_POST['offline_d_submit']) && !empty($_POST['offline_d_submit']) ? sanitize($_POST['offline_d_submit']) : date('Y-m-d H:i:s'),
					'offline_t' => sanitize($_POST['offline_t_submit']),
					'reg_verify' => intval($_POST['reg_verify']),
					'auto_verify' => intval($_POST['auto_verify']),
					'reg_allowed' => intval($_POST['reg_allowed']),
					'notify_admin' => intval($_POST['notify_admin']),
					'user_limit' => intval($_POST['user_limit']),
					'flood' => intval($_POST['flood']),
					'logging' => intval($_POST['logging']),
					'attempt' => intval($_POST['attempt']),
					'analytics' => trim($_POST['analytics']),
					'editor' => intval($_POST['editor']),
					'metadesc' => trim($_POST['metadesc']),
					'metakeys' => trim($_POST['metakeys']),
					'mailer' => sanitize($_POST['mailer']),
					'sendmail' => sanitize($_POST['sendmail']),
					'smtp_host' => sanitize($_POST['smtp_host']),
					'smtp_user' => sanitize($_POST['smtp_user']),
					'smtp_pass' => sanitize($_POST['smtp_pass']),
					'smtp_port' => intval($_POST['smtp_port']),
					'is_ssl' => intval($_POST['is_ssl'])
			);

			if (isset($_POST['dellogo']) && $_POST['dellogo'] == 1) {
				$data['logo'] = "NULL";
			} elseif (!empty($_FILES['logo']['name'])) {
				if ($this->logo) {
					@unlink(UPLOADS . $this->logo);
				}
					move_uploaded_file($_FILES['logo']['tmp_name'], UPLOADS.$_FILES['logo']['name']);

				$data['logo'] = sanitize($_FILES['logo']['name']);
			} else {
				$data['logo'] = $this->logo;
			}

			if (isset($_POST['dellbgimg']) && $_POST['dellbgimg'] == 1) {
				$data['bgimg'] = "NULL";
			} elseif (!empty($_FILES['bgimg']['name'])) {
				if ($this->bgimg) {
					@unlink(BASEPATH . "theme/". $this->theme . "/images/" . $this->bgimg);
				}
					move_uploaded_file($_FILES['bgimg']['tmp_name'], BASEPATH . "theme/". $this->theme . "/images/" . $_FILES['bgimg']['name']);

				$data['bgimg'] = sanitize($_FILES['bgimg']['name']);
			} else {
				$data['bgimg'] = $this->bgimg;
			}
			
			Registry::get("Database")->update(self::sTable, $data);
			
			if (Registry::get("Database")->affected()) {
				$json['type'] = 'success';
				$json['message'] = Filter::msgOk(Lang::$word->_CG_UPDATED, false);
				// Log kaydı geçici olarak devre dışı bırakıldı
				// Security::writeLog("Sistem ayarları güncellendi", "system", "no", "config");
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
	   * Core:::renderThemeBg()
	   * 
	   * @return
	   */
	  public function renderThemeBg()
	  {
	
		  if (Registry::get("Content")->custom_bg) {
			  $css = '';
			  $css .= 'background-image: url(' . UPLOADURL . Registry::get("Content")->custom_bg . ');';
			  $css .= 'background-repeat:no-repeat;';
			  $css .= 'background-position:center top;';
			  $css .= 'background-attachment:fixed;';
			  $css .= 'background-size: cover;';
			  echo ' style="' . $css . '"';
		  } else {
			  $css = '';
			  $repeat = ($this->repbg) ? "repeat" : "no-repeat";
			  $attach = ($this->bgfixed) ? "fixed" : "scroll";
	
			  if ($this->bgimg) {
				  $css .= 'background-image: url(' . SITEURL . '/theme/' . $this->theme . '/images/' . $this->bgimg . ');';
				  $css .= 'background-repeat:' . $repeat . ';';
				  $css .= 'background-position:' . $this->bgalign . ' top;';
				  $css .= 'background-attachment:' . $attach . ';';
			  }
			  if ($this->bgcolor) {
				  $css .= 'background-color:' . $this->bgcolor . ';';
			  }
	
			  echo ' style="' . $css . '"';
	
		  }
	  }
	  
 
	  /**
	   * Core:::getLanguage()
	   * 
	   * @return
	   */
	   /*
	  private function getLanguage()
	  {
		  $this->langdir = BASEPATH . "lang/";
		  
		  if (isset($_COOKIE['LANG_TUBI'])) {
			  $sel_lang = sanitize($_COOKIE['LANG_TUBI'], 2);
			  if ($this->validLang($sel_lang)) {
				  $this->language = $sel_lang;
				  $this->lang_dir = getValue("langdir", "language", "flag = '" . $sel_lang . "'");
				  $this->dblang = ($sel_lang == $this->lang) ? "_" . $this->lang : "_" . $this->language;
			  } else {
				  $this->language = $this->lang;
				  $this->lang_dir = getValue("langdir", "language", "flag = '" . $this->lang . "'");
				  $this->dblang = ($this->language == $this->lang) ? "_" . $this->lang : "_" . $this->language;
			  }
			  if (file_exists($this->langdir . $this->language . ".lang.php")) {
				  include($this->langdir . $this->language . ".lang.php");
			  } else {
				  include($this->langdir . $this->lang . ".lang.php");
			  }
		  } else {
			  $this->language = $this->lang;
			  $this->lang_dir = getValue("langdir", "language", "flag = '" . $this->lang. "'");
			  $this->dblang = "_" . $this->language;
			  include($this->langdir . $this->lang . ".lang.php");
		  }
	  }
		*/		
	  /**
	   * Core:::langList()
	   * 
	   * @return
	   */
	  public  function langList()
	  {
		  
		  $sql = "SELECT * FROM " . Content::lgTable . " ORDER BY flag";
          $row = Registry::get("Database")->fetch_all($sql);
          
		  return ($row) ? $this->langlist = $row : 0;
	  }
 
 	  /**
	   * Core:::validLang()
	   * 
       * @param mixed $abbr
       * @return
       */

	  public function validLang($abbr)
	  {
	
		  $result = array();
		  foreach ($this->langList() as $val) {
			  if ($val->flag == $abbr) {
				  $result[] = $val;
			  }
		  }
		  return ($result) ? 1 : 0;
	
	  }

 	  /**
	   * Core:::langIcon()
	   * 
	   * @return
	   */
	  public static function langIcon()
	  {
		  return "<div class=\"tubi bottom right attached special label\">" . strtoupper(self::$language) . "</div>"; 
	  }
	  
      /**
       * Core::getThemeOptions()
       * 
       * @return
       */ 
	  public function getThemeOptions($themename)
	  {
		  $options = glob("" . BASEPATH . "/theme/" . $themename . "/skins/*.css");
	
		  $html = '';
		  if (!$options) {
			  print Lang::$word->_CG_THEME_VAR_N;
		  } else {
			  $html .= '<select name="theme_var">';
			  $html .= "<option value=\"\">" . Lang::$word->_CG_THEME_VAR_S . "</option>\n";
			  foreach ($options as $val) {
				  $newval = basename(stripExt($val));
				  if ($newval == $this->theme_var) {
					  $html .= "<option selected=\"selected\" value=\"" . $newval . "\">" . $newval . "</option>\n";
				  } else
					  $html .= "<option value=\"" . $newval . "\">" . $newval . "</option>\n";
			  }
			  $html .= '</select>';
			  unset($val);
			  return $html;
		  }
	  }
	    	  	   	  	  
      /**
       * Core::getShortDate()
       * 
       * @return
       */ 
      public static function getShortDate($selected = false)
	  {
	
		  $format = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') ? "%#d" : "%e";
	
          $arr = array(
				 '%m-%d-%Y' => strftime('%m-%d-%Y') . ' (MM-DD-YYYY)',
				 $format . '-%m-%Y' => strftime($format . '-%m-%Y') . ' (D-MM-YYYY)',
				 '%m-' . $format . '-%y' => strftime('%m-' . $format . '-%y') . ' (MM-D-YY)',
				 $format . '-%m-%y' => strftime($format . '-%m-%y') . ' (D-MMM-YY)',
				 '%d %b %Y' => strftime('%d %b %Y')
		  );
		  
		  $shortdate = '';
		  foreach ($arr as $key => $val) {
              if ($key == $selected) {
                  $shortdate .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $shortdate .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $shortdate;
      }
	  
      /**
       * Core::getLongDate()
       * 
       * @return
       */ 	
	  public static function getLongDate($selected = false)
	  {
		  $format = (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') ? "%#d" : "%e";
		  $arr = array(
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

      /**
       * Core::getTimeFormat()
       * 
       * @return
       */ 	  
      public static function getTimeFormat($selected = false)
	  {
          $arr = array(
				'%I:%M %p' => strftime('%I:%M %p'),
				'%I:%M %P' => strftime('%I:%M %P'),
				'%H:%M' => strftime('%H:%M'),
				'%k' => strftime('%k'),
		  );
		  
		  $longdate = '';
		  foreach ($arr as $key => $val) {
              if ($key == $selected) {
                  $longdate .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $longdate .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $longdate;
      }
	  
      /**
       * Core::monthList()
       * 
       * @return
       */ 	  
	  public static function monthList($list = true, $long = true, $selected = false)
	  {
		  $selected = is_null(get('month')) ? strftime('%m') : get('month');
	
		  if ($long) {
			  $arr = array(
				  '01' => Lang::$word->_JAN,
				  '02' => Lang::$word->_FEB,
				  '03' => Lang::$word->_MAR,
				  '04' => Lang::$word->_APR,
				  '05' => Lang::$word->_MAY,
				  '06' => Lang::$word->_JUN,
				  '07' => Lang::$word->_JUL,
				  '08' => Lang::$word->_AUG,
				  '09' => Lang::$word->_SEP,
				  '10' => Lang::$word->_OCT,
				  '11' => Lang::$word->_NOV,
				  '12' => Lang::$word->_DEC);
		  } else {
			  $arr = array(
				  '01' => Lang::$word->_JA_,
				  '02' => Lang::$word->_FE_,
				  '03' => Lang::$word->_MA_,
				  '04' => Lang::$word->_AP_,
				  '05' => Lang::$word->_MY_,
				  '06' => Lang::$word->_JU_,
				  '07' => Lang::$word->_JL_,
				  '08' => Lang::$word->_AU_,
				  '09' => Lang::$word->_SE_,
				  '10' => Lang::$word->_OC_,
				  '11' => Lang::$word->_NO_,
				  '12' => Lang::$word->_DE_);
		  }
		  $html = '';
		  if ($list) {
			  foreach ($arr as $key => $val) {
				  $html .= "<option value=\"$key\"";
				  $html .= ($key == $selected) ? ' selected="selected"' : '';
				  $html .= ">$val</option>\n";
			  }
		  } else {
			  $html .= '"' . implode('","', $arr) . '"';
		  }
		  unset($val);
		  return $html;
	  }

      /**
       * Core::weekList()
       * 
       * @return
       */ 	  
	  public static function weekList($list = true, $long = true, $selected = false)
	  {
		  if ($long) {
			  $arr = array(
				  '1' => Lang::$word->_SUNDAY,
				  '2' => Lang::$word->_MONDAY,
				  '3' => Lang::$word->_TUESDAY,
				  '4' => Lang::$word->_WEDNESDAY,
				  '5' => Lang::$word->_THURSDAY,
				  '6' => Lang::$word->_FRIDAY,
				  '7' => Lang::$word->_SATURDAY);
		  } else {
			  $arr = array(
				  '1' => Lang::$word->_SUN,
				  '2' => Lang::$word->_MON,
				  '3' => Lang::$word->_TUE,
				  '4' => Lang::$word->_WED,
				  '5' => Lang::$word->_THU,
				  '6' => Lang::$word->_FRI,
				  '7' => Lang::$word->_SAT);
		  }
	
		  $html = '';
		  if ($list) {
			  foreach ($arr as $key => $val) {
				  $html .= "<option value=\"$key\"";
				  $html .= ($key == $selected) ? ' selected="selected"' : '';
				  $html .= ">$val</option>\n";
			  }
		  } else {
			  $html .= '"' . implode('","', $arr) . '"';
		  }
	
		  unset($val);
		  return $html;
	  }
	  
      /**
       * Core::yearList()
	   *
       * @param mixed $start_year
       * @param mixed $end_year
       * @return
       */
	  function yearList($start_year, $end_year)
	  {
		  $selected = is_null(get('year')) ? date('Y') : get('year');
		  $r = range($start_year, $end_year);
		  
		  $select = '';
		  foreach ($r as $year) {
			  $select .= "<option value=\"$year\"";
			  $select .= ($year == $selected) ? ' selected="selected"' : '';
			  $select .= ">$year</option>\n";
		  }
		  return $select;
	  }
	  
      /**
       * Core::getStats()
       * 
       * @return
       */ 	  
      public function getStats()
	  {
          $sql = "SELECT SUM(pageviews) as views, SUM(uniquevisitors) as uniques,"
		  . "\n AVG(pageviews) as average, AVG(uniquevisitors) as uaverage FROM " . self::stTable 
		  . "\n GROUP BY YEAR(day)"; 
          
          $row = Registry::get("Database")->first($sql);
          
          return ($row) ? $row : 0;
      }


      /**
       * Core::getDigiShopStats()
       * 
       * @return
       */ 	  
      public function getDigiShopStats()
	  {
		  if (Registry::get("Database")->numrows(Registry::get("Database")->query("SHOW TABLES LIKE 'mod_digishop'"))) {
			  $row = Registry::get("Database")->first("SELECT SUM(price) as totalsale, AVG(price) as average" 
			  . "\n FROM mod_digishop_transactions" 
			  . "\n WHERE active = 1" 
			  . "\n AND status = 1");
		  } else {
			  $row = 0;
		  }
          
          return ($row) ? $row : 0;
      }
	  

      /**
       * Core::getBookingStats()
       * 
       * @return
       */ 	  
      public function getBookingStats()
	  {
		  if (Registry::get("Database")->numrows(Registry::get("Database")->query("SHOW TABLES LIKE 'mod_bookings'"))) {
			  $row = Registry::get("Database")->first("SELECT SUM(price) as totalsale, AVG(price) as average" 
			  . "\n FROM mod_bookings_transactions" 
			  . "\n WHERE active = 1" 
			  . "\n AND status = 1");
		  } else {
			  $row = 0;
		  }
          
          return ($row) ? $row : 0;
      }
	  
      /**
       * Core::totalMembershipIncome()
       * 
       * @return
       */
      public function totalMembershipIncome()
      {
          $sql = "SELECT SUM(rate_amount) as totalsale, AVG(rate_amount) as average"
		  . "\n FROM " . Membership::pTable
		  . "\n WHERE status = 1";
          $row = Registry::get("Database")->first($sql);
          
          return ($row) ? $row : 0;
      }

      /**
       * Core::totalMembershipIncome()
       * 
       * @return
       */
      public function getLatestUser()
      {
          $sql = "SELECT id, username, UNIX_TIMESTAMP(created) as cdate FROM " . Users::uTable
		  . "\n WHERE active = 'y' ORDER BY created DESC";
          $row = Registry::get("Database")->first($sql);
          
          return ($row) ? $row : 0;
      }
	  
      /**
       * Core::getNextEvent()
       * 
       * @return
       */ 	  
      public function getNextEvent()
	  {
          $sql = "SELECT id, title" . Lang::$lang . " as title, date_start, venue" . Lang::$lang . " as venue FROM mod_events"
		  . "\n WHERE date_start > NOW()" 
		  . "\n AND active = 1"; 
          
          $row = Registry::get("Database")->first($sql);
          
          return ($row) ? $row : 0;
      }

      /**
       * Core::getNotes()
       * 
       * @return
       */ 	  
      public function getNotes()
	  {
          $sql = "SELECT *, body_en as content, UNIX_TIMESTAMP(created) as cdate FROM " . self::nTable
		  . "\n ORDER BY created DESC"; 
          
          $row = Registry::get("Database")->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
      /**
       * Core::countEvents()
       * 
       * @return
       */
      public function countEvents()
      {
		  
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM mod_events"
		  . "\n WHERE YEAR(date_start) = " . date('Y')
		  . "\n AND MONTH(date_start) = " . date('m')
		  . "\n AND DAY(date_start) = " . date('d')
		  . "\n AND user_id = " . Registry::get("Users")->uid;
		  $row = Registry::get("Database")->first($sql);
		  
		  return ($row) ? $row->total : 0;

      }
	    
      /**
       * Core::getVisitors()
       * 
       * @return
       */
      public function getVisitors()
      {
          if (@getenv("HTTP_CLIENT_IP")) {
              $vInfo['ip'] = getenv("HTTP_CLIENT_IP");
          } elseif (@getenv("HTTP_X_FORWARDED_FOR")) {
              $vInfo['ip'] = getenv('HTTP_X_FORWARDED_FOR');
          } elseif (@getenv('REMOTE_ADDR')) {
              $vInfo['ip'] = getenv('REMOTE_ADDR');
          } elseif (isset($_SERVER['REMOTE_ADDR'])) {
              $vInfo['ip'] = $_SERVER['REMOTE_ADDR'];
          } else {
              $vInfo['ip'] = "Unknown";
          }

          if (!preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/i", $vInfo['ip']) &&
              $vInfo['ip'] != "Unknown") {
              $pos = strpos($vInfo['ip'], ",");
              $vInfo['ip'] = substr($vInfo['ip'], 0, $pos);
              if ($vInfo['ip'] == "")
                  $vInfo['ip'] = "Unknown";
          }

          $vInfo['ip'] = str_replace("[^0-9\.]", "", $vInfo['ip']);
          setcookie("TUBICMS_HITS", time(), time() + 3600);
          $vCookie['is_cookie'] = (isset($_COOKIE['TUBICMS_HITS'])) ? 1 : 0;
          $date = date('Y-m-d');

          if ($row = Registry::get("Database")->first("SELECT * FROM " . self::stTable . " WHERE DATE(day)='" . $date . "'")) {
              $hid = intval($row->id);
              $pageviews = $row->pageviews;
              $unique = $row->uniquevisitors;

              $stats['pageviews'] = "INC(1)";
              Registry::get("Database")->update(self::stTable, $stats, "id='" . $hid . "'");

              if (!isset($_COOKIE['TUBICMS_UNIQUE']) && $vCookie['is_cookie']) {
                  setcookie("TUBICMS_UNIQUE", time(), time() + 3600);
                  $stats['uniquevisitors'] = "INC(1)";
                  Registry::get("Database")->update(self::stTable, $stats, "id='" . $hid . "'");
              }
          } else {
              $istats = array(
                  'day' => "NOW()",
                  'pageviews' => 1,
                  'uniquevisitors' => 1,
              );
              Registry::get("Database")->insert(self::stTable, $istats);
          }
      }

      /**
       * Core::getTimezones()
       * 
       * @return
       */
	  public function getTimezones()
	  {
		  $data = '';
		  $tzone = DateTimeZone::listIdentifiers();
		  $data .='<select name="dtz" style="width:200px" class="custombox">';
		  foreach ($tzone as $zone) {
			  $selected = ($zone == $this->dtz) ? ' selected="selected"' : '';
			  $data .= '<option value="' . $zone . '"' . $selected . '>' . $zone . '</option>';
		  }
		  $data .='</select>';
		  return $data;
	  }

	  /**
	   * Core::formatMoney()
	   * 
	   * @param mixed $amount
	   * @return
	   */
	  public function formatMoney($amount, $free = true)
	  {
		  $word = ($free) ? Lang::$word->_FREE : '0.00';
		  return ($amount == 0) ? $word : $this->cur_symbol . number_format($amount, 2, $this->dsep, $this->tsep) . ' ' .$this->currency;
	  }

	  /**
	   * Core::in_url()
	   * 
	   * @param mixed $data
	   * @return
	   */
	  public function in_url($data)
	  {
          
		  return str_replace("../uploads/","uploads/",$data);  
	  }

	  /**
	   * Core::out_url()
	   * 
	   * @param mixed $data
	   * @return
	   */
	  public function out_url($data)
	  {
		  return  str_replace("uploads/","../uploads/",$data);  
	  }
	  				  
      /**
       * Core::getRowById()
       * 
       * @param mixed $table
       * @param mixed $id
       * @param bool $and
       * @param bool $is_admin
       * @return
       */
      public static function getRowById($table, $id, $and = false, $is_admin = true)
      {
          $id = sanitize($id, 8, true);
          if ($and) {
              $sql = "SELECT * FROM " . (string )$table . " WHERE id = '" . Registry::get("Database")->escape((int)$id) . "' AND " . Registry::get("Database")->escape($and) . "";
          } else
              $sql = "SELECT * FROM " . (string )$table . " WHERE id = '" . Registry::get("Database")->escape((int)$id) . "'";

          $row = Registry::get("Database")->first($sql);

          if ($row) {
              return $row;
          } else {
              if ($is_admin)
                  Filter::error("You have selected an Invalid Id - #" . $id, "Core::getRowById()");
          }
      }

      /**
       * Core::getRow()
       * 
       * @param mixed $table
       * @param mixed $where
	   * @param bool $is_admin
       * @return
       */
      public static function getRow($table, $where, $what, $is_admin = true)
      {
          $sql = "SELECT * FROM " . (string )$table . " WHERE $where = '" . $what . "'";
          $row = Registry::get("Database")->first($sql);

          if ($row) {
              return $row;
          } else {
              if ($is_admin)
                  Filter::error("You have selected an Invalid Value - #" . $what, "Core::getRow()");
          }
      }

      /**
       * Core::verifyTxnId()
       * 
       * @param mixed $txn_id
       * @return
       */
	  public static function verifyTxnId($txn_id)
	  {
	
		  $sql = Registry::get("Database")->query("SELECT id FROM " . Membership::pTable . " WHERE txn_id = '" . sanitize($txn_id) . "' LIMIT 1");
		  if (Registry::get("Database")->numrows($sql) > 0)
			  return false;
		  else
			  return true;
	  }
	     
      /**
       * Core::iconList()
       * 
	   * @param mixed $active
       * @return
       */
	  public static function iconList($active = false)
	  {
	
		  $arr = array(
			  'archive icon' => 'big archive icon',
			  'attachment icon' => 'big attachment icon',
			  'browser icon' => 'big browser icon',
			  'bug icon' => 'big bug icon',
			  'calendar icon' => 'big calendar icon',
			  'cart icon' => 'big cart icon',
			  'certificate icon' => 'big certificate icon',
			  'chat icon' => 'big chat icon',
			  'cloud icon' => 'big cloud icon',
			  'code icon' => 'big code icon',
			  'comment icon' => 'big comment icon',
			  'dashboard icon' => 'big dashboard icon',
			  'desktop icon' => 'big desktop icon',
			  'empty calendar icon' => 'big empty calendar icon',
			  'external url icon' => 'big external url icon',
			  'external url sign icon' => 'big external url sign icon',
			  'file icon' => 'big file icon',
			  'file outline icon' => 'big file outline icon',
			  'folder icon' => 'big folder icon',
			  'open folder icon' => 'big open folder icon',
			  'open folder outline icon' => 'big open folder outline icon',
			  'folder outline icon' => 'big folder outline icon',
			  'help icon' => 'big help icon',
			  'home icon' => 'big home icon',
			  'inbox icon' => 'big inbox icon',
			  'information icon' => 'big information icon',
			  'information letter icon' => 'big information letter icon',
			  'legal icon' => 'big legal icon',
			  'location arrow icon' => 'big location arrow icon',
			  'mail icon' => 'big mail icon',
			  'mail outline icon' => 'big mail outline icon',
			  'map icon' => 'big map icon',
			  'map marker icon' => 'big map marker icon',
			  'mobile icon' => 'big mobile icon',
			  'music icon' => 'big music icon',
			  'chat outline icon' => 'big chat outline icon',
			  'comment outline icon' => 'big comment outline icon',
			  'payment icon' => 'big payment icon',
			  'photo icon' => 'big photo icon',
			  'qr code icon' => 'big qr code icon',
			  'question icon' => 'big question icon',
			  'rss icon' => 'big rss icon',
			  'rss sign icon' => 'big rss sign icon',
			  'setting icon' => 'big setting icon',
			  'settings icon' => 'big settings icon',
			  'signal icon' => 'big signal icon',
			  'sitemap icon' => 'big sitemap icon',
			  'table icon' => 'big table icon',
			  'tablet icon' => 'big tablet icon',
			  'tag icon' => 'big tag icon',
			  'tags icon' => 'big tags icon',
			  'tasks icon' => 'big tasks icon',
			  'terminal icon' => 'big terminal icon',
			  'text file icon' => 'big text file icon',
			  'text file outline icon' => 'big text file outline icon',
			  'time icon' => 'big time icon',
			  'trash icon' => 'big trash icon',
			  'url icon' => 'big url icon',
			  'user icon' => 'big user icon',
			  'users icon' => 'big users icon',
			  'video icon' => 'big video icon',
			  'add icon' => 'big add icon',
			  'add sign icon' => 'big add sign icon',
			  'add sign box icon' => 'big add sign box icon',
			  'adjust icon' => 'big adjust icon',
			  'bookmark empty icon' => 'big bookmark empty icon',
			  'bookmark icon' => 'big bookmark icon',
			  'cloud download icon' => 'big cloud download icon',
			  'cloud upload icon' => 'big cloud upload icon',
			  'crop icon' => 'big crop icon',
			  'download disk icon' => 'big download disk icon',
			  'download icon' => 'big download icon',
			  'edit icon' => 'big edit icon',
			  'edit sign icon' => 'big edit sign icon',
			  'empty flag icon' => 'big empty flag icon',
			  'exchange icon' => 'big exchange icon',
			  'filter icon' => 'big filter icon',
			  'flag icon' => 'big flag icon',
			  'fork code icon' => 'big fork code icon',
			  'forward mail icon' => 'big forward mail icon',
			  'fullscreen icon' => 'big fullscreen icon',
			  'hide icon' => 'big hide icon',
			  'level down icon' => 'big level down icon',
			  'level up icon' => 'big level up icon',
			  'off icon' => 'big off icon',
			  'refresh icon' => 'big refresh icon',
			  'remove circle icon' => 'big remove circle icon',
			  'remove icon' => 'big remove icon',
			  'remove sign icon' => 'big remove sign icon',
			  'reorder icon' => 'big reorder icon',
			  'reply all mail icon' => 'big reply all mail icon',
			  'reply mail icon' => 'big reply mail icon',
			  'retweet icon' => 'big retweet icon',
			  'save icon' => 'big save icon',
			  'screenshot icon' => 'big screenshot icon',
			  'search icon' => 'big search icon',
			  'share icon' => 'big share icon',
			  'share sign icon' => 'big share sign icon',
			  'sign in icon' => 'big sign in icon',
			  'sign out icon' => 'big sign out icon',
			  'tint icon' => 'big tint icon',
			  'unhide icon' => 'big unhide icon',
			  'upload disk icon' => 'big upload disk icon',
			  'upload icon' => 'big upload icon',
			  'block layout icon' => 'big block layout icon',
			  'column layout icon' => 'big column layout icon',
			  'grid layout icon' => 'big grid layout icon',
			  'list layout icon' => 'big list layout icon',
			  'resize full icon' => 'big resize full icon',
			  'resize horizontal icon' => 'big resize horizontal icon',
			  'resize small icon' => 'big resize small icon',
			  'resize vertical icon' => 'big resize vertical icon',
			  'sort alphabet descending icon' => 'big sort alphabet descending icon',
			  'sort alphabet icon' => 'big sort alphabet icon',
			  'sort ascending icon' => 'big sort ascending icon',
			  'sort attributes descending icon' => 'big sort attributes descending icon',
			  'sort attributes icon' => 'big sort attributes icon',
			  'sort descending icon' => 'big sort descending icon',
			  'sort icon' => 'big sort icon',
			  'sort order descending icon' => 'big sort order descending icon',
			  'sort order icon' => 'big sort order icon',
			  'zoom in icon' => 'big zoom in icon',
			  'zoom out icon' => 'big zoom out icon',
			  'align center icon' => 'big align center icon',
			  'align justify icon' => 'big align justify icon',
			  'align left icon' => 'big align left icon',
			  'align right icon' => 'big align right icon',
			  'bold icon' => 'big bold icon',
			  'copy icon' => 'big copy icon',
			  'cut icon' => 'big cut icon',
			  'ellipsis horizontal icon' => 'big ellipsis horizontal icon',
			  'ellipsis vertical icon' => 'big ellipsis vertical icon',
			  'font icon' => 'big font icon',
			  'indent left icon' => 'big indent left icon',
			  'indent right icon' => 'big indent right icon',
			  'italic icon' => 'big italic icon',
			  'list icon' => 'big list icon',
			  'move icon' => 'big move icon',
			  'ordered list icon' => 'big ordered list icon',
			  'paste icon' => 'big paste icon',
			  'print icon' => 'big print icon',
			  'quote left icon' => 'big quote left icon',
			  'quote right icon' => 'big quote right icon',
			  'strikethrough icon' => 'big strikethrough icon',
			  'subscript icon' => 'big subscript icon',
			  'superscript icon' => 'big superscript icon',
			  'text height icon' => 'big text height icon',
			  'text width icon' => 'big text width icon',
			  'underline icon' => 'big underline icon',
			  'undo icon' => 'big undo icon',
			  'unlink icon' => 'big unlink icon',
			  'unordered list icon' => 'big unordered list icon',
			  'backward icon' => 'big backward icon',
			  'forward icon' => 'big forward icon',
			  'eject icon' => 'big eject icon',
			  'fast backward icon' => 'big fast backward icon',
			  'fast forward icon' => 'big fast forward icon',
			  'mute icon' => 'big mute icon',
			  'pause icon' => 'big pause icon',
			  'play circle icon' => 'big play circle icon',
			  'play icon' => 'big play icon',
			  'play sign icon' => 'big play sign icon',
			  'shuffle icon' => 'big shuffle icon',
			  'repeat icon' => 'big repeat icon',
			  'step backward icon' => 'big step backward icon',
			  'step forward icon' => 'big step forward icon',
			  'stop icon' => 'big stop icon',
			  'unmute icon' => 'big unmute icon',
			  'volume down icon' => 'big volume down icon',
			  'volume off icon' => 'big volume off icon',
			  'volume up icon' => 'big volume up icon',
			  'ambulance icon' => 'big ambulance icon',
			  'anchor icon' => 'big anchor icon',
			  'barcode icon' => 'big barcode icon',
			  'lab icon' => 'big lab icon',
			  'beer icon' => 'big beer icon',
			  'bell outline icon' => 'big bell outline icon',
			  'bolt icon' => 'big bolt icon',
			  'book icon' => 'big book icon',
			  'briefcase icon' => 'big briefcase icon',
			  'building icon' => 'big building icon',
			  'bullhorn icon' => 'big bullhorn icon',
			  'bullseye icon' => 'big bullseye icon',
			  'camera icon' => 'big camera icon',
			  'camera retro icon' => 'big camera retro icon',
			  'coffee icon' => 'big coffee icon',
			  'doctor icon' => 'big doctor icon',
			  'eraser icon' => 'big eraser icon',
			  'female icon' => 'big female icon',
			  'fighter jet icon' => 'big fighter jet icon',
			  'fire extinguisher icon' => 'big fire extinguisher icon',
			  'fire icon' => 'big fire icon',
			  'checkered flag icon' => 'big checkered flag icon',
			  'food icon' => 'big food icon',
			  'gamepad icon' => 'big gamepad icon',
			  'gift icon' => 'big gift icon',
			  'glass icon' => 'big glass icon',
			  'globe icon' => 'big globe icon',
			  'hdd icon' => 'big hdd icon',
			  'headphones icon' => 'big headphones icon',
			  'hospital icon' => 'big hospital icon',
			  'key icon' => 'big key icon',
			  'keyboard icon' => 'big keyboard icon',
			  'laptop icon' => 'big laptop icon',
			  'leaf icon' => 'big leaf icon',
			  'lemon icon' => 'big lemon icon',
			  'lightbulb icon' => 'big lightbulb icon',
			  'magic icon' => 'big magic icon',
			  'magnet icon' => 'big magnet icon',
			  'male icon' => 'big male icon',
			  'medkit icon' => 'big medkit icon',
			  'money icon' => 'big money icon',
			  'moon icon' => 'big moon icon',
			  'pencil icon' => 'big pencil icon',
			  'phone icon' => 'big phone icon',
			  'phone sign icon' => 'big phone sign icon',
			  'pin icon' => 'big pin icon',
			  'plane icon' => 'big plane icon',
			  'puzzle piece icon' => 'big puzzle piece icon',
			  'road icon' => 'big road icon',
			  'rocket icon' => 'big rocket icon',
			  'shield icon' => 'big shield icon',
			  'stethoscope icon' => 'big stethoscope icon',
			  'suitcase icon' => 'big suitcase icon',
			  'sun icon' => 'big sun icon',
			  'ticket icon' => 'big ticket icon',
			  'trophy icon' => 'big trophy icon',
			  'truck icon' => 'big truck icon',
			  'umbrella icon' => 'big umbrella icon',
			  'wrench icon' => 'big wrench icon',
			  'ban circle icon' => 'big ban circle icon',
			  'checkmark icon' => 'big checkmark icon',
			  'checkmark sign icon' => 'big checkmark sign icon',
			  'minus checkbox icon' => 'big minus checkbox icon',
			  'empty checkbox icon' => 'big empty checkbox icon',
			  'checked checkbox icon' => 'big checked checkbox icon',
			  'exclamation icon' => 'big exclamation icon',
			  'attention icon' => 'big attention icon',
			  'frown icon' => 'big frown icon',
			  'heart empty icon' => 'big heart empty icon',
			  'heart icon' => 'big heart icon',
			  'loading icon' => 'big loading icon',
			  'lock icon' => 'big lock icon',
			  'meh icon' => 'big meh icon',
			  'ok circle icon' => 'big ok circle icon',
			  'ok sign icon' => 'big ok sign icon',
			  'smile icon' => 'big smile icon',
			  'empty star icon' => 'big empty star icon',
			  'shalf empty star icon' => 'big shalf empty star icon',
			  'half star icon' => 'big half star icon',
			  'star icon' => 'big star icon',
			  'thumbs down icon' => 'big thumbs down icon',
			  'thumbs down outline icon' => 'big thumbs down outline icon',
			  'thumbs up icon' => 'big thumbs up icon',
			  'thumbs up outline icon' => 'big thumbs up outline icon',
			  'unlock alternate icon' => 'big unlock alternate icon',
			  'unlock icon' => 'big unlock icon',
			  'warn icon' => 'big warn icon',
			  'angle down icon' => 'big angle down icon',
			  'angle left icon' => 'big angle left icon',
			  'angle right icon' => 'big angle right icon',
			  'angle up icon' => 'big angle up icon',
			  'arrow box down icon' => 'big arrow box down icon',
			  'arrow box right icon' => 'big arrow box right icon',
			  'arrow box up icon' => 'big arrow box up icon',
			  'down icon' => 'big down icon',
			  'left icon' => 'big left icon',
			  'right icon' => 'big right icon',
			  'up icon' => 'big up icon',
			  'asterisk icon' => 'big asterisk icon',
			  'triangle down icon' => 'big triangle down icon',
			  'triangle left icon' => 'big triangle left icon',
			  'triangle right icon' => 'big triangle right icon',
			  'triangle up icon' => 'big triangle up icon',
			  'down arrow icon' => 'big down arrow icon',
			  'left arrow icon' => 'big left arrow icon',
			  'right arrow icon' => 'big right arrow icon',
			  'up arrow icon' => 'big up arrow icon',
			  'arrow sign down icon' => 'big arrow sign down icon',
			  'arrow sign left icon' => 'big arrow sign left icon',
			  'arrow sign right icon' => 'big arrow sign right icon',
			  'arrow sign up icon' => 'big arrow sign up icon',
			  'circle left icon' => 'big circle left icon',
			  'circle right icon' => 'big circle right icon',
			  'circle up icon' => 'big circle up icon',
			  'circle down icon' => 'big circle down icon',
			  'circle blank icon' => 'big circle blank icon',
			  'circle icon' => 'big circle icon',
			  'double angle down icon' => 'big double angle down icon',
			  'double angle left icon' => 'big double angle left icon',
			  'double angle right icon' => 'big double angle right icon',
			  'double angle up icon' => 'big double angle up icon',
			  'hand down icon' => 'big hand down icon',
			  'hand left icon' => 'big hand left icon',
			  'hand right icon' => 'big hand right icon',
			  'hand up icon' => 'big hand up icon',
			  'long arrow down icon' => 'big long arrow down icon',
			  'long arrow left icon' => 'big long arrow left icon',
			  'long arrow right icon' => 'big long arrow right icon',
			  'long arrow up icon' => 'big long arrow up icon',
			  'minus icon' => 'big minus icon',
			  'minus sign alternate icon' => 'big minus sign alternate icon',
			  'minus sign icon' => 'big minus sign icon',
			  'sign icon' => 'big sign icon',
			  'dollar icon' => 'big dollar icon',
			  'euro icon' => 'big euro icon',
			  'pound icon' => 'big pound icon',
			  'rupee icon' => 'big rupee icon',
			  'won icon' => 'big won icon',
			  'yen icon' => 'big yen icon',
			  'adn icon' => 'big adn icon',
			  'android icon' => 'big android icon',
			  'apple icon' => 'big apple icon',
			  'bitbucket icon' => 'big bitbucket icon',
			  'bitbucket sign icon' => 'big bitbucket sign icon',
			  'bitcoin icon' => 'big bitcoin icon',
			  'css3 icon' => 'big css3 icon',
			  'dribbble icon' => 'big dribbble icon',
			  'dropbox icon' => 'big dropbox icon',
			  'facebook icon' => 'big facebook icon',
			  'facebook sign icon' => 'big facebook sign icon',
			  'facetime video icon' => 'big facetime video icon',
			  'flickr icon' => 'big flickr icon',
			  'foursquare icon' => 'big foursquare icon',
			  'github alternate icon' => 'big github alternate icon',
			  'github icon' => 'big github icon',
			  'github sign icon' => 'big github sign icon',
			  'gittip icon' => 'big gittip icon',
			  'google plus icon' => 'big google plus icon',
			  'google plus sign icon' => 'big google plus sign icon',
			  'h sign icon' => 'big h sign icon',
			  'html5 icon' => 'big html5 icon',
			  'instagram icon' => 'big instagram icon',
			  'linkedin icon' => 'big linkedin icon',
			  'linkedin sign icon' => 'big linkedin sign icon',
			  'linux icon' => 'big linux icon',
			  'maxcdn icon' => 'big maxcdn icon',
			  'pinterest icon' => 'big pinterest icon',
			  'pinterest sign icon' => 'big pinterest sign icon',
			  'renren icon' => 'big renren icon',
			  'skype icon' => 'big skype icon',
			  'stackexchange icon' => 'big stackexchange icon',
			  'trello icon' => 'big trello icon',
			  'tumblr icon' => 'big tumblr icon',
			  'tumblr sign icon' => 'big tumblr sign icon',
			  'twitter icon' => 'big twitter icon',
			  'twitter sign icon' => 'big twitter sign icon',
			  'vk icon' => 'big vk icon',
			  'weibo icon' => 'big weibo icon',
			  'windows icon' => 'big windows icon',
			  'xing icon' => 'big xing icon',
			  'xing sign icon' => 'big xing sign icon',
			  'youtube icon' => 'big youtube icon',
			  'youtube play icon' => 'big youtube play icon',
			  'youtube sign icon' => 'big youtube sign icon',
			  'cab icon' => 'big cab icon',
			  'space shuttle icon' => 'big space shuttle icon',
			  'slack icon' => 'big slack icon',
			  'envelope icon' => 'big envelope icon',
			  'wordpress icon' => 'big wordpress icon',
			  'bank icon' => 'big bank icon',
			  'graduation icon' => 'big graduation icon',
			  'google icon' => 'big google icon',
			  'reddit icon' => 'big reddit icon',
			  'reddit square icon' => 'big reddit square icon',
			  'stumbleupon circle icon' => 'big stumbleupon circle icon',
			  'stumbleupon icon' => 'big stumbleupon icon',
			  'delicious icon' => 'big delicious icon',
			  'digg icon' => 'big digg icon',
			  'history icon' => 'big history icon',
			  'circle thin icon' => 'big circle thin icon',
			  'header icon' => 'big header icon',
			  'paragraph icon' => 'big paragraph icon',
			  'sliders icon' => 'big sliders icon',
			  'drupal icon' => 'big drupal icon',
			  'joomla icon' => 'big joomla icon',
			  'language icon' => 'big language icon',
			  'fax icon' => 'big fax icon',
			  'building icon' => 'big building icon',
			  'child icon' => 'big child icon',
			  'paw icon' => 'big paw icon',
			  'spoon icon' => 'big spoon icon',
			  'cube icon' => 'big cube icon',
			  'cubes icon' => 'big cubes icon',
			  'behance icon' => 'big behance icon',
			  'behance square icon' => 'big behance square icon',
			  'steam icon' => 'big steam icon',
			  'steam square icon' => 'big steam square icon',
			  'recycle icon' => 'big recycle icon',
			  'tree icon' => 'big tree icon',
			  'spotify icon' => 'big spotify icon',
			  'deviantart icon' => 'big deviantart icon',
			  'soundcloud icon' => 'big soundcloud icon',
			  'database icon' => 'big database icon',
			  'ra icon' => 'big ra icon',
			  'ge icon' => 'big ge icon',
			  'git icon' => 'big git icon',
			  'git square icon' => 'big git square icon',
			  'hacker news icon' => 'big hacker news icon',
			  'weibo icon' => 'big weibo icon',
			  'qq icon' => 'big qq icon',
			  'wechat icon' => 'big wechat icon',
			  'send icon' => 'big send icon',
			  'send outline icon' => 'big send outline icon',
			  'pdf outline icon' => 'big pdf outline icon',
			  'word outline icon' => 'big word outline icon',
			  'excel outline icon' => 'big excel outline icon',
			  'powerpoint outline icon' => 'big powerpoint outline icon',
			  'photo outline icon' => 'big photo outline icon',
			  'zip outline icon' => 'big zip outline icon',
			  'audio outline icon' => 'big audio outline icon',
			  'movie outline icon' => 'big movie outline icon',
			  'code outline icon' => 'big code outline icon',
			  'vine outline icon' => 'big vine outline icon',
			  'plus outline icon' => 'big plus outline icon',
			  'codepen outline icon' => 'big codepen outline icon',
			  'jsfiddle icon' => 'big jsfiddle icon',
			  'pied piper icon' => 'big pied piper icon',
			  'pied piper alt icon' => 'big pied piper alt icon',
			  'support icon' => 'big support icon',
			  'circle notch icon' => 'big circle notch icon',
			  'share alt icon' => 'big share alt icon',
			  'share alt square icon' => 'big share alt square icon',
			  'share bomb icon' => 'big share bomb icon',
			  'angellist icon' => 'big angellist icon',
			  'bell slash icon' => 'big bell slash icon',
			  'bus icon' => 'big bus icon',
			  'visa icon' => 'big visa icon',
			  'google wallet icon' => 'big google wallet icon',
			  'lastfm square icon' => 'big lastfm square icon',
			  'paint brush icon' => 'big paint brush icon',
			  'ils icon' => 'big ils icon',
			  'toggle off icon' => 'big toggle off icon',
			  'toggle on icon' => 'big toggle on icon',
			  'twitch icon' => 'big twitch icon',
			  'bicycle icon' => 'big bicycle icon',
			  'discover icon' => 'big discover icon',
			  'area chart icon' => 'big area chart icon',
			  'calculator icon' => 'big calculator icon',
			  'mastercard icon' => 'big mastercard icon',
			  'copyright icon' => 'big copyright icon',
			  'line chart icon' => 'big line chart icon',
			  'wifi icon' => 'big wifi icon',
			  'paypal icon' => 'big paypal icon',
			  'paypal card icon' => 'big paypal card icon',
			  'at icon' => 'big at icon',
			  'binoculars icon' => 'big binoculars icon',
			  'cc icon' => 'big cc icon',
			  'eyedropper icon' => 'big eyedropper icon',
			  'ioxhost icon' => 'big ioxhost icon',
			  'meanpath icon' => 'big meanpath icon',
			  'pie chart icon' => 'big pie chart icon',
			  'slideshare icon' => 'big slideshare icon',
			  'yelp icon' => 'big yelp icon',
			  'bell slash outline icon' => 'big bell slash outline icon',
			  'birthday cake icon' => 'big birthday cake icon',
			  'amex card icon' => 'big amex card icon',
			  'stripe icon' => 'big stripe icon',
			  'futbol icon' => 'big futbol icon',
			  'futbol outline icon' => 'big futbol outline icon',
			  'lastfm icon' => 'big lastfm icon',
			  'newspaper icon' => 'big newspaper icon',
			  'tty icon' => 'big tty icon',
			);
	
	
		  $html = '';
		  ksort($arr);
		  foreach ($arr as $key => $val) {
			  $html .= "<i data-icon-name=\"$key\" class=\"";
			  $html .= ($key == $active) ? 'active ' : '';
			  $html .= $val . "\"></i>\n";
		  }
		  unset($val);
		  return $html;
	  }

      /**
       * Core::setLocalet()
       * 
       * @return
       */
	  public function setLocale()
	  {
		  return explode(',', $this->locale);
	  }
	  
      /**
       * Core::getlocaleList()
       * 
       * @return
       */
      public function getlocaleList()
      {
          $html = '';
          foreach (self::localeList() as $key => $val) {
              if ($key == $this->locale) {
                  $html .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $html .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $html;
      }

      /**
       * Core::localeList()
       * 
       * @return
       */
	  public static function localeList()
	  {
	
		  $lang = array(
			  "af_utf8,Afrikaans,af_ZA.UTF-8,Afrikaans_South Africa.1252,WINDOWS-1252" => "Afrikaans",
			  "sq_utf8,Albanian,sq_AL.UTF-8,Albanian_Albania.1250,WINDOWS-1250" => "Albanian",
			  "ar_utf8,Arabic,ar_SA.UTF-8,Arabic_Saudi Arabia.1256,WINDOWS-1256" => "Arabic",
			  "eu_utf8,Basque,eu_ES.UTF-8,Basque_Spain.1252,WINDOWS-1252" => "Basque",
			  "be_utf8,Belarusian,be_BY.UTF-8,Belarusian_Belarus.1251,WINDOWS-1251" => "Belarusian",
			  "bs_utf8,Bosnian,bs_BA.UTF-8,Serbian (Latin),WINDOWS-1250" => "Bosnian",
			  "bg_utf8,Bulgarian,bg_BG.UTF-8,Bulgarian_Bulgaria.1251,WINDOWS-1251" => "Bulgarian",
			  "ca_utf8,Catalan,ca_ES.UTF-8,Catalan_Spain.1252,WINDOWS-1252" => "Catalan",
			  "hr_utf8,Croatian,hr_HR.UTF-8,Croatian_Croatia.1250,WINDOWS-1250" => "Croatian",
			  "zh_cn_utf8,Chinese (Simplified),zh_CN.UTF-8,Chinese_China.936" => "Chinese (Simplified)",
			  "zh_tw_utf8,Chinese (Traditional),zh_TW.UTF-8,Chinese_Taiwan.950" => "Chinese (Traditional)",
			  "cs_utf8,Czech,cs_CZ.UTF-8,Czech_Czech Republic.1250,WINDOWS-1250" => "Czech",
			  "da_utf8,Danish,da_DK.UTF-8,Danish_Denmark.1252,WINDOWS-1252" => "Danish",
			  "nl_utf8,Dutch,nl_NL.UTF-8,Dutch_Netherlands.1252,WINDOWS-1252" => "Dutch",
			  "en_utf8,English,en.UTF-8,English_Australia.1252," => "English(Australia)",
			  "en_us_utf8,English (US)" => "English",
			  "et_utf8,Estonian,et_EE.UTF-8,Estonian_Estonia.1257,WINDOWS-1257" => "Estonian",
			  "fa_utf8,Farsi,fa_IR.UTF-8,Farsi_Iran.1256,WINDOWS-1256" => "Farsi",
			  "fil_utf8,Filipino,ph_PH.UTF-8,Filipino_Philippines.1252,WINDOWS-1252" => "Filipino",
			  "fi_utf8,Finnish,fi_FI.UTF-8,Finnish_Finland.1252,WINDOWS-1252" => "Finnish",
			  "fr_utf8,French,fr_FR.UTF-8,French_France.1252,WINDOWS-1252" => "French",
			  "fr_ca_utf8,French (Canada),fr_FR.UTF-8,French_Canada.1252" => "French (Canada)",
			  "ga_utf8,Gaelic,ga.UTF-8,Gaelic; Scottish Gaelic,WINDOWS-1252" => "Gaelic",
			  "gl_utf8,Gallego,gl_ES.UTF-8,Galician_Spain.1252,WINDOWS-1252" => "Gallego",
			  "ka_utf8,Georgian,ka_GE.UTF-8,Georgian_Georgia.65001" => "Georgian",
			  "de_utf8,German,de_DE.UTF-8,German_Germany.1252,WINDOWS-1252" => "German",
			  "el_utf8,Greek,el_GR.UTF-8,Greek_Greece.1253,WINDOWS-1253" => "Greek",
			  "gu_utf8,Gujarati,gu.UTF-8,Gujarati_India.0" => "Gujarati",
			  "he_utf8,Hebrew,he_IL.utf8,Hebrew_Israel.1255,WINDOWS-1255" => "Hebrew",
			  "hi_utf8,Hindi,hi_IN.UTF-8,Hindi.65001" => "Hindi",
			  "hu_utf8,Hungarian,hu.UTF-8,Hungarian_Hungary.1250,WINDOWS-1250" => "Hungarian",
			  "is_utf8,Icelandic,is_IS.UTF-8,Icelandic_Iceland.1252,WINDOWS-1252" => "Indonesian",
			  "id_utf8,Indonesian,id_ID.UTF-8,Indonesian_indonesia.1252,WINDOWS-1252" => "Indonesian",
			  "it_utf8,Italian,it_IT.UTF-8,Italian_Italy.1252,WINDOWS-1252" => "Italian",
			  "ja_utf8,Japanese,ja_JP.UTF-8,Japanese_Japan.932" => "Japanese",
			  "kn_utf8,Kannada,kn_IN.UTF-8,Kannada.65001" => "Kannada",
			  "km_utf8,Khmer,km_KH.UTF-8,Khmer.65001" => "Khmer",
			  "ko_utf8,Korean,ko_KR.UTF-8,Korean_Korea.949" => "Korean",
			  "lo_utf8,Lao,lo_LA.UTF-8,Lao_Laos.UTF-8,WINDOWS-1257" => "Lao",
			  "lt_utf8,Lithuanian,lt_LT.UTF-8,Lithuanian_Lithuania.1257,WINDOWS-1257" => "Lithuanian",
			  "lv_utf8,Latvian,lat.UTF-8,Latvian_Latvia.1257,WINDOWS-1257" => "Latvian",
			  "ml_utf8,Malayalam,ml_IN.UTF-8,Malayalam_India.x-iscii-ma" => "Malayalam",
			  "ms_utf8,Malaysian,ms_MY.UTF-8,Malay_malaysia.1252,WINDOWS-1252" => "Malaysian",
			  "mi_tn_utf8,Maori (Ngai Tahu),mi_NZ.UTF-8,Maori.1252,WINDOWS-1252" => "Maori (Ngai Tahu)",
			  "mi_wwow_utf8,Maori (Waikoto Uni),mi_NZ.UTF-8,Maori.1252,WINDOWS-1252" => "Maori (Waikoto Uni)",
			  "mn_utf8,Mongolian,mn.UTF-8,Cyrillic_Mongolian.1251" => "Mongolian",
			  "no_utf8,Norwegian,no_NO.UTF-8,Norwegian_Norway.1252,WINDOWS-1252" => "Norwegian",
			  "nn_utf8,Nynorsk,nn_NO.UTF-8,Norwegian-Nynorsk_Norway.1252,WINDOWS-1252" => "Nynorsk",
			  "pl_utf8,Polish,pl.UTF-8,Polish_Poland.1250,WINDOWS-1250" => "Polish",
			  "pt_utf8,Portuguese,pt_PT.UTF-8,Portuguese_Portugal.1252,WINDOWS-1252" => "Portuguese",
			  "pt_br_utf8,Portuguese (Brazil),pt_BR.UTF-8,Portuguese_Brazil.1252,WINDOWS-1252" => "Portuguese (Brazil)",
			  "ro_utf8,Romanian,ro_RO.UTF-8,Romanian_Romania.1250,WINDOWS-1250" => "Romanian",
			  "ru_utf8,Russian,ru_RU.UTF-8,Russian_Russia.1251,WINDOWS-1251" => "Russian",
			  "sm_utf8,Samoan,mi_NZ.UTF-8,Maori.1252,WINDOWS-1252" => "Samoan",
			  "sr_utf8,Serbian,sr_CS.UTF-8,Serbian (Cyrillic)_Serbia and Montenegro.1251,WINDOWS-1251" => "Serbian",
			  "sk_utf8,Slovak,sk_SK.UTF-8,Slovak_Slovakia.1250,WINDOWS-1250" => "Slovak",
			  "sl_utf8,Slovenian,sl_SI.UTF-8,Slovenian_Slovenia.1250,WINDOWS-1250" => "Slovenian",
			  "so_utf8,Somali,so_SO.UTF-8" => "Somali",
			  "es_utf8,Spanish (International),es_ES.UTF-8,Spanish_Spain.1252,WINDOWS-1252" => "Spanish",
			  "sv_utf8,Swedish,sv_SE.UTF-8,Swedish_Sweden.1252,WINDOWS-1252" => "Swedish",
			  "tl_utf8,Tagalog,tl.UTF-8" => "Tagalog",
			  "ta_utf8,Tamil,ta_IN.UTF-8,English_Australia.1252" => "Tamil",
			  "th_utf8,Thai,th_TH.UTF-8,Thai_Thailand.874,WINDOWS-874" => "Thai",
			  "to_utf8,Tongan,mi_NZ.UTF-8',Maori.1252,WINDOWS-1252" => "Tongan",
			  "tr_utf8,Turkish,tr_TR.UTF-8,Turkish_Turkey.1254,WINDOWS-1254" => "Turkish",
			  "uk_utf8,Ukrainian,uk_UA.UTF-8,Ukrainian_Ukraine.1251,WINDOWS-1251" => "Ukrainian",
			  "vi_utf8,Vietnamese,vi_VN.UTF-8,Vietnamese_Viet Nam.1258,WINDOWS-1258" => "Vietnamese",
			  );
	
		  return $lang;
	  }

	  /**
	   * Core::url()
	   * 
	   * @param mixed $type
	   * @param mixed $action
	   * @param bool $has_id
	   * @return
	   */
	  public static function url($type, $action, $has_id = false)
	  {
		  $sub = ($type == "modules") ? "modname=" . Filter::$modname . "&amp;maction=" : "plugname=" . Filter::$plugname . "&amp;paction=";
		  $id = ($has_id) ? "&amp;id=" . $has_id : null;
	
		  return $url = "index.php?do={$type}&amp;action=config&amp;" . $sub . $action . $id;
	
	  }
	  
	  /**
	   * Core::_implodeFields()
	   * 
	   * @param mixed $array
	   * @return
	   */
	  public static function _implodeFields($array, $sep = ',')
	  {
          if (is_array($array)) {
			  $result = array();
			  foreach ($array as $row) {
				  if ($row != '') {
					  array_push($result, sanitize($row));
				  }
			  }
			  return implode($sep, $result);
          }
		  return false;
	  }
	  
      /**
       * Core::checkTable()
       * 
	   * @param mixed $tablename
       * @return
       */
	  public static function checkTable($tablename)
	  {
		  return Registry::get("Database")->numrows(Registry::get("Database")->query("SHOW TABLES LIKE '" . $tablename . "'")) ? true : false;
	  }

  }
?>