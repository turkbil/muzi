<?php

  /**
   * filemanager
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: Filemanager.php, v4.00 2014-07-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);

  require_once ("../../../../../../init.php");
  if (!$user->is_Admin())
      exit;
?>
<?php
  require_once ('filemanager.class.php');
  Registry::set('Filemanager', new Filemanager());


  $response = '';

  if (!isset($_GET)) {
      Registry::get("Filemanager")->error(Registry::get("Filemanager")->lang('INVALID_ACTION'));
  } else {

      if (isset($_GET['mode']) && $_GET['mode'] != '') {

          switch ($_GET['mode']) {

              default:

                   Registry::get("Filemanager")->error( Registry::get("Filemanager")->lang('MODE_ERROR'));
                  break;

              case 'getinfo':

                  if (Registry::get("Filemanager")->getvar('path')) {
                      $response = Registry::get("Filemanager")->getinfo();
                  }
                  break;

              case 'getfolder':

                  if (Registry::get("Filemanager")->getvar('path')) {
                      $response = Registry::get("Filemanager")->getfolder();
                  }
                  break;

              case 'rename':

                  if (Registry::get("Filemanager")->getvar('old') && Registry::get("Filemanager")->getvar('new')) {
                      $response = Registry::get("Filemanager")->rename();
                  }
                  break;

              case 'move':
                  if (Registry::get("Filemanager")->getvar('old') && Registry::get("Filemanager")->getvar('new', 'parent_dir') && Registry::get("Filemanager")->getvar('root')) {
                      $response = Registry::get("Filemanager")->move();
                  }
                  break;

              case 'editfile':

                  if (Registry::get("Filemanager")->getvar('path')) {
                      $response = Registry::get("Filemanager")->editfile();
                  }
                  break;

              case 'delete':

                  if (Registry::get("Filemanager")->getvar('path')) {
                      $response = Registry::get("Filemanager")->delete();
                  }
                  break;

              case 'addfolder':

                  if (Registry::get("Filemanager")->getvar('path') && Registry::get("Filemanager")->getvar('name')) {
                      $response = Registry::get("Filemanager")->addfolder();
                  }
                  break;

              case 'download':
                  if (Registry::get("Filemanager")->getvar('path')) {
                      Registry::get("Filemanager")->download();
                  }
                  break;

              case 'preview':
                  if (Registry::get("Filemanager")->getvar('path')) {
                      if (isset($_GET['thumbnail'])) {
                          $thumbnail = true;
                      } else {
                          $thumbnail = false;
                      }
                      Registry::get("Filemanager")->preview($thumbnail);
                  }
                  break;

              case 'maxuploadfilesize':
                  Registry::get("Filemanager")->getMaxUploadFileSize();
                  break;
          }

      } else
          if (isset($_POST['mode']) && $_POST['mode'] != '') {

              switch ($_POST['mode']) {

                  default:

                      Registry::get("Filemanager")->error(Registry::get("Filemanager")->lang('MODE_ERROR'));
                      break;

                  case 'add':

                      if (Registry::get("Filemanager")->postvar('currentpath')) {
                          Registry::get("Filemanager")->add();
                      }
                      break;

                  case 'replace':

                      if (Registry::get("Filemanager")->postvar('newfilepath')) {
                          Registry::get("Filemanager")->replace();
                      }
                      break;

                  case 'savefile':

                      if (Registry::get("Filemanager")->postvar('content', false) && Registry::get("Filemanager")->postvar('path')) {
                          $response = Registry::get("Filemanager")->savefile();
                      }
                      break;
              }

          }
  }

  echo json_encode($response);
  exit;
?>