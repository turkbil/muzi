<?php
  /**
   * Minify Class
   *
   * @yazilim Tubi Portal
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: class_minify.php, v1.00 2012-03-05 10:12:05 Nurullah Okatan
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');


  class Minify
  {

      const prefix = 'master_';
	  const suffix = '.css';


      /**
       * Minify::__callStatic()
       * 
       * @param mixed $type
       * @param mixed $source
       * @return
       */
      public static function cache($source, $type)
      {

          $target = THEME . '/cache/';
          $last_change = self::last_change($source);

		  if (Registry::get("Core")->lang_dir == "rtl") {
			  $temp = $target . self::prefix . 'rtl_main' . self::suffix;
		  } else {
			  $temp = $target . self::prefix . 'main' . self::suffix;
		  }
		  
          if (!file_exists($temp) || $last_change > filemtime($temp)) {
              if (!self::write_cache($source, $temp, $type)) {
                  Filter::msgError("Minify:: - Writing the file to <{$target}> failed!");
              }
          }
		  
          return basename($temp);
      }



      /**
       * Minify::last_change()
       * 
       * @param mixed $files
       * @return
       */
    protected static function last_change($files)
    {
        $result = array();
        foreach ($files as $key => $file) {
            $file_path = THEME . '/' . $file;
            // Dosya varsa son değiştirilme zamanını al, yoksa atla
            if (file_exists($file_path)) {
                $result[] = filemtime($file_path);
            }
        }
        
        // Eğer hiç dosya bulunamadıysa şimdiki zamanı döndür
        if (empty($result)) {
            return time();
        }
        
        sort($result);
        $result = array_reverse($result);
        
        return $result[key($result)];
    }


    /**
     * Minify::write_cache()
     * 
     * @param mixed $files
     * @param mixed $target
     * @param mixed $type
     * @return
     */
    protected static function write_cache($files, $target, $type)
    {
        $content = "";

        foreach ($files as $file) {
            $file_path = THEME . '/' . $file;
            
            // Dosya var mı kontrol et
            if (file_exists($file_path)) {
                $content .= file_get_contents($file_path);
            } else {
                // Dosya yoksa uyarı logu yazılabilir ama isteğe bağlı
                // error_log("CSS dosyası bulunamadı: " . $file_path);
                continue; // Mevcut olmayan dosyaları atla
            }
        }

        // CSS içeriğini minify et
        $content = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $content);
        $content = str_replace(array(
            "\r\n",
            "\r",
            "\n",
            "\t",
            '  ',
            '    ',
            '    '), '', $content);
        $content = str_replace(array(
            ': ',
            ' {',
            ';}'), array(
            ':',
            '{',
            '}'), $content);
            
        // Cache dizini var mı kontrol et
        if (!file_exists(THEME . '/cache/'))
            mkdir(THEME . '/cache/', 0755);
            
        // Eğer içerik boşsa, en azından boş bir dosya oluştur
        if (empty($content)) {
            $content = "/* No CSS content found */";
        }
        
        return file_put_contents($target, $content);
    }
  }
?>