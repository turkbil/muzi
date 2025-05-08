<?php
  /**
   * Rss
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: rss.php, v4.00 2014-04-24 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  require_once ("init.php");


  header("Content-Type: text/xml");
  header('Pragma: no-cache');
  echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  echo "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n\n";
  echo "<channel>\n";
  echo "<title><![CDATA[" . $core->site_name . "]]></title>\n";
  echo "<link><![CDATA[" . SITEURL . "]]></link>\n";
  echo "<description><![CDATA[Latest 20 Rss Feeds - " . $core->company . "]]></description>\n";
  echo "<generator>" . $core->company . "</generator>\n";

  $sql = "SELECT body" . Lang::$lang . ", title" . Lang::$lang . " as pagetitle, slug," 
  . "\n DATE_FORMAT(created, '%a, %d %b %Y %T GMT') as created" 
  . "\n FROM " . Content::pTable
  . "\n WHERE active = 1" 
  . "\n AND home_page = 0" 
  . "\n AND login = 0" 
  . "\n AND activate = 0" 
  . "\n AND account = 0" 
  . "\n AND register = 0" 
  . "\n AND search = 0" 
  . "\n AND sitemap = 0" 
  . "\n ORDER BY created DESC LIMIT 20";

  $data = $db->fetch_all($sql);
  foreach ($data as $row) {
      $title = $row->pagetitle;

      $newbody = '';
      $body = $row->{'body' . Lang::$lang};
      $string = preg_replace('!%%.*?%%!s', '', $body);
      $newbody = cleanSanitize($string, 400);

      $date = $row->created;
      $slug = $row->slug;
      $url = Url::Page($slug);

      echo "<item>\n";
      echo "<title><![CDATA[$title]]></title>\n";
      echo "<link><![CDATA[$url]]></link>\n";
      echo "<guid isPermaLink=\"true\"><![CDATA[$url]]></guid>\n";
      echo "<description><![CDATA[$newbody]]></description>\n";
      echo "<pubDate><![CDATA[$date]]></pubDate>\n";
      echo "</item>\n";
  }
  unset($row);
  echo "</channel>\n";
  echo "</rss>";
?>