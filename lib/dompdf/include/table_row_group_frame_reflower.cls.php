<?php
/**
 * @yazilim dompdf
 * @link    http://www.dompdf.com/
 * @web adresi
@web adresi
@web adresi  Benj Carson <benjcarson@digitaljunkies.ca>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: table_row_group_frame_reflower.cls.php 448 2011-11-13 13:00:03Z fabien.menager $
 */

/**
 * Reflows table row groups (e.g. tbody tags)
 *
 * @access private
 * @yazilim dompdf
 */
class Table_Row_Group_Frame_Reflower extends Frame_Reflower {

  function __construct($frame) {
    parent::__construct($frame);
  }

  function reflow(Frame_Decorator $block = null) {
    $page = $this->_frame->get_root();

    $style = $this->_frame->get_style();
    
    // Our width is equal to the width of our parent table
    $table = Table_Frame_Decorator::find_parent_table($this->_frame);
    
    $cb = $this->_frame->get_containing_block();
    
    foreach ( $this->_frame->get_children() as $child) {
      // Bail if the page is full
      if ( $page->is_full() )
        return;

      $child->set_containing_block($cb["x"], $cb["y"], $cb["w"], $cb["h"]);
      $child->reflow();

      // Check if a split has occured
      $page->check_page_break($child);

    }

    if ( $page->is_full() )
      return;

    $cellmap = $table->get_cellmap();
    $style->width = $cellmap->get_frame_width($this->_frame);
    $style->height = $cellmap->get_frame_height($this->_frame);

    $this->_frame->set_position($cellmap->get_frame_position($this->_frame));
    
    if ( $table->get_style()->border_collapse === "collapse" ) 
      // Unset our borders because our cells are now using them
      $style->border_style = "none";
 
  }

}
