<?php
  /**
   * Controller
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: controller.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  
  require_once("../../../../init.php");
  if (!$user->is_Admin())
    exit;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>File Manager</title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="styles/filemanager.css" />
<link href="../../../css/icon.css" rel="stylesheet" type="text/css">
</head>
<body>
<div>
  <form id="uploader" method="post">
    <button id="home" name="home" type="button" value="Home"><i class="icon home"></i></button>
    <h1></h1>
    <div id="uploadresponse"></div>
    <input id="mode" name="mode" type="hidden" value="add" />
    <input id="currentpath" name="currentpath" type="hidden" />
    <div id="file-input-container">
      <div id="alt-fileinput">
        <input id="filepath" name="filepath" type="text" />
        <button id="browse" name="browse" type="button" value="Browse"><i class="icon add"></i></button>
      </div>
      <input	id="newfile" name="newfile" type="file" />
    </div>
    <button id="upload" name="upload" type="submit" value="Upload"><i class="icon upload cloud"></i></button>
    <button id="newfolder" name="newfolder" type="button" value="New Folder"><i class="icon folder open"></i></button>
    <button id="grid" class="ON" type="button"><i class="icon layout grid"></i></button>
    <button id="list" type="button"><i class="icon layout list"></i></button>
  </form>
  <div id="splitter">
    <div id="filetree"></div>
    <div id="fileinfo">
      <h1></h1>
    </div>
  </div>
  <form name="search" id="search" method="get">
    <div>
      <input type="text" value="" name="q" id="q" />
      <a id="reset" href="#" class="q-reset"></a> <span class="q-inactive"></span> </div>
  </form>
  <ul id="itemOptions" class="contextMenu">
    <li class="select"><a href="#select"></a></li>
    <li class="download"><a href="#download"></a></li>
    <li class="rename"><a href="#rename"></a></li>
    <li class="move"><a href="#move"></a></li>
    <li class="replace"><a href="#replace"></a></li>
    <li class="delete separator"><a href="#delete"></a></li>
  </ul>
  <script src="../../../../../assets/jquery.js"></script>
  <script src="../../../../../assets/global.js"></script>
  <script type="text/javascript" src="scripts/jquery.form-3.24.js"></script>
  <script type="text/javascript" src="scripts/jquery.splitter/jquery.splitter-1.5.1.js"></script> 
  <script type="text/javascript" src="scripts/jquery.filetree/jqueryFileTree.js"></script> 
  <script type="text/javascript" src="scripts/jquery.contextmenu/jquery.contextMenu-1.01.js"></script> 
  <script type="text/javascript" src="scripts/jquery.impromptu-3.2.min.js"></script> 
  <script type="text/javascript" src="scripts/jquery.tablesorter-2.7.2.min.js"></script> 
  <script type="text/javascript" src="scripts/filemanager.js"></script> 
</div>
</body>
</html>