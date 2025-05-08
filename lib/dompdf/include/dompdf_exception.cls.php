<?php
/**
 * @yazilim dompdf
 * @link    http://www.dompdf.com/
 * @web adresi
@web adresi
@web adresi  Benj Carson <benjcarson@digitaljunkies.ca>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: dompdf_exception.cls.php 448 2011-11-13 13:00:03Z fabien.menager $
 */

/**
 * Standard exception thrown by DOMPDF classes
 *
 * @yazilim dompdf
 */
class DOMPDF_Exception extends Exception {

  /**
   * Class constructor
   *
   * @param string $message Error message
   * @param int $code Error code
   */
  function __construct($message = null, $code = 0) {
    parent::__construct($message, $code);
  }

}
