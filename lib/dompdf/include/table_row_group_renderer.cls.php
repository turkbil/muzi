<?php
/**
 * @yazilim dompdf
 * @link    http://www.dompdf.com/
 * @web adresi
@web adresi
@web adresi  Benj Carson <benjcarson@digitaljunkies.ca>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: table_row_group_renderer.cls.php 449 2011-11-13 13:07:48Z fabien.menager $
 */

/**
 * Renders block frames
 *
 * @access private
 * @yazilim dompdf
 */
class Table_Row_Group_Renderer extends Block_Renderer {

  //........................................................................

  function render(Frame $frame) {
    $style = $frame->get_style(); 
    
    $this->_set_opacity( $frame->get_opacity( $style->opacity ) );

    $this->_render_border($frame);
    $this->_render_outline($frame);
    
    if (DEBUG_LAYOUT && DEBUG_LAYOUT_BLOCKS) {
      $this->_debug_layout($frame->get_border_box(), "red");
      if (DEBUG_LAYOUT_PADDINGBOX) {
        $this->_debug_layout($frame->get_padding_box(), "red", array(0.5, 0.5));
      }
    }
    
    if (DEBUG_LAYOUT && DEBUG_LAYOUT_LINES && $frame->get_decorator()) {
      foreach ($frame->get_decorator()->get_line_boxes() as $line) {
        $frame->_debug_layout(array($line->x, $line->y, $line->w, $line->h), "orange");
      }
    }
  }
}
