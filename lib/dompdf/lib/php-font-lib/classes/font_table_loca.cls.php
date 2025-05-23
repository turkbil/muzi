<?php
/**
 * @yazilim php-font-lib
 * @link    http://php-font-lib.googlecode.com/
 * @web adresi
@web adresi
@web adresi  Fabien M�nager <fabien.menager@gmail.com>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: font_table_loca.cls.php 43 2012-02-05 22:26:53Z fabien.menager $
 */

/**
 * `loca` font table.
 * 
 * @yazilim php-font-lib
 */
class Font_Table_loca extends Font_Table {
  protected function _parse(){
    $font = $this->getFont();
    $offset = $font->pos();
    
    $indexToLocFormat = $font->getData("head", "indexToLocFormat");
    $numGlyphs = $font->getData("maxp", "numGlyphs");
    
    $font->seek($offset);
    
    $data = array();
    
    // 2 bytes
    if ($indexToLocFormat == 0) {
      $d = $font->read(($numGlyphs + 1) * 2);
      $loc = unpack("n*", $d);
      
      for ($i = 0; $i <= $numGlyphs; $i++) {
        $data[] = $loc[$i+1] * 2;
      }
    }
    
    // 4 bytes
    else if ($indexToLocFormat == 1) {
      $d = $font->read(($numGlyphs + 1) * 4);
      $loc = unpack("N*", $d);
      
      for ($i = 0; $i <= $numGlyphs; $i++) {
        $data[] = $loc[$i+1];
      }
    }
    
    $this->data = $data;
  }
  
  function _encode(){
    $font = $this->getFont();
    $data = $this->data;
    
    $indexToLocFormat = $font->getData("head", "indexToLocFormat");
    $numGlyphs = $font->getData("maxp", "numGlyphs");
    $length = 0;
    
    // 2 bytes
    if ($indexToLocFormat == 0) {
      for ($i = 0; $i <= $numGlyphs; $i++) {
        $length += $font->writeUInt16($data[$i] / 2);
      }
    }
    
    // 4 bytes
    else if ($indexToLocFormat == 1) {
      for ($i = 0; $i <= $numGlyphs; $i++) {
        $length += $font->writeUInt32($data[$i]);
      }
    }
    
    return $length;
  }
}