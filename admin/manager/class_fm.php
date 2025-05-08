<?php
  /**
   * Filemanager Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: class_fm.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Filemanager
  {
      private static $base_dir;
      public $rel_dir;
      private $show_dir;
      public $cur_dir;
      private $dir_list = array();
      private $file_list = array();
      private $dir_count = 0;
      private $file_count = 0;
      private $cdirs = 0;
      private $cfiles = 0;
      const maxFile = 52428800;


      public static $fileext = array(
          ".gif",
          ".jpg",
          ".jpeg",
          ".bmp",
          ".png",
          ".txt",
          ".nfo",
          ".doc",
          ".docx",
          ".xls",
          ".xlsx",
          ".htm",
          ".html",
          ".zip",
          ".rar",
          ".tar",
          ".css",
          ".pdf",
          ".swf",
          ".avi",
          ".mp4",
          ".ogv",
          ".webm",
          ".mp3");

      const DS = '/';


      /**
       * Filemanager::__construct()
       * 
       * @return
       */
      function __construct()
      {
          global $core;

          self::$base_dir = str_replace("\\", "/", UPLOADS);

          if (isset($_REQUEST['cdir'])) {
              $this->rel_dir = str_replace("../", "", $_REQUEST['cdir']);
              $this->rel_dir = str_replace(".", "", $_REQUEST['cdir']);
              $this->rel_dir = str_replace("\\", "/", $_REQUEST['cdir']);
          } else {
              $this->rel_dir = null;
          }

          $this->renderAll();

      }


      /**
       * Filemanager::renderAll()
       * 
       * @return
       */
      public function renderAll()
      {
          global $core;

          if (is_dir(UPLOADS . $this->rel_dir) and opendir(UPLOADS . $this->rel_dir) == true) {
              $handler = opendir(UPLOADS . $this->rel_dir);
              $this->cur_dir = self::$base_dir . $this->rel_dir;
              $fileurl = UPLOADURL . self::DS . $this->rel_dir;
          } else {
              $handler = opendir(UPLOADS);
              $this->cur_dir = UPLOADS;
              $fileurl = UPLOADURL . self::DS;
              $this->rel_dir = null;
          }
          $parent_dir = str_replace('.', '', dirname($this->rel_dir));
          $dirs = $files = array();

          while (false !== ($file = readdir($handler))) {

              if ($file != "." && $file != ".." && $file != "Thumbs" && $file != ".htaccess" && $file != "index.php") {
                  if (filetype($this->cur_dir . self::DS . $file) == 'dir') {

                      $link = UPLOADS . str_replace(UPLOADS, '', $this->rel_dir) . self::DS . $file;
                      $link = preg_replace("#/+#", "/", $link);

                      $dirs[] = array(
                          'name' => $file,
                          'path' => self::fixPath(ltrim($this->rel_dir . self::DS . $file, "/")),
                          'link' => $link,
                          'size' => 0,
                          'type' => 'dir',
                          'time' => filemtime($this->cur_dir . self::DS . $file),
                          'ftime' => date('d-m-Y', filemtime($this->cur_dir . self::DS . $file)),
                          'ext' => 'folder.png');

                  } else {
                      $link = str_replace(UPLOADURL, '', $fileurl) . self::DS . $file;
                      $link = UPLOADURL . preg_replace("#/+#", "/", $link);

                      $ext = explode(".", $this->cur_dir . self::DS . $file, strlen($this->cur_dir . self::DS . $file));
                      $extn = $ext[count($ext) - 1];
                      $showimg = '<a href="' . $link . '" class="fancybox" title="' . $file . '">' . $file . '</a>';

                      $files[] = array(
                          'name' => self::getFileType($file) == 'image' ? $showimg : $file,
                          'fname' => $file,
                          'path' => ltrim($this->rel_dir . self::DS . $file, "/"),
                          'size' => self::getSize(filesize($this->cur_dir . self::DS . $file)),
                          'fsize' => filesize($this->cur_dir . self::DS . $file),
                          'type' => self::getFileType($file),
                          'time' => filemtime($this->cur_dir . self::DS . $file),
                          'ftime' => date('d-m-Y', filemtime($this->cur_dir . self::DS . $file)),
                          'ext' => self::_getFileType($extn),
                          'link' => $link);
                  }
              }
          }


          closedir($handler);

          if ($this->rel_dir != '') {

              $link = str_replace(UPLOADS, '', $parent_dir);
              $link = ltrim($link, '/\\');

              array_unshift($dirs, array(
                  'name' => _FM_GOBACK,
                  'path' => '..',
                  'link' => 'index.php?do=filemanager&amp;cdir=' . $link,
                  'size' => 0,
                  'type' => 'back',
                  'time' => 0,
                  'buffer' => false,
                  ));
          }

          $breadcrumb = array();
          $next = '';
          $back = _HOME . '/' . str_replace(UPLOADS, '', trim($this->rel_dir, '/'));
          $back = explode('/', $back);
          foreach ($back as $key => $backlink) {
              if ($backlink != _HOME) {
                  $next .= self::DS . $backlink;
                  $next = ltrim($next, '/');
              }
              if (empty($this->rel_dir)) {
                  $crumbs[_HOME] = 'index.php?do=filemanager';
              } else {
                  $crumbs[$backlink] = 'index.php?do=filemanager&amp;cdir=' . $next;
              }
          }
          $this->dir_count = count($dirs) - 1;
          $this->file_count = count($files);

          return array(
              'dirs' => $dirs,
              'files' => $files,
              'crumbs' => $crumbs,
              'dir_count' => $this->dir_count,
              'file_count' => $this->file_count,
              'directory' => $this->rel_dir);
      }

      /**
       * Filemanager::dozip()
       * 
       * @param mixed $zipfiles
       * @param mixed $cur_dir
       * @return
       */
      public function dozip($zipfiles, $cur_dir)
      {
          $destination = preg_replace("#/+#", "/", UPLOADS . $cur_dir . '/archive_' . time() . '.zip');
          if (substr($destination, -4, 4) != '.zip') {
              $destination = $destination . '.zip';
          }

          $zip = new ZipArchive();
          if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
              print 'Archive could not be created';
          }

          $startdir = str_replace('\\', '/', UPLOADS . $cur_dir);

          foreach ($zipfiles as $source) {
              $source = UPLOADS . $source;
              $source = str_replace('\\', '/', $source);

              if (is_dir($source) === true) {
                  $subdir = str_replace($startdir . '/', '', $source) . '/';
                  $zip->addEmptyDir($subdir);
                  $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

                  foreach ($files as $file) {
                      $file = str_replace('\\', '/', $file);
                      if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
                          continue;

                      if (is_dir($file) === true) {
                          $zip->addEmptyDir($subdir . str_replace($source . '/', '', $file . '/'));
                      } else
                          if (is_file($file) === true) {
                              $zip->addFromString($subdir . str_replace($source . '/', '', $file), file_get_contents($file));
                          }
                  }
              } else
                  if (is_file($source) === true) {
                      $zip->addFromString(basename($source), file_get_contents($source));
                  }
          }

          $zip->close();

          $html = '<tr id="fileid_' . time() . '" class="added-list">';
          $html .= '<th><img src="manager/images/mime/zip.png" alt="" /></th>';
          $html .= '<td class="left">' . basename($destination) . '</td>';
          $html .= '<td class="left">' . self::getSize(filesize($destination)) . '</td>';
          $html .= '<td class="left">' . date('d-m-Y', time()) . '</td>';
          $html .= '<th class="firstrow">';
          $html .= '<div class="ez-checkbox" id="file-added-' . time() . '">';
          $html .= '<input id="multif-' . time() . '" class="ez-hide" type="checkbox" value="' . preg_replace("#/+#", "/", $cur_dir . self::DS . basename($destination)) . '" name="multif[]" />';
          $html .= '</div>';
          $html .= '</th>';
          $html .= '<th class="firstrow">';
          $html .= '<a href="javascript:void(0);" id="item-options_' . time() . '" data-name="' . basename($destination) . '" 
			data-path="' . preg_replace("#/+#", "/", $cur_dir . self::DS . basename($destination)) . '">';
          $html .= '<img src="images/mod-config.png" alt="" /></a></th>';
          $html .= '</tr>';

          $json['type'] = 'success';
          $json['message'] = $html;
          $json['info'] = '<div class="msgOk">' . str_replace('[FILENAME]', basename($destination), _FM_ZIPOK) . '</div>';
          print json_encode($json);
      }


	  /**
	   * unzipFile()
	   * 
	   * @param mixed $file
	   * @param mixed $path
	   * @return
	   */
	  public function unzipFile($file, $path)
	  {
	
		  if (!extension_loaded('zip')) {
			  print ('Zip PHP module is not installed on this server');
			  die;
		  }
	
		  $file = UPLOADS . $file;
	
		  $zip = zip_open($file);
		  if (!$zip)
			  print ("Unable to proccess file '{$file}'");
	
		  while ($zip_entry = zip_read($zip)) {
			  $zdir = dirname(zip_entry_name($zip_entry));
			  $zname = zip_entry_name($zip_entry);
	
			  if (!zip_entry_open($zip, $zip_entry, "r")) {
				  print "Unable to proccess file '{$zname}'";
				  continue;
			  }
	
			  if (!is_dir(UPLOADS . $path . self::DS . $zdir)) {
				  mkdir(UPLOADS . $path . self::DS . $zdir);
			  }
	
			  if (!is_dir(UPLOADS . $path . self::DS . $zname) && substr($zname, -1, 1) == "/") {
				  mkdir(UPLOADS . $path . self::DS . $zname);
				  continue;
			  }
	
			  $zip_fs = zip_entry_filesize($zip_entry);
				  if (empty($zip_fs)) {
				  @touch(UPLOADS . $path . self::DS . $zname);
				  continue;
			  }
	
			  $zz = zip_entry_read($zip_entry, $zip_fs);
	
			  $z = fopen(UPLOADS . $path . self::DS . $zname, "w");
			  fwrite($z, $zz);
			  fclose($z);
			  zip_entry_close($zip_entry);
	
		  }
		  zip_close($zip);
	
		  return;
	  }

      /**
       * Filemanager::renameFile()
       * 
       * @param mixed $old_name
       * @param mixed $new_name
       * @param mixed $base
       * @return
       */
      public function renameFile($old_name, $new_name, $base)
      {
          if (!file_exists($new_name)) {
              rename($old_name, $new_name);

              $link = UPLOADURL . self::DS . preg_replace("#/+#", "/", $base . self::DS . basename($new_name));

              $ext = explode(".", $new_name, strlen($this->cur_dir . self::DS . $new_name));
              $extn = $ext[count($ext) - 1];
              $showimg = '<a href="' . $link . '" class="fancybox" title="' . basename($new_name) . '">' . basename($new_name) . '</a>';
              $name = self::getFileType($new_name) == 'image' ? $showimg : basename($new_name);

              $html = '<tr id="fileid_' . time() . '" class="added-list">';
              $html .= '<th><img src="manager/images/mime/' . $extn . '.png" /></th>';
              $html .= '<td class="left">' . $name . '</td>';
              $html .= '<td class="left">' . self::getSize(filesize($new_name)) . '</td>';
              $html .= '<td class="left">' . date('d-m-Y', time()) . '</td>';
              $html .= '<th class="firstrow">';
              $html .= '<div class="ez-checkbox" id="file-added-' . time() . '">';
              $html .= '<input id="multif-' . time() . '" class="ez-hide" type="checkbox" value="' . preg_replace("#/+#", "/", $base . self::DS . basename($new_name)) . '" name="multif[]" />';
              $html .= '</div>';
              $html .= '</th>';
              $html .= '<th class="firstrow">';
              $html .= '<a href="javascript:void(0);" id="item-options_' . time() . '" data-name="' . basename($new_name) . '" 
		  data-path="' . preg_replace("#/+#", "/", $base . self::DS . basename($new_name)) . '">';
              $html .= '<img src="images/mod-config.png" alt="" /></a></th>';
              $html .= '</tr>';

              $json['type'] = 'success';
              $json['message'] = $html;
              $json['uid'] = time();
              $json['info'] = '<div class="msgOk">' . str_replace('[FILENAME]', basename($old_name), _FM_FILE_REN_OK) . '</div>';
              print json_encode($json);

          } else {
              $json['message'] = '<div class="msgAlert">' . str_replace('[FILENAME]', basename($old_name), _FM_FILE_REN_I) . '</div>';
              print json_encode($json);
          }
          return;
      }

      /**
       * Filemanager::renameDir()
       * 
       * @param mixed $old_name
       * @param mixed $new_name
       * @param mixed $base
       * @return
       */
      public function renameDir($old_name, $new_name, $base)
      {
          if (!file_exists(rtrim($new_name, "/"))) {
              rename(rtrim($old_name, "/"), rtrim($new_name, "/"));

              $html = '<tr id="dirid_' . time() . '">';
              $html .= '<th><img src="manager/images/mime/folder.png" /></th>';
              $html .= '<td class="left"><a href="index.php?do=filemanager&amp;cdir=' . preg_replace("#/+#", "/", $base . self::DS . basename($new_name)) . '">' . basename($new_name) . '</a></td>';
              $html .= '<td class="left">&nbsp;</td>';
              $html .= '<td class="left">' . date('d-m-Y', time()) . '</td>';
              $html .= '<th class="firstrow">';
              $html .= '<div class="ez-checkbox" id="folder-added-' . time() . '">';
              $html .= '<input id="multid-' . time() . '" class="ez-hide" type="checkbox" value="' . preg_replace("#/+#", "/", $base . self::DS . basename($new_name)) . '" name="multid[]" />';
              $html .= '</div>';
              $html .= '</th>';
              $html .= '<th class="firstrow">';
              $html .= '<a href="javascript:void(0);" id="folder-options_' . time() . '" data-name="' . basename($new_name) . '" data-path="' . preg_replace("#/+#", "/", $base . self::DS . basename($new_name)) . '">';
              $html .= '<img src="images/mod-config.png" alt="" /></a></th>';
              $html .= '</tr>';

              $json['type'] = 'success';
              $json['message'] = $html;
              $json['uid'] = time();
              $json['info'] = '<div class="msgOk">' . str_replace('[FILENAME]', basename($old_name), _FM_FILE_REN_OK) . '</div>';
              print json_encode($json);

          } else {
              $json['message'] = '<div class="msgAlert">' . str_replace('[FILENAME]', basename($old_name), _FM_FILE_REN_I) . '</div>';
              print json_encode($json);
          }
          return;
      }

      /**
       * Filemanager::delete()
       * 
       * @param mixed $path
       * @param string $name
       * @return
       */
      public function delete($path, $name = '')
      {
          global $core;
		  
          if (is_dir(UPLOADS . $path)) {
              if ($this->purge(UPLOADS . $path)) {
                  if ($name) {
                      $core->msgOK(_FM_DIR_DEL_OK1 . '<strong> ' . $name . ' </strong>' . _FM_DIR_DEL_OK2);
                  } else
                      return true;
              } else
                  $core->msgOK(_FM_DIR_DEL_ERR . '<strong> ' . $name . ' </strong>');
          } elseif (file_exists(UPLOADS . $path)) {
              if (unlink(UPLOADS . $path)) {
                  if ($name) {
                      $core->msgOK(_FM_FILE_OK1 . '<strong> ' . $name . ' </strong>' . _FM_FILE_OK2);
                  } else
                      return true;
              } else
                  $core->msgOK(_FM_FILE_ERR . '<strong> ' . $name . ' </strong>');
          } else
              $core->msgError(_FM_DEL_ERR2);
      }

      /**
       * Filemanager::purge()
       * 
       * @param mixed $dir
       * @param bool $delroot
       * @return
       */
      private function purge($dir, $delroot = true)
      {
          if (!$dh = @opendir($dir))
              return;

          while (false !== ($obj = readdir($dh))) {
              if ($obj == '.' || $obj == '..' || $obj == 'index.php' || $obj == 'index.html')
                  continue;

              if (!@unlink($dir . '/' . $obj))
                  $this->purge($dir . '/' . $obj, true);
          }

          closedir($dh);

          if ($delroot)
              @rmdir($dir);
          return true;
      }

      /**
       * Filemanager::makeDirectory()
       * 
       * @param mixed $path
       * @param mixed $name
       * @return
       */
      public function makeDirectory($path, $name)
      {
          if (mkdir(UPLOADS . $path . $name)) {
              $html = '<tr id="dirid_' . time() . '">';
              $html .= '<th><img src="manager/images/mime/folder.png" /></th>';
              $html .= '<td class="left"><a href="index.php?do=filemanager&amp;cdir=' . preg_replace("#/+#", "/", $path . self::DS . $name) . '">' . $name . '</a></td>';
              $html .= '<td class="left">&nbsp;</td>';
              $html .= '<td class="left">' . date('d-m-Y', time()) . '</td>';
              $html .= '<th class="firstrow">';
              $html .= '<div class="ez-checkbox" id="folder-added-' . time() . '">';
              $html .= '<input id="multid-' . time() . '" class="ez-hide" type="checkbox" value="' . preg_replace("#/+#", "/", $path . self::DS . $name) . '" name="multid[]" />';
              $html .= '</div>';
              $html .= '</th>';
              $html .= '<th class="firstrow">';
              $html .= '<a href="javascript:void(0);" id="folder-options_' . time() . '" data-name="' . $name . '" data-path="' . preg_replace("#/+#", "/", $path . self::DS . $name) . '">';
              $html .= '<img src="images/mod-config.png" alt="" /></a></th>';
              $html .= '</tr>';

              $dirs = UPLOADS . $path;
              $json['type'] = 'success';
              $json['message'] = $html;
              $json['uid'] = time();
              $json['info'] = '<div class="msgOk">' . _FM_DIR_OK1 . '<strong> ' . $name . ' </strong>' . _FM_DIR_OK2 . '</div>';
              $json['dcount'] = (count(glob("$dirs/*", GLOB_ONLYDIR)));
              print json_encode($json);
          } else {
              $json['message'] = '<div class="msgError">' . _FM_DIR_ERR . '<strong> ' . $name . ' </strong>' . '</div>';
              print json_encode($json);


          }
      }

      /**
       * Filemanager::makeFile()
       * 
       * @param mixed $path
       * @param mixed $name
       * @return
       */
      public function makeFile($path, $name)
      {
          if (!file_exists(UPLOADS . $path . $name)) {
              touch(UPLOADS . $path . $name);

              $link = UPLOADURL . self::DS . preg_replace("#/+#", "/", $path . self::DS . $name);

              $ext = explode(".", $name, strlen($this->cur_dir . self::DS . $name));
              $extn = $ext[count($ext) - 1];
              $showimg = '<a href="' . $link . '" class="fancybox" title="' . $name . '">' . $name . '</a>';
              $name = self::getFileType($name) == 'image' ? $showimg : $name;

              $html = '<tr id="fileid_' . time() . '" class="added-list">';
              $html .= '<th><img src="manager/images/mime/' . $extn . '.png" /></th>';
              $html .= '<td class="left">' . $name . '</td>';
              $html .= '<td class="left">0 B</td>';
              $html .= '<td class="left">' . date('d-m-Y', time()) . '</td>';
              $html .= '<th class="firstrow">';
              $html .= '<div class="ez-checkbox" id="file-added-' . time() . '">';
              $html .= '<input id="multif-' . time() . '" class="ez-hide" type="checkbox" value="' . preg_replace("#/+#", "/", $path . self::DS . $name) . '" name="multif[]" />';
              $html .= '</div>';
              $html .= '</th>';
              $html .= '<th class="firstrow">';
              $html .= '<a href="javascript:void(0);" id="item-options_' . time() . '" data-name="' . $name . '" 
			  data-path="' . preg_replace("#/+#", "/", $path . self::DS . $name) . '">';
              $html .= '<img src="images/mod-config.png" alt="" /></a></th>';
              $html .= '</tr>';

              $dirs = UPLOADS . $path;
              $json['type'] = 'success';
              $json['message'] = $html;
              $json['uid'] = time();
              $json['info'] = '<div class="msgOk">' . _FM_FILENAME1 . $name . _FM_FILENAME2 . '</div>';
              print json_encode($json);
          } else {
              $json['message'] = '<div class="msgError">' . _FM_FILENAME_ERR . '<strong> ' . $name . ' </strong>' . '</div>';
              print json_encode($json);
          }
      }

      /**
       * Filemanager::copyAll()
       * 
       * @param mixed $source
       * @param mixed $dest
       * @return
       */
      public function copyAll($source, $dest)
      {
          global $core;
		  
          foreach ($source as $file) {
              if (strpos(self::fixPath(UPLOADS . $dest . self::DS . $file), self::fixPath(UPLOADS . $file . self::DS)) !== false) {
                  continue;
              }

              $this->xcopy(UPLOADS . $file, UPLOADS . $dest . self::DS . $file);
          }
          print '<div class="msgOk">' . _FM_COPY_OK . '</div>';
      }

      /**
       * Filemanager::xcopy()
       * 
       * @param mixed $source
       * @param mixed $dest
       * @return
       */
      private function xcopy($source, $dest)
      {
          if (is_file($source)) {
              return copy($source, $dest);
          }

          if (!is_dir($dest)) {
              mkdir($dest);
          }

          $dir = dir($source);
          while (false !== $entry = $dir->read()) {
              if ($entry == '.' || $entry == '..') {
                  continue;
              }

              $this->xcopy($source . self::DS . $entry, $dest . self::DS . $entry);
          }

          $dir->close();

          return true;
      }

      /**
       * Filemanager::moveFiles()
       * 
       * @param mixed $source
       * @param mixed $dest
       * @return
       */
	  public function moveFiles($source, $dest)
	  {
		  foreach($source as $file){
			  if ($file == '.' || $file == '..') return false;
			  if (!file_exists(self::fixPath(UPLOADS . $dest . self::DS . basename($file)))){
                  if (strpos(self::fixPath(UPLOADS . $dest . self::DS . basename($file)), self::fixPath(UPLOADS . $file . self::DS)) !== false) {
					  continue;
				  }
				  rename(self::fixPath(UPLOADS . $file), self::fixPath(UPLOADS . $dest . self::DS . basename($file)));
			  }
		  }
		  return;
	  }
	
      /**
       * Filemanager::listDirectories()
       * 
       * @param mixed $dir
       * @param integer $subdir
       * @return
       */
      public function listDirectories($dir = UPLOADS, $subdir = 0)
      {
          if (!is_dir($dir)) {
              return false;
          }

          $scan = scandir($dir);
          foreach ($scan as $key => $val) {
              if ($val[0] == ".") {
                  continue;
              }

              if (is_dir($dir . "/" . $val)) {
                  echo "<option value=\"" . str_replace(UPLOADS, "", $dir . "/" . $val) . "\">" . str_repeat("&#166;&nbsp;&nbsp;&nbsp;&nbsp;", $subdir) . $val . "</option>\n";
                  if ($val[0] != ".") {
                      $this->listDirectories($dir . "/" . $val, $subdir + 1);
                  }
              }
          }

          return true;
      }


      /**
       * Filemanager::getSize()
       * 
       * @param mixed $bytes
       * @param integer $precision
       * @return
       */
      public static function getSize($bytes, $precision = 0)
      {
          $units = array(
              'B',
              'KB',
              'MB',
              'GB',
              'TB');

          $bytes = max($bytes, 0);
          $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
          $pow = min($pow, count($units) - 1);

          $bytes /= pow(1024, $pow);

          return round($bytes, $precision) . ' ' . $units[$pow];
      }

      /**
       * Filemanager::getFileType()
       * 
       * @param mixed $filename
       * @return
       */
      public static function getFileType($filename)
      {
          if (preg_match("/^.*\.(jpg|jpeg|png|gif|bmp)$/i", $filename) != 0) {
              return 'image';

          } elseif (preg_match("/^.*\.(txt|css|php|sql|js)$/i", $filename) != 0) {
              return 'text';

          } elseif (preg_match("/^.*\.(zip)$/i", $filename) != 0) {
              return 'zip';
          }
          return 'generic';
      }

      /**
       * Filemanager::_getFileType()
       * 
       * @param mixed $extn
       * @return
       */
      private static function _getFileType($extn)
      {
          switch ($extn) {
              case "css":
                  return "css.png";
                  break;

              case "csv":
                  return "csv.png";
                  break;

              case "fla":
              case "swf":
                  return "fla.png";
                  break;

              case "mp3":
              case "wav":
                  return "mp3.png";
                  break;

              case "jpg":
              case "JPG":
              case "gif":
              case "png":
                  return "jpg.png";
                  break;

              case "bmp":
              case "dib":
                  return "bmp.png";
                  break;

              case "txt":
              case "log":
              case "sql":
                  return "txt.png";
                  break;

              case "js":
                  echo "js.png";
                  break;

              case "pdf":
                  return "pdf.png";
                  break;

              case "zip":
              case "rar":
              case "tgz":
              case "gz":
                  return "zip.png";
                  break;

              case "doc":
              case "rtf":
                  return "doc.png";
                  break;

              case "asp":
              case "jsp":
                  echo "asp.png";
                  break;

              case "php":
                  return "php.png";
                  break;

              case "htm":
              case "html":
                  return "htm.png";
                  break;

              case "ppt":
                  return "ppt.png";
                  break;

              case "exe":
              case "bat":
              case "com":
                  return "exe.png";
                  break;

              case "wmv":
              case "mpg":
              case "mpeg":
              case "wma":
              case "asf":
                  return "wmv.png";
                  break;

              case "midi":
              case "mid":
                  return "midi.png";
                  break;

              case "mov":
                  return "mov.png";
                  break;

              case "psd":
                  return "psd.png";
                  break;

              case "ram":
              case "rm":
                  return "rm.png";
                  break;

              case "xml":
                  return "xml.png";
                  break;

              default:
                  return "file.png";
                  break;
          }

      }

      /**
       * Filemanager::fixPath()
       * 
       * @param mixed $path
       * @return
       */
      public static function fixPath($path)
      {
          $path = str_replace('\\', '/', $path);
          $path = preg_replace("#/+#", "/", $path);
          return $path;
      }

      /**
       * Filemanager::fixNames()
       * 
       * @param mixed $string
       * @param bool $strict
       * @return
       */
      public static function fixNames($string, $strict = true)
      {
          $strip = array(
              "..",
              "*",
              "\n");
          if ($strict)
              array_push($strip, "/", "\\");
          $clean = trim(str_replace($strip, "_", sanitize($string)));

          return $clean;
      }

      /**
       * Filemanager::doUpload()
       * 
       * @param mixed $cur_dir
       * @return
       */
      public function doUpload($cur_dir)
      {
          $filedir = preg_replace("#/+#", "/", UPLOADS . $cur_dir . '/');
          if (self::validateUpload($filedir, $cur_dir) == true) {
              move_uploaded_file($_FILES['filedata']['tmp_name'], $filedir . $_FILES['filedata']['name']);

              $ext = explode(".", $_FILES['filedata']['name'], strlen($_FILES['filedata']['name']));
              $extn = $ext[count($ext) - 1];
              $link = UPLOADURL . self::DS . preg_replace("#/+#", "/", $cur_dir . self::DS . $_FILES["filedata"]["name"]);
              $showimg = '<a href="' . $link . '" class="fancybox" title="' . $_FILES['filedata']['name'] . '">' . $_FILES['filedata']['name'] . '</a>';

              self::doJason(array(
                  "success" => true,
                  "id" => $_POST["fileid"],
                  "instanceid" => self::isXhrMethod() ? "" : $_POST["instanceid"],
                  "appendFiles" => true,
                  "file" => array(
                      "name" => self::getFileType($_FILES["filedata"]["name"]) == 'image' ? $showimg : $_FILES["filedata"]["name"],
					  "fname" => $_FILES["filedata"]["name"],
                      "mime" => $_FILES["filedata"]["type"],
                      "size" => $_FILES["filedata"]["size"],
                      "id" => $_POST["fileid"],
                      'path' => ltrim($cur_dir . self::DS . $_FILES["filedata"]["name"], "/"),
                      'ext' => self::_getFileType($extn),
                      'type' => self::getFileType($_FILES["filedata"]["name"]),
                      'ftime' => date('d-m-Y', time()),
                      'fsize' => self::getSize($_FILES["filedata"]["size"]),
                      'link' => $link,
                      "rel_dir" => $cur_dir,
                      )));
          }
      }

      /**
       * Filemanager::doJason()
       * 
       * @param mixed $result
       * @return
       */
      public static function doJason($result)
      {
          $json = json_encode($result);

          if (self::isXhrMethod()) {
              header("Content-Type: application/json");
              echo $json;
          } else {
              $instanceid = $result['instanceid'];
              echo "
			<script type=\"text/javascript\">
				parent.jQuery.fn.FileUploader.Instances['" . $instanceid . "'].onComplete(eval('(" . $json . ")'));
			</script>";
          }
      }

      /**
       * Filemanager::getFileExt()
       * 
       * @return
       */
      private static function getFileExt()
      {
          $name = $_FILES["filedata"]["name"];
          $parts = explode(".", $name);
          $last = sizeof($parts) - 1;

          return (sizeof($parts) < 2) ? "" : (sizeof($parts) < 2) ? "" : "." . strtolower($parts[$last]);
      }


      /**
       * Filemanager::isXhrMethod()
       * 
       * @return
       */
      private static function isXhrMethod()
      {
          return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
      }

      /**
       * Filemanager::isPostMethod()
       * 
       * @return
       */
      private static function isPostMethod()
      {
          return ($_SERVER["REQUEST_METHOD"] == "POST" or self::isXhrMethod());
      }

      /**
       * Filemanager::validateUpload()
       * 
       * @param mixed $cur_dir
       * @param mixed $rel_dir
       * @return
       */
      private static function validateUpload($cur_dir, $rel_dir)
      {
          if (!self::isPostMethod()) {
              self::doJason(array("success" => false, "message" => "This request type is not supported"));
              return false;
          }

          if (isset($_POST["fileid"]) == false) {
              self::doJason(array("success" => false, "message" => "No file was identified"));
              return false;
          }

          if (sizeof($_FILES) == 0) {
              self::doJason(array(
                  "success" => false,
                  "message" => "No file can be detected",
                  "instanceid" => $_POST["instanceid"],
                  "id" => $_POST["fileid"]));
              return false;
          }

          if (self::maxFile != null && self::maxFile < $_FILES["filedata"]["size"]) {
              self::doJason(array(
                  "success" => false,
                  "message" => str_replace("[LIMIT]", getSize(self::maxFile), _FM_ERRFILESIZE_T),
                  "id" => $_POST["fileid"],
                  "instanceid" => self::isXhrMethod() ? "" : $_POST["instanceid"],
                  "file" => array(
                      "name" => $_FILES["filedata"]["name"],
                      "mime" => $_FILES["filedata"]["type"],
                      "size" => $_FILES["filedata"]["size"],
                      "id" => $_POST["fileid"])));

              return false;
          }

          if (self::$fileext != null && in_array(self::getFileExt(), self::$fileext) == false) {
              self::doJason(array(
                  "success" => false,
                  "message" => str_replace("[FILETYPES]", implode(", ", self::$fileext), _FM_FILEINFO),
                  "id" => $_POST["fileid"],
                  "instanceid" => self::isXhrMethod() ? "" : $_POST["instanceid"],
                  "file" => array(
                      "name" => $_FILES["filedata"]["name"],
                      "mime" => $_FILES["filedata"]["type"],
                      "size" => $_FILES["filedata"]["size"],
                      "id" => $_POST["fileid"])));

              return false;
          }

          if (!is_dir(preg_replace("#/+#", "/", $cur_dir . '/'))) {
              self::doJason(array(
                  "success" => false,
                  "message" => _FM_UPLDIR,
                  "id" => $_POST["fileid"],
                  "instanceid" => self::isXhrMethod() ? "" : $_POST["instanceid"],
                  "file" => array(
                      "name" => $_FILES["filedata"]["name"],
                      "mime" => $_FILES["filedata"]["type"],
                      "size" => $_FILES["filedata"]["size"],
                      "id" => $_POST["fileid"])));

              return false;
          }

          if (!is_writeable(preg_replace("#/+#", "/", $cur_dir . '/'))) {
              self::doJason(array(
                  "success" => false,
                  "message" => str_replace("[DIRNAME]", $rel_dir . '/', _FM_DIRNW),
                  "id" => $_POST["fileid"],
                  "instanceid" => self::isXhrMethod() ? "" : $_POST["instanceid"],
                  "file" => array(
                      "name" => $_FILES["filedata"]["name"],
                      "mime" => $_FILES["filedata"]["type"],
                      "size" => $_FILES["filedata"]["size"],
                      "id" => $_POST["fileid"])));

              return false;
          }

          return true;
      }

  }
?>