<?php

  /**
   * Resize Class
   *
   * @yazilim CMS pro
   * @web adresi turkbilisim.com.tr
   * @copyright 2014
   * @version $Id: class_resize.php,v 4.00 2014-01-10 21:12:05 Nurullah Okatan
   */

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');


  class Resize
  {

      public static $file = null; //file name to resize
      public static $width = 80; //new image width
      public static $height = 80; //new image height
      const proportional = false; //keep image proportional, default is no
      public static $output = "file"; //name of the new file (include path if needed)
      public static $delete_original = false; //if true the original image will be deleted
      const use_linux_commands = false; //if set to true will use "rm" to delete the image, if false will use PHP unlink
      public static $quality = 100; // enter 1-100 (100 is best quality) default is 100
	  
	  private static $instance;


      /**
       * Resize::__construct()
       * 
       * @return
       */
      private function __construct(){}
	  

      /**
       * Resize::instance()
       * 
       * @return
       */
	  public static function instance(){
		  if (!self::$instance){ 
			  self::$instance = new Resize(); 
		  } 
	  
		  return self::$instance;  
	  }

      /**
       * Resize::doResize()
       * 
       * @return
       */
      public static function doResize()
      {

          if (self::$height <= 0 && self::$width <= 0)
              return false;

          // Setting defaults and meta
          $info = getimagesize(self::$file);
          $image = '';
          $final_width = 0;
          $final_height = 0;
          list($width_old, $height_old) = $info;

          // Calculating proportionality
          if (self::proportional) {
              if (self::$width == 0)
                  $factor = self::$height / $height_old;
              elseif (self::$height == 0)
                  $factor = self::$width / $width_old;
              else
                  $factor = min(self::$width / $width_old, self::$height / $height_old);

              $final_width = round($width_old * $factor);
              $final_height = round($height_old * $factor);
          } else {
              $final_width = (self::$width <= 0) ? $width_old : self::$width;
              $final_height = (self::$height <= 0) ? $height_old : self::$height;
          }

          // Loading image to memory according to type
          switch ($info[2]) {
              case IMAGETYPE_GIF:
                  $image = imagecreatefromgif(self::$file);
                  break;
              case IMAGETYPE_JPEG:
                  $image = imagecreatefromjpeg(self::$file);
                  break;
              case IMAGETYPE_PNG:
                  $image = imagecreatefrompng(self::$file);
                  break;
              default:
                  return false;
          }


          // This is the resizing/resampling/transparency-preserving magic
          $image_resized = imagecreatetruecolor($final_width, $final_height);
          if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
              $transparency = imagecolortransparent($image);

              if ($transparency >= 0) {
                  $transparent_color = imagecolorsforindex($image, $trnprt_indx);
                  $transparency = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
                  imagefill($image_resized, 0, 0, $transparency);
                  imagecolortransparent($image_resized, $transparency);
              } elseif ($info[2] == IMAGETYPE_PNG) {
                  imagealphablending($image_resized, false);
                  $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
                  imagefill($image_resized, 0, 0, $color);
                  imagesavealpha($image_resized, true);
              }
          }
          imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);

          // Taking care of original, if needed
          if (self::$delete_original) {
              if (self::use_linux_commands)
                  exec('rm ' . self::$file);
              else
                  @unlink(self::$file);
          }

          // Preparing a method of providing result
          switch (strtolower(self::$output)) {
              case 'browser':
                  $mime = image_type_to_mime_type($info[2]);
                  header("Content-type: $mime");
                  self::$output = null;
                  break;
              case 'file':
                  self::$output = self::$file;
                  break;
              case 'return':
                  return $image_resized;
                  break;
              default:
                  break;
          }

          // Writing image according to type to the output destination and image quality
          switch ($info[2]) {
              case IMAGETYPE_GIF:
                  imagegif($image_resized, self::$output);
                  break;
              case IMAGETYPE_JPEG:
                  imagejpeg($image_resized, self::$output, self::$quality);
                  break;
              case IMAGETYPE_PNG:
                  self::$quality = 9 - (int)((0.9 * self::$quality) / 10.0);
                  imagepng($image_resized, self::$output, self::$quality);
                  break;
              default:
                  return false;
          }

          return true;
      }
  }

?>