<?php

  /**
   * Functions
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: functions.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  /**
   * redirect_to()
   * 
   * @param mixed $location
   * @return
   */
  function redirect_to($location)
  {
      if (!headers_sent()) {
          header('Location: ' . $location);
          exit;
      } else {
          echo '<script type="text/javascript">';
          echo 'window.location.href="' . $location . '";';
          echo '</script>';
          echo '<noscript>';
          echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
          echo '</noscript>';
      }
  }

  /**
   * countEntries()
   * 
   * @param mixed $table
   * @param string $where
   * @param string $what
   * @return
   */
  function countEntries($table, $where = '', $what = '')
  {
      if (!empty($where) && isset($what)) {
          $q = "SELECT COUNT(*) FROM " . $table . "  WHERE " . $where . " = '" . $what . "' LIMIT 1";
      } else
          $q = "SELECT COUNT(*) FROM " . $table . " LIMIT 1";

      $record = Registry::get("Database")->query($q);
      $total = Registry::get("Database")->fetchrow($record);
      return $total[0];
  }

  /**
   * getChecked()
   * 
   * @param mixed $row
   * @param mixed $status
   * @return
   */
  function getChecked($row, $status)
  {
      if ($row == $status) {
          echo "checked=\"checked\"";
      }
  }

  /**
   * post()
   * 
   * @param mixed $var
   * @return
   */
  function post($var)
  {
      if (isset($_POST[$var]))
          return $_POST[$var];
  }

  /**
   * get()
   * 
   * @param mixed $var
   * @return
   */
  function get($var)
  {
      if (isset($_GET[$var]))
          return $_GET[$var];
  }

  /**
   * sanitize()
   * 
   * @param mixed $string
   * @param bool $trim
   * @return
   */
  function sanitize($string, $trim = false, $int = false, $str = false)
  {
      $string = filter_var($string, FILTER_SANITIZE_STRING);
      $string = trim($string);
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = str_replace(array(
          '‘',
          '’',
          '“',
          '”'), array(
          "'",
          "'",
          '"',
          '"'), $string);

      if ($trim)
          $string = substr($string, 0, $trim);
      if ($int)
          $string = preg_replace("/[^0-9\s]/", "", $string);
      if ($str)
          $string = preg_replace("/[^a-zA-Z\s]/", "", $string);

      return $string;
  }

  /**
   * cleanSanitize()
   * 
   * @param mixed $string
   * @param bool $trim
   * @return
   */
  function cleanSanitize($string, $trim = false, $end_char = '&#8230;')
  {
      $string = cleanOut($string);
      $string = filter_var($string, FILTER_SANITIZE_STRING);
      $string = trim($string);
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = str_replace(array(
          '‘',
          '’',
          '“',
          '”'), array(
          "'",
          "'",
          '"',
          '"'), $string);

      if ($trim) {
          if (strlen($string) < $trim) {
              return $string;
          }

          $string = preg_replace("/\s+/", ' ', str_replace(array(
              "\r\n",
              "\r",
              "\n"), ' ', $string));

          if (strlen($string) <= $trim) {
              return $string;
          }

          $out = "";
          foreach (explode(' ', trim($string)) as $val) {
              $out .= $val . ' ';

              if (strlen($out) >= $trim) {
                  $out = trim($out);
                  return (strlen($out) == strlen($string)) ? $out : $out . $end_char;
              }
          }
      }
      return $string;
  }

  /**
   * truncate()
   * 
   * @param mixed $str
   * @param int $n
   * @param mixed $end_char
   * @return
   */
  function truncate($str, $n = 100, $end_char = '&#8230;')
  {
      if (strlen($str) < $n) {
          return $str;
      }

      $str = preg_replace("/\s+/", ' ', str_replace(array(
          "\r\n",
          "\r",
          "\n"), ' ', $str));

      if (strlen($str) <= $n) {
          return $str;
      }

      $out = "";
      foreach (explode(' ', trim($str)) as $val) {
          $out .= $val . ' ';

          if (strlen($out) >= $n) {
              $out = trim($out);
              return (strlen($out) == strlen($str)) ? $out : $out . $end_char;
          }
      }
  }

  /**
   * getValue()
   * 
   * @param mixed $stwhatring
   * @param mixed $table
   * @param mixed $where
   * @return
   */
  function getValue($what, $table, $where)
  {
      $sql = "SELECT $what FROM $table WHERE $where";
      $row = Registry::get("Database")->first($sql);
      return ($row) ? $row->$what : '';
  }

  /**
   * getValues()
   * 
   * @param mixed $stwhatring
   * @param mixed $table
   * @param mixed $where
   * @return
   */
  function getValues($what, $table, $where)
  {
      $sql = "SELECT $what FROM $table WHERE $where";
      $row = Registry::get("Database")->first($sql);
      return ($row) ? $row : 0;
  }
  
  /**
   * getValueById()
   * 
   * @param mixed $what
   * @param mixed $table
   * @param mixed $id
   * @return
   */
  function getValueById($what, $table, $id)
  {
      $sql = "SELECT $what FROM $table WHERE id = $id";
      $row = Registry::get("Database")->first($sql);
      return ($row) ? $row->$what : '';
  }

  /**
   * getValuesById()
   * 
   * @param mixed $what
   * @param mixed $table
   * @param mixed $id
   * @return
   */
  function getValuesById($what, $table, $id)
  {
      $sql = "SELECT $what FROM $table WHERE id = $id";
      $row = Registry::get("Database")->first($sql);
      return ($row) ? $row : 0;
  }
  
  /**
   * phpself()
   * 
   * @return
   */
  function phpself()
  {
      return htmlspecialchars($_SERVER['PHP_SELF']);
  }

  /**
   * stripTags()
   * 
   * @param mixed $start
   * @param mixed $end
   * @param mixed $string
   * @return
   */
  function stripTags($start, $end, $string)
  {
      $string = stristr($string, $start);
      $doend = stristr($string, $end);
      return substr($string, strlen($start), -strlen($doend));
  }

  /**
   * getTemplates()
   * 
   * @param mixed $dir
   * @param mixed $site
   * @return
   */
  function getTemplates($dir, $site)
  {
      $getDir = dir($dir);
      while (false !== ($templDir = $getDir->read())) {
          if ($templDir != "." && $templDir != ".." && $templDir != "index.php") {
              $selected = ($site == $templDir) ? " selected=\"selected\"" : "";
              echo "<option value=\"{$templDir}\"{$selected}>{$templDir}</option>\n";
          }
      }
      $getDir->close();
  }

  /**
   * stripExt()
   * 
   * @param mixed $filename
   * @return
   */
  function stripExt($filename)
  {
      if (strpos($filename, ".") === false) {
          return ucwords($filename);
      } else
          return substr(ucwords($filename), 0, strrpos($filename, "."));
  }

  /**
   * cleanOut()
   * 
   * @param mixed $text
   * @return
   */
  function cleanOut($text)
  {
      $text = strtr($text, array(
          '\r\n' => "",
          '\r' => "",
          '\n' => ""));
      $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
      $text = str_replace('<br>', '<br />', $text);
      return stripslashes($text);
  }

  /**
   * isActive()
   * 
   * @param mixed $id
   * @return
   */
  function isActive($id)
  {
      if ($id == 1) {
          $display = '<i data-content="' . Lang::$word->_PUBLISHED . '" class="rounded inverted icon check"></i>';
      } else {
          $display = '<i data-content="' . Lang::$word->_NOTPUBLISHED . '" class="rounded inverted icon time"></i>';
      }

      return $display;
  }

  /**
   * isActive()
   * 
   * @param mixed $id
   * @return
   */
  function isRequired($id)
  {
      if ($id == 1) {
          $display = '<i data-content="' . Lang::$word->_REQ_FIELD . '" class="rounded inverted icon check"></i>';
      } else {
          $display = '<i data-content="' . Lang::$word->_REQ_FIELDN . '" class="rounded inverted icon ban"></i>';
      }

      return $display;
  }
  
  /**
   * isCompleted()
   * 
   * @param mixed $id
   * @return
   */
  function isCompleted($id)
  {
      if ($id == 1) {
          $display = '<i data-content="' . Lang::$word->_COMPLETED . '" class="rounded inverted icon check"></i>';
      } else {
          $display = '<i data-content="' . Lang::$word->_PENDING . '" class="rounded inverted icon time"></i>';
      }

      return $display;
      ;
  }
  
  /**
   * isAdmin()
   * 
   * @param mixed $id
   * @return
   */
  function isAdmin($userlevel)
  {
      if ($userlevel == 9) {
          $display = '<i data-content="' . Lang::$word->_UR_SADMIN . '" class="rounded inverted black icon user"></i>';
      } elseif ($userlevel == 8) {
          $display = '<i data-content="' . Lang::$word->_UR_ADMIN . '" class="rounded inverted info icon user"></i>';
      } else {
          $display = '<i data-content="' . Lang::$word->_USER . '" class="rounded inverted success icon user"></i>';
      }

      return $display;
      ;
  }

  /**
   * userStatus()
   * 
   * @param mixed $id
   * @return
   */
  function userStatus($status, $id)
  {
      switch ($status) {
          case "y":
              $display = '<span class="tubi positive label">' . Lang::$word->_USER_A . '</span>';
              break;

          case "n":
              $display = '<span class="tubi info label">' . Lang::$word->_USER_I . '</span>';
              break;

          case "t":
              $display = '<span class="tubi warning label">' . Lang::$word->_USER_P . '</span>';
              break;

          case "b":
              $display = '<span class="tubi negative label">' . Lang::$word->_USER_B . '</span>';
              break;
      }

      return $display;
      ;
  }

  /**
   * delete_directory()
   * 
   * @param mixed $dirname
   * @return
   */
	function delete_directory($dirname) {
		$dir_handle='';
	   if (is_dir($dirname))
		  $dir_handle = opendir($dirname);
	   if (!$dir_handle)
		  return false;
	   while($file = readdir($dir_handle)) {
		  if ($file != "." && $file != "..") {
			 if (!is_dir($dirname."/".$file))
				unlink($dirname."/".$file);
			 else
				delete_directory($dirname.'/'.$file);    
		  }
	   }
	   closedir($dir_handle);
	   rmdir($dirname);
	   return true;
	}

  /**
   * alphaBits()
   * 
   * @param bool $all
   * @param array $vars
   * @return
   */
  function alphaBits($all = false, $vars)
  {
      if (!empty($_SERVER['QUERY_STRING'])) {
          $parts = explode("&amp;", $_SERVER['QUERY_STRING']);
          $vars = str_replace(" ", "", $vars);
          $c_vars = explode(",", $vars);
          $newParts = array();
          foreach ($parts as $val) {
              $val_parts = explode("=", $val);
              if (!in_array($val_parts[0], $c_vars)) {
                  array_push($newParts, $val);
              }
          }
          if (count($newParts) != 0) {
              $qs = "&amp;" . implode("&amp;", $newParts);
          } else {
              return false;
          }
          
		  $html = '';
          $charset = explode(",", Lang::$word->_CHARSET);
          $html .= "<div class=\"tubi small pagination menu\">\n";
          foreach ($charset as $key) {
			  $active = ($key == get('letter')) ? ' active' : null;
              $html .= "<a class=\"item$active\" href=\"" . phpself() . "?letter=" . $key . $qs . "\">" . $key . "</a>\n";
          }
          $viewAll = ($all === false) ? phpself() : $all;
          $html .= "<a class=\"item\" href=\"" . $viewAll . "\">" . Lang::$word->_ALL . "</a>\n";
          $html .= "</div>\n";
		  unset($key);
		  
		  return $html;
	  } else {
		  return false;
	  }
  }
