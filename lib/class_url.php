<?php
  /**
   * Class Url
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: class_url.php, v1.00 2012-03-05 10:12:05 Nurullah Okatan
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  final class Url
  {
      public static $data = array();


    /**
     * Url::__construct()
     * 
     * @return
     */
    public function __construct()
    {
        self::$data = array(
            //Module directories. Only change Keys (Left Side)
            "moddir" => array(
                "digishop" => "eticaret",
                "haberler" => "blog",
                "hizmetler" => "portfolio",
                "booking" => "booking",
                "psdrive" => "psdrive",
                "forum" => "forum",
                "muzibu" => "muzibu" // Muzibu modülü eklendi
            ),
            
            //Pages
            "pagedata" => array(
                "page" => "sayfa" // <- Change here
            ),
            
            //Module. Only change Values (Right Side)
            "module" => array(
                //Digishop
                "digishop" => "eticaret",
                "digishop-cat" => "kategori",
                "digishop-checkout" => "sepet",
                
                //Blog
                "blog" => "haberler",
                "blog-cat" => "kategori",
                "blog-search" => "arama",
                "blog-archive" => "arsiv",
                "blog-author" => "yazar",
                "blog-tag" => "etiket",
                
                //Dergi
                "portfolio" => "hizmetler",
                "portfolio-cat" => "kategori",
                
                //Muzibu - Tüm değerleri kontrol edelim
                "muzibu" => "muzibu",
                "muzibu-song" => "song",
                "muzibu-album" => "album",
                "muzibu-artist" => "artist",
                "muzibu-genre" => "genre",
                "muzibu-playlist" => "playlist",
                "muzibu-sector" => "sector",
                "muzibu-favorites" => "favorites"
            )
        );
        
        return self::$data;
    }
    
    /**
     * Url::Homepage()
     * 
     * @return boolean
     */
    public static function Homepage()
    {
        global $content;
        return (count($content->_url) <= 1);
    }

    
      /**
       * Url::Page()
       * 
       * @return
       */
      public static function Page($slug, $pars = false)
      {
          $segment = self::$data['pagedata'];
		  
		  $url = SITEURL . '/' . $segment['page'] . '/' . $slug . '/' . $pars;
		  
		  return $url;

      }

      public static function Muzibu($type, $slug = false, $pars = false)
      {
          $segment = self::$data['module'];
          switch ($type) {
              case 'song':
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-song'] . '/' . $pars;
                  break;
              case 'song-detail':
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-song'] . '/' . $slug . '/' . $pars;
                  break;
              case 'album':
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-album'] . '/' . $pars;
                  break;
              case 'album-detail':
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-album'] . '/' . $slug . '/' . $pars;
                  break;
              case 'artist':
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-artist'] . '/' . $pars;
                  break;
              case 'artist-detail':
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-artist'] . '/' . $slug . '/' . $pars;
                  break;
              case 'genre':
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-genre'] . '/' . $pars;
                  break;
              case 'genre-detail':
                  Registry::set('Muzibu', new Muzibu(false, false, true));
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-genre'] . '/' . $slug . '/' . $pars;
                  break;
              case 'playlist':
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-playlist'] . '/' . $pars;
                  break;
              case 'playlist-detail':
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-playlist'] . '/' . $slug . '/' . $pars;
                  break;
              case 'sector':
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-sector'] . '/' . $pars;
                  break;
              case 'sector-detail':
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-sector'] . '/' . $slug . '/' . $pars;
                  break;
              case 'favorites':
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $segment['muzibu-favorites'] . '/' . $pars;
                  break;
              default:
                  $url = SITEURL . '/' . $segment['muzibu'] . '/' . $slug . '/' . $pars;
                  break;
          }
          return $url;
      }

      /**
       * Url::Blog()
       * 
       * @return
       */
      public static function Blog($type, $slug = false, $pars = false)
      {
          $segment = self::$data['module'];
          switch ($type) {
              case 'blog':
                  $url = SITEURL . '/' . $segment['blog'] . '/' . $pars;
                  break;

              case 'blog-cat':
				  $url = SITEURL . '/' . $segment['blog'] . '/' . $segment['blog-cat'] . '/' . $slug . '/' . $pars;
                  break;

              case 'blog-search':
				  $url = SITEURL . '/' . $segment['blog'] . '/' . $segment['blog-search'] . '/' . $pars;
                  break;

              case 'blog-archive':
				  $url = SITEURL . '/' . $segment['blog'] . '/' . $segment['blog-archive'] . '/' . $pars;
                  break;

              case 'blog-author':
				  $url = SITEURL . '/' . $segment['blog'] . '/' . $segment['blog-author'] . '/' . $slug . '/' . $pars;
                  break;

              case 'blog-tags':
				  $url = SITEURL . '/' . $segment['blog'] . '/' . $segment['blog-tag'] . '/' . urlencode($slug) . '/' . $pars;
                  break;

              default:
				  $url = SITEURL . '/' . $segment['blog'] . '/' . $slug . '/' . $pars;
                  break;

          }
		  
		  return $url;

      }

      /**
       * Url::Portfolio()
       * 
       * @return
       */
      public static function Portfolio($type, $slug = false, $pars = false)
      {
          $segment = self::$data['module'];
          switch ($type) {
              case 'portfolio':
                  $url = SITEURL . '/' . $segment['portfolio'] . '/' . $pars;
                  break;

              case 'portfolio-cat':
				  $url = SITEURL . '/' . $segment['portfolio'] . '/' . $segment['portfolio-cat'] . '/' . $slug . '/' . $pars;
                  break;

              default:
				  $url = SITEURL . '/' . $segment['portfolio'] . '/' . $slug . '/' . $pars;
                  break;

          }
		  
		  return $url;

      } 

  }