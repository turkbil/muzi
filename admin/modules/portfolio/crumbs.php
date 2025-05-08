<?php
  /**
   * Breadcrumbs
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: crumbs.php, v4.00 2014-04-20 10:12:05 Nurullah Okatan
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  require_once("admin_class.php");
?>
<?php
  $length = count($this->_url);
  switch ($length) {
      case 3:
          $nav = '<a href="' . Url::Portfolio("portfolio") . '" class="section">' . $this->moduledata->{'title' . Lang::$lang} . '</a>';
          $nav .= '<span class="divider"></span>';
          $nav .= '<div class="active section">' . $this->moduledata->mod->{'title' . Lang::$lang} . '</div>';
          break;
		  
      case 2:
          $nav = '<li class="breadcrumb-item d-none d-xl-block"><a href="' . Url::Portfolio("portfolio") . '" class="section">' . $this->moduledata->{'title' . Lang::$lang} . '</a></li>';
          $nav .= '<li class="breadcrumb-item nowrap active">' . $this->moduledata->mod->{'title' . Lang::$lang} . '</li>';
          break;

      default:
          $nav = '<li class="breadcrumb-item nowrap active">' . $this->moduledata->{'title' . Lang::$lang} . '</li>';
          break;
  }
?>