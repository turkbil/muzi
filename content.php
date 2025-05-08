<?php
/**
 * Content
 *
 * @yazilim Tubi Portal
 * @web adresi turkbilisim.com.tr
 * @copyright 2014
 * @version $Id: content.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
 */
define("_VALID_PHP", true);
require_once("init.php");

if ($content->_url[0] == Url::$data['pagedata']['page']):
    $row = $content->renderPage();

    $plgresult = $content->getPluginLayoutFront();
    $widgettop = Content::countPlace($plgresult, "top");
    $widgetbottom = Content::countPlace($plgresult, "bottom");
    $widgetleft = Content::countPlace($plgresult, "left");
    $widgetright = Content::countPlace($plgresult, "right");
    $widgetcenbot = Content::countPlace($plgresult, "cenbot");
    $assets = Content::countPlace($plgresult, false, false);

    $totalleft = is_array($widgetleft) ? count($widgetleft) : 0;
    $totalright = is_array($widgetright) ? count($widgetright) : 0;
    $totaltop = is_array($widgettop) ? count($widgettop) : 0;
    $totalcenbot = is_array($widgetcenbot) ? count($widgetcenbot) : 0;
    $totalbot = is_array($widgetbottom) ? count($widgetbottom) : 0;

    if ($row):
        $core->getVisitors(); // visitor counter
        require_once(THEMEDIR . "/index.tpl.php");
    else:
        redirect_to(SITEURL . "/404.php");
    endif;
else:
    if (isset(Url::$data['moddir'][$content->_url[0]]) and file_exists('modules/' . Url::$data['moddir'][$content->_url[0]] . '/main.php')):
        
        $plgresult = $content->getPluginLayoutFront();
        $widgettop = Content::countPlace($plgresult, "top");
        $widgetbottom = Content::countPlace($plgresult, "bottom");
        $widgetleft = Content::countPlace($plgresult, "left");
        $widgetright = Content::countPlace($plgresult, "right");
        $widgetcenbot = Content::countPlace($plgresult, "cenbot");
        $assets = Content::countPlace($plgresult, false, false);

        $totalleft = is_array($widgetleft) ? count($widgetleft) : 0;
        $totalright = is_array($widgetright) ? count($widgetright) : 0;
        $totaltop = is_array($widgettop) ? count($widgettop) : 0;
        $totalbot = is_array($widgetbottom) ? count($widgetbottom) : 0;
        $totalcenbot = is_array($widgetcenbot) ? count($widgetcenbot) : 0;

        require_once(THEMEDIR . "/mod_index.tpl.php");
    else:
        redirect_to(SITEURL . "/404.php");
    endif;
endif;
?>