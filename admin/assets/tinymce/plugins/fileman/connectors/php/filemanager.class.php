<?php

  /**
   * Filemanager Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: Filemanager.class.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Filemanager
  {

      protected $config = array();
      protected $language = array();
      protected $get = array();
      protected $post = array();
      protected $properties = array();
      protected $item = array();
      protected $languages = array();
      protected $allowed_actions = array();
      protected $root = '';
      protected $doc_root = '';
      protected $dynamic_fileroot = '';
      protected $cachefolder = '_thumbs/';
      protected $thumbnail_width = 64;
      protected $thumbnail_height = 64;
      protected $separator = 'userfiles';

      /**
       * Filemanager::__construct()
       * 
       * @param string $extraConfig
       * @return
       */
      public function __construct($extraConfig = '')
      {

          $data = $this->config();
		  $cgf = json_encode($data);
		  $config = json_decode($cgf, true);

          $this->config = $config;

          // override config options if needed
          if (!empty($extraConfig)) {
              $this->setup($extraConfig);
          }

          $this->root = dirname(dirname(dirname(__file__))) . DIRECTORY_SEPARATOR;
          $this->properties = array(
              'Date Created' => null,
              'Date Modified' => null,
              'Height' => null,
              'Width' => null,
              'Size' => null);

          if ($this->config['options']['fileRoot'] !== false) {
              if ($this->config['options']['serverRoot'] === true) {
                  $this->doc_root = $_SERVER['DOCUMENT_ROOT'];
                  $this->separator = basename($this->config['options']['fileRoot']);
              } else {
                  $this->doc_root = $this->config['options']['fileRoot'];
                  $this->separator = basename($this->config['options']['fileRoot']);
              }
          } else {
              $this->doc_root = $_SERVER['DOCUMENT_ROOT'];
          }

          $this->setParams();
          $this->setPermissions();
          $this->availableLanguages();
          $this->loadLanguageFile();
      }

      private function config() {
		  $base_dir = '/' . Registry::get("Core")->site_dir . '/uploads/';
		  $array = array(
			  "options" => array(
				  "culture" => "en",
				  "lang" => "php",
				  "defaultViewMode" => "grid",
				  "autoload" => true,
				  "showFullPath" => false,
				  "showTitleAttr" => false,
				  "browseOnly" => false,
				  "showConfirmation" => true,
				  "showThumbs" => true,
				  "generateThumbnails" => false,
				  "searchBox" => false,
				  "listFiles" => true,
				  "fileSorting" => "default",
				  "chars_only_latin" => true,
				  "dateFormat" => "d M Y H:i",
				  "serverRoot" => true,
				  "fileRoot" => $base_dir,
				  "relPath" => false,
				  "logger" => false,
				  "capabilities" => array(
					  "select",
					  "download",
					  "rename",
					  "delete",
					  "replace"),
				  "plugins" => array()),
		
			  "security" => array(
				  "allowChangeExtensions" => false,
				  "allowNoExtension" => false,
				  "uploadPolicy" => "DISALLOW_ALL",
				  "uploadRestrictions" => array(
					  "jpg",
					  "jpeg",
					  "gif",
					  "png",
					  "svg",
					  "txt",
					  "pdf",
					  "odp",
					  "ods",
					  "odt",
					  "rtf",
					  "doc",
					  "docx",
					  "xls",
					  "xlsx",
					  "ppt",
					  "pptx",
					  "csv",
					  "ogv",
					  "mp4",
					  "webm",
					  "m4v",
					  "ogg",
					  "mp3",
					  "wav")),
		
			  "upload" => array(
				  "overwrite" => false,
				  "imagesOnly" => false,
				  "fileSizeLimit" => 16),
		
			  "exclude" => array(
				  "unallowed_files" => array(".htaccess", "web.config"),
				  "unallowed_dirs" => array(
					  "._thumbs",
					  ".CDN_ACCESS_LOGS",
					  "cloudservers"),
				  "unallowed_files_REGEXP" => "/^\\./",
				  "unallowed_dirs_REGEXP" => "/^\\./"),
		
			  "images" => array("imagesExt" => array(
					  "jpg",
					  "jpeg",
					  "gif",
					  "png",
					  "svg"), "resize" => array(
					  "enabled" => true,
					  "maxWidth" => 1280,
					  "maxHeight" => 1024)),
		
			  "videos" => array(
				  "showVideoPlayer" => true,
				  "videosExt" => array(
					  "ogv",
					  "mp4",
					  "webm",
					  "m4v"),
				  "videosPlayerWidth" => 400,
				  "videosPlayerHeight" => 222),
		
			  "audios" => array(
				  "showAudioPlayer" => true, 
				  "audiosExt" => array(
					  "ogg",
					  "mp3",
					  "wav")),
					  
			  "edit" => array(
				  "enabled"=> false,
				  "lineNumbers"=> true,
				  "lineWrapping"=> true,
				  "codeHighlight"=> false,
				  "theme"=> "elegant",
				  "editExt" => array(
					  "txt",
					  "csv",
					  "wav")),
					  
			  "extras" => array(
				  "extra_js_async"=> true,
				  "extra_js" => array(
					  "txt",
					  "csv",
					  "wav")),
					  
			  "icons" => array(
				  "path"=> "images/fileicons/",
				  "directory"=> "_Open.png",
				  "default"=> "default.png")
			  );
			  
			  return $array;
        }
      /**
       * Filemanager::setup()
       * 
       * @param mixed $extraconfig
       * @return
       */
      public function setup($extraconfig)
      {

          $this->config = array_replace_recursive($this->config, $extraconfig);

      }

      // allow Filemanager to be used with dynamic folders
      /**
       * Filemanager::setFileRoot()
       * 
       * @param mixed $path
       * @return
       */
      public function setFileRoot($path)
      {

          if ($this->config['options']['serverRoot'] === true) {
              $this->doc_root = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;
          } else {
              $this->doc_root = $path;
          }

          // necessary for retrieving path when set dynamically with $fm->setFileRoot() method
          $this->dynamic_fileroot = str_replace($_SERVER['DOCUMENT_ROOT'], '', $this->doc_root);
          $this->separator = basename($this->doc_root);

      }

      /**
       * Filemanager::error()
       * 
       * @param mixed $string
       * @param bool $textarea
       * @return
       */
      public function error($string, $textarea = false)
      {
          $array = array(
              'Error' => $string,
              'Code' => '-1',
              'Properties' => $this->properties);


          if ($textarea) {
              echo '<textarea>' . json_encode($array) . '</textarea>';
          } else {
              echo json_encode($array);
          }
          die();
      }

      /**
       * Filemanager::lang()
       * 
       * @param mixed $string
       * @return
       */
      public function lang($string)
      {
          if (isset($this->language[$string]) && $this->language[$string] != '') {
              return $this->language[$string];
          } else {
              return 'Language string error on ' . $string;
          }
      }

      /**
       * Filemanager::getvar()
       * 
       * @param mixed $var
       * @param mixed $preserve
       * @return
       */
      public function getvar($var, $preserve = null)
      {
          if (!isset($_GET[$var]) || $_GET[$var] == '') {
              $this->error(sprintf($this->lang('INVALID_VAR'), $var));
          } else {
              $this->get[$var] = $this->sanitize($_GET[$var], $preserve);
              return true;
          }
      }
      /**
       * Filemanager::postvar()
       * 
       * @param mixed $var
       * @param bool $sanitize
       * @return
       */
      public function postvar($var, $sanitize = true)
      {
          if (!isset($_POST[$var]) || $_POST[$var] == '') {
              $this->error(sprintf($this->lang('INVALID_VAR'), $var));
          } else {
              if ($sanitize) {
                  $this->post[$var] = $this->sanitize($_POST[$var]);
              } else {
                  $this->post[$var] = $_POST[$var];
              }
              return true;
          }
      }

      /**
       * Filemanager::getinfo()
       * 
       * @return
       */
      public function getinfo()
      {
          $this->item = array();
          $this->item['properties'] = $this->properties;
          $this->get_file_info('', false);

          // handle path when set dynamically with $fm->setFileRoot() method
          if ($this->dynamic_fileroot != '') {
              $path = $this->dynamic_fileroot . $this->get['path'];
              $path = preg_replace('~/+~', '/', $path); // remove multiple slashes
          } else {
              $path = $this->get['path'];
          }

          if (in_array(strtolower($this->item['filetype']), array_map('strtolower', $this->config['images']['imagesExt']))) {
              $dpath = $path;
          } else {
              $dpath = $this->config['icons']['path'] . strtolower($this->item['filetype']) . '.png';
          }
          $array = array(
              'Path' => $path,
              'Filename' => $this->item['filename'],
              'File Type' => $this->item['filetype'],
              'Preview' => $dpath,
              'Properties' => $this->item['properties'],
              'Error' => "",
              'Code' => 0);
          return $array;


      }

      /**
       * Filemanager::getfolder()
       * 
       * @return
       */
      public function getfolder()
      {
          $array = array();
          $filesDir = array();

          $current_path = $this->getFullPath();


          if (!$this->isValidPath($current_path)) {
              $this->error("No way.");
          }

          if (!is_dir($current_path)) {
              $this->error(sprintf($this->lang('DIRECTORY_NOT_EXIST'), $this->get['path']));
          }
          if (!$handle = opendir($current_path)) {
              $this->error(sprintf($this->lang('UNABLE_TO_OPEN_DIRECTORY'), $this->get['path']));
          } else {
              while (false !== ($file = readdir($handle))) {
                  if ($file != "." && $file != "..") {
                      array_push($filesDir, $file);
                  }
              }
              closedir($handle);

              // By default
              // Sorting files by name ('default' or 'NAME_DESC' cases from $this->config['options']['fileSorting']
              natcasesort($filesDir);

              foreach ($filesDir as $file) {

                  if (is_dir($current_path . $file)) {
                      if (!in_array($file, $this->config['exclude']['unallowed_dirs']) && !preg_match($this->config['exclude']['unallowed_dirs_REGEXP'], $file)) {
                          $array[$this->get['path'] . $file . '/'] = array(
                              'Path' => $this->get['path'] . $file . '/',
                              'Filename' => $file,
                              'File Type' => 'dir',
                              'Preview' => $this->config['icons']['path'] . $this->config['icons']['directory'],
                              'Properties' => array(
                                  'Date Created' => date($this->config['options']['dateFormat'], filectime($this->getFullPath($this->get['path'] . $file . '/'))),
                                  'Date Modified' => date($this->config['options']['dateFormat'], filemtime($this->getFullPath($this->get['path'] . $file . '/'))),
                                  'filemtime' => filemtime($this->getFullPath($this->get['path'] . $file . '/')),
                                  'Height' => null,
                                  'Width' => null,
                                  'Size' => null),
                              'Error' => "",
                              'Code' => 0);
                      }
                  } else
                      if (!in_array($file, $this->config['exclude']['unallowed_files']) && !preg_match($this->config['exclude']['unallowed_files_REGEXP'], $file)) {
                          $this->item = array();
                          $this->item['properties'] = $this->properties;
                          $this->get_file_info($this->get['path'] . $file, true);

                          if (!isset($this->params['type']) || (isset($this->params['type']) && strtolower($this->params['type']) == 'images' && in_array(strtolower($this->item['filetype']), array_map
                              ('strtolower', $this->config['images']['imagesExt'])))) {
                              if ($this->config['upload']['imagesOnly'] == false || ($this->config['upload']['imagesOnly'] == true && in_array(strtolower($this->item['filetype']), array_map('strtolower',
                                  $this->config['images']['imagesExt'])))) {
                                  $array[$this->get['path'] . $file] = array(
                                      'Path' => $this->get['path'] . $file,
                                      'Filename' => $this->item['filename'],
                                      'File Type' => $this->item['filetype'],
                                      'Preview' => $this->item['preview'],
                                      'Properties' => $this->item['properties'],
                                      'Error' => "",
                                      'Code' => 0);
                              }
                          }
                      }
              }
          }

          $array = $this->sortFiles($array);

          return $array;
      }


      /**
       * Filemanager::editfile()
       * 
       * @return
       */
      public function editfile()
      {

          $current_path = $this->getFullPath();

          if (!$this->has_permission('edit') || !$this->isValidPath($current_path) || !$this->isEditable($current_path)) {
              $this->error("No way.");
          }


          $content = file_get_contents($current_path);
          $content = htmlspecialchars($content);

          if (!$content) {
              $this->error(sprintf($this->lang('ERROR_OPENING_FILE')));
          }

          $array = array(
              'Error' => "",
              'Code' => 0,
              'Path' => $this->get['path'],
              'Content' => $this->formatPath($content));

          return $array;
      }

      /**
       * Filemanager::savefile()
       * 
       * @return
       */
      public function savefile()
      {

          $current_path = $this->getFullPath($this->post['path']);

          if (!$this->has_permission('edit') || !$this->isValidPath($current_path) || !$this->isEditable($current_path)) {
              $this->error("No way.");
          }

          if (!is_writable($current_path)) {
              $this->error(sprintf($this->lang('ERROR_WRITING_PERM')));
          }


          $content = htmlspecialchars_decode($this->post['content']);
          $r = file_put_contents($current_path, $content, LOCK_EX);

          if (!is_numeric($r)) {
              $this->error(sprintf($this->lang('ERROR_SAVING_FILE')));
          }

          $array = array(
              'Error' => "",
              'Code' => 0,
              'Path' => $this->formatPath($this->post['path']));

          return $array;
      }

      /**
       * Filemanager::rename()
       * 
       * @return
       */
      public function rename()
      {

          $suffix = '';

          if (substr($this->get['old'], -1, 1) == '/') {
              $this->get['old'] = substr($this->get['old'], 0, (strlen($this->get['old']) - 1));
              $suffix = '/';
          }
          $tmp = explode('/', $this->get['old']);
          $filename = $tmp[(sizeof($tmp) - 1)];
          $path = str_replace('/' . $filename, '', $this->get['old']);

          $new_file = $this->getFullPath($path . '/' . $this->get['new']) . $suffix;
          $old_file = $this->getFullPath($this->get['old']) . $suffix;

          if (!$this->has_permission('rename') || !$this->isValidPath($old_file)) {
              $this->error("No way.");
          }

          // For file only - we check if the new given extension is allowed regarding the security Policy settings
          if (is_file($old_file) && $this->config['security']['allowChangeExtensions'] && !$this->isAllowedFileType($new_file)) {
              $this->error(sprintf($this->lang('INVALID_FILE_TYPE')));
          }


          if (file_exists($new_file)) {
              if ($suffix == '/' && is_dir($new_file)) {
                  $this->error(sprintf($this->lang('DIRECTORY_ALREADY_EXISTS'), $this->get['new']));
              }
              if ($suffix == '' && is_file($new_file)) {
                  $this->error(sprintf($this->lang('FILE_ALREADY_EXISTS'), $this->get['new']));
              }
          }

          if (!rename($old_file, $new_file)) {
              if (is_dir($old_file)) {
                  $this->error(sprintf($this->lang('ERROR_RENAMING_DIRECTORY'), $filename, $this->get['new']));
              } else {
                  $this->error(sprintf($this->lang('ERROR_RENAMING_FILE'), $filename, $this->get['new']));
              }
          }
          $array = array(
              'Error' => "",
              'Code' => 0,
              'Old Path' => $this->get['old'],
              'Old Name' => $filename,
              'New Path' => $path . '/' . $this->get['new'] . $suffix,
              'New Name' => $this->get['new']);
          return $array;
      }

      /**
       * Filemanager::move()
       * 
       * @return
       */
      public function move()
      {

          // dynamic fileroot dir must be used when enabled
          $rootDir = $this->dynamic_fileroot;

          if (empty($rootDir)) {
              $rootDir = $this->get['root'];
          }
          $rootDir = str_replace('//', '/', $rootDir);
          $oldPath = $this->getFullPath($this->get['old']);

          // old path
          $tmp = explode('/', trim($this->get['old'], '/'));
          $fileName = array_pop($tmp); // file name or new dir name
          $path = '/' . implode('/', $tmp) . '/';

          // new path
          if (substr($this->get['new'], 0, 1) != "/") {
              // make path relative from old dir
              $newPath = $path . '/' . $this->get['new'] . '/';
          } else {
              $newPath = $rootDir . '/' . $this->get['new'] . '/';
          }

          $newPath = preg_replace('#/+#', '/', $newPath);
          $newPath = $this->expandPath($newPath, true);

          //!important! check that we are still under ROOT dir
          if (strncasecmp($newPath, $rootDir, strlen($rootDir))) {
              $this->error(sprintf($this->lang('INVALID_DIRECTORY_OR_FILE'), $this->get['new']));
          }

          if (!$this->has_permission('move') || !$this->isValidPath($oldPath)) {
              $this->error("No way.");
          }

          $newRelativePath = $newPath;
          $newPath = $this->getFullPath($newPath);

          // check if file already exists
          if (file_exists($newPath . $fileName)) {
              if (is_dir($newPath . $fileName)) {
                  $this->error(sprintf($this->lang('DIRECTORY_ALREADY_EXISTS'), rtrim($this->get['new'], '/') . '/' . $fileName));
              } else {
                  $this->error(sprintf($this->lang('FILE_ALREADY_EXISTS'), rtrim($this->get['new'], '/') . '/' . $fileName));
              }
          }

          // create dir if not exists
          if (!file_exists($newPath)) {
              if (!mkdir($newPath, 0755, true)) {
                  $this->error(sprintf($this->lang('UNABLE_TO_CREATE_DIRECTORY'), $newPath));
              }
          }

          // move
          if (!rename($oldPath, $newPath . $fileName)) {
              if (is_dir($oldPath)) {
                  $this->error(sprintf($this->lang('ERROR_RENAMING_DIRECTORY'), $path, $this->get['new']));
              } else {
                  $this->error(sprintf($this->lang('ERROR_RENAMING_FILE'), $path . $fileName, $this->get['new']));
              }
          }

          $array = array(
              'Error' => "",
              'Code' => 0,
              'Old Path' => $path,
              'Old Name' => $fileName,
              'New Path' => $this->formatPath($newRelativePath),
              'New Name' => $fileName,
              );
          return $array;
      }

      /**
       * Filemanager::delete()
       * 
       * @return
       */
      public function delete()
      {

          $current_path = $this->getFullPath();
          $thumbnail_path = $this->get_thumbnail_path($current_path);

          if (!$this->has_permission('delete') || !$this->isValidPath($current_path)) {
              $this->error("No way.");
          }

          if (is_dir($current_path)) {

              $this->unlinkRecursive($current_path);

              // we remove thumbnails if needed
              $this->unlinkRecursive($thumbnail_path);

              $array = array(
                  'Error' => "",
                  'Code' => 0,
                  'Path' => $this->formatPath($this->get['path']));

              return $array;

          } else
              if (file_exists($current_path)) {

                  unlink($current_path);

                  // delete thumbail if exists
                  if (file_exists($thumbnail_path))
                      unlink($thumbnail_path);

                  $array = array(
                      'Error' => "",
                      'Code' => 0,
                      'Path' => $this->formatPath($this->get['path']));

                  return $array;

              } else {
                  $this->error(sprintf($this->lang('INVALID_DIRECTORY_OR_FILE')));
              }
      }

      /**
       * Filemanager::replace()
       * 
       * @return
       */
      public function replace()
      {

          $this->setParams();

          if (!isset($_FILES['fileR']) || !is_uploaded_file($_FILES['fileR']['tmp_name'])) {

              // if fileSize limit set by the user is greater than size allowed in php.ini file, we apply server restrictions
              // and log a warning into file
              if ($this->config['upload']['fileSizeLimit'] > $this->getMaxUploadFileSize()) {
                  $this->config['upload']['fileSizeLimit'] = $this->getMaxUploadFileSize();
                  $this->error(sprintf($this->lang('UPLOAD_FILES_SMALLER_THAN'), $this->config['upload']['fileSizeLimit'] . $this->lang('mb')), true);
              }

              $this->error(sprintf($this->lang('INVALID_FILE_UPLOAD') . ' ' . sprintf($this->lang('UPLOAD_FILES_SMALLER_THAN'), $this->config['upload']['fileSizeLimit'] . $this->lang('mb'))), true);
          }
          // we determine max upload size if not set
          if ($this->config['upload']['fileSizeLimit'] == 'auto') {
              $this->config['upload']['fileSizeLimit'] = $this->getMaxUploadFileSize();
          }

          if ($_FILES['fileR']['size'] > ($this->config['upload']['fileSizeLimit'] * 1024 * 1024)) {
              $this->error(sprintf($this->lang('UPLOAD_FILES_SMALLER_THAN'), $this->config['upload']['fileSizeLimit'] . $this->lang('mb')), true);
          }

          // we check the given file has the same extension as the old one
          if (strtolower(pathinfo($_FILES['fileR']['name'], PATHINFO_EXTENSION)) != strtolower(pathinfo($this->post['newfilepath'], PATHINFO_EXTENSION))) {
              $this->error(sprintf($this->lang('ERROR_REPLACING_FILE') . ' ' . pathinfo($this->post['newfilepath'], PATHINFO_EXTENSION)), true);
          }

          if (!$this->isAllowedFileType($_FILES['fileR']['name'])) {
              $this->error(sprintf($this->lang('INVALID_FILE_TYPE')), true);
          }

          // we check if extension is allowed regarding the security Policy settings
          if (!$this->isAllowedFileType($_FILES['fileR']['name'])) {
              $this->error(sprintf($this->lang('INVALID_FILE_TYPE')), true);
          }

          // we check if only images are allowed
          if ($this->config['upload']['imagesOnly'] || (isset($this->params['type']) && strtolower($this->params['type']) == 'images')) {
              if (!($size = @getimagesize($_FILES['fileR']['tmp_name']))) {
                  $this->error(sprintf($this->lang('UPLOAD_IMAGES_ONLY')), true);
              }
              if (!in_array($size[2], array(
                  1,
                  2,
                  3,
                  7,
                  8))) {
                  $this->error(sprintf($this->lang('UPLOAD_IMAGES_TYPE_JPEG_GIF_PNG')), true);
              }
          }

          $current_path = $this->getFullPath($this->post['newfilepath']);

          if (!$this->has_permission('replace') || !$this->isValidPath($current_path)) {
              $this->error("No way.");
          }

          move_uploaded_file($_FILES['fileR']['tmp_name'], $current_path);

          // we delete thumbnail if file is image and thumbnail already
          if ($this->is_image($current_path) && file_exists($this->get_thumbnail($current_path))) {
              unlink($this->get_thumbnail($current_path));
          }

          // automatically resize image if it's too big
          $imagePath = $current_path;
          if ($this->is_image($imagePath) && $this->config['images']['resize']['enabled']) {
              if ($size = @getimagesize($imagePath)) {
                  if ($size[0] > $this->config['images']['resize']['maxWidth'] || $size[1] > $this->config['images']['resize']['maxHeight']) {
                      require_once ('./inc/vendor/wideimage/lib/WideImage.php');

                      $image = WideImage::load($imagePath);
                      $resized = $image->resize($this->config['images']['resize']['maxWidth'], $this->config['images']['resize']['maxHeight'], 'inside');
                      $resized->saveToFile($imagePath);

                  }
              }
          }

          chmod($current_path, 0644);

          $response = array(
              'Path' => dirname($this->post['newfilepath']),
              'Name' => basename($this->post['newfilepath']),
              'Error' => "",
              'Code' => 0);


          echo '<textarea>' . json_encode($response) . '</textarea>';
          die();
      }

      /**
       * Filemanager::add()
       * 
       * @return
       */
      public function add()

      {

          $this->setParams();

          if (!isset($_FILES['newfile']) || !is_uploaded_file($_FILES['newfile']['tmp_name'])) {

              // if fileSize limit set by the user is greater than size allowed in php.ini file, we apply server restrictions
              // and log a warning into file
              if ($this->config['upload']['fileSizeLimit'] > $this->getMaxUploadFileSize()) {
                  $this->config['upload']['fileSizeLimit'] = $this->getMaxUploadFileSize();
                  $this->error(sprintf($this->lang('UPLOAD_FILES_SMALLER_THAN'), $this->config['upload']['fileSizeLimit'] . $this->lang('mb')), true);
              }

              $this->error(sprintf($this->lang('INVALID_FILE_UPLOAD') . ' ' . sprintf($this->lang('UPLOAD_FILES_SMALLER_THAN'), $this->config['upload']['fileSizeLimit'] . $this->lang('mb'))), true);
          }
          // we determine max upload size if not set
          if ($this->config['upload']['fileSizeLimit'] == 'auto') {
              $this->config['upload']['fileSizeLimit'] = $this->getMaxUploadFileSize();
          }

          if ($_FILES['newfile']['size'] > ($this->config['upload']['fileSizeLimit'] * 1024 * 1024)) {
              $this->error(sprintf($this->lang('UPLOAD_FILES_SMALLER_THAN'), $this->config['upload']['fileSizeLimit'] . $this->lang('mb')), true);
          }

          // we check if extension is allowed regarding the security Policy settings
          if (!$this->isAllowedFileType($_FILES['newfile']['name'])) {
              $this->error(sprintf($this->lang('INVALID_FILE_TYPE')), true);
          }

          // we check if only images are allowed
          if ($this->config['upload']['imagesOnly'] || (isset($this->params['type']) && strtolower($this->params['type']) == 'images')) {
              if (!($size = @getimagesize($_FILES['newfile']['tmp_name']))) {
                  $this->error(sprintf($this->lang('UPLOAD_IMAGES_ONLY')), true);
              }
              if (!in_array($size[2], array(
                  1,
                  2,
                  3,
                  7,
                  8))) {
                  $this->error(sprintf($this->lang('UPLOAD_IMAGES_TYPE_JPEG_GIF_PNG')), true);
              }
          }
          $_FILES['newfile']['name'] = $this->cleanString($_FILES['newfile']['name'], array('.', '-'));

          $current_path = $this->getFullPath($this->post['currentpath']);

          if (!$this->isValidPath($current_path)) {
              $this->error("No way.");
          }

          if (!$this->config['upload']['overwrite']) {
              $_FILES['newfile']['name'] = $this->checkFilename($current_path, $_FILES['newfile']['name']);
          }
          move_uploaded_file($_FILES['newfile']['tmp_name'], $current_path . $_FILES['newfile']['name']);

          chmod($current_path . $_FILES['newfile']['name'], 0644);

          $response = array(
              'Path' => $this->post['currentpath'],
              'Name' => $_FILES['newfile']['name'],
              'Error' => "",
              'Code' => 0);


          echo '<textarea>' . json_encode($response) . '</textarea>';
          die();
      }

      /**
       * Filemanager::addfolder()
       * 
       * @return
       */
      public function addfolder()
      {

          $current_path = $this->getFullPath();

          if (!$this->isValidPath($current_path)) {
              $this->error("No way.");
          }
          if (is_dir($current_path . $this->get['name'])) {
              $this->error(sprintf($this->lang('DIRECTORY_ALREADY_EXISTS'), $this->get['name']));

          }
          $newdir = $this->cleanString($this->get['name']);
          if (!mkdir($current_path . $newdir, 0755)) {
              $this->error(sprintf($this->lang('UNABLE_TO_CREATE_DIRECTORY'), $newdir));
          }
          $array = array(
              'Parent' => $this->get['path'],
              'Name' => $this->get['name'],
              'Error' => "",
              'Code' => 0);

          return $array;
      }

      /**
       * Filemanager::download()
       * 
       * @return
       */
      public function download()
      {

          $current_path = $this->getFullPath();

          if (!$this->has_permission('download') || !$this->isValidPath($current_path)) {
              $this->error("No way.");
          }

          // we check if extension is allowed regarding the security Policy settings
          if (!$this->isAllowedFileType(basename($current_path))) {
              $this->error(sprintf($this->lang('INVALID_FILE_TYPE')), true);
          }

          if (isset($this->get['path']) && file_exists($current_path)) {
              header("Content-type: application/force-download");
              header('Content-Disposition: inline; filename="' . basename($current_path) . '"');
              header("Content-Transfer-Encoding: Binary");
              header("Content-length: " . filesize($current_path));
              header('Content-Type: application/octet-stream');
              header('Content-Disposition: attachment; filename="' . basename($current_path) . '"');
              readfile($current_path);
              exit();
          } else {
              $this->error(sprintf($this->lang('FILE_DOES_NOT_EXIST'), $current_path));
          }
      }

      /**
       * Filemanager::preview()
       * 
       * @param mixed $thumbnail
       * @return
       */
      public function preview($thumbnail)
      {

          $current_path = $this->getFullPath();

          if (isset($this->get['path']) && file_exists($current_path)) {

              // if $thumbnail is set to true we return the thumbnail
              if ($this->config['options']['generateThumbnails'] == true && $thumbnail == true) {
                  // get thumbnail (and create it if needed)
                  $returned_path = $this->get_thumbnail($current_path);
              } else {
                  $returned_path = $current_path;
              }

              header("Content-type: image/" . strtolower(pathinfo($returned_path, PATHINFO_EXTENSION)));
              header("Content-Transfer-Encoding: Binary");
              header("Content-length: " . filesize($returned_path));
              header('Content-Disposition: inline; filename="' . basename($returned_path) . '"');
              readfile($returned_path);

              exit();

          } else {
              $this->error(sprintf($this->lang('FILE_DOES_NOT_EXIST'), $current_path));
          }
      }

      /**
       * Filemanager::getMaxUploadFileSize()
       * 
       * @return
       */
      public function getMaxUploadFileSize()
      {

          $max_upload = (int)ini_get('upload_max_filesize');
          $max_post = (int)ini_get('post_max_size');
          $memory_limit = (int)ini_get('memory_limit');

          $upload_mb = min($max_upload, $max_post, $memory_limit);


          return $upload_mb;
      }

      /**
       * Filemanager::setParams()
       * 
       * @return
       */
      private function setParams()
      {
          $tmp = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/');
          $tmp = explode('?', $tmp);
          $params = array();
          if (isset($tmp[1]) && $tmp[1] != '') {
              $params_tmp = explode('&', $tmp[1]);
              if (is_array($params_tmp)) {
                  foreach ($params_tmp as $value) {
                      $tmp = explode('=', $value);
                      if (isset($tmp[0]) && $tmp[0] != '' && isset($tmp[1]) && $tmp[1] != '') {
                          $params[$tmp[0]] = $tmp[1];
                      }
                  }
              }
          }
          $this->params = $params;
      }

      /**
       * Filemanager::setPermissions()
       * 
       * @return
       */
      private function setPermissions()
      {

          $this->allowed_actions = $this->config['options']['capabilities'];

          if ($this->config['edit']['enabled'])
              array_push($this->allowed_actions, 'edit');

      }


      /**
       * Filemanager::get_file_info()
       * 
       * @param string $path
       * @param bool $thumbnail
       * @return
       */
      private function get_file_info($path = '', $thumbnail = false)
      {

          // DO NOT  rawurlencode() since $current_path it
          // is used for displaying name file
          if ($path == '') {
              $current_path = $this->get['path'];
          } else {
              $current_path = $path;
          }
          $tmp = explode('/', $current_path);
          $this->item['filename'] = $tmp[(sizeof($tmp) - 1)];

          $tmp = explode('.', $this->item['filename']);
          $this->item['filetype'] = $tmp[(sizeof($tmp) - 1)];
          $this->item['filemtime'] = filemtime($this->getFullPath($current_path));
          $this->item['filectime'] = filectime($this->getFullPath($current_path));

          $this->item['preview'] = $this->config['icons']['path'] . $this->config['icons']['default'];

          if (is_dir($current_path)) {

              $this->item['preview'] = $this->config['icons']['path'] . $this->config['icons']['directory'];

          } else
              if (in_array(strtolower($this->item['filetype']), array_map('strtolower', $this->config['images']['imagesExt']))) {

                  // svg should not be previewed as raster formats images
                  if ($this->item['filetype'] == 'svg') {
                      $this->item['preview'] = $current_path;
                  } else {
                      $this->item['preview'] = SITEURL . '/thumbmaker.php?src=' . $current_path . '&amp;h=' . $this->thumbnail_width . '&amp;w=' . $this->thumbnail_height;
                  }

                  $this->item['properties']['Size'] = filesize($this->getFullPath($current_path));
                  if ($this->item['properties']['Size']) {
                      list($width, $height, $type, $attr) = getimagesize($this->getFullPath($current_path));
                  } else {
                      $this->item['properties']['Size'] = 0;
                      list($width, $height) = array(0, 0);
                  }
                  $this->item['properties']['Height'] = $height;
                  $this->item['properties']['Width'] = $width;
                  $this->item['properties']['Size'] = filesize($this->getFullPath($current_path));


              } else
                  if (file_exists($this->root . $this->config['icons']['path'] . strtolower($this->item['filetype']) . '.png')) {

                      $this->item['preview'] = $this->config['icons']['path'] . strtolower($this->item['filetype']) . '.png';
                      $this->item['properties']['Size'] = filesize($this->getFullPath($current_path));
                      if (!$this->item['properties']['Size'])
                          $this->item['properties']['Size'] = 0;

                  }

          $this->item['properties']['Date Modified'] = date($this->config['options']['dateFormat'], $this->item['filemtime']);
          $this->item['properties']['filemtime'] = filemtime($this->getFullPath($current_path));
      }

      /**
       * Filemanager::getFullPath()
       * 
       * @param string $path
       * @return
       */
      private function getFullPath($path = '')
      {

          if ($path == '') {
              if (isset($this->get['path']))
                  $path = $this->get['path'];
          }

          if ($this->config['options']['fileRoot'] !== false) {
              $full_path = $this->doc_root . rawurldecode(str_replace($this->doc_root, '', $path));
              if ($this->dynamic_fileroot != '') {
                  $full_path = $this->doc_root . rawurldecode(str_replace($this->dynamic_fileroot, '', $path));
              }
          } else {
              $full_path = $this->doc_root . rawurldecode($path);
          }

          $full_path = str_replace("//", "/", $full_path);

          return $full_path;

      }

      /**
       * format path regarding the initial configuration
       * @param string $path
       */
      /**
       * Filemanager::formatPath()
       * 
       * @param mixed $path
       * @return
       */
      private function formatPath($path)
      {

          if ($this->dynamic_fileroot != '') {

              $a = explode($this->separator, $path);
              return end($a);

          } else {

              return $path;

          }

      }

      /**
       * Filemanager::sortFiles()
       * 
       * @param mixed $array
       * @return
       */
      private function sortFiles($array)
      {

          // handle 'NAME_ASC'
          if ($this->config['options']['fileSorting'] == 'NAME_ASC') {
              $array = array_reverse($array);
          }

          // handle 'TYPE_ASC' and 'TYPE_DESC'
          if (strpos($this->config['options']['fileSorting'], 'TYPE_') !== false || $this->config['options']['fileSorting'] == 'default') {

              $a = array();
              $b = array();

              foreach ($array as $key => $item) {
                  if (strcmp($item["File Type"], "dir") == 0) {
                      $a[$key] = $item;
                  } else {
                      $b[$key] = $item;
                  }
              }

              if ($this->config['options']['fileSorting'] == 'TYPE_ASC') {
                  $array = array_merge($a, $b);
              }

              if ($this->config['options']['fileSorting'] == 'TYPE_DESC' || $this->config['options']['fileSorting'] == 'default') {
                  $array = array_merge($b, $a);
              }
          }

          // handle 'MODIFIED_ASC' and 'MODIFIED_DESC'
          if (strpos($this->config['options']['fileSorting'], 'MODIFIED_') !== false) {

              $modified_order_array = array(); // new array as a column to sort collector

              foreach ($array as $item) {
                  $modified_order_array[] = $item['Properties']['filemtime'];
              }

              if ($this->config['options']['fileSorting'] == 'MODIFIED_ASC') {
                  array_multisort($modified_order_array, SORT_ASC, $array);
              }
              if ($this->config['options']['fileSorting'] == 'MODIFIED_DESC') {
                  array_multisort($modified_order_array, SORT_DESC, $array);
              }
              return $array;

          }

          return $array;


      }

      /**
       * Filemanager::isValidPath()
       * 
       * @param mixed $path
       * @return
       */
      private function isValidPath($path)
      {

          // @todo remove debug message

          return !strncmp($path, $this->getFullPath(), strlen($this->getFullPath()));

      }

      /**
       * Filemanager::unlinkRecursive()
       * 
       * @param mixed $dir
       * @param bool $deleteRootToo
       * @return
       */
      private function unlinkRecursive($dir, $deleteRootToo = true)
      {
          if (!$dh = @opendir($dir)) {
              return;
          }
          while (false !== ($obj = readdir($dh))) {
              if ($obj == '.' || $obj == '..') {
                  continue;
              }

              if (!@unlink($dir . '/' . $obj)) {
                  $this->unlinkRecursive($dir . '/' . $obj, true);
              }
          }

          closedir($dh);

          if ($deleteRootToo) {
              @rmdir($dir);
          }

          return;
      }

      /**
       * isAllowedFile()
       * check if extension is allowed regarding the security Policy / Restrictions settings
       * @param string $file
       */
      /**
       * Filemanager::isAllowedFileType()
       * 
       * @param mixed $file
       * @return
       */
      private function isAllowedFileType($file)
      {

          $path_parts = pathinfo($file);

          // if there is no extension AND no extension file are not allowed
          if (!isset($path_parts['extension']) && $this->config['security']['allowNoExtension'] == false) {
              return false;
          } else {
              return true;
          }

          $exts = array_map('strtolower', $this->config['security']['uploadRestrictions']);

          if ($this->config['security']['uploadPolicy'] == 'DISALLOW_ALL') {

              if (!in_array(strtolower($path_parts['extension']), $exts))
                  return false;
          }
          if ($this->config['security']['uploadPolicy'] == 'ALLOW_ALL') {

              if (in_array(strtolower($path_parts['extension']), $exts))
                  return false;
          }

          return true;

      }

      /**
       * Filemanager::cleanString()
       * 
       * @param mixed $string
       * @param mixed $allowed
       * @return
       */
      private function cleanString($string, $allowed = array())
      {
          $allow = null;

          if (!empty($allowed)) {
              foreach ($allowed as $value) {
                  $allow .= "\\$value";
              }
          }

          $mapping = array(
              'Š' => 'S',
              'š' => 's',
              'Đ' => 'Dj',
              'đ' => 'dj',
              'Ž' => 'Z',
              'ž' => 'z',
              'Č' => 'C',
              'č' => 'c',
              'Ć' => 'C',
              'ć' => 'c',
              'À' => 'A',
              'Á' => 'A',
              'Â' => 'A',
              'Ã' => 'A',
              'Ä' => 'A',
              'Å' => 'A',
              'Æ' => 'A',
              'Ç' => 'C',
              'È' => 'E',
              'É' => 'E',
              'Ê' => 'E',
              'Ë' => 'E',
              'Ì' => 'I',
              'Í' => 'I',
              'Î' => 'I',
              'Ï' => 'I',
              'Ñ' => 'N',
              'Ò' => 'O',
              'Ó' => 'O',
              'Ô' => 'O',
              'Õ' => 'O',
              'Ö' => 'O',
              'Ő' => 'O',
              'Ø' => 'O',
              'Ù' => 'U',
              'Ú' => 'U',
              'Û' => 'U',
              'Ü' => 'U',
              'Ű' => 'U',
              'Ý' => 'Y',
              'Þ' => 'B',
              'ß' => 'Ss',
              'à' => 'a',
              'á' => 'a',
              'â' => 'a',
              'ã' => 'a',
              'ä' => 'a',
              'å' => 'a',
              'æ' => 'a',
              'ç' => 'c',
              'è' => 'e',
              'é' => 'e',
              'ê' => 'e',
              'ë' => 'e',
              'ì' => 'i',
              'í' => 'i',
              'î' => 'i',
              'ï' => 'i',
              'ð' => 'o',
              'ñ' => 'n',
              'ò' => 'o',
              'ó' => 'o',
              'ô' => 'o',
              'õ' => 'o',
              'ö' => 'o',
              'ő' => 'o',
              'ø' => 'o',
              'ù' => 'u',
              'ú' => 'u',
              'ű' => 'u',
              'û' => 'u',
              'ü' => 'u',
              'ý' => 'y',
              'ý' => 'y',
              'þ' => 'b',
              'ÿ' => 'y',
              'Ŕ' => 'R',
              'ŕ' => 'r',
              ' ' => '_',
              "'" => '_',
              '/' => '');

          if (is_array($string)) {

              $cleaned = array();

              foreach ($string as $key => $clean) {
                  $clean = strtr($clean, $mapping);

                  if ($this->config['options']['chars_only_latin'] == true) {
                      $clean = preg_replace("/[^{$allow}_a-zA-Z0-9]/u", '', $clean);
                      // $clean = preg_replace("/[^{$allow}_a-zA-Z0-9\x{0430}-\x{044F}\x{0410}-\x{042F}]/u", '', $clean); // allow only latin alphabet with cyrillic
                  }
                  $cleaned[$key] = preg_replace('/[_]+/', '_', $clean); // remove double underscore
              }
          } else {
              $string = strtr($string, $mapping);
              if ($this->config['options']['chars_only_latin'] == true) {
                  $clean = preg_replace("/[^{$allow}_a-zA-Z0-9]/u", '', $string);
                  // $clean = preg_replace("/[^{$allow}_a-zA-Z0-9\x{0430}-\x{044F}\x{0410}-\x{042F}]/u", '', $string); // allow only latin alphabet with cyrillic
              }
              $cleaned = preg_replace('/[_]+/', '_', $string); // remove double underscore

          }
          return $cleaned;
      }


      /**
       * Filemanager::has_permission()
       * 
       * @param mixed $action
       * @return
       */
      private function has_permission($action)
      {

          if (in_array($action, $this->allowed_actions))
              return true;

          return false;

      }

      /**
       * Filemanager::get_thumbnail_path()
       * 
       * @param mixed $path
       * @return
       */
      private function get_thumbnail_path($path)
      {

          $a = explode($this->separator, $path);

          $path_parts = pathinfo($path);

          $thumbnail_path = $a[0] . $this->separator . '/' . $this->cachefolder . dirname(end($a)) . '/';
          $thumbnail_name = $path_parts['filename'] . '_' . $this->thumbnail_width . 'x' . $this->thumbnail_height . 'px.' . $path_parts['extension'];

          if (is_dir($path)) {
              $thumbnail_fullpath = $thumbnail_path;
          } else {
              $thumbnail_fullpath = $thumbnail_path . $thumbnail_name;
          }

          return $thumbnail_fullpath;

      }

      /**
       * Filemanager::sanitize()
       * 
       * @param mixed $var
       * @param mixed $preserve
       * @return
       */
      private function sanitize($var, $preserve = null)
      {
          $sanitized = strip_tags($var);
          $sanitized = str_replace('http://', '', $sanitized);
          $sanitized = str_replace('https://', '', $sanitized);
          if ($preserve != 'parent_dir') {
              $sanitized = str_replace('../', '', $sanitized);
          }
          return $sanitized;
      }

      /**
       * Filemanager::checkFilename()
       * 
       * @param mixed $path
       * @param mixed $filename
       * @param string $i
       * @return
       */
      private function checkFilename($path, $filename, $i = '')
      {
          if (!file_exists($path . $filename)) {
              return $filename;
          } else {
              $_i = $i;
              $tmp = explode( /*$this->config['upload']['suffix'] . */ $i . '.', $filename);
              if ($i == '') {
                  $i = 1;
              } else {
                  $i++;
              }
              $filename = str_replace($_i . '.' . $tmp[(sizeof($tmp) - 1)], $i . '.' . $tmp[(sizeof($tmp) - 1)], $filename);
              return $this->checkFilename($path, $filename, $i);
          }
      }

      /**
       * Filemanager::loadLanguageFile()
       * 
       * @return
       */
      private function loadLanguageFile()
      {

          // we load langCode var passed into URL if present and if exists
          // else, we use default configuration var
          $lang = $this->config['options']['culture'];
          if (isset($this->params['langCode']) && in_array($this->params['langCode'], $this->languages))
              $lang = $this->params['langCode'];

          if (file_exists($this->root . 'scripts/languages/' . $lang . '.js')) {
              $stream = file_get_contents($this->root . 'scripts/languages/' . $lang . '.js');
              $this->language = json_decode($stream, true);
          } else {
              $stream = file_get_contents($this->root . 'scripts/languages/' . $lang . '.js');
              $this->language = json_decode($stream, true);
          }
      }

      /**
       * Filemanager::availableLanguages()
       * 
       * @return
       */
      private function availableLanguages()
      {

          if ($handle = opendir($this->root . '/scripts/languages/')) {
              while (false !== ($file = readdir($handle))) {
                  if ($file != "." && $file != "..") {
                      array_push($this->languages, pathinfo($file, PATHINFO_FILENAME));
                  }
              }
              closedir($handle);
          }
      }

      /**
       * Filemanager::is_image()
       * 
       * @param mixed $path
       * @return
       */
      private function is_image($path)
      {

          $a = getimagesize($path);
          $image_type = $a[2];

          if (in_array($image_type, array(
              IMAGETYPE_GIF,
              IMAGETYPE_JPEG,
              IMAGETYPE_PNG,
              IMAGETYPE_BMP))) {
              return true;
          }
          return false;
      }

      /**
       * Filemanager::isEditable()
       * 
       * @param mixed $file
       * @return
       */
      private function isEditable($file)
      {

          $path_parts = pathinfo($file);

          $exts = array_map('strtolower', $this->config['edit']['editExt']);

          if (in_array($path_parts['extension'], $exts)) {

              return true;

          } else {

              return false;

          }


      }

      /**
       * Filemanager::expandPath()
       * 
       * @param mixed $path
       * @param bool $clean
       * @return
       */
      public function expandPath($path, $clean = false)
      {
          $todo = explode('/', $path);
          $fullPath = array();

          foreach ($todo as $dir) {
              if ($dir == '..') {
                  $element = array_pop($fullPath);
                  if (is_null($element)) {
                      return false;
                  }
              } else {
                  if ($clean) {
                      $dir = $this->cleanString($dir);
                  }
                  array_push($fullPath, $dir);
              }
          }
          return implode('/', $fullPath);
      }
  }

?>