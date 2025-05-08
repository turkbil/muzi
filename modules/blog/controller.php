<?php
  /**
   * processComment
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: processComment.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  require_once("../../init.php");

  require_once (MODPATH . "blog/admin_class.php");
  Registry::set('Blog', new Blog());
?>
<?php
  /* == Process Comment == */
  if (isset($_POST['processComment'])) {

      if (empty($_POST['username']) and Registry::get("Blog")->username_req)
          Filter::$msgs['username'] = Lang::$word->_MOD_AMC_E_NAME;

      if (Registry::get("Blog")->show_captcha) {
          Filter::checkPost('captcha', Lang::$word->_MOD_AMC_E_CAPTCHA);

          if ($_SESSION['captchacode'] != $_POST['captcha'])
              Filter::$msgs['captcha'] = Lang::$word->_MOD_AMC_E_CAPTCHA2;
      }

      if (empty($_POST['email']) and Registry::get("Blog")->email_req)
          Filter::$msgs['email'] = Lang::$word->_MOD_AMC_E_EMAIL;

      if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $_POST['email']))
          Filter::$msgs['email'] = Lang::$word->_MOD_AMC_E_EMAIL2;

      if (isset($_POST['www']) and !empty($_POST['www'])) {
          if (!preg_match("#^http://*#", $_POST["www"]))
              Filter::$msgs['www'] = Lang::$word->_MOD_AMC_E_WWW;
      }

      Filter::checkPost('body', Lang::$word->_MOD_AMC_E_COMMENT);

      if (empty(Filter::$msgs)) {

          $text = cleanOut($_POST['body']);
          $string = Blog::keepTags($text, '<strong><em><i><b><br><p><pre><code>', '');
          $filtered = (Registry::get("Blog")->blacklist_words) ? Registry::get("Blog")->censored($string) : $string;

          $data = array(
              'parent_id' => (isset($_POST['parent_id'])) ? intval($_POST['parent_id']) : 0,
              'artid' => intval($_POST['artid']),
              'user_id' => intval($user->uid),
              'username' => sanitize($_POST['username']),
              'email' => sanitize($_POST['email']),
              'body' => $filtered,
              'www' => sanitize($_POST['www']),
              'created' => "NOW()",
              'ip' => sanitize($_SERVER['REMOTE_ADDR']),
              'active' => (Registry::get("Blog")->auto_approve) ? 1 : 0);

          $db->insert(Blog::cmTable, $data);
		  $page = getValuesById("slug, title" . Lang::$lang, Blog::mTable, $data['artid']);

          $adata = array(
              'uid' => $user->uid,
              'url' => Url::$data['module']['blog'] . "/" . $page->slug . "/",
              'icon' => "chat outline",
              'type' => "article comment",
              'title' => $page->{'title' . Lang::$lang},
              'subject' => Lang::$word->_PPF_FBLG_P,
              'message' => $filtered,
              'created' => "NOW()"
			  );
			  
          $db->insert(Users::uaTable, $adata);

          if (Registry::get("Blog")->notify_new) {
			  $artslug = $page->slug;
              $sender_email = $data['email'];
              $username = $data['username'];
              $message = $filtered;
              $www = $data['www'];
              $ip = sanitize($_SERVER['REMOTE_ADDR']);

              require_once (BASEPATH . "lib/class_mailer.php");
              $mailer = Mailer::sendMail();

              $row = Core::getRowById(Content::eTable, 11);

              $body = str_replace(array(
                  '[MESSAGE]',
                  '[SENDER]',
                  '[NAME]',
                  '[WWW]',
                  '[PAGEURL]',
                  '[IP]'), array(
                  $message,
                  $sender_email,
                  $username,
                  $www,
                  Url::Blog("item", $artslug),
				  $ip), $row->{'body' . Lang::$lang});

              $message = Swift_Message::newInstance()
						->setSubject($row->{'subject' . Lang::$lang})
						->setTo(array($core->site_email => $core->site_name))
						->setFrom(array($sender_email => $username))
						->setBody(cleanOut($body), 'text/html');

              $mailer->send($message);
          }

          $result = (Registry::get("Blog")->auto_approve) ? Lang::$word->_MOD_AMC_MSGOK1 : Lang::$word->_MOD_AMC_MSGOK2;

          if ($db->affected()) {
              Security::writeLog(Lang::$word->_USER . ' ' . $user->username . ' ' . Lang::$word->_LG_COMMENT_SENT, "", "no", "user");
              $json['status'] = 'success';
              $json['message'] = Filter::msgOk($result, false);
          } else {
              $json['status'] = 'alert';
              $json['message'] = Filter::msgAlert(Lang::$word->_SYSTEM_PROCCESS, false);
          }
          print json_encode($json);


      } else {
          $json['message'] = Filter::msgStatus();
          print json_encode($json);
      }
  }

  /* == Delete Comment == */
  if (isset($_POST['delComment']) and $user->is_Admin()) :
      $id = intval($_POST['delComment']);
      $db->delete(Blog::cmTable, "id = " . Filter::$id);
  endif;
  
  /* == Process Lke == */
  if (isset($_POST['doLike']) and Filter::$id):
      $data['like_up'] = "INC(1)";
      $db->update(Blog::mTable, $data, "id = " . Filter::$id);
      print intval($_POST['total'] + 1);
	  
	  if($user->logged_in):
		  $page = getValuesById("slug, title" . Lang::$lang, Blog::mTable, Filter::$id);
		  $url = Url::$data['module']['blog'] . "/" . $page->slug . "/";
		  
		  if(!$row = $db->first("SELECT id FROM " . Users::uaTable . " WHERE uid = " . $user->uid . " AND url='" . $url . "' AND type = 'article like'")):
			  $adata = array(
				  'uid' => $user->uid,
				  'url' => $url,
				  'icon' => "heart",
				  'type' => "article like",
				  'title' => $page->{'title' . Lang::$lang},
				  'subject' => Lang::$word->_PPF_FBLG_L,
				  'message' => "NULL",
				  'created' => "NOW()"
				  );
				  
			  $db->insert(Users::uaTable, $adata);
		  endif;
	  endif;
  endif;

  /* == Process Vote == */
  if (isset($_POST['rating'])):
      $rating = (int)$_POST['stars'];

      $data['rating'] = "INC($rating)";
      $data['rate_number'] = "INC(1)";
      $db->update(Blog::mTable, $data, "id=" . Filter::$id);

      if ($db->affected()):
          print '<i class="icon check"></i> ' . Lang::$word->_MOD_AM_THX;
      else:
          print '<i class="icon ban"></i> ' . Lang::$word->_MOD_AM_THX_ERR;
      endif;
  endif;
  
  /* == Process Article == */
  if (isset($_POST['processArticle']) and $user->logged_in):
      Registry::get("Blog")->processUserArticle();
  endif;
?>