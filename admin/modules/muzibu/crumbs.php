<?php
  /**
   * Muzibu Crumbs
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: crumbs.php, v1.00 2025-03-08 20:45:05 Muzibu
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
    
  require_once("admin_class.php");
?>
<?php
  $length = count($this->_url);
  switch ($length) {
      case 3:
          if (in_array(Url::$data['module']['muzibu-song'], $this->_url) || 
             in_array(Url::$data['module']['muzibu-album'], $this->_url) || 
             in_array(Url::$data['module']['muzibu-artist'], $this->_url) || 
             in_array(Url::$data['module']['muzibu-genre'], $this->_url) || 
             in_array(Url::$data['module']['muzibu-playlist'], $this->_url) || 
             in_array(Url::$data['module']['muzibu-sector'], $this->_url)) {
              
              $nav = '<a href="' . Url::Muzibu("") . '" class="section">' . $this->moduledata->{'title' . Lang::$lang} . '</a>';
              $nav .= '<span class="divider"></span> ';
              
              if (in_array(Url::$data['module']['muzibu-song'], $this->_url)) {
                  $nav .= '<div class="active section">Şarkılar</div>';
              }
              if (in_array(Url::$data['module']['muzibu-album'], $this->_url)) {
                  $nav .= '<div class="active section">Albümler</div>';
              }
              if (in_array(Url::$data['module']['muzibu-artist'], $this->_url)) {
                  $nav .= '<div class="active section">Sanatçılar</div>';
              }
              if (in_array(Url::$data['module']['muzibu-genre'], $this->_url)) {
                  $nav .= '<div class="active section">Türler</div>';
              }
              if (in_array(Url::$data['module']['muzibu-playlist'], $this->_url)) {
                  $nav .= '<div class="active section">Çalma Listeleri</div>';
              }
              if (in_array(Url::$data['module']['muzibu-sector'], $this->_url)) {
                  $nav .= '<div class="active section">Sektörler</div>';
              }
          } else {
              $nav = '<a href="' . Url::Muzibu("") . '" class="section">' . $this->moduledata->{'title' . Lang::$lang} . '</a>';
              $nav .= '<span class="divider"></span>';
              $nav .= '<div class="active section"> ' . Lang::$word->_CATEGORY . ' </div>';
              $nav .= '<span class="divider"></span>';
              $nav .= '<div class="active section"> ' . $this->moduledata->mod->{'name' . Lang::$lang} . ' </div>';
          }
          break;
          
      case 2:
          if (in_array(Url::$data['module']['muzibu-favorites'], $this->_url)) {
              $nav = '<a href="' . Url::Muzibu("") . '" class="section">' . $this->moduledata->{'title' . Lang::$lang} . '</a>';
              $nav .= '<span class="divider"></span> ';
              $nav .= '<div class="active section">Favoriler</div>';
          } else {
              $nav = '<a href="' . Url::Muzibu("") . '" class="section">' . $this->moduledata->{'title' . Lang::$lang} . '</a>';
              $nav .= '<span class="divider"></span>';
              if (isset($this->moduledata->mod) && isset($this->moduledata->mod->{'title' . Lang::$lang})) {
                  $nav .= '<div class="active section">' . $this->moduledata->mod->{'title' . Lang::$lang} . '</div>';
              } else {
                  $nav .= '<div class="active section">Detay</div>';
              }
          }
          break;
          
      default:
          $nav = '<div class="active section">' . $this->moduledata->{'title' . Lang::$lang} . '</div>';
          break;
  }
?>