<?php
  /**
   * Controller
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: controller.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  
  require_once("../../init.php");
  if (!$user->is_Admin())
      redirect_to("../../login.php");
  
  require_once("admin_class.php");
  Registry::set('FAQManager', new FAQManager());
?>
<?php
  /* == Process FAQ == */
  if (isset($_POST['processFaq'])):
      Registry::get("FAQManager")->processFaq();
  endif;

  /* == Update FAQ Order == */
  if (isset($_GET['sortslides'])):
      FAQManager::updateOrder();
  endif;
  
  /* == Delete FAQ == */
  if (isset($_POST['delete']) and $_POST['delete'] == "deleteFaq"):
      $title = sanitize($_POST['title']);
      $result = $db->delete(FAQManager::mTable, "id=" . Filter::$id);

      if ($result):
          $json['type'] = 'success';
          $json['title'] = Lang::$word->_SUCCESS;
          $json['message'] = Lang::$word->_MOD_FAQ_FAQ . ' /' . $title . '/ ' . Lang::$word->_DELETED;
          Security::writeLog(Lang::$word->_MOD_FAQ_FAQ . ' /' . urldecode($title) . '/ ' . Lang::$word->_DELETED, "", "no", "module");
      else:
          $json['type'] = 'warning';
          $json['title'] = Lang::$word->_ALERT;
          $json['message'] = Lang::$word->_SYSTEM_PROCCESS;
      endif;
      print json_encode($json);
  endif;
?>