/**
   * doUrl()
   *  
   * @return
   */
  function doUrl($id, $slug, $type, $pars = false)
  {
       switch ($type) {
          case "page":
              $url = SITEURL . '/page/' . $slug . '/' . $pars;
              break;
           
          case "blog":
              $url = SITEURL . '/blog/' . $pars;
              break;
           
          case "blog-item":
              $url = SITEURL . '/blog/' . $slug . '/' . $pars;
              break;
           
          case "blog-cat":
              $url = SITEURL . '/blog/category/' . $slug . '/' . $pars;
              break;
           
          case "blog-search":
              $url = SITEURL . '/blog/search/' . $pars;
              break;
           
          case "blog-archive":
              $url = SITEURL . '/blog/archive/' . $pars;
              break;
           
          case "blog-author":
              $url = SITEURL . '/blog/author/' . $slug . '/' . $pars;
              break;
           
          case "blog-tags":
              $url = SITEURL . '/blog/tag/' . urlencode($slug) . '/' . $pars;
              break; 
			           
          case "portfolio":
              $url = SITEURL . '/portfolio/' . $pars;
              break;
           
          case "portfolio-cat":
              $url = SITEURL . '/portfolio/category/' . $slug . '/' . $pars;
              break; 
			          
          case "portfolio-item":
              $url = SITEURL . '/portfolio/' . $slug . '/' . $pars;
              break;
          
          case "muzibu":
              $url = SITEURL . '/muzibu/' . $pars;
              break;
              
          case "muzibu-song":
              $url = SITEURL . '/muzibu/song/' . $slug . '/' . $pars;
              break;
              
          case "muzibu-album":
              $url = SITEURL . '/muzibu/album/' . $slug . '/' . $pars;
              break;
              
          case "muzibu-artist":
              $url = SITEURL . '/muzibu/artist/' . $slug . '/' . $pars;
              break;
              
          case "muzibu-genre":
              $url = SITEURL . '/muzibu/genre/' . $slug . '/' . $pars;
              break;
              
          case "muzibu-playlist":
              $url = SITEURL . '/muzibu/playlist/' . $slug . '/' . $pars;
              break;
              
          case "muzibu-sector":
              $url = SITEURL . '/muzibu/sector/' . $slug . '/' . $pars;
              break;
              
          case "muzibu-favorites":
              $url = SITEURL . '/muzibu/favorites/' . $pars;
              break;
           
       }
       return $url;
   }

   function doUrlParts($type)
  {
       switch ($type) {
           case "blog-search":
              $val = 'search';
              break;
           
           case "blog-tags":
              $val = 'tag';
              break; 
			        
           case "blog-archive":
              $val = 'archive';
              break;
           
           case "blog-author":
              $val = 'author';
              break; 
			          
           case "digishop-checkout":
              $val = 'checkout';
              break;
           
           case "psdrive-search":
              $val = 'search';
              break; 
			           
           case "psdrive-tags":
              $val = 'tag';
              break; 
			        
           case "forum-user":
              $val = 'user';
              break;
              
           case "muzibu-song":
              $val = 'song';
              break;
              
           case "muzibu-album":
              $val = 'album';
              break;
              
           case "muzibu-artist":
              $val = 'artist';
              break;
              
           case "muzibu-genre":

              $val = 'genre';
              break;
              
           case "muzibu-playlist":
              $val = 'playlist';
              break;
              
           case "muzibu-sector":
              $val = 'sector';
              break;
              
           case "muzibu-favorites":
              $val = 'favorites';
              break;
      }
       return $val;
   }

   
  /**
   * randName()
   * 
   * @return
   */
  function randName($i = 6)
  {
      $code = '';
      for ($x = 0; $x < $i; $x++) {
          $code .= '-' . substr(strtoupper(sha1(rand(0, 999999999999999))), 2, 6);
      }
      $code = substr($code, 1);
      return $code;
  }

  /**
   * checkDir()
   * 
   * @param mixed $dir
   * @return
   */
  function checkDir($dir)
  {
      if (!is_dir($dir)) {
          echo "path does not exist<br/>";
          $dirs = explode('/', $dir);
          $tempDir = $dirs[0];
          $check = false;

          for ($i = 1; $i < count($dirs); $i++) {
              echo " Checking " . $tempDir . "<br/>";
              if (is_writeable($tempDir)) {
                  $check = true;
              } else {
                  $error = $tempDir;
              }

              $tempDir .= '/' . $dirs[$i];
              if (!is_dir($tempDir)) {
                  if ($check) {
                      echo " Creating " . $tempDir . "<br/>";
                      @mkdir($tempDir, 0755);
                      @chmod($tempDir, 0755);
                  } else
                      echo " Not enough permissions";
              }
          }
      }
  }

  /**
   * getSize()
   * 
   * @param mixed $bytes
   * @return
   */
  function getSize($bytes)
  {
      if ($bytes >= 1073741824) {
          $bytes = number_format($bytes / 1073741824, 2) . ' GB';
      } elseif ($bytes >= 1048576) {
          $bytes = number_format($bytes / 1048576, 2) . ' MB';
      } elseif ($bytes >= 1024) {
          $bytes = number_format($bytes / 1024, 2) . ' KB';
      } elseif ($bytes > 1) {
          $bytes = $bytes . ' bytes';
      } elseif ($bytes == 1) {
          $bytes = $bytes . ' byte';
      } else {
          $bytes = '0 bytes';
      }

      return $bytes;
  }

  /**
   * compareFloatNumbers()
   * 
   * @param mixed $float1
   * @param mixed $float2
   * @param string $operator
   * @return
   */
  function compareFloatNumbers($float1, $float2, $operator='=')  
  {  
	  // Check numbers to 5 digits of precision  
	  $epsilon = 0.00001;  
		
	  $float1 = (float)$float1;  
	  $float2 = (float)$float2;  
		
	  switch ($operator)  
	  {  
		  // equal  
		  case "=":  
		  case "eq":  
			  if (abs($float1 - $float2) < $epsilon) {  
				  return true;  
			  }  
			  break;    
		  // less than  
		  case "<":  
		  case "lt":  
			  if (abs($float1 - $float2) < $epsilon) {  
				  return false;  
			  } else {  
				  if ($float1 < $float2) {  
					  return true;  
				  }  
			  }  
			  break;    
		  // less than or equal  
		  case "<=":  
		  case "lte":  
			  if (compareFloatNumbers($float1, $float2, '<') || compareFloatNumbers($float1, $float2, '=')) {  
				  return true;  
			  }  
			  break;    
		  // greater than  
		  case ">":  
		  case "gt":  
			  if (abs($float1 - $float2) < $epsilon) {  
				  return false;  
			  } else {  
				  if ($float1 > $float2) {  
					  return true;  
				  }  
			  }  
			  break;    
		  // greater than or equal  
		  case ">=":  
		  case "gte":  
			  if (compareFloatNumbers($float1, $float2, '>') || compareFloatNumbers($float1, $float2, '=')) {  
				  return true;  
			  }  
			  break;    
		
		  case "<>":  
		  case "!=":  
		  case "ne":  
			  if (abs($float1 - $float2) > $epsilon) {  
				  return true;  
			  }  
			  break;    
		  default:  
			  die("Unknown operator '".$operator."' in compareFloatNumbers()");    
	  }  
		
	  return false;  
  } 

  /**
   * numberToWords()
   * 
   * @param mixed $number
   * @return
   */
  function numberToWords($number)
  {
      $words = array(
          'zero',
          'one',
          'two',
          'three',
          'four',
          'five',
          'six',
          'seven',
          'eight',
          'nine',
          'ten',
          'eleven',
          'twelve',
          'thirteen',
          'fourteen',
          'fifteen',
          'sixteen',
          'seventeen',
          'eighteen',
          'nineteen',
          'twenty',
          30 => 'thirty',
          40 => 'fourty',
          50 => 'fifty',
          60 => 'sixty',
          70 => 'seventy',
          80 => 'eighty',
          90 => 'ninety',
          100 => 'hundred',
          1000 => 'thousand');
      $number_in_words = '';
      if (is_numeric($number)) {
          $number = (int)round($number);
          if ($number < 0) {
              $number = -$number;
              $number_in_words = 'minus ';
          }
          if ($number > 1000) {
              $number_in_words = $number_in_words . numberToWords(floor($number / 1000)) . " " . $words[1000];
              $hundreds = $number % 1000;
              $tens = $hundreds % 100;
              if ($hundreds > 100) {
                  $number_in_words = $number_in_words . ", " . numberToWords($hundreds);
              } elseif ($tens) {
                  $number_in_words = $number_in_words . " and " . numberToWords($tens);
              }
          } elseif ($number > 100) {
              $number_in_words = $number_in_words . numberToWords(floor($number / 100)) . " " . $words[100];
              $tens = $number % 100;
              if ($tens) {
                  $number_in_words = $number_in_words . " and " . numberToWords($tens);
              }
          } elseif ($number > 20) {
              $number_in_words = $number_in_words . " " . $words[10 * floor($number / 10)];
              $units = $number % 10;
              if ($units) {
                  $number_in_words = $number_in_words . numberToWords($units);
              }
          } else {
              $number_in_words = $number_in_words . " " . $words[$number];
          }
          return $number_in_words;
      }
      return false;
  }
  
  /**
   * wordsToNumber()
   * 
   * @param mixed $number
   * @return
   */
  function wordsToNumber($data) {
	$data = strtr(
		$data,
		array(
			'zero'      => '0',
			'a'         => '1',
			'one'       => '1',
			'two'       => '2',
			'three'     => '3',
			'four'      => '4',
			'five'      => '5',
			'six'       => '6',
			'seven'     => '7',
			'eight'     => '8',
			'nine'      => '9',
			'ten'       => '10',
			'eleven'    => '11',
			'twelve'    => '12',
			'thirteen'  => '13',
			'fourteen'  => '14',
			'fifteen'   => '15',
			'sixteen'   => '16',
			'seventeen' => '17',
			'eighteen'  => '18',
			'nineteen'  => '19',
			'twenty'    => '20',
			'thirty'    => '30',
			'forty'     => '40',
			'fourty'    => '40',
			'fifty'     => '50',
			'sixty'     => '60',
			'seventy'   => '70',
			'eighty'    => '80',
			'ninety'    => '90',
			'hundred'   => '100',
			'thousand'  => '1000',
			'million'   => '1000000',
			'billion'   => '1000000000',
			'and'       => '',
		)
	);
  
	$parts = array_map(
		function ($val) {
			return floatval($val);
		},
		preg_split('/[\s-]+/', $data)
	);
  
	$stack = new SplStack; 
	$sum   = 0; 
	$last  = null;
  
	foreach ($parts as $part) {
		if (!$stack->isEmpty()) {
			if ($stack->top() > $part) {
				if ($last >= 1000) {
					$sum += $stack->pop();
					$stack->push($part);
				} else {
					$stack->push($stack->pop() + $part);
				}
			} else {
				$stack->push($stack->pop() * $part);
			}
		} else {
			$stack->push($part);
		}
  
		$last = $part;
	}
  
	return $sum + $stack->pop();
  }

  /**
   * timesince()
   * 
   * @param int $original
   * @return
   */
  function timesince($original)
  {
      // array of time period chunks
      $chunks = array(
          array(60 * 60 * 24 * 365, 'yıl'),
          array(60 * 60 * 24 * 30, 'ay'),
          array(60 * 60 * 24 * 7, 'hafta'),
          array(60 * 60 * 24, 'gün'),
          array(60 * 60, 'saat'),
          array(60, 'dakika'),
          array(1, 'saniye'),
          );

      $today = time();
       /* Current unix time  */
      $since = $today - $original;

      // $j saves performing the count function each time around the loop
      for ($i = 0, $j = count($chunks); $i < $j; $i++) {
          $seconds = $chunks[$i][0];
          $name = $chunks[$i][1];

          // finding the biggest chunk (if the chunk fits, break)
          if (($count = floor($since / $seconds)) != 0) {
              break;
          }
      }

      $print = ($count == 1) ? '1 ' . $name : "$count {$name}";

      if ($i + 1 < $j) {
          // now getting the second item
          $seconds2 = $chunks[$i + 1][0];
          $name2 = $chunks[$i + 1][1];

          // add second item if its greater than 0
          if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
              $print .= ($count2 == 1) ? ', 1 ' . $name2 : " $count2 {$name2}";
          }
      }
      return $print . ' ' . Lang::$word->_AGO;
  } 

  /**
   * array_key_exists_wildcard()
   * 
   * @param mixed $array
   * @param mixed $search
   * @param string $return
   * @return
   */
  function array_key_exists_wildcard($array, $search, $return = '')
  {
      $search = str_replace('\*', '.*?', preg_quote($search, '/'));
      $result = preg_grep('/^' . $search . '$/i', array_keys($array));
      if ($return == 'key-value')
          return array_intersect_key($array, array_flip($result));
      return $result;
  }

  /**
   * array_value_exists_wildcard()
   * 
   * @param mixed $array
   * @param mixed $search
   * @param string $return
   * @return
   */
  function array_value_exists_wildcard($array, $search, $return = '')
  {
      $search = str_replace('\*', '.*?', preg_quote($search, '/'));
      $result = preg_grep('/^' . $search . '$/i', array_values($array));
      if ($return == 'key-value')
          return array_intersect($array, $result);
      return $result;
  }

  /**
   * searchforValue()
   * 
   * @param bool $value
   * @return
   */
  function searchforValue($array, $key, $value)
  {
	  if($array) {
		  foreach ($array as $val) {
			  if ($val->$key == $value) {
				  return true;
			  }
		  }
		  return false;
	  }
  }

  /**
   * findInArray()
   * 
   * @param mixed $array
   * @param mixed $val1
   * @param mixed $val2
   * @return
   */
  function findInArray($array, $val1, $val2)
  {
	  if($array) {
		  $result = array();
		  foreach ($array as $val) {
			  if ($val->$val1 == $val2) {
				  $result[] = $val;
			  }
		  }
		  return ($result) ? $result : 0;
	  }
  }

  /**
   * countInArray()
   * 
   * @param mixed $array
   * @param mixed $key
   * @param mixed $value
   * @return
   */
  function countInArray($array, $key, $value)
  {
      $i = 0;
      foreach ($array as $k => $v)
          $i++;      {
          if ($v->$key === $value)
              return $i;
      }
      return false;
  }
  
  /**
   * makeDir()
   * 
   * @param mixed $path
   * @param int $mode
   * @return
   */
  function makeDir($path)
  {
      $path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
      $e = explode("/", ltrim($path, "/"));
      if (substr($path, 0, 1) == "/") {
          $e[0] = "/" . $e[0];
      }
      $c = count($e);
      $cp = $e[0];
      for ($i = 1; $i < $c; $i++) {
          if (!is_dir($cp) && !@mkdir($cp, 0755)) {
              return false;
          }
          $cp .= "/" . $e[$i];
      }
      //return @mkdir($path, $mode);
	  @mkdir ($path, 0755);
	  return @chmod($path, 0755);
  }
    
  /**
   * dodate()
   * 
   * @param mixed $format
   * @param mixed $date
   * @return
   */
  function dodate($format, $date)
  {

      return strftime($format, strtotime($date));
  }

  /**
   * getTime()
   * 
   * @return
   */
  function getTime()
  {
      $timer = explode(' ', microtime());
      $timer = $timer[1] + $timer[0];
      return $timer;
  }
  /**
   * downloadFile()
   * 
   * @return
   */ 
  function downloadFile($fileLocation, $fileName, $maxSpeed = 5120)
  {
      if (connection_status() != 0)
          return (false);
		  
	  $extension = strtolower(substr($fileName, strrpos($fileName, '.') + 1));

      /* List of File Types */
      $fileTypes['swf'] = 'application/x-shockwave-flash';
      $fileTypes['pdf'] = 'application/pdf';
      $fileTypes['exe'] = 'application/octet-stream';
      $fileTypes['zip'] = 'application/zip';
      $fileTypes['doc'] = 'application/msword';
      $fileTypes['xls'] = 'application/vnd.ms-excel';
      $fileTypes['ppt'] = 'application/vnd.ms-powerpoint';
      $fileTypes['gif'] = 'image/gif';
      $fileTypes['png'] = 'image/png';
      $fileTypes['jpeg'] = 'image/jpg';
      $fileTypes['jpg'] = 'image/jpg';
      $fileTypes['rar'] = 'application/rar';

      $fileTypes['ra'] = 'audio/x-pn-realaudio';
      $fileTypes['ram'] = 'audio/x-pn-realaudio';
      $fileTypes['ogg'] = 'audio/x-pn-realaudio';

      $fileTypes['wav'] = 'video/x-msvideo';
      $fileTypes['wmv'] = 'video/x-msvideo';
      $fileTypes['avi'] = 'video/x-msvideo';
      $fileTypes['asf'] = 'video/x-msvideo';
      $fileTypes['divx'] = 'video/x-msvideo';

      $fileTypes['mp3'] = 'audio/mpeg';
      $fileTypes['mp4'] = 'audio/mpeg';
      $fileTypes['mpeg'] = 'video/mpeg';
      $fileTypes['mpg'] = 'video/mpeg';
      $fileTypes['mpe'] = 'video/mpeg';
      $fileTypes['mov'] = 'video/quicktime';
      $fileTypes['swf'] = 'video/quicktime';
      $fileTypes['3gp'] = 'video/quicktime';
      $fileTypes['m4a'] = 'video/quicktime';
      $fileTypes['aac'] = 'video/quicktime';
      $fileTypes['m3u'] = 'video/quicktime';

      $contentType = $fileTypes[$extension];


      header("Cache-Control: public");
      header("Content-Transfer-Encoding: binary\n");
      header('Content-Type: $contentType');

      $contentDisposition = 'attachment';

      if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
          $fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName, '.') - 1);
          header("Content-Disposition: $contentDisposition;filename=\"$fileName\"");
      } else {
          header("Content-Disposition: $contentDisposition;filename=\"$fileName\"");
      }

      header("Accept-Ranges: bytes");
      $range = 0;
      $size = filesize($fileLocation);

      if (isset($_SERVER['HTTP_RANGE'])) {
          list($a, $range) = explode("=", $_SERVER['HTTP_RANGE']);
          str_replace($range, "-", $range);
          $size2 = $size - 1;
          $new_length = $size - $range;
          header("HTTP/1.1 206 Partial Content");
          header("Content-Length: $new_length");
          header("Content-Range: bytes $range$size2/$size");
      } else {
          $size2 = $size - 1;
          header("Content-Range: bytes 0-$size2/$size");
          header("Content-Length: " . $size);
      }

      if ($size == 0) {
          die('Zero byte file! Aborting download');
      }

      $fp = fopen("$fileLocation", "rb");

      fseek($fp, $range);

      while (!feof($fp) and (connection_status() == 0)) {
          set_time_limit(0);
          print (fread($fp, 1024 * $maxSpeed));
          flush();
          ob_flush();
          sleep(1);
      }
      fclose($fp);

      exit;

      return ((connection_status() == 0) and !connection_aborted());
  } 
  



