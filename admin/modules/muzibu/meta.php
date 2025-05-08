<?php
  /**
   * Muzibu Meta
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: meta.php, v1.00 2025-03-08 20:45:05 Muzibu
   */
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  require_once ("admin_class.php");

  $length = count($this->_url);
  $sep = " | ";
  
  if ($length > 3)
	  redirect_to(SITEURL . '/404.php');
?>
<?php
  switch ($length) {
      case 3:
          if (in_array(Url::$data['module']['muzibu-song'], $this->_url) || 
             in_array(Url::$data['module']['muzibu-album'], $this->_url) || 
             in_array(Url::$data['module']['muzibu-artist'], $this->_url) || 
             in_array(Url::$data['module']['muzibu-genre'], $this->_url) || 
             in_array(Url::$data['module']['muzibu-playlist'], $this->_url) || 
             in_array(Url::$data['module']['muzibu-sector'], $this->_url)) {
              
              $html = "<title>";
              
              if (in_array(Url::$data['module']['muzibu-song'], $this->_url)) {
                  $html .= $this->moduledata->{'title' . Lang::$lang} . ' - Şarkılar';
              }
              if (in_array(Url::$data['module']['muzibu-album'], $this->_url)) {
                  Registry::set('Muzibu', new Muzibu(false, true, false));
                  $html .= $this->moduledata->{'title' . Lang::$lang} . ' - Albümler';
              }
              if (in_array(Url::$data['module']['muzibu-artist'], $this->_url)) {
                  $html .= $this->moduledata->{'title' . Lang::$lang} . ' - Sanatçılar';
              }
              if (in_array(Url::$data['module']['muzibu-genre'], $this->_url)) {
                  Registry::set('Muzibu', new Muzibu(false, false, true));
                  $html .= $this->moduledata->{'title' . Lang::$lang} . ' - Türler';
              }
              if (in_array(Url::$data['module']['muzibu-playlist'], $this->_url)) {
                  Registry::set('Muzibu', new Muzibu());
                  Registry::get('Muzibu')->playlist->renderSinglePlaylist();
                  $html .= $this->moduledata->{'title' . Lang::$lang} . ' - Çalma Listeleri';
              }
              if (in_array(Url::$data['module']['muzibu-sector'], $this->_url)) {
                  $html .= $this->moduledata->{'title' . Lang::$lang} . ' - Sektörler';
              }
              
              $html .= $sep . Registry::get("Core")->site_name;
              $html .= "</title>\n";

              $html .= "<meta name=\"description\" content=\"";
              $html .= ($this->moduledata->{'metadesc' . Lang::$lang}) ? $this->moduledata->{'metadesc' . Lang::$lang} : Registry::get("Core")->metadesc;
              $html .= "\" />\n";
              
              $html .= "<meta name=\"keywords\" content=\"";
              $html .= ($this->moduledata->{'metakey' . Lang::$lang}) ? $this->moduledata->{'metakey' . Lang::$lang} : Registry::get("Core")->metakeys;
              $html .= "\" />\n";
          } else {
              Registry::set('Muzibu', new Muzibu(false, false, true));
              if (isset($this->moduledata->mod)) {
                  $row = $this->moduledata->mod;
                  $html = "<title>";
                  $html .= 'Kategori - ' . $row->{'name' . Lang::$lang};
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
          }
          break;
          
      case 2:
          
                if (in_array(Url::$data['module']['muzibu-song'], $this->_url)) {
                      $html .= '<title>Şarkılar</title>';
                }
                if (in_array(Url::$data['module']['muzibu-album'], $this->_url)) {
                  $html .= '<title>Albümler</title>';
                }
                  if (in_array(Url::$data['module']['muzibu-artist'], $this->_url)) {
                      $html .= '<title>Sanatçılar</title>';
                  }
                  if (in_array(Url::$data['module']['muzibu-genre'], $this->_url)) {
                      $html .= '<title>Türler</title>';
                  }
                  if (in_array(Url::$data['module']['muzibu-playlist'], $this->_url)) {
                       $html .= '<title>Çalma Listeleri</title>';
                  }
                  if (in_array(Url::$data['module']['muzibu-sector'], $this->_url)) {
                      $html .= '<title>Sektörler</title>';
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