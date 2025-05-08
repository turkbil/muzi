<?php
  /**
   * Meta
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: meta.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  require_once("admin_class.php");
  
  $length = count($this->_url);
  $sep = " | ";

  if ($length > 3)
	  redirect_to(SITEURL . '/404.php');
?>
<?php
  switch ($length) {
      case 3:
          Registry::set('Portfolio', new Portfolio(false, true));
          if (isset($this->moduledata->mod)) {
              $row = $this->moduledata->mod;
              $html = "<title>";
              $html .= Lang::$word->_MOD_PF_PFCAT . ' - ' . $row->{'title' . Lang::$lang};
              $html .= $sep . Registry::get("Core")->site_name;
              $html .= "</title>\n";

              $html .= "<meta name=\"description\" content=\"";
              $html .= ($row->{'metadesc' . Lang::$lang}) ? $row->{'metadesc' . Lang::$lang} : Registry::get("Core")->metadesc;
              $html .= "\" />\n";

              $html .= "<meta name=\"keywords\" content=\"";
              $html .= ($row->{'metakey' . Lang::$lang}) ? $row->{'metakey' . Lang::$lang} : Registry::get("Core")->metakeys;
              $html .= "\" />\n";
          } else {
              redirect_to(SITEURL . '/404.php');
          }
          break;
		  
      case 2:
          Registry::set('Portfolio', new Portfolio(true));
          if (isset($this->moduledata->mod)) {
              $row = $this->moduledata->mod;
              $html = "<title>";
              $html .= $row->{'title' . Lang::$lang};
              $html .= $sep . Registry::get("Core")->site_name;
              $html .= "</title>\n";

              $html .= "<meta name=\"description\" content=\"";
              $html .= ($row->{'metadesc' . Lang::$lang}) ? $row->{'metadesc' . Lang::$lang} : Registry::get("Core")->metadesc;
              $html .= "\" />\n";

              $html .= "<meta name=\"keywords\" content=\"";
              $html .= ($row->{'metakey' . Lang::$lang}) ? $row->{'metakey' . Lang::$lang} : Registry::get("Core")->metakeys;
              $html .= "\" />\n";
          } else {
              redirect_to(SITEURL . '/404.php');
          }
          break;

      default:
          $html = "<title>";
          $html .= $this->moduledata->{'title' . Lang::$lang};
          $html .= $sep . Registry::get("Core")->site_name;
          $html .= "</title>\n";

          $html .= "<meta name=\"description\" content=\"";
          $html .= ($this->moduledata->{'metadesc' . Lang::$lang}) ? $this->moduledata->{'metadesc' . Lang::$lang} : Registry::get("Core")->metadesc;
          $html .= "\" />\n";

          $html .= "<meta name=\"keywords\" content=\"";
          $html .= ($this->moduledata->{'metakey' . Lang::$lang}) ? $this->moduledata->{'metakey' . Lang::$lang} : Registry::get("Core")->metakeys;
          $html .= "\" />\n";
          break;
  }
  print $html;
?>