/**
 * formatSongDuration()
 * 
 * @param int $seconds
 * @return string formatted duration (e.g. 3:45)
 */
function formatSongDuration($seconds)
{
    return sprintf("%d:%02d", floor($seconds/60), $seconds%60);
}

/**
 * getTotalSongs()
 * 
 * @param int $album_id
 * @return int number of songs in album
 */
function getTotalSongs($album_id)
{
    return countEntries("muzibu_songs", "album_id", $album_id);
}

/**
 * getTotalAlbums()
 * 
 * @param int $artist_id
 * @return int number of albums by artist
 */
function getTotalAlbums($artist_id)
{
    return countEntries("muzibu_albums", "artist_id", $artist_id);
}

/**
 * getMuzibuImage()
 * 
 * @param string $folder (artists, albums, genres, playlists, sectors)
 * @param string $filename
 * @param string $default Default image if not found
 * @return string Full URL to image
 */
function getMuzibuImage($folder, $filename, $default = "default.jpg")
{
    if ($filename && file_exists(UPLOADS . "muzibu/" . $folder . "/" . $filename)) {
        return UPLOADURL . "muzibu/" . $folder . "/" . $filename;
    } else {
        return THEMEURL . "/assets/images/" . $default;
    }
}

/**
 * getLatestSongs()
 * 
 * @param int $limit
 * @return array Latest songs
 */
