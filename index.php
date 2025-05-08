<?php
  /**
   * Index
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: index.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  require_once ("init.php");

  $row = $content->renderPage(true);
  $plgresult = $content->getPluginLayoutFront();

  $widgettop = Content::countPlace($plgresult, "top");
  $widgetbottom = Content::countPlace($plgresult, "bottom");
  $widgetleft = Content::countPlace($plgresult, "left");
  $widgetright = Content::countPlace($plgresult, "right");
  $widgetcenbot = Content::countPlace($plgresult, "cenbot");
  $assets = Content::countPlace($plgresult, false, false);

  $totalleft = count($widgetleft);
  $totalright = count($widgetright);
  $totaltop = count($widgettop);
  $totalbot = count($widgetbottom);
  $totalcenbot = count($widgetcenbot);

  if ($row):
      $core->getVisitors(); // visitor counter
      require_once (THEMEDIR . "/index.tpl.php");
  else:
      redirect_to(SITEURL . "/404.php");
  endif;
?>