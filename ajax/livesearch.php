<?php
  /**
   * Live Search
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2010
   * @version $Id: livesearch.php,v 1.1.5 2010-12-28 10:12:05 Nurullah Okatan
   */
  define("_VALID_PHP", true);
  require_once("../init.php");

?>
<?php
  if (isset($_POST['liveSearch']))
      : $string = sanitize($_POST['liveSearch'],15);
  
  if (strlen($string) > 3)
      : $sql = "SELECT slug, title" . Lang::$lang . " as pagetitle" 
	  . "\n FROM " . Content::pTable
	  . "\n WHERE title" . Lang::$lang . " LIKE '%" . $db->escape($string) . "%' or body" . Lang::$lang . " LIKE '%" . $db->escape($string) . "%'"
	  . "\n ORDER BY created DESC LIMIT 10";
	  
          $html = '';
          if ($result = $db->fetch_all($sql)):
              $html .= '<div id="search-results" class="tubi divided list">';
              foreach ($result as $row):
				  $html .= '<a class="item" href="' . Url::Page($row->slug) . '"><div class="header">' . truncate($row->pagetitle,40) . '</div></a>';
              endforeach;
              $html .= '</div>';
              print $html;
          endif;
      endif;
  endif;
?>