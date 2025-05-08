<?php
  define("_VALID_PHP", true);
  require_once("../../../../../../init.php");
  if (!$user->is_Admin())
    exit;
	
	
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
          "fileRoot" => $base_dir = '/' . Registry::get("Core")->site_dir . '/uploads/',
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
              "enabled" => false,
              "maxWidth" => 1280,
              "maxHeight" => 1024)),

      "videos" => array(
          "showVideoPlayer" => false,
          "videosExt" => array(
              "ogv",
              "mp4",
              "webm",
              "m4v"),
          "videosPlayerWidth" => 400,
          "videosPlayerHeight" => 222),

      "audios" => array(
          "showAudioPlayer" => false, 
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

	print json_encode($array);
?>