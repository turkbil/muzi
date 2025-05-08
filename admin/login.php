<?php
  /**
   * Login
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2011
   * @version $Id: login.php, v2.00 2011-04-20 10:12:05 Nurullah Okatan
   */
  
  define("_VALID_PHP", true);
  require_once("init.php");
?>
<?php
  if ($user->is_Admin())
      redirect_to("index.php");

  if (isset($_POST['submit'])):
      $result = $user->login($_POST['username'], $_POST['password']);
      //Login successful
      if ($result):
          Security::writeLog(Lang::$word->_USER . ' ' . $user->username . ' ' . Lang::$word->_LG_LOGIN, "user", "no", "user");
          redirect_to("index.php");
      endif;
  endif;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css">
<title><?php echo $core->site_name;?></title>
<link href="assets/css/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../assets/jquery.js"></script>
</head>
<body>
<div class="wrapper">
  <div id="loginform">
    <form id="admin_form" name="admin_form" method="post">
      <h1>admin panel</h1>
      <div class="fields">
        <input id="username" name="username" placeholder="<?php echo Lang::$word->_USERNAME;?>" type="text">
        <input id="password" name="password" placeholder="******" type="password">
      </div>
      <div class="footer">
        <p class="clearfix"><a href="../" id="backto"><?php echo Lang::$word->_LG_BACK;?></a></p>
        <button class="button" type="submit" name="submit" id="submit"><?php echo Lang::$word->_UA_LOGIN;?></button>
        <p class="copy">Copyright &copy; <?php echo date('Y').' '.$core->site_name;?></p>
      </div>
    </form>
  </div>
  <div id="message-box"><?php print Filter::$showMsg;?></div>
</div>
</body>
</html>