function getLatestSongs($limit = 10)
{
    $sql = "SELECT s.*, a.title" . Lang::$lang . " as artist_name, al.title" . Lang::$lang . " as album_name 
            FROM muzibu_songs as s
            LEFT JOIN muzibu_albums as al ON s.album_id = al.id
            LEFT JOIN muzibu_artists as a ON al.artist_id = a.id
            WHERE s.active = 1
            ORDER BY s.created DESC
            LIMIT " . intval($limit);
    
    $row = Registry::get("Database")->fetch_all($sql);
    return ($row) ? $row : 0;
}

/**
 * getFeaturedSongs()
 * 
 * @param int $limit
 * @return array Featured songs
 */
function getFeaturedSongs($limit = 10)
{
    $sql = "SELECT s.*, a.title" . Lang::$lang . " as artist_name, al.title" . Lang::$lang . " as album_name 
            FROM muzibu_songs as s
            LEFT JOIN muzibu_albums as al ON s.album_id = al.id
            LEFT JOIN muzibu_artists as a ON al.artist_id = a.id
            WHERE s.active = 1 AND s.is_featured = 1
            ORDER BY s.created DESC
            LIMIT " . intval($limit);
    
    $row = Registry::get("Database")->fetch_all($sql);
    return ($row) ? $row : 0;
}

