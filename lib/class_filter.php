<?php
  /**
   * Filter Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: class_filter.php, v2.00 2011-04-20 18:20:24 Nurullah Okatan
   */
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  final class Filter
  {
	  public static $id = null;
      public static $get = array();
      public static $post = array();
      public static $cookie = array();
      public static $files = array();
      public static $server = array();
      private static $marker = array();
	  public static $msgs = array();
	  public static $showMsg;

	  public static $action = null;
	  public static $paction = null;
	  public static $maction = null;
	  
	  public static $do = null;
	  public static $plugname = null;
	  public static $modname = null;
      

      /**
       * Filter::__construct()
       * 
       * @return
       */
      public function __construct()
      {
          $_GET = self::clean($_GET);
          $_POST = self::clean($_POST);
          $_COOKIE = self::clean($_COOKIE);
          $_FILES = self::clean($_FILES);
          $_SERVER = self::clean($_SERVER);

          self::$get = $_GET;
          self::$post = $_POST;
          self::$cookie = $_COOKIE;
          self::$files = $_FILES;
          self::$server = $_SERVER;
		  
		  self::getAction();
		  self::getDo();
		  self::getPlugin();
		  self::getPluginAction();
		  self::getModule();
		  self::getModuleAction();
		  self::$id = self::getId();
      }

	  /**
	   * Filter::getId()
	   * 
	   * @return
	   */
	  private static function getId()
	  {
		  if (isset($_REQUEST['id'])) {
			  self::$id = (is_numeric($_REQUEST['id']) && $_REQUEST['id'] > -1) ? intval($_REQUEST['id']) : false;
			  self::$id = sanitize(self::$id);
			  
			  if (self::$id == false) {
				  DEBUG == true ? self::error("You have selected an Invalid Id", "Filter::getId()") : self::ooops();
			  } else
				  return self::$id;
		  }
	  }
	  
      /**
       * Filter::clean()
       * 
       * @param mixed $data
       * @return
       */
      public static function clean($data)
      {
          if (is_array($data)) {
              foreach ($data as $key => $value) {
                  unset($data[$key]);

                  $data[self::clean($key)] = self::clean($value);
              }
          } else {
			  if (ini_get('magic_quotes_gpc')) {
				  $data = stripslashes($data);
			  } else {
				  $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
			  }
		  }

          return $data;
      }
	  
      /**
       * Filter::getAction()
       * 
       * @return
       */
	  private static function getAction()
	  {
		  if (isset(self::$get['action'])) {
			  $action = ((string)self::$get['action']) ? (string)self::$get['action'] : false;
			  $action = sanitize($action);
			  
			  if ($action == false) {
				  self::error("You have selected an Invalid Action Method","Filter::getAction()");
			  } else
				  return self::$action = $action;
		  }
	  }
	  	  
      /**
       * Filter::getDo()
       * 
       * @return
       */
	  private static function getDo()
	  {
		  if (isset(self::$get['do'])) {
			  $do = ((string)self::$get['do']) ? (string)self::$get['do'] : false;
			  $do = sanitize($do);
			  
			  if ($do == false) {
				  self::error("You have selected an Invalid Do Method","Filter::getDo()");
			  } else
				  return self::$do = $do;
		  }
	  }
	  
      /**
       * Filter::getPlugin()
       * 
       * @return
       */
	  private static function getPlugin()
	  {
		  if (isset(self::$get['plugname'])) {
			  $plugname = ((string)self::$get['plugname']) ? (string)self::$get['plugname'] : false;
			  $plugname = sanitize($plugname);
			  
			  if ($plugname == false) {
				  self::error("You have selected an Invalid Plugname Method","Filter::getPlugin()");
			  } else
				  return self::$plugname = $plugname;
		  }
	  }

      /**
       * Filter::getPluginAction()
       * 
       * @return
       */
	  private static function getPluginAction()
	  {
		  if (isset(self::$get['paction'])) {
			  $paction = ((string)self::$get['paction']) ? (string)self::$get['paction'] : false;
			  $paction = sanitize($paction);
			  
			  if ($paction == false) {
				  self::error("You have selected an Invalid Plugin Action Method","Filter::getPluginAction()");
			  } else
				  return self::$paction = $paction;
		  }
	  }

      /**
       * Filter::getModule()
       * 
       * @return
       */
	  private static function getModule()
	  {
		  if (isset(self::$get['modname'])) {
			  $modname = ((string)self::$get['modname']) ? (string)self::$get['modname'] : false;
			  $modname = sanitize($modname);
			  
			  if ($modname == false) {
				  self::error("You have selected an Invalid Modname Method","Filter::getModule()");
			  } else
				  return self::$modname = $modname;
		  }
	  }

      /**
       * Filter::getModuleAction()
       * 
       * @return
       */
	  private static function getModuleAction()
	  {
		  if (isset(self::$get['maction'])) {
			  $maction = ((string)self::$get['maction']) ? (string)self::$get['maction'] : false;
			  $maction = sanitize($maction);
			  
			  if ($maction == false) {
				  self::error("You have selected an Invalid Module Action Method","Filter::getModuleAction()");
			  } else
				  return self::$maction = $maction;
		  }
	  }
	  
      /**
       * Filter::msgAlert()
       * 
       * @param mixed $msg
       * @param bool $fader
       * @param bool $print
       * @param bool $altholder
       * @return
       */
      public static function msgAlert($msg, $print = true, $fader = false, $altholder = false)
      {
          self::$showMsg = "<div class=\"tubi icon message warning\"><i class=\"flag icon\"></i><i class=\"close icon\"></i><div class=\"content\"><div class=\"header\"> " . Lang::$word->_ALERT . "</div><p>" . $msg . "</p></div></div>";
          if ($fader == true)
              self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgAlert\").fadeOut(\"slow\",    
			  function() {       
				$(\".msgAlert\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";

          if ($print == true) {
              print ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          } else {
              return ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          }
      }


      /**
       * Filter::msgSingleAlert()
       * 
       * @param mixed $msg
       * @param bool $print
       * @return
       */
      public static function msgSingleAlert($msg, $print = true)
      {
          self::$showMsg = "<div class=\"tubi warning message\"><i class=\"attention icon\"></i> " . $msg . "</div>";

          if ($print == true) {
              print self::$showMsg;
          } else {
              return self::$showMsg;
          }
      }

      /**
       * Filter::msgOk()
       * 
       * @param mixed $msg
       * @param bool $fader
       * @param bool $print
       * @param bool $altholder
       * @return
       */
      public static function msgOk($msg, $print = true, $fader = false, $altholder = false)
      {
          self::$showMsg = "<div class=\"tubi icon message success\"><i class=\"flag icon\"></i><i class=\"close icon\"></i><div class=\"content\"><div class=\"header\"> " . Lang::$word->_SUCCESS . "</div><p>" . $msg .
              "</p></div></div>";
          if ($fader == true)
              self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgOk\").fadeOut(\"slow\",    
			  function() {       
				$(\".msgOk\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";
          if ($print == true) {
              print ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          } else {
              return ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          }
      }

      /**
       * Filter::msgSingleOk()
       * 
       * @param mixed $msg
       * @param bool $print
       * @return
       */
      public static function msgSingleOk($msg, $print = true)
      {
          self::$showMsg = "<div class=\"tubi success message\"><i class=\"ok sign icon\"></i> " . $msg . "</div>";

          if ($print == true) {
              print self::$showMsg;
          } else {
              return self::$showMsg;
          }
      }
	  
      /**
       * Filter::msgInfo()
       * 
       * @param mixed $msg
       * @param bool $fader
       * @param bool $print
       * @param bool $altholder
       * @return
       */
      public static function msgInfo($msg, $print = true, $fader = false, $altholder = false)
      {
          self::$showMsg = "<div class=\"tubi icon message info\"><i class=\"flag icon\"></i><i class=\"close icon\"></i><div class=\"content\"><div class=\"header\"> " . Lang::$word->_INFO . "</div><p>" . $msg . "</p></div></div>";
          if ($fader == true)
              self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgInfo\").fadeOut(\"slow\",    
			  function() {       
				$(\".msgInfo\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";

          if ($print == true) {
              print ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          } else {
              return ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          }
      }

      /**
       * Filter::msgSingleOk()
       * 
       * @param mixed $msg
       * @param bool $print
       * @return
       */
      public static function msgSingleInfo($msg, $print = true)
      {
          self::$showMsg = "<div class=\"tubi info message\"><i class=\"information icon\"></i> " . $msg . "</div>";

          if ($print == true) {
              print self::$showMsg;
          } else {
              return self::$showMsg;
          }
      }
	  
      /**
       * Filter::msgError()
       * 
       * @param mixed $msg
       * @param bool $fader
       * @param bool $print
       * @param bool $altholder
       * @return
       */
      public static function msgError($msg, $print = true, $fader = false, $altholder = false)
      {
          self::$showMsg = "<div class=\"tubi icon message error\"><i class=\"flag icon\"></i><i class=\"close icon\"></i><div class=\"content\"><div class=\"header\"> " . Lang::$word->_ERROR . "</div><p>" . $msg .
              "</p></div></div>";
          if ($fader == true)
              self::$showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
			setTimeout(function() {       
			  $(\".msgError\").fadeOut(\"slow\",    
			  function() {       
				$(\".msgError\").remove();  
			  });
			},
			4000);
		  // ]]>
		  </script>";
          if ($print == true) {
              print ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          } else {
              return ($altholder) ? '<div id="alt-msgholder">' . self::$showMsg . '</div>' : self::$showMsg;
          }
      }

      /**
       * Filter::msgSingleError()
       * 
       * @param mixed $msg
       * @param bool $print
       * @return
       */
      public static function msgSingleError($msg, $print = true)
      {
          self::$showMsg = "<div class=\"tubi error message\"><i class=\"ban circle icon\"></i> " . $msg . "</div>";

          if ($print == true) {
              print self::$showMsg;
          } else {
              return self::$showMsg;
          }
      }
	  
    
    /**
     * Filter::msgStatus()
     * 
     * @return
     */
    public static function msgStatus()
    {
        // Hata düzeltmesi: $msgs'nin dizi olduğundan emin oluyoruz
        if (!is_array(self::$msgs)) {
            self::$msgs = array();
        }
        
        self::$showMsg = "<div class=\"tubi error message\"><i class=\"close icon\"></i><div class=\"header\">" . Lang::$word->_SYSTEM_ERR . "</div><div class=\"content\"><ul class=\"tubi list\">";
        
        foreach (self::$msgs as $msg) {
            self::$showMsg .= "<li>" . $msg . "</li>\n";
        }
        
        self::$showMsg .= "</ul></div></div>";

        return self::$showMsg;
    }



      /**
       * Filter::error()
       * 
       * @param mixed $msg
       * @param mixed $source
       * @return
       */
      public static function error($msg, $source)
      {
          if (DEBUG == true) {
              $the_error = "<div class=\"tubi message error\">";
              $the_error .= "<span>System ERROR!</span><br />";
              $the_error .= "DB Error: " . $msg . " <br /> More Information: <br />";
              $the_error .= "<ul class=\"error\">";
              $the_error .= "<li> Date : " . date("F j, Y, g:i a") . "</li>";
              $the_error .= "<li> Function: " . $source . "</li>";
              $the_error .= "<li> Script: " . $_SERVER['REQUEST_URI'] . "</li>";
              $the_error .= "<li>&lsaquo; <a href=\"javascript:history.go(-1)\"><strong>Go Back to previous page</strong></a></li>";
              $the_error .= '</ul>';
              $the_error .= '</div>';
          } else {
              $the_error = "<div class=\"msgError\" style=\"color:#444;width:400px;margin-left:auto;margin-right:auto;border:1px solid #C3C3C3;font-family:Arial, Helvetica, sans-serif;font-size:13px;padding:10px;background:#f2f2f2;border-radius:5px;text-shadow:1px 1px 0 #fff\">";
              $the_error .= "<h4 style=\"font-size:18px;margin:0;padding:0\">Oops!!!</h4>";
              $the_error .= "<p>Something went wrong. Looks like the page you're looking for was moved or never existed. Make sure you typed the correct URL or followed a valid link.</p>";
              //$the_error .= "<p>&lsaquo; <a href=\"javascript:history.go(-1)\" style=\"color:#0084FF;\"><strong>Go Back to previous page</strong></a></p>";
              $the_error .= '</div>';
          }
          print $the_error;
          die();
      }

      /**
       * Filter::ooops()
       * 
       * @return
       */
      public static function ooops()
      {
          $the_error = "<div class=\"msgError\" style=\"color:#444;width:400px;margin-left:auto;margin-right:auto;border:1px solid #C3C3C3;font-family:Arial, Helvetica, sans-serif;font-size:13px;padding:10px;background:#f2f2f2;border-radius:5px;text-shadow:1px 1px 0 #fff\">";
          $the_error .= "<h4 style=\"font-size:18px;margin:0;padding:0\">Oops!!!</h4>";
          $the_error .= "<p>Something went wrong. Looks like the page you're looking for was moved or never existed. Make sure you typed the correct URL or followed a valid link.</p>";
          $the_error .= "<p>&lsaquo; <a href=\"javascript:history.go(-1)\" style=\"color:#0084FF;\"><strong>Go Back to previous page</strong></a></p>";
          $the_error .= '</div>';
          print $the_error;
          die();
      }

	  /**
	   * Filter::in_url()
	   * 
	   * @param mixed $data
	   * @return
	   */
	  public static function in_url($data)
	  {
		  $display = str_replace("../uploads/", "uploads/", $data);
		  return $display;  
	  }

	  /**
	   * Filter::out_url()
	   * 
	   * @param mixed $data
	   * @return
	   */
	  public static function out_url($data)
	  {
		  $display = str_replace("uploads/", "../uploads/", $data); 
		  return $display; 
	  }

      /**
       * Filter::getPost()
       * 
       * @param mixed $key
       * @return
       */
      public static function getPost($key)
      {
          return self::arrayKey($key, $_POST);
      }

      /**
       * Filter::arrayKey()
       * 
       * @param mixed $key
       * @param mixed $data
       * @return
       */
      private static function arrayKey($key, $data)
      {
          $array_keys = array();
          if (preg_match('/^([^\[]{1,})\[(.*)\]+$/', $key, $match)) {
              $array_keys[] = $match[1];
              $ns = explode('[', '[' . $match[2] . ']');
              foreach ($ns as $nss) {
                  if ($nss) {
                      $array_keys[] = trim($nss, '][');
                  }
              }

              $buf = $data;
              foreach ($array_keys as $k) {
                  if (isset($buf[$k])) {
                      $buf = $buf[$k];
                  } else 
                      $buf = null;
              }

              return $buf;
          } else {
              return isset($data[$key]) ? $data[$key] : null;
          }
      }

      /**
       * Helper::multi_array_to_single_uniq()
       * 
       * @param mixed $array
       * @param mixed $maxdepth
       * @param integer $depth
       * @return
       */
      public static function multi_array_to_single_uniq($array, $maxdepth = null, $depth = 0)
      {

          $single = array();
          if (!is_array($array)) {
              return $single;
          }

          $depth++;
          foreach ($array as $key => $value) {
              if (($depth <= $maxdepth || is_null($maxdepth)) && is_array($value)) {
                  $single = array_merge($single, self::multi_array_to_single_uniq($value, $maxdepth, $depth));
              } else {
                  array_push($single, $value);
              }
          }
          return array_unique($single);
      }
	   
    /**
     * Filter::checkPost()
     * 
     * @param mixed $index
     * @param mixed $msg
     * @return
     */  
    public static function checkPost($index, $msg) {
        // Hata düzeltmesi: $msgs'nin dizi olduğundan emin oluyoruz
        if (!is_array(self::$msgs)) {
            self::$msgs = array();
        }
        
        if(empty($_POST[$index]))
            self::$msgs[$index] = $msg;
    }


      /**
       * Filter::checkSetPost()
       * 
       * @param mixed $index
       * @param mixed $msg
       * @return
       */
      public static function checkSetPost($index, $msg)
      {

          if (!isset($_POST[$index]))
              self::$msgs[$index] = $msg;
      }
	  
	  /**
	   * Filter::dodate()
	   * 
	   * @param mixed $format
	   * @param mixed $date
	   * @return
	   */  
	  public static function dodate($format, $date) {
		  
		return utf8_encode(strftime(Registry::get("Core")->$format, strtotime($date)));
	  } 

	  /**
	   * Filter::dotime()
	   * 
	   * @param mixed $time
	   * @return
	   */  
	  public static function dotime($time) {
		  
		return utf8_encode(strftime(Registry::get("Core")->time_format, strtotime($time)));
	  } 
	  
      /**
       * Filter::mark()
       * 
       * @param mixed $name
       * @return
       */
      public static function mark($name)
      {
          self::$marker[$name] = microtime();
      }


      /**
       * Filter::elapsed()
       * 
       * @param string $point1
       * @param string $point2
       * @param integer $decimals
       * @return
       */
      public static function elapsed($point1 = '', $point2 = '', $decimals = 4)
      {

          if (!isset(self::$marker[$point1])) {
              return '';
          }

          if (!isset(self::$marker[$point2])) {
              self::$marker[$point2] = microtime();
          }

          list($sm, $ss) = explode(' ', self::$marker[$point1]);
          list($em, $es) = explode(' ', self::$marker[$point2]);

          return number_format(($em + $es) - ($sm + $ss), $decimals);
      }
  }
?>