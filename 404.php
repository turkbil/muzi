<?php
  /**
   * 404
   *
   * @yazilim CMS pro
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: 404.php, v4.00 2014-01-10 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  require_once("init.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>404 Error! | <?php echo $core->site_name;?></title>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700" rel="stylesheet" type="text/css">
<link href="<?php echo THEMEURL . '/cache/' . Minify::cache(array('css/base.css','css/button.css','css/image.css','css/icon.css','css/breadcrumb.css','css/popup.css','css/form.css','css/input.css','css/table.css','css/label.css','css/segment.css','css/message.css','css/divider.css','css/dropdown.css','css/list.css','css/header.css','css/menu.css','css/datepicker.css','css/progress.css','css/utility.css'),'css');?>" rel="stylesheet" type="text/css" />
<link href="<?php echo THEMEURL;?>/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php require_once (THEMEDIR . "/404.tpl.php");;?>
</body>
</html>