/**
 * isFavoriteSong()
 * 
 * @param int $user_id
 * @param int $song_id
 * @return bool
 */
function isFavoriteSong($user_id, $song_id)
{
    $sql = "SELECT id FROM muzibu_favorites 
            WHERE user_id = " . intval($user_id) . " 
            AND song_id = " . intval($song_id) . " 
            LIMIT 1";
    
    $row = Registry::get("Database")->first($sql);
    return ($row) ? true : false;
}

/**
 * countFavorites()
 * 
 * @param int $user_id
 * @return int Number of favorite songs
 */
function countFavorites($user_id)
{
    return countEntries("muzibu_favorites", "user_id", $user_id);
}

/**
 * addSongPlay()
 * 
 * @param int $song_id
 * @param int $user_id
 * @return void
 */
function addSongPlay($song_id, $user_id = 0)
{
    $data = array(
        'song_id' => intval($song_id),
        'user_id' => intval($user_id),
        'ip_address' => $_SERVER['REMOTE_ADDR'],
        'created' => "NOW()"
    );
    
    Registry::get("Database")->insert("muzibu_song_plays", $data);
    
    // Ayrıca şarkının toplam oynatma sayısını artıralım
    $sql = "UPDATE muzibu_songs SET play_count = play_count + 1 WHERE id = " . intval($song_id);
    Registry::get("Database")->query($sql);
}

