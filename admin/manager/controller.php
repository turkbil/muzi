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

  require_once ("../init.php");

  if (!$user->is_Admin())
      redirect_to("../login.php");

  require ("class_fm.php");
  $fm = new Filemanager();
  
  $action = isset($_REQUEST["action"]) ? sanitize($_REQUEST["action"]) : false; 
?>
<?php
  switch ($action):
      case "renameFile":
          if (!empty($_POST["newname"])):
              $oldname = Filemanager::fixPath(UPLOADS . $_POST["path"]);
              $base = dirname($_POST["path"]) . '/';
              $newname = Filemanager::fixPath(UPLOADS . $base . Filemanager::fixNames($_POST["newname"]));
              $fm->renameFile($oldname, $newname, $base);
          endif;
          break;

      case "renameDir":
          if (!empty($_POST["newname"])):
              $oldname = Filemanager::fixPath(UPLOADS . $_POST["path"]);
              $base = dirname($_POST["path"]) . '/';
              $newname = Filemanager::fixPath(UPLOADS . $base . Filemanager::fixNames($_POST["newname"]));
              $fm->renameDir($oldname, $newname, $base);
          endif;
          break;

      case "deleteSingle":
          if (!empty($_POST["path"])):
              $fm->delete(Filemanager::fixPath($_POST["path"]), $_POST["name"]);
          endif;
          break;

      case "deleteMulti":
          if (empty($_POST['multid']) && empty($_POST['multif'])):
              $core->msgAlert(_FM_SEL_ERR);
          else:
              if (isset($_POST['multid'])):
                  foreach ($_POST['multid'] as $deldir):
                      $action = $fm->delete(Filemanager::fixPath($deldir));
                  endforeach;
                  if ($action)
                      $core->msgOK(_FM_DELOK_DIR);
              endif;
              if (isset($_POST['multif'])):
                  foreach ($_POST['multif'] as $delfile):
                      $action = $fm->delete(Filemanager::fixPath($delfile));
                  endforeach;
                  if ($action)
                      $core->msgOK(_FM_DELOK_FILE);
              endif;
          endif;
          break;

      case "createFile":
          if (empty($_POST["name"])):
              $json['message'] = '<div class="msgError">' . _FM_FILENAME_R . '</div>';
              print json_encode($json);
          else:
              $fm->makeFile(Filemanager::fixPath($_POST["path"] . '/'), Filemanager::fixNames($_POST["name"]));
          endif;
          break;

      case "createDir":
          if (empty($_POST["name"])):
              $json['message'] = '<div class="msgError">' . _FM_DIR_NAME_R . '</div>';
              print json_encode($json);
          else:
              $fm->makeDirectory(Filemanager::fixPath($_POST["path"] . '/'), Filemanager::fixNames($_POST["name"]));
          endif;
          break;

      case "listDir":
          $fm->listDirectories();
          break;

      case "copyAll":
          if (empty($_POST['multid']) && empty($_POST['multif'])):
              $core->msgAlert(_FM_SEL_ERR);
          else:
              if (isset($_POST['multid']) and isset($_POST['multif'])):
                  $alldata = array_merge($_POST['multid'], $_POST['multif']);
              elseif (isset($_POST['multid'])):
                  $alldata = $_POST['multid'];
              else:
                  $alldata = $_POST['multif'];
              endif;
                  $fm->copyAll($alldata, $_POST['path']);
          endif;
          break;

      case "moveAll":
          if (empty($_POST['multid']) && empty($_POST['multif'])):
              $core->msgAlert(_FM_SEL_ERR);
          else:
              if (isset($_POST['multid']) and isset($_POST['multif'])):
                  $alldata = array_merge($_POST['multid'], $_POST['multif']);
              elseif (isset($_POST['multid'])):
                  $alldata = $_POST['multid'];
              else:
                  $alldata = $_POST['multif'];
              endif;
                  $fm->moveFiles($alldata, $_POST['path']);
          endif;
          break;
		  
      case "dozip":
          if (empty($_POST['multid']) && empty($_POST['multif'])):
              $json['message'] = '<div class="msgAlert">' . _FM_SEL_ERR . '</div>';
              print json_encode($json);
          else:
              if (isset($_POST['multid']) and isset($_POST['multif'])):
                  $zipfiles = array_merge($_POST['multid'], $_POST['multif']);
              elseif (isset($_POST['multid'])):
                  $zipfiles = $_POST['multid'];
              else:
                  $zipfiles = $_POST['multif'];
              endif;
                  $fm->dozip($zipfiles, sanitize($_POST['cur_dir']));
          endif;
          break;

      default:
          $fm->renderAll();
          break;
  endswitch;

  if (isset($_POST['fileid'])):
      $fm->doUpload($_REQUEST['filedir']);
  endif;
?>