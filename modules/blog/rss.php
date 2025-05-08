<?php
  /**
   * Rss
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: rss.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  require_once ("../../init.php");

  $id = (isset($_GET['cid'])) ? intval($_GET['cid']) : null;

  $single = $db->first("SELECT name" . Lang::$lang . " as catname FROM mod_blog_categories WHERE id = '" . $db->escape($id) . "' AND active = 1");
  $catname = ($single->catname) ? $single->catname : $core->company;

  header("Content-Type: text/xml");
  header('Pragma: no-cache');
  echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  echo "<rss version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n\n";
  echo "<channel>\n";
  echo "<title><![CDATA[" . sanitize($core->site_name) . "]]></title>\n";
  echo "<link><![CDATA[" . $core->site_url . "]]></link>\n";
  echo "<description><![CDATA[Latest 20 Rss Feeds - " . $catname . "]]></description>\n";
  echo "<generator>" . sanitize($core->company) . "</generator>\n";

  $sql = "SELECT c.*, c.id as cid, a.title" . Lang::$lang . " as atitle, a.slug, a.body" . Lang::$lang . " as description, thumb, a.created" 
  . "\n FROM mod_blog as a" 
  . "\n INNER JOIN mod_blog_related_categories rc ON a.id = rc.aid" 
  . "\n LEFT JOIN mod_blog_categories as c ON c.id = rc.cid" 
  . "\n LEFT JOIN users as u ON u.id = a.uid" 
  . "\n WHERE rc.cid = " . $db->escape($id)
  . "\n AND c.active = 1" 
  . "\n AND a.created <= NOW()" 
  . "\n AND (a.expire = '0000-00-00 00:00:00' OR a.expire >= NOW())" 
  . "\n AND a.active = 1" 
  . "\n ORDER BY a.created DESC LIMIT 20";

  $data = $db->fetch_all($sql);

  if ($data) {
      foreach ($data as $row) {
          $title = $row->atitle;
          $text = $row->description;
          $body = cleanSanitize($text, 300);
		  $date= date("D, d M Y H:i:s T", strtotime($row->created));

          $thumb = ($row->thumb) ? SITEURL . '/thumbmaker.php?src=' . MODURL . '/blog/dataimages/' . $row->thumb . '&amp;h=80&amp;w=120' : UPLOADURL . 'blank.png';
          $img = '<img src="' . $thumb . '" alt="" align="left" hspace="15" border="2" />';
          $url = doUrl(false, $row->slug, "blog-item");

          echo "<item>\n";
          echo "<title><![CDATA[$title]]></title>\n";
          echo "<link><![CDATA[$url]]></link>\n";
          echo "<guid isPermaLink=\"true\"><![CDATA[$url]]></guid>\n";
          echo "<description><![CDATA[$img$body]]></description>\n";
          echo "<pubDate><![CDATA[$date]]></pubDate>\n";
          echo "</item>\n";
      }
      unset($row);
      echo "</channel>\n";
      echo "</rss>";
  }
?>