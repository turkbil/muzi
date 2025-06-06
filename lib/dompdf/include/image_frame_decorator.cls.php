<?php
/**
 * @yazilim dompdf
 * @link    http://www.dompdf.com/
 * @web adresi
@web adresi
@web adresi  Benj Carson <benjcarson@digitaljunkies.ca>
 * @web adresi
@web adresi
@web adresi  Fabien M�nager <fabien.menager@gmail.com>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: image_frame_decorator.cls.php 448 2011-11-13 13:00:03Z fabien.menager $
 */

/**
 * Decorates frames for image layout and rendering
 *
 * @access private
 * @yazilim dompdf
 */
class Image_Frame_Decorator extends Frame_Decorator {

  /**
   * The path to the image file (note that remote images are
   * downloaded locally to DOMPDF_TEMP_DIR).
   *
   * @var string
   */
  protected $_image_url;
  
  /**
   * The image's file error message
   *
   * @var string
   */
  protected $_image_msg;

  /**
   * Class constructor
   *
   * @param Frame $frame the frame to decorate
   * @param DOMPDF $dompdf the document's dompdf object (required to resolve relative & remote urls)
   */
  function __construct(Frame $frame, DOMPDF $dompdf) {
    global $_dompdf_warnings;
    
    parent::__construct($frame, $dompdf);
    $url = $frame->get_node()->getAttribute("src");
      
    //debugpng
    if (DEBUGPNG) print '[__construct '.$url.']';

    list($this->_image_url, $type, $this->_image_msg) = Image_Cache::resolve_url($url,
                                                                          $dompdf->get_protocol(),
                                                                          $dompdf->get_host(),
                                                                          $dompdf->get_base_path());

    if ( Image_Cache::is_broken($this->_image_url) &&
         $alt = $frame->get_node()->getAttribute("alt") ) {
      $style = $frame->get_style();
      $style->width  = (4/3)*Font_Metrics::get_text_width($alt, $style->font_family, $style->font_size, $style->word_spacing);
      $style->height = Font_Metrics::get_font_height($style->font_family, $style->font_size);
    }
  }

  /**
   * Return the image's url
   *
   * @return string The url of this image
   */
  function get_image_url() {
    return $this->_image_url;
  }

  /**
   * Return the image's error message
   *
   * @return string The image's error message
   */
  function get_image_msg() {
    return $this->_image_msg;
  }
  
}
