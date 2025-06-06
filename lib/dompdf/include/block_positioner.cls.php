<?php
/**
 * @yazilim dompdf
 * @link    http://www.dompdf.com/
 * @web adresi
@web adresi
@web adresi  Benj Carson <benjcarson@digitaljunkies.ca>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: block_positioner.cls.php 448 2011-11-13 13:00:03Z fabien.menager $
 */

/**
 * Positions block frames
 *
 * @access private
 * @yazilim dompdf
 */
class Block_Positioner extends Positioner {


  function __construct(Frame_Decorator $frame) { parent::__construct($frame); }
  
  //........................................................................

  function position() {
    $frame = $this->_frame;
    $style = $frame->get_style();
    $cb = $frame->get_containing_block();
    $p = $frame->find_block_parent();
    
    if ( $p ) {
      $float = $style->float;
      if ( !DOMPDF_ENABLE_CSS_FLOAT || !$float || $float === "none" ) {
        $p->add_line(true);
      }
      $y = $p->get_current_line_box()->y;
      
    } else
      $y = $cb["y"];

    $x = $cb["x"];

    // Relative positionning
    if ( $style->position === "relative" ) {
      $top =    $style->length_in_pt($style->top,    $cb["h"]);
      //$right =  $style->length_in_pt($style->right,  $cb["w"]);
      //$bottom = $style->length_in_pt($style->bottom, $cb["h"]);
      $left =   $style->length_in_pt($style->left,   $cb["w"]);
      
      $x += $left;
      $y += $top;
    }
    
    $frame->set_position($x, $y);
  }
}
