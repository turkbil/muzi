<?php
/**
 * @yazilim dompdf
 * @link    http://www.dompdf.com/
 * @web adresi
@web adresi
@web adresi  Benj Carson <benjcarson@digitaljunkies.ca>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: table_row_frame_reflower.cls.php 448 2011-11-13 13:00:03Z fabien.menager $
 */

/**
 * Reflows table rows
 *
 * @access private
 * @yazilim dompdf
 */
class Table_Row_Frame_Reflower extends Frame_Reflower {


  function __construct(Table_Row_Frame_Decorator $frame) {
    parent::__construct($frame);
  }

  //........................................................................

  function reflow(Frame_Decorator $block = null) {
    $page = $this->_frame->get_root();

    if ( $page->is_full() )
      return;

    $this->_frame->position();
    $style = $this->_frame->get_style();
    $cb = $this->_frame->get_containing_block();

    foreach ($this->_frame->get_children() as $child) {

      if ( $page->is_full() )
        return;

      $child->set_containing_block($cb);
      $child->reflow();

    }

    if ( $page->is_full() )
      return;

    $table = Table_Frame_Decorator::find_parent_table($this->_frame);
    $cellmap = $table->get_cellmap();
    $style->width = $cellmap->get_frame_width($this->_frame);
    $style->height = $cellmap->get_frame_height($this->_frame);

    $this->_frame->set_position($cellmap->get_frame_position($this->_frame));

  }

  //........................................................................

  function get_min_max_width() {
    throw new DOMPDF_Exception("Min/max width is undefined for table rows");
  }
}
