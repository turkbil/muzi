<?php
/**
 * @yazilim dompdf
 * @link    http://www.dompdf.com/
 * @web adresi
@web adresi
@web adresi  Benj Carson <benjcarson@digitaljunkies.ca>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: null_frame_reflower.cls.php 448 2011-11-13 13:00:03Z fabien.menager $
 */

/**
 * Dummy reflower
 *
 * @access private
 * @yazilim dompdf
 */
class Null_Frame_Reflower extends Frame_Reflower {

  function __construct(Frame $frame) { parent::__construct($frame); }

  function reflow(Frame_Decorator $block = null) { return; }
  
}