/**
 * getSongsByGenre()
 * 
 * @param int $genre_id
 * @param int $limit
 * @return array Songs by genre
 */
function getSongsByGenre($genre_id, $limit = 0)
{
    $sql = "SELECT s.*, a.title" . Lang::$lang . " as artist_name, al.title" . Lang::$lang . " as album_name 
            FROM muzibu_songs as s
            LEFT JOIN muzibu_albums as al ON s.album_id = al.id
            LEFT JOIN muzibu_artists as a ON al.artist_id = a.id
            WHERE s.active = 1 AND s.genre_id = " . intval($genre_id);
    
    if ($limit > 0) {
        $sql .= " LIMIT " . intval($limit);
    }
    
    $row = Registry::get("Database")->fetch_all($sql);
    return ($row) ? $row : 0;
}




	  


function tarih4($format, $datetime = 'now'){
    $z = date("$format", strtotime($datetime));
    $gun_dizi = array(
        'Monday'    => 'Pazartesi',
        'Tuesday'   => 'Salı',
        'Wednesday' => 'Çarşamba',
        'Thursday'  => 'Perşembe',
        'Friday'    => 'Cuma',
        'Saturday'  => 'Cumartesi',
        'Sunday'    => 'Pazar',
        'January'   => Lang::$word->_JAN,
        'February'  => Lang::$word->_FEB,
        'March'     => Lang::$word->_MAR,
        'April'     => Lang::$word->_APR,
        'May'       => Lang::$word->_MAY,
        'June'      => Lang::$word->_JUN,
        'July'      => Lang::$word->_JUL,
        'August'    => Lang::$word->_AUG,
        'September' => Lang::$word->_SEP,
        'October'   => Lang::$word->_OCT,
        'November'  => Lang::$word->_NOV,
        'December'  => Lang::$word->_DEC,
        'Mon'       => 'Pts',
        'Tue'       => 'Sal',
        'Wed'       => 'Çar',
        'Thu'       => 'Per',
        'Fri'       => 'Cum',
        'Sat'       => 'Cts',
        'Sun'       => 'Paz',
        'Jan'       => 'Oca',
        'Feb'       => 'Şub',
        'Mar'       => 'Mar',
        'Apr'       => 'Nis',
        'Jun'       => 'Haz',
        'Jul'       => 'Tem',
        'Aug'       => 'Ağu',
        'Sep'       => 'Eyl',
        'Oct'       => 'Eki',
        'Nov'       => 'Kas',
        'Dec'       => 'Ara',
    );
    foreach($gun_dizi as $en => $tr){
        $z = str_replace($en, $tr, $z);
    }
    if(strpos($z, 'Mayıs') !== false && strpos($format, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
    return $z;
	
	// tarih('j F Y','2017-08-15');
}
  
function tarih5($format, $datetime = 'now'){
    $z = date("$format", strtotime($datetime));
    $gun_dizi = array(
        '1'       => Lang::$word->_JA_,
        '2'       => Lang::$word->_FE_,
        '3'       => Lang::$word->_MA_,
        '4'       => Lang::$word->_AP_,
        '5'       => Lang::$word->_MY_,
        '6'       => Lang::$word->_JU_,
        '7'       => Lang::$word->_JL_,
        '8'       => Lang::$word->_AU_,
        '9'       => Lang::$word->_SE_,
        '10'       => Lang::$word->_OC_,
        '11'       => Lang::$word->_NO_,
        '12'       => Lang::$word->_DE_,
    );
    foreach($gun_dizi as $en => $tr){
        $z = str_replace($en, $tr, $z);
    }
    if(strpos($z, 'Mayıs') !== false && strpos($format, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
    return $z;
	
	// tarih('j F Y','2017-08-15');
}


function tarih3($format, $datetime = 'now'){
    $z = date("$format", strtotime($datetime));
    $gun_dizi = array(
        '01'       => 'Ocak',
        '02'       => 'Şubat',
        '03'       => 'Mart',
        '04'       => 'Nisan',
        '05'       => 'Mayıs',
        '06'       => 'Haziran',
        '07'       => 'Temmuz',
        '08'       => 'Ağustos',
        '09'       => 'Eylül',
        '10'       => 'Ekim',
        '11'       => 'Kasım',
        '12'       => 'Aralık',
    );
    foreach($gun_dizi as $en => $tr){
        $z = str_replace($en, $tr, $z);
    }
    if(strpos($z, 'Mayıs') !== false && strpos($format, 'F') === false) $z = str_replace('Mayıs', 'May', $z);
    return $z;
	
	// tarih('j F Y','2017-08-15');
}
  	  
function tarih($created){

	  $tarih = explode(" ", $created);
	  $date = explode("-", $tarih['0']);  $tarihsaat =  $date['2']. ' ' . tarih3($date['1']) . ' ' . $date['0'] . ' ' . $tarih['1'];

	  return $tarihsaat; 
}
	  
function tarih2($created){

	  $tarih = explode(" ", $created);
	  $date = explode("-", $tarih['0']);  $tarihsaat =  $date['2']. ' ' . tarih3($date['1']) . ' ' . $date['0'];

	  return $tarihsaat; 
}
	  
	# Ornekler 
	# $metin = "şirin ülkenin, çok özgün insanları"; 
	# $metin = buyuk($metin);  echo $metin."<br>"; 
	# $metin = kucuk($metin);  echo $metin."<br>"; 
	# $metin = ihb($metin);     echo $metin."<br>"; 
	# $metin = ikb($metin);     echo $metin."<br>"; 
	# $metin = tr2en($metin);          echo $metin."<br>"; 
	
	
	# Tumu buyuk harf 
  function buyuk($deger) 
	   { 
	   $deger = str_replace("ç","Ç",$deger); 
	   $deger = str_replace("ğ","Ğ",$deger); 
	   $deger = str_replace("ı","I",$deger); 
	   $deger = str_replace("i","İ",$deger); 
	   $deger = str_replace("ö","Ö",$deger); 
	   $deger = str_replace("ü","Ü",$deger); 
	   $deger = str_replace("ş","Ş",$deger); 

	   $deger = strtoupper($deger); 
	   $deger = trim($deger); 

	   return $deger; 
	   } 

	# Tumu kucuk harf 
  function kucuk($deger) 
	   { 
	   $deger = str_replace("Ç","ç",$deger); 
	   $deger = str_replace("Ğ","ğ",$deger); 
	   $deger = str_replace("I","ı",$deger); 
	   $deger = str_replace("İ","i",$deger); 
	   $deger = str_replace("Ö","ö",$deger); 
	   $deger = str_replace("Ü","ü",$deger); 
	   $deger = str_replace("Ş","ş",$deger); 

	   $deger = strtolower($deger); 
	   $deger = trim($deger); 

	   return $deger; 
	   } 

	# Ilk harf buyuk (cumle) 
  function ikb($deger) 
	   { 
	   $deger = split(" ",trim($deger)); 
	   $deger_tr = ""; 

	   for($x=0; $x < count($deger); $x++) 
		   { 
		   $deger_bas = substr($deger[$x],0,1); 
		   $deger_son = substr($deger[$x],1); 
		   $deger_bas = buyuk($deger_bas); 

	   $deger_bas = str_replace("ç","Ç",$deger_bas); 
	   $deger_bas = str_replace("ğ","Ğ",$deger_bas); 
	   $deger_bas = str_replace("ı","I",$deger_bas); 
	   $deger_bas = str_replace("i","İ",$deger_bas); 
	   $deger_bas = str_replace("ö","Ö",$deger_bas); 
	   $deger_bas = str_replace("ü","Ü",$deger_bas); 
	   $deger_bas = str_replace("ş","Ş",$deger_bas); 

	   $deger_bas = strtoupper($deger_bas); 
	   $deger_bas = trim($deger_bas); 

		   $deger_tr .= $deger_bas.$deger_son." "; 
		   } 

	   $deger_tr = trim($deger_tr); 

	   return $deger_tr; 
	   } 

	# Ilk harf buyuk (kelime) 
  function ihb($deger) 
	   { 
	   $deger_bas = substr($deger,0,1); 
	   $deger_son = substr($deger,1); 
	   $deger_bas = buyuk($deger_bas); 

	   $deger_tr  = $deger_bas.$deger_son; 
	   $deger_tr  = trim($deger_tr); 

	   return $deger_tr; 
	   } 
  

    /**
   * getir()
   * 
   * @return
   */
  function getir($what,$table,$where)
  {
	  global $db;
	  
	  $sql = "SELECT $what FROM $table $where";
	  $row = $db->fetch_all($sql);
	  
	  return ($row) ? $row : 0;
  }

  /**
   * getir()
   * 
   * @return
   */
  function getir2($what,$table1,$table2,$a,$b,$where)
  {
	  global $db;
	  
	  $sql = "SELECT $what FROM $table1 as a"
		  . "\n LEFT JOIN $table2 as b ON a.$a = b.$b" 
		  . "\n $where ";
	  $row = $db->fetch_all($sql);
	  
	  return ($row) ? $row : 0;
  }

  /**
   * geti()
   * 
   * @return
   */
  function geti($table,$where)
  {
	  global $db;
	  
	  $sql = "SELECT * FROM $table WHERE id = $where";
          $row = $db->first($sql);
	  
	  return ($row) ? $row : 0;
  }

  /**
   * geti2()
   * 
   * @return
   */
  function geti2($what,$table,$where)
  {
	  global $db;
	  
	  $sql = "SELECT $what FROM $table $where";
          $row = $db->first($sql);
	  
	  return ($row) ? $row : 0;
  } 
  
  function generateUniqueID($length = 11)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }
  
  function textToUL($text){

    // Satırları diziye dönüştür
    $lines = explode("\n", $text);
    
    // UL listesi oluştur
    echo "<ul>";
    foreach ($lines as $line) {
        echo "<li>" . htmlspecialchars(trim($line)) . "</li>";
    }
    echo "</ul>";
  }
  
  function getMP3Duration($path){
      require_once BASEPATH.'lib/getid3/getid3.php';
      $getID3 = new getID3;
      $fileInfo = $getID3->analyze(BASEPATH.'modules/muzibu/datafiles/songs/' . $path );
      $duration = $fileInfo['playtime_seconds'];
      
      return $duration;
      
  }
  
  function formatMP3Duration($seconds){
      $minutes = str_pad(intval($seconds / 60),2, "0", STR_PAD_LEFT);
      $seconds = str_pad($seconds % 60,2, "0", STR_PAD_LEFT);
      return $minutes.":".$seconds;
      
  }
  
  function randomString($length = 6, $includeNumbers = false) {
        // Harfler
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
        // Eğer sayılar da isteniyorsa karakter kümesine ekle
        if ($includeNumbers) {
            $characters .= '0123456789';
        }
    
        // String uzunluğu
        $charactersLength = strlen($characters);
        $randomString = '';
    
        // Rastgele karakterleri oluştur
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }
?>