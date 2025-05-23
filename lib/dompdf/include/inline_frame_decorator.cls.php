<?php
/**
 * @yazilim dompdf
 * @link    http://www.dompdf.com/
 * @web adresi
@web adresi
@web adresi  Benj Carson <benjcarson@digitaljunkies.ca>
 * @web adresi
@web adresi
@web adresi  Helmut Tischer <htischer@weihenstephan.org>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: inline_frame_decorator.cls.php 448 2011-11-13 13:00:03Z fabien.menager $
 */

/**
 * Decorates frames for inline layout
 *
 * @access private
 * @yazilim dompdf
 */
class Inline_Frame_Decorator extends Frame_Decorator {
  
  function __construct(Frame $frame, DOMPDF $dompdf) { parent::__construct($frame, $dompdf); }

  function split($frame = null, $force_pagebreak = false) {

    if ( is_null($frame) ) {
      $this->get_parent()->split($this, $force_pagebreak);
      return;
    }

    if ( $frame->get_parent() !== $this )
      throw new DOMPDF_Exception("Unable to split: frame is not a child of this one.");
        
    $split = $this->copy( $this->_frame->get_node()->cloneNode() ); 
    $this->get_parent()->insert_child_after($split, $this);

    // Unset the current node's right style properties
    $style = $this->_frame->get_style();
    $style->margin_right = 0;
    $style->padding_right = 0;
    $style->border_right_width = 0;

    // Unset the split node's left style properties since we don't want them
    // to propagate
    $style = $split->get_style();
    $style->margin_left = 0;
    $style->padding_left = 0;
    $style->border_left_width = 0;

    //On continuation of inline element on next line,
    //don't repeat non-vertically repeatble background images
    //See e.g. in testcase image_variants, long desriptions
    if ( ($url = $style->background_image) && $url !== "none"
         && ($repeat = $style->background_repeat) && $repeat !== "repeat" &&  $repeat !== "repeat-y"
       ) {
      $style->background_image = "none";
    }           

    // Add $frame and all following siblings to the new split node
    $iter = $frame;
    while ($iter) {
      $frame = $iter;      
      $iter = $iter->get_next_sibling();
      $frame->reset();
      $split->append_child($frame);
    }
    
    $page_breaks = array("always", "left", "right");
    $frame_style = $frame->get_style();
    if( $force_pagebreak ||
      in_array($frame_style->page_break_before, $page_breaks) ||
      in_array($frame_style->page_break_after, $page_breaks) ) {

      $this->get_parent()->split($split, true);
    }
  }
  
} 
